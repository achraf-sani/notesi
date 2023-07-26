<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;


class Course extends Model
{
    use HasFactory;
    
    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'courseId';
    protected $fillable = [
        'courseName',
        'courseCoeff',
        'moduleId',
        'courseAbbreviation',
    ];

    /**
     * Get the module that owns the course.
     */
    public function module()
    {
        return $this->belongsTo(Module::class, 'moduleId');
    }

    /**
     * Get the marks for this course.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class, 'courseId');
    }
    



}
