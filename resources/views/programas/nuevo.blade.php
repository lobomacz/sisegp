@extends('layouts.app')

@if($menu_list != null)
	@section('toolbar')
		@foreach($menu_list as $item => $list)
			@component('components.nav_menu', ['item' => $item, 'list' => $list])
			@endcomponent
		@endforeach
	@endsection('toolbar')
@endif

@section('content')

	@component('components.formulario', ['ruta' => $ruta])

		@slot('titulo_form')
			{{ __('insert') }}&nbsp;{{ __('program') }}
		@endslot

		@include('programas.formulario')

	@endcomponent

	@component('components.dialogo_alert')

		@slot('titulo_alert')
			{{ __('save') }}&nbsp;{{ isset($programa->id) ? __('changes'):__('data') }}
		@endslot

		@slot('mensaje_alert')
			{{ __('messages.insert_new') }}
		@endslot

		@include('partials.button_submit', ['value' => 'OK'])


	@endcomponent

@endsection