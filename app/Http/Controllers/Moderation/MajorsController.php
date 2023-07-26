<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Major;


class MajorsController extends Controller
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
     * function to controll access to majors space
     */
    public function getMajorsCpanel() {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            return view("cpanel.majors");
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' => 'You are not allowed to use this website!']);
    }
    
    /**
     * function to parse uploaded file and update database.
     */
    public function addMajors(Request $request) {
        //dd($request);
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            
            $upload = $request->file('file');
            $filePath = $upload->getRealPath();
            $file = fopen($filePath, "r");
            // dd($upload->getClientOriginalName());
            $updated = array();
            $created = array();
            while (($column = fgetcsv($file, 10000, ",")) !== False){
                //dd($column);
                $majorName = $column[0];
                $semesterName = $column[1];
                $majorAbbrev = $column[2];
                //get semester id and push the rest to the DB
                $semesterId = Semester::where('semesterName', $semesterName)->first()->semesterId;
                //dd($majorName, $semesterId, $majorAbbrev);
                // $test = new Major;
                // $test->fill(['semesterId' => $semesterId,
                //     'majorAbbreviation' => $majorAbbrev,
                //     'majorName' => utf8_encode($majorName),]
                // );
                // dd($test);
                $insert_majors = Major::dontCache()->updateOrCreate(
                    [
                        'semesterId' => $semesterId,
                        'majorAbbreviation' => $majorAbbrev,
                    ],//if a record with semid and majorAbbrev exists
                    [
                        'majorName' => utf8_encode($majorName),
                    ]//update name, else merge arrays and insert
                );   
                if(!$insert_majors->wasRecentlyCreated && $insert_majors->wasChanged()){
                    // updateOrCreate performed an update
                    array_push($updated, $insert_majors);
                }

                if($insert_majors->wasRecentlyCreated){
                // updateOrCreate performed create
                    array_push($created, $insert_majors);
                }   
            //dd($insert_majors->majorId);
            }
            Major::flushQueryCache();
            return view('cpanel.majors', ['updated' => $updated, 'created' => $created]);
        }
        else {
            return redirect()->route("errorPage")->withErrors(['msg' => 'You are not allowed to use this website!']);
        }
        
    }
}
