<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $fillable = ['name', 'icono', 'position', 'parent', 'slug', 'enabled'];


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent')->where('parent', 0);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent');
    }

    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [array_merge($line1, ['submenu' => $this->getChildren($data, $line1)])]);
            }
        }
        return $children;
    }

    public function optionsMenu()
    {
        /*$data = DB::select(DB::raw('SELECT * from menus WHERE enabled=true order by position'));
        $arrData = collect($data)->map(function($x){ return (array) $x; })->toArray();*/

        return $this->where('enabled', true)
            ->orderby('parent')
            ->orderby('position')
            ->orderby('name')
            ->get()
            ->toArray();
    }


    static public function saveMenu($request)
    {

        $obj = new self();

        $parent=false;
        $data = DB::select(DB::raw('SELECT max(position) as position from menus'));
        $nPosition = $data[0]->position + 1;

        #Es sub directorio
        if($request->tipo!=1){
            $parent=$request->id_submenu;
            $nPosition=false;
        }

        $obj->name = $request->name;
        $obj->icono = $request->icono;
        $obj->enabled = $request->enabled;
        $obj->position = $nPosition;
        $obj->parent = $parent;
        $obj->slug = $request->slug;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'saveMenu', [
            'name' => $request->name,
            'icono' => $request->icono,
            'enabled' => $request->enabled,
            'parent' => $request->parent,
            'slug' => $request->slug,
        ]);

        return $obj;
    }

    static public function updateMenu($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);

        $parent=false;
        $nPosition = $request->position;

        #Es sub directorio
        if($request->get('tipo')!=1){
            $parent=$request->id_submenu;
            $nPosition=false;
        }

        $obj->name = $request->name;
        $obj->icono = $request->icono;
        $obj->enabled = $request->enabled;
        $obj->position = $nPosition;
        $obj->parent = $parent;
        $obj->slug = $request->slug;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'updateMenu', [
            'name' => $request->name,
            'icono' => $request->icono,
            'enabled' => $request->enabled,
            'parent' => $request->parent,
            'slug' => $request->slug,
        ]);

        return $obj;
    }

    static public function updateSubMenu($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);
        $obj->parent = $request->parent;
        $obj->name = $request->name;
        $obj->enabled = $request->enabled;
        $obj->slug = $request->slug;
        $obj->save();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($obj, 'updateSubMenu', [
            'name' => $request->name,
            'icono' => $request->icono,
            'enabled' => $request->enabled,
            'parent' => $request->parent,
            'slug' => $request->slug,
        ]);

        return $obj;
    }

    static public function deleteMenu($id)
    {
        $obj = new self();

        $deteleMenu=$obj->find($id);
        $obj->find($id)->delete();

        #Guardamos en Activity Log
        ActivityLog::saveActivityLog($deteleMenu, 'deleteMenu', []);

        return $deteleMenu;
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();

        $menuAll = [];
        foreach ($data as $line) {
            $item = [array_merge($line, ['submenu' => $menus->getChildren($data, $line)])];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }

    static function getMenu($search = null, $id = null)
    {
        // DB::enableQueryLog();
        $data = Menu::select('*')
            ->where('enabled', '=', true)
            ->where(function ($data) use ($search, $id) {
                if (!empty($search)) {
                    if ($search == 'slug') {
                        $data->orwhere('slug', '=', null);
                    }
                    if ($search == 'parent') {
                        $data->where('parent', '=', false);
                    }
                    if ($id) {
                        $data->where('parent', '=', $id);
                    }
                }
            })
            ->orderBy('position', 'ASC')
            ->get();

        // dd(DB::getQueryLog());
        return $data;
    }


    static function buildTree(array $elements, $parentId = 0)
    {

        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = Menu::buildTree($elements, $element['id']);

                if ($children) {
                    $element['children'] = $children;
                }

                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function getSubMenu($filter = [])
    {
        //DB::enableQueryLog();

        $data = $this->where('parent', '!=', false);

        if (empty($filter)) {
            $data->orwhere('slug', '=', false);
        }

        if (isset($filter['status']) && !empty($filter['status'])) {
            $data->where('enabled', $filter['status']);
        }

        if (isset($filter['search']) && !empty($filter['search'])) {
            $data->where('name', $filter['search']);
        }

        $data->orderby('parent')
            ->orderby('position')
            ->orderby('name')
            ->get();

        //dd(DB::getQueryLog());

        return $data;
    }


    static function getPermissionHasRoles($id = null)
    {
        //DB::enableQueryLog();
        $hasRolesPermission=Menu::join('role_has_permissions', 'role_has_permissions.id_menu', '=', 'menus.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('menus.id')
            ->where('role_has_permissions.role_id', '=', $id)
            ->get()->toArray();

        //dd(DB::getQueryLog());

        $arrPermission = [];

        if ($hasRolesPermission) {
            foreach ($hasRolesPermission AS $items) {
                $arrPermission[] .= $items['id'];//id del menu
            }
        }

        return $arrPermission;
    }

    static function getAdditionalPermissions($menuId = null, $rolId=null)
    {
        $additionalPermissions = Menu::join('role_has_permissions', 'role_has_permissions.id_menu', '=', 'menus.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('menus.name','menus.icono','menus.position','menus.parent','menus.slug','menus.id AS menu_id','role_has_permissions.new','role_has_permissions.edit','role_has_permissions.delet','role_has_permissions.role_id')
            ->where('menus.id', '=', $menuId)
            ->where('roles.id', '=', $rolId)
            ->first();

        return $additionalPermissions;
    }

    static function getPermissionRolUser($rolId)
    {
        $permissionRolUser =Menu::join('role_has_permissions', 'role_has_permissions.id_menu', '=', 'menus.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('menus.name','menus.icono','menus.position','menus.parent','menus.slug','menus.id AS menu_id','role_has_permissions.new','role_has_permissions.edit','role_has_permissions.delet','role_has_permissions.role_id')
            ->where('roles.id', '=', $rolId)
            ->orderBy('menus.name', 'ASC')
            ->get()->toArray();

        return $permissionRolUser;
    }

}
