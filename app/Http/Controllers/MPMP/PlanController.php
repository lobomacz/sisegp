<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Periodo;

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

    	if ($request->isMethod('get')) {

    		$unidad_gestion = $this->funcionario->unidadGestion->get();
    		
    		$plan = Plan::findOrFail($id);

    		///TODO:
    		// Refinar la selección de resultados para que no se repitan los resultados 
    		// que ya fueron asociados al plan
    		
    		$resultados = $plan->resultados;
    		$resultados_proyectos = $unidad_gestion->proyectos()->where('ejecutado', false)->resultados;
    		$resultados_programas = $unidad_gestion->programas()->where('finalizado', false)->proyectos()->where('ejecutado', false)->resultados;

    		return view('mpmp.plan_resultados', ['titulo' => 'Resultados del Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'resultados' => $resultados, 'por_proyecto' => $resultados_proyectos, 'por_programa' => $resultados_programas]);


    	}elseif ($request->isMethod('post')) {
    		
    		if ($request->has('datos_res')) {
    			
    			$plan = Plan::findOrFail($id);

    			if (!($plan->cerrado || $plan->aprobado)) {
    				
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

    				$ruta = route('VerPlan', ['id' => $id]);

    				return view('alert', ['titulo' => 'Sin Autorización de Modificar', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan ya fué aprobado o se encuentra cerrado y no puede ser modificado.', 'route' => $ruta]);

    			}

    		}else{

    			return redirect()->route('error');

    		}

    	}
    }

    public function productos(Request $request, $id){

    	$plan = Plan::findOrFail($id);

    	if ($plan->aprobado || $plan->cerrado) {
    		
    		$ruta = route('VerPlan', ['id' => $id]);

			return view('alert', ['titulo' => 'Sin Autorización de Modificar', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan ya fué aprobado o se encuentra cerrado y no puede ser modificado.', 'route' => $ruta]);
    	}else{

    		if ($request->isMethod('get')) {

    			if ($plan->resultados != null) {
    				
    				$ruta = route('VerPlan', ['id' => $id]);

					return view('alert', ['titulo' => 'Sin Indicadores de Resultado', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan no posee indicadores de resultado asignados. Revise y vuelva a intentarlo.' => $ruta]);

    			}
    			
    			$resultados = $plan->resultados;

    			$productos = $plan->productos;

    			$ruta = route('PlanProductos', ['id' => $id]);

    			return view('mpmp.plan_productos', ['titulo' => 'Productso Por Resultado para el Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'resultados' => $resultados, 'route' => $ruta]);

    		}elseif ($request->isMethod('post')) {
    			
    			if($request->has('datos_prod')){

    				$datos_prod = $request->input('datos_prod');

    				$registrar = function($producto_id, agregar=false){

    					$producto = $plan->productos()->find($producto_id);

    					if ($producto != null && !agregar) {

    						$plan->productos()->dettach($producto_id);

    					}else if($producto == null && agregar){

    						$plan->productos()->attach($producto_id);

    					}

    					
    				};

    				if ($datos_prod != null) {
    					
    					array_map($registrar, $datos_prod['producto_id'], $datos_prod['agregar']);

    					return redirect('VerPlan', ['id' => $id]);

    				}else{

	    				return redirect()->route('error');

	    			}

    			}else{

    				return redirect()->route('error');
    			}
    		}

    	}
    	
    }

    public function actividades(Request $request, $id){

    	$plan = Plan::findOrFail($id);

    	if ($plan->aprobado || $plan->cerrado) {
    		
    		$ruta = route('VerPlan', ['id' => $id]);

			return view('alert', ['titulo' => 'Sin Autorización de Modificar', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan ya fué aprobado o se encuentra cerrado y no puede ser modificado.', 'route' => $ruta]);

    	}else{

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
    			
    			if ($plan->aprobado || $plan->cerrado) {
    		
		    		$ruta = route('VerPlan', ['id' => $id]);

					return view('alert', ['titulo' => 'Sin Autorización de Modificar', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'mensaje' => 'El plan ya fué aprobado o se encuentra cerrado y no puede ser modificado.', 'route' => $ruta]);

		    	}else{

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
    	}
    }
}
