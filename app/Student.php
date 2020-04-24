<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis',
        'name',
        'address',
        'phone_number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parent()
    {
        return $this->hasOne('App\StudentParent', 'student_id');
    }

    public function location()
    {
        return $this->hasMany('App\Location');
    }
}
