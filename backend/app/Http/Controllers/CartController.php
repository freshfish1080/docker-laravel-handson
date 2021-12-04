<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\SalesSlip;
use App\Models\SalesDetails;
use PDF;
use DB;

class CartController extends Controller
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
     * カートの中身を表示する
     *  @param 顧客ID
     * @return
     */
    public function listCart($id)
    {   
        // カートテーブルのデータ有無を取得（true or false)
        $is_exists = Cart::select('carts.*', 'customers.name AS c_name', 'goods.name AS g_name',
            'customers.customer_id AS c_id', 'goods.goods_id AS g_id')
            ->leftJoin('customers','carts.customer_id','customers.customer_id')
            ->leftJoin('goods', 'carts.goods_id', 'goods.goods_id')
            ->where('carts.customer_id', $id)->exists();

        // カートテーブルのデータが存在しない場合
        if ( !$is_exists ){
            // 別のブレードへ飛ばす
            return redirect()->back()->withInput()->withErrors('カートは空です');
        }

        $carts = Cart::select('carts.*', 'customers.name AS c_name', 'goods.name AS g_name',
            'customers.customer_id AS c_id', 'goods.goods_id AS g_id')
            ->leftJoin('customers','carts.customer_id','customers.customer_id')
            ->leftJoin('goods', 'carts.goods_id', 'goods.goods_id')
            ->where('carts.customer_id', $id)->get();
        
        // 合計金額 初期化しておく
        $total_price = 0;
        foreach($carts as $cart){
            $total_price += ($cart['price'] * $cart['stock']);
        }

        // 返す値：　ログインユーザーのメモテーブルとタグテーブル
        return view('cart.cart-list', compact('carts', 'total_price'));
    }

    /**
     * カートへ追加する
     *
     * @param Request $request
     * @return mixed 
     */
    public function addCart(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'goods_id' => 'required',
            'raw_price' => 'required',
            'stock' => 'required|digits_between:1,255'
        ]);

        // リクエストで飛んできた値を　「配列」　で取得
        $inputs = $request->all(); 

        // ここからトランザクション処理
        DB::transaction(function() use($inputs){
            // カートへPostされてきたデータをインサートする
            Cart::insert([
                'customer_id' => $inputs['customer_id'],
                'goods_id' => $inputs['goods_id'],
                'price' => $inputs['raw_price'],
                'stock' => $inputs['stock']
            ]);
        });
        
        // 登録完了のメッセージをセッションへ渡す
        $request->session()->flash('message', '登録完了しました');

        // return redirect( route('cart.searchCustomer') );
        return redirect()->back()->withInput();
    }
    
    /**
     * 購入最終確認画面を表示する
     *
     * @param [type] $id
     * @return view
     */
    // public function confirmCart($id)
    // {
    //     // カート＆カスタマー＆グッズテーブルをくっつける
    //     $carts = Cart::select('carts.*', 'customers.name AS c_name', 'goods.name AS g_name',
    //                         'customers.customer_id AS c_id', 'goods.goods_id AS g_id')
    //         ->leftJoin('customers','carts.customer_id','customers.customer_id')
    //         ->leftJoin('goods', 'carts.goods_id', 'goods.goods_id')
    //         ->where('carts.customer_id', $id)->get();
        
    //     // 合計金額 初期化しておく
    //     $total_price = 0;
    //     foreach($carts as $cart){
    //         $total_price += ($cart['price'] * $cart['stock']);
    //     }

    //     return view('cart.cart-confirm', compact('carts', 'total_price'));
    // }

    /**
     * 売上明細＆売上伝票へ反映する
     *
     * @param Request $request
     * @return void
     */
    public function exeCart(Request $request)
    {
        $inputs = $request->all();

        
        $customer_id = intval($inputs['customer_id'][0]);

        $priceis = $inputs['price'];    // 価格の配列
        $stocks = $inputs['stock'];     // 個数の配列
        $count = count($priceis);       //　カウンタ変数 
    
        // 合計金額を初期化し、合計金額を取得する
        $total_price = 0;               
        for ( $i=0; $i<$count; $i++){
            $total_price += $priceis[$i] * $stocks[$i];
        }

        
        
        DB::transaction(function() use($inputs, $customer_id, $total_price, $count){
            //　1.売上伝票の作成（顧客ID、販売合計）
            $sales_slip_id = SalesSlip::insertGetId([
                'selling_price_sum' => $total_price,
                'customer_id' => $customer_id
            ]);
            
            // 2.売上明細の作成（単価、数量、商品ID、売上伝票） //SalesDetails//
            for ( $i=0; $i<$count; $i++){
                SalesDetails::insert([
                    'selling_price' => $inputs['price'][$i],
                    'goods_id' => $inputs['goods_id'][$i],
                    'sales_slips_num' => $sales_slip_id,
                    'stock' => $inputs['stock'][$i]
                ]);
            }
            
            // 3.確定したあとはカートの中身を削除する
            Cart::query()->delete();
        });

        // $pdf = PDF::loadView('receipt', compact('total_price'));
        // return $pdf->stream();
        
        // セッションにメッセージを渡す
        $request->session()->flash('message', '売上登録が完了しました');
        return redirect( route('cart.searchCustomer') );
    }
    
    //　カスタマー検索画面の表示
    public function searchCustomer()
    {
        return view('cart.cart-customer-list');
    }

    // 検索ボタンの処理
    public function findCustomer(Request $request)
    {
        $inputs = $request->all();
        $name = $inputs['name_search'];
        
        // あいまい検索
        $customers = Customer::where('name', 'like', "%$name%")->get();
    
        return view('cart.cart-customer-list', compact('customers'));
    }
   

    // 販売画面の表示
    public function selectGoods($id)
    {
        $customers = Customer::where('customer_id',$id)
                    ->whereNull('deleted_at')->get(); // 全顧客データ    
        $goodsArray = Goods::whereNull('deleted_at')->get();  // 全商品データ
        // 販売トップ画面へ　＆　顧客データと商品データを添付
        return view('cart.cart-search-customer', compact('customers', 'goodsArray'));
    }

    /**
     * カート内の商品を削除する
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        // カートIDが入ってるcart-id
        $inputs = $request->all();
        $cart_id = $inputs['cart-id'];
        
        // ここからトランザクション処理
        DB::transaction(function() use($cart_id){
            //　対象カテゴリーを削除する
            Cart::where('cart_id', $cart_id)->delete();
        });
        
        $request->session()->flash('msg_delete', '削除完了しました');
        // 戻る 
        return redirect( route('cart.searchCustomer') );
    }
}
