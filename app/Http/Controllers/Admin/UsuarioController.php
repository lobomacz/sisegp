<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
	/**
	* Ingresa un nuevo Usuario
	*
	* @param Request $request
	* @return Response
	*/
    public function nuevo(Request $request){

    	if($request->isMethod('get')){

    		$funcionario = Auth::user()->funcionario;

            $secccion = "Usuarios";

    		$usuario = new User;

    		$funcionarios = App\Models\Funcionario::all()->filter(function($funcionario){

    			return $funcionario->usuario === null;

    		});

    		return view('usuarios.formulario', ['titulo' => 'Ingreso de Usuarios', 'seccion':$seccion, 'funcionarios' => $funcionarios], 'usuario' => $usuario, 'funcionario' => $funcionario);

    	}elseif ($request->isMethod('post')) {

    		if(!$request->has('funcionario_id')){

    			return redirect()->route('error', ['titulo' => 'Error de Vinculación', 'mensaje' => 'El usuario debe corresponder a un funcionario. Por favor, elija el funcionario para el usuario y vuelva a intentarlo.']);

    		}else if(!$request->has(['name', 'email', 'password',])){

    			return redirect()->route('error', ['titulo' => 'Error de Validación', 'mensaje' => 'Hacen falta datos obligatorios. Por favor, revise y vuelva a intentarlo.']);
    		
            }

    		$usuario = new User;

            $funcionario_user = Funcionario::findOrFail($request->funcionario_id);

    		//$usuario->funcionario_id = $request->funcionario_id;
    		$usuario->name = $request->name;

    		$usuario->email = $request->email;

    		$usuario->password = $request->password;

    		//$usuario->save();
            $funcionario_user->usuario()->save($usuario);

    		return redirect()->route('AdminUsuarios');
    	}
    }

    public function ver($id){

    	if($id != null || $id == ''){

    		$funcionario = Auth::user()->funcionario;

            $secccion = "Usuarios";

    		return view('usuarios.perfil', ['usuario' => User::findOrFail($id), 'funcionario' => $funcionario, 'seccion' => $seccion]);

    	}else{

    		return redirect()->route('error', ['titulo' => 'Error de Datos', 'mensaje' => 'El ID no puede estar vacío. Por favor, revise y vuelva a intentarlo.']);

    	}
    }

    /**
    * @param Request $request
    * @param integer $id
    * @return Response
    */
    public function editar(Request $request, $id){

    	if($request->isMethod('get')){

    		$funcionario = Auth::user()->funcionario;

            $secccion = "Usuarios";

    		return view('usuarios.formulario', ['usuario' => User::findOrFail($id), 'funcionario' => $funcionario],'titulo' => 'Modificación de Usuarios', 'seccion':$seccion);

    	}else if($request->isMethod('post')){

    		$usuario = User::find($id);

    		$usuario->name = $request->name;

    		$usuario->email = $request->email;

    		$usuario->save();

    		return redirect()->route('DetalleUsuario', ['id' => $id]);
    	}
    }

    public function eliminar(Request $request, $id){

    	if($request->isMethod('get')){

    		$funcionario = Auth::user()->funcionario;

            $ruta = route('EliminarUsuario', ['id' => $id]);

    		return view('alert', ['funcionario' => $funcionario, 'route' => $ruta, 'titulo' => 'Eliminar Usuario', 'mensaje' => 'Se eliminará el registro de la base de datos.']);
    	
        }else if($request->isMethod('post')){
    		
            $usuario = User::findOrFail($id);

    		$usuario->delete();

    		return redirect()->route('AdminUsuarios');
    	}
    }

    public function desactivar(Request $request, $id){

    	if($request->isMethod('get')){

            $ruta = route('DesactivarUsuario', ['id' => $id]);

    		return view('alert', ['route' => $ruta, 'titulo' => 'Desactivar Usuario', 'mensaje' => 'Se desactivará el usuario y no tendrá acceso al sistema.']);

    	}else if($request->isMethod('post')){

    		$usuario = User::findOrFail($id);

    		$usuario->activo = false;
            
    		$usuario->save();

    		return redirect()->route('AdminUsuarios');
    	}
    }


}
