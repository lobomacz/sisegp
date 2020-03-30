<h6 class="text-uppercase">{{ $programa->codigo_programa }}</h6>

<p class="lead mt-3">{{ $programa->descripcion }}</p>

<input class="d-none" type="text" id="id_programa" value="{{ $programa->id }}" hidden>

@include('partials.select', ['field' => 'unidad_gestion_id', 'size' => 'large', 'value' => null, 'idfield' => 'id', 'textfield' => 'nombre', 'label' => __('management unit'), 'required' => true, 'list' => $unidades])

