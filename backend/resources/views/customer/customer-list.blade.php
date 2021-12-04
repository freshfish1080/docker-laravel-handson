@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('javascript')
<script src="/js/confirm.js"></script>
@endsection

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->
<div class="ml-3"><!-- スペーシングをとりあえずしておく-->
<h2>お客様一覧</h2>
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif
@if (session('msg_delete'))
    <div class="alert alert-danger">{{ session('msg_delete') }}</div>
@endif
<div class="table-responsive">
<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th scope="col">顧客番号</th>
            <th scope="col">名前</th>
            <th scope="col">住所</th>
            <th scope="col">TEL</th>
            <th scope="col">メール </th>
            <th scope="col">割引率</th>
            <th scope="col">作成日</th>
            <th scope="col">更新日</th>
            <th scope="col">編集</th>
            <th scope="col">削除</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <th scope="row">{{ $customer['customer_code'] }}</th>
            <td>{{ $customer['name'] }}</td>
            <td>{{ $customer['address'] }}</td>
            <td>{{ $customer['phone'] }}</td>
            <td>{{ $customer['email'] }}</td>
            <td>{{ $customer['discount'] }}</td>
            <td>{{ $customer['created_at'] }}</td>
            <td>{{ $customer['updated_at'] }}</td>
            <td><a href="/customer/edit/{{ $customer['customer_id'] }}" class="btn btn-secondary"">編集</a></td>
            <td>
                <form id="delete-form" action="{{ route('customer.destroy') }}" id="delete-form" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer['customer_id'] }}"> 
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
@endsection
