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

	@component('components.formulario', ['ruta' => $ruta, 'id' => $proyecto->id])

		@slot('titulo_form')
			{{ __('edit') }}&nbsp;{{ __('project') }}
		@endslot

		@include('proyectos.formulario')

	@endcomponent

	@component('components.dialogo_alert')

		@slot('titulo_alert')
			{{ __('save') }}&nbsp;{{ __('changes') }}
		@endslot

		@slot('alert_warning')
			{{ __('messages.change_warning') }}
		@endslot

		@slot('mensaje_alert')
			{{ __('messsages.update_alert') }}
		@endslot

		@include('partials.submit_button', ['value' => 'OK'])

	@endcomponent

@endsection('content')