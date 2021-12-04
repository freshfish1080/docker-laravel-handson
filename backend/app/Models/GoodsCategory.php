<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    use HasFactory;

    protected $table = 'goods_categories';

    // 可変項目
    protected $fillable = 
    [
        'name'
    ];

    /**
     * 商品カテゴリーの全てのデータを返す
     *
     * @param
     * @return GoodsCategoriesモデル(全リスト）     */
    public function getGoodsCategoriesAll()
    {
        return $this->whereNull('deleted_at')->get();
    }

    /**
     * IDと一致する商品カテゴリーの単一データを返す
     *
     * @return GoodsCategoriesモデル(単一フィールド)
     */
    public function getGoodsCategoryById($id)
    {
        // return $this->where('goods_category', $id)->whereNull('deleted_at')->get();
        return $this->where('goods_category', $id)->whereNull('deleted_at')->first();
    }
    
    /**
     *  送られてきた名前をもとに商品カテゴリーを追加する
     *  @return void
     */
    public function addGoodsCategoryByName($name)
    {
        GoodsCategory::insert(['name' => $name]);
        return null;
    }

    /**
     *  送られてきたデータをもとにモデルの更新処理をおこなう
     *  @return void
     */
    public function updateGoodsCategory($inputs)
    {
        GoodsCategory::where('goods_category', $inputs['category_id'])
                    ->update(['name' => $inputs['category_name']]);

        return null;
    }

    /**
     *  商品カテゴリモデルの削除をする
     * @return void
     */
    public function deleteGoodsCategoryById($id)
    {
        GoodsCategory::where('goods_category', $id)->delete();

        return null;
    }
    
    


    

}
