<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class StudentController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        $user->profile = $user->student()->first();

        return response()->json([
            'data' => $user,
        ], 200);
    }
}
