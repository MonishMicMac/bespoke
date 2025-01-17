<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Product;
use App\Models\VendorLogin;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index()
    {
        $designer = Designer::all()->where('action',0);
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('designers.index', ['designers' => $designer,'productdetails' => $productdetails,'vendordetails' => $vendordetails]);
    }
    public function store(Request $request)
    {
// dd($request);

        $request->validate([
            'designer_name' => 'required',
            'designer_title' => 'required',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image file
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',

        ]);

        // Handle the image upload
        $imageName = null;
        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('designerimages'), $imageName);
        }

        $designer = new Designer();
        $designer->designer_name = $request->designer_name;
        $designer->designer_image = $imageName;
        $designer->designer_title = $request->designer_title;
        $designer->navigate = $request->navigate;
        $designer->searchfield_id = $request->searchfield_id;
        $designer->searchfield_text = $request->searchfield_text;
        $designer->save();
        return back();
    }
    public function edit($id)
    {
        $designeredit = Designer::where('id',$id)->first();
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('designers.edit', ['designeredits' => $designeredit ,'productdetails' => $productdetails,'vendordetails' => $vendordetails]);
    }
    public function update(Request $request,$id){

        $designerupdate = Designer::where('id',$id)->first();
// dd($request);
        $request->validate([
            'designer_name'=>'required',
            'img_path'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'designer_title'=>'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',

        ]);

        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('designerimages'), $imageName);
            $designerupdate->designer_image = $imageName; // Update the image path
        }

        $designerupdate->designer_name = $request->designer_name;
        $designerupdate->designer_title = $request->designer_title;
        $designerupdate->navigate = $request->navigate;
        $designerupdate->searchfield_id = $request->searchfield_id;
        $designerupdate->searchfield_text = $request->searchfield_text;
        $designerupdate->save();
        return redirect()->route('designer.create');



    }
    public function delete($id){
        $designerdelete = Designer::where('id',$id)->first();
        $designerdelete->action = '1';
        $designerdelete->save();
        return back();
    }

}
