<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormOwner extends Model
{
    protected $fillable = [
        'assigned_form_owner_id',
        'form_id',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, "form_id", "id");
    }
}
