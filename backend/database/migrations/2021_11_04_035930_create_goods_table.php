<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            // 商品ID
            $table->unsignedBigInteger('goods_id', true);
            // 商品名
            $table->string('name');
            // 原価
            $table->integer('raw_price');
            // 在庫数
            $table->integer('stock');
            // 商品カテゴリID
            $table->unsignedBigInteger('goods_category_id');

            // 削除、作成、更新日
            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->foreign('goods_category_id')->references('goods_category')->on('goods_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
