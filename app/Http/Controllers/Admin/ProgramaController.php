<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Programa;
use App\Models\UnidadGestion;

class ProgramaController extends Controller
{
    //
    protected $funcionario = Auth::user()->funcionario;
    
    protected $seccion = 'Programas';

    public function ver($id){

    	$funcionario = $this->funcionario;
    	$programa = Programa::findOrFail($id);

    	return view('programas.detalle', ['funcionario' => $funcionario, 'titulo' => 'Detalle del Programa', 'seccion' => 'Programas', 'programa' => $programa]);
    }

    public function nuevo(Request $request){

    	if ($request->isMethod('get')) {

    		$funcionario = $this->funcionario;
    		$programa = new Programa;

    		return view('programas.formulario', ['funcionario' => $funcionario, 'titulo' => 'Ingreso de Programas', 'seccion' => 'Programas', 'programa' => $programa, 'route' => 'NuevoPrograma']);

    	}elseif ($request->isMethod('post')) {

    		if (!$request->has(['codigo_programa', 'descripcion'])) {

    			return redirect()->route('error', ['titulo' => 'Error de Validación', 'mensaje' => 'Hacen falta datos obligatorios. Por favor, revise y vuelva a intentarlo.']);
    		
            }

    		$programa = new Programa;

    		$programa->codigo_programa = $request->codigo_programa;
    		$programa->descripcion = $request->descripcion;
    		$programa->objetivo_general = $request->objetivo_general;

    		$programa->save();

    		return redirect()->route('AdminProgramas');

    	}
    }

    public function editar(Request $request, $id){
    	
    	if ($request->isMethod('get')) {

            $programa = Programa::findOrFail($id);

            if ($programa->finalizado) {

                return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'El programa que busca se encuentra finalizado. Revise y vuelva a intentarlo.', 'funcionario' => $this->funcionario]);

            }

    		$funcionario = $this->funcionario;
    		

    		return view('programas.formulario', ['titulo' => 'Edición de Programa', 'seccion' => 'Programas', 'funcionario' => $funcionario, 'programa' => $programa, 'route' => 'EditarPrograma']);

    	}elseif ($request->isMethod('post')) {

    		if (!$request->has(['codigo_programa', 'descripcion'])) {

    			return redirect()->route('error', ['titulo' => 'Error de Validación', 'mensaje' => 'Hacen falta datos obligatorios. Por favor, revise y vuelva a intentarlo.']);
    		
            }

    		$programa = Programa::findOrFail($id);

    		$programa->codigo_programa = $request->codigo_programa;
    		$programa->descripcion = $request->descripcion;
    		$programa->objetivo_general = $request->objetivo_general;

    		$programa->save();

    		return redirect()->route('AdminProgramas');
    	}
    }

    public function asociar(Request $request, $id){

    	if ($request->isMethod('get')) {

    		$funcionario = $this->funcionario;
    		$programa = Programa::findOrFail($id);
    		$unidades = UnidadGestion::all();

    		return view('programas.asociar', ['titulo' => 'Asociar Programa a Unidad de Gestión', 'seccion' => 'Programas', 'programa' => $programa, 'unidades' => $unidades, 'funcionario' => $funcionario]);

    	}elseif ($request->isMethod('post')) {

    		$programa = Programa::findOrFail($id);
    		$unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);

    		$programa->unidadesGestion()->attach($unidad->id);

    		return redirect()->route('AdminProgramas');
    	}
    }

    public function disociar(Request $request, $id){

        if ($request->isMethod('get')) {

            $funcionario = $this->funcionario;
            $programa = Programa::findOrFail($id);
            $unidades = $programa->unidadesGestion;

            return view('programas.asociar', ['titulo' => 'Remover Programa de Unidad de Gestión', 'seccion' => 'Programas', 'programa' => $programa, 'unidades' => $unidades, 'funcionario' => $funcionario, 'disociar' => true]);

        }elseif ($request->isMethod('post')) {

            $programa = Programa::findOrFail($id);
            $unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);

            $programa->unidadesGestion()->dettach($unidad->id);

            return redirect()->route('AdminProgramas');
        }
    }

    public function eliminar(Request $request, $id){

    	if ($request->isMethod('get')) {

    		$funcionario = $this->funcionario;

            $ruta = route('EliminarPrograma', ['id' => $id]);

    		return view('alert', ['titulo' => 'Eliminar Programa', 'mensaje' => 'Se eliminará el Registro de la base de datos.', 'route' => $ruta, 'funcionario' => $funcionario]);

    	}elseif ($request->isMethod('post')) {
            
    		//Programa::destroy($id);
            $programa = Programa::findOrFail($id);

            $programa->delete();

    		return redirect()->route('AdminProgramas');
    	}
    }
}
