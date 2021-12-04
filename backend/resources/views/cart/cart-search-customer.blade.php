@extends('layouts.app3') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->

<script>
    // 販売商品のセレクトボックスが変更されたときの処理
    function test(){
        var id = document.getElementById("selectGoods").value;
        var name = 0;

        // laravelの配列変数をJavaScriptの変数へ渡す
        var goods_array = {!! json_encode($goodsArray) !!}
        
        // goods_idが変更したセレクトボックスと一致した単価をViewに直接変更する
        goods_array.forEach(goods => {
            if(goods['goods_id'] == id){
                document.getElementById("raw_price_label").innerText=goods['raw_price'];
                document.getElementById("raw_price").value=goods['raw_price']; 
            }
        });
    }
</script>

<!--　セッションにエラーが入っていたら表示する -->
@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
<!--　セッションにメッセージがはいっていたら表示する -->
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    
@endif

<div class="card">
    <div class="card-header">
        <h4>商品入力</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form class="mb-3" action="{{ route('cart.addCart') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="selectCustomer" class="col-sm-1 col-form-label">お客様：</label>
                    <div class="col-sm-3">
                        <input type="hidden" name="customer_id" value="{{ $customers[0]['customer_id'] }}"/>
                        <label class="col-form-label">{{ $customers[0]['name'] }}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectGoods" class="col-sm-1 col-form-label">商品：</label>
                    <div class="col-sm-3">
                        <select class="form-select mb-3" name="goods_id" id="selectGoods" aria-label="Default select example" onchange="test()">
                            <option selected>商品を選択してください</option>
                            @foreach($goodsArray as $goods)
                            <option value="{{ $goods['goods_id'] }}">{{ $goods['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" class="form-control mb-3" id="raw_price" name="raw_price" value="300">
                    <label class="col-sm-1 col-form-label">単価:</label>
                    <label class="col-sm-1 col-form-label" id="raw_price_label">---</label>
                    <label class="col-sm-1 col-form-label">円</label>
                </div>
                <div class="form-group row">
                    <label for="inputStock" class="col-sm-1 col-form-label">数量</label>
                    <div class="col-sm-1">
                        <input type="number" min="1" max="50" class="form-control mb-3" name="stock" id="inputStock">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">カートへ追加する</button>
                <a class="btn btn-primary btn-sm ml-3" href="/cart/list/{{ $customers[0]['customer_id'] }}" role="button">カートを確認する</a>
            </form>
        </div>
    </div>
    <div class="card-footer">
        
    </div>
</div>




@endsection
