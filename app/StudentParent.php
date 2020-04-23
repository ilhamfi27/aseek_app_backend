<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'orang_tua';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'alamat', 'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function student()
    {
        return $this->belongsTo('App\Student', 'id_siswa', 'id');
    }
}
