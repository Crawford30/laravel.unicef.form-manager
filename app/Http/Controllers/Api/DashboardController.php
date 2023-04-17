<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\FormData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    // Get form data
    public function getFormData(Request $request)
    {
        $forms = Form::where('is_completed', true)->withCount('data')->orderBy('data_count', 'desc')->get();
        $completed_forms = Form::where('is_completed', true)->count();

        $total_form_data = FormData::count();

        return response(['response' => 'success', 'forms' => $forms, 'total_form_data' => $total_form_data, 'completed_forms' => $completed_forms]);
    }
}
