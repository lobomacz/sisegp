<div class="from-group row">
	<label for="{{ $field }}" class="text-uppercase col-md-3 col-form-label">
		{{ isset($label) ? $label:str_replace('_', ' ', $field) }}
		@isset($required)<span class="text-danger">&#8902;</span>@endisset
	</label>
	<div class="col{{ $size == 'small' ? '-md-4':'' }}">
		
		<select name="{{ $field }}" id="{{ $field }}" class="form-control{{ $errors->has($field) ? ' is-invalid':'' }}" {{ isset($required) && $required == true ? 'required':'' }} {{ isset($readonly) && $readonly == true ? 'readonly' }} {{ isset($disabled) && $disabled == true ? 'disabled':'' }} {{ isset($multiple) && $multiple == true ? 'multiple':''}}>
			{{ $slot }}
		</select>

		@if($errors->has($field))
			@include('partials.field_error')
		@endif

		@isset($help)
			@include('partials.field_help')
		@endisset

	</div>
</div>