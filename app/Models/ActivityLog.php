<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [];


    public function getActivityfiltered($arrayFilters = array())
    {

       // dd($arrayFilters);

        //DB::enableQueryLog();
        $query = ActivityLog::join('users', 'activity_log.causer_id', '=', 'users.id')
            ->join('roles', 'users.rol_id', '=', 'roles.id')
            ->select('activity_log.id', 'activity_log.log_name', 'activity_log.description', 'activity_log.subject_id', 'activity_log.subject_type', 'activity_log.causer_id', 'activity_log.causer_type', 'activity_log.properties', 'activity_log.created_at', 'activity_log.updated_at', 'users.email', 'users.firstname', 'users.lastname', 'users.rol_id', 'roles.id As id_rol', 'roles.name');

        if (!empty($arrayFilters['user_id'])) {
            $query->where('activity_log.causer_id', '=', $arrayFilters['user_id']);
        }

        if (!empty($arrayFilters['description'])) {
            $query->where('activity_log.description', 'LIKE', '%' . $arrayFilters['description'] . '%');
        }

        if (!empty($arrayFilters['created_at'])) {
            $query->whereDate('activity_log.created_at', '=', $arrayFilters['created_at']);
        }
        //dd($query->toSql());

        return $query->orderBy('users.id', 'asc')->paginate(20);
    }


    static public function saveActivityLog($model, $log, array $param)
    {
        #Guardamos la actividad
        activity()
            ->performedOn($model)
            ->causedBy(Auth::user())
            ->withProperties($param)
            ->log($log);
        return $model;
    }
}
