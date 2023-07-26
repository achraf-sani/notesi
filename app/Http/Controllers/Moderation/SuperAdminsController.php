<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Moderator;
use App\Models\SuperAdmin;  

class SuperAdminsController extends Controller
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

    public function getSuperadminsCpanel() {
        if (count(Auth::user()->superadmins) > 0) {//only superadmins
            $users = User::all();
            $data = array();
            $moderators = array();
            $superadmins = array();
            foreach($users as $user) {
                if (count($user->superadmins) <= 0 && count($user->moderators) <= 0) {
                    array_push($data, $user);//user not admin and not moderator -> can be made moderator
                }
                else if (count($user->superadmins) <=0) {
                    array_push($moderators, $user);
                }
                else {
                    array_push($superadmins, $user);
                }
            }

            return view("cpanel.superadmins", ['users' => $data, 'moderators' => $moderators, 'superadmins' => $superadmins]);
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
    }

     /**
     * function to make selected user a superadmin.
     */
    public function addSuperadmins($id) {
        if (count(Auth::user()->superadmins) > 0) {
            //only superadmins
            $user = User::where('userId', $id)->first();
            $superadmin = SuperAdmin::dontCache()->updateOrCreate(
                [
                    'userId' => $id,
                    'firstName' => $user->firstName,
                    'lastName' => $user->lastName,
                    'superAdminRole' => 'superadmin',
                    'superAdminAvatar' => 'avatar',
                ]
            );

        }
        SuperAdmin::flushQueryCache();
        return redirect()->route('superadmins');
    }

}
