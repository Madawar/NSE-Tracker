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
            <th>View Trend</th>


        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($stocks as $stock)
            <tr class="{{$stock->color}} d">
                <th scope="row">{{$i}}</th>
                <td>
                    {{ucwords($stock->stock)}}
                    @if($stock->color == "danger")
                        ({{number_format($stock->percentage)}}% Below Average)
                    @endif

                    @if($stock->color == "success")
                        ({{number_format($stock->percentage)}}% above Average)
                    @endif
                </td>
                <td>{{$stock->value}}  </td>
                <td>{{$stock->max}}  </td>
                <td>{{$stock->min}}  </td>
                <td>{{$stock->avg}}  </td>
                <td><a href="{{action('SharesController@show',$stock->stock)}}" class="btn btn-block btn-flat bg-green"><i
                                class="fa fa-line-chart"></i></a></td>


                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection