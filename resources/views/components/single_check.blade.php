<div class="form-group row">
	<div class="col-md-3"></div>
	<div class="col">
		<div class="form-check">
			<input type="checkbox" name="{{$field}}" class="form-check-input" id="{{$field}}" {{ $checked == true ? 'checked':'' }} {{ isset($required) && $required == true ? 'required':'' }} {{ isset($readonly) ? 'readonly':'' }} {{ isset($disabled) ? 'disabled':''}}>
			<label for="{{ $field }}" class="form-check-label text-uppercase">{{ isset($label) ? $label:str_replace('_', ' ', $field) }}
			@isset($required)<span class="text-danger">&#8902;</span>@endisset</label>
		</div>

		@isset($help)
			@include('partials.field_help')
		@endisset

	</div>
	
</div>