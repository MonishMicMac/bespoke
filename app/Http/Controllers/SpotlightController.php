<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Spotlight;
use App\Models\VendorLogin;
use Illuminate\Http\Request;

class SpotlightController extends Controller
{
    public function index()
    {

        $spotlight = Spotlight::all()->where('action', '0');
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('spotlight.index', ['spotlights' => $spotlight,'productdetails'=>$productdetails, 'vendordetails' => $vendordetails]);
    }
    public function store(Request $request)
    {

        // dd($request);
        // exit;
        // Validate the request
        $request->validate([
            'shop_id' => 'required',
            'shop_name' => 'required',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image file
            'price' => 'required|numeric',
            'title' => 'required',
            'brand_name' => 'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',
        ]);

        // Handle the image upload
        $imageName = null;
        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('spotlightimages'), $imageName);
        }

        // Create a new Spotlight instance and save the data
        $spotlight = new Spotlight();
        $spotlight->shop_id = $request->shop_id;
        $spotlight->shop_name = $request->shop_name;
        $spotlight->background_image = $imageName; // Save the uploaded image path
        $spotlight->price = $request->price;
        $spotlight->title = $request->title;
        $spotlight->brand_name = $request->brand_name;
        $spotlight->navigate = $request->navigate;
        $spotlight->searchfield_id = $request->searchfield_id;
        $spotlight->searchfield_text = $request->searchfield_text;
        $spotlight->save();

        // Return success response or redirect
        return redirect()->back()->with('success', 'Spotlight created successfully!');
    }
    public function edit($id)
    {
        $spotlightedit = Spotlight::where('id', $id)->first();
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('spotlight.edit', ['spotlightedit' => $spotlightedit,'productdetails'=>$productdetails, 'vendordetails' => $vendordetails]);
    }
    public function update(Request $request, $id)
    {
        $spotlightupdate = Spotlight::find($id);

        if (!$spotlightupdate) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        $request->validate([
            'shop_id' => 'required',
            'shop_name' => 'required',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required',
            'title' => 'required',
            'brand_name' => 'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',
        ]);

        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('spotlightimages'), $imageName);
            $spotlightupdate->background_image = $imageName; // Update the image path
        }

        $spotlightupdate->shop_id = $request->shop_id;
        $spotlightupdate->shop_name = $request->shop_name;
        $spotlightupdate->price = $request->price;
        $spotlightupdate->title = $request->title;
        $spotlightupdate->brand_name = $request->brand_name; // Corrected the property name
        $spotlightupdate->navigate = $request->navigate;
        $spotlightupdate->searchfield_id = $request->searchfield_id;
        $spotlightupdate->searchfield_text = $request->searchfield_text;
        $spotlightupdate->save();

        return redirect()->route('spotlight.create')->with('success', 'Spotlight updated successfully.');
    }
    public function destroy($id)
    {
        $spotlightdestroy = Spotlight::find($id);
        $spotlightdestroy->action = '1';
        $spotlightdestroy->save();
        return redirect()->route('spotlight.create')->with('success', 'Spotlight Deleted Successfully');

    }
}
