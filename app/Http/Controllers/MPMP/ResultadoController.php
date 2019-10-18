<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UnidadGestion;
use App\Models\UnidadMedida;
use App\Models\Resultado;
use App\Models\Proyecto;

class ResultadoController extends Controller
{
    protected $funcionario = Auth::user()->funcionario;
    
    protected $seccion = 'Indicadores de Resultado';

    /**
    * Indice de resultados
    *
    * Se muestra opción de selección por proyecto y por unidad de gestión si el usuario validado posee rol 
    * de superusuario, director, director-seplan o director-ejecutivo. Caso contrario, se presenta selección
    * por proyecto correspondiente a la unidad de gestión del usuario validado.
    * La plantilla mostrará dos formularios con lista desplegable para seleccionar Unidad de Gestión
    * y en la segunda lista, Proyecto. Cada formulario dirigirá a un controlador según corresponda
    * con el dato seleccionado de la lista desplegable.
    */

    public function index(){

    	$proyectos = null;
    	$unidades = null;

    	if ($this->funcionario->tieneRol('superusuario') || $this->funcionario->tieneRol('director') || $this->funcionario->tieneRol('director-seplan') || $this->funcionario->tieneRol('director-ejecutivo')) {

    		$unidades = UnidadGestion::all();
    		$proyectos = Proyecto::all()->filter(function($proyecto){
    			return !$proyecto->ejecutado;
    		});

    		if ($proyectos == null && $unidades == null) {
    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Debe seleccionar un proyecto o una unidad de gestión', 'funcionario' => $this->funcionario]);
    		}

    		return view('mpmp.resultados_unidad' ['titulo' => 'Lista General de Resultados', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'unidades' => $unidades, 'proyectos' => $proyectos]);

    		
    	}else{

    		$proyectos = $this->funcionario->unidadGestion->proyectos;

    		return view('mpmp.resultados_unidad' ['titulo' => 'Resultados por Unidad de Gestión', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'proyectos' => $proyectos]);
    	}
    }

    public function resultadosProyecto(Request $request){

    	if ($request->has('proyecto_id')) {

    		$proyecto = Proyecto::findOrFail($request->proyecto_id);
    		$resultados = $proyecto->resultados;

    		return view('mpmp.resultados_proyecto', ['titulo' => 'Indicadores de Resultado para el proyecto', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'resultados' => $resultados, 'ver' => true, 'proyecto' => $proyecto]);
            
    	}else{
    		return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Debe seleccionar un proyecto para el indicador. Revise y vuelva a intentarlo.', 'funcionario' => $this->funcionario]);
    	}
    }

    public function resultadosUnidad(Request $request){
    	
    	if ($request->has('unidad_gestion_id')) {

    		$unidad_gestion = UnidadGestion::findOrFail($request->unidad_gestion_id);
    		$proyectos = $unidad_gestion->proyectos->where('ejecutado', false)->get();

    		return view('mpmp.resultados_unidad', ['titulo' => 'Indicadores de Resultado', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'unidad_gestion' => $unidad_gestion, 'ver' => true, 'proyectos' => $proyectos]);
    	}else{
    		return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Debe seleccionar una unidad de gestion para listar los resultados. Revise y vuelva a intentarlo.', 'funcionario' => $this->funcionario]);
    	}
    }

    public function nuevo(Request $request){
    	if ($request->isMethod('get')) {

    		$unidad_gestion = $this->funcionario->unidadGestion;
    		$unidades_medida = UnidadMedida::all();
    		$proyectos = $unidad_gestion->proyectos;
    		$resultado = new Resultado;

    		return view('mpmp.formulario_resultado', ['titulo' => 'Ingreso de Indicadores de Resultado', 'seccion' => $this->seccion, 'unidad_gestion' => $unidad_gestion, 'proyectos' => $proyectos, 'resultado' => $resultado, 'route' => 'NuevoResultado', 'unidades' => $unidades_medida, 'funcionario' => $this->funcionario]);

    	}else if($request->isMethod('post')){

    		if (!$request->has('proyecto_id')) {
    			return redirect()->route('error');
    		}else {

    			$resultado = new Resultado;
    			$proyecto = Proyecto::findOrFail($request->proyecto_id);

    			$resultado->codigo = $request->codigo;
    			$resultado->descripcion = $request->descripcion;
    			$resultado->formula = $request->formula;
    			$resultado->unidad_medida_id = $request->unidad_medida_id;
    			$proyecto->resultados()->save($resultado);

    			return redirect()->route('IndiceResultados');
    		}
    	}
    }

    public function ver($id){

    	if (is_null($id)) {

    		return redirect()->route('error');

    	}else{

    		$resultado = Resultado::findOrFail($id);

    		return view('mpmp.detalle_resultado', ['titulo' => 'Detalle de Indicador de Resultado', 'secccion' => $this->seccion, 'funcionario' => $this->funcionario, 'resultado' => $resultado]);

    	}

    }

    public function aprobar($id){

    	if (is_null($id)) {

    		return redirect()->route('error');

    	}else{

    		$resultado = Resultado::findOrFail($id);
    		$resultado->aprobado = true;

    		$resultado->save();

    		return redirect()->route('IndiceResultados');

    	}
    }

    public function editar(Request $request, $id){

    	if ($request->isMethod('get')) {

    		$resultado = Resultado::findOrFail($id);
    		$unidades = UnidadMedida::all();
    		$proyectos = $this->funcionario->unidadGestion->proyectos;

    		return view('mpmp.formulario_resultado', ['titulo' => 'Edición de Indicadores de Resultado', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'resultado' => $resultado, 'unidades' => $unidades, 'proyectos' => $proyectos, 'route' => 'EditarResultado']);

    	}else if ($request->isMethod('post')) {

    		if (!$request->has(['proyecto_id', 'unidad_medida_id', 'descripcion'])) {

    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Los datos ingresados no son suficientes. Revise y vuelva a intentarlo.', 'funcionario' => $this->funcionario]);

    		}
    	}
    }

    public function eliminar(Request $request, $id){

    	if($request->isMethod('get')){

            $ruta = route('EliminarResultado', ['id' => $id]);

    		return view('alert', ['titulo' => 'Eliminar Indicador de Resultado', 'seccion' => $this->seccion, 'mensaje' => 'Se eliminará el registro de la base de datos', 'funcionario' => $this->funcionario, 'route' => $ruta]);

    	}elseif ($request->isMethod('post')) {
    		
    		$resultado = Resultado::findOrFail($id);
    		$resultado->delete();
            
    		return redirect()->route('IndiceResultados');
    	}

    }
}
