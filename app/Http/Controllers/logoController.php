<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;


class logoController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = "logo"; //title
        $this->route = 'logo'; //Route
        $this->view = 'front.logo'; //the view folder
        $this->path = 'logo'; //the path
        $this->access = 'logo'; //the permission
        $this->context_model = '\App\Models\logo';


        $this->middleware('permission:' . $this->access . '-view', ['only' => ['index', 'data']]);
        $this->middleware('permission:' . $this->access . '-update', ['only' => ['getSingle']]);
        $this->middleware('permission:' . $this->access . '-delete', ['only' => ['delete']]);
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
        foreach ($items as  $item) {
            $action = "";
            if (auth()->user()->can($this->access . '-update')) {
                $url = route($this->route . '.getSingle');
                $action .= "<button type='button'
                            class='btn btn-icon btn-success btn-sm mx-2'
                            onclick=updatefn('$url',$item->id) title='update this row'>
                            <i class='fas fa-edit'></i>
                            </button>";
            }
            if (auth()->user()->can($this->access . '-delete')) {
                $delete_url = route($this->route . '.delete');
                $action .= "<button type='button'
                            class='btn btn-icon btn-danger btn-sm'
                            onclick=deletefn('$delete_url',$item->id) title='delete this row'>
                            <i class='fas fa-trash'></i>
                            </button>";
            }

            $status = "";
            if ($item?->status == "enabled") {
                $status = "<span class='badge bg-success'> Enabled </span>";
            } else if ($item?->status == "disabled") {
                $status = "<span class='badge bg-danger'> Disabled </span>";
            }


            $data[] = [
                $counter,
                $item->name,
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
            'name' => 'required',
            'image' => 'required_if:id,!=,null',
        ]);

        try {
            if ($request->has("id") && $request->filled("id") && auth()->user()->can($this->access . '-update')) {
                $context_model = $this->context_model::findorfail($request->input("id"));
                if ($request->hasFile("image")) {
                    $file = $request->image;
                    $newName = time() . "." . $file->getClientOriginalExtension();
                    $file->move("storage/logo", $newName);
                    $data["image"] = $newName;
                }
                $context_model->update($data);
                return response("Successfully updated the " . $this->title);
            } else if (!$request->filled("id") && auth()->user()->can($this->access . '-create')) {
                if ($request->hasFile("image")) {
                    $file = $request->image;
                    $newName = time() . "." . $file->getClientOriginalExtension();
                    $file->move("storage/logo", $newName);
                    $data["image"] = $newName;
                }
                $this->context_model::create($data);
                return response("Successfully created new " . $this->title);
            } else {
                return response("You dont permission to perform this task!!!", 500);
            }
        } catch (\Throwable $th) {
            return response("Something went wrong!!!", 500);
        }
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
}
