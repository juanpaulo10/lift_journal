<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
use App\User;

class RegistrationForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|alpha_num|min:6'
        ];
    }

    /**
     * creates a user
     * logs in with session
     * mails to mailtrap (in the meanwhile)
     *
     * @return void
     */
    public function persist()
    {
        $oUser = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt( $this->password )
        ]);

        //login the user
        auth()->login($oUser);

        //mailto // fetches email addr of user
        Mail::to( $oUser )->send(new Welcome( $oUser ));
    }
}
