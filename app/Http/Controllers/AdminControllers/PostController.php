<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // post list
        $posts = Post::paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation
        $validation = $request->validate([
            'title' => 'required|string',
            'author_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:categories,id',
            'slug' => 'required|string',
            'content' => 'nullable',
            'is_published' => 'required|boolean',
            'posted_date' => 'required|date',
            'poster_image' => 'nullable|image',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);
        //store

        $post = Post::create([
            'title' => $validation['title'],
            'author_id' => $validation['author_id'],
            'category_id' => $validation['category_id'],
            'slug' => $validation['slug'],
            'content' => $validation['content'],
            'is_published' => $request->has('is_published'),
            'posted_date' => $validation['posted_date'],
            'meta_title' => $validation['meta_title'],
            'meta_description' => $validation['meta_description'],
        ]);


        if ($request->hasFile('poster_image')) {
            $post->storeMedia($request->file('poster_image'));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::find($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validation
        $validation = $request->validate([
            'title' => 'required|string',
            'author_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:categories,id',
            'slug' => 'required|string',
            'content' => 'nullable',
            'is_published' => 'required|boolean',
            'posted_date' => 'required|date',
            'poster_image' => 'nullable|image',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);
        
        //Update
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Post not found');
        }

        $post->update([
            'title' => $validation['title'],
            'author_id' => $validation['author_id'],
            'category_id' => $validation['category_id'],
            'slug' => $validation['slug'],
            'content' => $validation['content'],
            'is_published' => $request->has('is_published'),
            'posted_date' => $validation['posted_date'],
            'meta_title' => $validation['meta_title'],
            'meta_description' => $validation['meta_description'],
        ]);


        if ($request->hasFile('poster_image')) {
            $post->deleteMedia($post->poster_image);
            $post->storeMedia($request->file('poster_image'));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Post not found');
        }
        $post->delete();
        
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
