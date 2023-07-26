<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;

class Mark extends Model
{
    use HasFactory;

    use QueryCacheable;
    protected $cacheFor = 180; // 3 minutes
       
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'markId',//self implemented Id
        'courseId',
        'studentId',
        'mark',
    ];

     /**
     * Get the student with this mark.
     */
    protected $primaryKey = 'markId';
    public $incrementing = false;//not auto inc key
    protected $keyType = 'string';

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentId');
    }

     /**
     * Get the course with this mark.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId');
    }


}
