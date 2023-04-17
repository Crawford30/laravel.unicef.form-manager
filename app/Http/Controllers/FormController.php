<?php

namespace App\Http\Controllers;

use App\Form;
use App\User;
use App\Section;
use App\FormData;
use App\FormUser;
use Carbon\Carbon;
use App\FormOwner;
use App\FormViewer;
use App\StaffProfile;
use App\UserPermission;
use Illuminate\Http\Request;
use App\Exports\ExportCollectedDataRaw;

class FormController extends Controller
{
    public function createForm()
    {
        return view('forms.create_form');
    }

    public function editForm($id)
    {
        return view('forms.edit_form', compact('id'));
    }

    public function showForms()
    {
        return view('forms.list_form');
    }

    public function collectData(Request $request, $id)
    {
        return view('forms.collect_data', compact('id'));
    }

    public function collectedData(Request $request)
    {
        $isFormAdmin = in_array('forms', auth()->user()->permissions);
        $data = $isFormAdmin 
                    ? FormData::count()
                    : FormData::where('user_id', auth()->user()->id)->count();                 

        $formOwners = FormOwner::all()->pluck('assigned_form_owner_id');
        $formUsers = FormUser::all()->pluck('assigned_user_id');
        
        $users = $formOwners->merge($formUsers)->unique()->count();

        $dataStats = $isFormAdmin 
                ? Form::orderBy('created_at', 'DESC')->get()->map(function($d) {
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
                ->orderBy('created_at', 'DESC')->get()->map(function($d) {
                    return [
                        'id' => $d->id,
                        'name' => $d->form_name,
                        'data' => FormData::where('user_id', auth()->user()->id)
                                                ->where('form_id', $d->id)->count()
                    ];
                })->values()->all();
        
        $context = [
            'data' => $data,
            'users' => $users,
            'viewers' => $formOwners->merge(UserPermission::where('permission', 'forms')->get()->pluck('user_id'))->unique()->count(),
            'stats' => $dataStats
        ];

        return view('forms.form_data')->with($context);
    }

    public function formCollectedData(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        
        $formOwners = FormOwner::where('form_id', $form->id)
                                    ->get()->pluck('assigned_form_owner_id');
        $formUsers = FormUser::where('form_id', $form->id)
                                    ->get()->pluck('assigned_user_id');
        
        $users = $formOwners->merge($formUsers)->unique()->map(function($user) {
            return [
                'id' => $user,
                'name' => User::find($user) != null ? User::find($user)->name : 'Unknown'
            ];
        })->values()->all();

        if(in_array('forms', auth()->user()->permissions) || $formOwners->has(auth()->user()->id)) {
            FormViewer::create([
                'user_id' => auth()->user()->id,
                'form_id' => $form->id
            ]);
        }

        return view('forms.colleced_form_data')->with('form', $form)
                                                ->with('users', $users);
    }

    public function userForms(Request $request)
    {
        
        $forms = Form::count();
        $data = FormData::count();                    

        $formOwners = FormOwner::all()->pluck('assigned_form_owner_id');
        $formUsers = FormUser::all()->pluck('assigned_user_id');
        
        $users = $formOwners->merge($formUsers)->unique()->count();

        $formRecords = $formOwners->merge($formUsers)->unique()->map(function($user) use($data) {
            $count = FormData::where('user_id', $user)->count();
            $staff = User::find($user);

            if($staff != null) {
                $staffProfile = StaffProfile::where('email', $staff->email)->first();
                $section = 'Test Section';

                if($staffProfile != null) {
                    $section = Section::find($staffProfile->section)->name;
                }

                return [
                    'type' => 'data',
                    'name' => $staff->name,
                    'data' => $count,
                    'section' => $section,
                    'percent' => $data != 0 ? ($count * 100) / $data : 0
                ];
            }
            return [];
        })->filter(function($data) {
            return count(array_keys($data)) > 0;
        })->all();

        $formAssignemts = $formOwners->merge($formUsers)->unique()->map(function($user) use ($formOwners, $formUsers, $forms) {
            $count = $formOwners->unique()->merge($formUsers->unique())->filter(function($u) use ($user) {
                return $u == $user;
            })->count();
            
            $staff = User::find($user);
            
            if($staff != null) {
                $staffProfile = StaffProfile::where('email', $staff->email)->first();
                $section = 'Test Section';

                if($staffProfile != null) {
                    $section = Section::find($staffProfile->section)->name;
                }

                return [
                    'type' => 'form',
                    'name' => $staff->name,
                    'data' => $count,
                    'section' => $section,
                    'percent' => $forms != 0 ? ($count * 100) / $forms : 0
                ];
            }
            return [];
        })->filter(function($data) {
            return count(array_keys($data)) > 0;
        })->all();


        $sectionData = collect($formRecords)->merge(collect($formAssignemts))->groupBy('section')->map(function($value, $key) use ($data, $forms){
            
            $total = $data + $forms;
            
            $sectionData = $value->filter(function($v) {
                return $v['type'] == 'data';
            })->sum('data');

            $sectionForms = $value->filter(function($v) {
                return $v['type'] == 'form';
            })->max('data');

            return [
                'section' => $key,
                'data' => $sectionData,
                'forms' => $sectionForms,
                'percent' => $total != 0 ? (($sectionData + $sectionForms) * 100) / $total : 0
            ];
        })->values()->all();
        
        $context = [
            'forms' => $forms,
            'data' => $data,
            'users' => $users,
            'records' => $formRecords,
            'assignments' => $formAssignemts,
            'viewers' => $formOwners->merge(UserPermission::where('permission', 'forms')->get()->pluck('user_id'))->unique()->count(),
            'section' => $sectionData
        ];

        return view('forms.form_users')->with($context);
    }

    public function viewerForms(Request $request)
    {
        
        $forms = Form::count();
        $data = FormData::count();                    

        $formOwners = FormOwner::all()->pluck('assigned_form_owner_id');
        $formUsers = FormUser::all()->pluck('assigned_user_id');
        
        $users = $formOwners->merge($formUsers)->unique()->count();

        $formRecords = $formOwners->merge(UserPermission::where('permission', 'forms')->get()->pluck('user_id'))->unique()->map(function($user) use($forms) {
            $count = FormViewer::where('user_id', $user)->get()
                                    ->pluck('form_id')->unique()->count();

            $staff = User::find($user);

            return $staff != null ? [
                'name' => $staff->name,
                'data' => $count,
                'percent' => $forms != 0 ? ($count * 100) / $forms : 0
            ] : [];
        })->filter(function($data) {
            return count(array_keys($data)) > 0;
        })->all();

        $formViewers = Form::all()->map(function($form) {
            return [
                'name' => $form->form_name,
                'data' => FormViewer::where('form_id', $form->id)->get()->pluck('user_id')->unique()->count()
            ];
        })->values()->all();
        
        $context = [
            'forms' => $forms,
            'data' => $data,
            'users' => $users,
            'records' => $formRecords,
            'viewers' => $formOwners->merge(UserPermission::where('permission', 'forms')->get()->pluck('user_id'))->unique()->count(),
            'assignments' => $formViewers
        ];

        return view('forms.form_viewers')->with($context);
    }

    public function exportData(Request $request)
    {
        $form = Form::findOrFail($request->form_id);
        $month = (int) $request->get('filter_by');

        if($request->has('start_date') && $request->has('end_date')) {
            $data = FormData::where('form_id', $form->id)
                                ->where('created_at', '>=', $request->get('start_date'))
                                ->where('created_at', '<=', $request->get('end_date'))
                                ->get();
        } else {
            $lastMonths = Carbon::now()->startOfMonth()->subMonth($month);
            $data = $month == 0 
                            ? FormData::where('form_id', $form->id)->get() 
                            : FormData::where('form_id', $form->id)
                                        ->where('created_at', '>', $lastMonths)
                                        ->get();
        }

        $collectedData = collect($data)->pluck('fields_data')->map(function($d) {
            return is_array($d) || is_object($d) ? (object) $d : json_decode($d);
        });

        $formFields = json_decode($form->field_type);
        $questions = collect($formFields)->filter(function($field) {
            return is_object(json_decode($field->field_type)) && property_exists(json_decode($field->field_type), 'type') 
                                ? json_decode($field->field_type)->type != 'file' : true;
        })->map(function($field) {
            return [
                'question' => property_exists($field, 'category') && $field->category != NULL && $field->category != '' 
                                    ? $field->category . ': ' . $field->label : $field->label,
                'key' => $field->field_input_name
            ];
        });

        $mappedCollectedData = $collectedData->map(function($data) use ($questions) {
            return collect($data)->filter(function($d) {
                return is_array($d) || is_object($d) || is_null($d) ? true : !str_contains($d, 'base64');
            })->map(function($v, $k) use ($questions){
                $question = $questions->first(function($q) use ($k) {
                    return $q['key'] == $k;
                });

                return $question != null ? [
                   'question' => $question['question'],
                   'key' => $k,
                   'response' => is_array($v) || is_object($v) ? implode(", ", array_values((array) $v)) : $v
                ] : null ;
            })->filter(function($d) {
                return $d != null;
            })->values()->all();
        })->values();

        $filename = $request->format == 'xls' ? $form->form_name . ' - Collected Data.xlsx' : $form->form_name . ' Collected Data.csv';
        $excelExport = (new ExportCollectedDataRaw($form, $mappedCollectedData, $questions->pluck('question')->values()->all()))
                                        ->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        $csvExport = (new ExportCollectedDataRaw($form, $mappedCollectedData, $questions->pluck('question')->values()->all()))
                                        ->download($filename, \Maatwebsite\Excel\Excel::CSV, [
                                                'Content-Type' => 'text/csv',
                                            ]);

        return $request->format == "xls" ? $excelExport : $csvExport;
    }
}
