@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('javascript')
<script src="/js/confirm.js"></script>
@endsection

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
<div class="ml-3"><!-- スペーシングをとりあえずしておく-->
<h2>商品カテゴリーリスト</h2>
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
            <th scope="col">商品カテゴリー名</th>
            <th scope="col">作成日</th>
            <th scope="col">更新日</th>
            <th scope="col">編集</th>
            <th scope="col">削除</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($goods_categories as $cate_array)
        <tr>
            <th scope="row">{{ $cate_array['goods_category'] }}</th>
            <td>{{ $cate_array['name'] }}</td>
            <td>{{ $cate_array['created_at'] }}</td>
            <td>{{ $cate_array['updated_at'] }}</td>
            <td><a href="/goods/category/edit/{{ $cate_array['goods_category'] }}" class="btn btn-secondary">編集</a></td>
            <td>
                <form id="delete-form" action="{{ route('goods_category.destroy') }}" method="POST">
                    @csrf
                    <input type="hidden" name="goods_category" value="{{ $cate_array['goods_category'] }}">
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
