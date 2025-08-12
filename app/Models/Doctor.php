<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'doctors';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'department_id',
        'image',
        'licence_number',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
