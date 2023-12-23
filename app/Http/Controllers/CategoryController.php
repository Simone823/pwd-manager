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
            abort(403);
        }

        // aggiungo il log attività
        LogActivity::addLog("Lista Categorie");

        // recupero tutte le categorie dal db
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
            abort(403);
        }

        // aggiungo il log attività
        LogActivity::addLog("Creazione Categoria");

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
            abort(403);
        }

        // validazione request
        $request->validate([
            'category_name' => 'required|string|alpha|min:3|max:200|unique:categories,category_name'
        ]);

        // data request all
        $data = $request->all();

        // creo nuova istanza Category
        $newCategory = new Category();

        // setto i valori
        $newCategory->category_name = ucfirst($data['category_name']);

        // save
        $newCategory->save();

        // aggiungo il log attività
        LogActivity::addLog("Creata Categoria {$newCategory->category_name}");

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
            abort(403);
        }

        // recupero la categoria by id
        $category = Category::find($id);
        
        // aggiungo il log attività
        LogActivity::addLog("Modifica Categoria {$category->category_name}");
        
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
            abort(403);
        }

        // recupero la categoria by id
        $category = Category::find($id);

        // validazione request
        $request->validate([
            'category_name' => 'required|string|alpha|min:3|max:200|unique:categories,category_name,'.$id
        ]);

        // data request all
        $data = $request->all();

        // update valori
        $category->category_name = ucfirst($data['category_name']);

        // save
        $category->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificata Categoria {$category->category_name}");

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
            abort(403);
        }

        // recupero la categoria by id
        $category = Category::find($id);

        // elimino la categoria
        $category->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminata Categoria {$category->category_name}");

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
            abort(403);
        }

        // controllo se esiste almeno un id
        if(count($request->idsRecord) == 0) {
            return response()->json([
                'status' => 400,
                'message' => 'There are no selected record ids'
            ], 400);
        }
        
        // elimino tutt i record aventi gli id della request
        $categories = Category::whereIn('id', $request->idsRecord)->delete();
        
        // Aggiungo il log attività
        LogActivity::addLog("Eliminate Categorie selezionati");
        
        return response()->json([
            'status' => 200,
            'message' => 'Selected Categories have been deleted.'
        ], 200);
    }
}
