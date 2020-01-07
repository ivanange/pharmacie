<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Nullable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(); /* va contenir les donnees de la table catégories dans la base*/
        $categories = Category::all(); /*va aller recuperer les donnees de la table categories de la base*/
        $data["categories"] =$categories; /* contient les informations qu'on est allées chercher  */

        return view('index', $data); /*on affiche toutes les categories dans la page index*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   /*on valide la création ( on récupère les données entrer dans le formulaire) */
        $request = $request->validate([
            "name"=>"required|string|max:500",
            "desc"=>"nullable|string|max:1500"
            ]);

            /*on crée une nouvelle catégorie dont le nom et la description seront vide
            et à partir de la variable request on la remplie avec les infos recuperees*/

            $new_category = new Category();

            $new_category->fill($request->all());

            $new_category->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request = $request->validate([
            "name"=>"required|string|max:500",
            "desc"=>"nullable|string|max:1500"
            ]);

        $category->fill($request->all());
        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
