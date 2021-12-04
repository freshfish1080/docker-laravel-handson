@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('javascript')
<script src="/js/confirm.js"></script>
@endsection

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
<div class="ml-3"><!-- スペーシングをとりあえずしておく-->
<h2>商品リスト</h2>
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif
@if (session('msg_delete'))
    <div class="alert alert-danger">{{ session('msg_delete') }}</div>
@endif

<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">商品名</th>
            <th scope="col">原価</th>
            <th scope="col">数量</th>
            <th scope="col">カテゴリー名</th>
            <th scope="col">作成日</th>
            <th scope="col">更新日</th>
            <th scope="col">編集</th>
            <th scope="col">削除</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($goodsAll as $goods)
        <tr>
            <th scope="row">{{ $goods['goods_id'] }}</th>
            <td>{{ $goods['name'] }}</td>
            <td>{{ $goods['raw_price'] }}</td>
            <td>{{ $goods['stock'] }}</td>
            <td>{{ $goods['category_name'] }}</td>
            <td>{{ $goods['created_at'] }}</td>
            <td>{{ $goods['updated_at'] }}</td>
            <td><a href="/goods/edit/{{ $goods['goods_id'] }}" class="btn btn-secondary"">編集</a></td>
            <td>
                <form id="delete-form" action="{{ route('goods.destroy') }}" id="delete-form" method="POST">
                    @csrf
                    <input type="hidden" name="goods_id" value="{{ $goods['goods_id'] }}">
                    <button type="submit" class="btn btn-secondary" onclick="deleteHandle(event);">削除</button>
                    <!-- フォントオーサムを使用時
                    <i class="fas fa-trash mr-3" onclick="deleteHandle(event);"></i>
                    -->
                </form>                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
