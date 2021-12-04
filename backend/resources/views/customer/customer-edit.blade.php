@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
<h2>お客様編集画面</h2>
<!--　セッションにエラーが入っていたら表示する -->
@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
<!--　セッションにメッセージがはいっていたら表示する -->
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif

<div class="table-responsive">
    <form class="mb-3" action="{{ route('customer.update') }}" method="POST">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $customer['customer_id'] }}"
        <label for="inputName" class="form-label">お名前</label>
        <input type="text" class="form-control mb-3" name="name" id="inputName" value="{{ $customer['name'] }}">
        <label for="inputAddress" class="form-label">住所</label>
        <input type="text" class="form-control mb-3" name="address" id="inputAddress" value="{{ $customer['address'] }}">
        <label for="inputPhone" class="form-label">TEL</label>
        <input type="number" class="form-control mb-3" name="phone" id="inputPhone" value="{{ $customer['phone'] }}">
        <label for="inputEmail" class="form-label">メールアドレス</label>
        <input type="email" class="form-control mb-3" name="email" id="inputEmail" areia-describedby="emailHelp" value="{{ $customer['email'] }}">
        <label for="inputDiscount" class="form-label">割引率</label>
        <input type="number" class="form-control mb-3" name="discount" id="inputDiscount" value="{{ $customer['discount'] }}">

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
