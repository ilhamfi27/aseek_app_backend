<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis', 'nama', 'alamat', 'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parent()
    {
        return $this->hasOne('App\StudentParent', 'id_siswa');
    }

    public function location()
    {
        return $this->hasMany('App\Location');
    }
}
