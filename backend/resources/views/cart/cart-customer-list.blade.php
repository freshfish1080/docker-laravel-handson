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
@if (session('msg_delete'))
    <div class="alert alert-danger">{{ session('msg_delete') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h4>お客様検索</h4>
    </div>
    <div class="card-body">
        絞り込み
        <form class="d-flex" action="{{ route('cart.findCustomer') }}" method="POST">
            @csrf
            <input type="search" name="name_search" class="form-control me-2">
            <button class="btn btn-outline-primary" type="submit" ml-3>Search</button>
        </form>
    </div>
    
</div>
@if ( isset($customers) )

    <!-- テーブルは半分の画面を使用する -->
    <div class="container-fluid p-0">
       <div class="row">
            <div class="col-sm-3"> 
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">顧客名</th>
                            <th scope="col">選択</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $customers as $customer )
                        <tr>
                            <td>{{ $customer['name'] }}</td>
                            <td><a href="/cart/goods/select/{{ $customer['customer_id'] }}" class="btn btn-primary">選択</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-3"> 
                <!-- 中部　　-->
            </div>
            <div class="col-sm-6"> 
                <!--  右部 -->
            </div>
       </div>
    </div>   
@else 
@endif
@endsection
