<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Product;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class CategoriesController extends Controller
{


   public function getCategories() {

       return Category::all();
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

   public function getProducts($id) {



                 if($id === -1) {
                     return Product::select('title', 'price', 'imageUrl');
                 }




     return Product::select('products.id', 'products.title', 'products.price', 'products.imageUrl',
           DB::raw('CASE WHEN items.quantity IS NULL THEN 0 ELSE items.quantity END as quantity'))
       ->leftJoin('items', function($join) use($id){
           $join->on('products.id', '=', 'items.product_id')
               ->where('items.shopping_cart_id', '=', $id);
       })->get();

   }



   public function getProductNamesAll(Request $request) {

     $namid = $request->nam;
     $cartid = $request->cart;

      if($request->cart === null){

         return Product::select('products.id','title', 'price', 'imageUrl')
         ->join('categories', 'categories.id', '=', 'products.category_id')
           ->where('products.category_id', $request->nam)->get();
          }

       return Product::select('products.id', 'products.title', 'products.price', 'products.imageUrl',
           DB::raw('CASE WHEN items.quantity IS NULL THEN 0 ELSE items.quantity END as quantity'))
           ->join('categories', 'categories.id', '=', 'products.category_id')->where('products.category_id', '=', $namid)
           ->leftJoin('items', function($join) use($cartid, $namid){
               $join->on('products.id', '=', 'items.product_id')
                   ->where('items.shopping_cart_id', '=', $cartid);
           })->get();



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

    public function deleteProduct($id) {
        Product::find($id)->delete();
    }

    public function newCart(Request $request) {

          $input = $request->all();
          $ini= null;
          foreach($input as $in){
             $ini = $in;
          }
          $cart = new ShoppingCart();
          $cart->created = $ini;
          $cart->save();

          $id = ShoppingCart::select('id')->where('created', $ini)->first();


        return response()->json($id);

    }

    public function getCartId($id) {

       $cart = ShoppingCart::find($id)->select('id')->first();
      return  $cartId = $cart->id;

    }

    public function createItem(Request $request)
    {


        $cart_item_quantity = Item::select('quantity')->where('shopping_cart_id', $request->car)
            ->where('product_id', $request->pro)->first();

         if( $cart_item_quantity === null) {

             $item = new Item();

             $item->shopping_cart_id = $request->car;
             $item->product_id = $request->pro;
             $item->quantity = 1;
             $item->save();

         } else {
             $new = $cart_item_quantity->quantity + 1;
             Item::where('shopping_cart_id', $request->car)
                 ->where('product_id', $request->pro)->update(['quantity' => $new]);

         }







    }






    public function getCart($id) {
         $cart = ShoppingCart::find($id);
         return $cart->items;
    }

    public function deleteItem(Request $request) {
       $quantity = Item::select('quantity')->where('shopping_cart_id', $request->car)->where('product_id', $request->pro)->first();
       $new =$quantity->quantity-1;
       if($new <= 0) {
           Item::where('shopping_cart_id', $request->car)->where('product_id', $request->pro)->delete();
       }

       Item::select('quantity')->where('shopping_cart_id', $request->car)->where('product_id', $request->pro)->update(['quantity' => $new]);
    }


}
