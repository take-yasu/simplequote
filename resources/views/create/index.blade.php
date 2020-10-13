@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row mb-2">
                <h4>■御見積書新規作成</h4>
            </div>

            <!--見積入力フォーム-->
            <div class="row mb-2">
                <div class="col">
                    <form action="{{route('create.insert')}}" method="post" id="create">
                        @csrf
                        <!--見積ヘッダー部-->
                        <div class="card mb-2">
                            <div class="card-header">ご希望のお見積内容をご入力ください</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="delivery_name" class="col-md-2 col-form-label">お届け先名称</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="delivery_name" placeholder="お届け先名称を入力">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zip" class="col-md-2 col-form-label">郵便番号</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="zip" onKeyUp="AjaxZip3.zip2addr(this,'','address01','address02', 'address03');" placeholder="郵便番号を入力すれば住所が自動入力されます。（ハイフン無しで）"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="delivery_name" class="col-md-1 col-form-label">都道府県</label>
                                    <div class="col-md-2">
                                        <select class="form-control" name="address01">
                                            <option value="">-- 都道府県 --</option>
                                            @foreach($prefs as $pref)
                                                <option value="{{$pref->pref_name}}">{{$pref->pref_name}}</option>
                                            @endforeach
                                        </select>
                                        <!--<input type="text" class="form-control" name="address01" />-->
                                    </div>
                                    <label for="delivery_name" class="col-md-1 col-form-label">市区町村</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="address02" />
                                    </div>
                                    <label for="delivery_name" class="col-md-1 col-form-label">丁目番地</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="address03" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--見積明細部-->
                        <add-row
                            :login-user="{{ json_encode([
                                'name' => Auth::user()->name,
                                'user_code' => Auth::user()->user_code,
                                ]) }}">
                        </add-row>

                        <!--見積明細部-->
                        <!--
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>商品コード</th>
                                    <th>商品名</th>
                                    <th>数量</th>
                                    <th>単価</th>
                                    <th>小計</th>
                                <tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= $denpyou_rows; $i++)
                                <tr>
                                    <td><input type="text" class="form-control" name="product_number"></td>
                                    <td><input type="text" class="form-control" name="product_name" readonly></td>
                                    <td><input type="text" class="form-control" name="quantity"></td>
                                    <td><input type="text" class="form-control" name="unit_price" readonly></td>
                                    <td><input type="text" class="form-control" name="subtotal" readonly></td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>-->
                        <button type="submit" class="btn btn-primary">確認</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="/js/ajaxzip3.js"></script>
@endsection
