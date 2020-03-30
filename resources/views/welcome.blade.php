<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.sysname') }} || SISEGP</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .logo {
                width: 100%;
                text-align: center;
                margin-bottom: -15px;
            }

            .logo__text {
                text-transform: uppercase;
                font-size: 84px;
                font-weight: 100;
                margin-bottom: -5px;
            }

            .logo__picture {
                display: inline-block;
                width: 30%;
                margin-bottom: 5px;
            }

            .form__lang {
                position: absolute;
                visibility: hidden;
                top: -100rem;
                left: -100rem;
            }


        </style>
        <link rel="stylesheet" href="{{ URL::asset('storage/css/styles.css') }}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
    
                    <!-- Language Links -->

                    @if (App::isLocale('en'))
                    <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('form-es').submit();">Español</a>
                    <form id="form-es" class="form__lang" action="{{ route('Lang', ['lang' => 'es']) }}" method="post">
                        @csrf
                        <input name="backroute" id="backroute" type="hidden" value="{{ route('Welcome') }}">
                    </form>
                    @else
                    <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('form-en').submit();">English</a>
                    <form id="form-en" action="{{ route('Lang', ['lang' => 'en']) }}" class="form__lang" method="post">
                        @csrf
                        <input id="backroute" type="hidden" name="backroute" value="{{ route('Welcome') }}">
                    </form>
                    @endif

    
                    @auth
                        <a href="{{ url('/home') }}">{{ __('Home') }}</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('Login') }}&nbsp;<span class="icon icon-macz-sign-in"></span></a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <div class="logo">
                        <h2 class="logo__text">
                            GRACCS
                        </h2>
                        <img class="logo__picture" src="{{ URL::asset('img/logo_azul.png') }}" alt="logo_graccs">
                    </div>
                    SISEGP
                </div>

                <div class="links">
                    <a href="http://si.graccs.gob.ni" target="_blank">SIGC</a>
                    <a href="http://si.graccs.gob.ni:8000" target="_blank">Agenda</a>
                    <a href="http://craccs.gob.ni" target="_blank">{{ __('messages.craccs_link') }}</a>
                </div>
<!--
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> -->
            </div>
        </div>
    </body>
</html>
