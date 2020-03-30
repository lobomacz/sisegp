@extends('layouts.app')

@isset($menu_list)
	@section('toolbar')
		@foreach($menu_list as $item => $list)
			@component('components.nav_menu', ['item' => $item, 'list' => $list])
			@endcomponent
		@endforeach
	@endsection('toolbar')
@endisset

@section('content')

	@component('components.formulario', ['ruta' => $ruta])

		@slot('titulo_form')
			{{ __('insert') }}&nbsp;{{ __('project') }}
		@endslot

		@include('proyectos.formulario')

	@endcomponent

	@component('components.dialogo_alert')

		@slot('titulo_alert')
			{{ __('save') }}&nbsp;{{ __('data') }}
		@endslot

		@slot('mensaje_alert')
			{{ __('messages.insert_new') }}
		@endslot

		@include('partials.button_submit', ['value' => 'OK'])

	@endcomponent

@endsection('content')