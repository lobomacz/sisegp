<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libreria\MenuBuilder;
use App\Models\UnidadGestion;
use App\Models\UnidadMedida;
use App\Models\Resultado;
use App\Models\Proyecto;
use Auth;

class ResultadoController extends Controller
{

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
    const SECCION = 'result indicators';

    public function lista(MenuBuilder $mb, $page, $todos=null){

        $proyectos = null;
        $funcionario = Auth::user()->funcionario;
        $limite = config('variables.limite_lista', 20);
        $ruta = route('ListaResultados', ['page' => $page, 'todos' => $todos]);

        if ($funcionario->tieneRol('superusuario') || $funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('director-ejecutivo')){

            $unidades = UnidadGestion::all();
            
            $proyectos = Proyecto::all()->filter(function($proyecto){

              return !$proyecto->ejecutado;

            })->paginate($limite);

            if (isset($todos) && $todos == 't') {
                
                $proyectos = Proyecto::all()->paginate($limite);
            }


            return view('mpmp.lista_resultados', ['seccion' => self::SECCION, 'unidades' => $unidades, 'proyectos' => $proyectos, 'todos' => $todos, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

        } else {

            if (isset($todos) && $todos == 't') {
                
                $proyectos = $funcionario->unidadGestion->proyectos;
            }else {
                $proyectos = $funcionario->unidadGestion->proyectos->filter(function($proyecto){
                    return !$proyecto->ejecutado;
                });
            }   

            return view('mpmp.Lista_resultados_unidad', ['seccion' => self::SECCION, 'proyectos' => $proyectos, 'todos' => $todos, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

        }
    }


    public function lista_filtro(MenuBuilder $mb, $filtro, $valor, $page, $todos=null){

        $funcionario = Auth::user()->funcionario;
        $limite = config('variables.limite_lista', 20);
        $ruta = route('ListaResultadosFiltro', ['page' => $page, 'filtro' => $filtro, 'todos' => $todos]);

        if ($funcionario->tieneRol('superusuario') || $funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('director-ejecutivo')){

            if ($filtro === 'proyecto') {
                
                /*
                $proyecto = Proyecto::findOrFail($valor);

                $resultados = $proyecto->resultados->paginate($limite);

                $datos = ['seccion' => self::SECCION, 'backroute' => $ruta, 'proyecto' => $proyecto, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()];

                return view('mpmp.lista_resultados_proyecto', $datos);
                */
                //$datos = ['seccion' => self::SECCION, 'backroute' => $ruta, 'proyecto' => $proyecto, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()];

                $this->filtro_proyecto($valor, $ruta);

            } elseif ($filtro === 'unidad-gestion') {
                
                $unidad = UnidadGestion::findOrFail($valor);

                $proyectos = $unidad->proyectos->where('ejecutado', false)->get();

                if (isset($todos) && $todos == 't') {
                    
                    $proyectos = $unidad->proyectos;
                }

                $datos = ['seccion' => self::SECCION, 'backroute' => $ruta, 'unidad' => $unidad, 'proyectos' => $proyectos, 'menu_list' => $mb->getMenu()];

                return view('Lista_resultados_unidad', $datos);

            }

        } elseif ($funcionario->tieneRol('digitador') || $funcionario->tieneRol('digitador-adq')) {

            /*
            $proyecto = Proyecto::findOrFail($valor);

            $resultados = $proyecto->resultados->paginate($limite);

            $datos = ['seccion' => self::SECCION, 'backroute' => $ruta, 'proyecto' => $proyecto, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()];

            return view('mpmp.lista_resultados_proyecto', $datos);
            */
            //$datos = ['seccion' => self::SECCION, 'backroute' => $ruta, 'proyecto' => $proyecto, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()];

            $this->filtro_proyecto($valor, $ruta);
            
        } else {

            toastr()->error(__('messages.unauthorized_operation'), 'Error');

            return redirect()->route('ListaResultados', ['page' => 1]);

        }

    }

    private function filtro_proyecto(MenuBuilder $mb, $valor, $ruta){

        $proyecto = Proyecto::findOrFail($valor);

        $resultados = $proyecto->resultados;

        $datos = ['seccion' => self::SECCION, 'backroute' => $ruta, 'proyecto' => $proyecto, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()];

        return view('mpmp.lista_resultados_proyecto', $datos);

    }

    public function nuevo(Request $request, MenuBuilder $mb){

        if($request->isMethod('get')){

            $funcionario = Auth::user()->funcionario;

            $unidad_gestion = $funcionario->unidadGestion;
            $unidades_medida = UnidadMedida::all();
            $proyectos = $unidad_gestion->proyectos->where('ejecutado', false)->get();
            $resultado = new Resultado;
            $ruta = route('NuevoResultado');

            if (!$request->session()->has('errors')) {
                # code...
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Valudation Error')));

            }

            return view('mpmp.nuevo_resultado', ['seccion' => self::SECCION, 'unidad_gestion' => $unidad_gestion, 'proyectos' => $proyectos, 'resultado' => $resultado, 'ruta' => $ruta, 'backroute' => $ruta, 'unidades' => $unidades_medida, 'menu_list' => $mb->getMenu()]);


        } elseif ($request->isMethod('post')) {
            
            $request->validate([
                'proyecto_id' => 'bail|integer|required',
                'codigo' => 'alpha_dash|max:3|min:3|required',
                'descripcion' => 'alpha_dash|max:400|required',
                'formula' => 'string|max:200|nullable',
                'unidad_medida_id' => 'integer|required',
            ]);

            $resultado = null;

            try {

                $resultado = Resultado::create($request->input());
                
            } catch (Exception $e) {
                
                error_log('Excepción al crear nuevo resultado. '.$e->getMessage());

                toastr()->error(__('messages.registration_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
            }

            if (isset($resultado)) {
                
                return redirect()->route('VerResultado', ['id' => $resultado->id]);

            }

        }
    }

    public function ver(MenuBuilder $mb, $id){

        $resultado = Resultado::findOrFail($id);

        $ruta = route('VerResultado', ['id' => $id]);
        $ruta_delete = route('EliminarResultado', ['id' => $id]);
        $ruta_edit = route('EditarResultado', ['id' => $id]);
        $ruta_aprobar= route('AprobarResultado', ['id' => $id]);

        return view('mpmp.ver_resultado', ['secccion' => self::SECCION, 'resultado' => $resultado, 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'ruta_aprobar' => $ruta_aprobar, 'menu_list' => $mb->getMenu()]);

    }

    public function aprobar($id){

        $resultado = Resultado::findOrFail($id);

        try {

            $resultado->aprobado = true;

            $resultado->save();
            
        } catch (Exception $e) {

            error_log("Excepción al aprobar resultado. ".$e->getMessage());

            toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

            return redirect()->route('error');

        }
        

        return redirect()->route('VerResultado', ['id' => $id]);

    }

    public function editar(Request $request, MenuBuilder $mb, $id){

        $resultado = Resultado::findOrFail($id);

        if ($request->isMethod('get')) {
            # code...
            if ($resultado->aprobado) {
                
                toastr()->error(__('messages.edit_approved_record'), strtoupper(__('clearance violation')));

                return redirect()->route('ListaResultados', ['page' => 1]);
                
            }

            $unidades = UnidadMedida::all();
            $proyectos = $funcionario->unidadGestion->proyectos->where('ejecutado', false)->get();
            $ruta = route('EditarResultado', ['id' => $id]);

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            }else{

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

            return view('mpmp.editar_resultado', ['seccion' => self::SECCION, 'resultado' => $resultado, 'unidades' => $unidades, 'proyectos' => $proyectos, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()]);

        } elseif ($request->isMethod('post')) {
            # code...
            $request->validate([
                'proyecto_id' => 'bail|integer|required',
                'codigo' => 'alpha_dash|max:3|min:3|required',
                'descripcion' => 'alpha_dash|max:400|required',
                'formula' => 'string|max:200|nullable',
                'unidad_medida_id' => 'integer|required',
            ]);

            try {

                $resultado->fill($request->input());

                $resultado->save();
                
            } catch (Exception $e) {
                
                error_log("Excepción al actualizar resultado. ".$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');

            }

            return redirect()->route('VerResultado', ['id' => $resultado->id]);

        }
    }

    public function eliminar($id){

        $resultado = Resultado::findOrFail($id);

        try {

            $resultado->delete();
            
        } catch (Exception $e) {

            error_log("Excepción al eliminar resultado. ".$e->getMessage());

            toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

            return redirect()->route('error');
            
        }

        return redirect()->route('ListaResultados', ['page' => 1]);
        
    }


    public function ingresar_productos(Request $request, MenuBuilder $mb, $id){

        $resultado = Resultado::findOrFail($id);

        $ruta = route('IngresarProductosResultado', ['id' => $id]);

        if ($request->isMethod('get')) {
            # code...
            $extra_rows = config('variables.extra_rows');
            
        } else if ($request->isMethod('post')) {
            # code...
        }
    }



}