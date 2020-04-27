<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Student;

class StudentController extends Controller
{
    public function location(Request $request)
    {
        $user = Auth::user();
        $student_id = $request->id_siswa;

        if ($user->level == "wali") {
            $parent = $user->studentParent()->first();
            $childData = $parent->student()->first();
            $lastLocation = $childData->location()->get()->last();
        } else if ($user->level == "sekolah") {
            if (!$student_id) {
                return response()->json([
                    'error' => 'Bad Request'
                ], 400);
            }
            $student = Student::find($student_id);
            $lastLocation = $student->location()->get()->last();
        } else {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return response()->json($lastLocation, 200);
    }

    public function locationHistory(Request $request)
    {
        $user = Auth::user();
        $student_id = $request->id_siswa;

        if ($user->level == "wali") {
            $parent = $user->studentParent()->first();
            $childData = $parent->student()->first();
            $locationHistory = $childData->location()->get();
        } else if ($user->level == "sekolah") {
            if (!$student_id) {
                return response()->json([
                    'error' => 'Bad Request'
                ], 400);
            }
            $student = Student::find($student_id);
            $locationHistory = $student->location()->get();
        } else {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return response()->json($locationHistory, 200);
    }
}
