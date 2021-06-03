<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($route = null)
    {
        $dataUser = User
            ::join('roles', 'users.rol_id', '=', 'roles.id')
            ->select('users.id', 'users.email', 'users.firstname', 'users.lastname', 'users.user_status', 'roles.name', 'roles.created_at')
            ->orderBy('users.firstname')
            ->paginate(50);

        return view('backend.settings.table_user', [
            'dataUser' => $dataUser,
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
        $dataRol = Role::orderBy('name')->get();

        return view('backend.forms.forms_user', [
            'route' => $route,
            'dataRol' => $dataRol
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
        //Verifico si el email existe
        $items = User::where([
            ['email', '=', $request->get('email')]
        ])->get();

        if (isset($items)) {
            if (!$items->isEmpty()) {
                return response()->json(['status' => 'fail', 'alert' => env('MSJ_FAIL')]);
            }
        }

        $user = User::saveUser($request);

        #Envio el email con su user y contraseña
        #PARAMETROS PARA ENVIAR EL EMAIL
        /*if (isset($user->id)) {

            $email = $request->get('email');
            $password = $request->get('password');
            $firstname = ucfirst(mb_strtolower($request->get('firstname')));

            $bodyTemplate = "Estimado usuario $firstname usted ha sido registrado en nuestro sistema para la administración de nuestros procesos, los datos son los 
        siguientes:<br><br><p>Correo electrónico: $email </p> <p>Contrase&ntilde;a:  $password </p>";

            Event(new UserOperadorSendMail($request->get('firstname'), $request->get('email'), $bodyTemplate));
        }*/

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
        $data = User::find($id);
        $dataRol = Role::orderBy('name')->get();

        return view('backend.forms.forms_user', compact('data', 'id'), [
            'route' => $route,
            'dataRol' => $dataRol
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

        $user = User::updateUser($request);

        if ($user) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS')]);
        }

        return response()->json(['status' => 'success', 'alert' => env('MSJ_FAIL')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::deleteUser($request->id);

        if ($user) {
            return response()->json(['status' => 'success', 'alert' => env('MSJ_SUCCESS_DELETE')]);
        }

        return response()->json(['status' => 'success', 'alert' => env('MSJ_FAIL_DELETE')]);


    }

    public function listPermissionRole(Request $request)
    {
        $hasRolesPermission = Menu::getPermissionRolUser($request->id_rol);

        return view('backend.settings.ajax_list_permission_role', ['hasRolesPermission' => $hasRolesPermission]);
    }
}
