<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $connection = "auth_connection";
    
    protected $fillable = [
        "personal_id", "action", "description", "status"
    ];
}
