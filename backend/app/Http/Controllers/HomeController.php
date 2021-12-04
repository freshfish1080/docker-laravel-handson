<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;
use App\Models\MemoTag;
use App\Models\Goods;
use DB;
use Hamcrest\Core\HasToString;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  顧客編集更新処理 
     *  @param 
     *  @return 
     */
    public function top()
    {
        return view('top');
    }

    // 販売画面の表示
    public function showSales()
    {
        $customers = Customer::whereNull('deleted_at')->get(); // 全顧客データ    
        $goodsArray = Goods::whereNull('deleted_at')->get();  // 全商品データ
        // 販売トップ画面へ　＆　顧客データと商品データを添付
        return view('sales.sales-top', compact('customers', 'goodsArray'));
    }

    // 管理画面の表示
    public function showSystems()
    {
        
        return view('systems-top');
    }

    /**
     * Show the application dashboard.
     *  
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderby('id', 'DESC')
            ->get();

        // 返す値：　ログインユーザーのメモテーブルとタグテーブル
        return view('create', compact('tags'));
    }

    public function store(Request $request)
    {
        // リクエストで飛んできた値を　「配列」　で取得
        $req = $request->all(); 
        $request->validate(['content' => 'required']);

        // ここからトランザクション処理
        DB::transaction(function() use($req){
            
            // 　メモテーブルのIDを格納
            // 同時にメモテーブルにcontentフィールドとユーザーIDをインサートする
            $memo_id = Memo::insertGetId(['content' => $req['memo_content'], 'user_id' => \Auth::id()]);
            
            // bool　　リクエストしたユーザーID、新規タグがあるかどうかを格納 
            $is_tag_exists = Tag::where('user_id', '=', \Auth::id())
                                ->where('name', '=', $req['new_tag_name'])
                                ->exists();

            // ①新規タグ欄が入力されていること、②重複タグがないこと
            if( !empty($req['new_tag_name']) && !$is_tag_exists ){
                // ①tagsテーブルにインサート、②タグIDを取得
                // ②memo_tagsにインサートで、メモとタグを紐付ける
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $req['new_tag_name']]);
                MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag_id]);
            }
            // 既存タグが紐付けられた場合-memo_tagsにインサート
            foreach($req['tags'] as $tag){
                MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag]);
            }
        });
        return redirect( route('home') );
    }

    /**
     * Undocumented function
     *
     * @param [type] $id 
     * @return view テンプレート、値
     */
    public function edit($id)
    {
        //$edit_memo = Memo::find($id);
        $edit_memo = Memo::select('memos.*', 'tags.id AS tag_id')
                ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                ->leftJoin('tags', 'memo_tags.tag_id', '=', 'tags.id')
                ->where('memos.user_id', '=', \Auth::id())
                ->where('memos.id', '=', $id)
                ->whereNull('memos.deleted_at')
                ->get();

        $include_tags = [];
        foreach($edit_memo as $memo){
            array_push($include_tags, $memo['tag_id']);
        }
       
        $tags = Tag::where('user_id', '=', \Auth::id())->whereNull('deleted_at')->orderBy('id', 'DESC')->get();
        // メモをビューへ渡す
        return view('edit', compact('edit_memo', 'include_tags', 'tags'));
    }

    public function update(Request $request)
    {
        // リクエストしたデータを取得
        $posts = $request->all();
        $request->validate(['content' => 'required']);
    
        // トランザクション
        DB::transaction(function () use($posts) {
            // アップデートは必ずwhereを使う！！
            Memo::where('id', $posts['memo_id'])->update(['content' => $posts['content']]);
            // 一旦メモとタグの紐付けを削除 (中間テーブルは物理削除)
            MemoTag::where('memo_id', '=', $posts['memo_id'])->delete();
            // 再度、メモとタグの紐付け
            foreach($posts['tags'] as $tag){
                MemoTag::insert(['memo_id' => $posts['memo_id'], 'tag_id' => $tag]);
            }

            $dup_tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])
                ->exists();
            // もし、新しいタグの入力があれば、インサートして紐付け
            if( !empty($requests['new_tag_name']) && !$dup_tag_exists ){
                // ①tagsテーブルにインサート、②タグIDを取得
                // ②memo_tagsにインサートで、メモとタグを紐付ける
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $requests['new_tag_name']]);
                MemoTag::insert(['memo_id' => $posts['memo_id'], 'tag_id' => $tag_id]);
            }
        });

        return redirect( route('home') );
    }

    public function destroy(Request $request)
    {
        $posts = $request->all();
        // 論理削除するため、deleted_atに日付を入れてアップデートする 
        Memo::where('id', $posts['memo_id'])->update(['deleted_at'=>date("Y-m-d H:i:s", time())]);
        
        return redirect( route('home') );
    }
}
