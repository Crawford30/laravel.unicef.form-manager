<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormUser extends Model
{

    protected $fillable = [
        'assigned_user_id',
        'form_id',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class,"form_id","id");
    }
}
