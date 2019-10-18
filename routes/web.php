<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//RUTAS ADMINISTRATIVAS

Route::get('/administrar', 'AdminController@index')->name('AdminDashboard');

Route::get('/administrar/usuarios/{todos?}', 'AdminController@usuarios')->name('AdminUsuarios');

/*
Route::get('/administrar/usuarios/nuevo', 'AdminController@nuevoUsuario')->name('NuevoUsuario');

Route::get('/administrar/usuarios/{id}/ver', 'AdminController@verUsuario')->where('id','[0-9]+')->name('DetalleUsuario');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/editar', 'AdminController@editarUsuario')->where('id','[0-9]+')->name('EditarUsuario');

Route::get('/administrar/usuarios/{id}/eliminar', 'AdminController@emilinarUsuario')->where('id','[0-9]+')->name('EliminarUsuario')
*/

Route::get('/administrar/funcionarios/{todos?}', 'AdminController@funcionarios')->name('AdminFuncionarios');

Route::get('/administrar/programas/{todos?}', 'AdminController@programas')->name('AdminProgramas');

Route::get('/administrar/proyectos/{todos?}', 'AdminController@proyectos')->name('AdminProyectos');

Route::get('/administrar/tablas', 'AdminController@maestros')->name('AdminMaestros');

//RUTAS DE LISTADOS MAESTROS

Route::resources([
	'clasificadores' => 'Admin\ClasificadorController',
	'comunidades' => 'Admin\ComunidadController',
	'documentos' => 'Admin\DocumentoController',
	'estructuras' => 'Admin\EstructuraController',
	'fotos' => 'Admin\FotoController',
	'insumos' => 'Admin\InsumoController',
	'municipios' => 'Admin\MunicipioController',
	'periodos' => 'Admin\PeriodoController',
	'sector-desarrollo' => 'Admin\SectorDesarrolloController',
	'unidad-gestions' => 'Admin\UnidadGestionController',
	'unidad-medidas' => 'Admin\UnidadMedidaController',
]);

//RUTAS DE ADMINISTRACIÓN DE USUARIOS

