<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Storage;
use Validator;

class CategoryController extends Controller
{
    // Updated Route Definitions
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'img_path' => 'nullable|image|mimes:png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imgPath = null;
        if ($request->hasFile('img_path')) {
            $imgPath = $request->file('img_path')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'action' => $request->input('action', '0'),
            'img_path' => $imgPath,
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function index()
    {
        $categories = Category::where('action', '0')->get();
        return view('admin.category', compact('categories'));
    }

    public function edit($id)
    {
        // Retrieve the category by its ID where action is 0
        $category = Category::where('action', '0')->find($id);

        // Check if the category exists
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found or already deleted.');
        }

        // dd($category);
        return view('admin.editCategory', compact('category'));
    }


    public function update(Request $request, Category $category, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'img_path' => 'nullable|image|mimes:png|max:2048',
        ]);

        $category = Category::where('action', '0')->find($id);


        if ($request->hasFile('img_path')) {
            if ($category->img_path) {
                Storage::delete('public/' . $category->img_path);
            }
            $path = $request->file('img_path')->store('categories', 'public');
            $category->img_path = $path;
        }


        $category->update([
            'name' => $request->name,
            'img_path' => $category->img_path,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        // Find the category by ID
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Set the category's action to '1' (mark as inactive/deleted)
        $category->action = '1';
        $category->save();  // Save the updated model

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    

}
