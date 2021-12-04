<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            // プライマリー
            $table->unsignedBigInteger('customer_id', true);
            // カスタマーコード
            $table->string('customer_code', 100);
            // 名前
            $table->string('name', 25);
            // 住所
            $table->string('address', 100);
            // tel
            $table->unsignedBigInteger('phone');
            // mail
            $table->string('email');
            // 割引率
            $table->tinyInteger('discount');
            // 論理削除を定義
             // 削除、作成、更新日
             $table->softDeletes();
             $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
             $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
