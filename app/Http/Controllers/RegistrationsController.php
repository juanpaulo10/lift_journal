<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationForm;

class RegistrationsController extends Controller
{

    /**
     * registration form
     *
     * @return void
     */
    public function create()
    {
        return view('registrations.create');
    }
    
    public function store(RegistrationForm $oRegForm)
    {
        $oRegForm->persist();

        return [
            'message' => 'Register Success!',
            'url' => url('/')
        ];
    }
}
