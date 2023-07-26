<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;



class Student extends Model
{
    use HasFactory;

    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'studentId';
    protected $fillable = [

        'currentSemester',
        'firstName',
        'lastName',
        'fullName',
        'userId',
        'studentPromo',
        'studentGroup',
        'studentMajor',//ID
    
 
    ];

    /**
     * Get the user for this student.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

     /**
     * Get the selected semester for this student.
     */
    public function currentSemester()
    {
        return $this->belongsTo(Semester::class, 'currentSemester');
    }

    /**
     * Get the major for this student.
     */
    public function major()
    {
        return $this->belongsTo(Major::class, 'studentMajor');
    }

     /**
     * Get the marks for this student.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class, 'studentId');
    }

}
