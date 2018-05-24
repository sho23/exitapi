<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .card-link {
            display: block;
        }
    </style>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $( function() {
        $( "#spots" ).autocomplete({
              source: document.location.origin + '/home/auto_search',
              minLength: 1,
              select: function(event, ui) {
                    $('#spot').val(ui.item.value);
              }
        });
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('.parent').on('change', function(){
            var trackId = $(this).val();
            $.ajax({
                url: document.location.origin + '/spots/get_station_list',
                type: "POST",
                dataType: 'json',
                data: {
                track_id: trackId
                }
            })
            .done(function(data){
                $('.children option').remove();
                $.each(data, function(id, name){
                  $('.children').append($('<option>').text(name).attr('value', id));
                });
            })
            .fail(function(){
                console.log("失敗");
            });
        });
        $('.children').on('change', function(){
            var stationId = $(this).val();
            $.ajax({
                url: document.location.origin + '/spots/get_exit_list',
                type: "POST",
                dataType: 'json',
                data: {
                station_id: stationId
                }
            })
            .done(function(data){
                //selectタグ（子） の option値 を一旦削除
                $('.childchildren option').remove();
                //select.php から戻って来た data の値をそれそれ optionタグ として生成し、
                // .car_model に optionタグ を追加する
                $.each(data, function(id, name){
                  $('.childchildren').append($('<option>').text(name).attr('value', id));
                });
            })
            .fail(function(){
                console.log("失敗");
            });
        });

    });
  </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li><a href="{{ url('/spots/create') }}" class="btn btn-primary">新規追加</a></li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
