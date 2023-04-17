<?php

namespace App\Http\Requests;

use App\Form;
use App\User;
use App\EmailLog;
use App\FormUser;
use App\FormOwner;
use App\FormTimeline;
use App\StaffProfile;
use App\Mail\FormUserEmail;
use App\Mail\FormOwnerEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array('forms', auth()->user()->permissions);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  [];
    }

    public function saveForm()
    {
        if ($this->hasFile('form_icon')) {
            $file = storeFile('upload', $this->file('form_icon'));
            $imagePath = $file->file_path;
        } else {
            $imagePath = null;
        }

        $data = [
            "user_id" =>  auth()->user()->id,
            "form_name" => $this->form_name,
            "form_description" => $this->form_description,
            "form_color" => $this->form_color,
            "icon_name" => $imagePath,
            "field_type" =>  json_encode($this->fields, true),
            "form_categories" => json_encode($this->form_categories, true),
            "is_completed" => json_decode($this->form_is_completed)
        ];

        if($this->has('form_id')) {
            $form = Form::updateOrCreate(["id" => $this->form_id], $data);
            FormTimeline::create([
                'form_id' => $form->id,
                'user_id' => auth()->user()->id,
                'title' => 'Updated a new form, ' . $form->form_name,
                'icon' => 'fas fa-pen',
                'color' => randomColor(),
                'timeline_by' => auth()->user()->name
            ]);
        } else {
            $form = Form::create($data);
            FormTimeline::create([
                'form_id' => $form->id,
                'user_id' => auth()->user()->id,
                'title' => 'Created a new form, ' . $form->form_name,
                'icon' => 'fas fa-plus',
                'color' => randomColor(),
                'timeline_by' => auth()->user()->name
            ]);
        }

        if($this->has('form_users') && is_array($this->form_users)) {
            FormUser::where('form_id', $form->id)->delete();
            foreach ($this->form_users as $user) {
                $staff = StaffProfile::find($user);
    
                if ($staff != null && $staff->email) {
                    $user = User::where('email', $staff->email)->first();
                    if($user != null) {
                        $userForm = FormUser::where('assigned_user_id', $user->id)
                                                ->where('form_id', $form->id)
                                                ->first();

                        if($userForm == null) {
                            FormUser::updateOrCreate(
                                [
                                    "assigned_user_id" => $user->id,
                                    "form_id" => $form->id,
                                ], 
                                []
                            );

                            $checkTimeline = FormTimeline::where('form_id', $form->id)
                                                            ->where('user_id', $user->id)
                                                            ->where('title', 'Added to form, ' . $form->form_name)
                                                            ->first();

                            if($checkTimeline == null) {
                                FormTimeline::create([
                                    'form_id' => $form->id,
                                    'user_id' => $user->id,
                                    'title' => 'Added to form, ' . $form->form_name,
                                    'icon' => 'fas fa-user-plus',
                                    'color' => randomColor(),
                                    'timeline_by' => auth()->user()->name
                                ]);
                            }
            
                            if($form->is_completed) {
                                $this->dispatchFormUserEmail($form->form_name, $staff->name, $staff->email, auth()->user()->name, $form->id);
                            }
                        }
                    }
                }
            }
        }

        if($this->has('form_owners') && is_array($this->form_owners)) {
            FormOwner::where('form_id', $form->id)->delete();
            foreach ($this->form_owners as $user) {
                $staff = StaffProfile::find($user);
    
                if ($staff != null && $staff->email) {
                    $user = User::where('email', $staff->email)->first();

                    if($user != null) {
                        $userForm = FormOwner::where('assigned_form_owner_id', $user->id)
                                                ->where('form_id', $form->id)
                                                ->first();

                        if($userForm == null) {
                            FormOwner::updateOrCreate(
                                [
                                    "assigned_form_owner_id" => $user->id,
                                    "form_id" => $form->id,
                                ], []
                            );

                            $checkTimeline = FormTimeline::where('form_id', $form->id)
                                                            ->where('user_id', $user->id)
                                                            ->where('title', 'Added to form as owner, ' . $form->form_name)
                                                            ->first();
                            
                            if($checkTimeline == null) {
                                FormTimeline::create([
                                    'form_id' => $form->id,
                                    'user_id' => $user->id,
                                    'title' => 'Added to form as owner, ' . $form->form_name,
                                    'icon' => 'fas fa-user-plus',
                                    'color' => randomColor(),
                                    'timeline_by' => auth()->user()->name
                                ]);
                            }
            
                            if($form->is_completed) {
                                $this->dispatchFormOwnerEmail($form->form_name, $staff->name, $staff->email, auth()->user()->name);
                            }
                        }
                    }
                }
            }
        }

        return response()->json($form, 200);
    }

    private function dispatchFormUserEmail($formName, $name, $email, $fromName, $formId)
    {
        $emailLog = EmailLog::create([
            "to" => $email,
            "description" => "Form User Rights Assigned"
        ]);

        $emailLog->updateCode();

        try {
            $mail = (new FormUserEmail($emailLog, $formName, $name, $email, $fromName, $formId));
            $emailLog->update([
                "body" => $mail->render()
            ]);
            Mail::to($email)->send($mail);
        } catch (\Exception $exception) {}
    }

    private function dispatchFormOwnerEmail($formName, $name, $email, $fromName)
    {
        $emailLog = EmailLog::create([
            "to" => $email,
            "description" => "Form Owner Rights Assigned"
        ]);

        $emailLog->updateCode();

        try {
            $mail = (new FormOwnerEmail($emailLog, $formName, $name, $email, $fromName));
            $emailLog->update([
                "body" => $mail->render()
            ]);
            Mail::to($email)->send($mail);
        } catch (\Exception $exception) {}
    }
}
