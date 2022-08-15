<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Traits\ActiveInactiveTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    use ActiveInactiveTrait;

    public function index()
    {
        if (auth()->user()->can('role-view'))
        {
            App::setLocale(Session::get('currentLocal'));


            $roles = Role::orderBy('is_active','DESC')
            ->orderBy('id','DESC')
            ->get();

            if (request()->ajax())
            {
                return datatables()->of($roles)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('action', function ($row)
                {
                    $actionBtn = "";

                    if (auth()->user()->can('set_permission'))
                    {
                        $actionBtn .= '<a class="permission btn btn-info btn-sm" title="Permission" href="'.route('admin.rolePermission',$row->id).'">Permission</a> &nbsp; ';
                    }

                    if (auth()->user()->can('role-edit'))
                    {
                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                        &nbsp; ';
                    }

                    if (auth()->user()->can('role-action'))
                    {
                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                        }
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('admin.pages.role.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('role-store'))
        {
            if ($request->ajax()) {

                $validator = Validator::make($request->only('role_name'),[
                    'role_name'  => 'required|unique:roles,name',
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $role = new Role();
                $role->name       = $request->role_name;
                $role->guard_name = 'web';
                $role->is_active  = $request->is_active;
                $role->save();
            }
            return response()->json(['success'=>'Data Added Successfully']);
        }

    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $role = Role::find($request->id);
            return response()->json(['id' => $request->id, 'role_name' => $role->name,'is_active'=> $role->is_active]);
        }
    }

    public function update(Request $request)
    {
        if (auth()->user()->can('role-edit'))
        {
            if ($request->ajax()) {

                $role       = Role::find($request->id);
                $role->name = $request->role_name;

                if ($request->is_active==1) {
                    $role->is_active = 1;
                }else {
                    $role->is_active = 0;
                }
                $role->update();

                return response()->json(['success'=>'Data Updated Successfully']);
            }
        }
    }

    public function active(Request $request){

        if ($request->ajax()){
            return $this->activeData(Role::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(Role::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, Role::whereIn('id',$request->idsArray));
        }
    }
}
