@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->

<div class="card">
    <div class="card-header">
        <h4>商品カテゴリの登録</h4>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <form class="mb-3" action="{{ route('goods_category.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">商品カテゴリー名:</label>
                    <div class="col-sm-4">
                        <input type="text" name="category_name" class="form-control"  placeholder="商品カテゴリー名">
                    </div>
                </div>
                @error('category_name')
                    <div class="alert alert-danger">カテゴリー入力欄を確認してください。</div>
                @enderror
                <button type="submit" class="btn btn-primary mt-3">登録</button>
            </form>
        </div>
    </div>
    <div class="card-footer">
    </div>
</div>
@endsection
