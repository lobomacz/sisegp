<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav mr-auto">
                        @yield('toolbar')
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Language Links -->

                        <li class="nav-item dropdown text-uppercase">
                            
                            <a id="langDropdown" href="#" class="nav-link d-inline-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" arie-expanded="false">
                                @if(App::isLocale('es'))
                                <div class="bandera mx-3">
                                    <div class="bandera__img bandera__img--es"></div>
                                </div>
                                @else
                                <div class="bandera mx-3">
                                    <div class="bandera__img bandera__img--en"></div>
                                </div>
                                @endif
                                {{ App::getLocale() }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right w-auto" aria-labelledby="langDropdown">
                                <a href="{{ route('Lang', ['lang' => 'es', 'backroute' => isset($backroute)?$backroute:'Home']) }}" class="dropdown-item text-uppercase">
                                    ESPAÑOL
                                    <div class="bandera float-right">
                                        <div class="bandera__img bandera__img--es"></div>
                                    </div>
                                </a>
                                <a href="{{ route('Lang', ['lang' => 'en', 'backroute' => isset($backroute)?$backroute:'Home']) }}" class="dropdown-item">
                                    ENGLISH
                                    <div class="bandera float-right">
                                        <div class="bandera__img bandera__img--en"></div>
                                    </div>
                                </a>
                            </div>
                        </li>

                        <!-- Authentication Links -->
                        
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        <footer class="pt-4 footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        Copyright&copy; {{ __('messages.copyright') }}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        {{ __('messages.owner') }}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        {{ date('Y') }}
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
