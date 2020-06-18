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
})->name('Welcome')->middleware('language');

Auth::routes(['register' => false]);

Route::post('/lang/{lang}', 'LangController@lang')->name('Lang');

Route::get('/home', 'HomeController@index')->name('Home');

//
//RUTAS ADMINISTRATIVAS
//

Route::get('/administrar', 'AdminController@index')->name('AdminDashboard');

Route::get('/administrar/usuarios/{todos?}', 'AdminController@usuarios')->name('AdminUsuarios');

Route::get('/administrar/funcionarios/{todos?}', 'AdminController@funcionarios')->name('AdminFuncionarios');

Route::get('/administrar/programas/{todos?}', 'AdminController@programas')->name('AdminProgramas');

Route::get('/administrar/proyectos/{todos?}', 'AdminController@proyectos')->name('AdminProyectos');

Route::get('/administrar/tablas', 'AdminController@maestros')->name('AdminMaestros');

//
//RUTAS DE LISTADOS MAESTROS
//

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

//
//RUTAS DE ADMINISTRACIÓN DE USUARIOS
//

Route::match(['get', 'post'], '/administrar/usuarios/nuevo', 'Admin\UsuarioController@nuevo')->name('NuevoUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

Route::get('/administrar/usuarios/{id}/ver', 'Admin\UsuarioController@ver')->where('id', '[0-9]+')->name('DetalleUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/editar', 'Admin\UsuarioController@editar')->where('id', '[0-9]+')->name('UpdateUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/eliminar', 'Admin\UsuarioController@eliminar')->where('id', '[0-9]+')->name('EliminarUsuario')->middleware('auth', 'check.rol:superusuario');

Route::match(['get', 'post'], '/administrar/usuarios/{id}/desactivar', 'Admin\UsuarioController@desactivar')->where('id', '[0-9]+')->name('DesactivarUsuario')->middleware('auth', 'check.permissions:administrar_usuarios');

//
//RUTAS DE ADMINISTRACION DE FUNCIONARIOS
//

Route::match(['get', 'post'], '/administrar/funcionarios/nuevo', 'FuncionarioController@nuevo')->name('NuevoFuncionario')->middleware('auth', 'check.rol:superusuario');

Route::get('/administrar/funcionarios/{id}/ver', 'FuncionarioController@ver')->where('id', '[0-9]+')->name('DetalleFuncionario')->middleware('auth');

Route::match(['get', 'post'], '/administrar/funcionarios/{id}/editar', 'FuncionarioController@editar')->where('id', '[0-9]+')->name('EditarFuncionario')->middleware('auth', 'check.rol:superusuario');

Route::match(['get', 'post'], '/administrar/funcionarios/{id}/desactivar', 'FuncionarioController@desactivar')->where('id', '[0-9]+')->name('DesactivarFuncionario')->middleware('auth', 'check.rol:superusuario');

Route::match(['get', 'post'], '/administrar/funcionarios/{id}/eliminar', 'FuncionarioController@eliminar')->where('id', '[0-9]+')->name('EliminarFuncionario')->middleware('auth', 'check.rol:superusuario');

//
//RUTAS ADMINISTRACION DE PROGRAMAS
//

Route::get('/programas', 'Admin\ProgramaController@index')->name('IndiceProgramas')->middleware('auth', 'check.permissions:ver_programas');

Route::get('/programas/page/{page}/{todos?}', 'Admin\ProgramaController@lista')->where('page', '[0-9]+')->name('ListaProgramas')->middleware('auth', 'check.permissions:ver_programas', 'language');

Route::get('/programas/{id}/ver/{trashed?}', 'Admin\ProgramaController@ver')->where('id', '[0-9]+')->name('VerPrograma')->middleware('auth', 'check.permissions:ver_programas', 'language');

Route::match(['get', 'post'], '/programas/nuevo', 'Admin\ProgramaController@nuevo')->name('NuevoPrograma')->middleware('auth','check.permissions:ingresar_programas', 'language');

Route::match(['get', 'post'], '/programas/{id}/editar', 'Admin\ProgramaController@editar')->where('id', '[0-9]+')->name('EditarPrograma')->middleware('auth', 'check.permissions:modificar_programas', 'language');

Route::match(['get', 'post'], '/programas/{id}/unidad-gestion', 'Admin\ProgramaController@asociar')->where('id', '[0-9]+')->name('AsociarPrograma')->middleware('auth', 'check.permissions:modificar_programas', 'language');

Route::post('/programas/{id}/unidad-gestion/{idu}/remover/', 'Admin\ProgramaController@disociar_unidad')->where('id', '[0-9]+')->name('DisociarUnidadPrograma')->middleware('auth', 'check.permissions:modificar_programas', 'language');

Route::post('/programas/{id}/eliminar/{trashed?}', 'Admin\ProgramaController@eliminar')->where('id', '[0-9]+')->name('EliminarPrograma')->middleware('auth', 'check.rol:superusuario', 'language');

Route::get('/programas/{id}/reciclar/', 'Admin\ProgramaController@reciclar')->where('id', '[0-9]+')->name('ReciclarPrograma')->middleware('auth', 'check.rol:superusuario', 'language');

//RUTAS DE ADMINISTRACION DE PROYECTOS

Route::get('/proyectos', 'Admin\ProyectoController@index')->name('IndiceProyectos')->middleware('auth', 'check.permissions:ver_proyectos');

Route::get('/proyectos/page/{page}/{todos?}', 'Admin\ProyectoController@lista')->where('page', '[0-9]+')->name('ListaProyectos')->middleware('auth', 'check.permissions:ver_proyectos', 'language');

Route::get('/proyectos/{id}/ver', 'Admin\ProyectoController@ver')->where('id', '[0-9]+')->name('VerProyecto')->middleware('auth', 'check.permissions:ver_proyectos', 'language');

Route::match(['get', 'post'], '/proyectos/nuevo', 'Admin\ProyectoController@nuevo')->name('NuevoProyecto')->middleware('auth', 'check.permissions:ingresar_proyectos', 'language');

Route::match(['get', 'post'], '/proyectos/{id}/editar', 'Admin\ProyectoController@editar')->where('id', '[0-9]+')->name('EditarProyecto')->middleware('auth', 'check.permissions:modificar_proyectos', 'language');

Route::match(['get', 'post'], '/proyectos/{id}/unidad-gestion', 'Admin\ProyectoController@asociar_unidad')->where('id', '[0-9]+')->name('AsociarProyectoUnidad')->middleware('auth', 'check.permissions:modificar_proyectos', 'language');

Route::post('/proyectos/{id}/unidad-gestion/{idu}/remover', 'Admin\ProyectoController@disociar_unidad')->where(['id' => '[0-9]+', 'idu' => '[0-9]+'])->name('DisociarProyectoUnidad')->middleware('auth', 'check.permissions:modificar_proyectos');

Route::match(['get', 'post'], '/proyectos/{id}/comunidades', 'Admin\ProyectoController@asociar_comunidad')->where('id', '[0-9]+')->name('AsociarProyectoComunidad')->middleware('auth', 'check.permissions:modificar_proyectos', 'language');

Route::post('/proyectos/{id}/comunidad/{idc}/remover', 'Admin\ProyectoController@disociar_comunidad')->where(['id' => '[0-9]+', 'idc' => '[0-9]+'])->name('DisociarProyectoComunidad')->middleware('auth', 'check.permissions:modificar_proyectos');

Route::post('/proyectos/{id}/eliminar/{trashed?}', 'Admin\ProyectoController@eliminar')->where('id', '[0-9]+')->name('EliminarProyecto')->middleware('auth', 'check.rol:superusuario');

Route::get('/proyectos/{id}/reciclar', 'Admin\ProyectoController@reciclar')->where('id', '[0-9]+')->name('ReciclarProyecto')->middleware('auth', 'check.rol:superusuario', 'language');


Route::match(['get', 'post'], '/proyectos/{id}/ingresar-resultados', 'Admin\ProyectoController@ingresar_resultados')->name('IngresarResultadosProyecto')->middleware('auth', 'check.permissions:ingresar_resultados', 'language');


//RUTAS DE ADMINISTRACION DE INDICADORES DE RESULTADO DE PROYECTOS

Route::get('/resultados/page/{page}/{todos?}', 'MPMP\ResultadoController@lista')->where('page', '[0-9]+')->name('ListaResultados')->middleware('auth', 'check.permissions:ver_resultados', 'language');

Route::get('/resultados/{filtro}/{valor}/page/{page}/{todos?}', 'MPMP\ResultadoController@lista_filtro')->where(['filtro' => '[a-z]+', 'valor' => '[a-z]+', 'page' => '[0-9]+'])->name('ListaResultadosFiltro')->middleware('auth', 'check.permissions:ver_resultados', 'language');


Route::match(['get', 'post'], '/resultados/nuevo', 'MPMP\ResultadoController@nuevo')->name('NuevoResultado')->middleware('auth', 'check.permissions:ingresar_resultados', 'language');

Route::get('/resultados/{id}/ver', 'MPMP\ResultadoController@ver')->where('id', '[0-9]+')->name('VerResultado')->middleware('auth','check.permissions:ver_resultados', 'language');

Route::get('/resultados/{id}/aprobar', 'MPMP\ResultadoController@aprobar')->where('id', '[0-9]+')->name('AprobarResultado')->middleware('auth', 'check.permissions:aprobar_resultados');

Route::match(['get', 'post'], '/resultados/{id}/editar', 'MPMP\ResultadoController@editar')->where('id', '[0-9]+')->name('EditarResultado')->middleware('auth', 'check.permissions:modificar_resultados', 'language');

Route::post('/resultados/{id}/eliminar', 'MPMP\ResultadoController@eliminar')->where('id', '[0-9]+')->name('EliminarResultado')->middleware('auth', 'check.permissions:eliminar_resultados', 'language');

Route::match(['get','post'], '/resultados/{id}/ingresar-productos/', 'MPMP\ResultadoController@ingresar_productos')->where('id', '[0-9]+')->name('IngresarProductosResultado')->middleware('auth', 'check.permissions:ingresar_resultados', 'language');

//RUTAS DE ADMINISTRACION DE INDICADORES DE PRODUCTO DE PROYECTOS

Route::get('/productos/page/{page}', 'MPMP\ProductoController@lista')->where('page', '[0-9]+')->name('ListaProductos')->middleware('auth', 'check.permissions:ver_productos', 'language');

Route::get('/productos/{id}/ver', 'MPMP\ProductoController@ver')->where('id', '[0-9]+')->name('VerProducto')->middleware('auth', 'check.permissions:ver_productos', 'language');

Route::match(['get', 'post'], '/productos/nuevo', 'MPMP\ProductoController@nuevo')->name('NuevoProducto')->middleware('auth', 'check.permissions:ingresar_productos', 'language');


Route::match(['get', 'post'], '/productos/{id}/editar', 'MPMP\ProductoController@editar')->where('id', '[0-9]+')->name('EditarProducto')->middleware('auth', 'check.permissions:modificar_productos', 'language');

Route::post('/productos/{id}/eliminar', 'MPMP\ProductoController@eliminar')->where('id', '[0-9]+')->name('EliminarProducto')->middleware('auth', 'check.permissions:eliminar_productos');

Route::get('/productos/{id}/aprobar', 'MPMP\ProductoController@aprobar')->where('id', '[0-9]+')->name('AprobarProducto')->middleware('auth', 'check.permissions:aprobar_productos');

Route::match(['get','post'], '/productos/{id}/ingresar-actividades', 'MPMP\ProductoController@ingresar_actividades')->where('id', '[0-9]+')->name('IngresarActividadesProducto')->middleware('auth', 'check.permissions:ingresar_actividades', 'language');


//
// RUTAS PARA PROCESAR DATOS DE ACTIVIDADES POR INDICADOR DE PRODUCTO
//

// Route::get('/actividades', 'MPMP\ActividadController@index')->name('IndiceActividades')->middleware('auth', 'check.permissions:ver_actividades');

Route::get('/actividades/page/{page}/{todos?}', 'MPMP\ActividadController@lista')->where('page', '[0-9]+')->name('ListaActividades')->middleware('auth', 'check.permissions:ver_actividades', 'language');

//Route::get('/producto/{id}/actividades', 'MPMP\ActividadController@actividadesProducto')->where('id', '[0-9]+')->name('ActividadesProducto')->middleware('auth', 'check.permissions:ver_actividades');

Route::match(['get', 'post'], '/actividades/nuevo', 'MPMP\ActividadController@nuevo')->where('id', '[0-9]+')->name('NuevaActividad')->middleware('auth', 'check.permissions:ingresar_actividades', 'language');


Route::get('/actividades/{id}/ver', 'MPMP\ActividadController@ver')->where('id', '[0-9]+')->name('VerActividad')->middleware('auth', 'check.permissions:ver_actividades', 'language');


Route::match(['get', 'post'], '/actividades/{id}/editar', 'MPMP\ActividadController@editar')->where('id', '[0-9]+')->name('EditarActividad')->middleware('auth', 'check.permissions:modificar_actividades', 'language');

Route::get('/actividades/{id}/accion/{accion}', 'MPMP\ActividadController@acciones')->where(['id' => '[0-9]+', 'accion' => '[A-Za-z]+'])->name('AccionActividad')->middleware('auth', 'language');

//Route::get('/actividades/{id}/cancelar', 'MPMP\ActividadController@cancelar')->where('id', '[0-9]+')->name('CancelarActividad')->middleware('auth', 'check.permissions:cancelar_actividades');



Route::post('/actividades/{id}/eliminar', 'MPMP\ActividadController@eliminar')->where('id', '[0-9]+')->name('EliminarActividad')->middleware('auth', 'check.permissions:eliminar_actividades');

Route::match(['get', 'post'], '/actividades/{id}/insumos', 'MPMP\ActividadController@insumos')->where('id', '[0-9]+')->name('InsumosActividad')->middleware('auth', 'check.permissions:modificar_actividades', 'language');

Route::match(['get', 'post'], '/actividades/{id}/insumos/{idd}/editar', 'MPMP\ActividadController@editar_insumos')->where(['id' => '[0-9]+', 'idd' => '[0-9]+'])->name('EditarInsumosActividad')->middleware('auth', 'check.permissions:modificar_actividades', 'language');

Route::post('/actividades/{id}/insumos/{idd}/eliminar', 'MPMP\ActividadController@eliminar_insumos')->where(['id' => '[0-9]+', 'idd' => '[0-9]+'])->name('EliminarInsumosActividad')->middleware('auth', 'check.permissions:modificar_actividades');

Route::match(['get', 'post'],'/actividades/{id}/informe/{pid?}', 'MPMP\ActividadController@informe')->where('id', '[0-9]+')->name('InformeActividad')->middleware('auth', 'check.permissions:ingresar_planes', 'language');

Route::post('/actividades/{id}/informe/anular', 'MPMP\ActividadController@anular_informe')->where('id', '[0-9]+')->name('AnularInformeActividad')->middleware('auth', 'check.rol:superusuario');

#Route::get('/actividades/{id}/informe/descargar/{tipo}', 'MPMP\ActividadController@documento_informe')->where(['id' => '[0-9]+', 'tipo' => '[A-Za-z]{3}'])->name('DescargaInformeActividad')->middleware('auth');

//
// Rutas para administración de PERIODOS POR UNIDAD
//

Route::get('/periodos/page/{page?}', 'MPMP\PeriodoController@lista')->name('ListaPeriodoUnidad')->middleware('auth', 'check.permissions:ver_periodos', 'language');

Route::get('/periodos/{id}/ver', 'MPMP\PeriodoController@ver')->where('id', '[0-9]+')->name('VerPeriodoUnidad')->middleware('auth', 'check.permissions:ver_periodos', 'language');

Route::post('/periodos/{id}/{accion}', 'MPMP\PeriodoController@accion')->where(['id' => '[0-9]+', 'accion' => '[a-z]+'])->name('AccionPeriodoUnidad')->middleware('auth', 'check.permissions:gestionar_periodos');

Route::post('/periodo/{id}/activar-todos', 'MPMP\PeriodoController@activarTodos')->where('id', '[0-9]+')->name('ActivarTodosPeriodos')->middleware('auth', 'check.permissions:gestionar_periodos');

Route::match(['get', 'post'], '/periodos/nuevo', 'MPMP\PeriodoController@nuevo')->name('NuevoPeriodoUnidad')->middleware('auth', 'check.permissions:ingresar_periodos', 'language');

Route::match(['get', 'post'], '/periodos/{id}/editar', 'MPMP\PeriodoController@editar')->where('id', '[0-9]+')->name('EditarPeriodoUnidad')->middleware('auth', 'check.permissions:modificar_periodos', 'language');

Route::match(['get', 'post'], '/periodo/{id}/resultados', 'MPMP\PeriodoController@resultados')->where('id', '[0-9]+')->name('PeriodoUnidadResultados')->middleware('auth', 'check.permissions:modificar_periodos');

//Route::match(['get', 'post'], '/periodo/{id}/resultados/add')->where('id', '[0-9]+')->name('AgregarResultadoPeriodo')->middleware('auth', 'check.permissions:modificar_periodos');

Route::post('/periodo/{id}/resultado/{rid}/remover', 'MPMP\PeriodoController@remover_resultado')->where(['id' => '[0-9]+', 'rid' => '[0-9]+'])->name('RemoverResultadoPeriodo')->middleware('auth', 'check.permissions:modificar_periodos');

//
// Rutas para administración de PLANES 
//

Route::get('/planes/page/{page}/{todos?}', 'MPMP\PlanController@lista')->where(['page' => '[0-9]+', 'todos' => '[a-z]+'])->name('ListaPlanes')->middleware('auth', 'check.permissions:ver_planes', 'language');

Route::get('/planes/{pid}/page/{page}', 'MPMP\PlanController@lista_planes_periodo')->where(['page' => '[0-9]+', 'pid' => '[0-9]4'])->name('ListaPlanesPeriodo')->middleware('auth', 'check.permissions:ver_planes', 'language');

#Route::get('/planes/{tipo}/page/{page}/{todos?}', 'MPMP\PlanController@lista')->where(['tipo' => '[a-z]+', 'periodo' => '[0-9]{4}', 'page' => '[0-9]+'])->name('ListaPlanes')->middleware('auth');

Route::match(['get', 'post'], '/planes/nuevo/', 'MPMP\PlanController@nuevo')->name('NuevoPlan')->middleware('auth', 'check.permissions:ingresar_planes', 'language');

Route::get('/planes/{id}/ver', 'MPMP\PlanController@ver')->where('id', '[0-9]+')->name('VerPlan')->middleware('auth', 'check.permissions:ver_planes', 'language');

Route::match(['get', 'post'], '/planes/{id}/editar', 'MPMP\PlanController@editar')->where('id', '[0-9]+')->name('EditarPlan')->middleware('auth', 'check.permissions:modificar_planes', 'language');

Route::post('/planes/{id}/eliminar', 'MPMP\PlanController@eliminar')->where('id', '[0-9]+')->name('EliminarPlan')->middleware('auth', 'check.permissions:eliminar_planes');

Route::get('/planes/{id}/aprobar', 'MPMP\PlanController@aprobar')->where('id', '[0-9]+')->name('AprobarPlan')->middleware('auth', 'check.permissions:aprobar_planes');

Route::get('/planes/{id}/activar', 'MPMP\PlanController@activar')->where('id', '[0-9]+')->name('ActivarPlanes')->middleware('auth', 'check.permissions:gestionar_planes');

//Route::get('/planes/gestion/{gestion}', 'MPMP\PlanController@gestion')->where('gestion', '[a-z]+')->name('GestionPlanes')->middleware('auth','check.permissions:gestionar_planes');

Route::post('/planes/{id}/cerrar', 'MPMP\PlanController@cerrar')->where('id', '[0-9]+')->name('CerrarPlan')->middleware('auth', 'check.permissions:cerrar_planes');

Route::post('/planes/{id}/abrir', 'MPMP\PlanController@abrir')->where('id', '[0-9]+')->name('AbrirPlan')->middleware('auth', 'check.permissions:gestionar_planes');

Route::match(['get', 'post'], '/planes/{pid}/actividades/{id}/ejecutar', 'MPMP\ActividadController@ejecutar')->where(['id' => '[0-9]+', 'pid' => '[0-9]+'])->name('EjecutarActividad')->middleware('auth', 'check.permissions:ejecutar_actividades', 'language');

Route::match(['get', 'post'], '/planes/{$id}/informe', 'MPMP\PlanController@informe')->where('id', '[0-9]+')->name('InformePlan')->middleware('auth', 'check.permissions:modificar_planes', 'language');

//Route::get('planes/{id}/detalle', 'MPMP\PlanController@detalle')->where('id', '[0-9]+')->name('DetallePlan')->middleware('auth', 'check.permissions:ver_planes');

Route::match(['get', 'post'], '/planes/{id}/productos', 'MPMP\PlanController@productos')->where('id', '[0-9]+')->name('PlanProductos')->middleware('auth', 'check.permissions:modificar_planes');

Route::post('/planes/{id}/productos/{pid}/remover', 'MPMP\PlanController@remover_producto')->where(['id' => '[0-9]+', 'pid' => '[0-9]+'])->name('RemoverProducto')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/actividades', 'MPMP\PlanController@actividades')->where('id', '[0-9]+')->name('PlanActividades')->middleware('auth', 'check.permissions:modificar_planes', 'language');

Route::post('/planes/{id}/actividades/{aid}/remover', 'MPMP\PlanController@remover_actividad')->where(['id' => '[0-9]+', 'aid' => '[0-9]+'])->name('RemoverActividad')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/servicios-personales', 'MPMP\PlanController@servicios_personales')->where('id', '[0-9]+')->name('PlanServiciosPersonales')->middleware('auth', 'check.permissions:modificar_planes');

Route::match(['get', 'post'], '/planes/{id}/informe', 'MPMP\PlanController@informe')->where('id', '[0-9]+')->name('InformePlan')->middleware('auth', 'check.permissions:modificar_planes');

Route::get('/planes/{id}/solicitudes', 'MPMP\PlanController@solicitudes')->where('id', '[0-9]+')->name('SolicitudesPlan')->middleware('auth', 'check.permissions:ver_solicitudes');

//
// Administración de solicitudes
//

Route::get('/solicitudes', 'Control\SolicitudController@index')->name('IndiceSolicitudes')->middleware('auth', 'check.permissions:ver_solicitudes');

Route::get('/solicitudes/page/{page}/{todas?}', 'Control\SolicitudController@lista')->name('ListaSolicitudes')->middleware('auth', 'check.permissions:ver_solicitudes');

Route::get('/solicitudes/{tipo}/page/{page}/', 'Control\SolicitudController@solicitudesPorTipo')->where(['tipo' => '[A-Za-z]+', 'page' => '[0-9]+'])->name('SolicitudesPorTipo')->middleware('auth', 'check.permissions:ver_solicitudes');

Route::get('/solicitudes/unidad-gestion/{id}/', 'Control\SolicitudController@solicitudesPorUnidadGestion')->where('id', '[0-9]+')->name('SolicitudesPorUnidadGestion')->middleware('auth', 'check.permissions:ver_solicitudes');

Route::match(['get', 'post'], '/solicitudes/nueva', 'Control\SolicitudController@nueva')->name('NuevaSolicitud')->middleware('auth', 'check.permissions:ingresar_solicitudes');

Route::match(['get', 'post'], '/solicitudes/{id}/editar', 'Control\SolicitudController@editar')->where('id', '[0-9]+')->name('EditarSolicitud')->middleware('auth', 'check.permissions:modificar_solicitudes');

Route::get('/solicitudes/{id}/ver', 'Control\SolicitudController@ver')->where('id', '[0-9]+')->name('VerSolicitud')->middleware('auth', 'check.permissions:ver_solicitudes');

Route::post('/solicitudes/{id}/eliminar', 'Control\SolicitudController@eliminar')->where('id', '[0-9]+')->name('EliminarSolicitud');

Route::get('/solicitudes/gestion/{gestion}', 'Control\SolicitudController@gestion')->where('gestion', '[a-z]+')->name('GestionSolicitudes')->middleware('auth', 'check.permissions:modificar_solicitudes');

Route::get('/solicitudes/{id}/tramite/{tramite}', 'Control\SolicitudController@tramite')->where(['id' => '[0-9]+', 'tramite' => '[a-z]+'])->name('AccionSolicitud')->middleware('auth');


Route::get('/informe/anual', 'Control\InformeController@anual')->name('InformeAnual');

Route::get('/informe/trimestral', 'Control\InformeController@trimestral')->name('InformeTrimestral');

Route::get('/informe/actividades', 'Control\InformeController@actividades')->name('InformeActividades');

Route::get('/informe/consolidado', 'Control\InformeController@consolidado')->name('InformeConsolidado');


Route::view('/error', 'error', ['title'=>'¡Error!', 'message'=>'Página No Autorizada.'])->name('error');

Route::redirect('*', '/error', 401);