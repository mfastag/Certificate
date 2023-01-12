<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\tblSiteWide;
use App\Models\vwPlcActiveFormulaStep;
use App\Models\PLC_Active_Formula_Status_Color;

use DB;




class ExceptionController extends Controller
{
    
    public function index()
    {
        //$recs = vwPlcActiveFormulaStep::select('PLC_Master_id')->distinct()->get();
        //$recs = vwPlcActiveFormulaStep::select('PLC_Master_id')->distinct()->get();
        return view('exception'); 
    }

    public function getTopEquipmentExceptions(Request $r) {
//        $recs = DB::select("select top 5 [object],count(1) as [count] from [tblSiteWideData] where [Exceptions Triggered]='TRUE' group by [object] order by [count] desc");
//        dd($recs);
        $line='CIP 1601';

        $StartDay=$r->StartDay;
        $StartDay='20220601';
        $EndDay=$r->EndDay;
        $EndDay='20220620';
        $CipSystem=$r->CipSystem;   
        $Plant=$r->Plant;
        $Line=$r->Line;
        $Equipment=$r->Equipment;
        $TopN = $r->Equipment;
        $TopN = 50;
        $logged_in_user = Auth::user()->name;
        $recs=DB::select(DB::raw("exec [spCipTopExceptions] '$StartDay', '$EndDay','$CipSystem','$Plant','$Line', '$Equipment',$TopN, '$logged_in_user' "));
        


        return $recs;

    }


    public function getExceptionsByType(Request $r)
    {
        $recs = DB::select("select [exception_type],count(1) as [count], sum(try_cast([Total Chemical Cost] as float)) as chemCost from [tblSiteWideData] where [Exceptions Triggered]='TRUE' group by [exception_type]");

        $data['labels'] = [];
        $data['values'] = [];
        $distinct=[];
        $count=0;
        $otherCount=0;
        foreach($recs as $r) {
            if($count++<5) {
                $data['labels'][] = $r->exception_type;
                $data['values'][] = $r->count;
            } else {
                $otherCount+=$r->count;
            }
            $distinct[$r->exception_type]=1;    
        }
        $data['labels'][] = 'Others';
        $data['values'][] = $otherCount;


        return $data;
    }

    public function getExceptionsByLine(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        $recs = DB::select("select [CIP Line] as cipline, count(1) as count from tblSiteWideData where {$w} group by [CIP Line] order by 2 desc");
        
        $data['labels'] = [];
        $data['values'] = [];
        $distinct=[];
        $count=0;
        $otherCount=0;
        foreach($recs as $r) {
            if($count++<5) {
                $data['labels'][] = $r->cipline;
                $data['values'][] = $r->count;
            } else {
                $otherCount+=$r->count;
            }
            $distinct[$r->cipline]=1;          
        }
        $data['labels'][] = 'Others';
        $data['values'][] = $otherCount;

        $data['distinct']=array_keys($distinct);

        return $data;
    }

    public function getExceptionsByObject(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        $recs = DB::select("select [Object] as object, count(1) as count from tblSiteWideData where {$w} group by [Object] order by 2 desc");
        
        $data['labels'] = [];
        $data['values'] = [];
        $count=0;
        $otherCount=0;
        $distinct=[];
        foreach($recs as $r) {
            if($count++<5) {
                $data['labels'][] = $r->object;
                $data['values'][] = $r->count;
            } else {
                $otherCount+=$r->count;
            }
            $distinct[$r->object]=1;          
        }
       // $data['labels'][] = 'Others';
       // $data['values'][] = $otherCount;

        $data['distinct']=  array_keys($distinct);

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



}
