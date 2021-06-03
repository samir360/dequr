<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index($route = null, Request $request)
    {
        $arrayFilter=$request['filter'];

        $objActivity= new ActivityLog();

        $data=$objActivity->getActivityfiltered($arrayFilter);

        $dataOperador = User::where([['rol_id', '!=', 3]])->get();

        return view('backend.settings.table_activity_log', [
            'dataActivity' => $data,
            'arrayFilter'=>$arrayFilter,
            'dataOperador' => $dataOperador,
            'route' => $route
        ])->withErrors('Oops! no existe registro para mostrar');
    }
}
