<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            // 仕入明細Ｎｏ
            $table->unsignedBigInteger('purchase_detail_no', true);
            // 仕入価格
            $table->integer('purchase_price');
            // 商品ＩＤ
            $table->unsignedBigInteger('goods_id');
            // 仕入伝票Ｎｏ
            $table->unsignedBigInteger('purchase_slips_num');

            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->foreign('goods_id')->references('goods_id')->on('goods');
            // $table->foreign('purchase_slips_no')->references('purchase_slips_no')->on('purchase_slips');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
