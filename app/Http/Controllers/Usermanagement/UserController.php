<?php

namespace App\Http\Controllers\Usermanagement;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = "Users"; //title
        $this->route = 'user_management.users'; //Route
        $this->view = 'usermanagement.users'; //the view folder
        $this->path = 'user_management.users'; //the path
        $this->access = 'user'; //the permission
        $this->context_model = "\App\Models\User";


        $this->middleware('permission:'.$this->access.'-view', ['only' => ['index','data']]);
        $this->middleware('permission:'.$this->access.'-update', ['only' => ['getSingle']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['delete']]);
    }

    public function index() :View
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['roles'] = Role::get();
        // $data['hospitals'] = Hospital::get();

        // if(auth()->user()->can("system-manage-branch")){
        //     $data['branches'] = Branch::get();
        // }


        return view($this->view.'.index', $data);
    }

    function data(Request $request){
        $items = $this->context_model::get();
        $data = [];
        $counter = 1;
        foreach ($items as  $item) {
            $action = "";
            if(auth()->user()->can($this->access.'-update')){
             $url = route($this->route.'.getSingle');
                $action .= "<button type='button'
                            class='btn btn-icon btn-success btn-sm mx-2'
                            onclick=updatefn('$url',$item->id) title='update this row'>
                            <i class='fas fa-edit'></i>
                            </button>";
            }
            if(auth()->user()->can($this->access.'-delete')){
                $delete_url = route($this->route.'.delete');
                $action .= "<button type='button'
                            class='btn btn-icon btn-danger btn-sm'
                            onclick=deletefn('$delete_url',$item->id) title='delete this row'>
                            <i class='fas fa-trash'></i>
                            </button>";
            }

            $data[] = [
                $counter,
                $item?->name,
                $item?->email,
                // $item

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

    function create(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->id.',id',
            'role' => 'required',
            'password' => 'required_if:id,=,null'
        ]);

        // try {
            if($request->has("id") && $request->filled("id") && auth()->user()->can($this->access.'-update') ){
                if(!$request->filled('password')){
                    unset($data['password']);
                }
                $context_model = $this->context_model::findorfail($request->input("id"));
                $context_model->update($data);
                $context_model->assignRole($request->role);
                return response("Successfully updated the".$this->title);
            }else if(auth()->user()->can($this->access.'-create')){
                $data["created_by"] = auth()->user()->id;

                if(auth()->user()->can("system-manage-all")){
                    $data["hospital_id"] = $request->hospital;
                    $data["branch_id"] = $request->branch;
                }else{
                    $data["hospital_id"] = auth()->user()->hospital_id;
                    $data["branch_id"] = $request->branch;
                }



                $user = $this->context_model::create($data);
                $user->assignRole($request->role);
                return response("Successfully created new ".$this->title);
            }else{
                return response("You dont permission to perform this task!!!", 500);
            }
        // } catch (\Throwable $th) {
        //     return response("Something went wrong!!!",500);
        // }
    }

    function delete(Request $request){
        $data = $request->validate([
            "id" => "required"
        ]);
        try {
            /*if (Fine::where(["id" => $data["id"], "status" => "deducted"])->exists()){
                return response("This fine is already deducted from the employee and can not be deleted!!!!!!!",500);
            }*/
            $model = $this->context_model::findorfail($data["id"]);
            $model->delete();
            return response("Successfully deleted ".$this->title);
        } catch (\Throwable $th) {
            //throw $th;
            return response("Something went wrong!!!",500);
        }
    }



}
