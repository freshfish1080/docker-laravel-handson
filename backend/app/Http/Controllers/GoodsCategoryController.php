<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodsCategory;
use App\Http\Requests\GoodsRequest;
use DB;

// class ProductController extends Controller
class GoodsCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GoodsCategory $goods_category)
    {
        $this->middleware('auth');
        $this->goods_category = $goods_category;
    }

    /**
     * 商品カテゴリ一覧画面を表示
     *  
     *  @return view
     */
    public function list()
    {   
        // 商品カテゴリーモデルを取得する
        $goods_categories = $this->goods_category->getGoodsCategoriesAll();
        return view('category.goods-category-list', compact('goods_categories'));
    }

    /**
     *  商品カテゴリ登録画面を表示する
     * 
     * @return view
     */
    public function create()
    {
        return view('category.goods-category-create');
    }
    
    /**
     * 商品カテゴリーを登録する
     * @param category_name
     * @return view
     */
    public function store(Request $request)
    {
        // バリデーションチェック(重複) todo
        $request->validate(['category_name' => 'required']);
        // モデルにデータを追加する
        $this->goods_category->addGoodsCategoryByName($request['category_name']);

        return redirect( route('goods_category.list') )->with('message', '登録完了しました');
    }

    /**
     * 商品カテゴリーの詳細画面を表示する
     * @param id 商品カテゴリID
     * @return view 商品カテゴリデータ
     */
    public function edit($id)
    {
        $goods_category = $this->goods_category->getGoodsCategoryById($id);
        
        return view('category.goods-category-edit', compact('goods_category'));
    }

    /**
     * 商品カテゴリーの更新処理
     * @param request 
     * @return view 
     */
    public function update(Request $request)
    {
        $inputs = $request->all();
        
        // 更新処理
        DB::transaction(function() use($inputs){
            $this->goods_category->updateGoodsCategory($inputs);
        });
        
        return redirect( route('goods_category.list') )->with('message', '登録完了しました');
    }

    /**
     * 商品カテゴリーを削除する
     * @param goods_category(主キー)
     * @return view
     */
    public function destroy(Request $request)
    {
        // idを取得
        $tmp = $request->all();
        $id = $tmp['goods_category'];
        
        // ここからトランザクション処理
        DB::transaction(function() use($id){
            //　対象カテゴリーを削除する
             // GoodsCategory::where('goods_category', $id)->delete();
             $this->goods_category->deleteGoodsCategoryById($id);
        });
        
        // カテゴリーリストへ セッションも渡す
        return redirect( route('goods_category.list') )->with('msg_delete', '削除完了しました');
    }
    
}
