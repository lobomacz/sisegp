<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Libreria\MenuBuilder;
use App\Models\Proyecto;
use App\Models\UnidadGestion;
use App\Models\Programa;
use App\Models\SectorDesarrollo;

class ProyectoController extends Controller
{
    //
    
    const SECCION = 'projects';

    public function lista(MenuBuilder $mb, $page, $todos=null){

        $limite = config('variables.limite_lista', 20);


        $proyectos = Proyecto::where('ejecutado', false)->paginate($limite);

        if ($todos === 't') {
            $proyectos = Proyecto::withTrashed()->get()->paginate($limite);
        }

        $ruta = route('ListaProyectos', ['page' => 1]);

        return view('proyectos.lista', ['seccion' => self::SECCION, 'todos' => $todos, 'proyectos' => $proyectos, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta]);

    }

    public function ver(MenuBuilder $mb, $id, $trashed=false)
    {

        $proyecto = $ruta = $ruta_edit = $ruta_delete = $ruta_link = $ruta_comunidad = $ruta_recycle = $params = null;


        if ($trashed == true) {
            
            $proyecto = Proyecto::withTrashed()->find($id);

            $params = ['id' => $proyecto->id, 'trashed' => $trashed];

            $ruta_recycle = route('ReciclarProyecto', ['id' => $proyecto->id]);

        }else{

            $proyecto = Proyecto::findOrFail($id);

            $params = ['id' => $proyecto->id];

            $ruta_edit = route('EditarProyecto', $params);

            $ruta_link = route('AsociarProyectoUnidad', $params);

            $ruta_comunidad = route('AsociarProyectoComunidad', $params);

        }

        $ruta = route('VerProyecto', $params);

        $ruta_delete = route('EliminarPoyecto', $params);
    	

    	return view('proyectos.detalle', ['titulo' => 'Detalle de Proyecto', 'seccion' => self::SECCION, 'proyecto' => $proyecto, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'ruta_link' => $ruta_link, 'ruta_comunidad' => $ruta_comunidad, 'ruta_recycle' => $ruta_recycle, 'trashed' => $trashed]);
    }

