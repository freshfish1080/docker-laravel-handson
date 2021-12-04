<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use DB;

class CustomerController extends Controller
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
     * 顧客一覧画面を表示
     *  
     *  @return view
     */
    public function list()
    {   
        // 商品カテゴリーモデルデータ全て取得（削除データ以外）
        $customers = Customer::whereNull('deleted_at')->get();

        return view('customer.customer-list', compact('customers'));
    }

    /**
     *  顧客登録画面を表示する
     * 
     * @return view
     */
    public function create()
    {
        // 顧客登録画面へ遷移する
        return view('customer.customer-create');
    }

    /**
     *  顧客登録を実行する
     * @param request
     * @return view
     */
    public function store(Request $request)
    {
        // バリデーションチェック todo ＠でリクエストフォームに書き換える
        // 重複チェック unique:データベース名,カラム名
        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code',
            'name' => 'required | max:10'
        ]);
        
        $customer = $request->all();

        // ここからトランザクション処理
        DB::transaction(function() use($customer){
            //　インサート処理実行
            Customer::insert([
                'customer_code' => $customer['customer_code'],
                'name' => $customer['name'],
                'address' => $customer['address'],
                'phone' => $customer['phone'],
                'email' => $customer['email'],
                'discount' => $customer['discount']
             ]);
        });

        $request->session()->flash('message', '登録完了しました');
        
        // 登録にはredirectを使う　なぜ？
        return redirect( route('customer.list')) ;
    }

    /**
     *  顧客を削除する
     * @param request
     * @return redirect
     */
    public function destroy(Request $request)
    {
         // customer_idが入っている
         $tmp = $request->all();
         $id = $tmp['customer_id'];
         
         // ここからトランザクション処理
         DB::transaction(function() use($id){
             //　対象カテゴリーを削除する
             Customer::where('customer_id', $id)->delete();
         });
         
         // セッションにメッセージを渡す
         $request->session()->flash('msg_delete', '削除完了しました');
         // カテゴリーリストへ戻る
         return redirect( route('customer.list') );
    }

    /**
     *  顧客編集画面の表示  
     *  @param id 顧客ID
     *  @return view　 顧客編集実行画面
     */
    public function edit($id)
    {
        $customer = Customer::where('customer_id', $id)->first();
        return view('customer.customer-edit', compact('customer'));
    }

     /**
     *  顧客編集更新処理 
     *  @param request
     *  @return redirect
     */
    public function update(Request $request)
    {
        // バリデーションチェック
        $request->validate([
            'name' => 'required | max:30'
        ]);

        // データを代入
        $inputs = $request->all();
        
        // "customer_id" => "6"
        // "name" => "テスト太郎"
        // "address" => "茨城県"
        // "phone" => "9011111111"
        // "email" => "aaa@gmail.com"
        // "discount" => "29"
                
        // ここからトランザクション処理
        DB::transaction(function() use($inputs){
            // todo mori
            Customer::where('customer_id', $inputs['customer_id'])
                ->update([
                            'name' => $inputs['name'],
                            'address' => $inputs['address'],
                            'phone' => $inputs['phone'],
                            'email' => $inputs['email'],
                            'discount' => $inputs['discount']
                        ]);
        });

        $request->session()->flash('message', '変更完了しました');
        return redirect( route('customer.list') );
    }

    
}
