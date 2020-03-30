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

	
	@if(isset($programa))

	<h4 class="display-4 text-left text-uppercase mb-3">{{ __('program') }}</h4>

		@component('components.detalle', ['ruta_delete' => $ruta_delete, 'ruta_edit' => $ruta_edit, 'ruta_recycle' => $ruta_recycle, 'title' => $programa->acronimo, 'subtitle' => $programa->codigo, 'trashed' => $trashed])

			<p class="text-justify lead text-uppercase">
				{{ $programa->descripcion }}
			</p>
			
			@isset ($programa->objetivo)
			    <p class="text-justify lead text-uppercase">
					{{ $programa->objetivo }}
				</p>
			@endisset

			@unless($programa->finalizado == false)
			<h5 class="text-danger text-uppercase">{{ __('ended') }}</h5>
			@endunless
			
			@if(isset($programa->unidadesGestion) && $programa->unidadesGestion->count() > 0)
			<h5 class="text-uppercase">
				{{ __('management units') }}
			</h5>
			<ul class="list-group">
				@foreach($programa->unidadesGestion as $unidad)
				<li class="list-group-item">
					{{ $unidad->nombre }}
					@if(Auth::user()->funcionario->tienePermiso('modificar_programas') && $trashed == false)
						{{-- EL COMPONENTE list_button_post incluye un boton y un formulario el slot es la ruta del formulario --}}
						@component('components.list_button_post', ['type' => 'unlink', 'item' => $unidad->id, 'title' => __('messages.unlink_unit')])
							{{ route('DisociarUnidadPrograma', ['id' => $programa->id, 'idu' => $unidad->id]) }}
						@endcomponent
					@endif
				</li>
				@endforeach
			</ul>
			@endif

			@if(isset($ruta_link) && Auth::user()->funcionario->tienePermiso('modificar_programas'))
				@include('partials.button', ['ruta' => $ruta_link, 'titulo' => __('messages.link_unit'), 'icono' => 'link'])
			@endif

		@endcomponent

		@component('components.dialogo_alert', ['no' => true])
			@slot('titulo_alert')
				{{ __('delete') }}&nbsp;{{ __('program') }}
			@endslot

			@slot('alert_danger')
				{{ $trashed == true ? __('messsages.delete_danger'):__('messsages.trash_warning') }}
			@endslot

			@slot('mensaje_alert')
				{{ __('messages.confirm_action') }}
			@endslot
			
			<button type="button" onclick="$('#formulario').submit()" class="btn btn-primary text-uppercase">{{ __('yes') }}</button>

		@endcomponent

	@else

		<div class="alert alert-warning">
			{{ __('no data') }}
		</div>

	@endif
	

@endsection