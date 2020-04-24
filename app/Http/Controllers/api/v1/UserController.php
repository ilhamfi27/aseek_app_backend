<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\StudentParent;
use App\Student;
use App\Teacher;
use Illuminate\Support\Facades\DB;

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
        $rules = [
            'name' => 'required|regex:/^[a-zA-Z. ]*$/',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'level' => 'required',
        ];

        if ($input['level'] == 'wali') {
            // rules for wali
            $rules = array_merge($rules, [
                'address' => 'required',
                'phone_number' => 'required|numeric',
            ]);
        } else if ($input['level'] == 'siswa') {
            // rules for siswa
            $rules = array_merge($rules, [
                'address' => 'required',
                'phone_number' => 'required|numeric',
                'nis' => 'required|numeric',
            ]);
        } else if ($input['level'] == 'sekolah') {
            // rules for guru / sekolah
            $rules = array_merge($rules, [
                'position' => 'required',
                'nip' => 'required|numeric',
            ]);
        }

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $input['password'] = bcrypt($input['password']);
        DB::beginTransaction();
        try {
            $user = User::create($input);
            $input['user_id'] = $user->id;
    
            if ($input['level'] == 'wali') {
                // insert profile wali
                $studentAvailable = $this->checkStudentAvailability($input['student_id']);
                if (!$studentAvailable) {
                    return response()->json([
                        'error' => "Student don't available"
                    ], 400);
                } 
                StudentParent::create($input);
            } else if ($input['level'] == 'siswa') {
                // insert profile siswa
                Student::create($input);
            } else if ($input['level'] == 'sekolah') {
                // insert profile guru / sekolah
                Teacher::create($input);
            }
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollback();
        }

        $response['success'] = true;
        
        return response()->json($response, 200);
    }

    private function checkStudentAvailability($id)
    {
        $studentDontExist = Student::find($id) == null;
        if ($studentDontExist){
            return false;
        }
        
        $studentHasParent = StudentParent::where("student_id", $id)
                            ->count();
        if ($studentHasParent > 0){
            return false;
        }
        return true;
    }
}
