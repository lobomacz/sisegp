@extends('layouts.app')

@section('content')

<div class="container">
	
	<div class="row justify-content-center">
			
		<div class="col-md-3">
			<div class="accordion" id="mnuMenuPrincipal">
				
				@if($funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq') || $funcionario->tieneRol('digitador-presupuesto') || $funcionario->tieneRol('digitador-fin'))
				
				<div class="card">
					<div class="card-header" id="mnuIngresar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navIngresar" aria-expanded="false" aria-controls="mnuIngresar">
								{{ __('enter') }}
							</button>
						</h2>
					</div>

					<div id="navIngresar" aria-labelledBy="mnuIngresar" class="collapse show" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								@if($funcionario->tienePermiso('ingresar_programas'))
								<li class="nav-item text-uppercase">
									<a href="{{ route('NuevoPrograma') }}" class="nav-link">
										{{ __('programs') }}
									</a>
								</li>
								@endif
								@if($funcionario->tienePermiso('ingresar_proyectos'))
								<li class="nav-item text-uppercase">
									<a href="{{ route('NuevoProyecto') }}" class="nav-link">
										{{ __('projects') }}
									</a>
								</li>
								@endif
								<li class="nav-item text-uppercase">
									<a href="{{ route('NuevoResultado') }}" class="nav-link">
										{{ __('result indicators') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('product indicators') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('activities') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('plans') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('supplies requests') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@endif

			</div>
		</div>

		<div class="col-md-8">
			<div class="card bg-dark">
				<img src="{{ Storage::url('imgs/bote.jpg') }}" alt="cayuco en la bahia" class="card-img">
				<div class="card-img-overlay">
					<div class="card-header display-4 text-capitalize">
						{{ __('data input') }}
					</div>
					<p class="card-text lead text-center text-uppercase">
						{{ __('messages.digitacion_header') }}
					</p>
				</div>
			</div>
		</div>

	</div>

</div>

@endsection