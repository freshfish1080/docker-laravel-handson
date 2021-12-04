@extends('layouts.app3') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->

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
        <h4>購入内容</h4>
    </div>
    <div>
        <h5 class="ml-3">購入者：{{ $carts[0]['c_name'] }}</h5>
    </div>
    <div class="card-body">
        <form class="card-body my-card-body" action="{{ route('cart.exeCart') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">商品</th>
                        <th scope="col">単価</th>
                        <th scope="col">数量</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $carts as $cart )
                    <tr>
                        <td>{{ $cart['g_name'] }}</td>
                        <td>{{ $cart['price'] }}</td>
                        <td>{{ $cart['stock'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4>合計:{{ $total_price }}円</h4>
            <!-- todo -->
            <!-- 売上伝票フォームへPOSTする -->
            <!-- 必要なもの 売上伝票（顧客ID）、売上明細（価格、数量、商品ID） -->
            <input type="hidden" name="customer_id[]" value="{{ $carts[0]['c_id'] }}">
            @foreach( $carts as $cart)
                <input type="hidden" name="goods_id[]" value="{{ $cart['g_id'] }}">   
                <input type="hidden" name="price[]" value="{{ $cart['price'] }}">   
                <input type="hidden" name="stock[]" value="{{ $cart['stock'] }}">    
            @endforeach
            <button type=submit class="btn btn-primary">確定する</button>
        </form>
    </div>
</div>
<a class="btn btn-secondary btn-sm mt-3" href="/top" role="button">TOPへ戻る</a>

@endsection
