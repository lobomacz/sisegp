<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libreria\MenuBuilder;
use App\Models\Comunidad;
use App\Models\Municipio;


class ComunidadController extends Controller
{
    //
    const SECCION = 'communities';

    public function __construct(){

        $this->middleware(['auth', 'check.rol:superusuario', 'language']);

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MenuBuilder $mb)
    {
        //
        $comunidades = Comunidad::all()->groupBy('municipio_id');

        $ruta = route('comunidades.index');

        $datos = ['seccion' => self::SECCION, 'comunidades' => $comunidades, 'backroute' => $ruta, 'menu_list' => $mb->getMenu()];

        return view('admin.comunidades_index', $datos);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, MenuBuilder $mb)
    {
        //
        $comunidad = new Comunidad();

        $backroute = route('comunidades.create');

        $ruta = route('comunidades.store');

        $datos = ['seccion' => SECCION, 'comunidad' => $comunidad, 'backroute' => $backroute, 'menu_list' => $mb->getMenu(), 'ruta' => $ruta];

        if ($request->session()->has('errors')) {
            
            toastr()->warning(__('messages.validation_error'), strtoupper(__('Validation Error')));

        } else {

            toastr()->info(__('messages.required_fields'));

        }

        return view('admin.formulario_comunidad', $datos);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'municipio_id' => 'bail|integer|required',
            'nombre' => 'string|min:5|max:100|required',
            'lat' => 'numeric|required',
            'lng' => 'numeric|required',
        ]);

        $comunidad = Comunidad::create($request->input());

        toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

        return redirect()->route('comunidades.show', ['id' => $comunidad->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MenuBuilder $mb, $id)
    {
        //
        $comunidad = Comunidad::findOrFail($id);

        $params = ['id' => $id];

        $ruta = route('comunidades.show', $params);

        $ruta_edit = route('comunidades.edit', $params);

        $ruta_delete = route('comunidades.destroy', $params);

        $datos = ['seccion' => self::SECCION, 'comunidad' => $comunidad, 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'menu_list' => $mb->getMenu()];   

        return view('admin.ver_comunidad', $datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MenuBuilder $mb, $id)
    {
        //
        $comunidad = Comunidad::findOrFail($id);

        $params = ['id' => $id];

        $ruta = route('comunidades.update', $params);

        $backroute = route('comunidades.edit', $params);

        $datos = ['seccion' => self::SECCION, 'comunidad' => $comunidad, 'backroute' => $backroute, 'ruta' => $ruta, 'menu_list' => $mb->getMenu()];

        if ($request->session()->has('errors')) {
            
            toastr()->warning(__('messages.validation_error'), strtoupper(__('Validation Error')));

        } else {

            toastr()->info(__('messages.required_fields'));

        }

        return view('admin.formulario_comunidad', $datos);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $comunidad = Comunidad::findOrFail($id);

        $request->validate([
            'municipio_id' => 'bail|integer|required',
            'nombre' => 'string|min:5|max:100|required',
            'lat' => 'numeric|required',
            'lng' => 'numeric|required',
        ]);

        $comunidad->fill($request->input());

        $comunidad->save();

        toastr()->success(__('messages.update_success'), strtoupper(__('Operation Success')));

        return redirect()->route('comunidades.show', ['id' => $id]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $comunidad = Comunidad::findOrFail($id);

        $comunidad->delete();

        toastr()->success(__('messages.record_deleted'));

        return redirect()->route('comunidades.index');
    }
}
