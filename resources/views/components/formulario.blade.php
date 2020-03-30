<div class="row justify-content-center">
	<div class="col-md-{{ isset($table) && $table == true ? '10':'8' }}">
		<h1 class="display-4 text-uppercase text-center mb-4">{{ $titulo_form }}</h1>
		
		<form id="formulario" action="{{ $ruta }}" class="pt-3" method="post">
			<p class="text-danger mb-4 text-capitalize">&#8902;{{ __('required') }}</p>

			@csrf
			
			{{ $slot }}
			
			{{-- <input type="submit" class="btn btn-primary mt-4 text-uppercase" value="{{ isset($id) ? __('update'):__('save') }}"> --}}
			
			<button class="btn btn-primary mt-4 text-uppercase" type="button" data-toggle="modal" data-target="#alertModal">
				{{ isset($id) ? __('update'):__('save') }}
			</button>
			<input type="reset" class="btn btn-secondary mt-4 text-uppercase" value="{{ __('reset') }}">
		</form>
	</div>
</div>