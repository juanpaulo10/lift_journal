<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['destroy']);
    }

    /**
     * Login page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.login');
    }

    /**
     * Log in an authenticated user, else do not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate( $request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if( !auth()->attempt(request(['email', 'password'])) ){ //If not, go to login page. input error
            return abort(401, "Please check your credentials");
        }

        //send json to reply the homepage
        return ['url' => '/'];
    }

    /**
     * destroy current session, log out the auth user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        auth()->logout();
        
        return redirect('/login');
    }
}
