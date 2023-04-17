<?php

namespace App\Http\Controllers\Api;

use App\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth', 'unicef_auth']);
    }

    public function index(Request $request)
    {
        $currentuserdata = Form::where('user_id', auth()->user()->id)->get();

        if (in_array('forms', auth()->user()->permissions) && (auth()->user()->user_type == 'unicef')) {
            return view('home_with_permission_returning')->with('currentuserdata', $currentuserdata);
        } else {
            return view('home_with_no_permission');
        }
    }
}
