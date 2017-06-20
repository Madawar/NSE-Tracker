<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{url('css/app.css')}}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{url('css/AdminLTE.css')}}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{url('css/font-awesome.css')}}" type="text/css" media="all"/>
    <link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed|Ubuntu|Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <style>
        .container {
            background: white;
            padding: 10px;
            min-height: 500px;
            box-shadow: -1px -1px 15px 1px rgba(207, 205, 207, 1) !important;
        }
    </style>


    <title>
        @section('title')@show
    </title>
</head>
<body class="">
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">NSE Stock Tracker</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{action('StockController@index')}}">View Bought Stocks</a></li>
                <li><a href="{{action('SharesController@index')}}">View All Shares</a></li>
                <li><a href="{{action('StockController@create')}}">Record Bought Stock</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    @yield('content')
</div>

</body>
<script type="text/javascript" src="{{url('js/app.js')}}"></script>

@section('jquery')

@show


</html>