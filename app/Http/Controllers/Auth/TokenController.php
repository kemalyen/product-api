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

    /**
     * Get access token for a user
     * 
     * @group Authentication
     * 
     * @response 200  {
     * {
     *   "success": {
     *      "token": "{YOUR_AUTH_KEY}"
     * }
     *}
     */
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
<<<<<<< HEAD
            if ($user->hasRole('Account Api User') || $user->hasRole('Admin')) {
=======
            if ($user->hasRole('Account Api User')) {
>>>>>>> a104ec760aa1fcb589b73ca9016cc8ab20ad3664
                $success['token'] = $user->createToken('api-token')->plainTextToken;
                return response()->json(['success' => $success], $this->successStatus);
            }
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        return response()->json(['error' => 'Your credentials are wrong!'], 401);
    }
}
