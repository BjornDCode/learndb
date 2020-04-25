<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required',
            'item_type' => 'required',
            'type' => 'required',
        ]);

        Auth::user()->activities()->create($data);

        return Redirect::back();
    }

}
