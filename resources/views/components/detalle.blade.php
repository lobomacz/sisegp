<div class="row justify-content-center">
	<div class="col-md-4">
		<div class="card mt-4 text-left">
			<div class="card-body">
				<h4 class="card-title display-4">{{ $title }}</h4>
				@isset($subtitle)
				<h6 class="card-subtitle text-muted mb-2">{{ $subtitle }}</h6>
				@endisset

				{{ $slot }}
				
				<a href="{{ $ruta_edit }}" data-toggle="tooltip" data-placement="top" class="card-link text-uppercase btn btn-info{{ isset($trashed) && $trashed == true ? ' disabled':'' }}" title="{{ __('edit') }}"><span class="icon icon-macz-pencil"></span></a>
				@if(isset($trashed) && $trashed == true)
				<a href="{{ $ruta_recycle }}" data-toggle="tooltip" data-placement="top" title="{{ __('recycle') }}" class="card-link btn btn-secondary"><span class="icon icon-macz-recycle"></span></a>
				@endif
				<button type="button"  class="btn btn-danger card-link text-uppercase" data-toggle="modal" data-target="#alertModal"><span data-toggle="tooltip" data-placement="top" title="{{ __('delete') }}" class="icon icon-macz-times"></span></button>
				<form id="formulario" action="{{ $ruta_delete }}" method="post" class="d-none">
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>

