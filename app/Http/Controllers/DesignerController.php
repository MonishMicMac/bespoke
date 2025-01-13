<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index()
    {
        $designer = Designer::all()->where('action',0);
        return view('designers.index', ['designers' => $designer]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'designer_name' => 'required',
            'designer_title' => 'required',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate the image file
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
        $designer->save();
        return back();
    }
    public function edit($id)
    {
        $designeredit = Designer::where('id',$id)->first();
        return view('designers.edit', ['designeredits' => $designeredit]);
    }
    public function update(Request $request,$id){

        $designerupdate = Designer::where('id',$id)->first();

        $request->validate([
            'designer_name'=>'required',
            'img_path'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'designer_title'=>'required'
        ]);

        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('designerimages'), $imageName);
            $designerupdate->designer_image = $imageName; // Update the image path
        }

        $designerupdate->designer_name = $request->designer_name;
        $designerupdate->designer_title = $request->designer_title;
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
