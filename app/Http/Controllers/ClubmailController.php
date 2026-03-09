<?php

namespace App\Http\Controllers;

use App\Mail\BulkMail;
use App\Models\Clubmail;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClubmailController extends Controller
{
    public function index()
    {
        $clubmails = Clubmail::all()
            ->sortByDesc('created_at');

        return view('.clubmails.index', compact('clubmails'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $updated_by = $user->id;
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'replyToName' => ['required', 'string', 'max:255'],
            'replyToAddress' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        Clubmail::create($data);

        return redirect('/mails');
    }

    public function show(Clubmail $clubmail)
    {
        return $clubmail;
    }

    public function edit($id)
    {
        $mail = Clubmail::find($id);

        return view('clubmails.edit', compact('mail'));
    }

    public function update(Request $request)
    {
        switch ($request->input('action')) {
            case 'save':
                $this->saveMail($request);

                return redirect('/mails');

                break;
            case 'prepare':
                $this->saveMail($request);
                $clubmail = Clubmail::find($request->id);
                $user = Auth::user();

                return view('clubmails.prepare', compact('clubmail', 'user'));
                break;
        }
    }

    private function saveMail(Request $request)
    {
        $clubmail = Clubmail::find($request->id);
        $user = Auth::user();
        $updated_by = $user->id;
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'replyToName' => ['required', 'string', 'max:255'],
            'replyToAddress' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $data['updated_by'] = $updated_by;
        $clubmail->update($data);
    }

    public function destroy(Clubmail $clubmail)
    {
        $clubmail->delete();

        return response()->json();
    }

    public function compose()
    {
        $user = Auth::user();
        $replyToName = $user->name;
        $replyToAddress = $user->email;

        return view('clubmails.compose', compact('replyToAddress', 'replyToName'));
    }

    public function sendMail(Request $request)
    {
        $clubmail = Clubmail::find($request->id);

        $replyToAddress = $clubmail->replyToAddress;
        $replyToName = $clubmail->replyToName;

        $distribution = $request->distribution;

        switch ($distribution) {
            case 'test':
                $address = 'alex@alexsykes.net';
                $address = 'alexs130151@gmail.com';
                $sendToName = 'alex';
                Mail::to($address)
                    ->send(new BulkMail($clubmail, $sendToName, $replyToAddress, $replyToName));
                info("Bulk mail sent to $address!");
                break;
            case 'users':
                $userList = DB::table('users')->where('email_optout', false)
                    ->select('name', 'email')
                    ->get();

                $delay = 1;
                foreach ($userList as $user) {
                    $sendToName = $user->name;
                    $sendToEmail = $user->email;

                    Mail::to(new Address($sendToEmail, $sendToName))
                        ->later(now()->addSeconds($delay++),
                            new BulkMail($clubmail, $sendToName, $replyToAddress, $replyToName));
                    info($sendToEmail);
                }
                break;
            default:
                throw new Exception('Unexpected value');
        }

        return redirect('/mails');
    }
}
