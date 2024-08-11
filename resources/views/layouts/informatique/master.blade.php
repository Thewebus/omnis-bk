<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="OMNIS un système de gestion scolaire qui consiste en la digitalisation des process existants dans les différents établissements aussi bien primaires, secondaires que supérieurs dans les secteurs public et privé." />
        <meta name="keywords" content="ERP éducation, éducation, logiciel de gestion d'école, école, grande école" />
        <meta name="author" content="selfbranding" />
        <link rel="icon" href="{{asset('/assets/images/favicon.png')}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{asset('/assets/images/favicon.png')}}" type="image/x-icon">
        <title>@yield('title')</title>
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        <!-- Flashy font-->
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet'>
        <!-- Font Awesome-->
        @includeIf('layouts.informatique.partials.css')
    </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-sidebar" id="pageWrapper">
      <!-- Page Header Start-->
      @includeIf('layouts.informatique.partials.header')
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        @includeIf('layouts.informatique.partials.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          @yield('content')
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright {{date('Y')}}-{{date('y', strtotime('+1 year'))}} © OMNIS All rights reserved.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- latest jquery-->
    @includeIf('layouts.informatique.partials.js')
    @include('flashy::message')
    <script>
      var body = document.getElementsByTagName('body')[0];
      var dark_theme_class = 'dark-theme';
      var theme = getCookie('theme');

      if(theme != '') {
          body.classList.add(theme);
      }

      document.addEventListener('DOMContentLoaded', function () {
          $('#theme-toggle').on('click', function () {

              if (body.classList.contains(dark_theme_class)) {
                  body.classList.remove(dark_theme_class);
                  $('#mode').text('Light Mode')
                  setCookie('theme', 'light');
              }
              else {
                  $('#mode').text('Dark Mode')
                  body.classList.add(dark_theme_class);
                  setCookie('theme', 'dark-theme');
              }
          });
      });

      // enregistrement du theme dans le cookie
      function setCookie(name, value) {
          var d = new Date();
          d.setTime(d.getTime() + (365*24*60*60*1000));
          var expires = "expires=" + d.toUTCString();
          console.log(expires)
          document.cookie = name + "=" + value + ";" + expires + ";path=/";
          console.log(document.cookie)
      }

      // methode de recuperation du theme dans le cookie
      function getCookie(cname) {
          var theme = cname + "=";
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');

          for(var i = 0; i < ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) == ' ') {
                  c = c.substring(1);
              }

              if (c.indexOf(theme) == 0) {
                  return c.substring(theme.length, c.length);
              }
          }
          return "";
      }
    </script>
  </body>
</html>
