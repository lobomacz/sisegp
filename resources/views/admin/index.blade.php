@extends('layouts.app')

@section('content')

<div class="container ">
	<div class="row justify-content-center">
		<div class="col-md-3">
			<div class="accordion" id="mnuMenuPrincipal">
				<div class="card">
					<div class="card-header" id="mnuFuncionarios">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navFuncionarios" aria-expanded="false" aria-controls="mnuFuncionarios">
								{{ __('officials') }}
							</button>
						</h2>
					</div>

					<div id="navFuncionarios" class="collapse" aria-labelledby="mnuFuncionarios" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase"><a href="{{ route('AdminFuncionarios') }}" class="nav-link">
									{{ __('list') }}
								</a></li>
								<li class="nav-item text-uppercase"><a href="{{ route('NuevoFuncionario') }}" class="nav-link">
									{{ __('new') }}
								</a></li>
								
							</ul>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header" id="mnuUsuarios">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navUsuarios" aria-expanded="false" aria-controls="mnuUsuarios">
								{{ __('users') }}
							</button>
						</h2>
					</div>

					<div id="navUsuarios" class="collapse" aria-labelledby="mnuUsuarios" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('AdminUsuarios') }}" class="nav-link">
										{{ __('list') }}
									</a></li>
								<li class="nav-item text-uppercase">
									<a href="{{ route('NuevoUsuario') }}" class="nav-link">
										{{ __('new') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header" id="mnuProgramas">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navProgramas" aria-expanded="false" aria-controls="mnuProgramas">
								{{ __('programs') }}
							</button>
						</h2>
					</div>

					<div id="navProgramas" class="collapse" aria-labelledby="mnuProgramas" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('AdminProgramas') }}" class="nav-link">
										{{ __('list') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="{{ route('NuevoPrograma') }}" class="nav-link">
										{{ __('new') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header" id="mnuProyectos">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navProyectos" aria-expanded="false" aria-controls="mnuProyectos">
								{{ __('projects') }}
							</button>
						</h2>
					</div>

					<div id="navProyectos" class="collapse" aria-labelledby="mnuProyectos" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('AdminProyectos') }}" class="nav-link">
										{{ __('list') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="{{ route('NuevoProyecto') }}" class="nav-link">
										{{ __('new') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header" id="mnuMaestros">
						<h2 class="mb-0">
							<button class="btn btn-link text-uppercase" type="button" data-toggle="collapse" data-target="#navMaestros" aria-expanded="false" aria-controls="mnuMaestros">
								{{ __('source tables') }}
							</button>
						</h2>
					</div>

					<div id="navMaestros" class="collapse" aria-labelledby="mnuMaestros" data-parent="#mnuMenuPrincipal">
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item text-uppercase">
									<a href="{{ route('AdminMaestros') }}" class="nav-link">
										{{ __('expense classifier') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('communities') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('structures') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('supplies') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('municipalities') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('periods') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('development sectors') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('management units') }}
									</a>
								</li>
								<li class="nav-item text-uppercase">
									<a href="" class="nav-link">
										{{ __('units of measurement') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="card text-white bg-dark">
				<img src="{{ Storage::url('imgs/amanecer.jpg') }}" alt="Motonave Río Escondido" class="card-img">
				<div class="card-img-overlay">
					<div class="card-header display-4 text-capitalize">{{ __('Dashboard') }}</div>
					<p class="lead card-text text-center text-uppercase">
						{{ __('messages.admin_dashboard') }}
					</p>
				</div>
			</div> 
		</div>
	</div>
</div>

@endsection