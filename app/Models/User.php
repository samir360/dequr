<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    const ROL_ADMIN = 1;
    const ROL_OPERATOR = 2;
    const ROL_BUSINESS= 3;
    const ROL_USERNAME = 4;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function saveUser($request)
    {

        $obj = new self();

        $obj->rol_id = $request->rol_id;
        $obj->firstname = ucfirst(strtolower($request->firstname));
        $obj->lastname = ucfirst(strtolower($request->lastname));
        $obj->email = $request->email;
        $obj->password = Hash::make($request->password);
        $obj->user_status = $request->user_status;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'saveUser', [
            'firstname' => ucfirst(strtolower($request->firstname)),
            'lastname' => ucfirst(strtolower($request->lastname)),
            'email' => $request->email
        ]);
        return $obj;
    }

    static public function updateUser($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);

        $obj->rol_id = $request->rol_id;
        $obj->firstname = ucfirst(strtolower($request->firstname));
        $obj->lastname = ucfirst(strtolower($request->lastname));
        $obj->email = $request->email;
        $obj->user_status = $request->user_status;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'updateUser', [
            'firstname' => ucfirst(strtolower($request->firstname)),
            'lastname' => ucfirst(strtolower($request->lastname)),
            'email' => $request->email
        ]);

        return $obj;
    }

    static public function deleteUser($id)
    {
        $obj = new self();

        $templateSms=$obj->find($id);
        $obj->find($id)->delete();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($templateSms, 'deleteUser', []);

        return $templateSms;
    }
}
