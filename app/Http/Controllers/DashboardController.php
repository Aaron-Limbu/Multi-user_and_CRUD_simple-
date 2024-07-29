<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //show dashboard page for user
    public function index(){
        $products = Product::orderBy('created_at','ASC')->get();
        $user_id = Auth::id();
        return view('dashboard',['products'=>$products,'user'=>$user_id]);
    }
    public function buy($id,Request $request){
        $product = Product::findOrFail($id);
        $user = Auth::user();
        $rules = ['quantity' => 'required|integer'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('account.dashboard')->withInput()->with('error', 'Enter a proper value');
        } else {
            $order = new Order();
            $order->username_id = $user->id;
            $order->username = $user->name;
            $order->product_id = $product->id;
            $order->product_name = $product->name;
            $order->price = $product->price;
            $order->item_count = $request->quantity;
            $order->total_price = $request->quantity * $product->price;
            $order->save();
            return redirect()->route('account.dashboard')->with('success', 'You have successfully bought ' . $product->name);
        }
    }
    public function order(){
        $orders = Order::orderBy('created_at','ASC')->get();
        return view('order',['orders'=>$orders]);
    }
    public function cancel($id){
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('account.orders')->with('success','product has been successfully removed');
    }
}
