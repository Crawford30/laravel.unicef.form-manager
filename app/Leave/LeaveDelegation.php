<?php

namespace App\Leave;

use App\StaffProfile;
use Illuminate\Database\Eloquent\Model;

class LeaveDelegation extends Model
{
    protected $connection = "leave_connection";

    protected $appends = ['staff'];

    protected $fillable = ['delegated_role_to', 'leave_id'];

    public function getStaffAttribute()
    {
        return StaffProfile::where('personal_id', $this->delegated_role_to)->first();
    }
}
