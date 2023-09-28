<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 

class TokenController extends Controller
{
    public $successStatus = 200;

    public function create(Request $request)
    {
        $input = $request->only('email', 'password');
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ])->validate();

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('api-token')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
