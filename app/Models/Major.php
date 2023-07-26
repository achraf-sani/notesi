<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;

class Major extends Model
{
    use HasFactory;
    
    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'majorId';
    protected $fillable = [
        'majorName',
        'semesterId',
        'majorAbbreviation',
    ];

    /**
     * Get the Semester that owns the major.
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semesterId');
    }

    /**
     * Get the students for this major.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'studentMajor');
    }

    /**
     * Get the modules for this major
     */
    public function modules()
    {
        return $this->hasMany(Module::class, 'moduleMajor');
    }

}
