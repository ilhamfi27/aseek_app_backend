<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();

        $location = Location::create($input);

        $response['success'] = true;

        return response()->json(
            $response,
            200
        );
    }
}
