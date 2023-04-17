<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'user_id',
        'form_name',
        'form_description',
        'form_categories',
        'form_color',
        'icon_name',
        'field_type',
        'is_completed'
    ];

    protected $casts = [
        'field_type' => 'array',
        'form_categories' => 'array'
    ];

    protected $appends = [
        'users_count', 'owners_count', 'data_count', 'owner_ids', 
        'owner_profile_ids', 'user_profile_ids', 'grouped_fields', 
        'fields', 'categories', 'fields_count', 'viewers_count'];

    protected $hidden = [
        'field_type',
        'form_categories'
    ];

    public function users()
    {
        return $this->hasMany(FormUser::class, 'form_id', 'id');
    }

    public function owners()
    {
        return $this->hasMany(FormOwner::class, 'form_id', 'id');
    }

    public function data()
    {
        return $this->hasMany(FormData::class, 'form_id', 'id');
    }

    public function getUsersCountAttribute()
    {
        return count($this->users);
    }

    public function getOwnersCountAttribute()
    {
        return count($this->owners);
    }

    public function getDataCountAttribute()
    {
        return FormData::where('form_id', $this->id)->count();
    }

    public function getOwnerIdsAttribute()
    {
        return $this->owners->pluck('assigned_form_owner_id');
    }

    public function getViewersCountAttribute()
    {
        return collect($this->owner_ids)
                    ->merge(UserPermission::where('permission', 'forms')->get()->pluck('user_id'))
                    ->unique()->count();
    }

    public function getOwnerProfileIdsAttribute()
    {
        $profileIds = [];

        foreach($this->owner_ids as $id) {
            $user = User::find($id);
            if($user != null) {
                $profile = StaffProfile::where('email', $user->email)->first();
                if($profile != null) {
                    $profileIds[] = $profile->id;
                }
            }
        }

        return $profileIds;
    }

    public function getUserProfileIdsAttribute() 
    {
        $profileIds = [];

        foreach($this->users as $user) {
            $user = User::find($user->assigned_user_id);
            if($user != null) {
                $profile = StaffProfile::where('email', $user->email)->first();
                if($profile != null) {
                    $profileIds[] = $profile->id;
                }
            }
        }

        return $profileIds;
    }

    public function getGroupedFieldsAttribute()
    {
        $form = collect(json_decode($this->field_type));
        $fields = $form->groupBy('category');
        return collect($fields);
    }

    public function getFieldsAttribute()
    {
        return collect(json_decode($this->field_type))->values();
    }

    public function getCategoriesAttribute()
    {
        return collect(json_decode($this->form_categories))->values();
    }

    public function getFieldsCountAttribute()
    {
        return collect($this->fields)->count();
    }
}
