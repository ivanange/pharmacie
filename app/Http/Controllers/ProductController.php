<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array(); /* va contenir les donnees de la table produits dans la base*/
        $products = Product::with("category")->get(); /*va aller recuperer les donnees de la table produits de la base*/
        $data["products"] = $products; /* contient les informations qu'on est allées chercher  */

        return $request->json ?? false ? $products->toJson() : view('products.index', $data); /*on affiche toutes les categories dans la page index*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*on valide la création ( on récupère les données entrer dans le formulaire) */
        $request = $request->validate([
            "name" => "required|string|max:500",
            "manufacturer" => "required|string|max:500",
            "weight" => "sometimes|numeric",
            "price" => "required|numeric",
            "qte" => "required|integer",
            "expireDate" => "required|dateTime",
            "category_id" => "required|exists:categories,id"

        ]);

        /*on crée une nouvelle catégorie dont le nom et la description seront vide
            et à partir de la variable request on la remplie avec les infos recuperees*/

        $product = new Product();

        $product->fill($request->all());

        $product->save();

        return $request->json ?? false ? $product->toJson() : redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Request $request)
    {
        return $request->json ?? false ? $product->toJson() : view('products.show', ["product" => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', ["product" => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request = $request->validate([
            "name" => "required|string|max:500",
            "manufacturer" => "required|string|max:500",
            "weight" => "sometimes|numeric",
            "price" => "required|numeric",
            "qte" => "required|integer",
            "expireDate" => "required|dateTime",
            "category_id" => "required|exists:categories,id"

        ]);

        $product->fill($request->all());
        $product->save();

        return $request->json ?? false ? $product->toJson() : redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        $product->delete();
        return $request->json ?? false ? response()->json() : redirect('/products');
    }
}
