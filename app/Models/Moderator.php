<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;


class Moderator extends Model
{
    use HasFactory;

    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes
           
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'moderatorId';
    protected $fillable = [
        'userId',
        'firstName',
        'lastName',
        'moderatorCreatedBy',
        'moderatorRole',

    ];

     /**
     * Get the user for this moderator.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

     /**
     * Get the sa who created this moderator.
     */
    public function superadmin()
    {
        return $this->belongsTo(SuperAdmin::class, 'moderatorCreatedBy');
    }
}
