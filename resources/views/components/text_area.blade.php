<div class="form-group row">
	<label for="{{$field}}" class="text-uppercase col-md-3 col-form-label">{{ $label }}
		@isset($required)<span class="text-danger">&#8902;</span>@endisset
	</label>
	<div class="col">
		<textarea placeholder="{{ $placeholder }}" name="{{$field}}" id="{{$field}}" cols="{{ isset($cols) ? $cols:10 }}" rows="{{ isset($rows) ? $rows:10 }}" class="form-control text-uppercase{{ $errors->has($field) ? ' is-invalid':'' }}" {{ isset($required) && $required == true ? 'required':'' }} {{ isset($readonly) ? 'readonly':'' }} {{ isset($disabled) ? 'disabled':''}}>
			{{ $slot }}
		</textarea>
		@if($errors->has($field))
			@include('partials.field_error')
		@endif
		@isset($help)
			@include('partials.field_help')
		@endisset
	</div>
</div>