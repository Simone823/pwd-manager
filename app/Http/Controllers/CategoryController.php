<?php

namespace App\Http\Controllers;

use App\Category;
use App\LogActivity;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasPermission('categories-view')) {
            abort(401);
        }

        // recupero le categorie
        $categories = Category::sortable(['category_name' => 'asc'])->paginate(config('app.default_paginate'));

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermission('categories-create')) {
            abort(401);
        }

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermission('categories-create')) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'category_name' => 'required|string|regex:/^[\pL\s]+$/u|min:3|max:200|unique:categories,category_name'
        ]);

        // creo la nuova categoria
        $newCategory = new Category();
        $newCategory->category_name = ucfirst($request->category_name);
        $newCategory->save();

        // aggiungo il log attività
        LogActivity::addLog("Creato Categoria: {$newCategory->category_name}");

        return redirect()->route('categories.index')->with('success', "La Categoria con nome: {$newCategory->category_name} è stata creata.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermission('categories-edit')) {
            abort(401);
        }

        // recupero la categoria
        $category = Category::findOrFail($id);
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->hasPermission('categories-edit')) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'category_name' => 'required|string|regex:/^[\pL\s]+$/u|min:3|max:200|unique:categories,category_name,'.$id
        ]);

        // aggiorno la categoria
        $category = Category::findOrFail($id);
        $category->category_name = ucfirst($request->category_name);
        $category->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificato Categoria: {$category->category_name}");

        return redirect()->route('categories.index')->with('success', "La Categoria con nome: $category->category_name è stata modificata.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermission('categories-delete')) {
            abort(401);
        }

        // elimino la categoria
        $category = Category::findOrFail($id);
        $category->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminato Categoria: {$category->category_name}");

        return redirect()->route('categories.index')->with('success', "La Categoria con nome: {$category->category_name} è stata eliminata.");
    }

    /**
     * Elimina record selezionati
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request)
    {
        if(!Auth::user()->hasPermission('categories-delete')) {
            abort(401);
        }

        // controllo se esiste almeno un id
        if(count($request->idsRecord) == 0) {
            return response()->json([
                'status' => 400,
                'message' => 'There are no selected record ids'
            ], 400);
        }
        
        // elimino tutt i record aventi gli id della request
        $categories = Category::whereIn('id', $request->idsRecord)->get();
        $categories->each->delete();
        
        // Aggiungo il log attività
        foreach ($categories as $category) {
            LogActivity::addLog("Eliminato Categoria: {$category->category_name}");
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Selected Categories have been deleted.'
        ], 200);
    }
}