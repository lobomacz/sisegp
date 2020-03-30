<h6 class="text-uppercase">
	{{ $programa->codigo }}
</h6>

<p class="lead mt-3 text-uppercase">
	{{ $programa->descripcion }}
</p>

<input class="d-none" type="hidden" name="programa_id" id="programa_id" value="{{ $programa->id }}">

@component('components.select', ['field' => 'unidad_gestion_id', 'size' => 'small', 'label' => __('management unit'), 'required' => true])

	@include('partials.select_option_empty')
	
	@foreach($unidades as $item)

		@include('partials.select_option', ['value_field' => 'id', 'text_field' => 'acronimo'])

	@endforeach
	
@endcomponent


{{--  

@include('partials.select', ['field' => 'unidad_gestion_id', 'size' => 'large', 'value' => null, 'idfield' => 'id', 'textfield' => 'nombre', 'label' => __('management unit'), 'required' => true, 'list' => $unidades])

--}}

