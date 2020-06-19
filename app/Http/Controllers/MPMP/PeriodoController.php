<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Libreria\MenuBuilder;
use App\Http\Controllers\Controller;
use App\Models\Periodo;
use App\Models\PeriodoUnidad;
use App\Models\Personal;
use App\Models\Plan;
use Auth;


class PeriodoController extends Controller
{
    //
    
    const SECCION = "periods";


    public function lista(Request $request, MenuBuilder $mb, $page=1){

        $limite = config('variables.limite_lista', 20);

        $funcionario = Auth::user()->funcionario;

        $ruta = route('ListaPeriodoUnidad', ['page' => $page]);

        $periodos = null;

        $datos = null;

        if ($funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('director-ejecutivo')) {
            
            $periodos = PeriodoUnidad::all();

            $datos = ['rol' => $funcionario->rol];


        } else {

            $unidad = $funcionario->unidadGestion;

            $periodos = $unidad->periodos;

            $datos = ['unidad' => $unidad];
        }


        $count = $periodos->count();


        if ($count > $limite) {
            
            $periodos = $periodos->paginate($limite);

        }

        //$datos = ['seccion' => self::SECCION, 'page' => $page, 'periodos' => $periodos, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

        $datos['seccion'] = self::SECCION;
        $datos['page'] = $page;
        $datos['periodos'] = $periodos;
        $datos['backroute'] = $ruta;
        $datos['menu_list'] = $mb->getMenu();

        return view('mpmp.lista_periodos', $datos);
        
    }

