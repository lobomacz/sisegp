<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;

class AdminController extends Controller
{
    //

    public function __construct(){

    	$this->middleware(['auth', 'check.rol:superusuario', 'language']);

    }


    public function index(){

        $funcionario = Auth::user()->funcionario;
        
        return view('admin.index', ['titulo' => 'Panel de Administración', 'seccion' => 'Dashboard', 'funcionario' => $funcionario, 'backroute' => 'AdminDashboard']);

    }

    public function usuarios($todos=false){

        $usuarios = null;

        $urlTodos = route('AdminUsuarios', ['todos' => true]);

        if($todos){

            $usuarios = App\User::all();

        }else{

            $usuarios = App\User::all()->reject(function($usuario){

                return !$usuario->funcionario->activo;

            });
        }

        

        $funcionario = Auth::user()->funcionario;

        return view('admin.usuarios', ['usuarios' => $usuarios, 'funcionario' => $funcionario, 'titulo' => 'Registro de Usuarios', 'seccion' => 'Usuarios', 'urlTodos' => $urlTodos]);
    }

    public function funcionarios($todos=false){

        $funcionarios = null;

        $urlTodos = route('AdminFuncionarios', ['todos' => true]);

        if($todos){

            $funcionarios = App\Models\Funcionario::all();

        }else{

            $funcionarios = App\Models\Funcionario::all()->reject(function($funcionario){

                return !$funcionario->activo;

            });
        }

        $funcionario = Auth::user()->funcionario;

        return view('admin.funcionarios', ['funcionarios' => $funcionarios, 'funcionario' => $funcionario, 'titulo' => 'Registro de Funcionarios', 'seccion' => 'Funcionarios', 'urlTodos' => $urlTodos]);

    }

    public function programas($todos=false){

        $programas = null;

        $urlTodos = route('AdminProgramas', ['todos' => true]);

        if ($todos) {

            $programas = App\Models\Programa::all();

        }else{

            $programas = App\Models\Programa::all()->filter(function($programa){

                return !$programa->finalizado;

            });
        }

        $funcionario = Auth::user()->funcionario;

        return view('admin.programas', ['programas' => $programas, 'funcionario' => $funcionario, 'titulo' => 'Administración de Programas', 'seccion' => 'Programas GRACCS', 'urlTodos' => $urlTodos]);

    }

    public function proyectos($todos=false){

        $proyectos = null;

        $urlTodos = route('AdminProyectos', ['todos' => true]);

        if($todos){

            $proyectos = App\Models\Proyecto::all();

        }else {

            $proyectos = App\Models\Proyecto::all()->filter(function($proyecto){

               return !$proyecto->finalizado; 

            });
        }

        $funcionario = Auth::user()->funcionario;

        return view('admin.proyectos', ['proyectos' => $proyectos, 'funcionario' => $funcionario, 'titulo' => 'Administración de Proyectos', 'seccion' => 'Proyectos GRACCS', 'urlTodos' => $urlTodos]);
    }

    public function maestros(){
        
        $funcionario = Auth::user()->funcionario;

        return view('admin.maestros', ['funcionario' => $funcionario, 'titulo' => 'Tablas Maestras', 'seccion' => 'Datos Maestros']);
    }


}
