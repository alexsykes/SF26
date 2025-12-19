<?php

namespace App\Http\Controllers;

use App\Mail\BulkMail;
use App\Models\Clubmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;

class ClubmailController extends Controller
{
    public function index()
    {
        $clubmails = Clubmail::all()
            ->sortByDesc('created_at');
        return view('/clubmails/list', compact('clubmails'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $user = \Auth::user();
        $updated_by = $user->id;
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'replyToName' => ['required', 'string', 'max:255'],
            'replyToAddress' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $data['updated_by'] = $updated_by;
//        dd($data);
        Clubmail::create($data);

        return redirect('/clubmails');
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
                return redirect('/mail/edit/' . $request->id);

                break;
            case 'prepare':
                $this->saveMail($request);
                $clubmail = Clubmail::find($request->id);
                $user = \Auth::user();
                return view('clubmails.prepare', compact('clubmail', 'user'));
                break;
        }
    }

    private function saveMail(Request $request)
    {
        $clubmail = Clubmail::find($request->id);
        $user = \Auth::user();
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
        $user = \Auth::user();
        $replyToName = $user->name;
        $replyToAddress = $user->email;

        return view('clubmails.compose', compact('replyToAddress', 'replyToName'));
    }

    public function sendMail(Request $request)
    {
        $clubmail = Clubmail::find($request->id);

//        dd($clubmail);
        $distribution = $request->distribution;
        switch ($distribution) {
            case 'test':
//                dd($clubmail);
                $address = 'alex@alexsykes.net';
                $address = 'alexs130151@gmail.com';
                $replyToAddress = $clubmail->replyToAddress;
                $replyToName = $clubmail->replyToName;
                $name = 'alex';
                Mail::to($address)
                    ->send(new BulkMail($clubmail, $name));
                info("Bulk mail sent to $address!");
                break;
            case 'users':

                $address = 'alexjeddah@icloud.com';
                break;
            default:
                throw new \Exception('Unexpected value');
        }

        return redirect('/clubmails');
    }
}
