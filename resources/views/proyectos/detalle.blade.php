@extends('layouts.app')

@isset($menu_list)
	@section('toolbar')
		@foreach($menu_list as $item => $list)
			@component('components.nav_menu', ['item' => $item, 'list' => $list])
			@endcomponent
		@endforeach
	@endsection('toolbar')
@endisset


@if(isset($proyecto))
	@section('content')
		
		<h4 class="display-4 text-uppercase text-left mb-3">{{ __('project') }}</h4>

		@component('components.detalle', ['title' => $proyecto->acronimo, 'subtitle' => $proyecto->codigo, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'ruta_link' => $ruta_link, 'ruta_recycle' => $ruta_recycle, 'trashed' => $trashed])

			<p class="lead text-uppercase text-justify">
				{{ $proyecto->descripcion }}
			</p>
			
			@isset ($proyecto->objetivo)
			    <p class="lead text-uppercase text-justify">
					{{ $proyecto->objetivo }}
				</p>
			@endisset

			<dl>
				<dt class="text-uppercase">
					{{ __('sector') }}
				</dt>
				<dd class="text-uppercase">
					{{ $proyecto->sectorDesarrollo->nombre }}
				</dd>
				@isset ($proyecto->fecha_inicio)
				<dt class="text-uppercase">
					{{ __('start date') }}
				</dt>
				<dd>
					{{ $proyecto->fecha_inicio }}
				</dd>
				@endisset
				@isset ($proyecto->fecha_final)
				<dt class="text-uppercase">
					{{ __('finish date') }}
				</dt>
				<dd>
					{{ $proyecto->fecha_final }}
				</dd>
				@endisset
			</dl>

			@unless ($proyecto->ejecutado == false)
				<h5 class="text-danger text-uppercase">
					{{ __('executed') }}
				</h5>
			@endunless	

			@if (isset($trashed) && $trashed == true)
				<div class="alert alert-danger text-uppercase">
					{{ __('messages.trashed_record') }}&nbsp;<span class="icon icon-macz-trash"></span>
				</div>
			@endif

			<div class="alert alert-info" role="alert">
				<h4 class="alert-heading text-uppercase">
					{{ __('budget') }}
				</h4>
				<div class="display-4">
					{{ config('variables.simbolo_moneda') }}&nbsp;{{ $proyecto->presupuesto }}
				</div>
			</div>

			{{-- INDICADORES DE RESULTADO ASOCIADOS AL PROYECTO --}}

			<h5 class="text-uppercase">
				<span class="icon icon-macz-line-chart"></span>&nbsp;{{ __('result indicators') }}
			</h5>

			<a href="{{ route('IngresarResultadosProyecto', ['id' => $proyecto->id]) }}" class="btn btn-primary text-capitalize" role="button">
				<span class="icon icon-macz-plus"></span>&nbsp;{{ __('insert') }}
			</a>

			@if(isset($proyecto->resultados) && $proyecto->resultados->count() > 0)
				
				<ul class="list-group">

					@foreach($proyecto->resultados as $resultado)
						
						<li class="list-group-item text-uppercase">
							{{ $resultado->codigo }}&nbsp;{{ substr($resultado->descripcion,0,15) }}&nbsp;<a href="{{ route('VerResultado', ['id' => $resultado->id]) }}" class="btn btn-outline-secondary"><span class="icon icon-macz-eye"></span></a>
						</li>

					@endfor

				</ul>
				
			@else

				<p class="display-4 text-info">
					{{ __('no data') }}
				</p>

			@endif
			
			{{-- SI TIENE UNIDADES ASOCIADAS, SE MUESTRA LA LISTA --}}

			<h5 class="text-uppercase">
				<span class="icon icon-macz-suitcase"></span>&nbsp;{{ __('management units') }}
			</h5>
			@if(isset($proyecto->unidadesGestion) && $proyecto->unidadesGestion->count() > 0)

				<ul class="list-group">
					@foreach ($proyecto->unidadesGestion as $unidad)
						<li class="list-group-item">
							{{ $unidad->nombre }}
							@if (Auth::user()->funcionario->tienePermiso('modificar_proyectos') && $trashed == false && $proyecto->finalizado == false)
								@component('components.list_button_post', ['type' => 'unlink', 'item' => $unidad->id, 'title' => __('messages.unlink_unit')])
								{{ route('DisociarProyectoUnidad', ['id' => $proyecto->id, 'idu' => $unidad->id]) }}
								@endcomponent
							@endif
						</li>
					@endforeach
				</ul>

			@else

				<p class="display-4 text-info">
					{{ __('no data') }}
				</p>

			@endif
			
			{{-- LISTA DE LAS COMUNIDADES DONDE TIENE PRESENCIA EL PROYECTO --}}
			@if (isset($proyecto->comunidades) && $proyecto->comunidades->count() > 0)

				<h5 class="text-uppercase">
					<span class="icon icon-macz-home"></span>&nbsp;{{ __('communities') }}
				</h5>
				
				<ul class="list-group">
					@foreach ($proyecto->comunidades as $comunidad)
						<li class="list-group-item text-uppercase">
							{{ $comunidad->nombre }}
							@if (Auth::user()->funcionario->tienePermiso('modificar_proyectos') && $trashed == false && $proyecto->finalizado == false)
								@component('components.list_button_post', ['type' => 'unlink', 'item' => $comunidad->id, 'title' => __('messages.unlink_community')])
								{{ route('DisociarProyectoComunidad', ['id' => $proyecto->id, 'idc' => $comunidad->id]) }}
								@endcomponent
							@endif
						</li>
					@endforeach
				</ul>

			@endif

			@if (isset($ruta_comunidad) && Auth::user()->funcionario->tienePermiso('modificar_proyectos'))
				@include('partials.button', ['ruta' => $ruta_comunidad, 'titulo' => __('messages.link_community'), 'icono' => 'thumb-tack'])
			@endif

			@if(isset($ruta_link) && Auth::user()->funcionario->tienePermiso('modificar_proyectos'))
				@include('partials.button', ['ruta' => $ruta_link, 'titulo' => __('messages.link_unit'), 'icono' => 'link'])
			@endif

		@endcomponent

		@component('components.dialogo_alert', ['no' => true])

			@slot('titulo_alert')
			    {{ __('delete') }}&nbsp;{{ __('project') }}
			@endslot

			@slot('alert_danger')
			    {{ $trashed == true ? __('messages.delete_danger'):__('messages.trash_warning') }}
			@endslot

			@slot('mensaje_alert')
			    {{ __('messages.confirm_action') }}
			@endslot

			<button class="btn btn-primary text-uppercase" type="button" onclick="$('#formulario').submit()">
				{{ __('yes') }}
			</button>

		@endcomponent

	@endsection('content')

@else

	<div class="alert alert-warning">
		{{ __('no data') }}
	</div>

@endif