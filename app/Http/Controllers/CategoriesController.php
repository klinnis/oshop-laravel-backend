<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CategoriesController extends Controller
{


   public function getCategories() {

       return Category::select('name')->get();
   }

   public function getProductNames($name) {

       $boolean= 'Not';

        $product_name = Product::select('title')->where('title', $name)->get();

        if($product_name->isEmpty())
            return response()->json($boolean);

   }

   public function storeProduct(Request $request) {

       $category_name= $request->categories;

       $category_id = Category::select('id')->where('name', $category_name)->first();
       $final= $category_id->id;

       $product = new Product();

      $product->title = $request->title;
      $product->price = $request->price;
      $product->category_id = $final;
      $product->imageUrl = $request->imageUrl;

      $product->save();

   }

   public function getProducts() {
       return Product::all();
   }

   public function getOneProduct($id) {

      $product = Product::find($id);
      $category = Product::select('category_id')->where('id', $id)->first();
      $category_id = $category->category_id;

       $category_final = Category::select('name')->where('id', $category_id)->first();
       $final = $category_final->name;


       $data = [
           "title" => $product->title,
           "price" => $product->price,
           "imageUrl" => $product->imageUrl,
           "categories" => $final

    ];


       return response()->json($data);


   }

    public function updateProduct(Request $request, $id) {

      $category_name = $request->categories;

      $category = Category::select('id')->where('name', $category_name)->first();

       $product = Product::find($id);

        $product->title = $request->title;
        $product->price = $request->price;
        $product->category_id =  $category->id;
        $product->imageUrl =  $request->imageUrl;

        $product->save();

    }

}
