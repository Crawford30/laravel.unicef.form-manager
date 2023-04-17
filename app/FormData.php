<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    protected $fillable = [
        'user_id',
        'form_id',
        'fields_data'
    ];

    protected $casts = ['fields_data' => 'array'];

    public function form()
    {
        return $this->belongsTo(Form::class, "form_id", "id");
    }
}
