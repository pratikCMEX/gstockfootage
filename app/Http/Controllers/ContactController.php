<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $title = 'Home';
        $page = 'sasa';
        $js = ['home'];

        return view('front.contact_us', compact('title', 'page', 'js'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'    => 'required|string|max:255',
                'email'   => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string'
            ]);

            DB::beginTransaction();

            $contact = ContactMessage::create([
                'name'    => $request->name,
                'email'   => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            Mail::to(env('OWNER_MAIL'))
                ->send(new ContactMessageMail($contact));

            DB::commit();
            return back()->with('msg_success', 'Message sent successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('msg_error', 'Something went wrong!');
        }
    }
}
