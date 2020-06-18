<?php

namespace App\Http\Controllers\MPMP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libreria\MenuBuilder;
use App\Models\Producto;
use App\Models\Resultado;
use App\Models\UnidadMedida;
use App\Models\Actividad;
use Auth;

class ProductoController extends Controller
{
    
    
    const SECCION = 'product indicators';


    public function lista(MenuBuilder $mb, $page=1){

        $funcionario = Auth::user()->funcionario;

        $limite = config('variables.limite_lista', 20);
        $ruta = route('ListaProductos', ['page' => $page]);

        $proyectos = $funcionario->unidadGestion->proyectos->where('ejecutado',false)->paginate($limite);

        $datos = ['seccion' => self::SECCION, 'proyectos' => $proyectos, 'backroute' => $ruta, 'menu_list' => $mb->getMenu(), 'page' => $page, 'unidad_gestion' => $funcionario->unidadGestion];

        return view('productos.lista', $datos);

    }


    public function ver(MenuBuilder $mb, $id){

        $producto = Producto::findOrFail($id);

        $ruta = route('VerProducto', ['id' => $id]);

        $ruta_edit = route('EditarProducto', ['id' => $id]);

        $ruta_delete = route('EliminarProducto', ['id' => $id]);

        $ruta_aprobar = route('AprobarProducto', ['id' => $id]);

        return view('productos.detalle', ['seccion' => self::SECCION, 'producto' => $producto, 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'ruta_aprobar' => $ruta_aprobar, 'menu_list' => $mb->getMenu()]);

    }


