<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\UnidadMedida;

class ActividadController extends Controller
{
    //
    protected $funcionario = Auth::user()->funcionario;

    protected $seccion = "Actividades";

    public function index($id){

    	$producto = Producto::findOrFail($id);

    	$actividades = $producto->actividades;

    	return view('mpmp.indice_actividades', ['titulo' => 'Actividades del producto', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'producto' => $producto, 'actividades' => $actividades]);

    }

    public function nuevo(Request $request, $id){

    	$producto = Producto::findOrFail($id);

    	if($request->isMethod('get')){

    		$actividad = new Actividad;

    		return view('mpmp.formulario_actividad', ['titulo' => 'Nueva Actividad del producto', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'producto' => $producto, 'actividad' => $actividad]);

    	}elseif ($request->isMethod('post')) {
    		
    		if (!$request->has(['producto_id', 'codigo', 'descripcion', 'fuente_financiamiento', 'monto_presupuesto'])) {
    			
    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Los campos codigo, id de producto, monto y descripción son obligatorios.', 'funcionario' => $this->funcionario]);
    		}else{

    			$actividad = new Actividad;

    			$actividad->codigo = $request->codigo;
    			$actividad->descripcion = $request->descripcion;
    			$actividad->fuente_financiamiento = $request->fuente_financiamiento;
    			$actividad->monto_presupuesto = $request->monto_presupuesto;

    			$producto->actividades()->save($actividad);

    			return redirect()->route('IndiceActividades', ['id' => $id]);

    		}
    	}
    }

    public function ver($id, $id_act){

    	$producto = Producto::findOrFail($id);

    	$actividad = $producto->actividades->find($id_act)->get();

    	return view('mpmp.detalle_actividad', ['titulo' => 'Detalle de Actividad', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'producto' => $producto, 'actividad' => $actividad]);

    }

    public function editar(Request $request, $id, $id_act){

    	$producto = Producto::findOrFail($id);

    	if($request->isMethod('get')){

    		$actividad = $producto->actividades->find($id_act)->get();

    		return view('mpmp.formulario_actividad', ['titulo' => 'Nueva Actividad del producto', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'producto' => $producto, 'actividad' => $actividad]);

    	}else if($request->isMethod('post')){

    		if (!$request->has(['producto_id', 'codigo', 'descripcion', 'fuente_financiamiento', 'monto_presupuesto'])) {
    			
    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Los campos codigo, id de producto, monto y descripción son obligatorios.', 'funcionario' => $this->funcionario]);
    		}else{

    			$actividad = new Actividad;

    			$actividad->codigo = $request->codigo;
    			$actividad->descripcion = $request->descripcion;
    			$actividad->fuente_financiamiento = $request->fuente_financiamiento;
    			$actividad->monto_presupuesto = $request->monto_presupuesto;

    			$actividad->save();

    			return redirect()->route('IndiceActividades', ['id' => $id]);
    		}
    	}
    }

    public function acciones(Request $request, $id, $id_act){

    	$url = $request->url();

    	$accion = strtolower(explode("/", $url)[-1]);

    	$producto = Producto::findOrFail($id);

    	$actividad = $producto->actividades->find($id_act);

    	switch ($accion) {
    		case 'aprobar':
    			$actividad->aprobada = true;
    			break;
    		case 'cancelar':
    			$actividad->cancelada = true;
    			break;
    		case 'ejecutar':
    			$actividad->ejecutada = true;
    			break;
    		default:
    			return redirect()->route('error');
    			break;
    	}

        $actividad->save();

    	return redirect()->route('IndiceActividades', ['id' => $id])
    }

    public function eliminar(Request $request, $id, $id_act){

    	if($request->isMethod('get')){

    		$ruta = route('EliminarActividad', ['id' => $id, 'id_act' => $id_act]);

    		return view('alert', ['titulo' => 'Eliminar Actividad', 'seccion' => $this->seccion, 'mensaje' => 'Se eliminará el registro de la base de datos permanentemente.', 'route' => $ruta, 'funcionario' => $this->funcionario]);
            
    	}else if($request->isMethod('post')){

    		Actividad::destroy($id_act);

    		return redirect()->route('IndiceActividades', ['id' => $id]);

    	}


    }

