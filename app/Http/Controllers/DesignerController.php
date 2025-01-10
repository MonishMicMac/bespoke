<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index()
    {
        $designer = Designer::all();
        return view('designers.index', ['designers' => $designer]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'designer_name' => 'required',
            'designer_title' => 'required',
            'designer_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate the image file
        ]);

        if ($request->hasFile($request->designer_image)) {
            $imageName = time() . '.' . $request->designer_image->extension();
            $request->designer_image->move(public_path('designerimages'), $imageName);
        }

        $designer = new Designer();
        $designer->designer_name = $request->designer_name;
        $designer->designer_image = $imageName;
        $designer->title = $request->designer_title;
        $designer->save();
        return back();
    }

}
