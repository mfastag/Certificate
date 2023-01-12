<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tblSiteWide;
use App\Models\vwObjectFacilityFieldsUsage;
use Illuminate\Support\Facades\Auth;
use DB;




class FacilityController extends Controller
{

    public function index()
    {
        return view('facilityusage');
    }

    public function totalUsage(Request $r) {
        $where = $this->BuildWhere($r);

        //$data = DB::select("select top 5000 * from vwObjectChemFieldsUsage where {$where} order by [StartDateTime]");
        $data = vwObjectFacilityFieldsUsage::selectRaw("top 5000 *")
            ->whereRaw($where)
            //->groupByRaw('[exception_type]')
            ->orderByRaw("[StartDateTime]")
            ->get();   
        return $data;
    }

    public function totalUsageChart(Request $r) {
        $where = $this->BuildWhere($r);

        $query = "select cast([StartDateTime] as date) as [StartDateTime] ,FieldName,sum(cost) as cost 
                  from vwObjectFacilityFieldsUsage where {$where} group by cast([StartDateTime] as date),FieldName order by [StartDateTime]";

        //$data['data'] = DB::select($query);
        $data['data'] = vwObjectFacilityFieldsUsage::selectRaw("cast([StartDateTime] as date) as [StartDateTime] ,FieldName,sum(cost) as cost")
        ->whereRaw($where)
        ->groupByRaw('cast([StartDateTime] as date),FieldName')
        ->orderByRaw("[StartDateTime]")
        ->get();

        return $data;
    }

    
    function BuildWhere(Request $r) {
        $where = " 1=1 and cost>0 ";
        
        if($r['dateFrom'] && $r['dateTo']) {
            $d1 = date('Ymd',strtotime($r->dateFrom));
            $d2 = date('Ymd',strtotime($r->dateTo));
            $where .= " and [StartDateTime] between '{$d1}' and '{$d2}' ";
        } else {
            $d1 = date('Ymd',time()-7*84600);
            $d2 = date('Ymd',time()+84600);
            $where .= " and [StartDateTime] between '{$d1}' and '{$d2}' ";
        }

        if($r['line'] ) {
            if(strlen($r->line)>1) $where .= " and [CIP Line]='{$r->line}' ";
        }

        if($r['system'] ) {
            if(strlen($r->system)>1) $where .= " and [CIP System]='{$r->system}' ";
        }

        if($r['object']) {
            if(strlen($r->object)>1) $where .= " and [Object]='{$r->object}' ";
        }

        if($r['exception']) {
            if(strlen($r->exception)>1) $where .= " and [Exceptions Triggered]='{$r->exception}' ";
        }

        if($r['measure']) {
            if(strlen($r->measure)>1) $where .= " and [FieldName]='{$r->measure}' ";
        }
        
        if($r['plant']) {
            if(strlen($r->plant)>1) $where .= " and [Plant]='{$r->plant}' ";
        }
        
        //$where .= " and [Exceptions Triggered]='TRUE' ";

        
        return $where;
    }

    public function getDashExceptionPieChart(Request $r) {
        return;
        //$recs = DB::select("select [exception_type],count(1) as [count], sum(try_cast([Total Chemical Cost] as float)) as chemCost from [tblSiteWideData] where [Exceptions Triggered]='TRUE' group by [exception_type]");
        
        $recs = tblSiteWideData::selectRaw("[exception_type],count(1) as [count], sum(try_cast([Total Chemical Cost] as float)) as chemCost")
            ->whereRaw("[Exceptions Triggered]='TRUE'")
            ->groupByRaw('[exception_type]')
            //->orderByRaw("[StartDateTime]")
            ->get();  

        $chemCost=0;
        foreach($recs as $r) {
            $data['labels'][] = $r->exception_type;
            $data['values'][] = $r->count;
            $data['costValues'][] = $r->chemCost;
            $chemCost += $r->chemCost;
        }

        $data['chemCost'] = $chemCost; 

        return $data;
    }


