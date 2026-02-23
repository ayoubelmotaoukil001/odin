<?php

namespace App\Http\Controllers;

use App\Events\LinkCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Link;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StoreLinkRequest ;
use App\Events\LinkActionEvent ;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $links = Link::with('category', 'tags', 'user')->get();
        } else {
            
            $links = Link::where('user_id', Auth::id())
                        ->with('category', 'tags')
                        ->get();
        }

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

public function store(StoreLinkRequest $request) 
{

   $link = Link::create([
        'title' => $request->title,
        'url' => $request->url,
        'category_id' => $request->category_id,
        'user_id' => Auth::id() ,
    ]);
    event( new LinkCreated($link)) ;

    return redirect()->route('links.index')->with('success', 'link addes suucesfuly');
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
        public function destroy(Link $link)
    {
        $this->authorize('delete', $link);

        
        event(new \App\Events\LinkActionEvent(Auth::user(), $link, 'deleted'));

        $link->delete();
        return redirect()->route('links.index')->with('success', 'Link moved to trash.');
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

        public function trash()
    {
        $links = Link::onlyTrashed()
                    ->where('user_id', Auth::id())
                    ->get();
                    
        return view('links.trash', compact('links'));
    }


        public function restore($id)
    {
        $link = Link::withTrashed()->findOrFail($id);
        $this->authorize('restore', $link);

        $link->restore();

        return redirect()->route('links.index')->with('success', 'Link restored successfully.');
    }

        public function forceDelete($id)
    {
        $link = Link::withTrashed()->findOrFail($id);

        
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $link->forceDelete(); 

        return redirect()->route('links.trash')->with('success', 'Link deleted permanently.');
    }
        public function toggleFavorite(\App\Models\Link $link)
    {
        
        auth()->user()->favoriteLinks()->toggle($link->id);

        return back()->with('success', 'Favorites updated!');
    }
    public function favorites()
    {
    
        $links = auth()->user()->favoriteLinks()->with('category', 'tags')->latest()->get();
        
        
        return view('links.index', compact('links'));
    }


}
