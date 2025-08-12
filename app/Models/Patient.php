<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable implements CanResetPassword
{
    use HasFactory;
    use Notifiable;

    protected $primaryKey = 'id';
    protected $table = 'patients';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'gender',

    ];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
