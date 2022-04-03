<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            // 売上明細Ｎｏ
            $table->unsignedBigInteger('sales_details_no', true);
            // 販売価格
            $table->integer('selling_price');
            // 商品ＩＤ
            $table->unsignedBigInteger('goods_id');
            // 売上伝票Ｎｏ
            $table->unsignedBigInteger('sales_slips_num');

            // 削除、作成、更新日
            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            // $table->foreign('goods_id')->references('goods_id')->on('goods');
            $table->foreign('sales_slips_num')->references('sales_slips_num')->on('sales_slips');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_details');
    }
}