    public function nuevo(Request $request, MenuBuilder $mb)
    {
    	if($request->isMethod('get')){

    		$proyecto = new Proyecto;
            $programas = Programa::where('finalizado', false)->get();
            $sectores = SectorDesarrollo::all();
    		$funcionario = $this->funcionario;

            $ruta = route('NuevoProyecto');

            $datos = ['titulo' => 'Ingreso de Proyecto', 'seccion' => self::SECCION, 'proyecto' => $proyecto, 'ruta' => $ruta, 'backroute' => $ruta, 'programas' => $programas, 'sectores' => $sectores, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {

                toastr()->info(__('messages.required_fields'));

            }else {

                toastr()->error(__('messages.validation_error'), __('Validation Error'));

            }

    		return view('proyectos.nuevo', $datos);

    	}else if($request->isMethod('post')){

            $request->validate([
                'codigo' => 'bail|unique:proyectos|alpha_dash|max:45|required',
                'programa_id' => 'numeric|required',
                'acronimo' => 'alpha_num|max:25|required',
                'descripcion' => 'alpha_num|max:250|required',
                'objetivo' => 'alpha_num|max:1000|nullable',
                'fecha_inicio' => 'date|required',
                'fecha_final' => 'date|nullable',
                'sector_desarrollo_id' => 'numeric|required',
                'presupuesto' => 'numeric|required'
            ]);

            $proyecto = null;

            try {

                $proyecto = Proyecto::create($request->input());
                
            } catch (Exception $e) {

                error_log("Excepción en nuevo proyecto: ".$e->getMessage());
                
            }

            if ($proyecto != null) {
                
                toastr()->success(__('messages.registration_success'), __('Operation Success'));

                return redirect()->route('VerProyecto', ['id' => $proyecto->id]);

            }else{

                toastr()->error(__('messages.registration_error'), __('Operation Error'));

                return redirect()->route('NuevoProyecto');

            }


            /*
    		if ($request->has(['programa_id', 'codigo_proyecto', 'descripcion', 'fecha_inicio'])){

    			//$programa = Programa::find($request->programa_id);
    			//$sector = SectorDesarrollo::find($request->sector_desarrollo_id);

    			$proyecto = new Proyecto;

    			$proyecto->codigo_proyecto = $request->codigo_proyecto;
    			$proyecto->descripcion = $request->descripcion;
    			$proyecto->fecha_inicio = $request->fecha_inicio;
    			$proyecto->fecha_final = $request->fecha_final;
    			$proyecto->monto_presupuesto = $request->monto_presupuesto;

    			if($request->has('en_ejecucion')){
    				$proyecto->en_ejecucion = $request->en_ejecucion;
    			}

    			if ($request->has('ejecutado')) {
    				$proyecto->ejecutado = $request->ejecutado;
    			}

                $proyecto->programa_id = $request->programa_id;
                $proyecto->sector_desarrollo_id = $request->sector_desarrollo_id;
    			//$programa->proyectos()->save($proyecto);
    			//$sector->proyectos()->save($proyecto);
    			$proyecto->save();

    			return redirect()->route('AdminProyectos');
                
    		}else{
    			return view('alert', ['titulo' => 'Existe inconsistencia de datos', 'seccion' => $this->seccion, 'mensaje' => 'Los datos ingresados no son suficientes. Revise y vuelva a intentarlo.', 'funcionario' => $this->funcionario]);
    		}
            */
    	}
    }

    public function editar(Request $request, MenuBuilder $mb, $id){

    	if($request->isMethod('get')){

    		$proyecto = Proyecto::findOrFail($id);

            if ($proyecto->ejecutado) {

                toastr()->error(__('messages.edit_executed_record').upper(), __('Operation Error').upper());

                return redirect()->route('error');

            }

            $programas = Programa::where('finalizado', false)->get();
            $sectores = SectorDesarrollo::all();
            $ruta = route('EditarProyecto', ['id' => $proyecto->id]);

            $datos = ['titulo' => 'Editar Proyecto', 'seccion' => self::SECCION, 'proyecto' => $proyecto, 'programas' => $programas, 'sectores' => $sectores, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];


            if (!$request->session()->has('errors')) {

                toastr()->info(__('messages.required_fields'));

            }else {

                toastr()->error(__('messages.validation_error'), __('Validation Error'));
                
            }

    		return view('proyectos.formulario', $datos);


    	}else if ($request->isMethod('post')) {

            $request->validate([
                'codigo' => 'bail|unique:proyectos|alpha_dash|max:45|required',
                'programa_id' => 'numeric|required',
                'acronimo' => 'alpha_num|max:25|required',
                'descripcion' => 'alpha_num|max:250|required',
                'objetivo' => 'alpha_num|max:1000|nullable',
                'fecha_inicio' => 'date|required',
                'fecha_final' => 'date|nullable',
                'sector_desarrollo_id' => 'numeric|required',
                'presupuesto' => 'numeric|required'
            ]);

    		$programa = Programa::findOrFail($request->programa_id);
    		$sector = SectorDesarrollo::findOrFail($request->sector_desarrollo_id);
    		$proyecto = Proyecto::findOrFail($id);

            $proyecto->fill($request->input());

            /*
    		$proyecto->descripcion = $request->descripcion;
    		$proyecto->fecha_inicio = $request->fecha_inicio;
    		$proyecto->fecha_final	= $request->fecha_final;
    		$proyecto->monto_presupuesto = $request->monto_presupuesto;
    		$proyecto->en_ejecucion = $request->en_ejecucion;
    		$proyecto->ejecutado = $request->ejecutado;
            

            if($programa->id != $request->programa_id){
                $proyecto->programa()->associate($programa);
            }
    		
            if($sector->id != $request->sector_desarrollo_id){
                $proyecto->sectorDesarrollo()->associate($sector);
            }

            */

            $proyecto->fecha_final = $request->has('fecha_final') ? $request->fecha_final:null;

            $proyecto->ejecutado = $request->has('ejecutado') ? $request->ejecutado:false;

    		
            try {

                $proyecto->save();

            } catch (Exception $e) {
                
                error_log("Excepcion al modificar proyecto. ".$e->getMessage());

                toastr()->error(strtoupper(__('messages.update_error')), strtoupper(__('Operation Error')));

                return redirect()->route('EditarProyecto', ['id' => $proyecto->id]);

            }

    		return redirect()->route('VerProyecto', ['id' => $proyecto->id]);

    	}
    }

    public function asociar_unidad(Request $request, MenuBuilder $mb, $id){

        $proyecto = Proyecto::findOrFail($id);

    	if($request->isMethod('get')){

    		$unidades = UnidadGestion::all();

            if ($proyecto->unidadesGestion->count() > 0) {

                $unidades = $unidades->except($proyecto->unidadesGestion)->all();

            }

            $ruta = route('AsociarProyectoUnidad', ['id' => $proyecto->id]);

            $datos = ['seccion' => self::SECCION, 'proyecto' => $proyecto, 'unidades' => $unidades, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {

                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), __('Validation Error'));

            }

    		return view('proyectos.asociar', $datos);

    	}else if ($request->isMethod('post')) {

            $request->validate([
                'unidad_gestion_id' => 'bail|integer|required',
                'proyecto_id' => 'integer|required',
            ]);

            $unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);

            $proyecto->unidadesGestion()->attach($unidad->id);


    		return redirect()->route('VerProyecto', ['id' => $proyecto->id]);
    	}
    }

    public function disociar_unidad($id, $idu){

        $proyecto = Proyecto::findOrFail($id);

        $unidad = $proyecto->unidadesGestion->find($idu);

        if (isset($unidad)) {
            
            try {

                $proyecto->unidadesGestion()->dettach($unidad->id);
                
            } catch (Exception $e) {
                
                error_log("Excepción al desligar unidad de gestión de proyecto. ".$e->getMessage());

                toastr()->error(__("messages.critical_error"), strtoupper(__('Operation Error')));

                return redirect()->route('error');

            }

            return redirect()->route('VerProyecto', ['id' => $proyecto->id]);

        }

    }

    public function asociar_comunidad(Request $request, MenuBuilder $mb, $id){

        $proyecto = Proyecto::findOrFail($id);

        if ($request->isMethod('get')) {

            $comunidades = Comunidad::all();

            if ($proyecto->comunidades->count() > 0) {
                
                $comunidades = $comunidades->except($proyecto->comunidades)->all();

            }
            
            $ruta = route('AsociarProyectoComunidad', ['id' => $proyecto->id]);

            $datos = ['seccion' => self::SECCION, 'proyecto' => $proyecto, 'comunidades' => $comunidades, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            if ($request->session()->has('errors')) {
                
                toastr()->error(__('messages.validation_error'), __('Validation Error'));

            }else {

                toastr()->info(__('messages.required_fields'));

            }

            return view('proyectos.comunidad', $datos);

        }elseif ($request->isMethod('post')) {
            
            $request->validate([
                'comunidad_id' => 'bail|integer|required',
                'proyecto_id' => 'integer|required',
                'beneficiarios' => 'integer|required',
                'familias' => 'integer|required',
                'ninos' => 'integer|required',
                'ninas' => 'integer|required',
                'adolescentes_masculinos' => 'integer|present',
                'adolescentes_femeninos' => 'integer|present',
                'jovenes_masculinos' => 'integer|present',
                'jovenes_femeninos' => 'integer|present',
                'hombres' => 'integer|present',
                'mujeres' => 'integer|present',
                'ancianos' => 'integer|present',
                'discapacitados' => 'integer|present',
                'miskitu' => 'integer|present',
                'mestizo' => 'integer|present',
                'rama' => 'integer|present',
                'creole' => 'integer|present',
                'garifuna' => 'integer|present',
                'ulwa' => 'integer|present',
            ]);

            $comunidadId = $request->comunidad_id;

            $datos = array_filter($request->input(), function($k){
                return $k != 'comunidad_id' || $k != 'proyecto_id';
            }, ARRAY_FILTER_USE_KEY);

            try {

                $proyecto->comunidades()->attach($comunidadId, $datos);
                
            } catch (Exception $e) {

                error_log("Excepcion al asociar comunidad al proyecto. ".$e->getMessage());

                toastr()->error(__("messages.critical_error"), strtoupper(__('Operation Error')));

                return redirect()->route('AsociarProyectoComunidad', ['id' => $proyecto->id]);
                
            }

            toastr()->success(__('registration_success'), strtoupper(__('Operation Success')));

            return redirect()->route('VerProyecto', ['id' => $proyecto->id]);

        }
    }


    public function disociar_comunidad($id, $idc){

        $proyecto = Proyecto::findOrFail($id);

        $comunidad = $proyecto->comunidades->find($idc);

        if (isset($comunidad)) {
            
            try {

                $proyecto->comunidades()->dettach($comunidad->id);
                
            } catch (Exception $e) {
                
                error_log("Excepcion al desligar comunidad del proyecto. ".$e->getMessage());

                toastr()->error(__("messages.critical_error"), strtoupper(__('Operation Error')));

                return redirect()->route('error');
            }

            return redirect()->route('VerProyecto', ['id' => $proyecto->id]);

        }

    }

    public function eliminar($id, $trashed=false){

        try {

            if ($trashed == true) {
            
                $proyecto = Proyecto::withTrashed()->find($id);

                $proyecto->forceDelete();

            } else {

                $proyecto = Proyecto::findOrFail($id);

                $proyecto->delete();

            }

        } catch (Exception $e) {
            
            error_log("Excepción al borrar proyecto. ".$e->getMessage());

            toastr()->error(strtoupper(__('messages.critical_error')), strtoupper(__('Operation Error')));

            return redirect()->route('error');
        }


        return redirect->route('ListaProyectos', ['page' => 1]);

    }

    public function reciclar($id){
 
        $proyecto = Proyecto::onlyTrashed()->find($id)->get();

        $proyecto->restore();

        toastr()->info(__('messages.record_restored'), strtoupper(__('record restored')));

        return redirect()->route('VerProyecto', ['id' => $proyecto->id]);
    }


    public function editar_resultados(Request $request, MenuBuilder $mb, $id){
        // PENDIENTE DE IMPLEMENTAR
    }
    
    public function ingresar_resultados(Request $request, MenuBuilder $mb, $id){

        $proyecto = Proyecto::findOrFail($id);

        $ruta = route('IngresarResultadosProyecto', ['id' => $id]);

        if ($request->isMethod('get')) {

            $empty_rows = config('variables.campos_extra');

            $datos = ['seccion' => self::SECCION, 'proyecto' => $proyecto, 'filas' => $empty_rows, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            toastr()->info(__('messages.required_fields'));

            return view('proyectos.resultados', $datos);
            
        } elseif ($request->isMethod('post')) {
            

            if ($request->has('resultados')) {
                # code...
                $datos = $request->resultados;
                $filas = count($datos['codigo']);
                $saved = 0;

                for($i=0;$i<$filas;$i++){

                    if ((isset($datos['codigo'][$i] && strlen($datos['codigo'][$i] > 0))) && (isset($datos['descripcion'][$i]) && strlen($datos['descripcion'][$i]) > 0)) {

                        try {

                            $resultado = Resultado::create([
                                'proyecto_id' => $proyecto->id,
                                'codigo' => $datos['codigo'][$i],
                                'descripcion' => $datos['descripcion'][$i],
                                'formula' => $datos['formula'][$i],
                                'unidad_medida_id' => $datos['unidad_medida_id'][$i],
                            ]);

                            //$proyecto->resultados()->attach($resultado->id);
                            $saved++;

                        } catch (Exception $e) {
                            error_log("Excepción al registrar resultado de proyecto {$proyecto->codigo}. ".$e->getMessage());

                            toastr()->error(strtoupper(__('messages.critical_error')), strtoupper(__('Operation Error')));

                            return redirect()->route('error');
                        }
                        
                    } else {

                        break;

                    }
                }

                if ($saved > 0) {
                    
                    toastr()->success("{$saved} ".__('messages.records_saved'), strtoupper(__('Operation Success')));

                    return redirect()->route('VerProyecto', ['id' => $proyecto->id]);

                } else {

                    toastr()->info(__('messages.no_records_saved'));

                }

            } else {

                toastr()->error(__('messages.registration_error'), strtoupper(__('Operation Error')));


                return redirect($ruta);

            }
        }
    }

}
