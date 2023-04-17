<?php

namespace App\Http\Requests;

use App\Form;
use App\FormData;
use App\FormTimeline;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormDataRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  [
            "form_id" => "required",
            "data" => "required"
        ];
    }

    public function saveCollectedFormData()
    {
        $data = [
            "user_id" => auth()->user()->id,
            "form_id" => $this->form_id,
            "fields_data" =>  $this->data
        ];

        $formData = null;
        $form = Form::find($this->form_id);

        if($form != null) {
            $formData = FormData::create($data);
            FormTimeline::create([
                'form_id' => $form->id,
                'user_id' => auth()->user()->id,
                'title' => 'Data added to form, ' . $form->form_name,
                'icon' => 'fas fa-file-alt',
                'color' => randomColor(),
                'timeline_by' => auth()->user()->name
            ]);
        }

        return response()->json($formData, 200);
    }
}
