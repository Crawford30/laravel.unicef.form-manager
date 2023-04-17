<?php

namespace App\Http\Requests;

use App\Form;
use App\FormData;
use App\FormUser;
use App\FormOwner;
use App\FormTimeline;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUserFormRequest extends FormRequest
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
        return [
            "form_id" => "required"
        ];
    }

    public function delete()
    {
        $form = Form::findOrFail($this->form_id);
        FormUser::where("form_id", $form->id)->delete();
        FormOwner::where("form_id", $form->id)->delete();
        FormData::where("form_id", $form->id)->delete();

        FormTimeline::create([
            'form_id' => $form->id,
            'user_id' => auth()->user()->id,
            'title' => 'Deleted form, ' . $form->form_name,
            'icon' => 'fas fa-trash-alt',
            'color' => randomColor(),
            'timeline_by' => auth()->user()->name
        ]);

        $form->delete();

        return response()->json("DELETED", 200);
    }
}
