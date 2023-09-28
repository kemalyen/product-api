<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class LoginController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:8'
        ];


        $validator = Validator::make($request->all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            // create our user data for the authentication
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                // validation successful
                // do whatever you want on success
            } else {
                // validation not successful, send back to form
                return Redirect::to('checklogin');
            }
        }
    }
}
