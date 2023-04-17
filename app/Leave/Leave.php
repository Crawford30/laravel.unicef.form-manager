<?php

namespace App\Leave;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $connection = "leave_connection";

    protected $fillable = [
        'personal_id', 'start', 'end', 'days', 'delegated_to', 'status', 'name'
    ];
}