<div class="d-table-cell">

	@isset ($label)
	    <label class="text-uppercase" for="{{ $field }}">{{ isset($label) ? $label:str_replace('_', ' ', $field) }}
			@isset($required)<span class="text-danger">&#8902;</span>@endisset
		</label>
	@endisset
	
	@if(isset($group) && $group == true)
		<div class="input-group">
			@isset ($prepend)
			    <div class="input-group-prepend">
					<span class="input-group-text{{ isset($prepend_icon) ? ' icon icon-macz-'.$prepend_icon:'' }}">
						{{ $prepend }}
					</span>
				</div>
			@endisset
			<input type="{{ $type }}" id="{{ $field }}" name="{{ $field }}" class="form-control text-right{{ $errors->has($field) ? ' is-invalid':'' }}" placeholder="{{ $placeholder }}" value="{{ $slot }}" {{ isset($required) && $required == true ? 'required':'' }} {{ isset($readonly) ? 'readonly':'' }} {{ isset($disabled) ? 'disabled':''}}>
			@isset ($append)
			    <div class="input-group-prepend">
					<span class="input-group-text{{ isset($append_icon) ? ' icon icon-macz-'.$append_icon:'' }}">
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