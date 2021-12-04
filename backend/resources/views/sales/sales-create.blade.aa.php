@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
<h1 class="text-secondary ml-3">商品登録画面</h1>
    <form class="card-body my-card-body" action="{{ route('goods.store') }}" method="POST">
        @csrf
        <label for="inputId" class="form-label">商品名</label>
        <input type="text" class="form-control mb-3" name="name" id="inputId">
        <label for="inputRawPrice" class="form-label">原価</label>
        <input type="text" class="form-control mb-3" name="raw_price" id="inputRawPrice">
        <label for="inputStock" class="form-label">数量</label>
        <input type="text" class="form-control mb-3" name="stock" id="inputStock">
        <label for="inputGoodsCategory" class="form-label">商品カテゴリー</label>
        <select class="form-select mb-3" name="goods_category_id" id="inputGoodsCategory" aria-label="Default select example">
            <option selected>選択してください</option>
            <!-- todo  ここにループでカテゴリー名を入れる　とりあえずサンプルデータにしておく-->
            @foreach($goods_categories as $category)
            <option value="{{ $category['goods_category'] }}">{{ $category['name'] }}</option>
            @endforeach
        </select>
        
        @error('category_name')
            <div class="alert alert-danger">カテゴリー入力欄を確認してください。</div>
        @enderror
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
