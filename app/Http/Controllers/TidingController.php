<?php

namespace App\Http\Controllers;

use App\Models\Tiding;

class TidingController extends Controller
{
    public function index()
    {
        $tidings = Tiding::paginate(30);
        return view('tidings.index', compact('tidings'));
    }

    public function deleteAll()
    {
        Tiding::truncate();
        return redirect()->back();
    }
}
