@extends('layouts.app2') <!-- 親ビューと連携する -->

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
        <h4>お客様登録</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form class="mb-3" action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="inputCode" class="col-sm-1 col-form-label">顧客コード:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="customer_code" id="inputCode">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputName" class="col-sm-1 col-form-label">お名前:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="name" id="inputName">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputAddress" class="col-sm-1 col-form-label">住所:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="address" id="inputAddress">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPhone" class="col-sm-1 col-form-label">TEL:</label>
                    <div class="col-sm-5">
                        <input type="phone" class="form-control" name="phone" id="inputPhone">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-1 col-form-label">Mail:</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" name="email" id="inputEmail" areia-describedby="emailHelp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDiscount" class="col-sm-1 col-form-label">割引率:</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" name="discount" id="inputDiscount">
                    </div>
                    <label for="inputDiscount" class="col-sm-1 col-form-label">%</label>
                </div>
        
                <button type="submit" class="btn btn-primary">登録</button>
            </form>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>


@endsection
