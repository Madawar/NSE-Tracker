@extends('master')
@section('content')
    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Stock</th>
            <th>Value</th>
            <th>Shares</th>
            <th>Date</th>
            <th>Stop Order</th>

        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($stocks as $stock)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <td>{{ucwords($stock->stock)}}</td>
                <td>{{ucwords($stock->value)}}</td>
                <td>{{ucwords($stock->stockNo)}}</td>
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
@endsection