<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Rennokki\QueryCache\Traits\QueryCacheable;



class Semester extends Model
{
    use HasFactory;

    //use QueryCacheable;
    //protected $cacheFor = 180; // 3 minutes
    // do not cache semester as we update it and it might change

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'semesterId';
    protected $fillable = [
        'semesterName',
    ];

     /**
     * Get the majors for this semester.
     */
    public function majors()
    {
        return $this->hasMany(Major::class, 'semesterId');
    }

    /**
     * Get the students for this semester.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'currentSemester');
    }
}
