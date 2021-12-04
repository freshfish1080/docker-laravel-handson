<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\GoodsCategory;
use DB;

class GoodsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Goods $goods, GoodsCategory $goods_category)
    {
        $this->middleware('auth');
        $this->goods = $goods;
        $this->goods_category = $goods_category;
    }

    /**
     * 商品一覧画面を表示
     *  
     *  @return view
     */
    public function list()
    {   
        //　全商品取得
        $goodsAll = $this->goods->getGoodsAndCategory();

        return view('goods.goods-list', compact('goodsAll'));
    }

    /**
     *  商品登録画面を表示する
     * 
     * @return view
     */
    public function create()
    {
        // 商品カテゴリの削除以外のデータを取得する
        $goods_categories = GoodsCategory::whereNull('deleted_at')->get();

        return view('goods.goods-create', compact('goods_categories'));
    }
    
    /**
     * 商品を登録する
     * @param request
     * @return view
     */
    public function store(Request $request)
    {
        // バリデーションチェック(重複) todo
        $request->validate([
            'name' => 'required',
            'raw_price' => 'required',
            'stock' => 'required',
            'goods_category_id' => 'required'
        ]);
        $inputs = $request->all();
        
        // GoodsCategory::create(['name' => $category_name]);
        Goods::insert([
            'name' => $inputs['name'],
            'raw_price' => $inputs['raw_price'],
            'stock' => $inputs['stock'],
            'goods_category_id' => $inputs['goods_category_id']
        ]);
        // todo　とりあえずこの画面へ飛ばす
        $request->session()->flash('message', '登録完了しました');
        return redirect( route('goods.list') );
    }

    /**
     * 商品の編集画面を表示する
     * @param id 
     * @return view
     */
    public function edit($id)
    {
        // GoodsモデルにCategoryモデルをJoinしたものを取得する
        // $goods = Goods::select('goods.*', 'goods_categories.goods_category', 'goods_categories.name AS category_name')
        //     ->where('goods_id', $id)
        //     ->leftJoin('goods_categories', 'goods.goods_category_id', 'goods_categories.goods_category')
        //     ->first();
        
        // Goods By ID
        $goods = $this->goods->getGoodsById($id);
        
        // GoodsCategoryモデルの全てのを取得する
        $goods_categories = GoodsCategory::whereNull('deleted_at')->get();
       
        return view('goods.goods-edit', compact('goods', 'goods_categories'));
    }

    /**
     * 商品カテゴリーの更新処理
     * @param request 
     * @return view 
     */
    public function update(Request $request)
    {
        $inputs = $request->all();

        DB::transaction(function() use($inputs){
            Goods::where('goods_id', $inputs['goods_id'])
                ->update(
                [
                    'name' => $inputs['name'],
                    'raw_price' => $inputs['raw_price'],
                    'stock' => $inputs['stock'],
                    'goods_category_id' => $inputs['goods_category_id']
                ]
            );
        });

        // $request->session()->flash('message', '変更完了しました');
        session()->flash('message', '変更完了しました');
        return redirect( route('goods.list') );
    }

    /**
     * 商品カテゴリーを削除する
     * @param goods_category(主キー)
     * @return view
     */
    public function destroy(Request $request)
    {
        // idを取得
        $inputs = $request->all();
        $id = $inputs['goods_id'];
        
        // ここからトランザクション処理
        DB::transaction(function() use($id){
            //　対象カテゴリーを削除する
            Goods::where('goods_id', $id)->delete();
        });
        
        // セッションにメッセージを渡す
        $request->session()->flash('msg_delete', '削除完了しました');
        // カテゴリーリストへ戻る
        return redirect( route('goods.list') );
    }
    
}
