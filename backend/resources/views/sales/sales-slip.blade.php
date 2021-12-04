@extends('layouts.app2') <!-- 親ビューと連携する -->

@section('goods_content') <!-- 親に差し込む子ビューの内容 -->

<div class="ml-3"><!-- スペーシングをとりあえずしておく-->
    <h2>売上伝票検索</h2>
    
    <div class="card">
        <div class="card-header">
            <h4>絞り込み</h4>
        </div>
        <div class="card-body">
            <form class="d-flex" action="{{ route('sales.listSlip') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-1"><label>期間:</label></div>
                        <div class="col-1 p-0"><input type="date" name="date_min"></div>
                        <div class="col-1"><label class="col-form-label ml-3">〜</label></div>
                        <div class="col-1"><input type="date" name="date_max"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-1"><label>名前:</label></div>
                        <div class="col-3 p-0"><input type="search" name="name_search"></div>
                    </div>
                    <button class="btn btn-outline-primary col-1 mt-3" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- 絞り込みデータが入っていたら表示する -->
    @if ( isset($sales_slips) )
        <div class="card">
            <div class="card-header">
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">伝票番号</th>
                            <th scope="col">顧客ID</th>
                            <th scope="col">顧客名</th>
                            <th scope="col">売上金額</th>
                            <th scope="col">作成日</th>
                            <th scope="col">更新日</th>
                            <th scope="col">詳細</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_slips as $slip)
                        <tr>
                            <td>{{ $slip['sales_slips_num'] }}</td>
                            <td>{{ $slip['customer_id'] }}</td>
                            <td>{{ $slip['name'] }}</td>
                            <td>{{ $slip['selling_price_sum'] }}</td>
                            <td>{{ $slip['created_at'] }}</td>
                            <td>{{ $slip['updated_at'] }}</td>
                            <td><a href="/sales/details/{{ $slip['sales_slips_num'] }}" class="btn btn-secondary"">詳細</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
    @endif
    
</div>
@endsection
