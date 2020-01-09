<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Periodo;
use App\Models\ServicioPersonal;
use App\Models\Documento;

class PlanController extends Controller
{
    //
    protected $funcionario = Auth::user()->funcionario;

    protected $seccion = 'Planes';

    public function lista_planes($tipo, $per = null){

    	$periodo = $per;

    	if ($periodo === null) {
    		
    		$periodo = Periodo::all()->max('id');

    		if ($periodo === null) {
    			
    			return redirect()->route('error');
    		}

    	}

    	$planes = $periodo->planes()->where('tipo_plan', $tipo)->get();

    	return view('mpmp.lista_planes', ['titulo' => 'Lista de Planes del Período', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'planes' => $planes, 'periodo' => $periodo]);

    }

    public function nuevo(Request $request, $per=null){

    	if($request->isMethod('get')){

    		$periodo = Periodo::where('activo', true);

    		$plan = new Plan;

    		$ruta = route('NuevoPlan', ['per' => $periodo->id]);

    		return view('mpmp.formulario_plan', ['titulo' => 'Ingreso de Planes', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'periodo' => $periodo, 'plan' => $plan, 'route' => $ruta]);

    	}else if ($request->isMethod('post')) {

    		if(!$request->has(['fecha_inicio', 'fecha_final'])){

    			return redirect()->route('error');

    		}

    		$unidad_gestion = $this->funcionario->unidadGestion;
    		
    		$periodo = Periodo::find($per);

    		$plan = new Plan;

    		$plan->periodo_id = $periodo->id;
    		$plan->fecha_inicio = $request->fecha_inicio;
    		$plan->fecha_final = $request->fecha_final;
    		$plan->trimestre = $request->trimestre;

    		$unidad_gestion->planes()->save($plan);

    		return redirect()->route('IndicePlanes');

    	}
    }

    public function ver($id){

    	$plan = Plan::findOrFail($id);

    	return view('mpmp.detalle_plan', ['titulo' => 'Detalle de Plan', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'plan' => $plan]);
    }

