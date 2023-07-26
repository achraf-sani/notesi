<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Moderator;
use App\Models\SuperAdmin;

class ModeratorsController extends Controller
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
     * returns a list of all users that arent moderators or superadmins so that you can select one of them to be moderator.
     */
    public function getModeratorsCpanel() {
        if (count(Auth::user()->superadmins) > 0) {//only superadmins

            $users = User::all();
            $data = array();
            $moderators = array();
            foreach($users as $user) {
                if (count($user->superadmins) <= 0 && count($user->moderators) <= 0) {
                    array_push($data, $user);//user not admin and not moderator -> can be made moderator
                }
                else if (count($user->superadmins) <=0) {
                    array_push($moderators, $user);
                }
            }
            //dd($data);
            return view("cpanel.moderators", ['users' => $data, 'moderators' => $moderators]);
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' =>"You don't have permission to access this page.!"]);
    }

     /**
     * function to make selected user a moderator.
     */
    public function addModerators($id) {
        //dd($id);
        if (count(Auth::user()->superadmins) > 0) {
            //only superadmins
            $user = User::where('userId', $id)->first();
            $moderator = Moderator::dontCache()->updateOrCreate(
                [
                    'userId' => $id,
                    'firstName' => $user->firstName,
                    'lastName' => $user->lastName,
                    'moderatorRole' => 'moderator',
                    'moderatorCreatedBy' => Auth::user()->superadmins->first()->superAdminId,
                ]
            );
           // dd($moderator);

        }
        Moderator::flushQueryCache();
        return redirect()->route('moderators');
    }

    public function removeModerator($id) {
       // dd($id);
        if (count(Auth::user()->superadmins) > 0) {
            //only superadmins
            $result = Moderator::where('userId', $id)->delete();
            

        }
        Moderator::flushQueryCache();
        return redirect()->route('moderators');

    }
}
