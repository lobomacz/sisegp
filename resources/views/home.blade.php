@extends('layouts.app')

@section('content')
<div class="container">
    <!--
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>-->

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="jumbotron">
                <h1 class="display-4 text-uppercase">
                    {{ __('messages.homegreeting') }}
                </h1>
                <p class="lead my-2">
                    {{ __('messages.introduction') }}
                </p>
                <hr class="my-4">
                <p class="my-3">
                    {{ __('messages.menuprompt') }}
                </p>
                <div class="nav justify-content-center text-uppercase">

                    @if (Auth::user()->funcionario->tieneRol('superusuario') == true)
                    
                        <div class="nav-item">
                            <a href="{{ route('AdminDashboard') }}" class="nav-link">{{ __('Dashboard') }}</a>
                        </div>
                      
                    @else

                        @if (Auth::user()->funcionario->tieneRol('director') || Auth::user()->funcionario->tieneRol('director-seplan') || Auth::user()->funcionario->tieneRol('director-ejecutivo'))

                            <div class="nav-item"><a href="{{ route('Gestion') }}" class="nav-link">{{ __('management') }}</a></div>
                            <div class="nav-item"><a href="{{ route('Reportes') }}" class="nav-link">{{ __('reports') }}</a></div>

                        @else
    
                            <div class="nav-item"><a href="{{ route('Digitacion') }}" class="nav-link">{{ __('data registry') }}</a></div>
                            <div class="nav-item"><a href="{{ route('Gestion') }}" class="nav-link">{{ __('management') }}</a></div>
                            <div class="nav-item"><a href="{{ route('Reportes') }}" class="nav-link">{{ __('reports') }}</a></div>

                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
