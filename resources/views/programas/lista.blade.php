@extends ('layouts.app')

@if($menu_list != null)
	@section('toolbar')
		@foreach($menu_list as $item => $list)
			@component('components.nav_menu', ['item' => $item, 'list' => $list])
			@endcomponent
		@endforeach
	@endsection('toolbar')
@endif

@section ('content')

<div class="row justify-content-center">
	<div class="col-md-10">
		<div class="jumbotron">
			<h4 class="display-4 text-center text-capitalize">{{ __('messages.program_index_title') }}</h4>
			<p class="lead text-capitalize text-center">{{  __('messages.program_index_help')}}</p>
			<a title="{{ __('insert') }} {{ __('program') }}" data-toggle="tooltip" data-placement="top" href="{{ route('NuevoPrograma') }}" class="btn btn-primary icon icon-macz-plus my-2"></a>

			@if(isset($programas) && $programas->count() > 0)
				
				@unless($todos == 't')
				<a href="{{ route('ListaProgramas', ['todos' => 't', 'page' => 1]) }}" class="btn btn-link text-capitalize">{{ __('view') }}&nbsp;{{ __('all') }}</a>
				@endunless
				
				@if($todos == 't')
				<p>
					<span class="icon icon-macz-ban"></span> = 'Borrado'
				</p>
				@endif

				{{ $programas->appends(['todos' => $todos])->onEachSide(config('variables.paginas'))->links() }}

				@component('components.table')

					@slot('table_header')

						<th>#</th>
						<th class="text-uppercase">{{ __('code') }}</th>
						<th class="text-uppercase">{{ __('program') }}</th>
						<th></th>
						<th></th>
						@if($todos == 't')
						<th></th>
						@endif

					@endslot

					
					@foreach($programas as $programa)
						<tr class="rounded">
							<th scope="row">{{ $loop->iteration }}</th>
							<td class="text-uppercase">{{ $programa->codigo }}</td>
							<td class="text-uppercase">{{ $programa->acronimo }}</td>
							<td class="text-uppercase">
								<a href="{{ route('VerPrograma', ['id' => $programa->id, 'trashed' => $programa->deleted_at != null ? true:false]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="{{ __('view') }}"><span class="icon icon-macz-chevron-right"></span></a>
							</td>
							<td class="text-uppercase">
								<a href="{{ route('EditarPrograma', ['id' => $programa->id]) }}" class="btn btn-sm btn-success{{ $programa->deleted_at != null ? ' disabled':'' }}" data-toggle="tooltip" data-placement="top" title="{{ __('edit') }}"><span class="icon icon-macz-pencil"></span></a>
							</td>
							@if($todos == 't')
							<td>
								@unless($programa->deleted_at == null)
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