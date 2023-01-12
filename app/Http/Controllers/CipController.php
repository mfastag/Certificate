<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tblSiteWide;
use DB;


class CipController extends Controller
{
    
    public function index(Request $r)
    {
//        $recs = vwPlcActiveFormulaStep::select('PLC_Master_id')->distinct()->get();
        return view('cipdetail'); 
    }

    public function getDetail(Request $r)
    {
        //$w = $this->buildWhereClause($r);
        
        $id='0';
        if($r['id']) $id=$r['id'];

        $recs=DB::select(DB::raw("exec spGetCipDetails $id "));
        

        //dd($recs);
        return $recs;
    }

    function buildWhereClause(Request $r) {
        $where = " 1=1 ";
        if($r->has('line') ) {
            if(strlen($r->line)>1) $where .= " and [Cip_Line]='{$r->line}' ";
        }

        if($r->has('system') ) {
            if(strlen($r->system)>1) $where .= " and [CIP System]='{$r->system}' ";
        }

        if($r->has('object')) {
            if(strlen($r->object)>1) $where .= " and [PLC_Name]='{$r->object}' ";
        }

        if($r->has('plant')) {
            if(strlen($r->plant)>1) $where .= " and [PlantName]='{$r->plant}' ";
        }

        if($r->has('exception')) {
            if(strlen($r->exception)>1) $where .= " and [Exceptions Triggered]='{$r->exception}' ";
        }
        
        //$where .= " and [Exceptions Triggered]='TRUE' ";

        
        return $where;

    }

}
