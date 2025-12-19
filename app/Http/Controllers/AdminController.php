<?php

namespace App\Http\Controllers;

use App\Mail\WebContact;
use App\Rules\ReCaptchaV3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

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

//        dd($sites);
        return view('admin.sites_approve', compact('sites'));
    }

    public function contact(Request $request)
    {
        return view('admin.contact');
    }

    public function sendMail(Request $request)
    {

        $request->validate([
                'sender' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'g-recaptcha-response' => ['required', new ReCaptchaV3('sendMail')],
            ]
        );

        $from = $request->sender;
        $at = $request->email;
        $content = $request->message;

        if (isset($request->copy_sender)) {
            Mail::to($at)
                ->send(new WebContact($from, $at, $content));
            info("Mail copied to $from at $at");
        }

        $adminAddress = "slopefinder@alexsykes.net";
        $bcc = "info@slopefinder.uk";
        Mail::to($adminAddress)
            ->send(new WebContact($from, $at, $content));
        info("Contact mail from $from at $at");

//        dd($request->all());
        if (Auth::check()) {
            return view('admin.sent');
        } else {
            return view('public.sent');
        }
    }
}
