<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $connection = "auth_connection";

    protected $appends = ['permissions'];

    protected $hidden = ['password'];

    public function getPermissionsAttribute()
    {
        return collect(UserPermission::where('user_id', $this->id)->get())
                    ->map(function($d){ return $d->permission; })->values()->all();
    }


    public function assignedForms(){
        $forms = Form::where('assigned_user_id', $this->id)
                        ->orderBy('created_at', 'DESC')->get();
        return $forms->load('form');
    }


    public function ownedForms(){
        $forms = FormOwner::where('assigned_form_owner_id', $this->id)
                        ->orderBy('created_at', 'DESC')->get();
        return $forms->load('form');
    }


    public function userFormsData(){
        $formsData = FormData::where('user_id', $this->id)
                        ->orderBy('created_at', 'DESC')->get();
        return $formsData->load('form');
    }
}
