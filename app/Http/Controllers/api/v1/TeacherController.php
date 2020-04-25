<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Student;

class TeacherController extends Controller
{
    public function showAllStudents(Request $request)
    {
        $user = Auth::user();
        
        if ($user->level != "sekolah") {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $students = Student::all();
        
        return response()->json($students, 200);
    }
}
