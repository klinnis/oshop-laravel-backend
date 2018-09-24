<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;


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

       //$category= $request->input('categories');

     //  $category_id = Category::select('id')->where('name', $category)->get();

       $product = new Product();

      $product->title = 'ghhgh';
      $product->price = 'ghgfhfgh';
      $product->category_id = 'fghfghh';
      $product->imageUrl = 'hgfghfghg';

      $product->save();

   }

   public function getProducts() {
       return Product::all();
   }

   public function getOneProduct($id) {
      return  Product::find($id);

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