Route::match(['get', 'post'], '/administrar/usuarios/nuevo', 'Admin\UsuarioController@nuevo')->name('NuevoUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

Route::get('/administrar/usuarios/{id}/ver', 'Admin\UsuarioController@ver')->where('id', '[0-9]+')->name('DetalleUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/editar', 'Admin\UsuarioController@editar')->where('id', '[0-9]+')->name('UpdateUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/eliminar', 'Admin\UsuarioController@eliminar')->where('id', '[0-9]+')->name('EliminarUsuario')->middleware('auth', 'check.rol:superusuario');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/desactivar', 'Admin\UsuarioController@desactivar')->where('id', '[0-9]+')->name('DesactivarUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

//RUTAS DE ADMINISTRACION DE FUNCIONARIOS

Route::match(['get', 'post'], '/administrar/funcionarios/nuevo', 'FuncionarioController@nuevo')->name('NuevoFuncionario')->middleware('auth', 'checl.rol:superusuario');

Route::get('/administrar/funcionarios/{id}/ver', 'FuncionarioController@ver')->where('id', '[0-9]+')->name('DetalleFuncionario')->middleware('auth');

Route::match(['get', 'post'], '/administrar/funcionarios/{id}/editar', 'FuncionarioController@editar')->where('id', '[0-9]+')->name('EditarFuncionario')->middleware('auth', 'check.rol:superusuario');

Route::match(['get', 'post'], '/administrar/funcionarios/{id}/desactivar', 'FuncionarioController@desactivar')->where('id', '[0-9]+')->name('DesactivarFuncionario')->middleware('auth', 'check.rol:superusuario');

Route::match(['get', 'post'], '/administrar/funcionarios/{id}/eliminar', 'FuncionarioController@eliminar')->where('id', '[0-9]+')->name('EliminarFuncionario')->middleware('auth', 'check.rol:superusuario');

//RUTAS ADMINISTRACION DE PROGRAMAS

//Route::get('/programas', 'Admin\ProgramaController@index')->name('IndiceProgramas');

Route::get('/programas/{id}/ver', 'Admin\ProgramaController@ver')->where('id', '[0-9]+')->name('VerPrograma')->middleware('auth');

Route::match(['get', 'post'], '/programas/nuevo', 'Admin\ProgramaController@nuevo')->name('NuevoPrograma')->middleware('auth','check.permissions:ingresar_programas');

Route::match(['get', 'post'], '/programas/{id}/editar', 'Admin\ProgramaController@editar')->where('id', '[0-9]+')->name('EditarPrograma')->middleware('auth', 'check.permissions:modificar_programas');

Route::match(['get', 'post'], '/programas/{id}/unidad-gestion', 'Admin\ProgramaController@asociar')->where('id', '[0-9]+')->name('AsociarPrograma')->middleware('auth', 'check.permissions:modificar_programas');

Route::match(['get', 'post'], '/programas/{id}/unidad-gestion/remover', 'Admin\ProgramaController@disociar')->where('id', '[0-9]+')->name('DisociarPrograma')->middleware('auth', 'check.permissions:modificar_programas');

Route::match(['get', 'post'], '/programas/{id}/eliminar', 'Admin\ProgramaController@eliminar')->where('id', '[0-9]+')->name('EliminarPrograma')->middleware('auth', 'check.rol:superusuario');

//RUTAS DE ADMINISTRACION DE PROYECTOS

//Route::get('/proyectos', 'Admin\ProyectoController@index')->name('IndiceProyectos');

Route::get('/proyectos/{id}/ver', 'Admin\ProyectoController@ver')->where('id', '[0-9]+')->name('VerProyecto')->middleware('auth');

Route::match(['get', 'post'], '/proyectos/nuevo', 'Admin\ProyectoController@nuevo')->name('NuevoProyecto')->middleware('auth', 'check.permissions:ingresar_proyectos');

Route::match(['get', 'post'], '/proyectos/{id}/editar', 'Admin\ProyectoController@editar')->where('id', '[0-9]+')->name('EditarProyecto')->middleware('auth', 'check.permissions:modificar_proyectos');

Route::match(['get', 'post'], '/proyectos/{id}/unidad-gestion', 'Admin\ProyectoController@asociar')->where('id', '[0-9]+')->name('AsociarProyecto')->middleware('auth', 'check.permissions:modificar_proyectos');

Route::match(['get', 'post'], '/proyectos/{id}/unidad-gestion/remover', 'Admin\ProyectoController@disociar')->where('id', '[0-9]+')->name('DisociarProyecto')->middleware('auth', 'check.permissions:modificar_proyectos');

Route::match(['get', 'post'], '/proyectos/{id}/eliminar', 'Admin\ProyectoController@eliminar')->where('id', '[0-9]+')->name('EliminarProyecto')->middleware('auth', 'check.rol:superusuario');

//RUTAS DE ADMINISTRACION DE INDICADORES DE RESULTADO DE PROYECTOS

Route::get('/resultados', 'MPMP\ResultadoController@index')->name('IndiceResultados')->middleware('auth');

Route::post('/resultados/proyecto', 'MPMP\ResultadoController@resultadosProyecto')->name('ResultadosProyecto')->middleware('auth');

Route::post('/resultados/unidad-gestion', 'MPMP\ResultadoController@resultadosUnidad')->name('ResultadosUnidad')->middleware('auth');

Route::match(['get', 'post'], '/resultados/nuevo', 'MPMP\ResultadoController@nuevo')->name('NuevoResultado')->middleware('auth', 'check.permissions:ingresar_resultados');

Route::get('/resultados/{id}/ver', 'MPMP\ResultadoController@ver')->where('id', '[0-9]+')->name('VerResultado')->middleware('auth');

Route::get('/resultados/{id}/aprobar', 'MPMP\ResultadoController@aprobar')->where('id', '[0-9]+')->name('AprobarResultado')->middleware('auth', 'check.permissions:aprobar_resultados');

Route::match(['get', 'post'], '/resultados/{id}/editar', 'MPMP\ResultadoController@editar')->where('id', '[0-9]+')->name('EditarResultado')->middleware('auth', 'check.permissions:modificar_resultados');

Route::match(['get', 'post'], '/resultados/{id}/eliminar', 'MPMP\ResultadoController@eliminar')->where('id', '[0-9]+')->name('EliminarResultado')->middleware('auth', 'eliminar_resultados');

//RUTAS DE ADMINISTRACION DE INDICADORES DE PRODUCTO DE PROYECTOS

Route::get('/resultados/{id}/productos', 'MPMP\ProductoController@index')->name('IndiceProductos')->middleware('auth');

Route::match(['get', 'post'], '/resultados/{id}/productos/nuevo', 'MPMP\ProductoController@nuevo')->name('NuevoProducto')->middleware('auth', 'check.permissions:ingresar_productos');

Route::get('/resutlados/{id}/productos/{id_prod}/ver', 'MPMP\ProductoController@ver')->where('id', '[0-9]+')->name('VerProducto')->middleware('auth');

Route::match(['get', 'post'], '/resultados/{id}/productos/{id_prod}/editar', 'MPMP\ProductoController@editar')->where('id', '[0-9]+')->name('EditarProducto')->middleware('auth', 'check.permissions:modificar_productos');

Route::match(['get', 'post'], '/resultados/{id}/productos/{id_prod}/eliminar', 'MPMP\ProductoController@eliminar')->where('id', '[0-9]+')->name('EliminarProducto')->middleware('auth', 'check.permissions:eliminar_productos');

Route::get('/resultados/{id}/productos/{id_prod}/aprobar', 'MPMP\ProductoController@aprobar')->where('id', '[0-9]+')->name('AprobarProducto')->middleware('auth', 'check.permissions:aprobar_productos');

// RUTAS PARA PROCESAR DATOS DE ACTIVIDADES POR INDICADOR DE PRODUCTO

Route::get('/producto/{id}/actividades', 'MPMP\ActividadController@index')->where('id', '[0-9]+')->name('IndiceActividades')->middleware('auth');

Route::match(['get', 'post'], '/producto/{id}/actividades/nuevo', 'MPMP\ActividadController@nuevo')->where('id', '[0-9]+')->name('NuevaActividad')->middleware('auth', 'check.permissions:ingresar_actividades');

Route::get('/producto/{id}/actividades/{id_act}/ver', 'MPMP\ActividadController@ver')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('VerActividad')->middleware('auth');

Route::match(['get', 'post'], '/producto/{id}/actividades/{id_act}/editar', 'MPMP\ActividadController@editar')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('EditarActividad')->middleware('auth', 'check.permissions:modificar_actividades');

Route::get('/producto/{id}/actividades/{id_act}/aprobar', 'MPMP\ActividadController@acciones')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('AprobarActividad')->middleware('auth', 'check.permissions:aprobar_actividades');

Route::get('/producto/{id}/actividades/{id_act}/cancelar', 'MPMP\ActividadController@acciones')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('CancelarActividad')->middleware('auth', 'check.permissions:cancelar_actividades');

Route::get('/producto/{id}/actividades/{id_act}/ejecutar', 'MPMP\ActividadController@acciones')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('EjecutarActividad')->middleware('auth', 'check.permissions:ejecutar_actividades');

Route::match(['get', 'post'], '/producto/{id}/actividades/{id_act}/eliminar', 'MPMP\ActividadController@eliminar')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('EliminarActividad')->middleware('auth', 'check.permissions:eliminar_actividades');

Route::match(['get', 'post'], '/producto/{id}/actividades/{id_act}/insumos', 'MPMP\ActividadController@insumos')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('InsumosActividad')->middleware('auth', 'check.permissions:modificar_actividades');

Route::match(['get', 'post'], '/producto/{id}/actividades/{id_act}/insumos/editar', 'MPMP\ActividadController@editar_insumos')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('EditarInsumosActividad')->middleware('auth', 'check.permissions:modificar_actividades');

Route::match('/producto/{id}/actividades/{id_act}/informe', 'MPMP\ActividadController@informe')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'])->name('InformeActividad')->middleware('auth');

Route::match('/producto/{id}/actividades/{id_act}/informe/{tipo}', 'MPMP\ActividadController@documento_informe')->where(['id' => '[0-9]+', 'id_act' => '[0-9]+'], 'tipo' => '[A-Za-z]{3}')->name('DocumentoInformeActividad')->middleware('auth');

// Rutas para administración de PLANES 

Route::view('/planes', 'mpmp.planes')->name('IndicePlanes')->middleware('auth');

Route::get('/planes/{tipo}/{per?}', 'MPMP\PlanController@lista_planes')->where(['tipo' => '[a-z]+', 'per' => '[0-9]{4}'])->name('ListaPlanes')->middleware('auth');

Route::match(['get', 'post'], '/planes/nuevo/{per?}', 'MPMP\PlanController@nuevo')->where('per', '[0-9]{4}')->name('NuevoPlan')->middleware('auth', 'check.permissions:ingresar_planes');

Route::get('/planes/{id}/ver', 'MPMP\PlanController@ver')->where('id', '[0-9]+')->name('VerPlan')->middleware('auth');

Route::match(['get', 'post'], '/planes/{id}/editar', 'MPMP\PlanController@editar')->where('id', '[0-9]+')->name('EditarPlan')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/eliminar', 'MPMP\PlanController@eliminar')->where('id', '[0-9]+')->name('EliminarPlan')->middleware('auth', 'check.rol:superusuario');

Route::get('/planes/{id}/aprobar', 'MPMP\PlanController@aprobar')->where('id', '[0-9]+')->name('AprobarPlan')->middleware('auth', 'check.permissions:aprobar_planes');

Route::get('/planes/{id}/activar', 'MPMP\PlanController@activar')->where('id', '[0-9]+')->name('ActivarPlanes')->middleware('auth', 'check.permissions:modificar_planes');

Route::get('/planes/{id}/cerrar', 'MPMP\PlanController@cerrar')->where('id', '[0-9]+')->name('CerrarPlan');

//Route::match(['get', 'post'], '/planes/{id}/unidad-gestion', 'MPMP\PlanController@asociar')->where('id', '[0-9]+')->name('AsociarPlan');

Route::match(['get', 'post'], '/planes/{id}/resultados', 'MPMP\PlanController@resultados')->where('id', '[0-9]+')->name('PlanResultados')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/productos', 'MPMP\PlanController@productos')->where('id', '[0-9]+')->name('PlanProductos')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/actividades', 'MPMP\PlanController@PlanActividades')->where('id', '[0-9]+')->name('PlanActividades')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/servicios-personales', 'MPMP\PlanController@planServiciosPersonales')->where('id', '[0-9]+')->name('PlanServiciosPersonales');

