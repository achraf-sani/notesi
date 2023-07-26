<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Major;



class AuthController extends Controller
{

    /**
     * redirects user to outlook
     */
    public function signin() {
      // Initialize the OAuth client
      $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => config('azure.appId'),
        'clientSecret'            => config('azure.appSecret'),
        'redirectUri'             => config('azure.redirectUri'),
        'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
        'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
        'urlResourceOwnerDetails' => '',
        'scopes'                  => config('azure.scopes')
      ]);

      $authUrl = $oauthClient->getAuthorizationUrl();
      return redirect()->away($authUrl);
    }

     /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
    
  
    public function welcome() {
      if (Auth::check()) {
        $semester = Auth::user()->students()->dontCache()->first()->currentSemester;
        if($semester != null) {
          return redirect()->route('home', [$semester]);
        }
        else {
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
          return redirect()->route('landing')->with(["availableSemesters" => $availableSemesters]);
        }
        
      }
      else {
        return view('welcome');
      }
    }

    public function landing() {
      if (Auth::check()) {
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
        return view('landing')->with(["availableSemesters" => $availableSemesters]);
      }
      else {
        //$semester = Auth::user()->students()->first()->currentSemester;
        return redirect()->route('welcome');
      }
    }

    public function callback(Request $request) {
   
    // Authorization code should be in the "code" query param
    $authCode = $request->query('code');
    //dd($authCode);
    if (isset($authCode)) {
        // Initialize the OAuth client
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => config('azure.appId'),
            'clientSecret'            => config('azure.appSecret'),
            'redirectUri'             => config('azure.redirectUri'),
            'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
            'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => config('azure.scopes')
        ]);

        //dd($oauthClient);
  
        
        try {
          // Make the token request
          $accessToken = $oauthClient->getAccessToken('authorization_code', [
            'code' => $authCode
          ]);
          //dd($accessToken);
          $graph = new Graph();
          $graph->setAccessToken($accessToken->getToken());
        
          $user = $graph->createRequest('GET', '/me')
            ->setReturnType(Model\User::class)
            ->execute();
        //dd($user);

        $fullName = $user->getDisplayName();
        //dd($user);
        $fullName = strtolower(preg_replace("/[^A-Za-z\w]/", '', $fullName));
        //dd($fullName);

      /*  Dummy data
      $student = Student::factory()->create([
          'firstName' => 'Adnane',
          'lastName' => 'Benazzou',
        ]);
        $student -> save();*/

        $exists = Student::where('fullName', $fullName)->get();
      //dd($exists);
      if (!sizeof($exists)) {//size of exists == 0
        //student doesn't exist
        //redirection
        return redirect()->route("welcome")->withErrors(['msg' => 'You are not allowed to use this website!']);

      }
      else {
        $auth_user = User::updateOrCreate([
          'email'=> $user->getMail(),
          'firstName'=>$user->getGivenName(),
          'lastName'=> $user->getSurname()
        ]);
        foreach($exists as $student) {
          $student->user()->associate($auth_user);
          $student->save();
        }
        
        Auth::loginUsingId($auth_user->userId);
        $currentSemester = $exists[0]->currentSemester;//they all have the same currentSemester
       // dd();
        if (count($exists[0]->user->superadmins) > 0 || count($exists[0]->user->moderators) > 0) {//they all are related to the same user
          //dd($exists->user->superadmins);
          return redirect()->route('dashboard');
        }
        else if($currentSemester) {
          return redirect()->route('home', [$currentSemester]);
          //return redirect()->route('home')->with(["currentSemester" => $currentSemester]);
        }
        else {
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
          return redirect()->route('landing')->with(["availableSemesters" => $availableSemesters]);
        }
        
        
      }
      
    }
    catch (\Throwable $th) {        
         throw $th;
        }
      }
    }
}
