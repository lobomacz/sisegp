<h6 class="text-uppercase">
	{{ $proyecto->codigo }}
</h6>
<p class="lead mt-3 text-uppercase">
	{{ $proyecto->descripcion }}
</p>

<input class="d-none" type="hidden" name="proyecto_id" id="proyecto_id" value="{{ $proyecto->id }}">

@component('components.select', ['field' => 'unidad_gestion_id', 'size' => 'small', 'label' => __('management unit'), 'required' => true])

	@include('partials.select_option_empty')
	
	@foreach($unidades as $item)

		@include('partials.select_option', ['value_field' => 'id', 'text_field' => 'acronimo'])
		
	@endforeach

@endcomponent

