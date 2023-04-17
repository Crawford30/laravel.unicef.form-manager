<?php

namespace App\Http\Controllers;

use App\User;
use App\Form;
use App\FormData;
use App\FormUser;
use App\FormOwner;
use App\FormTimeline;
use Illuminate\Http\Request;
class HomeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $isFormAdmin = in_array('forms', auth()->user()->permissions);
        $foms = $isFormAdmin
                    ? Form::count()
                    : Form::whereHas('users', function($query) {
                                $query->where('assigned_user_id', auth()->id());
                            })->orWhereHas('owners', function($query) {
                                $query->where('assigned_form_owner_id', auth()->id());
                            })->orWhere('user_id', auth()->id())->orderBy('created_at', 'DESC')->count();

        $data = $isFormAdmin
                    ? FormData::count()
                    : FormData::where('user_id', auth()->user()->id)->count();

        $formOwners = FormOwner::all()->pluck('assigned_form_owner_id');
        $formUsers = FormUser::all()->pluck('assigned_user_id');

        $users = $formOwners->merge($formUsers)->unique()->count();

        $timeline = $isFormAdmin ? [] : FormTimeline::where('user_id', auth()->user()->id)
                                    ->orderBy('created_at', 'DESC')
                                    ->take(6)->get();

        $dataStats = $isFormAdmin
                ? Form::orderBy('created_at', 'DESC')->take(8)->get()->map(function($d) {
                    return [
                        'id' => $d->id,
                        'name' => $d->form_name,
                        'data' => FormData::where('form_id', $d->id)->count()
                    ];
                })->values()->all()
                : Form::whereHas('owners', function($query) {
                    $query->where('assigned_form_owner_id', auth()->user()->id);
                })->orWhereHas('users', function($query) {
                    $query->where('assigned_user_id', auth()->user()->id);
                })->orWhere('user_id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')->take(8)->get()->map(function($d) {
                    return [
                        'id' => $d->id,
                        'name' => $d->form_name,
                        'data' => FormData::where('user_id', auth()->user()->id)
                                                ->where('form_id', $d->id)->count()
                    ];
                })->values()->all();

        $formRecords = $formOwners->merge($formUsers)->unique()->map(function($user) use($data) {
            $count = FormData::where('user_id', $user)->count();
            $user = User::find($user);
            return [
                'name' => $user ? $user->name : 'System',
                'data' => $count,
                'percent' => $data != 0 ? ($count * 100) / $data : 0
            ];
        })->all();

        $formAssignemts = $formOwners->merge($formUsers)->unique()->map(function($user) use ($formOwners, $formUsers, $foms) {
            $count = $formOwners->merge($formUsers)->filter(function($u) use ($user) {
                return $u == $user;
            })->count();
            $user = User::find($user);
            return [
                'name' => $user ? $user->name : 'System',
                'data' => $count,
                'percent' => $foms != 0 ? ($count * 100) / $foms : 0
            ];
        })->all();

        $context = [
            'forms' => $foms,
            'data' => $data,
            'users' => $users,
            'timeline' => $timeline,
            'dataStats' => $dataStats,
            'records' => $formRecords,
            'assignments' => $formAssignemts
        ];

        return view('index')->with($context);
    }
}