    public function insumos(Request $request, $id, $id_act){

    	if ($request->isMethod('get')) {
    		
    		$ruta = route('InsumosActividad', ['id' => $id, 'id_act' => $id_act]);

    		$insumos = Insumo::all();

    		$unidades = UnidadMedida::all();

    		return view('mpmp.insumos_actividad', ['titulo' => 'Asignación de Insumos Por Actividad', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'route' => $ruta, 'insumos' => $insumos, 'unidades' => $unidades]);

    	}elseif ($request->isMethod('post')) {

    		if(!$request->has('actividad_id')){
    			return view('alert', ['titulo' => 'Error de Datos', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => 'Existe inconsistencia en los datos. Revise y vuelva a intentarlo.']);
    		}else{

    			$actividad = Actividad::findOrFail($id_act);

    			$datos = $request->input('insumos', null);

    			$registrar = function($insumo_id, $unidad_medida_id, $costo_unitario, $cantidad){
    				
    				if ($insumo_id != null && $unidad_medida_id != null && $costo_unitario != null && $costo_unitario > 0 && $cantidad != null && $cantidad > 0) {

    					$actividad->insumos()->attach($insumo_id, ['unidad_medida_id' => $unidad_medida_id, 'costo_unitario' => $costo_unitario, 'cantidad' => $cantidad]);

    				}

    			};

    			if ($datos != null) {

                    array_map($registrar, $datos['insumo_id'], $datos['unidad_medida_id'], $datos['costo_unitario'], $datos['cantidad']);

                    return redirect()->route('VerActividad', ['id' => $id, 'id_act' => $id_act]);
                    
                }else{

                    return redirect()->route('error');

                }
    		}
    		
    	}
    }

    public function editar_insumos(Request $request, $id, $id_act){

    	if ($request->isMethod('get')) {
    		
    		$ruta = route('EditarInsumosActividad', ['id' => $id, 'id_act' => $id_act]);

    		$actividad = Actividad::findOrFail($id_act);

    		$insumos_actividad = $actividad->insumos;

    		$insumos = Insumo::all();

    		$unidades = UnidadMedida::all();

    		return view('mpmp.insumos_actividad', ['titulo' => 'Asignación de Insumos Por Actividad', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'route' => $ruta, 'insumos' => $insumos, 'unidades' => $unidades, 'insumos_actividad' => $insumos_actividad]);

    	}elseif ($request->isMethod('post')) {

    		if(!$request->has('actividad_id')){
    			return view('alert', ['titulo' => 'Error de Datos', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'mensaje' => 'Existe inconsistencia en los datos. Revise y vuelva a intentarlo.']);
    		}else{

    			$actividad = Actividad::findOrFail($id_act);

    			$datos = $request->input('insumos', null);

    			$registrar = function($insumo_id, $unidad_medida_id, $costo_unitario, $cantidad){
    				
    				if ($insumo_id != null && $unidad_medida_id != null && $costo_unitario != null && $costo_unitario > 0 && $cantidad != null && $cantidad > 0) {

    					/** El insumo ya existe, se modifica el dato quitando el registro
    					* de la tabla de unión y se vuelve agregar con los nuevos datos.
    					* Si el insumo no existe, se inserta el nuevo registro en la tabla de
    					* unión.
    					*/

    					if($actividad->insumos()->where('id', $insumo_id)->get() != null){

    						$actividad->insumos()->dettach($insumo_id);

    						$actividad->insumos()->attach($insumo_id, ['unidad_medida_id' => $unidad_medida_id, 'costo_unitario' => $costo_unitario, 'cantidad' => $cantidad]);

    					}else{

    						$actividad->insumos()->attach($insumo_id, ['unidad_medida_id' => $unidad_medida_id, 'costo_unitario' => $costo_unitario, 'cantidad' => $cantidad]);

    					}

    				}

    			};

                if ($datos != null) {

                    array_map($registrar, $datos['insumo_id'], $datos['unidad_medida_id'], $datos['costo_unitario'], $datos['cantidad']);

                    return redirect()->route('VerActividad', ['id' => $id, 'id_act' => $id_act]);

                }else{

                    return redirect()->route('error');

                }

    			
    		}
    		
    	}
    }

    

    public function informe($id, $id_act){

    }

    public function documento_informe($id, $id_act, $tipo){
    	
    }

}
