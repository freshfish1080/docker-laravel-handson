@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
<!--　セッションにメッセージがはいっていたら表示する -->
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif

<h1 class="text-secondary ml-3">商品編集画面</h1>
<form class="card-body my-card-body" action="{{ route('goods.update') }}" method="POST">
    @csrf
    <input type="hidden" name="goods_id" value="{{ $goods['goods_id'] }}">
    <label for="inputId" class="form-label">商品名</label>
    <input type="text" class="form-control mb-3" name="name" id="inputId" value="{{ $goods['name'] }}">
    <label for="inputRawPrice" class="form-label">原価</label>
    <input type="text" class="form-control mb-3" name="raw_price" id="inputRawPrice" value="{{ $goods['raw_price'] }}">
    <label for="inputStock" class="form-label">数量</label>
    <input type="text" class="form-control mb-3" name="stock" id="inputStock" value="{{ $goods['stock'] }}">
    <label for="inputGoodsCategory" class="form-label">商品カテゴリー</label>
    <select class="form-select mb-3" name="goods_category_id" id="inputGoodsCategory" aria-label="Default select example">
        <option value="{{ $goods['goods_category'] }}" selected>{{ $goods['category_name'] }}</option>
        <!-- todo  ここにループでカテゴリー名を入れる　とりあえずサンプルデータにしておく-->
        @foreach($goods_categories as $category)
        <option value="{{ $category['goods_category'] }}">{{ $category['name'] }}</option>
        @endforeach
    </select>
    
    @error('category_name')
        <div class="alert alert-danger">カテゴリー入力欄を確認してください。</div>
    @enderror
    <button type="submit" class="btn btn-primary">変更</button>
</form>
@endsection
