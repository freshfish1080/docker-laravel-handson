@extends('layouts.app3') <!-- 親ビューと連携する -->

@section('javascript')
<script src="/js/confirm.js"></script>
@endsection

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
        <h4>お客様名:{{ $carts[0]['c_name'] }}</h4>
    </div>
    <div>
        <span class="badge bg-light text-dark">カート一覧</h3></span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">商品</th>
                        <th scope="col">単価</th>
                        <th scope="col">数量</th>
                        <th scope="col">変更</th>
                        <th scope="col">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $carts as $cart )
                    <tr>
                        <td>{{ $cart['g_name'] }}</td>
                        <td>{{ $cart['price'] }}</td>
                        <td>{{ $cart['stock'] }}</td>
                        
                        <td><a href="#" class="btn btn-secondary"">変更</a></td>
                        <td>
                            <form action="{{ route('cart.destroy') }}" id="delete-form" method="POST">
                                @csrf
                                <input type="hidden" name="cart-id" value="{{ $cart['cart_id'] }}">
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
    </div>
    <div class="card-footer">
        <span>
            <h4>合計:{{ $total_price }}円</h4>
        </span>
    </div>
</div>
<form class="card-body my-card-body" action="{{ route('cart.exeCart') }}" method="POST">
    @csrf
    <input type="hidden" name="customer_id[]" value="{{ $carts[0]['c_id'] }}">
    @foreach( $carts as $cart)
        <input type="hidden" name="goods_id[]" value="{{ $cart['g_id'] }}">   
        <input type="hidden" name="price[]" value="{{ $cart['price'] }}">   
        <input type="hidden" name="stock[]" value="{{ $cart['stock'] }}">    
    @endforeach
    <button type=submit class="btn btn-primary">確定する</button>
</form>
@endsection
