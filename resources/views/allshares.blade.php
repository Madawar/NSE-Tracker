@extends('master')
@section('title')
    Stocks You Have Bought
@endsection
@section('content')
    <h1 class="text-center">All Stocks</h1>
    <hr/>
    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Stock</th>
            <th>Bid Value</th>
            <th>Max</th>
            <th>Min</th>
            <th>Avg</th>


        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($stocks as $stock)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <td>{{ucwords($stock->stock)}}</td>
                <td>{{$stock->value}}  </td>
                <td>{{$stock->max}}  </td>
                <td>{{$stock->min}}  </td>
                <td>{{$stock->avg}}  </td>


                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection