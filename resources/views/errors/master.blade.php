<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="OMNIS un système de gestion scolaire qui consiste en la digitalisation des process existants dans les différents établissements aussi bien primaires, secondaires que supérieurs dans les secteurs public et privé." />
        <meta name="keywords" content="ERP éducation, éducation, logiciel de gestion d'école, école, grande école" />
        <meta name="author" content="selfbranding" />
        <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
        <title>@yield('title')</title>
        <!-- Google font-->
        @includeIf('errors.partials.css')
    </head>
    <body>
        <!-- Loader starts-->
        <div class="loader-wrapper">
            <div class="theme-loader">
                <div class="loader-p"></div>
            </div>
        </div>
        <!-- Loader ends-->
        <!-- error page start //-->
        @yield('content')
        <!-- error page end //-->
        <!-- latest jquery-->
        @includeIf('errors.partials.js')
    </body>
</html>



