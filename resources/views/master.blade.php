<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{url('css/app.css')}}" type="text/css" media="all"/>
    <link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed|Ubuntu|Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>



    <title>
        @section('title')@show
    </title>
</head>
<body class="">
<div class="container">
    @yield('content')
</div>

</body>
<script type="text/javascript" src="{{url('js/app.js')}}"></script>

@section('jquery')

@show


</html>