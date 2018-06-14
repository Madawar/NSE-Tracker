@extends('master')
@section('title')
    Stocks You Have Bought
@endsection
@section('content')

    <div id="app">
    <vtable url="api/shares" :filters="filters" detail_row="graph_row"
            :columns="columns"></vtable>
    </div>

@endsection

@section('jquery')
    <script>
        app = new Vue({
            el: '#app',
            data: {
                columns: [

                    {
                        name: 'stock',
                        title: 'Stock',
                        sortField: 'stock',
                        visible: true
                    },
                    {
                        name: 'color',
                        title: 'Trend',
                        sortField: 'color',
                        visible: true
                    },
                    {
                        name: 'value',
                        title: 'Current Value',
                        sortField: 'value',
                        visible: true
                    },
                    {
                        name: 'max',
                        title: 'Max',
                        sortField: 'max',
                        visible: true
                    },
                    {
                        name: 'min',
                        title: 'Min',
                        sortField: 'min',
                        visible: true
                    }
                ],
                filters: []

            },
            methods: {}
        });
    </script>
@endsection