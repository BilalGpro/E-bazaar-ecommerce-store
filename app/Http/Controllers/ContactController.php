<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\User;

use App\Models\cart;

use App\Models\product;

use App\Models\order;

use App\Mail\ContactMail;

use Session;
use Stripe;
use Mail;
class ContactController extends Controller
{
    public function contact()
    {

            if (Auth::id())

        {
            $user=auth()->user();

            $cart=cart::where('phone',$user->phone)->get();

            $count=cart::where('phone',$user->phone)->count();

            return view('user.contact',compact('count','cart'));
        }
        else{

            return view('user.contact');
        }
    }

        public function sendMail(Request $request)
        {
            $details=[
            'name'->$request->name,
            'email'->$request->email,
            'subject'->$request->subject,
            'message'->$request->message,
            ];

            Mail::to('gondalbilal082@gmail.com')->send(new ContactMail($details));
            return back()->with('message_sent','Your message has been sent successfully!');
        }
}
