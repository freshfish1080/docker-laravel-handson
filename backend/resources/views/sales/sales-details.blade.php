@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->

<div class="ml-3"><!-- スペーシングをとりあえずしておく-->
    <h3>売上明細</h3>
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th scope="col">明細番号</th>
                <th scope="col">価格</th>
                <th scope="col">商品ID</th>
                <th scope="col">伝票番号</th>
                <th scope="col">登録日</th>
                <th scope="col">販売個数</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_details as $detail)
            <tr>
                <td>{{ $detail['sales_details_no'] }}</td>
                <td>{{ $detail['selling_price'] }}</td>
                <td>{{ $detail['goods_id'] }}</td>
                <td>{{ $detail['sales_slips_num'] }}</td>
                <td>{{ $detail['created_at'] }}</td>
                <td>{{ $detail['stock'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-primary" onclick="window.print();return false;">印刷</button>
</div>
@endsection