    public function ver(Request $request, MenuBuilder $mb, $id){

        $funcionario = Auth::user()->funcionario;

        $unidad = $funcionario->unidadGestion;

        $periodoUnidad = PeriodoUnidad::findOrFail($id);

        if (!($periodoUnidad->unidad_gestion_id == $unidad->id || $funcionario->tieneRol('director-seplan') || $funcionario->tieneRol('director-ejecutivo'))) {
            
            toastr()->error(__('messages.unauthorized_operation'), strtoupper(__('clearance violation')));

            return redirect()->route('error');

        }

        $ruta = route('VerPeriodoUnidad', ['id' => $id]);

        $ruta_activar = route('AccionPeriodoUnidad', ['id' => $id, 'accion' => 'activar']);

        $ruta_abrir = route('AccionPeriodoUnidad', ['id' => $id, 'accion' => 'abrir']);

        $datos = ['seccion' => self::SECCION, 'periodoUnidad' => $periodoUnidad, 'unidadGestion' => $unidad, 'ruta_abrir' => $ruta_abrir, 'ruta_activar' => $ruta_activar, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

        return view('mpmp.periodo_unidad', $datos);
    }

    public function accion($id, $accion){

        $periodo = PeriodoUnidad::findOrFail($id);

        $funcionario = Auth::user()->funcionario;

        $unidad = $funcionario->unidadGestion;

        if (!($periodo->unidad_gestion_id == $unidad->id || $funcionario->tieneRol('director-seplan'))) {
            
            toastr()->error(__('messages.unauthorized_operation'), strtoupper(__('clearance violation')));

            return redirect()->route('error');
            
        }

        switch (strtolower($accion)) {
            
            case 'activar':
                
                $periodo->activado = true;
                $periodo->abierto = false;
                $periodo->save();

                break;

            case 'desactivar':
                
                $periodo->activado = false;
                $periodo->abierto = false;
                $periodo->save();

                break;

            case 'abrir':

                if ($periodo->activado == true) {
                    
                    $periodo->abierto = false;
                    $periodo->save();

                } else {

                    toastr()->error(__('messages.open_inactive_period'));

                }

                break;
            
            default:
                
                toastr()->warning(ucfirst(__('unrecognized order')));

                break;
        }

        return redirect()->route('VerPeriodoUnidad', ['id' => $id]);


    }

    public function activarTodos($id){

        $periodo = Periodo::findOrFail($id);

        if ($periodo->cerrado == true) {
            
            toastr()->error(__('messages.unauthorized_operation'));

            return redirect()->route('error');
        }

        $periodosUnidades = $periodo->periodosUnidades;

        $count = 0;

        foreach ($periodosUnidades as $periodoUnidad) {
            
            $periodoUnidad->activado = true;

            $periodoUnidad->abierto = false;

            $periodoUnidad->save()

            $count++;

        }

        toastr()->info("{$count} ".__('messages.records_updated'));

        return redirect()->route('ListaPeriodoUnidad');

    }

    public function nuevo(Request $request, MenuBuilder $mb){

        if ($request->isMethod('get')) {
            
            $funcionario = Auth::user()->funcionario;

            $unidad = $funcionario->unidadGestion;

            $periodos = Periodo::where('cerrado', false);

            $ruta = route('NuevoPeriodoUnidad');

            $datos = ['seccion' => self::SECCION, 'ruta' => $ruta, 'backroute' => $ruta, 'unidad' => $unidad, 'periodos' => $periodos, 'menu_list' => $mb->getMenu()];

            if($request->session()->has('errors')){

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            } else {

                toastr()->info(__('messages.required_fields'));

            }

            return view('mpmp.nuevo_periodo', $datos);

        } elseif ($request->isMethod('post')) {
            
            $request->validate([
                'periodo_id' => 'bail|integer|required',
                'unidad_gestion_id' => 'integer|required',
            ]);

            $periodoUnidad = PeriodoUnidad::create($request->input());

            toastr()->success(__('messages.registration_success'));

            return redirect()->route('VerPeriodoUnidad', ['id' => $periodoUnidad->id]);

        }
    }


    public function editar(Request $request, MenuBuilder $mb, $id){

        $periodoUnidad = PeriodoUnidad::findOrFail($id);

        if ($periodoUnidad->abierto == false) {
            
            toastr()->error(__('messages.edit_closed'), strtoupper(__('unauthorized operation')));

            return redirect()->route('VerPeriodoUnidad', ['id' => $id]);

        }

        if ($request->isMethod('get')) {
            
            $funcionario = Auth::user()->funcionario;

            $unidad = $funcionario->unidadGestion;

            if ($periodoUnidad->unidad_gestion_id != $unidad->id) {

                toastr()->error(__('messages.unauthorized_operation'), strtoupper(__('unauthorized operation')));

                return redirect()->route('error');
            }

            $periodos = Periodo::where('cerrado', false);

            $ruta = route('EditarPeriodoUnidad', ['id' => $id]);

            $datos = ['seccion' => self::SECCION, 'ruta' => $ruta, 'backroute' => $ruta, 'unidad' => $unidad, 'periodoUnidad' => $periodoUnidad, 'periodos' => $periodos, 'menu_list' => $mb->getMenu()];

            if($request->session()->has('errors')){

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            } else {

                toastr()->info(__('messages.required_fields'));

            }

            return view('mpmp.nuevo_periodo', $datos);

        } elseif ($request->isMethod('post')) {
            
            $request->validate([
                'periodo_id' => 'bail|integer|required',
                'unidad_gestion_id' => 'integer|required',
            ]);

            $periodoUnidad->fill($request->input());

            $periodoUnidad->save();

            toastr()->success(__('messages.update_success'));

            return redirect()->route('VerPeriodoUnidad', ['id' => $periodoUnidad->id]);

        }
    }    

    public function resultados(Request $request, MenuBuilder $mb, $id){

    	$periodoUnidad = PeriodoUnidad::findOrFail($id);

    	if ($periodoUnidad->abierto != true) {
            
            toastr()->error(__('messages.edit_closed'), strtoupper(__('unauthorized operation')));

            return redirect()->route('VerPeriodoUnidad', ['id' => $id]);

        }

    	if ($request->isMethod('get')) {

    		$unidadGestion = $this->funcionario->unidadGestion->get();

    		///TODO:
    		// Refinar la selección de resultados para que no se repitan los resultados 
    		// que ya fueron asociados al plan
    		
    		$resultados = collect([]);

    		$proyectos = $unidadGestion->proyectos()->where('ejecutado', false)->get();

            if ($unidadGestion->programas->count() > 0) {
                
                foreach ($unidadGestion->programas as $programa) {
                    
                    $proyectos = $proyectos->union($programa->proyectos);

                }

            }
    		
            foreach ($proyectos as $proyecto) {
                
                $resultados = $resultados->union($proyecto->resultados);

            }

    		return view('mpmp.plan_resultados', ['titulo' => 'Resultados del Plan', 'seccion' => $this->seccion, 'funcionario' => $this->funcionario, 'plan' => $plan, 'resultados' => $resultados, 'por_proyecto' => $resultados_proyectos, 'por_programa' => $resultados_programas]);


    	} else if ($request->isMethod('post')) {
    		
    		if ($request->has('resultados')) {
    				
				$datos = $request->input('resultados', null);

                $insertados = 0;

                $actualizados = 0;

    			//Función que recibe cada formulario con datos de post y asocia el resultado al plan
    			$registrar = function($resultado_id, $agregar=false){

    				$resultado = $periodoUnidad->resultados->find($resultado_id);

    				if ($resultado->count() > 0 && !$agregar) {

    					$plan->resultados()->dettach($resultado_id);

                        $actualizados++;

    				}else if($resultado->count() == 0 && $agregar){

    					$plan->resultados()->attach($resultado_id);

                        $insertados++;

    				}
    				
    				
    			};

                array_map($registrar, $datos['resultado_id'], $datos['agregar']);

                toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

                toastr()->info("{$insertados} ".__('messages.records_saved'));

                toastr()->info("{$actualizados} ".__('messages.records_updated'));

                return redirect()->route('VerPeriodoUnidad', ['id' => $id]);

    			

    		}else{

                toastr()->error(__('messages.unauthorized_operation'), strtoupper(__('unauthorized operation')));

    			return redirect()->route('error');

    		}

    	}
    }
}
