<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Rennokki\QueryCache\Traits\QueryCacheable;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'userId';
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the superadmins.
     */
    public function superadmins()
    {
        return $this->hasMany(SuperAdmin::class, 'userId');
    }

    /**
     * Get the students
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'userId');
    }

    /**
     * Get the superadmins.
     */
    public function moderators()
    {
        return $this->hasMany(Moderator::class, 'userId');
    }
}
