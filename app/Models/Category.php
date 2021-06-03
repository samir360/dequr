<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Category extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'ACTIVO';
    const STATUS_INACTIVE = 'INACTIVO';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


    static public function saveCategory($request)
    {
        $obj = new self();

        $obj->name = ucfirst(mb_strtolower($request->name));
        $obj->icon = strtolower($request->icon);
        $obj->status = $request->status;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'saveCategory', [
            'categories' => $obj
        ]);
        return $obj;
    }

    static public function updateCategory($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);

        $obj->name = ucfirst(mb_strtolower($request->name));
        $obj->icon = strtolower($request->firstname);
        $obj->status = $request->status;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'updateCategory', [
            'categories' => $obj
        ]);

        return $obj;
    }

    static public function deleteCategory($id)
    {
        $obj = new self();

        $category=$obj->find($id);
        $obj->find($id)->delete();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($category, 'deleteCategory', [
            'categories' => $category
        ]);

        return $category;
    }

}
