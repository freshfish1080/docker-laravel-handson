<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    /**
     * グッズモデルを返す
     * @return collection
     */
    public function getGoodsAndCategory()
    {
        $goodsAll = Goods::select('goods.*', 'goods_categories.name AS category_name')
            ->leftJoin('goods_categories', 'goods.goods_category_id', 'goods_categories.goods_category')
            ->get();

        return $goodsAll;
    }

    /**
     *  IDに一致するグッズモデルのフィールドを返す 
     * 
     */
    public function getGoodsById($id)
    {
        // GoodsモデルにCategoryモデルをJoinしたものを取得する
        $goods = Goods::select('goods.*', 'goods_categories.goods_category', 'goods_categories.name AS category_name')
            ->where('goods_id', $id)
            ->leftJoin('goods_categories', 'goods.goods_category_id', 'goods_categories.goods_category')
            ->first();
        
        return $goods;
    }

}
