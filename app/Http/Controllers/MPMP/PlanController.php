<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Libreria\MenuBuilder;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Periodo;
use App\Models\PeriodoUnidad;
use App\Models\Personal;
use App\Models\Documento;
use App\Models\Actividad;
use Auth;

class PlanController extends Controller
{
    
    const SECCION = 'plans';

    public function lista_planes(MenuBuilder $mb, $page=1, $todos=null){

        $ruta = route('ListaPlanes', ['page' => $page, 'todos' => $todos]);

        $periodos = null;

        $limite = config('variables.limite_lista', 20)/4;

    	$funcionario = Auth::user()->funcionario;

        $digitador = $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq');

    	if ($todos == null) {

            //$periodo = PeriodoUnidad::where([['activo', true], ['unidad_gestion_id', $funcionario->unidadGestion->id], ['abierto', true]])->get();
    		
            if ($digitador == true) {
                
                $periodos = PeriodoUnidad::where([['unidad_gestion_id', $funcionario->unidadGestion->id],['abierto', true]]);//$funcionario->unidadGestion->planes->where('periodo_id', $periodo->id);

            }else {

                $periodos = PeriodoUnidad::where('abierto', true);

            }
    		
    	} elseif (strtolower($todos) == 'all') {
            
            if ($digitador == true) {
                
                $periodos = PeriodoUnidad::where('unidad_gestion_id', $funcionario->unidadGestion->id);//$funcionario->unidadGestion->planes;

            }else {

                $periodos = PeriodoUnidad::all();

            }

        }

        if ($periodos->count() > $limite) {
            
            $periodos = $periodos->paginate($limite);

        }

    	
    	return view('mpmp.lista_planes', ['seccion' => self::SECCION, 'periodos' => $periodos, 'page' => $page, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

    }

    public function lista_planes_periodo(MenuBuilder $mb, $pid, $page=1){

        $ruta = route('ListaPlanesPeriodo', ['page' => $page, 'todos' => $todos, 'pid' => $pid]);

        $periodos = null;

        //$planes = null;

        $limite = config('variables.limite_lista', 20)/4;

        $funcionario = Auth::user()->funcionario;

        $digitador = $funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq');

        if ($digitador == true) {
                
            $periodos =  PeriodoUnidad::where([['periodo_id', $pid], ['unidad_gestion_id', $funcionario->unidadGestion->id]]);//$funcionario->unidadGestion->planes->where([['periodo_id', '=', $periodo->id], ['tipo', '=', $tipo],]);

        }else {

            $periodos = PeriodoUnidad::where('periodo_id', $pid) //Plan::where([['periodo_id', '=', $periodo->id], ['tipo', '=', $tipo],]);

        }

        /*
        if ($todos == null) {

            $periodo = Periodo::where('activo', true)->get();
            
            if ($digitador == true) {
                
                $planes = $funcionario->unidadGestion->planes->where([['periodo_id', '=', $periodo->id], ['tipo', '=', $tipo],]);

            }else {

                $planes = Plan::where([['periodo_id', '=', $periodo->id], ['tipo', '=', $tipo],]);

            }
            
        } elseif (strtolower($todos) == 'all') {
            
            if ($digitador == true) {
                
                $planes = $funcionario->unidadGestion->planes->where('tipo', '=', $tipo);

            }else {

                $planes = Plan::where('tipo', '=', $tipo);

            }

        }
        */

        if ($periodos->count() > $limite) {
            
            $periodos = $periodos->paginate($limite);

        }

        
        return view('mpmp.lista_planes', ['seccion' => self::SECCION, 'periodos' => $periodos, 'page' => $page, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

    }

    public function nuevo(Request $request, MenuBuilder $mb){

    	if($request->isMethod('get')){

            $funcionario = Auth::user()->funcionario;

            $unidad_gestion = $funcionario->unidadGestion;

            $periodo = PeriodoUnidad::where([['activo', true], ['unidad_gestion_id', $unidad_gestion->id]]);

    		$plan = new Plan;

    		$ruta = route('NuevoPlan');

            $datos = ['seccion' => self::SECCION, 'plan' => $plan, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu(), 'unidad_gestion' => $unidad_gestion, 'periodo' => $periodo];

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

    		return view('mpmp.nuevo_plan', $datos);

    	}else if ($request->isMethod('post')) {

    		$request->validate([
                'periodo_unidad_id' => 'bail|numeric|required',
                'fecha_inicio' => 'date|required',
                'fecha_final' => 'date|required',
                'trimestre' => 'numeric|required',
                'monto_aprobado' => 'numeric|nullable',
            ]);

            $plan = Plan::create($request->input());

            /*
    		$unidad_gestion = $this->funcionario->unidadGestion;
    		
    		$periodo = Periodo::find($per);

    		$plan = new Plan;

    		$plan->periodo_id = $periodo->id;
    		$plan->fecha_inicio = $request->fecha_inicio;
    		$plan->fecha_final = $request->fecha_final;
    		$plan->trimestre = $request->trimestre;

    		$unidad_gestion->planes()->save($plan);
            */

            toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

    		return redirect()->route('VerPlan', ['id' => $plan->id]);

    	}
    }

    public function ver(MenuBuilder $mb, $id){

    	$plan = Plan::findOrFail($id);

        $params = ['id' => $id];

        $ruta = route('VerPlan', $params);

        $ruta_edit = route('EditarPlan', $params);

        $ruta_delete = route('EliminarPlan', $params);

        $ruta_approve = route('AprobarPlan', $params);

        $ruta_activate = route('ActivarPlan', $params);

        $ruta_close = route('CerrarPlan', $params);

        $datos = ['seccion' => self::SECCION, 'plan' => $plan, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'ruta_approve' => $ruta_approve, 'ruta_activate' => $ruta_activate, 'ruta_close' => $ruta_close];

    	return view('mpmp.detalle_plan', $datos);

    }

    public function editar(Request $request, MenuBuilder $mb, $id){

    	$plan = Plan::findOrFail($id);

    	if (!($plan->cerrado == true)) {

    		if ($request->isMethod('get')) {

	    		$ruta = route('EditarPlan', ['id' => $id]);

                $datos = ['plan' => $plan, 'seccion' => self::SECCION, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

                if (!$request->session()->has('errors')) {
                    
                    toastr()->info(__('messages.required_fields'));
                } else {

                    toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

                }
                

	    		return view('mpmp.editar_plan', $datos);

	    	}else if ($request->isMethod('post')) {

	    		$request->validate([
                    'periodo_unidad_id' => 'bail|numeric|required',
                    'fecha_inicio' => 'date|required',
                    'fecha_final' => 'date|required',
                    'trimestre' => 'numeric|nullable',
                    'monto_aprobado' => 'numeric|nullable',
                ]);

                $plan->fill($request->input());

	    		$plan->save();

                toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

	    		return redirect()->route('VerPlan', ['id' => $id]);

	    	}
    	}else {

            toastr()->error(__('messages.edit_approved_record', strtoupper(__('unauthorized operation'))));

    		return redirect()->route('VerPlan', ['id' => $id]);

    	}

    	
    }

    public function eliminar(Request $request, $id){

    	if ($request->isMethod('post')) {
    		
    		$plan = Plan::findOrFail($id);

            if ($plan->aprobado == true) {
                
                toastr()->error(__('messages.delete_approved_record'), strtoupper(__('unauthorized operation')));
                return redirect()->route('VerPlan', ['id' => $id]);

            }

    		$plan->delete();

            toastr()->success(__('messages.record_deleted'));

    		return redirect()->route('ListaPlanes');
    	}
    }

    public function aprobar($id){

    	$plan = Plan::findOrFail($id);

    	$plan->aprobado = true;

        $plan->cerrado = true;

    	$plan->save();

        toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

    	return redirect()->route('VerPlan', ['id' => $id]);
    }

    public function abrir($id){

        $plan = Plan::findOrFail($id);

        $plan->cerrado = false;

        $plan->save();

        toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

        return redirect()->route('VerPlan', ['id' => $id]);
    }

    public function activar($id){

    	$plan = Plan::findOrFail($id);

        $periodo = $plan->periodo;

        //$tipo = $plan->tipo;

        //$unidad_gestion = $plan->unidadGestion;

        $activo = $periodo->planes->where('activo', true); //Plan::where([['unidad_gestion_id',$unidad_gestion],['tipo',$tipo],['activo',true]]);

        if(isset($activo) && $activo->id != null){

            toastr()->error(__('messages.unable_to_activate'));
            toastr()->info(__('messages.deactivate_plan'));

            return redirect()->route('VerPlan', ['id' => $activo->id]);

        }

    	$plan->activo = true;

    	$plan->save();

    	toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

        return redirect()->route('VerPlan', ['id' => $id]);

    }

    public function cerrar($id){

        $plan = Plan::findOrFail($id);

        //$balance = $plan->resultados[0]->pivot->balance;

        $productos = $plan->productos;

        $pendientes = 0;

        foreach ($productos as $producto) {
            if($producto->pivot->logros == null){
                $pendientes++;
            }
        }

        //$dificultades = $plan->productos[0]->pivot->dificultades;

        if($pendientes > 0){

            toastr()->warning(__('messages.no_plan_report'));

            return redirect()->route('VerPlan', ['id' => $id]);

        }

        $plan->activo = false;

        //$plan->cerrado = true;

        $plan->save();

        toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

        return redirect()->route('VerPlan', ['id' => $id]);

    }

    public function informe(Request $request, MenuBuilder $mb, $id){
        
        $plan = Plan::withCount('actividades')->get($id);

        if ($request->isMethod('get')) {
            
            if ($plan->activo == true) {
                
                $ruta = route('InformePlan', ['id' => $id]);

                $total_actividades = $plan->actividades_count;

                $ejecutadas = 0;

                foreach ($plan->actividades as $actividad) {
                    
                    if ($actividad->ejecutada == true) {
                        
                        $ejecutadas++;

                    }

                }

                $pendientes = $total_actividades - $ejecutadas;

                $datos = ['plan' => $plan, 'actividades' => $total_actividades, 'ejecutadas' => $ejecutadas, 'pendientes' => $pendientes, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu(), 'seccion' => self::SECCION];

                if (!$request->session()->has('errors')) {
                    
                    toastr()->info(__('messages.required_fields'));

                }else{

                    toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

                }

                return view('mpmp.informe_plan', $datos);

            }


        } elseif ($request->isMethod('post')) {

            if ($request->has('productos')) {
                
                //$datos_resultados = $request->datos_resultados;

                $productos = $request->productos;

                //$filas_resultados = count($datos_resultados['resultado_id']);

                $filas_productos = count($productos['producto_id']);

                //$resultados_saved = 0;

                $productos_saved = 0;

                /*
                for ($i=0; $i < $filas_resultados; $i++) { 

                    if (isset($datos_resultados['balance'][$i])) {
                        
                        $plan->resultados()->updateExistingPivot($datos_resultados['resultado_id'][$i],[
                            'balance' => $datos_resultados['balance'][$i]
                        ]);

                        $resultados_saved++;

                    }else{

                        break;

                    }

                }
                */

                for ($i=0; $i < $filas_productos; $i++) { 
                    
                    if (isset($productos['logros'][$i]) && isset($productos['dificultades'][$i])) {
                        
                        $plan->productos()->updateExistingPivot($productos['producto_id'][$i], [
                            'logros' => $productos['logros'][$i],
                            'situacion_resultado' => $productos['situacion_resultado'][$i],
                            'dificultades' => $productos['dificultades'][$i],
                            'soluciones' => $productos['soluciones'][$i],
                        ]);

                        $productos_saved++;

                    } else {

                        break;

                    }
                }

                //Si se envía un documento de informe
                //se procede a guardarlo y ligar la referencia

                if ($request->hasFile('documento') && $request->file('documento')->isValid()) {

                    try {

                        $documento_id = null;

                        $dir_destino = "docs";

                        $nombre = basename($request->documento->path());

                        $extension = $request->documento->extension();

                        $path = $request->documento->store($dir_destino);

                        $documento = new Documento;

                        $documento->descripcion = "Informe de plan {$plan->id}";

                        $documento->tipo_documento = $extension ?:"pdf";

                        $documento->url = $path;

                        $documento->nombre = $nombre;

                        $documento->save();

                        $plan->documentos()->attach($documento);
                        
                    } catch (Exception $e) {

                        $ruta = route('VerPlan', ['id' => $id]);
                        
                        $mensaje = "Ocurrió un problema al guardar el informe. ".$e->getMessage();

                        return view('error', ['titulo' => 'Error Crítico!', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => $mensaje, 'route' => ]);
                    }



                toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));
                toastr()->info("{$productos_saved} ".__('messages.records_updated'));

                return redirect()->route('VerPlan', ['id' => $id]);

            }
            
        }
    }


    public function productos(Request $request, MenuBuilder $mb, $id){

    	$plan = Plan::findOrFail($id);

    	//$no_mod = $this->checkPlan($plan);

    	if ($plan->aprobado && $plan->cerrado) {
    		//return $no_mod;
            toastr()->info(__('messages.edit_approved_record'));
            toastr()->warning(__('messages.unauthorized_operation'));

            return redirect()->route('VerPlan', ['id' => $id]);
    	}

        $ruta = route('PlanProductos', ['id' => $id]);

		if ($request->isMethod('get')) {

            /*
			if ($plan->resultados != null) {
				
				$ruta = route('VerPlan', ['id' => $id]);

				return view('alert', ['titulo' => 'Sin Indicadores de Resultado', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan no posee indicadores de resultado asignados. Revise y vuelva a intentarlo.' => $ruta]);

			}*/
			
			$resultados = $plan->periodo->resultados;

			$productos = collect([]); //$plan->productos;

            foreach ($resultados as $resultado) {
                
                $productos = $productos->union($resultado->productos->where('finalizado', false)->get());
            }

            $datos = ['seccion' => self::SECCION, 'plan' => $plan, 'resultados' => $resultados, 'productos' => $productos, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

			return view('mpmp.plan_productos', $datos);

		} else if ($request->isMethod('post')) {

            $request->validate([
                'producto_id' => 'bail|numeric|required',
                'meta' => 'numeric|required',
                'consolidado_anual' => 'string|required',
                'situacion_inicial' => 'alpha_num|max:500|present',
            ]);

            $producto = $request->all();

            $edit = $plan->productos->where('producto_id', $producto['producto_id'])->get();

            if ($edit->count() > 0) {

                $plan->productos()->updateExistingPivot($producto['producto_id'], [
                    'meta' => $producto['meta'],
                    'consolidado_anual' => $producto['consolidado_anual'],
                    'situacion_inicial' => $producto['situacion_inicial'],
                ]);

            } else {

                $plan->productos()->attach($producto['producto_id'], [
                    'meta' => $producto['meta'],
                    'consolidado_anual' => $producto['consolidado_anual'],
                    'situacion_inicial' => $producto['situacion_inicial'],
                ]);

            }

            toastr()->success(__($edit->count() > 0 ? 'messages.update_success':'messages.registration_success'));


            return redirect()->route('PlanProductos', ['id' => $id]);

		}
    	
    }


    public function remover_producto($id, $pid){

        $plan = Plan::findOrFail($id);

        $ruta = route('PlanProductos', ['id' => $id]);

        if($plan->cerrado == true){

            toastr()->warning(__('messages.edit_closed'), strtoupper(__('unauthorized operation')));

            return redirect($ruta);

        }

        $plan->productos()->detach($pid);

        toastr()->success(__('messages.record_removed'), strtoupper(__('Operation Success')));

        return redirect($ruta);

    }



    public function actividades(Request $request, MenuBuilder $mb, $id){

    	$plan = Plan::findOrFail($id);

        // Verifica si el plan puede ser modificado.
        // La etapa de modificación del plan es mientras no ha sido aprobado 
        // o no se haya cerrado.

    	if($plan->cerrado == true){

            toastr()->warning(__('messages.edit_closed'), strtoupper(__('unauthorized operation')));

            return redirect()->route('VerPlan', ['id' => $id]);

        }

        $ruta = route('PlanActividades', ['id' => $id]);

		if ($request->isMethod('get')) {
			
			if ($plan->productos->count() == 0) {

                toastr()->info(__('messages.no_product_registered'));

                return redirect()route('VerPlan', ['id' => $id]);
				
			}

			$productos = $plan->productos;

			$actividades = collect([]);

            foreach ($productos as $producto) {
                
                $actividades = $actividades->union($producto->actividades->where([['ejecutada', false], ['aprobada', true], ['cancelada', false]]));
            }

            if ($request->session()->has('errors')) {
                
                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            } else {

                toastr()->info(__('messages.required_fields'));

            }

			return view('mpmp.plan_actividades', ['seccion' => self::SECCION, 'productos' => $productos, 'actividades' => $actividades, 'route' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);


		}else if ($request->isMethod('post')) {
			

    		$request->validate([
                'actividad_id' => 'bail|numeric|required',
                'fecha_programada' => 'date|required',
            ]);

            $datos = $request->all();

            $edit = $plan->actividades->get($datos['actividad_id'])->count();

            if ($edit > 0) {
                
                $plan->actividades()->updateExistingPivot($datos['actividad_id'], ['fecha_programada' => $datos['fecha_programada']]);

            } else {

                $plan->actividades()->attach($datos['actividad_id'], ['fecha_programada' => $datos['fecha_programada']]);

            }

            toastr()->success(__($edit > 0 ? 'messages.update_success':'messages.registration_success'), strtoupper(__('Operation Success')));

            return redirect($ruta);
	    	
		}
    	
    }

    public function remover_actividad($id, $aid){

        $plan = Plan::findOrFail($id);

        $actividad = $plan->actividades->get($aid);

        if ($actividad->pivot->ejecutada != true) {
            
            $plan->actividades()->detach($aid);

        } else {

            toastr()->warning(__('messages.remove_executed_activity'), strtoupper(__('unauthorized operation')));

        }

        toastr()->success(__('messages.record_removed'), strtoupper(__('Operation Success')));

        return redirect()->route('VerPlan', ['id' => $id]);

    }


    public function servicios_personales(Request $request, MenuBuilder $mb, $id){

    	$plan = Plan::findOrFail($id);

    	if($plan->cerrado == true){

            toastr()->warning(__('messages.edit_closed'), strtoupper(__('unauthorized operation')));

            return redirect()->route('VerPlan', ['id' => $id]);

        }

        $ruta = route('PlanServiciosPersonales', ['id' => $id]);

    	if ($request->isMethod('get')) {
    		
    		$personal = $plan->personal;

    		

            if ($request->session()->has('errors')) {
                
                toastr()->warning(__('messages.validation_error'), strtoupper(__('Validation Error')));

            } else {

                toastr()->info(__('messages.required_fields'));

            }

    		return view('mpmp.servicios_personales', ['seccion' => self::SECCION, 'plan' => $plan, 'personal' => $personal, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

    	}elseif ($request->isMethod('post')) {

            $request->validate([
                'personal_id' => 'bail|integer|required',
                'personas' => 'integer|required',
                'salario' => 'numeric|required'
            ]);

            $personal = $request->all();

            $count = $plan->personal->where('personal_id', $personal['personal_id'])->count();

            if ($count > 0) {
                
                $plan->personal()->updateExistingPivot($personal['personal_id'], ['personas' => $personal['personas'], 'salario' => $personal['salario']]);

            } else {

                $plan->personal()->attach($personal['personal_id'], ['personas' => $personal['personas'], 'salario' => $personal['salario']]);

            }

            
            toastr()->success(__($count > 0 ? 'messages.update_success':'messages.registration_success'), strtoupper(__('Operation Success')));

            return redirect($ruta);


            // BLOQUE A ELIMINAR
    		/*
    		if ($request->has('datos_servicios')) {
    			
    			$datos = $request->input('datos_servicios');

    			$registrar = function($clasificador_id, $cargo, $cantidad, $salario, $treceavo, $antiguedad, $patronal, $inatec, $beneficios, $vacaciones, $otros, $horas){

    				$servicio = $plan->serviciosPersonales()->where([['clasificador_id', $clasificador_id], ['cargo', $cargo]])->get();

    				if ($servicio == null) {
    					
    					$servicio = new ServicioPersonal();

    					$servicio->clasificador_id = $clasificador_id;

    					$servicio->cargo = $cargo;
    				}

    				
    				$servicio->cantidad_personas = $cantidad;
    				$servicio->salario = $salario;
    				$servicio->treceavo = $treceavo;
    				$servicio->antiguedad = $antiguedad;
    				$servicio->patronal = $patronal;
    				$servicio->inatec = $inatec;
    				$servicio->beneficios = $beneficios;
    				$servicio->vacaciones = $vacaciones;
    				$servicio->otros_beneficios = $otros;
    				$servicio->horas_extra = $horas;

    				if ($servicio->id != null) {
    					$servicio->save();
    				}else{
    					$plan->serviciosPersonales()->save($servicio);
    				}

    			};

    			if (count($datos) > 0) {
    				
    				array_map($registrar, $datos['clasificador_id'], $datos['cargo'], $datos['cantidad'], $datos['salario'], $datos['treceavo'], $datos['antiguedad'], $datos['patronal'], $datos['inatec'], $datos['beneficios'], $datos['vacaciones'], $datos['otros'], $datos['horas']);

    				return redirect()->route('VerPlan');
    				
    			}else{

    				return redirect()->route('error');

    			}


    		}else{

    			return view('alert', ['titulo' => 'Sin datos de servicios', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => 'No se encontraron datos de servicios. Regrese y vuelva a intentarlo.']);

    		}
            */
            //FIN BLOQUE A ELIMINAR

    	}

    }

    /*
    public function informe(Request $request, $id){

        $plan = Plan::findOrFail($id);

        if($plan->cerrado || !$plan->aprobado){

            $ruta = route('VerPlan', ['id' => $id]);

            return view('alert', ['titulo' => 'Plan Activo', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => 'El plan se encuentra cerrado o pendiente de aprobar. No se ingresa el informe de ejecución en esta etapa del plan.', 'route' => $ruta]);
        }else{

            if($request->isMethod('get')){

                $resultados = $plan->resultados;

                $productos = $plan->productos;

                $ruta = route('InformePlan', ['id' => $id]);

                return view('mpmp.formulario_informe', ['titulo' => 'Informe de Ejecución del Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'resultados' => $resultados, 'productos' => $productos, 'route' => $ruta]);

            }elseif ($request->isMethod('post')) 
                
                if ($request->hasFile('documento') && $request->file('documento')->isValid()) {

                    try {

                        $documento_id = null;

                        $dir_destino = "docs";

                        $nombre = basename($request->documento->path());

                        $extension = $request->documento->extension();

                        $path = $request->documento->store($dir_destino);

                        $documento = new Documento;

                        $documento->descripcion = "Informe de plan ". $plan->tipo_plan;

                        $documento->tipo_documento = $extension ?:"pdf";

                        $documento->url = $path;

                        $documento->nombre = $nombre;

                        $documento->save();

                        $plan->documentos()->attach($documento);
                        
                    } catch (Exception $e) {

                        $ruta = route('VerPlan', ['id' => $id]);
                        
                        $mensaje = "Ocurrió un problema al guardar el informe. ".$e->getMessage();

                        return view('error', ['titulo' => 'Error Crítico!', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => $mensaje, 'route' => ]);
                    }

                    $resultados = $plan->resultados;

                    $productos = $plan->productos;

                    $ruta = route('VerPlan', ['id' => $id]);
                    
                    
                    if ($request->has('datos_res')) {
                        
                        $datos_res = $request->datos_res;

                        $registrar = function($rid, $balance){

                            if ($balance !== '') {
                                
                                $plan->resultados()->updateExistingPivot($rid, ['balance_resultado' => $balance]);

                            }
                        };

                        array_map($registrar, $datos_res['rid'], $datos_res['balance']);

                    }

                    if ($request->has('datos_prod')) {
                        
                        $datos_prod = $request->datos_prod;

                        $registrar = function($prid, $logros, $situacion, $dificultades, $soluciones){

                            $plan->productos()->updateExistingPivot($prid, ['logros' => $logros, 'situacion_resultado' => $situacion, 'dificultades' => $dificultades, 'soluciones' => $soluciones]);

                        };

                        array_map($registrar, $datos_prod['logros'], $datos_prod['situacion_resultado'], $datos_prod['dificultades'], $datos_prod['soluciones']);
                    }

                    return redirect()->route('VerPlan', ['id' => $id]);

                }else{

                    $ruta = route('VerPlan', ['id' => $id]);

                    return view('alert', ['titulo' => 'Informe Sin Documento', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => 'El informe del plan debe ir acompañado del documento en formato PDF. No se ingresará el informe de ejecución sin el documento correspondiente.', 'route' => $ruta]);
                }
            }

        }
    }
    

    private function checkPlan($plan){

    	if($plan->aprobado || $plan->cerrado){

			$ruta = route('VerPlan', ['id' => $id]);

			return view('alert', ['titulo' => 'Sin Autorización de Modificar', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan ya fué aprobado o se encuentra cerrado y no puede ser modificado.', 'route' => $ruta]);    		
    	}

    }
    */

}
