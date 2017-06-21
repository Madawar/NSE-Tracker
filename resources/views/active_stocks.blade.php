@extends('master')
@section('title')
    Stocks You Have Bought
@endsection
@section('content')
    <h1 class="text-center">Stocks You have Bought</h1>
    <hr/>
    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Stock</th>
            <th>Bid Value</th>
            <th>Shares</th>
            <th>Current Value</th>
            <th>Profit</th>
            <th>Date</th>
            <th>Stop Order</th>
            <th>Actions</th>

        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($stocks as $stock)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <td>{{ucwords($stock->stock)}}</td>
                <td>{{$stock->value}} = KES {{$stock->boughtValue}} </td>
                <td>{{ucwords($stock->stockNo)}}</td>
                <td>{{ucwords($stock->currentValue)}} = KES {{$stock->currentValue}}</td>
                <td>KES {{($stock->currentValue)-($stock->boughtValue)}}</td>
                <td>{{ucwords($stock->date)}}</td>
                <td>{{ucwords($stock->stopOrder)}}</td>
                <td>
                    <div aria-label="Actions" role="group" class="btn-group">
                        <a href="{{action('StockController@destroy', $stock->id)}}"
                           class="open-popup-link btn btn-primary"
                           data-url="{{action('StockController@destroy', $stock->id)}}"><i
                                    class="fa fa-remove"></i></a>
                        <a class="btn btn-info" href="{{action('StockController@edit', $stock->id)}}"> <i
                                    class="   fa fa-edit"></i></a>
                    </div>
                </td>

                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-8">

        </div>
        <div class="col-md-4">
            <h1 class="text-center">Bottom Line</h1>
            <hr/>
            <table class="table table-paper table-condensed table-bordered">
                <thead>
                <tr>
                    <th>Total Bid</th>
                    <th>Total Sellable</th>
                    <th>Profit</th>


                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{number_format($stocks->sum('boughtValue'),2)}}</td>
                    <td>{{number_format($stocks->sum('currentValue'),2)}}</td>
                    <td>{{number_format($stocks->sum('currentValue')-$stocks->sum('boughtValue'),2)}}</td>
                </tr>


                </tbody>
            </table>
        </div>
    </div>

@endsection