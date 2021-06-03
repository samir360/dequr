<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='static_pages';

    protected $fillable = [];

    const TERMS_AND_CONDITIONS='TÉRMINOS Y CONDICIONES';
    const LEGAL='LEGAL';
    const COOKIES='POLÍTICAS DE COOKIES';

    const STATIC_PAGE_ACTIVE='ACTIVO';
    const STATIC_PAGE_INACTIVE='INACTIVO';


    static public function saveStaticPage($request)
    {
        $obj = new self();

        $obj->title = mb_strtoupper($request->title);
        $obj->body = $request->body;
        $obj->page = $request->page;
        $obj->status = $request->status;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'saveStaticPage', [
            'static_page' => $obj,
        ]);
        return $obj;
    }

    static public function updateStaticPage($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);

        $obj->title = mb_strtoupper($request->title);
        $obj->body = $request->body;
        $obj->page = $request->page;
        $obj->status = $request->status;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'updateStaticPage', [
            'static_page' => $obj,
        ]);

        return $obj;
    }

    static public function deleteStaticPage($id)
    {
        $obj = new self();

        $staticPage=$obj->find($id);
        $obj->find($id)->delete();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($staticPage, 'deleteStaticPage', []);

        return $staticPage;
    }

}
