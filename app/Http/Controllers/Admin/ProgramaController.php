<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libreria\MenuBuilder;
use App\Models\Programa;
use App\Models\UnidadGestion;


class ProgramaController extends Controller
{
    
    //
    const SECCION = "programs";
    

    public function lista(MenuBuilder $mb, $page, $todos=null){

        //Variables para el paginador
        $limite = config('variables.limite_lista', 20);

        //Muestra lista de programas en ejecución
        $programas = Programa::where('finalizado', false)->paginate($limite);

        if ($todos === 't') {
            $programas = Programa::withTrashed()->get()->paginate($limite);
        }

        $ruta = route('ListaProgramas', ['page' => 1]);

        return view('programas.lista', ['seccion' => self::SECCION, 'programas' => $programas, 'todos' => $todos, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta]);

    }

    public function ver(MenuBuilder $mb, $id, $trashed=false){

        $programa = $ruta = $ruta_delete = $ruta_edit = $ruta_link = $ruta_recycle = $params = null;


        if ($trashed == true) {

            $programa = Programa::withTrashed()->find($id);

            $params = ['id' => $id, 'trashed' => $trashed];

            $ruta_recycle = route('ReciclarPrograma', ['id' => $programa->id]);

        }else{

            $programa = Programa::findOrFail($id);

            $params = ['id' => $programa->id];

            $ruta_edit = route('EditarPrograma', $params);

            $ruta_link = route('AsociarPrograma', $params);

        }

        $ruta = route('VerPrograma', $params);

        $ruta_delete = route('EliminarPrograma', $params);

        return view('programas.detalle', ['seccion' => self::SECCION, 'programa' => $programa, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'ruta_link' => $ruta_link, 'ruta_recycle' => $ruta_recycle, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta, 'trashed' => $trashed]);
    	
    }

