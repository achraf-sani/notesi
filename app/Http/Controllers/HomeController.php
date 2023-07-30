<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Course;
use App\Models\Major;
use App\Models\Mark;
use App\Models\Module;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Calculates the rank for the given semester of the user along with the mean of the class of the user
     * 
     */
    public function getRankAndClassMean($semesterMark, $studentPromo, $studentMajor, $studentSemester) {

        $allRelatedStudents = Auth::user()->students()->get();
        $studentIds = array();
        foreach($allRelatedStudents as $relatedStudent) {
            //get all student ids for this user
            array_push($studentIds, $relatedStudent->studentId);
        }
        //dd($studentIds);

        $students = Student::where('studentPromo', $studentPromo)
                            ->where('studentMajor', $studentMajor)
                            ->whereNotIn('studentId', $studentIds)
                            ->get();
        //dd($students);


        $studentsMarks = array($semesterMark);
        //$studentsMarks = array("Logged in user" => $semesterMark);//uncomment for general ranks 
        //get marks by studentSemester
        //ini_set('max_execution_time', 0);
        foreach ($students as $student) {
            $modules = $this->calculateModules($student->marks, $studentSemester);
            $mark = $this->calculateSemesterMark($modules);
            array_push($studentsMarks, $mark);
           //$studentsMarks[$student->lastName." ".$student->firstName] = $mark;//uncomment for general ranks
        }
        rsort($studentsMarks);
        //arsort($studentsMarks);//uncommment for general ranks
        //dd($studentsMarks);//uncomment for general ranks
       // dd(array_search($semesterMark, $studentsMarks) + 1);
        $rank = array_search($semesterMark, $studentsMarks) + 1;

        return ['rank' => $rank, 'classMean' => round(array_sum($studentsMarks)/count($studentsMarks), 2)];
    }

    /**
     * Calculate the module marks and returns them similiar to a json.
     */
    public function calculateModules($marks, $currentSemester) {
        $modules = array();
        //dd($marks);
        foreach ($marks as $mark) {
            //dd($mark->course->module->major->semester->semesterId);
            if ($mark->course->module->major->semesterId == $currentSemester) {//if module is part of this semester
                $module = "module".$mark->course->module->moduleId;
                
                /**
                 * decode utf-8 for french characters
                 */
                $moduleName = $mark->course->module->moduleName;
                if (preg_match('!!u', $moduleName))
                {
                    // This is UTF-8
                    $moduleName = utf8_decode($moduleName);
                    
                }
                $courseName = $mark->course->courseName;
                if (preg_match('!!u', $courseName))
                {
                    // This is UTF-8
                    $courseName = utf8_decode($courseName);
                }

                if (!array_key_exists($module, $modules)) {
                    $modules += [
                        $module => [
                            "moduleName" => $moduleName,
                            "moduleCoeff" => $mark->course->module->moduleCoeff,
                            "moduleMark" => round($mark->course->courseCoeff * $mark->mark / 100, 2) ,
                            "isRatt" => $mark->ratt,
                            "courses" => [
                                [
                                    "courseName" => $courseName,
                                    "courseCoeff" => $mark->course->courseCoeff,
                                    "courseMark" => $mark->mark,
                                ],
                            ]
                        ]
                    ];
                }
                else {
                    if ($mark->ratt){
                        $modules[$module]["isRatt"] = $mark->ratt;
                    }
                    array_push($modules[$module]["courses"],
                                [
                                    "courseName" => $courseName,
                                    "courseCoeff" => $mark->course->courseCoeff,
                                    "courseMark" => $mark->mark,
                                ]);
                    $modules[$module]["moduleMark"] += round($mark->course->courseCoeff * $mark->mark / 100, 2);
                }
            }
        }
        foreach ($modules as $module => $modulev) {
            if(($modulev["isRatt"]) && ($modulev["moduleMark"] > 12)){
                $modules[$module]["moduleMark"] = 12;
            }
        }
        ksort($modules);
        return $modules;
    }

    /**
     * calculates the mark for the whole semester
     */
    public function calculateSemesterMark($modules) {
        $mark = 0;
        foreach($modules as $module) {
            $mark += round($module["moduleCoeff"] * $module["moduleMark"] / 100, 2);
        }
        return $mark;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($currentSemester)//current semester id
    {
        //dd(Auth::user()->superadmins);
        $userId = Auth::user()->userId;
        $currentSemester = intval($currentSemester);
        $currSemester = Semester::where('semesterId', $currentSemester)->first();
        //dd($currSemester);
        $students = Student::where('userId', $userId)->get();
        $current_student = "";
        //dd($students);
        foreach($students as $student) {
            $semesterId = $student->major->semester->semesterId;
           // array_push($current_student, $semesterId);
           // dd($semesterId, $currentSemester);
            if ($semesterId == $currentSemester) {// the semester for this student major is the chosen semester
               $current_student = $student;
                
            }
        }
        if ($current_student == "") {
            //current semester doesnt exist for given user , show message that it doesnt exists
            $name = Auth::user()->students()->dontCache()->first()->fullName;
            $availableMajors = Student::where('fullName', $name)->pluck('studentMajor')->toArray();//array of studentMajorIds
            // dd($availableMajors);
            $availableSemesters = array();
            foreach ($availableMajors as $availableMajor) {
                $SEMESTER = Major::where('majorId', $availableMajor)->first()->semester;
                $availableSemesters[$SEMESTER->semesterName] = $SEMESTER->semesterId;
                //array_push($availableSemesters, $SEMESTER->semesterId);
            }
            ksort($availableSemesters);
            $availableSemesters = array_values($availableSemesters);


            //dd($availableSemesters);  
            $msg='No marks available yet for the selected semester, Please select another one ! 
            If the problem persists, please consider contacting us :D';
            //dd("here");
            return redirect()->route('errorPage')->with(["availableSemesters" => $availableSemesters])->withErrors(['msg' => $msg]);
        }
        $student = $current_student;//this is the major for this user for the given semester
        
        $majorAbbreviation = $student->major->majorAbbreviation;
        $master = (str_contains($majorAbbreviation, "ICD") == false) ? true : false;//true if icd not in abbrev else false
        $major = $student->major->majorName;
        if (preg_match('!!u', $major))
        {
            // This is UTF-8
            $major = utf8_decode($major);
        }

        //dd($major);
        $marks = $student->marks;
       // dd($student);
        //dd($student);
        //dd($marks);
        //dd($student->currentSemester);
        $modules = $this->calculateModules($marks, $currentSemester);
        //dd($modules);
        
        $semesterMark = $this->calculateSemesterMark($modules);
        //dd($semesterMark);
        $semester = [
            "semesterName" => $currSemester->semesterName,
            "semesterMark" => $semesterMark,
        ];

        //dd($student);
        
        $rankAndClassMean = $this->getRankAndClassMean($semesterMark, $student->studentPromo, $student->studentMajor, $currentSemester);

        //dd($rankAndClassMean);

        $rank = $rankAndClassMean["rank"];
        
        $classMean = $rankAndClassMean["classMean"];
        // dd($classMean); 
        
        $name = Auth::user()->students()->dontCache()->first()->fullName;
        $availableMajors = Student::where('fullName', $name)->pluck('studentMajor')->toArray();//array of studentMajorIds
        // dd($availableMajors);
        $availableSemesters = array();
        foreach ($availableMajors as $availableMajor) {
            $SEMESTER = Major::where('majorId', $availableMajor)->first()->semester;
            $availableSemesters[$SEMESTER->semesterName] = $SEMESTER->semesterId;
            //array_push($availableSemesters, $SEMESTER->semesterId);
        }
        ksort($availableSemesters);
        $availableSemesters = array_values($availableSemesters);


        //dd($modules, $semester, $rank, $classMean, $major);
        if (count($modules) == 0 ) {
            //dd("HERE");
            $msg='No marks available yet for the selected semester, Please select another one ! 
            If the problem persists, please consider contacting us :D';
            return redirect()->route('errorPage')->with(["availableSemesters" => $availableSemesters])->withErrors(['msg' => $msg]);
        }
        return view('home', ['semester' => $semester, 'modules' => $modules, 'major' => $major, 'rank' => $rank, 'classMean'=>$classMean, 'availableSemesters'=>$availableSemesters, 'master' => $master ]);
    }
}
