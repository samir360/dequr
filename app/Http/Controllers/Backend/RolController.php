<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($route = null)
    {
        $dataRol = Role::orderBy('id', 'asc')->paginate(10);

        return view('backend.settings.table_roles', [
            'dataRol' => $dataRol,
            'route' => $route
        ])->withErrors('Oops! no existe registro para mostrar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($route = null)
    {
        #Traemos los padres
        $padre = Menu::with('children')->get()->toArray();

        #Traemos los hijos
        $menus = Menu::buildTree($padre);

        return view('backend.forms.forms_roles', [
            'menus' => $menus,
            'route' => $route
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = Role::where([
            ['name', '=', strtolower($request->get('name'))]
        ])->get();

        if (!$items->isEmpty()) {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
        }

        if (!$request->get('menu_id')) {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
        }

        Role::saveRole($request);

        return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $route = null)
    {
        $data = Role::find($id);

        #Traemos los permisosn segun roles
        $arrPermission = Menu::getPermissionHasRoles($id);

        #Traemos los padres
        $padre = Menu::with('children')->get()->toArray();

        #Traemos los hijos
        $menus = Menu::buildTree($padre);

        return view('backend.forms.forms_roles', compact('data', 'id'), [
            'arrPermission' => $arrPermission,

            'menus' => $menus,
            'route' => $route
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $items = Role::where([
            ['name', '=', strtolower($request->name)]
        ])->where([
            ['id', '!=', $request->id]
        ])->get();

        if (!$items->isEmpty()) {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
        }

        if (!$request->get('menu_id')) {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
        }

        $role = Role::updateRole($request);

        if ($role) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS')]);
        } else {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::deleteRole($request->id);
        if ($role) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS_DELETE')]);
        } else {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL_DELETE')]);
        }
    }
}
