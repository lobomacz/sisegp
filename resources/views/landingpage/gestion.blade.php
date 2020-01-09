@extends('layouts.app')

@section('content')

<div class="container">
	
	<div class="row justify-content-center">
		<div class="col-md-3">
			<div class="accordion" id="mnuMenuPrincipal">

				@if($funcionario->tieneRol('director') || $funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('director-ejecutivo'))
				<div class="card">
					<div class="card-header" id="mnuAprobar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navAprobar" aria-expanded="false" aria-controls="mnuAprovar">
								{{ __('approve') }}
							</button>
						</h2>
					</div>

					<div id="navAprobar" class="collapse" aria-labelledby="mnuAprobar" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndiceResultados') }}" class="nav-link">
										{{ __('results') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndiceProductos') }}" class="nav-link">
										{{ __('products') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndiceActividades') }}" class="nav-link">
										{{ __('activities') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndicePlanes') }}" class="nav-link">
										{{ __('plans') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@endif
				
				@if($funcionario->tieneRol('director-ejecutivo'))
				<div class="card">
					<div class="card-header" id="mnuAutorizar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navAutorizar" aria-expanded="false" aria-controls="mnuAutorizar">
								{{ __('authorize') }}
							</button>
						</h2>
					</div>

					<div id="navAutorizar" class="collapse" aria-labelledby="mnuAutorizar" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndiceSolicitudes') }}" class="nav-link">
										{{ __('supplies requests') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@endif
				
				@if($funcionario->tieneRol('director') || $funcionario->tieneRol('director-seplan'))
				<div class="card">
					<div class="card-header" id="mnuRevisar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navRevisar" aria-expanded="false" aria-controls="mnuRevisar">
								{{ __('review') }}
							</button>
						</h2>
					</div>

					<div id="navRevisar" class="collapse" aria-labelledby="mnuRevisar" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndiceSolicitudes') }}" class="nav-link">
										{{ __('supplies requests') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@endif
				
				@if($funcionario->tieneRol('director') || $funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('director-ejecutivo'))
				<div class="card">
					<div class="card-header" id="mnuCancelar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navCancelar" aria-expanded="false" aria-controls="mnuCancelar">
								{{ __('cancel') }}
							</button>
						</h2>
					</div>

					<div id="navCancelar" class="collapse" aria-labelledby="mnuCancelar" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									{{-- Pendiente de definir la ruta para cancelar actividades --}}
									<a href="#" class="nav-link">
										{{ __('activities') }}
									</a>
								</li>
								@if($funcionario->tienePermiso('anular_solicitudes'))
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndiceSolicitudes') }}" class="nav-link">
										{{ __('supplies requests') }}
									</a>
								</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
				@endif
				
				@if($funcionario->tieneRol('director-seplan'))
				<div class="card">
					<div class="card-header" id="mnuCerrar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navCerrar" aria-expanded="false" aria-controls="mnuCerrar">
								{{ __('close') }}
							</button>
						</h2>
					</div>

					<div id="navCerrar" class="collapse" aria-labelledby="mnuCerrar" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('IndicePlanes') }}" class="nav-link">
										{{ __('plans') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@endif
				
				@if($funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq') || $funcionario->tieneRol('digitador-presupuesto') || $funcionario->tieneRol('digitador-fin'))
				<div class="card">
					<div class="card-header" id="mnuIngresar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navIngresar" aria-expanded="false" aria-controls="mnuIngresar">
								{{ __('enter') }}
							</button>
						</h2>
					</div>

					<div id="navIngresar" aria-labelledBy="mnuIngresar" class="collapse" data-parent="#mnuMenuPrincipal">
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
				
				@if($funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq') || $funcionario->tieneRol('digitador-presupuesto') || $funcionario->tieneRol('digitador-fin'))
				<div class="card">
					<div class="card-header" id="mnuModificar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navModificar" aria-expanded="false" aria-controls="mnuModificar">
								{{ __('modify') }}
							</button>
						</h2>
					</div>

					<div id="navModificar" aria-labelledBy="mnuModificar" class="collapse" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								@if($funcionario->tienePermiso('modificar_programas'))
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('programs') }}
									</a>
								</li>
								@endif
								@if($funcionario->tienePermiso('modificar_proyectos'))
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('projects') }}
									</a>
								</li>
								@endif
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
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
				

				@if($funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq') || $funcionario->tieneRol('digitador-presupuesto') || $funcionario->tieneRol('digitador-fin'))
				<div class="card">
					<div class="card-header" id="mnuEliminar">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navEliminar" aria-expanded="false" aria-controls="mnuEliminar">
								{{ __('delete') }}
							</button>
						</h2>
					</div>

					<div id="navEliminar" aria-labelledBy="mnuEliminar" class="collapse" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
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
								@if($funcionario->tienePermiso('eliminar_planes'))
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('plans') }}
									</a>
								</li>
								@endif
								
							</ul>
						</div>
					</div>
				</div>
				@endif

				@if($funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq') || $funcionario->tieneRol('digitador-presupuesto') || $funcionario->tieneRol('digitador-fin'))
				<div class="card">
					<div class="card-header" id="mnuOtros">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navOtros" aria-expanded="false" aria-controls="mnuOtros">
								{{ __('other') }}
							</button>
						</h2>
					</div>

					<div id="navOtros" aria-labelledBy="mnuOtros" class="collapse" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('execute') }} {{ __('activities') }}
									</a>
								</li>
								@if($funcionario->tienePermiso('verificar_presupuesto'))
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('check') }} {{ __('budget') }}
									</a>
								</li>
								@endif
								@if($funcionario->tienePermiso('recibir_solicitudes'))
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('receive') }} {{ __('supplies requests') }}
									</a>
								</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
				@endif

			</div>
		</div>

		<div class="col-md-8">
			<div class="card text-white bg-dark">
				<img src="{{ Storage::url('imgs/graccs.jpg') }}" alt="Gobierno Regional RACCS" class="card-img">
				<div class="card-img-overlay">
					<div class="card-header display-4 text-capitalize">{{ __('management') }}</div>
					<p class="lead card-text text-center text-uppercase">
						{{ __('messages.manage_dashboard') }}
					</p>
				</div>
			</div> 
		</div>
	</div>

</div>

@endsection