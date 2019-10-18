<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyecto;
use App\Models\UnidadGestion;
use App\Models\Programa;
use App\Models\SectorDesarrollo;

class ProyectoController extends Controller
{
    //
    protected $funcionario = Auth::user()->funcionario;
    
    protected $seccion = 'Proyectos';

    public function ver($id)
    {
    	$proyecto = Proyecto::findOrFail($id);
    	$funcionario = $this->funcionario;

    	return view('proyectos.detalle', ['titulo' => 'Detalle de Proyecto', 'seccion' => 'Proyectos', 'funcionario' => $funcionario, 'proyecto' => $proyecto]);
    }

    public function nuevo(Request $request)
    {
    	if($request->isMethod('get')){

    		$proyecto = new Proyecto;
            $programas = Programa::where('finalizado', false)->get();
            $sectores = SectorDesarrollo::all();
    		$funcionario = $this->funcionario;

    		return view('proyectos.formulario', ['titulo' => 'Ingreso de Proyecto', 'seccion' => $this->seccion, 'funcionario' => $funcionario, 'proyecto' => $proyecto, 'route' => 'NuevoProyecto', 'programas' => $programas, 'sectores' => $sectores]);

    	}else if($request->isMethod('post')){
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
    	}
    }

    public function editar(Request $request, $id){

    	if($request->isMethod('get')){

    		$proyecto = Proyecto::findOrFail($id);

            if ($proyecto->ejecutado) {
                return redirect()->route('error');
            }


            $programas = Programa::where('finalizado', false)->get();
            $sectores = SectorDesarrollo::all();
    		$funcionario = $this->funcionario;

    		return view('proyectos.formulario', ['titulo' => 'Editar Datos de Proyecto', 'seccion' => 'Proyectos', 'funcionario' => $funcionario, 'proyecto' => $proyecto, 'programas' => $programas, 'sectores' => $sectores]);

    	}elseif ($request->isMethod('post')) {

    		$programa = Programa::findOrFail($request->programa_id);
    		$sector = SectorDesarrollo::findOrFail($request->sector_desarrollo_id);
    		$proyecto = Proyecto::findOrFail($id);
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
    		
    		$proyecto->save();

    		return redirect()->route('AdminProyectos');

    	}
    }

    public function asociar(Request $request, $id){

    	if($request->isMethod('get')){

    		$proyecto = Proyecto::findOrFail($id);
    		$funcionario = $this->funcionario;
    		$unidades = UnidadGestion::all();

    		return view('proyectos.asociar', ['titulo' => 'Asociar Proyecto a Unidad de Gestión', 'seccion' => 'Proyectos', 'funcionario' => $funcionario, 'proyecto' => $proyecto, 'unidades' => $unidades]);

    	}elseif ($request->isMethod('post')) {

    		if (!$request->has('unidad_gestion_id')) {

    			return redirect()->route('error');

    		}else{

    			$proyecto = Proyecto::findOrFail($id);
    			$unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);

    			$proyecto->unidadesGestion()->attach($unidad->id);

    			return redirect()->route('AdminProyectos');
    		}
    	}
    }

    public function disociar(Request $request, $id){

        if($request->isMethod('get')){

            $proyecto = Proyecto::findOrFail($id);
            $funcionario = $this->funcionario;
            $unidades = $proyecto->unidadesGestion;

            return view('proyectos.asociar', ['titulo' => 'Remover Proyecto de Unidad de Gestión', 'seccion' => 'Proyectos', 'funcionario' => $funcionario, 'proyecto' => $proyecto, 'unidades' => $unidades]);

        }elseif ($request->isMethod('post')) {

            if (!$request->has('unidad_gestion_id')) {

                return redirect()->route('error');

            }else{

                $proyecto = Proyecto::findOrFail($id);
                $unidad = UnidadGestion::findOrFail($request->unidad_gestion_id);

                $proyecto->unidadesGestion()->dettach($unidad->id);

                return redirect()->route('AdminProyectos');
            }
        }
    }

    public function eliminar(Request $request, $id){
    	if($request->isMethod('get')){

    		$funcionario = $this->funcionario;

            $ruta = route('EliminarPoyecto', ['id' => $id]);

    		return view('alert', ['titulo' => 'Eliminar Proyecto', 'seccion' => 'Proyectos', 'mensaje' => 'Se eliminará el registro de la base de datos.', 'route' => $ruta, 'funcionario' => $funcionario]);
            
    	}elseif($request->isMethod('post')){
    		
    		Proyecto::destroy($id);

    		return redirect()->route('AdminProyectos');

    	}
    }
}
