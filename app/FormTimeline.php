<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormTimeline extends Model
{
    protected $fillable = [
        'form_id',
        'user_id',
        'title',
        'icon',
        'color',
        'timeline_by'
    ];
}
