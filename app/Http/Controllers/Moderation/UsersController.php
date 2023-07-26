<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UsersController extends Controller
{
    //
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
    public function getUsersCpanel() {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {//superadmins and moderators
            $usersCount = User::count();
            $users = User::all();
            return view("cpanel.users", [ 'usersCount' => $usersCount, 'users' => $users]);
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
    }
    
}
