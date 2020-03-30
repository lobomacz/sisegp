<div class="dropdown-item">
	<div class="dropright">
		
		<a id="mnu{{$nestedItem}}" href="" class="nav-link menu-anidado dropdown-toggle text-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{{ __($nestedItem) }}
		</a>

		<div class="dropdown-menu" aria-labelledby="mnu{{$nestedItem}}">
			@foreach($nestedList as $nestedElement)
			<a href="{{ $nestedElement['link'] }}" class="dropdown-item">{{ __($nestedElement['label']) }}</a>
			@endforeach
		</div>
	</div>
</div>