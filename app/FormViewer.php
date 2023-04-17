<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormViewer extends Model
{
    protected $fillable = [
        'user_id',
        'form_id'
    ];
}
