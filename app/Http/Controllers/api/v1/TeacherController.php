<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class TeacherController extends Controller
{
    public function profile(Request $request)
    {
        $userProfile = User::with('teacher')->find(Auth::id());

        return response()->json([
            'data' => $userProfile,
        ], 200);
    }
}
