<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesSlip;
use App\Models\SalesDetails;


class SalesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 売上伝票一覧表示のための検索画面を表示する
     * @return void
     */
    public function serachSlip()
    {
        return view('sales.serch-slip');
    }

    //　カスタマー検索画面の表示
    public function searchSlip()
    {
        return view('sales.sales-slip');
    }

    /**
     *  売上伝票を表示する
     * @return
     */
    public function listSlip(Request $request)
    {   
        $inputs = $request->all();
        // "date_min" => "2021-11-26"
        // "date_max" => "2021-11-27"

        // "created_at" => "2021-11-22 11:17:30"
        // "updated_at" => "2021-11-22 11:17:30"
        
        $name = $inputs['name_search'];
        $date_min = $inputs['date_min'];

        $date_min .= ' 00:00:00';
        
        $date_max = $inputs['date_max'];
        
        $sales_slips = SalesSlip::select('sales_slips.*', 'customers.name', 'customers.customer_id AS c_id')
                ->leftJoin('customers', 'sales_slips.customer_id', 'customers.customer_id')
                ->whereBetween('sales_slips.created_at', [$date_min, $date_max])
                ->where('customers.name', 'like', "%$name%")
                ->orderby('sales_slips_num', 'desc')->get(); 
        
        return view('sales.sales-slip', compact('sales_slips'));
    }

    /**
     * 売上明細画面を表示する
     *
     * @param [type] $id
     * @return view
     */
    public function detail($id)
    {
        // 指定の売上伝票に紐づく明細を複数取得する
        $sales_details = SalesDetails::where('sales_slips_num', $id)
                        ->orderby('sales_details_no', 'desc')->get();
        
        return view('sales.sales-details', compact('sales_details'));
    }

}