<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $route = null)
    {
        $filter = $request->get('filter');

        $filter['search'] = isset($filter['search']) ? $filter['search'] : [];
        $filter['status'] = (isset($filter['status'])) ? $filter['status'] : [];

        $obj = new Menu();
        $dataSubMenu = $obj->getSubMenu($filter);

        return view('backend.settings.table_sub_menu', [
                'dataSubMenu' => $dataSubMenu->paginate(20),
                'filter' => $filter,
                'route' => $route
            ]
        )->withErrors('Oops! no existe registro para mostrar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module = null)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = Menu::find($id);
        $dataMenu = Menu::getMenu('slug');

        return view('backend.forms.form_sub_menu', compact('data'), [
            'dataMenu' => $dataMenu,
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
        $subMenu=Menu::updateSubMenu($request);

        if ($subMenu) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS')]);
        } else {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
        }
    }

    public function destroy(Request $request)
    {

        $subMenu=Menu::deleteMenu($request->id);

        if ($subMenu) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS_DELETE')]);
        } else {
            return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL_DELETE')]);
        }

    }
}
