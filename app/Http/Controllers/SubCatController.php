<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Storage;

class SubCatController extends Controller
{

    public function index()
    {
        $categories = Category::where('action', '0')->get(); // Only active categories
        $subcategories = Subcategory::with('category')->where('action', '0')->get(); // Only active subcategories


        return view('subCategory.index', compact('subcategories', 'categories'));
    }

    // Store a new subcategory
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name', // Ensure name is unique in subcategories
            'category_id' => 'required|exists:categories,id', // Ensure category exists in the database
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Validate image file (supports PNG, JPG, JPEG)
        ]);


        // Handle the image upload
        $imgPath = null;
        if ($request->hasFile('img_path')) {
            // Store the image and get its path
            $imgPath = $request->file('img_path')->store('subcategories', 'public');
        }

        // Create the subcategory with the image path (if provided)
        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'img_path' => $imgPath, // Store the image path
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory added successfully.');
    }


    // Edit a subcategory
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('action', '0')->get(); // Only active categories
        return view('subCategory.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        // Validate input
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories')->ignore($subcategory->id), // Ignore current subcategory's name
            ], // Ensure name is unique in subcategories, except for the current one
            'category_id' => 'required|exists:categories,id', // Ensure category exists in the database
            'img_path' => 'nullable|image|mimes:png|max:2048', // Validate image file (supports PNG, JPG, JPEG)
        ]);

        // Handle image upload if a new file is provided
        if ($request->hasFile('img_path')) {
            // Delete the old image if exists
            if ($subcategory->img_path) {
                Storage::delete('public/' . $subcategory->img_path); // Remove the old file
            }

            // Store the new image in the 'public' directory
            $imgPath = $request->file('img_path')->store('subcategories', 'public'); // Store in 'public/subcategories'

            // Update the image path in the database to be relative to the public storage
            $subcategory->img_path = $imgPath;
        }

        // Update the subcategory with new data (including img_path if changed)
        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'img_path' => $subcategory->img_path, // Ensure img_path is updated if a new image was uploaded
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }


    // Soft delete a subcategory (update action to 1)
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->action = '1'; // Mark as deleted
        $subcategory->save();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }


}
