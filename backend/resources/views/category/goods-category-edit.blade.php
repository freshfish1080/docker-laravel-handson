@extends('layouts.app2') <!-- 親ビューを表示 -->

@section('goods_content') <!-- 以下、子ビューの内容 -->
@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
<!--　セッション変数（message）にメッセージがはいっていたら表示する -->
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif

<h1 class="text-secondary ml-3">商品カテゴリー名変更</h1>
<form class="card-body my-card-body" action="{{ route('goods_category.update') }}" method="POST">
    @csrf
    <input type="hidden" name="category_id" value="{{ $goods_category['goods_category'] }}">
    <input type="text" name="category_name" class="form-control mb-3" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="商品カテゴリー名" value="{{ $goods_category['name']}}">
    @error('category_name')
        <div class="alert alert-danger">カテゴリー入力欄を確認してください。</div>
    @enderror
    <button type="submit" class="btn btn-primary">変更</button>
</form>
@endsection
