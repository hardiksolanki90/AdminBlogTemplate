<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //list
        $category = Category::paginate(15);

        return view('admin.postCategory.list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.postCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation
        $validation = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        //store
        $category = Category::create([
            'name' => $validation['name'],
            'slug' => $validation['slug'],
            'description' => $validation['description'],
            'meta_title' => $validation['meta_title'],
            'meta_description' => $validation['meta_description'],
            'status' => $validation['status'],
        ]);

        return redirect()->route('admin.postCategory.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.postCategory.index')->with('error', 'Post category not found');
        }
        return view('admin.postCategory.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = Category::find($id);
        
        if (!$category) {
            return redirect()->route('admin.postCategory.index')->with('error', 'Post category not found');
        }
        return view('admin.postCategory.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.postCategory.index')->with('error', 'Post category not found');
        }
        $validation = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
        
        $category->update([
            'name' => $validation['name'],
            'slug' => $validation['slug'],
            'description' => $validation['description'],
            'meta_title' => $validation['meta_title'],
            'meta_description' => $validation['meta_description'],
            'status' => $validation['status'],
        ]);

        return redirect()->route('admin.postCategory.index')->with('success', 'Post category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.postCategory.index')->with('error', 'Post category not found');
        }
        $category->delete();
        return redirect()->route('admin.postCategory.index')->with('success', 'Post category deleted successfully');
    }
}
