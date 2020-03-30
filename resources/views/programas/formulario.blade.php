
@isset($programa->id)
	<input class="d-none" type="text" name="id" id="id" value="{{ $programa->id }}" hidden>
@endisset

@component('components.input', ['type' => 'text', 'size' => 'small', 'field' => 'codigo', 'label' => __('code'),'required' => true, 'placeholder' => __('program code'), 'help' => __('messages.code_help'), 'disabled' => isset($trashed) ? true:false])
	{{ $programa->codigo }}
@endcomponent

@component('components.input', ['type' => 'text', 'size' => 'xsmall', 'field' => 'acronimo', 'label' => __('acronym'), 'placeholder' => __('acronym'), 'help' => __('messages.acronym_help'), 'required' => true, 'disabled' => isset($trashed) ? true:false])
	{{ $programa->acronimo }}
@endcomponent

@component('components.input', ['type' => 'text', 'size' => 'large', 'field' => 'descripcion', 'label' => __('description'), 'placeholder' => __('program description'), 'required' => true, 'disabled' => isset($trashed) ? true:false])
	{{ $programa->descripcion }}
@endcomponent

@component('components.text_area', ['cols' => 100, 'rows' => 10, 'field' => 'objetivo', 'label' => __('objective'), 'placeholder' => __('general objective'), 'disabled' => isset($trashed) ? true:false])
	{{ $programa->objetivo }}
@endcomponent

@isset($programa->id)

	@component('components.single_check', ['field' => 'finalizado', 'label' => __('ended'), 'checked' => $programa->finalizado, 'disabled' => $programa->finalizado, 'help' => __('messages.ended_check_help'), 'disabled' => isset($trashed) ? true:false] )
	@endcomponent

	@component('components.input', ['type' => 'date', 'field' => 'fecha_finalizado', 'label' => __('date ended'), 'size' => 'small', 'placeholder' => '', 'readonly' => $programa->finalizado, 'help' => __('messages.ended_date_help'), 'disabled' => isset($trashed) ? true:false])
	{{ $programa->fecha_finalizado }}
	@endcomponent

@endisset
