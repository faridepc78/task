<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'password',
        'role',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    const ADMIN = 'admin';
    const USER = 'user';
    static $roles =
        [
            self::ADMIN,
            self::USER
        ];

    public function getFullNameAttribute()
    {
        return $this->f_name . ' ' . $this->l_name;
    }

    public function getProfileAttribute()
    {
        return getGravatar($this->email);
    }
}
