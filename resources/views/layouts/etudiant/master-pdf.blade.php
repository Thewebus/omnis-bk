<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/style.css')}}">
        <link id="color" rel="stylesheet" href="{{asset('/assets/css/color-1.css')}}" media="screen">
        <title>Scolarité</title>
    </head>
    <body>
        <!-- page-wrapper Start-->
        <div class="page-wrapper compact-sidebar" id="pageWrapper">
            <div class="page-body-wrapper sidebar-icon">
                <div class="page-body">
                    <!-- Container-fluid starts-->
                    @yield('content')
                    <!-- Container-fluid Ends-->
                </div>
            </div>
        </div>
        <script src="{{asset('/assets/js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('/assets/js/config.js')}}"></script>
        <script src="{{asset('/assets/js/bootstrap/popper.min.js')}}"></script>
        <script src="{{asset('/assets/js/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/js/script.js')}}"></script>
        <script src="{{asset('/assets/js/theme-customizer/customizer.js')}}"></script>
    </body>
</html>
