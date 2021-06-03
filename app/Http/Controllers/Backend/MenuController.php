<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($route = null)
    {
        if ($route == 1) {
            $dataMenu= Menu::getMenu('parent');
            return view('backend.settings.table_details_menu',[
                'dataMenu' => $dataMenu,
                'route' => 'menu'
            ])->withErrors('Oops! no existe registro para mostrar');

        } else {

            return view('backend.settings.table_menu',['route'=>$route])->withErrors('Oops! no existe registro para mostrar');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($route = null)
    {
        $obj = new Menu();
        $subMenu = $obj->optionsMenu();

        return view('backend.forms.form_menu', [
            'subMenu' => $subMenu,
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
        Menu::saveMenu($request);
        return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS')]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $route = null)
    {
        $obj = new Menu();
        $data = Menu::find($id);
        $subMenu = $obj->optionsMenu();

        return view('backend.forms.form_menu', compact('data'), [
            'subMenu' => $subMenu,
            'route' => $route
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $array = json_decode(stripslashes($request->arrayId));

        if (!empty($array)) {
            $i = 1;
            foreach ($array as $items) {
                unset($data);
                $data = [
                    'position' => $i
                ];
                $i++;

                Menu::find($items)->update($data);
            }
            $data = array('exito_details' => '1');

        } else {

            $menu = Menu::updateMenu($request);

            if ($menu) {
                return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS')]);
                $data = array('exito' => '1', 'editar' => 1);
            } else {
                return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
                $data = array('error' => '1');
            }
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $menu = Menu::deleteMenu($request->id);

        if ($menu) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS_DELETE')]);
        } else {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL_DELETE')]);
        }
    }
}
