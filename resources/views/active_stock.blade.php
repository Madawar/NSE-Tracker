@extends('master')
@section('title')
    Add A Stock That you have Bought
@endsection
@section('content')

    <h1 class="text-center">Record A Stock You Have Bought</h1>
    <hr/>
    <div class="alert alert-info">
        When You set Stop Order we will alert you when the stock goes below this level
    </div>
    @if(isset($stock))
        {!! Form::model($stock, ['action' => ['StockController@update', $stock->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'StockController@store', 'files'=>false)) !!}
    @endif

    <div class="form-group{!! $errors->has('stock') ? ' has-error' : '' !!}">
        {!! Form::label('stock', 'Stock') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-line-chart"></i></span>
            {!! Form::select('stock',$stocks, null, ['class' => 'form-control']) !!}
        </div>
        {!! $errors->first('stock', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group{!! $errors->has('stopOrder') ? ' has-error' : '' !!}">
        {!! Form::label('stopOrder', 'Stop Order') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-ban"></i></span>
            {!! Form::text('stopOrder', null, ['class' => 'form-control','placeholder'=>'Stop Order']) !!}
        </div>
        {!! $errors->first('stopOrder', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group{!! $errors->has('value') ? ' has-error' : '' !!}">
        {!! Form::label('value', 'Value') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-area-chart"></i></span>
            {!! Form::text('value', null, ['class' => 'form-control','placeholder'=>'Value']) !!}
        </div>
        {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group{!! $errors->has('stockNo') ? ' has-error' : '' !!}">
        {!! Form::label('stockNo', 'Number of Shares') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-list"></i></span>
            {!! Form::text('stockNo', null, ['class' => 'form-control','placeholder'=>'Number Of Shares']) !!}
            <span class="input-group-addon"><i class="fa fa-list"></i></span>
        </div>
        {!! $errors->first('stockNo', '<p class="help-block">:message</p>') !!}
    </div>

    <button type="submit" class="btn btn-flat bg-green btn-block">Save Stock</button>
    {!! Form::close() !!}
@endsection