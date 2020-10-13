@extends('layout')

@section('content')
<p>テストです</p>
@foreach($request->product_number as $index => $item)
{{$index}} {{$item}}
@endforeach
@endsection('content')
