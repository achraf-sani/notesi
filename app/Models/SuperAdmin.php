<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;



class SuperAdmin extends Model
{
    use HasFactory;

    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes
           /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'superAdminId';
    protected $fillable = [

        'userId',
        'firstName',
        'lastName',
        'superAdminAvatar',
        'superAdminRole',
 
    ];
    
    /**
     * Get the user for this sa.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * Get the moderators created by this sa.
     */
    public function moderators()
    {
        return $this->hasMany(Moderator::class, 'moderatorCreatedBy');
    }


}

