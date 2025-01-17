<?php

namespace App\Http\Controllers;

use App\Models\AppBanner;
use App\Models\Product;
use App\Models\VendorLogin;
use Illuminate\Http\Request;

class AppBannerController extends Controller
{

    public function create()
    {

        $banners = AppBanner::where('action', '0')->get(); // Get only banners where action is 0
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('appBanner.index', compact('banners', 'productdetails', 'vendordetails'));
    }




    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'type' => 'required|string',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',

        ]);

        // Check if there are already 5 banners with action = 0
        $bannerCount = AppBanner::where('action', '0')->count();

        // If there are already 5 banners with action = 0, prevent further uploads
        if ($bannerCount >= 5) {
            return redirect()->route('banners.create')->with('error', 'You can only upload 5 banners');
        }
        // dd($request->searchfield_id);

        // Upload image if there's a file
        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('app_banners', 'public');
        }

        // Store the banner with action set to 0 by default
        AppBanner::create([
            'img_path' => $imagePath,
            'type' => $request->type,
            'navigate' => $request->navigate,
            'searchfield_id' => $request->searchfield_id,
            'searchfield_text' => $request->searchfield_text,
            'action' => '0', // Always inactive by default
        ]);

        return redirect()->route('banners.create')->with('success', 'Banner created successfully.');
    }


    public function edit($id)
    {
        $banner = AppBanner::findOrFail($id); // Fetch the banner to edit
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('appBanner.edit', compact('banner', 'productdetails', 'vendordetails')); // Adjust view name as needed
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|string',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',
        ]);

        $banner = AppBanner::findOrFail($id);

        // Update the image if a new one is uploaded
        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('app_banners', 'public');
            $banner->img_path = $imagePath;

        }

        // Update the banner details
        $banner->type = $request->type;
        $banner->navigate = $request->navigate;
        $banner->searchfield_id = $request->searchfield_id;
        $banner->searchfield_text = $request->searchfield_text;
        $banner->save();

        return redirect()->route('banners.create')->with('success', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = AppBanner::findOrFail($id);

        // Instead of deleting, change action to 1
        $banner->action = '1';
        $banner->save();

        return redirect()->route('banners.create')->with('success', 'Banner removed successfully.');
    }

}
