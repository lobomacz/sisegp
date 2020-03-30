@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="jumbotron">
				<h1 class="display-4 text-danger">ERROR!</h1>
				<p class="lead">{{ __('messages.critical_error') }}</p>
			</div>
		</div>
	</div>
@endsection