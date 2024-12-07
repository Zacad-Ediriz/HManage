<?php

namespace App\Http\Controllers\Usermanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = "Roles"; //title
        $this->route = 'user_management.roles'; //Route
        $this->view = 'usermanagement.roles'; //the view folder
        $this->path = 'shift'; //the path
        $this->access = 'role'; //the permission
        $this->context_model = "Spatie\Permission\Models\Role";


        $this->middleware('permission:' . $this->access . '-view', ['only' => ['index', 'data']]);
        $this->middleware('permission:' . $this->access . '-update', ['only' => ['getSingle']]);
        $this->middleware('permission:' . $this->access . '-delete', ['only' => ['delete']]);
        $this->middleware('permission:' . $this->access . '-givepermission', ['only' => ['givePermission']]);
    }

    public function index(): View
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        return view($this->view . '.index', $data);
    }

    function data(Request $request)
    {
        $items = $this->context_model::get();
        $data = [];
        $counter = 1;
        foreach ($items as $item) {
            $action = "";


            if (auth()->user()->can($this->access . '-givepermission')) {
                $permission_url = route($this->route . '.givePermission', $item->id);
                $action .= "<a href='javascript:;' class='btn btn-sm btn-light btn-active-light-primary ms-2' onclick=location.href='$permission_url'>
           Give permission
                        </a>";
            }


            if (auth()->user()->can($this->access . '-update')) {
                $url = route($this->route . '.getSingle');
                $action .= "<button type='button'
                            class='btn btn-icon btn-success btn-sm mx-2'
                            onclick=updatefn('$url',$item->id) title='update this row'>
                            <i class='fas fa-edit'></i>
                            </button>";
            }
            if (auth()->user()->can($this->access . '-delete')) {
                $url = route($this->route . '.delete');
                $action .= "<button type='button'
                            class='btn btn-icon btn-danger btn-sm'
                            onclick=deletefn('$url',$item->id) title='delete this row'>
                            <i class='fas fa-trash'></i>
                            </button>";
            }

            $data[] = [
                $counter,
                $item?->name,
                $action
            ];
            $counter++;
        }
        return $data;
    }


    function getSingle(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            return $this->context_model::findorfail($request->id);
        } catch (\Exception $th) {
            return response("Something went wrong!!!", 500);
        }
    }

    function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $request->id . ',id'
        ]);

        // try {
        // if($request->has("id") && $request->filled("id") && auth()->user()->can(this->access.'-update') ){
        //     $context_model = $this->context_model::findorfail($request->input("id"));
        //     $context_model->update($data);
        //     return response("Successfully updated the".$this->title);
        // }else if(auth()->user()->can($this->access.'-create')){
        $data["created_by"] = auth()->user()->id;
        $this->context_model::create($data);
        return response("Successfully created new " . $this->title);
        // }else{
        //     return response("You dont permission to perform this task!!!", 500);
        // }
        // } catch (\Throwable $th) {
        //     return response("Something went wrong!!!",500);
        // }
    }

    function delete(Request $request)
    {
        $data = $request->validate([
            "id" => "required"
        ]);
        try {
            /*if (Fine::where(["id" => $data["id"], "status" => "deducted"])->exists()){
                return response("This fine is already deducted from the employee and can not be deleted!!!!!!!",500);
            }*/
            $model = $this->context_model::findorfail($data["id"]);
            $model->delete();
            return response("Successfully deleted " . $this->title);
        } catch (\Throwable $th) {
            //throw $th;
            return response("Something went wrong!!!", 500);
        }
    }


    public function givePermission(Request $request, $id = 0)
    {
        if ($request->isMethod("GET")) {

            $role = Role::find($id)?->name;
            $permissions = [];
            $perms = Permission::with(["roles"])
                ->orderby("name");
            $module = $request->module;
            if ($request->filled('module')) {
                $perms = $perms->where('module_id', $request->module);
            }
            $perms = $perms->get();
            foreach ($perms as $value) {
                $permissions[$value?->module][$value?->group][] = $value;

            }
            $modules = [];
            $route = $this->route;
            return view($this->view . '.permission', compact('role', 'permissions', 'id', 'modules', 'module', 'route'));
        } else if ($request->isMethod("POST")) {
            $role = Role::find($id);

            if ($request->permission == 1) {
                $role->givePermissionTo($request->id);
                return ["success" => true, "msg" => "Permission is granted"];
            } else if ($request->permission == 0) {
                $role->revokePermissionTo($request->id);
                return ["success" => true, "msg" => "Permission is revoked"];


            }



            $data = $request->validate([
                'permission' => 'nullable',
            ]);

            $role->syncPermissions($data['permission'] ?? 0);
            $role = $role?->name;

            /*
            $role = Role::find($id);
            //dd($request->input('name'));
            $role->name = 'Admin'; //$request->input('name');
            $role->save();
            //dd($data);
            $role->syncPermissions($data['permission'] ?? 0);
            $role = $role?->name;
            */


            $permissions = [];
            $perms = Permission::with(["roles", "modules"])
                ->orderby("name");
            $module = $request->module;
            if ($request->filled('module')) {
                $perms = $perms->where('module_id', $request->module);
            }
            $perms = $perms->get();
            foreach ($perms as $value) {
                $permissions[$value?->modules?->name][] = $value;

            }
            $modules = Module::get();
            return view('user_management.roles.permission', compact('role', 'permissions', 'id', 'modules', 'module'));
        }
    }


}
