<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Signalling;
use App\Models\User;

class CallController extends Controller
{
    public function home()
    {
        return view('calls.home');
    }

    public function signallingStart(Request $request)
    {
        // dd($request->all());

        broadcast(new Signalling($request->all()))->toOthers();

        // return back();
    }
}
