<?php

namespace App\Http\Controllers;

use App\Models\Site;

class SiteController extends Controller
{
    public function index($id)
    {
        $site = Site::where('id', $id)->first();
        return view('site.detail', compact('site'));
    }
}
