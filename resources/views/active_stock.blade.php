@extends('master')
@section('content')


@if(isset($stock))
    {!! Form::model($stock, ['action' => ['StockController@update', $stock->id], 'method' =>
    'patch'])
    !!}
@else
    {!! Form::open(array('action' => 'StockController@store', 'files'=>false)) !!}
@endif

<div class="form-group{!! $errors->has('stock') ? ' has-error' : '' !!}">
    {!! Form::label('stock', 'Stock') !!}
    {!! Form::select('stock',$stocks, null, ['class' => 'form-control']) !!}
    {!! $errors->first('stock', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{!! $errors->has('stopOrder') ? ' has-error' : '' !!}">
    {!! Form::label('stopOrder', 'Stop Order') !!}
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-ban"></i></span>
        {!! Form::text('stopOrder', null, ['class' => 'form-control','placeholder'=>'Stop Order']) !!}
        <span class="input-group-addon"><i class="fa fa-ban"></i></span>
    </div>
    {!! $errors->first('stopOrder', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{!! $errors->has('value') ? ' has-error' : '' !!}">
    {!! Form::label('value', 'Value') !!}
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-ban"></i></span>
        {!! Form::text('value', null, ['class' => 'form-control','placeholder'=>'Value']) !!}
        <span class="input-group-addon"><i class="fa fa-ban"></i></span>
    </div>
    {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
</div>

<button type="submit" class="btn btn-flat bg-flat btn-block">Save Stock</button>
{!! Form::close() !!}
@endsection