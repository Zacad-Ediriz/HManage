<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\logo;
use App\Models\News;
use App\Models\Team;
use App\Models\about;
use App\Models\cause;
use App\Models\Event;
use App\Models\slide;
use App\Models\Slider;
use App\Models\gallary;
use App\Models\setting;
use App\Models\Category;
use App\Models\document;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends Controller
{
    public function __construct()
    {
        $access = 'doctor'; // the permission prefix

        $this->middleware('permission:' . $access . '-view', ['only' => ['index', 'data']]);
        $this->middleware('permission:' . $access . '-update', ['only' => ['getSingle']]);
        $this->middleware('permission:' . $access . '-delete', ['only' => ['delete']]);
    }
    public function index()
    {
        $data['access'] = 'doctor'; // the permission

        return view('layout.index', $data);
    }

    public function dashbourds()
    {
        return view('dashbourd');
    }

}
