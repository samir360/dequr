<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'guard_name'];


    static public function saveRole($request)
    {

        $obj = new self();

        $obj->name = strtolower($request->name);
        $obj->guard_name = 'web';
        $obj->save();

        #Guardamos los permisos asociados al rol
        $menuId = $request->menu_id;
        $new = $request->new;
        $edit = $request->edit;
        $delet = $request->delet;

        foreach ($menuId AS $item) {

            $optionNew = false;
            $optionEdit = false;
            $optionDelet = false;

            $objHasPermission = new HasRoles();
            $objHasPermission->id_menu = $item;

            if ($new) {
                foreach ($new AS $itemNew) {
                    if ($itemNew == $item) {
                        $optionNew = true;
                        break;
                    }
                }
            }

            if ($edit) {
                foreach ($edit AS $itemEdit) {
                    if ($itemEdit == $item) {
                        $optionEdit = true;
                        break;
                    }
                }
            }

            if ($delet) {
                foreach ($delet AS $itemDelet) {
                    if ($itemDelet == $item) {
                        $optionDelet = true;
                        break;
                    }
                }
            }

            $objHasPermission->role_id = $obj->id;
            $objHasPermission->new = $optionNew;
            $objHasPermission->edit = $optionEdit;
            $objHasPermission->delet = $optionDelet;
            $objHasPermission->save();
        }

        return $obj;
    }

    static public function updateRole($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);

        $obj->name = strtolower($request->name);
        $obj->save();

        HasRoles::where([['role_id', '=', $request->id]])->delete();

        #Guardamos los permisos asociados al rol
        $menuId = $request->menu_id;
        $new = $request->new;
        $edit = $request->edit;
        $delet = $request->delet;

        foreach ($menuId AS $item) {

            $optionNew = false;
            $optionEdit = false;
            $optionDelet = false;

            $objHasPermission = new HasRoles();
            $objHasPermission->id_menu = $item;

            if ($new) {
                foreach ($new AS $itemNew) {
                    if ($itemNew == $item) {
                        $optionNew = true;
                        break;
                    }
                }
            }

            if ($edit) {
                foreach ($edit AS $itemEdit) {
                    if ($itemEdit == $item) {
                        $optionEdit = true;
                        break;
                    }
                }
            }

            if ($delet) {
                foreach ($delet AS $itemDelet) {
                    if ($itemDelet == $item) {
                        $optionDelet = true;
                        break;
                    }
                }
            }

            $objHasPermission->role_id = $request->id;
            $objHasPermission->new = $optionNew;
            $objHasPermission->edit = $optionEdit;
            $objHasPermission->delet = $optionDelet;
            $objHasPermission->save();
        }

        return $obj;
    }

    static public function deleteRole($id)
    {
        $obj = new self();

        $role=$obj->find($id);
        $obj->find($id)->delete();

        return $role;
    }

}
