<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;    //メモモデルを読み込み
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 全てのメソッドが呼ばれる前に動くメソッド
        view()->composer('*', function($view){
            $memo_model = new Memo();
            // メモ取得
            $memos = $memo_model->getMymemo();

            $tags = Tag::where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();
            
            // 第一引数はViewで使用するときの命名、第２引数は渡したい変数
            $view->with('memos', $memos)->with('tags', $tags);
        });
    }
}
