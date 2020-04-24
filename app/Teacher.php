<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'nip', 
        'position',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
