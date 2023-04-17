<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\FormData;
use Carbon\Carbon;
use App\StaffProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFormRequest;
use App\Http\Requests\StoreFormDataRequest;
use App\Http\Requests\DeleteUserFormRequest;

class FormController extends Controller
{
    public function getForms(Request $request)
    {
        $isWeb = $request->has('d') && $request->get('d') == 'web';
        if($isWeb) {
            $forms = in_array('forms', auth()->user()->permissions)
                    ? Form::orderBy('created_at', 'DESC')->get()
                    : Form::whereHas('users', function($query) {
                                $query->where('assigned_user_id', auth()->id());
                            })->orWhereHas('owners', function($query) {
                                $query->where('assigned_form_owner_id', auth()->id());
                            })->orWhere('user_id', auth()->id())->orderBy('created_at', 'DESC')->get();
        } else {
            $forms = in_array('forms', auth()->user()->permissions)
                        ? Form::where('is_completed', true)->orderBy('created_at', 'DESC')->get()
                        : Form::whereHas('users', function($query) {
                                    $query->where('assigned_user_id', auth()->id());
                                })->orWhereHas('owners', function($query) {
                                    $query->where('assigned_form_owner_id', auth()->id());
                                })->orWhere('user_id', auth()->id())
                                ->where('is_completed', true)
                                ->orderBy('created_at', 'DESC')->get();
        }

        return response()->json($forms);
    }

    public function getFormDetails(Request $request, $formId)
    {
        $form = Form::find($formId);
        return response()->json($form);
    }

    public function getStaff(Request $request)
    {
        $staff = StaffProfile::with('section')
                            ->whereNotNull("email")
                            ->orderBy("name", "asc")->get();
        return response()->json($staff);
    }

    public function getSerializedForm(Request $request)
    {
        $form = collect($request->all());
        $fields = collect($form->get('fields'))->groupBy('category');
        $form->put('fields', $fields);
        return response()->json($form, 200);
    }

    public function getSerializedData(Request $request)
    {
        return response()->json($request->all(), 200);
    }

    public function deleteUserForm(DeleteUserFormRequest $request)
    {
        return $request->delete();
    }

    public function createForm(CreateFormRequest $request)
    {
        set_time_limit(0);
        return $request->saveForm();
    }

    public function saveFormData(StoreFormDataRequest $request)
    {
        return $request->saveCollectedFormData();
    }

    public function getCollectedDataStats(Request $request)
    {
        $months = (int) $request->month;
        $isFormAdmin = in_array('forms', auth()->user()->permissions);

        if($months != 0) {
            $lastMonths = Carbon::now()->startOfMonth()->subMonth($months);

            $dataStats = $isFormAdmin
                ? Form::where('created_at', '>', $lastMonths)->orderBy('created_at', 'DESC')->get()->map(function($d) {
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
                ->where('created_at', '>', $lastMonths)
                ->orderBy('created_at', 'DESC')->get()->map(function($d) {
                    return [
                        'id' => $d->id,
                        'name' => $d->form_name,
                        'data' => FormData::where('user_id', auth()->user()->id)
                                                ->where('form_id', $d->id)->count()
                    ];
                })->values()->all();
        } else {
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
        }

        return apiResponse($dataStats);
    }

    public function getCollectedDataFormStats(Request $request, $id)
    {
        $form = Form::findOrFail($id);

        $month = (int) $request->month;
        $user = (int) $request->user_id;

        if($month != 0) {
            $lastMonths = Carbon::now()->startOfMonth()->subMonth($month);
            $data = in_array('forms', auth()->user()->permissions)
                    ? ($user == 0
                            ? FormData::where('form_id', $form->id)
                                            ->where('created_at', '>', $lastMonths)
                                            ->get()
                            : FormData::where('form_id', $form->id)
                                        ->where('user_id', $user)
                                        ->where('created_at', '>', $lastMonths)
                                        ->get())
                    : FormData::where('form_id', $form->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->get();
        } else {
            $data = in_array('forms', auth()->user()->permissions)
                    ? ($user == 0
                            ? FormData::where('form_id', $form->id)->get()
                            : FormData::where('form_id', $form->id)
                                        ->where('user_id', $user)->get())
                    : FormData::where('form_id', $form->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->get();
        }

        $collectedData = collect($data)->pluck('fields_data')->map(function($d) {
            return is_array($d) || is_object($d) ? (object) $d : json_decode($d);
        });

        $formFields = json_decode($form->field_type);
        $answeredQuestionsStats = collect($formFields)->map(function($field) use ($collectedData) {
            $count = $collectedData->filter(function($value) use ($field){
                return property_exists($value, $field->field_input_name)
                            && (
                                    is_array($value->{$field->field_input_name}) || is_object($value->{$field->field_input_name})
                                        ? count(array_values((array) $value->{$field->field_input_name})) > 0
                                        : $value->{$field->field_input_name} != ''
                                            && $value->{$field->field_input_name} != NULL);
            })->count();
            return [
                'name' => property_exists($field, 'category') && $field->category != NULL && $field->category != ''
                                    ? $field->category . ': ' . $field->label : $field->label,
                'data' => $count
            ];
        });

        return apiResponse($answeredQuestionsStats);
    }
}
