<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tblSiteWide;
use DB;




class ChartController extends Controller
{
    public function doDash()
    {
        return view('dash');
    }

    public function doActive()
    {
        return view('active');
    }

    public function index()
    {
        return view('index');
    }


    public function getDashExceptionPieChart(Request $r) {
        //$recs = DB::select("select [exception_type],count(1) as [count], sum(try_cast([Total Chemical Cost] as float)) as chemCost from [vwSiteWideData] where [Exceptions Triggered]='TRUE' group by [exception_type]");
        $recs = tblSiteWide::selectRaw("[exception_type],count(1) as [count], sum(try_cast([Total Chemical Cost] as float)) as chemCost")
            ->whereRaw("[Exceptions Triggered]='TRUE'")
            ->groupByRaw('[exception_type]')
            //->orderByRaw("1")
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

        //$recs = DB::select("select year([StartDateTimeFormatted]) as year,month([StartDateTimeFormatted]) as month,day([StartDateTimeFormatted]) as day, sum(try_cast([Total Chemical Cost] as float)) as total, count(1) as [count]     from vwSiteWideData where [StartDateTimeFormatted]>=getdate()-30 group by year([StartDateTimeFormatted]),month([StartDateTimeFormatted]),day([StartDateTimeFormatted]) order by 1,2,3");
        $recs = tblSiteWide::selectRaw("year([StartDateTimeFormatted]) as year,month([StartDateTimeFormatted]) as month,day([StartDateTimeFormatted]) as day, sum(try_cast([Total Chemical Cost] as float)) as total, count(1) as [count]")
            ->whereRaw("[StartDateTimeFormatted]>=getdate()-30")
            ->groupByRaw('year([StartDateTimeFormatted]),month([StartDateTimeFormatted]),day([StartDateTimeFormatted])')
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

    public function getHistoryTable(Request $r) {
        $w = $this->buildWhereClause($r);
        
        $recs = tblSiteWide::selectRaw("FORMAT(StartDateTimeFormatted, 'yyyy-MM-dd hh:mm:ss tt') as washtime,*")
            ->whereRaw($w)
            ->orderByRaw("StartDateTimeFormatted desc")
            ->limit(30)
            ->get();

        foreach($recs as $r) {
            $r->facility_cost = $r['Total Material Cost'];
                +$r['Total Water Cost']
                +$r['Thermal Cost']
                +$r['Electrical Cost']
                +$r['Time Cost'];

            $r->total_cost = $r->facility_cost + $r['Total Chemical Cost'];
        }
//dd($recs);
        return($recs);   


    }

    public function getDashTotalsTrendChart(Request $r) {
        $w = $this->buildWhereClause($r);

        $recs = tblSiteWide::selectRaw("year([StartDateTimeFormatted]) as year,month([StartDateTimeFormatted]) as month,day([StartDateTimeFormatted]) as day,sum([DurationMins]) as duration, sum([Electrical Cost]) as [ElectricalCost],sum([Time Cost]) as [TimeCost],sum([Total Material Cost]) as [TotalMaterialCost],sum([Total Water Cost]) as [TotalWaterCost],sum([Total Chemical Cost]) as [TotalChemicalCost],sum([Thermal Cost]) as [TotalThermalCost]")
            ->whereRaw('[StartDateTimeFormatted]>=getdate()-30')
            ->groupByRaw('year([StartDateTimeFormatted]),month([StartDateTimeFormatted]),day([StartDateTimeFormatted])')
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
            $data['therm'][] = $r->TotalThermalCost;
            
            $totCost+= $r->TotalChemicalCost+$r->ElectricalCost+$r->TimeCost+$r->TotalMaterialCost+$r->TotalWaterCost+$r->TotalThermalCost;

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






    public function plotly()
    {
        return view('plotly');
    }

    function buildWhereClause(Request $r) {
        $where = " 1=1 ";
        if($r->has('dateFrom') && $r->has('dateTo')) {
            $d1 = date('Ymd',strtotime($r->dateFrom));
            $d2 = date('Ymd',strtotime($r->dateTo));
            $where .= " and [StartDateTimeFormatted] between '{$d1}' and '{$d2}' ";
        } else {
            $d1 = date('Ymd',time()-7*84600);
            $d2 = date('Ymd',time()+84600);
            $where .= " and [StartDateTimeFormatted] between '{$d1}' and '{$d2}' ";
        }

        if($r->has('line') ) {
            if(strlen($r->line)>1) $where .= " and [CIP Line]='{$r->line}' ";
        }

        if($r->has('plant') ) {
            if(strlen($r->plant)>1) $where .= " and [Plant]='{$r->plant}' ";
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


    public function chart1_data(Request $r)
    {
        //$recs = tblSiteWide::select('StartDateTimeFormatted','Exceptions Triggered')->where('Exceptions Triggered','TRUE')->limit(1000)->get();
        
        $w = $this->buildWhereClause($r);

        //$recs = DB::select("select year([StartDateTimeFormatted]) as year,month([StartDateTimeFormatted]) as month,day([StartDateTimeFormatted]) as day, count(1) as count from vwSiteWideData where {$w}  group by year([StartDateTimeFormatted]),month([StartDateTimeFormatted]),day([StartDateTimeFormatted]) order by 1,2,3");
        //$recs = DB::select("select year([StartDateTimeFormatted]) as year,month([StartDateTimeFormatted]) as month,day([StartDateTimeFormatted]) as day, count(1) as count from vwSiteWideData where {$w}  group by year([StartDateTimeFormatted]),month([StartDateTimeFormatted]),day([StartDateTimeFormatted]) order by 1,2,3");
        $recs = tblSiteWide::selectRaw("year([StartDateTimeFormatted]) as year,month([StartDateTimeFormatted]) as month,day([StartDateTimeFormatted]) as day, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw('year([StartDateTimeFormatted]),month([StartDateTimeFormatted]),day([StartDateTimeFormatted])')
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

    public function chart2_data(Request $r)
    {
        $w = $this->buildWhereClause($r);

        //$recs = DB::select("select [CIP System] as cipsystem, count(1) as count from tblSiteWideData where {$w} group by [CIP System] order by 1");
        $recs = tblSiteWide::selectRaw("[CIP System] as cipsystem, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw('[CIP System]')
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


    public function chart3_data(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        //$recs = DB::select("select [CIP Line] as cipline, count(1) as count from vwSiteWideData where {$w} group by [CIP Line] order by 1");
        $recs = tblSiteWide::selectRaw("[CIP Line] as cipline, count(1) as count ")
            ->whereRaw($w)
            ->groupByRaw('[CIP Line]')
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


    public function chart4_data(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        //$recs = DB::select("select [Object] as object, count(1) as count from vwSiteWideData where {$w} group by [Object] order by 1");
        $recs = tblSiteWide::selectRaw("[Object] as object, count(1) as count")
            ->whereRaw($w)
            ->groupByRaw('[Object]')
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




    public function tabletoPlotly($recs) {
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
    

    public function tableToGoogle($recs)
    {
//dd($recs);

       $cols=[];
       foreach($recs->first()->getAttributes() as $k=>$v) {
            $type='string';
            if(key_exists($k,tblSiteWide::$cast)) {
              $type=tblSiteWide::$cast[$k];
            }
         
            $cols[] = (object)['id'=>$v, 'label'=>$k, 'type'=>$type]; 
       }

       $rows=[];
       foreach($recs as $r) {
            $cval=[];
            foreach($r->getAttributes() as $k=>$v) {
                if(key_exists($k,tblSiteWide::$cast)) {
                    if(tblSiteWide::$cast[$k]=='datetime') {
                       // echo $v."\n";
                        $t=date('c',strtotime($v));
                        $v=strtotime($t)*1000;
                       // echo date('c',$v)."\n";
                        $v = "Date({$v})";
                       // echo $v."\n";
                        
                    }
                }   
                $cval[] = array('v' => $v );
                
            }
            $rows[] = array('c' => $cval);
       }

       $table['cols'] = $cols;
       $table['rows'] = $rows;

       return json_encode($table);
    }



    public function getData1()
    {
        
        $recs = tblSiteWide::limit(100)->select('StartDateTimeFormatted','DurationHours','Exceptions Triggered')->get();

        echo $this->tableToGoogle($recs);
        
exit;
        $r = (object)['id'=>'task', 'label'=>'Employee Name', 'type'=>'string'];
        $cols[]=$r;
        $r = (object)['id'=>'startDate', 'label'=>'Start Date', 'type'=>'string'];
        $cols[]=$r;

        
        $cval=[];
        $cval[] = array('v' => 'Mike');
        $cval[] = array('v'=>'1-3-2008');
        $rows[] = array('c' => $cval);

        $cval=[];
        $cval[] = array('v' => 'John');
        $cval[] = array('v'=>'1-6-2018');
        $rows[] = array('c' => $cval);
        
        $table['cols'] = $cols;
        $table['rows'] = $rows;



   
     return json_encode($table);
        //$recs = tblSiteWide::limit(10)->get();



        foreach($recs as $r) {
            $data[] = [$r->id, $r->data1];

        }


        $cols = ['a'=>'xxx' ];
        
        
/*        
        $data = 
        
        
        data = {
            cols: [{id: 'task', label: 'Employee Name', type: 'string'},
                   {id: 'startDate', label: 'Start Date', type: 'date'}],
            rows: [{c:[{v: 'Mike'}, {v: new Date(2008, 1, 28), f:'February 28, 2008'}]},
                   {c:[{v: 'Bob'}, {v: new Date(2007, 5, 1)}]},
                   {c:[{v: 'Alice'}, {v: new Date(2006, 7, 16)}]},
                   {c:[{v: 'Frank'}, {v: new Date(2007, 11, 28)}]},
                   {c:[{v: 'Floyd'}, {v: new Date(2005, 3, 13)}]},
                   {c:[{v: 'Fritz'}, {v: new Date(2011, 6, 1)}]}
                  ]
          }

*/

    }


  


}