    public function getDashChemicalTrendChart(Request $r) {
        $w = $this->buildWhereClause($r);

        //$recs = DB::select("select year([Start Date/Time]) as year,month([Start Date/Time]) as month,day([Start Date/Time]) as day, sum(try_cast([Total Chemical Cost] as float)) as total, count(1) as [count]     from tblSiteWideData where [Start Date/Time]>='20220601' group by year([Start Date/Time]),month([Start Date/Time]),day([Start Date/Time]) order by 1,2,3");
        $recs = tblSiteWideData::selectRaw("year([Start Date/Time]) as year,month([Start Date/Time]) as month,day([Start Date/Time]) as day, sum(try_cast([Total Chemical Cost] as float)) as total, count(1) as [count] ")
            ->whereRaw("[Start Date/Time]>='20220601'")
            ->groupByRaw('year([Start Date/Time]),month([Start Date/Time]),day([Start Date/Time])')
            ->orderByRaw("1,2,3")
            ->get();  

        $data['x'] = [];
        $data['y'] = [];
        $min=9999999999;
        $max=0;
        $count=0;
        $total=0;
        foreach($recs as $r) {
            $count++;
            $data['x'][] = "{$r->year}-{$r->month}-{$r->day}";
            $data['y'][] = $r->total;
            $data['count'][] = $r->count;
            $total += $r->total;


            $d=strtotime("{$r->year}-{$r->month}-{$r->day}");
            if($d<$min) {
                $min=$d;
            }
            if($d>$max) {
                $max=$d;
            }
        }
        
        if(!$count) {
            $min=time()-30*24*60*60;
            $max=time();
        }
        
        $data['min'] = date('Y-m-d',$min);
        $data['max'] = date('Y-m-d',$max);
        $data['total'] = $total;
    

        return $data;
    }

    

    public function getDashTotalsTrendChart(Request $r) {
        $w = $this->buildWhereClause($r);

        //$recs = DB::select("select  year([Start Date/Time]) as year,month([Start Date/Time]) as month,day([Start Date/Time]) as day,sum([DurationMins]) as duration, sum([Electrical Cost]) as [ElectricalCost],sum([Time Cost]) as [TimeCost],sum([Total Material Cost]) as [TotalMaterialCost],sum([Total Water Cost]) as [TotalWaterCost],sum([Total Chemical Cost]) as [TotalChemicalCost] from tblSiteWideData where [Start Date/Time]>='20220601' group by year([Start Date/Time]),month([Start Date/Time]),day([Start Date/Time]) order by 1 ,2 ,3");
        $recs = tblSiteWideData::selectRaw("year([Start Date/Time]) as year,month([Start Date/Time]) as month,day([Start Date/Time]) as day,sum([DurationMins]) as duration, sum([Electrical Cost]) as [ElectricalCost],sum([Time Cost]) as [TimeCost],sum([Total Material Cost]) as [TotalMaterialCost],sum([Total Water Cost]) as [TotalWaterCost],sum([Total Chemical Cost]) as [TotalChemicalCost]")
            ->whereRaw("[Start Date/Time]>='20220601'")
            ->groupByRaw('year([Start Date/Time]),month([Start Date/Time]),day([Start Date/Time])')
            ->orderByRaw("1,2,3")
            ->get();  

        $data['x'] = [];
        $min=9999999999;
        $max=0;
        $count=0;
        $totCost=0;
        $duration=0;
        foreach($recs as $r) {
            $count++;
            $data['x'][] = "{$r->year}-{$r->month}-{$r->day}";
            $data['elec'][] = $r->ElectricalCost;
            $data['time'][] = $r->TimeCost;
            $data['material'][] = $r->TotalMaterialCost;
            $data['water'][] = $r->TotalWaterCost;
            $data['chem'][] = $r->TotalChemicalCost;
            
            $totCost+= $r->TotalChemicalCost+$r->ElectricalCost+$r->TimeCost+$r->TotalMaterialCost+$r->TotalWaterCost;

            $duration+= $r->duration;

            $d=strtotime("{$r->year}-{$r->month}-{$r->day}");
            if($d<$min) {
                $min=$d;
            }
            if($d>$max) {
                $max=$d;
            }
        }
        if(!$count) {
            $min=time()-30*24*60*60;
            $max=time();
        }

        $data['min'] = date('Y-m-d',$min);
        $data['max'] = date('Y-m-d',$max);
        $data['totCost'] = $totCost;
        $data['duration'] = $duration;



        return $data;
    }



    function buildWhereClause(Request $r) {
        $where = " 1=1 ";
        if($r->has('dateFrom') && $r->has('dateTo')) {
            $d1 = date('Ymd',strtotime($r->dateFrom));
            $d2 = date('Ymd',strtotime($r->dateTo));
            $where .= " and [Start Date/Time] between '{$d1}' and '{$d2}' ";
        } else {
            $d1 = date('Ymd',time()-7*84600);
            $d2 = date('Ymd',time()+84600);
            $where .= " and [Start Date/Time] between '{$d1}' and '{$d2}' ";
        }

        if($r->has('line') ) {
            if(strlen($r->line)>1) $where .= " and [CIP Line]='{$r->line}' ";
        }

        if($r->has('system') ) {
            if(strlen($r->system)>1) $where .= " and [CIP System]='{$r->system}' ";
        }

        if($r->has('object')) {
            if(strlen($r->object)>1) $where .= " and [Object]='{$r->object}' ";
        }

        if($r->has('exception')) {
            if(strlen($r->exception)>1) $where .= " and [Exceptions Triggered]='{$r->exception}' ";
        }
        
        //$where .= " and [Exceptions Triggered]='TRUE' ";

        
        return $where;

    }


