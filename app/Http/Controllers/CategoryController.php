<?php

namespace App\Http\Controllers;

use App\Category;
use App\LogActivity;
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
        // aggiungo il log attività
        LogActivity::addLog("Lista Categorie");

        // recupero tutte le categorie dal db
        $categories = Category::sortable(['name' => 'asc'])->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:3|max:200|unique:categories,name'
        ]);

        // data request all
        $data = $request->all();

        // creo nuova istanza Category
        $newCategory = new Category();

        // setto i valori
        $newCategory->name = ucfirst($data['name']);

        // save
        $newCategory->save();

        // aggiungo il log attività
        LogActivity::addLog("Creata Categoria {$newCategory->name}");

        return redirect()->route('categories.index')->with('success', "La Categoria con nome: {$newCategory->name} è stata creata.");
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
        // recupero la categoria by id
        $category = Category::find($id);
        
        // aggiungo il log attività
        LogActivity::addLog("Modifica Categoria {$category->name}");
        
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
        // recupero la categoria by id
        $category = Category::find($id);

        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:3|max:200|unique:categories,name,'.$id
        ]);

        // data request all
        $data = $request->all();

        // update valori
        $category->name = ucfirst($data['name']);

        // save
        $category->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificata Categoria {$category->name}");

        return redirect()->route('categories.index')->with('success', "La Categoria con nome: $category->name è stata modificata.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // recupero la categoria by id
        $category = Category::find($id);

        // elimino la categoria
        $category->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminata Categoria {$category->name}");

        return redirect()->route('categories.index')->with('success', "La Categoria con nome: {$category->name} è stata eliminata.");
    }
}
