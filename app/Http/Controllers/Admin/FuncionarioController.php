<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UnidadGestion;
use App\Models\Funcionario;


class FuncionarioController extends Controller
{
    //
    protected $seccion = 'Funcionarios';
    
    protected $funcionario = Auth::user()->funcionario;

    public function ver($id)
    {
    	$funcionario_act = $this->funcionario;
    	$funcionario = Funcionario::findOrFail($id);

    	return view('funcionarios.detalle', ['funcionario' => $funcionario_act, 'datos_funcionario' => $funcionario, 'titulo' => 'Datos del Funcionario', 'seccion' => $this->seccion]);
    }

    public function nuevo(Request $request)
    {
    	if($request->isMethod('get')){
    		$funcionario = $this->funcionario;
    		$seccion = $this->seccion;
    		$nuevo_func = new Funcionario;
    		$unidades = UnidadGestion::all();

    		return view('funcionarios.formulario', ['titulo' => 'Ingreso de Funcionario', 'secccion' => $secccion, 'funcionario' => $funcionario, 'datos_funcionario' => $nuevo_func, 'route' => 'NuevoFuncionario', 'unidades' => $unidades]);
    	}elseif ($request->isMethod('post')) {
    		if (!$request->has(['cedula', 'primer_nombre', 'primer_apellido', 'correo'])) {
    			return redirect()->route('error');
    		}else{
    			$unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);
    			$funcionario = new Funcionario;

    			$funcionario->cedula = $request->cedula;
    			$funcionario->primer_nombre = $request->primer_nombre;
    			$funcionario->segundo_nombre = $request->has('segundo_nombre') ? $request->segundo_nombre:'';
    			$funcionario->primer_apellido = $request->primer_apellido;
    			$funcionario->segundo_apellido = $request->has('segundo_apellido') ? $request->segundo_apellido:'';
    			$funcionario->sexo = $request->sexo;
    			$funcionario->fecha_nacimiento = $request->fecha_nacimiento;
    			$funcionario->cargo = $request->cargo;
    			$funcionario->correo = $request->correo;
    			$funcionario->activo = $request->activo;

    			$unidad->funcionarios()->save($funcionario);
    			//$funcionario->save()
    			return redirect()->route('AdminFuncionarios');

    		}
    	}
    }

    public function editar(Request $request, $id){

    	if ($request->isMethod('get')) {

    		$funcionario = $this->funcionario;
    		$seccion = $this->seccion;
    		$funcionario_edit = Funcionario::findOrFail($id);
    		$unidades = UnidadGestion::all();

    		return view('funcionarios.formulario', ['titulo' => 'Modificación de Funcionario', 'seccion' => $seccion, 'funcionario' => $funcionario, 'datos_funcionario' => $funcionario_edit, 'route' => 'EditarFuncionario', 'id' => $id, 'unidades' => $unidades]);

    	}elseif ($request->isMethod('post')) {
    		
    		$unidad = UnidadGestion::findOrFail($request->unidad_gestion_id)

			$funcionario->cedula = $request->cedula;
			$funcionario->primer_nombre = $request->primer_nombre;
			$funcionario->segundo_nombre = $request->has('segundo_nombre') ? $request->segundo_nombre:'';
			$funcionario->primer_apellido = $request->primer_apellido;
			$funcionario->segundo_apellido = $request->has('segundo_apellido') ? $request->segundo_apellido:'';
			$funcionario->sexo = $request->sexo;
			$funcionario->fecha_nacimiento = $request->fecha_nacimiento;
			$funcionario->cargo = $request->cargo;
			$funcionario->correo = $request->correo;
			$funcionario->activo = $request->activo;

			$funcionario->unidadGestion()->associate($unidad);
			$funcionario->save()

			return redirect()->route('AdminFuncionarios');

    	}

    }

    public function desactivar(Request $request, $id){

    	if ($request->isMethod('get')) {

    		return view('alert', ['titulo' => 'Desactivar Funcionario', 'seccion' => 'Funcionarios', 'mensaje' => 'El funcionario será desactivado junto con su usuario y no tendrá acceso al sistema.', 'id' => $id, 'route' => 'DesactivarFuncionario']);

    	}elseif ($request->isMethod('post')) {
    		
    		$funcionario = Funcionario::findOrFail($id);
    		$usuario = $funcionario->usuario;

    		$usuario->activo = false;
    		$usuario->save();

    		$funcionario->activo = false;
    		$funcionario->save();

    		return redirect()->route('AdminFuncionarios');
    	}
    }

    public function eliminar(Request $request, $id){

    	if ($request->isMethod('get')) {

    		return view('alert', ['titulo' => 'Eliminar Funcionario', 'seccion' => 'Funcionarios', 'mensaje' => 'El funcionario será eliminado de la base de datos junto con su usuario y no tendrá acceso al sistema.', 'id' => $id, 'route' => 'EliminarFuncionario']);

    	}elseif ($request->isMethod('post')) {
    		
    		$funcionario = Funcionario::findOrFail($id);
    		$funcionario->delete();

    		return redirect()->route('AdminFuncionarios');
    	}
    }
}
