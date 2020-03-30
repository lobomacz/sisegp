<li class="nav-item dropdown text-uppercase">
	<a id="mnu{{ $item }}" href="#" class="nav-link text-uppercase dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{{ __($item) }}
	</a>

	<div class="dropdown-menu" aria-labelledby="mnu{{ $item }}">
		@foreach($list as $element)

			@if(is_array($element['link']))
				@component('components.menu_anidado',['nestedItem' => $element['label'], 'nestedList' => $element['link']])
				@endcomponent
			@else
			<a href="{{ $element['link'] }}" class="dropdown-item">{{ __($element['label']) }}</a>
			@endif
		
		@endforeach
	</div>
</li>