@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
<div class="card">
    <div class="card-header">
        <h4 class="text-secondary ml-3">商品登録</h4>
    </div>
    <div class="card-body">
        <form class="mb-3" action="{{ route('goods.store') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputId" class="col-sm-1 col-form-label">商品名:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control mb-3" name="name" id="inputId">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputRawPrice" class="col-sm-1 col-form-label">単価:</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control mb-3" name="raw_price" id="inputRawPrice">
                </div>
                <label for="inputRawPrice" class="col-sm-1 col-form-label">円</label>
            </div>
            <div class="form-group row">
                <label for="inputStock" class="col-sm-1 col-form-label">数量:</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control mb-3" name="stock" id="inputStock">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputCategory" class="col-sm-1 col-form-label">カテゴリー:</label>
                <div class="col-sm-2">
                    <select class="form-select mb-3" name="goods_category_id" id="inputGoodsCategory" aria-label="Default select example">
                        <option selected>選択してください</option>
                        <!-- todo  ここにループでカテゴリー名を入れる　とりあえずサンプルデータにしておく-->
                        @foreach($goods_categories as $category)
                        <option value="{{ $category['goods_category'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            @error('category_name')
                <div class="alert alert-danger">カテゴリー入力欄を確認してください。</div>
            @enderror
            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
    <div class="card-footer">
        
    </div>
</div>

    
@endsection
