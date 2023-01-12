<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tblSiteWide;
use App\Models\vwPlcActiveFormulaStep;
use App\Models\PLC_Active_Formula_Status_Color;

use DB;




class ActiveController extends Controller
{
    
    public function index()
    {
        return view('active'); 
    }

    public function getActive(Request $r)
    {
        $w = $this->buildWhereClause($r);
        
        //$recs = DB::select("select * from vwPlcActiveFormulaStep where {$w} order by PlantName, Cip_Line");
        $recs = vwPlcActiveFormulaStep::selectRaw("*")
            ->whereRaw($w)
            //->groupByRaw('[exception_type]')
            ->orderByRaw("PlantName, Cip_Line")
            ->get();         
        //$xrecs=DB::select(DB::raw("exec [spGetFakeRows]"));
        //dd($xrecs);
        
        
        //dd($recs);
        return $recs;
    }

    public function getColors()
    {
        $recs = PLC_Active_Formula_Status_Color::orderBy('OrdrBy')->get();
        return $recs;
    }

   
    function buildWhereClause(Request $r) {
        $where = " 1=1 ";
        if($r->has('line') ) {
            if(strlen($r->line)>0) $where .= " and [Cip_Line]='{$r->line}' ";
        }

        if($r->has('system') ) {
            if(strlen($r->system)>0) $where .= " and [CIP System]='{$r->system}' ";
        }

        if($r->has('object')) {
            if(strlen($r->object)>0) $where .= " and [PLC_Name]='{$r->object}' ";
        }

        if($r->has('plant')) {
            if(strlen($r->plant)>0) $where .= " and [PlantName]='{$r->plant}' ";
        }

        if($r->has('exception')) {
            if(strlen($r->exception)>1) $where .= " and [Exceptions Triggered]='{$r->exception}' ";
        }
        
        //$where .= " and [Exceptions Triggered]='TRUE' ";

        
        return $where;

    }

}
