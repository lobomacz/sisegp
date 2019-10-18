<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Resultado;
use App\Models\UnidadMedida;

class ProductoController extends Controller
{
    //
    protected $funcionario = Auth::user()->funcionario;
    
    protected $seccion = "Indicadores de Producto";

    public function index($id){

    	 $resultado = Resultado::findOrFail($id);

    	 $productos = $resultado->productos;

    	 return view('mpmp.indice_productos', ['titulo' => 'Lista de Indicadores de Producto', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'resultado' => $resultado, 'productos' => $productos]);

    }

    public function nuevo(Request $request, $id){

    	if ($request->isMethod('get')) {

    		$unidades = UnidadMedida::all();
    		$producto = new Producto;

            $ruta = route('NuevoProducto', ['id' => $id]);

    		return view('mpmp.formulario_producto', ['titulo' => 'Ingreso de Indicadores de Producto', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'resultado_id' => $id, 'producto' => $producto, 'route' => $ruta, 'unidades' => $unidades]);

    	}elseif ($request->isMethod('post')) {

    		if (!$request->has(['codigo_producto', 'descripcion'])) {

    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Los campos codigo de producto y descripción son obligatorios.', 'funcionario' => $this->funcionario]);

    		}else{

    			$resultado = Resultado::findOrFail($id);
    			$producto = new Producto;

    			$producto->codigo_producto = $request->codigo_producto;
    			$producto->descripcion = $request->descripcion;
    			$producto->formula = $request->formula;
    			$producto->unidad_medida_id = $request->unidad_medida_id;

    			$resultado->productos()->save($producto);

    			return redirect()->route('IndiceProductos', ['id' => $id]);

    		}
    	}
    }

    public function ver($id, $id_prod){

    	$producto = Producto::findOrFail($id_prod);

    	return view('mpmp.detalle_producto', ['titulo' => 'Datos de Indicador de Producto', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'producto' => $producto, 'id_resultado' => $id]);

    }

    public function editar(Request $request, $id, $id_prod){

    	if ($request->isMethod('get')) {

    		$producto = Producto::findOrFail($id_prod);
    		$unidades = UnidadMedida::all();
            $ruta = route('EditarProducto', ['id' => $id, 'id_prod' => $id_prod]);

    		return view('mpmp.formulario_producto', ['titulo' => 'Edición de Datos de Indicador de Producto', 'funcionario' => $this->funcionario, 'seccion' => $this->seccion, 'resultado_id' => $id, 'producto' => $producto, 'route' => $ruta, 'unidades' => $unidades]);

    	}else if($request->isMethod('post')){

    		if (!$request->has(['codigo_producto', 'descripcion'])){

    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Los campos codigo de producto y descripción son obligatorios.', 'funcionario' => $this->funcionario]);
    			
    		}else{

    			$producto = Producto::findOrFail($id_prod);

    			$producto->codigo_producto = $request->codigo_producto;
    			$producto->descripcion = $request->descripcion;
    			$producto->formula = $request->formula;
    			$producto->unidad_medida_id = $request->unidad_medida_id;

    			$producto->save();

    			return redirect()->route('IndiceProductos', ['id' => $id]);

    		}

    	}
    }

    public function aprobar($id, $id_prod){

    	$producto = Producto::findOrFail($id_prod);

    	$producto->aprobado = true;
    	$producto->save();

    	return redirect()->route('IndiceProductos', ['id' => $id]);
        
    }

    public function eliminar(Request $request, $id, $id_prod){

    	if ($request->isMethod('get')) {

            $ruta = route('EliminarProducto', ['id' => $id, 'id_prod' => $id_prod]);

    		return view('alert', ['titulo' => 'Eliminar Indicador de Producto', 'seccion' => $this->seccion, 'mensaje' => 'Se eliminará el registro de la base de datos', 'funcionario' => $this->funcionario, 'route' => $ruta]);
            
    	}else if ($request->isMethod('post')) {
    		
    		$producto = Producto::findOrFail($id_prod);

    		$producto->delete();

    		return redirect()->route('IndiceProductos', ['id' => $id]);
    	}
    }
}
