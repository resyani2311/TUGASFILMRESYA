<head>
  <title>@yield('title', config('app.name')) - {{ config('app.name') }}</title>
  <!-- for-mobile-apps -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="keywords" content="{{ config('app.name') }}, film, movie, review" />
  <!-- //for-mobile-apps -->
  <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
  <link href="{{ asset('template/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
  <link href="{{ asset('template/css/medile.css') }}" rel='stylesheet' type='text/css' />
  <link href="{{ asset('template/css/single.css') }}" rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="{{ asset('template/css/contactstyle.css') }}" type="text/css" media="all" />
  <link rel="stylesheet" href="{{ asset('template/css/faqstyle.css') }}" type="text/css" media="all" />
  <link rel="stylesheet" href="{{ asset('template/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/news.css') }}" type="text/css" media="all" />
  <link rel="stylesheet" href="{{ asset('template/list-css/list.css') }}" type="text/css" media="all" />
  <link rel="stylesheet" href="{{ asset('css/app-extra.css') }}" type="text/css" media="all" />
  <script type="text/javascript" src="{{ asset('template/js/jquery-2.1.4.min.js') }}"></script>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300' rel='stylesheet' type='text/css'>
  <script type="text/javascript" src="{{ asset('template/js/move-top.js') }}"></script>
  <script type="text/javascript" src="{{ asset('template/js/easing.js') }}"></script>
  <link href="{{ asset('template/css/owl.carousel.css') }}" rel="stylesheet" type="text/css" media="all">
  <script src="{{ asset('template/js/owl.carousel.js') }}"></script>
  <script>
    $(document).ready(function() {
      $("#owl-demo").owlCarousel({ autoPlay: 3000, items: 5, itemsDesktop: [640, 5], itemsDesktopSmall: [414, 4] });
    });
  </script>
  @stack('style')
</head>
