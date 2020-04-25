<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $input['student_id'] = $user->id;

        $location = Location::create($input);

        $response['success'] = true;

        return response()->json(
            $response,
            200
        );
    }
}
