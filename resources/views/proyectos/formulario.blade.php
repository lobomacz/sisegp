
@isset ($proyecto->id)
    <input type="hidden" name="id" id="id" value="{{ $proyecto->id }}">
@endisset

@component('components.input', ['type' => 'text', 'field' => 'codigo', 'label' => __('code'), 'required' => true, 'size' => 'small', 'placeholder' => __('project code'), 'help' => __('messages.project_code_help'), 'disabled' => isset($trashed) ? true:false])
	{{ $proyecto->codigo }}
@endcomponent

@component('components.input', ['type' => 'text', 'size' => 'small', 'field' => 'acronimo', 'label' => __('acronym'), 'placeholder' => __('acronym'), 'required' => true, 'help' => __('messages.acronym_help'), 'disabled' => isset($trashed) ? true:false])
	{{ $proyecto->acronimo }}
@endcomponent

@component('components.select', ['field' => 'programa_id', 'size' => 'small', 'label' => __('program'), 'required' => true, 'value' => $proyecto->programa_id, 'disabled' => isset($trashed) ? true:false])

	@include('partials.select_option_empty')

	@foreach ($programas as $item)
		
		@include('partials.select_option', ['value_field' => 'id', 'text_field' => 'acronimo'])

	@endforeach

@endcomponent

@component('components.select', ['field' => 'sector_desarrollo_id', 'size' => 'small', 'label' => __('development sector', 'required' => true, 'value' => $proyecto->sector_desarrollo_id), 'disabled' => isset($trashed) ? true:false])

	@include('partials.select_option_empty')

	@foreach($sectores as $item)

		@include('partials.select_option', ['value_field' => 'id', 'text_field' => 'nombre_corto'])

	@endforeach

@endcomponent

@component('components.input', ['type' => 'text', 'size' => 'large', 'field' => 'descripcion', 'label' => __('description'), 'placeholder' => __('project description'), 'required' => true, 'disabled' => isset($trashed) ? true:false])
	{{ $proyecto->descripcion }}
@endcomponent

@component('components.text_area', ['field' => 'objetivo', 'cols' => 100, 'rows' => 10, 'label' => __('objective'), 'placeholder' => __('general objective'), 'disabled' => isset($trashed) ? true:false])
	{{ $proyecto->objetivo }}
@endcomponent

@component('components.input', ['type' => 'date', 'size' => 'small', 'field' => 'fecha_inicio', 'label' => __('starting date'), 'required' => true, 'disabled' => isset($trashed) ? true:false])
	{{ $proyecto->fecha_inicio }}
@endcomponent

@component('components.input', ['type' => 'date', 'size' => 'small', 'field' => 'fecha_final', 'label' => __('finising date'), 'disabled' => isset($trashed) ? true:false])
	{{ $proyecto->fecha_final }}
@endcomponent

@component('components.input', ['type' => 'number', 'size' => 'large', 'field' => 'presupuesto', 'required' => true, 'group' => true, 'prepend' => config('variables.simbolo_moneda'), 'placeholder' => '0.00', 'label' => __('budget'), 'disabled' => isset($trashed) ? true:false]])
	{{ $proyecto->presupuesto }}
@endcomponent

@isset ($proyecto->id)

		@component('components.single_check', ['field' => 'ejecutado', 'label' => __('executed'), 'checked' => $proyecto->ejecutado, 'disabled' => isset($trashed) ? true:false])
		@endcomponent
	    
@endisset