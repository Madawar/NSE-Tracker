@extends('master')
@section('title')
    Stock Graph
@endsection
@section('content')
    <div id="app">
        <div class="panel panel-default cls-panel">
            <div class="panel-body">
                <canvas id="mix4" count="1"></canvas>
            </div>
        </div>


        <chartjs-line target="mix4" datalabel="{{$stocks->first()->stock}}" :data={!! json_encode($stocks->pluck('value')) !!}   :backgroundcolor="['rgba(75,0,192,0.6)','rgba(0,88,88,0.6)','rgba(75,192,0,0.6)','rgba(75,192,192,0.6)']" :labels={!! json_encode($stocks->pluck('date')) !!} ></chartjs-line>

    </div>
@endsection

@section('jquery')
    <script>
        app = new Vue({
            el: '#app',
            data: {}
        });
    </script>
@endsection