    public function editar(Request $request, $id){

    	$plan = Plan::findOrFail($id);

    	if (!($plan->aprobado || $plan->cerrado)) {

    		if ($request->isMethod('get')) {

	    		$ruta = route('EditarPlan', ['id' => $id]);

	    		return view('mpmp.formulario_plan', ['titulo' => 'Modificar Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'route' => $ruta]);
	    	}else if ($request->isMethod('post')) {

	    		$plan->tipo_plan = $request->tipo_plan;
	    		$plan->fecha_inicio = $request->fecha_inicio;
	    		$plan->fecha_final = $request->fecha_final;
	    		$plan->trimestre = $request->trimestre;

	    		$plan->save();

	    		return redirect()->route('IndicePlanes');

	    	}
    	}else {
    		return redirect()->route('error');
    	}

    	
    }

    public function eliminar(Request $request, $id){

    	if ($request->isMethod('get')) {
    		
    		$ruta = route('EliminarPlan', ['id' => $id]);

    		return view('alert', ['titulo' => 'Eliminar Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => 'Se eliminará el plan de la base de datos.', 'route' => $ruta]);

    	}else if ($request->isMethod('post')) {
    		
    		$plan = Plan::findOrFail($id);

    		$plan->delete();

    		return redirect()->route('IndicePlanes');
    	}
    }

    public function aprobar($id){

    	$plan = Plan::findOrFail($id);

    	$plan->aprobado = true;

    	$plan->save();

    	return redirect()->route('IndicePlanes');
    }

    public function activar($id){

    	$plan = Plan::findOrFail($id);

    	$plan->activo = true;

    	$plan->save();

    	return redirect()->route('IndicePlanes');
    }

    public function resultados(Request $request, $id){

    	$plan = Plan::findOrFail($id);

    	$no_mod = $this->checkPlan($plan);

    	if ($no_mod != null) {
    		return $no_mod;
    	}

    	if ($request->isMethod('get')) {

    		$unidad_gestion = $this->funcionario->unidadGestion->get();

    		///TODO:
    		// Refinar la selección de resultados para que no se repitan los resultados 
    		// que ya fueron asociados al plan
    		
    		$resultados = $plan->resultados;
    		$resultados_proyectos = $unidad_gestion->proyectos()->where('ejecutado', false)->resultados;
    		$resultados_programas = $unidad_gestion->programas()->where('finalizado', false)->proyectos()->where('ejecutado', false)->resultados;

    		return view('mpmp.plan_resultados', ['titulo' => 'Resultados del Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'resultados' => $resultados, 'por_proyecto' => $resultados_proyectos, 'por_programa' => $resultados_programas]);


    	}elseif ($request->isMethod('post')) {
    		
    		if ($request->has('datos_res')) {
    			
    			
    				
				$datos_res = $request->input('datos_res', null);

    			//Función que recibe cada formulario con datos de post y asocia el resultado al plan
    			$registrar = function($resultado_id, $agregar=false){

    				$resultado = $plan->resultados()->find($resultado_id);

    				if ($resultado != null && !$agregar) {

    					$plan->resultados()->dettach($resultado_id);

    				}else if($resultado == null && $agregar){

    					$plan->resultados()->attach($resultado_id);

    				}
    				
    				
    			};

    			if ($datos_res != null) {
    				
    				array_map($registrar, $datos_res['resultado_id'], $datos_res['agregar']);

    				return redirect()->route('VerPlan', ['id' => $id]);

    			}else{

    				return redirect()->route('error');

    			}

    		}else{

    			return redirect()->route('error');

    		}

    	}
    }

    public function productos(Request $request, $id){

    	$plan = Plan::findOrFail($id);

    	$no_mod = $this->checkPlan($plan);

    	if ($no_mod != null) {
    		return $no_mod;
    	}

		if ($request->isMethod('get')) {

			if ($plan->resultados != null) {
				
				$ruta = route('VerPlan', ['id' => $id]);

				return view('alert', ['titulo' => 'Sin Indicadores de Resultado', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan no posee indicadores de resultado asignados. Revise y vuelva a intentarlo.' => $ruta]);

			}
			
			$resultados = $plan->resultados;

			$productos = $plan->productos;

			$ruta = route('PlanProductos', ['id' => $id]);

			return view('mpmp.plan_productos', ['titulo' => 'Productos Por Resultado para el Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'resultados' => $resultados, 'route' => $ruta]);

		}elseif ($request->isMethod('post')) {
			
			if($request->has('datos_prod')){

				$datos_prod = $request->input('datos_prod');

				$registrar = function($producto_id, $meta, $situacion, $agregar=false){

					$producto = $plan->productos()->find($producto_id);

					if ($producto != null && !agregar) {

						$plan->productos()->dettach($producto_id);

					}else if($producto == null && $agregar){

						$plan->productos()->attach($producto_id, ['meta' => $meta, 'situacion_inicial' => $situacion]);

					}

					
				};

				if ($datos_prod != null) {
					
					array_map($registrar, $datos_prod['producto_id'], $datos_prod['meta'], $datos_prod['situacion'], $datos_prod['agregar']);

					return redirect('VerPlan', ['id' => $id]);

				}else{

    				return redirect()->route('error');

    			}

			}else{

				return redirect()->route('error');
			}
		}

    	
    	
    }

    public function actividades(Request $request, $id){

    	$plan = Plan::findOrFail($id);

        // Verifica si el plan puede ser modificado.
        // La etapa de modificación del plan es mientras no ha sido aprobado 
        // o no se haya cerrado.

    	$no_mod = $this->checkPlan($plan); 

    	if ($no_mod != null) {
    		return $no_mod;
    	}

		if ($request->isMethod('get')) {
			
			if ($plan->productos != null) {
				
				$ruta = route('VerPlan', ['id' => $id]);

				return view('alert', ['titulo' => 'Sin Indicadores de Producto', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan no posee indicadores de producto asignados. Revise y vuelva a intentarlo.' => $ruta]);

			}

			$productos = $plan->productos;

			$actividades = $plan->actividades;

			$ruta = route('PlanActividades', ['id' => $id]);

			return view('mpmp.plan_actividades', ['titulo' => 'Selección de Actividades del Plan', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'producto' => $producto, 'actividades' => $actividades, 'route' => $ruta]);


		}else if ($request->isMethod('post')) {
			

    		if(!$request->has('datos_act')){

    			$ruta = route('VerPlan', ['id' => $id]);

				return view('alert', ['titulo' => 'Sin Datos de Actividades', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'No se encontraron datos de actividades seleccionadas. Por favor, vuelva a intentarlo.', 'route' => $ruta]);

    		}else{

    			$productos = $plan->productos;

    			$datos_act = $request->input('datos_act');

    			$registrar = function($actividad_id, $agregar=false){

    				$actividad = $plan->actividades()->find($actividad_id);

    				if ($actividad != null && !agregar) {
    					
    					$plan->actividades()->dettach($actividad_id);

    				}else if($actividad == null && agregar){

    					$plan->actividades()->attach($actividad_id);

    				}

    			};

    			if ($datos_act != null) {
    				
    				array_map($registrar, $datos_act['actividad_id'], $datos_act['agregar']);

    				return redirect()->route('VerPlan');

    			}else{

    				return redirect()->route('error');

    			}

    		}
	    	
		}
    	
    }

    public function servicios_personales(Request $request, $id){

    	$plan = Plan::findOrFail($id);

    	$no_mod = $this->checkPlan($plan);

    	if ($no_mod != null) {

    		return $no_mod;

    	}

    	if ($plan->tipo_plan !== 'anual') {

    		return redirect()->route('error');

    	}

    	if ($request->isMethod('get')) {
    		
    		$servicios = $plan->serviciosPersonales;

    		$ruta = route('PlanServiciosPersonales', ['id' => $id]);

    		return view('mpmp.formulario_servicios_personales', ['titulo' => 'Servicios Personales', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'servicios' => $servicios, 'route' => $ruta]);

    	}elseif ($request->isMethod('post')) {
    		
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
    	}

    }

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
}
