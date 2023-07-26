<?php

namespace App\Http\Controllers\Moderation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class DashboardController extends Controller
{
    public function dashboard() {
        if (!Auth::check()) {
            return redirect()->route("welcome");
        }
        else if(count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) 
        { 
            return view('cpanel.dashboard');
        }
        else {
            return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
        }
        
        }
}
