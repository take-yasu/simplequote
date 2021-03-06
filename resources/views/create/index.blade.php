@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if(isset($header))
                <div class="row mb-2">
                    <h4>■御見積書新規作成</h4>
                    <div class="col">
                        <div class="float-right btn-group">
                            <div class="btn-toolbar">
                                <a href="{{route('detail.index', ['denpyou_number' => $header->denpyou_number])}}" class="btn btn-outline-secondary">戻る</a>
                                <a href="{{route('search.index')}}" class="btn btn-outline-secondary">一覧</a>
                            </div class="btn-toolbar">
                        </div>
                    </div>
                </div>
            @else
                <div class="row mb-2">
                    <h4>■御見積書新規作成</h4>
                </div>
            @endif
            <!--見積入力フォーム-->
            <div class="row mb-2">
                <div class="col">
                    @if(isset($details))
                    <add-row
                        :login-user="{{ json_encode([
                            'route' => route('create.insert'),
                            'name' => Auth::user()->name,
                            'user_code' => Auth::user()->user_code,
                            ]) }}"
                        :old="{{ json_encode( Session::getOldInput()) }}"
                        :items=
                        "{{ json_encode([
                                'details' => $details,
                                ])}}"
                        >
                    @else
                    <add-row
                        :login-user="{{ json_encode([
                            'route' => route('create.insert'),
                            'name' => Auth::user()->name,
                            'user_code' => Auth::user()->user_code,
                            ]) }}"
                        :old="{{ json_encode( Session::getOldInput()) }}"
                        >
                    @endif
                        <div class="card mb-2">
                            <div class="card-header">ご希望のお見積内容をご入力ください</div>
                            <div class="card-body">
                                @if(count($errors) > 0)
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger">{{$error}}</div>
                                        @break
                                    @endforeach
                                @endif

                                <div class="form-group row">
                                    <label for="delivery_name" class="col-md-2 col-form-label">お届け先名称</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="delivery_name" placeholder="お届け先名称を入力"
                                            value=
                                                @if(old('delivery_name'))
                                                    "{{old('delivery_name')}}"
                                                @elseif(isset($header))
                                                    "{{$header->delivery_name}}"
                                                @else
                                                    ""
                                                @endif
                                             >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zip" class="col-md-2 col-form-label">郵便番号</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="zip" onKeyUp="AjaxZip3.zip2addr(this,'','address01','address02', 'address03');"
                                            placeholder="郵便番号を入力すれば住所が自動入力されます。（ハイフン無しで）"
                                            value=
                                                @if(isset($header))
                                                    "{{$header->zip}}"
                                                @else
                                                    "{{ old('zip') }}"
                                                @endif
                                            />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="delivery_name" class="col-md-1 col-form-label">都道府県</label>
                                    <div class="col-md-2">
                                        <select class="form-control" name="address01">
                                            <option value="">-- 都道府県 --</option>
                                            @foreach($prefs as $pref)
                                                <option value="{{$pref->pref_code}}"
                                                    @if(isset($header))
                                                        @if($header->pref_code == $pref->pref_code) selected @endif>{{$pref->pref_name}}</option>
                                                    @else
                                                        @if(old('address01') == $pref->pref_code) selected @endif>{{$pref->pref_name}}</option>
                                                    @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="delivery_name" class="col-md-1 col-form-label">市区町村</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="address02"
                                            value=
                                                @if(isset($header))
                                                    "{{$header->city_name}}"
                                                @else
                                                    "{{ old('address02') }}"
                                                @endif
                                            />
                                    </div>
                                    <label for="delivery_name" class="col-md-1 col-form-label">丁目番地</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="address03"
                                            value=
                                                @if(isset($header))
                                                    "{{$header->address}}"
                                                @else
                                                    "{{ old('address03') }}"
                                                @endif
                                            />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </add-row>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="/js/ajaxzip3.js"></script>
@endsection
