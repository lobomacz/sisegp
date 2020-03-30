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

	@component('components.formulario', ['ruta' => $ruta, 'id' => $programa->id])

		@slot('titulo_form')
			{{ __('edit') }}&nbsp;{{ __('program') }}
		@endslot

		@include('programas.formulario')

	@endcomponent

	@component('components.dialogo_alert')

		@slot('titulo_alert')
			{{ __('save') }}&nbsp;{{ isset($programa->id) ? __('changes'):__('data') }}
		@endslot

		@slot('alert_warning')
			{{ __('messages.change_warning') }}
		@endslot

		@slot('mensaje_alert')
			{{ __('messages.update_alert') }}
		@endslot

		@include('partials.button_submit', ['value' => 'OK'])

	@endcomponent

@endsection