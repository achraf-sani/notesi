<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Major;
use App\Models\Module;

class ModulesController extends Controller
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
     * function to controll access to modules space
     */
    public function getModulesCpanel() {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            return view("cpanel.modules");
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
    }
    
    /**
     * function to parse uploaded file and update database.
     */
    public function addModules(Request $request) {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) { 
            $updated = array();
            $created = array();
            foreach($request->file('files') as $key => $file) {
                //dd($key, $file);
                $name = $file->getClientOriginalName();
                $name = substr($name, 0, strlen($name) - 4);
                $semester_majorAbbrev = explode("_", $name);
                $semesterName = $semester_majorAbbrev[0];
                $majorAbbrev = $semester_majorAbbrev[1];
                //get semester id 
                $semesterId = Semester::where('semesterName', $semesterName)->first()->semesterId;
                //dd($semesterId);
                $majorId = Major::where('majorAbbreviation', $majorAbbrev)->where('semesterId', $semesterId)->first()->majorId;
                //dd($semester, $majorAbbrev);
                $filePath = $file->getRealPath();
                $file_open = fopen($filePath, "r");
                while (($column = fgetcsv($file_open, 10000, ",")) !== False){
                    $moduleName = $column[0];
                    $moduleCoeff = floatval($column[1]);
                    $moduleAbbrev = $column[2];
                   // dd(utf8_encode($moduleName));
                    //dd($moduleName, $moduleCoeff, $moduleAbbrev, $majorId);
                    $insert_modules = Module::dontCache()->updateOrCreate(
                        [
                            'moduleAbbreviation' => $moduleAbbrev,
                            'moduleMajor' => $majorId,//the major in which this module exists
                        ],
                        [
                            'moduleName' => utf8_encode($moduleName),
                            'moduleCoeff' => $moduleCoeff,//if exists update coeff
                        ]
                    );   
                    if(!$insert_modules->wasRecentlyCreated && $insert_modules->wasChanged()){
                        // updateOrCreate performed an update
                        array_push($updated, $insert_modules);
                    }

                    if($insert_modules->wasRecentlyCreated){
                    // updateOrCreate performed create
                        array_push($created, $insert_modules);
                    }   
                }   
            }
            Module::flushQueryCache();
            return view('cpanel.modules', ['updated' => $updated, 'created' => $created]);
        }
        else {
            return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
        }
        
    }
}