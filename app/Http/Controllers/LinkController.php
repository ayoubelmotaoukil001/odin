<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Link;
use App\Models\Category;
use App\Models\Tag;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $links = Link::with('category', 'tags')->get();
        return view('links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $categories = Category::all();
        $tags = Tag::all();
        return view('links.create', compact('categories', 'tags'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'url' => 'required|url',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id',
    ]);

    $link = Link::create([
        'title' => $request->title,
        'url' => $request->url,
        'user_id' => Auth::id(),
    ]);

    if ($request->has('tags')) {
        $link->tags()->attach($request->tags);
    }

    return redirect()->route('links.index')->with('success', 'Link created successfully');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $link = Link::with('category', 'tags')->findOrFail($id);
        return view('links.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $link = Link::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('links.edit', compact('link', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $link = Link::findOrFail($id);
        $link->update([
            'title' => $request->title,
            'url' => $request->url,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tags')) {
            $link->tags()->sync($request->tags);
        } else {
            $link->tags()->detach();
        }

        return redirect()->route('links.index')->with('success', 'Link updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $link = Link::findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', 'Link deleted successfully');
    }

    public function attachTag(Request $request, Link $link)
{
    $request->validate([
        'tag_id' => 'required|exists:tags,id',
    ]);

    
    $link->tags()->syncWithoutDetaching([$request->tag_id]);

    return redirect()->route('links.show', $link->id)
                     ->with('success', 'Tag assigned to link successfully!');
}

}
