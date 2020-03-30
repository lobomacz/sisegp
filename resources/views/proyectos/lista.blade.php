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

<div class="row justify-content-center">
	<div class="col-md-10">
		<div class="jumbotron">
			<h4 class="display-4 text-center text-capitalize">{{ __('messages.project_index_title') }}</h4>
			<p class="lead text-capitalize text-center">{{ __('messages.project_index_help') }}</p>
			<a href="{{ route('NuevoProyecto') }}" class="btn btn-primary icon icon-macz-plus my-2"></a>

			@if(isset($proyectos) && $proyectos->count() > 0)

				@unless($todos == 't')
					<a href="{{ route('ListaProyectos', ['todos' => 't', 'page' => 1]) }}" class="btn btn-link text-capitalize">{{ __('view') }}&nbsp;{{ __('all') }}</a>
				@endunless

				<p class="text-capitalize">
					<span class="icon icon-macz-thumbs-o-up"></span> = {{ __('executing') }}
				</p>

				@if($todos == 't')
					<p class="text-capitalize">
						<span class="icon icon-macz-thumbs-o-down"></span> = {{ __('executed') }}
					</p>
					<p class="text-capitalize">
						<span class="icon icon-macz-ban"></span> = {{ __('trashed') }}
					</p>
				@endif

				{{ $proyectos->appends(['todos' => $todos])->onEachSide(config('variables.paginas'))->links() }}

				@component('components.table')

					@slot('table_header')

						<th>#</th>
						<th class="text-uppercase">{{ __('code') }}</th>
						<th class="text-uppercase">{{ __('project') }}</th>
						<th class="text-uppercase">{{ __('sector') }}</th>
						<th class="text-uppercase">{{ __('status') }}</th>
						<th></th>
						<th></th>
						@if($todos == 't')
						<th></th>
						@endif

					@endslot

					@foreach($proyectos as $proyecto)

						<tr class="rounded">
							<th scope="row">{{ $loop->iteration }}</th>
							<td class="text-uppercase text-center">{{ $proyecto->codigo }}</td>
							<td class="text-uppercase text-center">{{ $proyecto->acronimo }}</td>
							<td class="text-uppercase text-center">{{ $proyecto->sectorDesarrollo->nombre_corto }}</td>
							<td class="text-uppercase text-center">
								@if($proyecto->ejecutado == false)
								<span class="icon icon-macz-thumbs-o-up"></span>
								@else
								<span class="icon icon-macz-thumbs-o-down"></span>
								@endif
							</td>
							<td class="text-uppercase text-center">
								<a href="{{ route('VerProyecto', ['id' => $proyecto->id, 'trashed' => $proyecto->deleted_at == null ? false:true]) }}" data-toggle="tooltip" data-placement="left" title="{{ __('view') }}" class="btn btn-sm btn-primary">
									<span class="icon icon-macz-chevron-right"></span>
								</a>
							</td>
							<td class="text-uppercase text-center">
								<a href="{{ route('EditarProyecto', ['id' => $proyecto->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('edit') }}" class="btn btn-sm btn-success{{ $proyecto->deleted_at != null ? ' disabled':'' }}">
									<span class="icon icon-macz-pencil"></span>
								</a>
							</td>
							@if($todos == 't')
							<td class="text-uppercase text-center">
								@unless($proyecto->deleted_at == null)
								<span class="icon icon-macz-ban"></span>
								@endunless
							</td>
							@endif
						</tr>

					@endforeach

				@endcomponent
			@else
				
				<h4 class="display-4 text-capitalize text-dark bg-warning">{{ __('no data') }}</h4>

			@endif

		</div>
	</div>
</div>

@endsection('content')