Route::get('/solicitudes', 'Control\SolicitudController@index')->name('IndiceSolicitudes');

Route::get('/solicitudes/{tipo}', 'Control\SolicitudController@solicitudesPorTipo')->where('tipo', '[A-Za-z]+')->name('SolicitudesPorTipo');

Route::get('/solicitudes/unidad-gestion/{unidad}/', 'Control\SolicitudController@solicitudesPorUnidadGestion')->where('unidad', '[0-9]+')->name('SolicitudesPorUnidadGestion');

Route::match(['get', 'post'], '/solicitudes/unidad-gestion/{unidad}/nueva', 'Control\SolicitudController@nueva')->where('unidad', '[0-9]+')->name('NuevaSolicitud');

Route::match(['get', 'post'], '/solicitudes/unidad-gestion/{unidad}/{id}/editar', 'Control\SolicitudController@editar')->where(['unidad' => '[0-9]+', 'id' => '[0-9]+'])->name('EditarSolicitud');

Route::get('/solicitudes/unidad-gestion/{unidad}/{id}/ver', 'Control\SolicitudController@ver')->where(['unidad' => '[0-9]+', 'id' => '[0-9]+'])->name('VerSolicitud');

Route::get('/solicitudes/unidad-gestion/{unidad}/{id}/eliminar', 'Control\SolicitudController@eliminar')->where(['unidad' => '[0-9]+', 'id' => '[0-9]+'])->name('EliminarSolicitud');




Route::view('/error', 'error', ['title'=>'¡Error!', 'message'=>'Página No Autorizada.'])->name('error');

Route::redirect('*', '/error', 401);