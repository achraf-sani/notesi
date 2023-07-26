<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;



class Module extends Model
{
    use HasFactory;

    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes
               
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'moduleId';
    protected $fillable = [
        'moduleName',
        'moduleCoeff',
        'moduleMajor',
        'moduleAbbreviation',
    ];

     /**
     * Get the course for this module.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'moduleId');
    }

    /**
     * Get the Major that owns the module.
     */
    public function major()
    {
        return $this->belongsTo(Major::class, 'moduleMajor');
    }

}
