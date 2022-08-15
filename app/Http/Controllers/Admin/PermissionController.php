<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function rolePermission($id)
    {
        App::setLocale(Session::get('currentLocal'));

        if (auth()->user()->can('set_permission'))
        {
            $role = Role::find($id);
            return view('admin.pages.role.permission',compact('role'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function permissionDetails($id)
	{
        if (auth()->user()->can('set_permission'))
        {
            $role = Role::find($id);
            $role_permissions = $role->permissions()->select('name')->get();

            $permissions = array();
            foreach ($role_permissions as $permission)
            {
                $permissions[] = $permission->name;
            }

            return json_encode($permissions);
        }
	}

    public function set_permission(Request $request)
	{
        if (auth()->user()->can('set_permission'))
        {
            $id = $request['roleId'];
            $role = Role::find($id);
            $all_permissions = $request['checkedId'];
            $role->syncPermissions($all_permissions);

            return response()->json(['success' => __('Successfully saved the permission')]);
        }
	}

}