    public function nuevo(Request $request, MenuBuilder $mb){

    	if ($request->isMethod('get')) {

            $resultados = null;

            $proyectos = Auth::user()->funcionario->unidadGestion->proyectos->where('ejecutado', false);

            foreach ($proyectos as $proyecto) {
                
                if ($resultados == null) {
                    
                    $resultados = $proyecto->resultados;

                } else {

                    $resultados = $proyecto->resultados->union($resultados);
                }
            }

    		$unidades = UnidadMedida::all();

    		$producto = new Producto;

            $ruta = route('NuevoProducto');

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

    		return view('productos.nuevo', ['seccion' => self::SECCION, 'producto' => $producto, 'ruta' => $ruta, 'backroute' => $ruta, 'unidades' => $unidades, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()]);

    	}elseif ($request->isMethod('post')) {

            $request->validate([
                'codigo' => 'bail|alpha_dash|max:5|required',
                'resultado_id' => 'integer|required',
                'descripcion' => 'alpha_dash|max:600|required',
                'formula' => 'alpha_dash|max:200|present|nullable',
                'unidad_medida_id' => 'integer|nullable',
            ]);

            $producto = null;

            try {

                $producto = Producto::create($request->input());
                
            } catch (Exception $e) {

                error_log("Excepción al ingresar Producto. ".$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
                
            }

            if ($producto != null) {
                
                toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

                return redirect()->route('VerProducto', ['id' => $producto->id]);
            }

    	}
    }
    

    public function editar(Request $request, MenuBuilder $mb, $id){

        $producto = Producto::findOrFail($id);

    	if ($request->isMethod('get')) {

            $resultados = null;

            $proyectos = Auth::user()->funcionario->unidadGestion->proyectos->where('ejecutado', false);

            foreach ($proyectos as $proyecto) {
                
                if ($resultados == null) {
                    
                    $resultados = $proyecto->resultados;

                } else {

                    $resultados = $proyecto->resultados->union($resultados);
                }
            }

    		$unidades = UnidadMedida::all();

            $ruta = route('EditarProducto', ['id' => $id]);

            $datos = ['seccion' => self::SECCION, 'producto' => $producto, 'ruta' => $ruta, 'backroute' => $ruta, 'unidades' => $unidades, 'resultados' => $resultados, 'menu_list' => $mb->getMenu()];

            if (!$request->session()->has('errors')) {
                
                toastr()->info(__('messages.required_fields'));

            } else {

                toastr()->error(__('messages.validation_error'), strtoupper(__('Validation Error')));

            }

    		return view('productos.editar', $datos);

    	}else if($request->isMethod('post')){

            $request->validate([
                'codigo' => 'bail|alpha_dash|max:5|required',
                'resultado_id' => 'integer|required',
                'descripcion' => 'alpha_dash|max:600|required',
                'formula' => 'alpha_dash|max:200|present|nullable',
                'unidad_medida_id' => 'integer|nullable',
            ]);

            $producto->fill($request->input());

            try {

                $producto->save();
                
            } catch (Exception $e) {

                error_log("Excepción al actualizar Producto. ".$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
                
            }

            toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

    		return redirect()->route('VerProducto', ['id' => $producto->id]);

    	}
    }

    public function aprobar($id){

    	$producto = Producto::findOrFail($id_prod);

        try {

            $producto->aprobado = true;
            $producto->save();
            
        } catch (Exception $e) {

            error_log("Excepción al aprobar producto. ".$e->getMessage());

            toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

            return redirect()->route('error');
            
        }

    	return redirect()->route('VerProducto', ['id' => $producto->id]);
        
    }

    public function eliminar(Request $request, $id){

    	if ($request->isMethod('post')) {
    		
    		$producto = Producto::findOrFail($id_prod);

            try {

                $producto->delete();
                
            } catch (Exception $e) {

                error_log("Excepción al eliminar producto. ".$e->getMessage());

                toastr()->error(__('messages.critical_error'), strtoupper(__('Operation Error')));

                return redirect()->route('error');
                
            }

    		return redirect()->route('ListaProductos', ['page' => 1]);
    	}
    }

    public function ingresar_actividades(Request $request, MenuBuilder $mb, $id){

        $producto = Producto::findOrFail($id);

        $ruta = route('IngresarActividadesProducto', ['id' => $id]);

        if ($request->isMethod('get')) {
            
            $empty_rows = config('variables.extra_rows', 4);

            $datos = ['seccion' => self::SECCION, 'producto' => $producto, 'filas' => $empty_rows, 'ruta' => $ruta, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

            toastr()->info(__('messages.required_fields'));

            return view('productos.actividades', $datos);

        } else if ($request->isMethod('post')) {

            if ($request->has('actividades')) {
                
                $datos = $request->actividades;
                $filas = count($datos['codigo']);
                $saved = 0;

                for ($i=0; $i < $filas; $i++) { 
                    
                    if ((isset($datos['codigo'][$i]) && strlen($datos['codigo'][$i]) > 0) && (isset($datos['descripcion'][$i]) && strlen($datos['descripcion'][$i]) > 0)) {
                        
                        try {

                            $actividad = Actividad::create([
                                'producto_id' => $producto->id,
                                'codigo' => $datos['codigo'][$i],
                                'descripcion' => $datos['descripcion'][$i],
                                'fuente_financiamiento' => $datos['fuente_financiamiento'][$i],
                                'monto_presupuesto' => $datos['monto_presupuesto'][$i],
                                'monto_aprobado' => $datos['monto_aprobado'][$i],
                                'monto_disponible' => $datos['monto_disponible'][$i],
                            ]);

                            $saved++;
                            
                        } catch (Exception $e) {

                            error_log("Excepción al registrar actividades del producto {$producto->codigo}. ".$e->getMessage());

                            toastr()->error(strtoupper(__('messages.critical_error')), strtoupper(__('Operation Error')));

                            return redirect()->route('error');
                            
                        }

                    } else {

                        break;

                    }

                }

                if ($saved > 0) {
                    
                    toastr()->success("{$saved} ".__('messages.records_saved'), strtoupper(__('Operation Success')));

                } else {

                    toastr()->info(__('messages.no_records_saved'));

                }

                return redirect()->route('VerProducto', ['id' => $id]);


            } else {

                toastr()->error(__('messages.registration_error'), strtoupper(__('Operation Error')));


                return redirect($ruta);

            }
        }

    }
}
