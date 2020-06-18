<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Libreria\MenuBuilder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\UnidadMedida;
use App\Models\Documento;
use App\Models\Foto;
use App\Models\Solicitud;
use Auth;

class ActividadController extends Controller
{
    
    const SECCION = 'activities';

    /*

    public function index($page=1, $todas=null){

    	$producto = Producto::findOrFail($id);

    	$actividades = $producto->actividades;

    	return view('mpmp.indice_actividades', ['titulo' => 'Actividades del producto', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'producto' => $producto, 'actividades' => $actividades]);

    }
    */

    public function lista(MenuBuilder $mb, $page=1){

        $funcionario = Auth::user()->funcionario;

        $limite = config('variables.limite_lista', 20);

        $ruta = route('ListaActividades', ['page' => $page, 'todos' => $todos]);

        $unidad = $funcionario->unidadGestion;

        $actividades = $unidad->proyectos->where('ejecutado', false)->resultados->productos->actividades->paginate($limite);

        $datos = ['seccion' => self::SECCION, 'actividades' => $actividades, 'backroute' => $ruta, 'menu_list' => $mb->getMenu(), 'page' => $page, 'unidad_gestion' => $unidad];

        return view('actividades.lista', $datos);

    }

    
    public function nuevo(Request $request, MenuBuilder $mb){
    	

    	if($request->isMethod('get')){

            $productos = Auth::user()->funcionario->unidadGestion->proyectos->where('ejecutado', false)->resultados->productos;

    		$actividad = new Actividad;

            $ruta = route('NuevaActividad');

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

    		return view('actividades.nuevo', ['seccion' => self::SECCION, 'productos' => $productos, 'actividad' => $actividad, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

    	}elseif ($request->isMethod('post')) {

            $request->validate([
                'producto_id' => 'bail|integer|required',
                'codigo' => 'alpha_dash|max:25|required',
                'descripcion' => 'alpha_num|max:600|required',
                'fuente_financiamiento' => 'alpha|present',
                'monto_presupuesto' => 'numeric|present',
                'monto_aprobado' => 'numeric|present',
                'monto_disponible' => 'numeric|present',
            ]);

            try {

                $actividad = Actividad::create($request->input());
                
            } catch (Exception $e) {

                error_log('Excepción al ingresar Actividad. '.$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
                
            }

            
            toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

            return redirect()->route('VerActividad', ['id' => $actividad->id]);

    	}
    }

    public function ver(MenuBuilder $mb, $id){

    	$actividad = Actividad::findOrFail($id);

        $params = ['id' => $id];

        $ruta = route('VerActividad', $params);

        $ruta_edit = route('EditarActividad', $params);

        $ruta_approve = route('AccionActividad', ['id' => $id, 'accion' => 'aprobar']);

        $ruta_cancel = route('AccionActividad', ['id' => $id, 'accion' => 'cancelar']);

        //$ruta_execute = route('AccionActividad', ['id' => $id, 'accion' => 'ejecutar'])

        $ruta_delete = route('EliminarActividad', $params);

        $ruta_anular_informe = route('AnularInformeActividad', $params);

        $datos = ['seccion' => self::SECCION, 'actividad' => $actividad, 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_approve' => $ruta_approve, 'ruta_cancel' => $ruta_cancel, 'ruta_delete' => $ruta_delete, 'menu_list' => $mb->getMenu()];

    	return view('actividades.detalle', $datos);

    }

    public function editar(Request $request, MenuBuilder $mb, $id){

    	$actividad = Actividad::findOrFail($id);

    	if($request->isMethod('get')){

            $ruta = route('EditarActividad', ['id' => $id]);

    		if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));
            }

            $datos = ['seccion' => self::SECCION, 'actividad' => $actividad, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

    		return view('actividades.editar', $datos);

    	}else if($request->isMethod('post')){

            $request->validate([
                'producto_id' => 'bail|integer|required',
                'codigo' => 'alpha_dash|max:25|required',
                'descripcion' => 'alpha_num|max:600|required',
                'fuente_financiamiento' => 'alpha|present',
                'monto_presupuesto' => 'numeric|present',
                'monto_aprobado' => 'numeric|present',
                'monto_disponible' => 'numeric|present',
            ]);

            try {

                $actividad->fill($request->input());

                $actividad->save();
                
            } catch (Exception $e) {
                
                error_log('Excepción al actualizar Actividad. '.$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
            }

            toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

            return redirect()->route('VerActividad', ['id' => $id]);
            
    	}
    }

    public function acciones(Request $request, $id, $accion){

        function unauthorized(){

            toastr()->error(__('messages.unauthorized_operation'));

            return redirect()->route('ListaActividades');

        }

    	$funcionario = Auth::user()->funcionario;

    	$actividad = Actividad::findOrFail($id);

    	switch (strtolower($accion)) {
    		case 'aprobar':
                if($funcionario->tienePermiso('aprobar_actividades')){
                    $actividad->aprobada = true;
                }else{

                    unauthorized();
                }
    			break;
    		case 'cancelar':
                if($funcionario->tienePermiso('cancelar_actividades')){
                    $actividad->cancelada = true;
                }else{

                    unauthorized();
                }
    			break;
                /*
    		case 'ejecutar':
                if($funcionario->tienePermiso('ejecutar_actividades')){
                    $actividad->ejecutada = true;
                }else{

                    unauthorized();
                }
    			break;
                */
    		default:
                toastr()->error(__('messages.unauthorized_operation'), strtoupper(__('unauthorized operation')));

    			return redirect()->route('error');
    			break;
    	}

        $actividad->save();

        if(strtolower($accion) === 'ejecutar'){
            return redirect()->route('InformeActividad', ['id' => $id]);
        }

    	return redirect()->route('IndiceActividades', ['id' => $id])
    }

    /**
    *
    * Función del controlador para dar una actividad 
    * por ejecutada de acuerdo al plan donde fue programada.
    *
    */

    public function ejecutar(Request $request, MenuBuilder $mb, $pid, $id){

        $actividad = Actividad::findOrFail($id);

        $plan = Plan::findOrFail($pid);

        if ($request->isMethod('get')) {
            
            $claves_insumos = DB::table('actividad_insumo')->select('id')->where('actividad_id', $actividad->id)->toArray();

            $solicitudes = DB::table('solicituds')->select('id')->whereIn('actividad_insumo_id', $claves_insumos)->where('procesado', true);

            // Verifica que si la actividad tiene solicitudes.
            // Si hay solicitudes de insumos. Debe haber un informe de rendición.
            // Si hay solicitudes sin informe, se redirige para
            // ingresar el informe de rendición correspondiente
            // antes de modificar la actividad.
            if ($solicitudes->count() > 0 && $actividad->informe->count() == 0) {
                
                toastr()->info(__('messages.no_report_activity'));

                return redirect()->route('InformeActividad', ['id' => $id, 'pid' => $pid]);

            }

            $ruta = route('EjecutarActividad', ['id' => $id, 'pid' => $pid]);

            $datos = ['seccion' => self::SECCION, 'actividad' => $actividad, 'plan' => $plan, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Operation Error')));
            }

            return view('actividades.ejecutar', $datos);

        } elseif ($request->isMethod('post')) {
            
            $request->validate([
                'actividad_id' => 'bail|integer|required',
                'fecha_ejecutada' => 'date|required',
            ]);

            $fecha_ejecutada = $request->fecha_ejecutada;

            $actividad->ejecutada = true;

            $actividad->planes()->updateExistingPivot($pid, ['ejecutada' => true, 'fecha_ejecutada' => $fecha_ejecutada]);

            toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

            return redirect()->route('VerPlan', ['id' => $pid]);

        }

    }

    public function eliminar(Request $request, $id){

    	if($request->isMethod('post')){

            $actividad = Actividad::findOrFail($id);

            $actividad->delete();

    		//Actividad::destroy($id);

    		return redirect()->route('ListaActividades');

    	}

    }

    public function insumos(Request $request, MenuBuilder $mb, $id){

        $actividad = Actividad::findOrFail($id);

        $ruta = route('InsumosActividad', ['id' => $id]);

    	if ($request->isMethod('get')) {

            $empty_rows = config('variables.extra_rows', 4);

    		$insumos = Insumo::all();

    		$unidades = UnidadMedida::all();

            $datos = ['seccion' => self::SECCION, 'ruta' => $ruta, 'backroute' => $ruta, 'actividad' => $actividad, 'insumos' => $insumos, 'unidades' => $unidades, 'filas' => $empty_rows, 'menu_list' => $mb->getMenu()];

    		return view('actividades.insumos', $datos);

    	} else if ($request->isMethod('post')) {

            if ($request->has('insumos')) {
                
                $datos = $request->insumos;
                $filas = count($datos['insumo_id']);
                $saved = 0;

                for ($i=0; $i < $filas; $i++) { 
                    
                    if (isset($datos['cantidad'][$i])) {
                        
                        try {

                            $insumo = ['unidad_medida_id' => $datos['unidad_medida_id'][$i], 'costo_unitario' => $datos['costo_unitario'][$i], 'cantidad' => $datos['cantidad'][$i]];

                            $actividad->insumos()->attach($datos['insumo_id'][$i], $insumo);
                            
                        } catch (Exception $e) {

                            error_log("Excepción al registrar insumos para la actividad {$actividad->codigo}. ".$e->getMessage());

                            toastr()->error(strtoupper(__('messages.critical_error')), strtoupper(__('Operation Error')));

                            return redirect()->route('error');
                            
                        }

                    } else {

                        break;

                    }
                }

                if ($saved > 0) {
                    
                    toastr()->success("{$saved} ".__('messages.records_saved'), strtoupper(__('Operation Success')));

                } else {

                    toastr()->info(__('messages.no_records_saved'));

                }

                return redirect()->route('VerActividad', ['id' => $id]);

            } else {

                toastr()->error(__('messages.registration_error'), strtoupper(__('Operation Error')));


                return redirect($ruta);

            }
    		
    	}
    }



    public function editar_insumos(Request $request, MenuBuilder $mb, $id, $idd){

        $actividad = Actividad::findOrFail($id);


    	if ($request->isMethod('get')) {
    		
    		$ruta = route('EditarInsumosActividad', ['id' => $id, 'idd' => $idd]);

    		$insumo = $actividad->insumos->filter($idd);

    		$unidades = UnidadMedida::all();

            $datos = ['seccion' => self::SECCION, 'ruta' => $ruta, 'backroute' => $ruta, 'insumo' => $insumo, 'unidades' => $unidades, 'actividad' => $actividad, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

    		return view('actividades.editar_insumo', $datos);

    	}else if ($request->isMethod('post')) {

            $request->validate([
                'unidad_medida_id' => 'bail|integer|required',
                'costo_unitario' => 'numeric|required',
                'cantidad' => 'numeric|required',
            ]);

            $attrs = ['unidad_medida_id' => $request->unidad_medida_id, 'costo_unitario' => $request->costo_unitario, 'cantidad' => $request->cantidad];

            $actividad->insumos()->updateExistingPivot($idd, $attrs);

    		toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

            return redirect()->route('VerActividad', ['id' => $id]);
    		
    	}
    }

    

    public function eliminar_insumos(Request $request, $id, $idd){

        if ($request->isMethod('post')) {
            
            $actividad = Actividad::findOrFail($id);

            try {

                $actividad->insumos()->detach($idd);
                
            } catch (Exception $e) {

                error_log("Excepción al retirar insumos de la actividad {$actividad->codigo} ".$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
                
            }

            toastr()->success(__('messages.update_success'));

            return redirect->route('VerActividad', ['id' => $id]);

        }
    }

    

    public function informe(Request $request, MenuBuilder $mb, $id, $pid=null){

        $actividad = Actividad::findOrFail($id);

        if ($actividad->ejecutada) {
            
            toastr()->error(__('messages.edit_executed_record'), strtoupper('error'));

            return redirect()->route('VerActividad', ['id' => $id]);

        }

        if($actividad->cancelada || ($actividad->informe != null && $actividad->informe->filter('anulado', false) != null)){

            toastr()->error('messages.unauthorized_operation');

            return redirect()->route('VerActividad', ['id' => $id]);

        }

        $ruta = route('InformeActividad', ['id' => $id]);

        if ($request->isMethod('get')) {

            $datos = ['seccion' => self::SECCION, 'actividad' => $actividad, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

            return view('actividades.informe', $datos);


        } elseif ($request->isMethod('post')) {
            
            $request->validate([
                'fecha_realizada' => 'bail|date|required',
                'documento' => 'bail|file|mimes:pdf|required',
                'foto' => 'image|dimensions:min_width=400,min_height=200|mimes:jpeg,jpg,png|nullable',
                'dificultades' => 'alpha_dash|max:1000|present',
                'soluciones' => 'alpha_dash|max:1000|present',
                'observaciones' => 'alpha_dash|max:1000|present',
                'beneficiarios_directos' => 'numeric|required',
                'beneficiarios_indirectos' => 'numeric|required',
                'hombres' => 'numeric|required',
                'mujeres' => 'numeric|required',
                'ninos' => 'numeric|required',
                'ninas' => 'numeric|required',
                'jovenes_m' => 'numeric|nullable',
                'jovenes_f' => 'numeric|nullable',
                'adulto_mayor_m' => 'numeric|nullable',
                'adulto_mayor_f' => 'numeric|nullable',
                'discapacitados' => 'numeric|nullable',
            ]);

            try {

                $informe = Informe::create($request->input());

                if ($request->hasFile('documento')) {
                    
                    $path_documento = $request->documento->store('docs');

                    $documento = Documento::create([
                        'nombre' => "Informe de actividad - {$actividad->codigo}",
                        'url' => $path_documento,
                        'descripcion' => "Documento de informe de la actividad '{$actividad->descripcion}'",
                        'tipo' => 'pdf',
                    ]);

                    $informe->documento()->associate($documento);

                } elseif ($request->hasFile('foto')) {
                    
                    $path_foto = $request->foto->store('fotos');

                    $foto = Foto::create([
                        'nombre' => "Foto de actividad - {$actividad->codigo}",
                        'url' => $path_foto,
                        'descripcion' => $actividad->descripcion,
                    ]);

                    $informe->fotos()->attach($foto->id);
                }
                
            } catch (Exception $e) {

                error_log("Excepción al registrar datos de informe. ".$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
                
            }


            toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

            if($pid==null){

                return redirect()->route('VerActividad', ['id' => $id]);

            } else {

                return redirect()->route('EjecutarActividad', ['id' => $id, 'pid' => $pid]);

            }

            


        }

    }

    public function anular_informe($id){

        $actividad = Actividad::findOrFail($id);

        $informe = $actividad->informe;

        $informe->anulado = true;

        $informe->save();

        toastr()->success(__('messages.update_success'));

        return redirect()->route('VerActividad', ['id' => $id]);
    }

}
