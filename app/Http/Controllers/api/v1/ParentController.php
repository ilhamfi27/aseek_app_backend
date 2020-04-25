<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ParentController extends Controller
{
    public function childData(Request $request)
    {
        $user = Auth::user();
        
        if ($user->level != "wali") {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $parent = $user->studentParent()->first();
        $childData = $parent->student()->first();

        return response()->json($childData, 200);
    }

    public function childLocation(Request $request)
    {
        $user = Auth::user();
        
        if ($user->level != "wali") {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
        
        $parent = $user->studentParent()->first();
        $childData = $parent->student()->first();
        $lastLocation = $childData->location()->get();

        return response()->json($lastLocation, 200);
    }
}
