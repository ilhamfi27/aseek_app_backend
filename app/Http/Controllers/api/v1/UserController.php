<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user_credentials = $request->post('user_credentials');
        $password = $request->post('password');

        if (filter_var($user_credentials, FILTER_VALIDATE_EMAIL)) {
            //user sent their email 
            Auth::attempt(['email' => $user_credentials, 'password' => $password]);
        } else {
            //they sent their username instead 
            Auth::attempt(['username' => $user_credentials, 'password' => $password]);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $response['token'] = $user->createToken('userLogin')->accessToken;
            $response['success'] = true;
            $response['user_id'] = $user->id;
            $response['username'] = $user->username;
            $response['email'] = $user->email;
            $response['level'] = $user->level;

            return response()->json(
                $response,
                200
            );
        } else {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
    }
    
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $response['success'] = true;
        $response['user_id'] = $user->id;
        $response['username'] = $user->username;
        $response['email'] = $user->email;
        $response['level'] = $user->level;
        
        return response()->json($response, 200);
    }
}
