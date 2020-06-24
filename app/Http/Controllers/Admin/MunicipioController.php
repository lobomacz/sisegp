<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;
use App\Libreria\MenuBuilder;
use App\Models\Municipio;


class MunicipioController extends Controller
{
    //
    const SECCION = 'municipalities';

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
        $municipios = Municipio::all();

        $ruta = route('municipios.index');

        $datos = ['seccion' => self::SECCION,'municipios' => $municipios, 'menu_list' => $mb->getMenu(), 'backroute' => $ruta];

        return view('admin.municipios_index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $backroute = route('municipios.create');

        $ruta = route('municipios.store');

        $municipio = new Municipio();

        $datos = ['seccion' => self::SECCION, 'menu_list' => $mb->getMenu(), 'backroute' => $backroute, 'municipio' => $municipio, 'ruta' => $ruta];

        if ($request->session()->has('errors')) {
            
            toastr()->warning(__('messages.validation_error'), strtoupper(__('Validation Error')));

        }else{

            toastr()->info('messages.required_fields');

        }

        return view('admin.formulario_municipio', $datos);

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
            'region' => 'bail|alpha|required',
            'nombre' => 'alpha_numeric|max:50|required',
            'nombre_corto' => 'alpha_numeric|max:10|required',
            'poblacion' => 'numeric|nullable',
            'extension' => 'numeric|nullable'
        ]);

        $municipio = Municipio::create($request->input());

        toastr()->success(__('messages.registration_success'), strtoupper(__('Operation Success')));

        return redirect()->route('municipios.show', ['id' => $municipio->id]);

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
        $municipio = Municipio::findOrFail($id);

        $ruta = route('municipios.show', ['id' => $id]);

        $ruta_edit = route('municipios.edit', ['id' => $id]);

        $ruta_delete = route('municipios.destroy', ['id' => $id]);

        $datos = ['seccion' => self::SECCION, 'municipio' => $municipio, 'backroute' => $ruta, 'ruta_edit' => $ruta_edit, 'ruta_delete' => $ruta_delete, 'menu_list' => $mb->getMenu()];

        return view('admin.ver_municipio', $datos);
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
        $municipio = Municipio::findOrFail($id);

        $backroute = route('municipios.edit', ['id' => $id]);

        $ruta = route('municipios.update', ['id' => $id]);

        $datos = ['seccion' => self::SECCION, 'municipio' => $municipio, 'backroute' => $backroute, 'menu_list' => $mb->getMenu(), 'ruta' => $ruta];

        if ($request->session()->has('errors')) {
            
            toastr()->warning(__('messages.validation_error'), strtoupper(__('Validation Error')));

        } else {

            toastr()->info(__('messages.required_fields'));

        }

        return view('admin.formulario_municipio', $datos);

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
        $municipio = Municipio::findOrFail($id);

        $request->validate([
            'region' => 'bail|alpha|required',
            'nombre' => 'alpha_numeric|max:50|required',
            'nombre_corto' => 'alpha_numeric|max:10|required',
            'poblacion' => 'numeric|nullable',
            'extension' => 'numeric|nullable'
        ]);

        $municipio->fill($request->input());

        $municipio->save();

        toastr()->success(__('messages.update_success'));

        return redirect()->route('municipios.show', ['id' => $id]);
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
        $municipio = Municipio::findOrFail($id);

        $municipio->delete();

        toastr()->success(__('messages.record_deleted'));

        return redirect()->route('municipios.index');

    }
}
