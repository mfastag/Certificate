<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tblSiteWide;
use App\Models\vwInventoryUsage;
use App\Models\tblCip_Chemical_log;
use App\Models\tblCip_Chemicals;
use Illuminate\Support\Facades\Auth;


use DB;

class InventoryController extends Controller
{
    
    public function index()
    {
        return view('inventory'); 
    }

    public function dosIndex()
    {
        //return view('dosGuage');
        return view('dos');
    }

   
    public function barcodeCheckMaterialCode(Request $r) {
        $barcode = $r->input('code');
        $material = tblCip_Chemicals::where('VendorCode', $barcode)->first();
        
        if ($material) {
            return response()->json(['success'=>true, 'material'=>$material]);
        } else {
            return response()->json(['success'=>false]);
        }
    }

    public function barcodePostInventory(Request $r) {
        $item = new tblCip_Chemical_log();
        $item->tblCip_Chemicals_id = $r->chemid;
        $item->tblCip_Plants_id= $r->plant;  
        $item->LogQty = $r->quantity;
        $item->RcvdSinceLast = $r->received;
        $item->LogDate=date('Y-m-d H:i:s');
        $item->changed_by=Auth::user()->name;
        
        //print_r($item);
        $item->save();        
        
        return response()->json(['success'=>true]);
    }


    public function getDos(Request $r) {
        $w = $this->buildWhereClause($r);
        $w .= ' and LstLog=1 ';

        $recs = vwInventoryUsage::select(['id','chemical_name','LogQty','DaysOfInventory','TodayQty','place_order','PlantName','tblCip_Plants_id'])->whereRaw($w)->orderBy('chemical_name','asc','PlantName','asc','DaysOfInventory','desc')->get();

        $now = strtotime('now');

        $data=[];
        foreach($recs as $r) {
            $data['x'][] = $r->chemical_name;
            $data['LogQty'][] = $r->LogQty;
            $data['DaysOfInventory'][] = $r->DaysOfInventory;
            $data['TodayQty'][] = $r->TodayQty;
            $data['hover'] = "Current Qty: " . $r->TodayQty . "<br>Place Order: " . $r->place_order;
            //$data['CurrentQty'][] = $r->CurrentQty;
            $data['id'][] = $r->id;
            $data['color']='green';

            if(strtotime($r->place_order) < $now ) {
                $data['color']='red';
            }
        }
        return $data;
    }

    public function getDosGuages(Request $r) {
        $w = $this->buildWhereClause($r);
        $w .= ' and LstLog=1 ';

        //dd($w);

        $recs = vwInventoryUsage::select(['id','chemical_name','LogQty','TodayQty','WarningQty','RedQty','DaysOfInventory','place_order','PlantName','tblCip_Plants_id'])->whereRaw($w)->orderBy('chemical_name','asc','PlantName','asc')->get();

        $now = strtotime('now');

        foreach($recs as $k=>$r) {
            if(strtotime($r->place_order) < $now ) {
                $recs[$k]->color='red';
            } else {
                $recs[$k]->color='green';
            }
        }
        return $recs;
    }


    public function getInventory(Request $r)
    {
        $w = $this->buildWhereClause($r);
        $w .= ' and LstLog=1 ';
        
        $recs = vwInventoryUsage::whereRaw($w)->orderBy('chemical_name', 'asc')->get();

        //$recs = DB::select("select * from vwPlcActiveFormulaStep where {$w} order by PlantName, Cip_Line");
        
        return $recs;
    }

    public function saveLog(Request $r) {
        
        $data = $r->all();

        foreach ($data as $key => $value) {
            if(substr($key,0,9)=='chem_curr') {
                $flds = explode('_', $key);
                $chemid=$flds[2];

                $curr = $data['chem_curr_' . $chemid];
                $recvd = $data['chem_recvd_' . $chemid];

                if(is_numeric($curr) || is_numeric($recvd) || is_numeric($recvd)) {
                    $item = new tblCip_Chemical_log();
                    $item->tblCip_Chemicals_id = $chemid;
                    $item->tblCip_Plants_id=$r->frmPlant;
                    $item->LogQty = $curr;
                    $item->RcvdSinceLast = $recvd;
                    $item->LogDate=date('Y-m-d');
                    $item->changed_by='Keith';
                    $item->save();
                }
            }
        }
        
        return 'OK';
    }


    function buildWhereClause(Request $r) {
        $where = " 1=1 ";

        if($r->has('plant')) {
            if(strlen($r->plant)>0) $where .= " and [PlantName]='{$r->plant}' ";
        }

        if($r->has('chemical')) {
            if(strlen($r->chemical)>0) $where .= " and [chemical_name]='{$r->chemical}' ";
        }

        return $where;

    }

}
