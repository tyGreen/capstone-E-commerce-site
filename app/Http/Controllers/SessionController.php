<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class SessionController extends Controller
{
    // GET current session data
    public function getData(Request $request)
    {
        // If current session had session id & ip address set
        if($request->session()->has('session_id') && $request->session->has('ip_address'))
        {
            // Echo id & ip to screen
            echo $request->session()->get('session_id');
            echo $request->session()->get('ip_address');
        }
        else
        {
            // Otherwise, create new session
            $this->createNew();
        }      
    }


    // CREATE new session
    public function createNew()
    {
        // Create new session object
        $newSession = new Session;

        // Get user's ip address & store in var
        $user_ip = request()->ip();
        // Get current session id & store in var
        $user_session = Session::getId();
            // $session_id = session()->getId();    ALTERNATIVE

        // Set session id and ip address to those passed into f(x)
        $newSession->put('session_id', $user_session);
        $newSession->put('ip_address', $user_ip);
    }      
}
