<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Link ;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories= Category::all() ;
        return view('categories.index' , compact('categories')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create') ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'name'=>'required|string|max:255' 
        ]);

        Category::create([
            'name'=>$request->name ,
             'user_id' => Auth::id() ,
        ]) ;
        return redirect()->route('categories.index')->with("succes" , "category created with succes") ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id) ;
        return view('categories.show' , compact('category')) ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=Category::findOrFail($id) ;
        return view('categories.edit' , compact('category')) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            'name'=>'required|string|max:255' ,
        ]) ;
        $category = Category::findOrFail($id) ; 
        $category->update([
            'name'=>$request->name ,
        ]) ;
        return redirect()->route('categories.index')->with("succes" ,"category updated with succes ") ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id)  ;
        $category->delete() ;

        return redirect()->route('categories.index')->with("succes" , "categorie deleted with succes") ;
    }
    public function attachLink(Request $request, Category $category)
{
    $request->validate([
        'link_id' => 'required|exists:links,id',
    ]);

    $link = Link::findOrFail($request->link_id);
    $link->category_id = $category->id;
    $link->save();

    return redirect()->route('categories.show', $category->id)
                     ->with('success', 'Link assigned to category successfully!');
}

}
