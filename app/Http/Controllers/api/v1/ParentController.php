<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ParentController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        $user->profile = $user->studentParent()->first();

        return response()->json([
            'data' => $user,
        ], 200);
    }

    public function childData(Request $request)
    {
        $user = Auth::user();
        $parent = $user->studentParent()->first();
        $child_data = $parent->student()->first();

        return response()->json([
            'data' => $child_data,
        ], 200);
    }
}