    public function nuevo(Request $request, MenuBuilder $mb){

    	if ($request->isMethod('get')) {

    		$programa = new Programa;

            $ruta = route('NuevoPrograma');

            $datos = ['seccion' => self::SECCION, 'programa' => $programa, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {

                toastr()->info(strtoupper(__('messages.required_fields')));

            }else{

                toastr()->error( strtoupper(__('messages.validation_error')), strtoupper(__('Validation Error')) );

            }
            

    		return view('programas.nuevo', $datos);

    	}else if ($request->isMethod('post')) {

            $request->validate([
                'codigo' => 'bail|unique:programas|alpha_dash|max:45|min:5|required',
                'descripcion' => 'string|max:250|required',
                'objetivo' => 'string|max:1000',
            ]);

            $programa = null;

            try {

                $programa = Programa::create($request->input());

            } catch (Exception $e) {

                error_log("Escepción en nuevo programa: ".$e->getMessage());

            }

            /*
            $programa->fill($request->all());

    		$programa->codigo = $request->codigo;
    		$programa->descripcion = $request->descripcion;
    		$programa->objetivo_general = $request->objetivo_general;

    		$saved = $programa->save();
            */

            if ($programa != null) {
                
                toastr()->success(strtoupper(__('messages.registration_success')), strtoupper(__('Operation Success')));

                return redirect()->route('VerPrograma', ['id' => $programa->id]);

            }else{

                toastr()->error(strtoupper(__('messages.registration_error')), strtoupper(__('Operation Error')));

                return redirect()->route('NuevoPrograma');

            }

    	}
    }

    public function editar(Request $request, MenuBuilder $mb, $id){
    	
    	if ($request->isMethod('get')) {

            $programa = Programa::findOrFail($id);

            if ($programa->finalizado) {

                toastr()->error(strtoupper(__('messages.edit_executed_record')), strtoupper(__('Operation Error')));

                return redirect()->route('error');

                /*
                return view('error', ['titulo' => 'Programa Finalizado', 'seccion' => self::SECCION, 'mensaje' => 'El programa que busca se encuentra finalizado. Revise y vuelva a intentarlo.', 'ruta' => 'AdminProgramas']);
                */

            }

            $ruta = route('EditarPrograma', ['id' => $programa->id]);

            $datos = ['seccion' => self::SECCION, 'programa' => $programa, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];


            if (!$request->session()->has('errors')) {

                toastr()->info(strtoupper(__('messages.required_fields')));

            }else {

                toastr()->error(strtoupper(__('messages.validation_error')), strtoupper(__('Validation Error')));
                
            }

    		return view('programas.editar', $datos);


    	}else if ($request->isMethod('post')) {

    		$request->validate([
                'codigo' => 'bail|unique:programas|alpha_dash|max:45|min:5|required',
                'descripcion' => 'string|max:250|required',
                'objetivo' => 'string|max:1000',
                'fecha_finalizado' => 'required_if:finalizado,true',
            ]);

    		$programa = Programa::findOrFail($id);

            $programa->fill($request->input());
            /*
    		$programa->codigo = $request->codigo;
    		$programa->descripcion = $request->descripcion;
    		$programa->objetivo_general = $request->objetivo_general;
            */
            $programa->finalizado = $request->has('finalizado') ? $request->finalizado : false;
            $programa->fecha_finalizado = $request->has('fecha_finalizado') ? $request->fecha_finalizado:null;

            try {

                $programa->save();

            } catch (Exception $e) {

                error_log("Excepcion al modificar programa. ".$e->getMessage());

                toastr()->error(strtoupper(__('messages.update_error')), strtoupper(__('Operation Error')));

                return redirect()->route('EditarPrograma', ['id' => $programa->id]);

            }
    		

    		return redirect()->route('VerPrograma', ['id' => $programa->id]);
    	}
    }

    public function asociar(Request $request, MenuBuilder $mb, $id){

        $programa = Programa::findOrFail($id);

    	if ($request->isMethod('get')) {

    		$unidades = UnidadGestion::all();

            if ($programa->unidadesGestion->count() > 0) {

                $unidades = $unidades->except($programa->unidadesGestion)->all();

            }

            $ruta = route('AsociarPrograma', ['id' => $programa->id]);

            if (!$request->session()->has('errors')) {

                toastr()->info(__('messages.required_fields'));

            } else {
                toastr()->error(__('messages.validation_error'), __('Validation Error'));
            }

    		return view('programas.asociar', ['seccion' => self::SECCION, 'programa' => $programa, 'unidades' => $unidades, 'ruta' => $ruta, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta]);

    	}else if ($request->isMethod('post')) {

            $request->validate([
                'unidad_gestion_id' => 'bail|integer|required',
                'programa_id' => 'integer|required',
            ]);

    		$unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);

            try {

                $programa->unidadesGestion()->attach($unidad->id);
            
            } catch (Exception $e) {
                
                error_log("Excepción al asociar unidad de gestión al programa. ".$e->getMessage());

                toastr()->error(__("messages.critical_error"), strtoupper(__('Operation Error')));

                return redirect()->route('AsociarPrograma', ['id' => $programa->id]);

            }

    		return redirect()->route('VerPrograma', ['id' => $programa->id]);

    	}
    }

    public function disociar_unidad($id, $idu){

        $programa = Programa::findOrFail($id);

        $unidad = $programa->unidadesGestion->find($idu);

        // $unidad = UnidadGestion::findOrFail($id);

        // $programa = $unidad->programas->find($idu);

        if (isset($unidad)) {
            
            try {

                $programa->unidadesGestion()->dettach($unidad->id);
            
            } catch (Exception $e) {
                
                error_log("Excepción al desligar unidad de gestión de programa. ".$e->getMessage());

                toastr()->error(__("messages.critical_error"), strtoupper(__('Operation Error')));

                return redirect()->route('error');

            }

            return redirect()->route('VerPrograma', ['id' => $programa->id]);

        } 

    }

    public function eliminar($id, $trashed=false){

        try {
            
            if ($trashed == true) {
                
                $programa = Programa::withTrashed()->find($id);

                $programa->forceDelete();

            }else{
                
            //Programa::destroy($id);
            $programa = Programa::findOrFail($id);

            $programa->delete();

            }

        } catch (Exception $e) {
            
            error_log("Excepcion al eliminar programa. ".$e->getMessage());

            toastr()->error(strtoupper(__('messages.critical_error')), strtoupper(__('Operation Error')));

            return redirect()->route('error');
        }


        return redirect()->route('ListaProgramas', ['page' => 1]);
    	
    }

    public function reciclar($id){

        $programa = Programa::onlyTrashed()->find($id)->get();

        $programa->restore();

        toastr()->info(__('messages.record_restored'), strtoupper(__('record restored')));

        return redirect()->route('VerPrograma', ['id' => $programa->id]);
    }
}