    public function xchart1_data(Request $r)
    {
        //$recs = tblSiteWide::select('Start Date/Time','Exceptions Triggered')->where('Exceptions Triggered','TRUE')->limit(1000)->get();
        
        $w = $this->buildWhereClause($r);

        //$recs = DB::select("select year([Start Date/Time]) as year,month([Start Date/Time]) as month,day([Start Date/Time]) as day, count(1) as count from tblSiteWideData where {$w}  group by year([Start Date/Time]),month([Start Date/Time]),day([Start Date/Time]) order by 1,2,3");
        $recs = tblSiteWideData::selectRaw("year([Start Date/Time]) as year,month([Start Date/Time]) as month,day([Start Date/Time]) as day, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw('year([Start Date/Time]),month([Start Date/Time]),day([Start Date/Time])')
            ->orderByRaw("1,2,3")
            ->get();  
        
        $data['x'] = [];
        $data['y'] = [];
        $min=9999999999;
        $max=0;
        $count=0;
        foreach($recs as $r) {
            $count++;
            $data['x'][] = "{$r->year}-{$r->month}-{$r->day}";
            $data['y'][] = $r->count;

            $d=strtotime("{$r->year}-{$r->month}-{$r->day}");
            if($d<$min) {
                $min=$d;
            }
            if($d>$max) {
                $max=$d;
            }
        }
        
        if(!$count) {
            $min=time()-30*24*60*60;
            $max=time();
        }
        
        $data['min'] = date('Y-m-d',$min);
        $data['max'] = date('Y-m-d',$max);
    
        

        return $data;
    }

    public function xchart2_data(Request $r)
    {
        $w = $this->buildWhereClause($r);

        //$recs = DB::select("select [CIP System] as cipsystem, count(1) as count from tblSiteWideData where {$w} group by [CIP System] order by 1");
        $recs = tblSiteWideData::selectRaw("[CIP System] as cipsystem, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw("[CIP System]")
            ->orderByRaw("1")
            ->get();  

        $data['x'] = [];
        $data['y'] = [];
        $distinct=[];
        foreach($recs as $r) {
            $data['x'][] = $r->cipsystem;
            $data['y'][] = $r->count;
            $distinct[$r->cipsystem] = 1;
        }
        
        $data['distinct']=  array_keys($distinct);

        return $data;
    }


    public function xchart3_data(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        //$recs = DB::select("select [CIP Line] as cipline, count(1) as count from tblSiteWideData where {$w} group by [CIP Line] order by 1");
        $recs = tblSiteWideData::selectRaw("[CIP Line] as cipline, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw("[CIP Line]")
            ->orderByRaw("1")
            ->get();  

        
        $data['x'] = [];
        $data['y'] = [];
        $distinct=[];
        foreach($recs as $r) {
            $data['x'][] = $r->cipline;
            $data['y'][] = $r->count;
            $distinct[$r->cipline] = 1;
        }
        
        $data['distinct']=  array_keys($distinct);

        return $data;
    }


    public function xchart4_data(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        //$recs = DB::select("select [Object] as object, count(1) as count from tblSiteWideData where {$w} group by [Object] order by 1");
        $recs = tblSiteWideData::selectRaw("[Object] as object, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw("[Object]")
            ->orderByRaw("1")
            ->get();  

        $data['x'] = [];
        $data['y'] = [];
        $distinct=[];
        foreach($recs as $r) {
            $data['x'][] = $r->object;
            $data['y'][] = $r->count;
            $distinct[$r->object] = 1;
        }
        
        $data['distinct']=  array_keys($distinct);

        return $data;
    }




    public function xtabletoPlotly($recs) {
        $data = [];
        $data['x'] = [];
        $data['y'] = [];
        $data['type'] = 'scatter';
        foreach ($recs as $rec) {
            $data['x'][] = $rec->StartDateTime;
            $data['y'][] = $rec->DurationHours;
        }
        return $data;
    }
    


    public function xgetData1()
    {
        
        $recs = tblSiteWide::limit(100)->select('Start Date/Time','DurationHours','Exceptions Triggered')->get();

        echo $this->tableToGoogle($recs);
        

   
     return json_encode($table);
        //$recs = tblSiteWide::limit(10)->get();
        foreach($recs as $r) {
            $data[] = [$r->id, $r->data1];

        }

        $cols = ['a'=>'xxx' ];
        
    }


  


}
