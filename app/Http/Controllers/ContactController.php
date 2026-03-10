<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Mail\QuoteMail;
use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $title = 'Contact Us';
        $page = 'front.contact_us';
        $js = ['contact_us'];

        return view('layouts.front.layout', compact('title', 'page', 'js'));
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

    public function Quote(Request $request)
    {
        $title = 'Home';
        $page = 'sasa';
        $js = ['contact_us'];
      
        return view('front.quote', compact('title', 'page', 'js'));
    }

    public function quoteStore(Request $request)
    {
        try {
            $request->validate([
                'first_name'        => 'required|string',
                'last_name'         => 'required|string',
                'phone'             => 'required|string',
                'email'             => 'required|email',
                'company'           => 'required|string',
                'job_role'          => 'required|string',
                'job_function'      => 'required|string',
                'company_size'      => 'required|string',
                'country'           => 'required|string',
                // 'state'             => 'required|string',
                'product_interest'  => 'required|string',
            ]);

            DB::beginTransaction();

            $quote = QuoteRequest::create([
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'company'           => $request->company,
                'job_role'          => $request->job_role,
                'job_function'      => $request->job_function,
                'company_size'      => $request->company_size,
                'country'           => $request->country,
                'state'             => $request->state,
                'product_interest'  => $request->product_interest,
                'newsletter'        => $request->has('newsletter') ? '1' : '0',
            ]);


            Mail::to(env('OWNER_MAIL'))
                ->send(new QuoteMail($quote));

            DB::commit();
            return back()->with('msg_success', 'Quote request submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('msg_error', $e->getMessage());
        }
    }
}
