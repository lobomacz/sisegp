<div class="form-group row">
	<label class="text-uppercase col-md-3 col-form-label" for="{{ $field }}">{{ isset($label) ? $label:str_replace('_', ' ', $field) }}
		@isset($required)<span class="text-danger">&#8902;</span>@endisset
	</label>
	<div class="col{{ $size == 'small' ? '-md-4':''  }}{{ $size == 'xsmall' ? '-md-3':'' }}">
		@if(isset($group) && $group == true)
		<div class="input-group">
			@isset ($prepend)
			    <div class="input-group-prepend">
					<span class="input-group-text">
						{{ $prepend }}
					</span>
				</div>
			@endisset
			<input type="{{ $type }}" id="{{ $field }}" name="{{ $field }}" class="form-control text-right{{ $errors->has($field) ? ' is-invalid':'' }}" placeholder="{{ $placeholder }}" value="{{ $slot }}" {{ isset($required) && $required == true ? 'required':'' }} {{ isset($readonly) ? 'readonly':'' }} {{ isset($disabled) ? 'disabled':''}}>
			@isset ($append)
			    <div class="input-group-prepend">
					<span class="input-group-text">
						{{ $append }}
					</span>
				</div>
			@endisset
		</div>
		@else
		<input type="{{ $type }}" id="{{ $field }}" name="{{ $field }}" class="form-control text-uppercase{{ $errors->has($field) ? ' is-invalid':'' }}" placeholder="{{ $placeholder }}" value="{{ $slot }}" {{ isset($required) && $required == true ? 'required':'' }} {{ isset($readonly) ? 'readonly':'' }} {{ isset($disabled) ? 'disabled':''}}>
		@endif
		

		@if($errors->has($field))
			@include('partials.field_error')
		@endif
		
		@isset($help)
			@include('partials.field_help')
		@endisset
	</div>
</div>