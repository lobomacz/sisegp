<a href="#" 
onclick="event.preventDefault();$('#form-{{ $item }}').submit();" data-toggle="tooltip" data-placement="top" title="{{ $title }}" class="btn btn-link-secondary btn-sm d-inline-block text-uppercase float-right">
@switch($type)
	@case('unlink')
	<span class="icon icon-macz-chain-broken"></span>
	@break
	@case('remove')
	<span class="icon icon-macz-minus"></span>
	@break
@endswitch
</a>
<form id="form-{{ $item }}" action="{{ $slot }}" method="post" class="d-none">
	@csrf
</form>