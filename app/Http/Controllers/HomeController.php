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


class HomeController extends Controller
{
    public function redirect()
    {
        $usertype=Auth::user()->usertype;

        if($usertype=='1')
        {   
            $total_product=product::all()->count();
            $total_order=order::all()->count();
            $total_user=user::all()->count();
            $order=order::all();
            $total_revenue=0;
            foreach ($order as $order)
            {
                $total_revenue=$total_revenue+$order->price;
            }
            $total_delivered=order::where('status','=','delivered')->get()->count();
            $total_notdelivered=order::where('status','=','not delivered')->get()->count();
            return view('admin.home',compact('total_product','total_order','total_user','total_revenue','total_delivered',('total_notdelivered')));
        }
        else
        {
            $data=product::paginate(3);

            $user=auth()->user();

            $count=cart::where('phone',$user->phone)->count();

            return view('user.home',compact('data','count'));
        }
    }

    public function index(){
        if (Auth::id())

        {
            return redirect('redirect');
        }
        else{

            $data=product::paginate(3);

            return view('user.home',compact('data'));
        }

        
    }

    public function search(Request $request)
        {
            $search=$request->search;
            if (Auth::id())

        {
            $user=auth()->user();

            $cart=cart::where('phone',$user->phone)->get();

            $count=cart::where('phone',$user->phone)->count();

            if($search==' ')
            {
                $data = product::paginate(3);
                return view('user.home',compact('data','count','cart'));
            }

            $data=product::where('title','Like','%'.$search.'%')->get();

            return view('user.home',compact('data','count','cart'));

        }


        

        if($search==' ')
        {
            $data = product::paginate(3);
            return view('user.home',compact('data'));
        }

        $data=product::where('title','Like','%'.$search.'%')->get();

        return view('user.home',compact('data'));
        
        }

    public function addcart(Request $request, $id)
    {
        if(Auth::id())
        {
            $user=auth()->user();
            $product=product::find($id);
            $cart=new cart;

            $cart->name=$user->name;
            $cart->phone=$user->phone;
            $cart->address=$user->address;
            $cart->product_title=$product->title;
            $cart->price=$product->price;
            $cart->quantity=$request->quantity;
            $cart->save();

            return redirect()->back()->with('message','Product Added Successfully');
        }
        else
        {
            return redirect('login');
        }
    }

    public function showcart()
    {
            $user=auth()->user();

            $cart=cart::where('phone',$user->phone)->get();

            $count=cart::where('phone',$user->phone)->count();

            return view('user.showcart',compact('count','cart'));
    }

    public function deletecart($id)
    {
        $data=cart::find($id);

        $data->delete();

        return redirect()->back()->with('message','Product Removed Successfully');
    }

    public function confirmorder(Request $request)
    {
        $user=auth()->user();

        $name=$user->name;
        $phone=$user->phone;
        $address=$user->address;

        if ($request->productname == null) { return redirect()->back()->with('message', 'First add something in CART'); }
        
        foreach($request->productname as $key=>$productname)
        {
            $order=new order;

            $order->product_name=$request->productname[$key];

            $order->price=$request->price[$key];

            $order->quantity=$request->quantity[$key];

            $order->name=$name;

            $order->phone=$phone;

            $order->address=$address;

            $order->status='not delivered';

            $order->save();
        }
        DB::table('carts')->where('phone',$phone)->delete();
        return redirect()->back()->with('message','Product Ordered Successfully');
    }

    public function cash_order()
    {
        $user=auth()->user();

        $userphone=$user->phone;

        $data=cart::where('phone','=',$userphone);

        foreach($data as $data)
        {
            $order= new order;

            $order->name=$data->name;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->product_name=$data->product_title;
            $order->status='not delivered';
            $order->save();

            $phone=$data->phone;
        }
        DB::table('carts')->where('phone',$phone)->delete();

    }

    public function aboutus()
    {

            if (Auth::id())

        {
            $user=auth()->user();

            $cart=cart::where('phone',$user->phone)->get();

            $count=cart::where('phone',$user->phone)->count();

            return view('user.aboutus',compact('count','cart'));
        }
        else{

            return view('user.aboutus');
        }
    }

    public function stripe($totalprice)
    {
        return view('user.stripe',compact('totalprice'));
    }

    public function stripePost(Request $request,$totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice*100,
                "currency" => "PKR",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment." 
        ]);
        
        $user=auth()->user();

        $userphone=$user->phone;

        $data=cart::where('phone','=',$userphone)->get();

        foreach($data as $data)
        {
            $order= new order;

            $order->name=$data->name;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->product_name=$data->product_title;
            $order->status='not delivered';
            $order->save();

            $phone=$data->phone;
            DB::table('carts')->where('phone',$phone)->delete();
           
        }
        

        Session::flash('success', 'Payment successful!');
              
        return back();
    }

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
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'message'=>$request->message,
            ];

            Mail::to('gondalbilal082@gmail.com')->send(new ContactMail($details));
            return back()->with('message_sent','Your message has been sent successfully!');
        }
    




    }

    



