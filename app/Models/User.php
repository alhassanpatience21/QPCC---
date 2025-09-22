<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ADMIN = 'Administrator';
    const SECRETARTY = 'Secretary';
    const AGENT = 'Agent';


    public function accounts()
    {
        return $this->hasMany(Account::class, 'registered_by');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'entered_by');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'entered_by');
    }

    public function scopeNotAdmin($query)
    {
        return $query->where('email', '!=', 'admin@sageitservices.com');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'agent');
    }
}
