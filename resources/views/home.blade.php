@extends('layouts.app')

@if($menu_list != null)
	@section('toolbar')

		@foreach($menu_list as $item => $list)
			@component('components.nav_menu', ['item' => $item, 'list' => $list])
			@endcomponent
		@endforeach

	@endsection('toolbar')
@endif

@section('content')

<div class="container">
	
	<div class="row justify-content-center">

		<div class="col-md-8">
			<div class="card text-white bg-dark">
				<img src="{{ Storage::url('imgs/graccs.jpg') }}" alt="Gobierno Regional RACCS" class="card-img card-img--dark">
				<div class="card-img-overlay">
					<div class="card-header display-4 text-capitalize">{{ __('messages.homegreeting') }}</div>
					<p class="lead mt-5 card-text text-uppercase text-justify d-none d-xl-block">
						{{ __('messages.introduction') }}
					</p>
					<p class="lead mt-5 card-text text-uppercase text-justify d-none d-xl-block">
						{{ __('messages.menu_bar_use') }}
					</p>
				</div>
			</div> 
		</div>

	</div>

</div>

@endsection