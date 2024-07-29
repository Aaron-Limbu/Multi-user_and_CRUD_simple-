<?php

namespace App\Http\Controllers\admin;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class DashboardController extends Controller
{
    public function index(){
        $products = Product::orderBy('created_at','ASC')->get();
        return view('admin.dashboard',[
            'products'=>$products
        ]);
    }
    public function Add(){
        return view('admin.create');
    }
    public function update($id){
        $product = Product::findOrFail($id);
        return view('admin.edit',[
            'product'=>$product
        ]);
    }

}
