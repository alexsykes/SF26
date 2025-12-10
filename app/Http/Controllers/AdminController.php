<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function suggestions(Request $request)
    {
        $user = \Auth::user();
        $username = $user->name;
        $email = $user->email;

        $suggestions = DB::table('suggestions')
            ->leftJoin('sites', 'sites.id', '=', 'suggestions.siteID')
            ->leftJoin('users', 'users.id', '=', 'suggestions.userID')
            ->where('completed', false)
            ->select('suggestions.*', 'sites.site_name', 'users.name', 'users.email')
            ->orderBy('created_at')
            ->get();
//dd($suggestions);
        return view('admin.suggestion_list', compact('suggestions'));
    }

    public function editSite(Request $request)
    {
//        $user = auth()->user();
        $siteID = $request->id;
        $site = DB::table('sites')
            ->where('id', $siteID)
            ->first();

        $suggestions = DB::table('suggestions')
            ->leftJoin('users', 'suggestions.userID', '=', 'users.id')
            ->where('siteID', $siteID)
            ->where('completed', false)
            ->select('suggestions.*', 'users.name')
            ->get();

        return view('site.edit', compact('site', 'suggestions'));
    }

    public function sitesToApprove()
    {
        $sites = DB::table('sites')
            ->where('published', false)
            ->get();

        return view('admin.sites_approve', compact('sites'));
    }
}
