<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    public function create(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required', // Ensure this matches the name attribute of your form field
        ];
        if($request->image!=""){
            $rules['image']= 'image';

        }

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back with input and errors
            return redirect()->route('admin.create')->withInput()->withErrors($validator);
        }

        // Create a new product instance
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->category = $request->category; // Make sure this field is present
        // Save the product to the database
        $product->save();
        if ($request->image!=""){
            $image = $request->image;
            $ext =  $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; //unique image name
            //save image to product directroy
            $image->move(public_path('uploads/products'),$imageName);
            $product->image = $imageName ;
            $product->save();
        }
        // Redirect to the dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Product has been added successfully');
    }
    public function edit($id, Request $request){
        $product = Product::findOrFail($id);

    // Define validation rules
    $rules = [
        'name' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
    ];

    if ($request->hasFile('image')) {
        $rules['image'] = 'image';
    }

    // Validate the request data
    $validator = Validator::make($request->all(), $rules);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->route('admin.edit', $product->id)->withInput()->withErrors($validator);
    }

    // Update product instance
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;

    if ($request->hasFile('image')) {
        // Delete old image
        File::delete(public_path('uploads/products/' . $product->image));

        // Save new image
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/products'), $imageName);
        $product->image = $imageName;
    }

    $product->category = $request->category;

    // Save the product to the database
    $product->save();

    // Redirect to the dashboard with a success message
    return redirect()->route('admin.dashboard')->with('success', 'Product has been updated successfully');
    }
    public function delete($id){
        $product = Product::findOrFail($id);
        File::delete(public_path('uploads/products/'.$product->image));
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success','product has been deleted successfully');
    }
}
