<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            // カートID
            $table->unsignedBigInteger('cart_id', true);
            // 数量
            $table->integer('stock');
            // 商品ID
            $table->unsignedBigInteger('goods_id');
            // 顧客ID
            $table->unsignedBigInteger('customer_id');

            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            
            // 外部キー設定　（ここを忘れてエラーではまったので注意！！）
            $table->foreign('goods_id')->references('goods_id')->on('goods');
            $table->foreign('customer_id')->references('customer_id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
