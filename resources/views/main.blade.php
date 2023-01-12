<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fileinput.min.css">
    
    <link href="/css/small-business.css" rel="stylesheet">
    <link href="/css/jquery.jqplot.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/bootstrap-table.min.css">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    @yield('stylesheet')

    <script src="/js/jquery-3.5.1.min.js" ></script>
    <script src="/js/popper.js"></script>
    <script src="/js/tableExport.min.js"></script>
    <script src="/js/jspdf.min.js"></script>
    <script src="/js/jspdf.plugin.autotable.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/fileinput.min.js" ></script>
    <script src="/js/bootstrap-table.min.js" ></script>
    <script src="/js/bootstrap-table-export.min.js" ></script>
    <script src="/js/bootstrap-table-filter-control.min.js" ></script>
    <script src="/js/bootstrap-table-cookie.min.js" ></script>
    <script src="/js/bootstrap-wysiwyg.js" ></script>
    <script src="/js/plotly-2.14.0.min.js" ></script>
    
    

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    
    
    
    </head>


<body>
        @include("partials._navigation")

<div class="container_fluid">
        @yield('content')
</div>



@yield('javascript')
@include('partials._footer')
</body>
</html>
