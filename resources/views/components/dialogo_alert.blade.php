<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalTitulo" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="text-uppercase modal-title font-weight-bold" id="alertModalTitulo">
					{{ $titulo_alert }}
				</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="{{ __('close') }}">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				@if (isset($alert_danger))
				<div class="alert alert-danger">{{ $alert_danger }}</div>
				@elseif (isset($alert_warning))
				<div class="alert alert-warning">{{ $alert_warning }}</div>
				@endif

				<p class="lead text-uppercase text-justify">
					{{ $mensaje_alert }}
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary text-uppercase" type="button" data-dismiss="modal">{{ isset($no) ? 'no' : __('close') }}</button>
				{{ $slot }}
			</div>
		</div>
	</div>
</div>