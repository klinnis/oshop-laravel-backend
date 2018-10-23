<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::group([

    'middleware' => 'api',

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    Route::post('me', 'AuthController@me');
    Route::put('store', 'CategoriesController@storeProduct');
    Route::put('updateproduct/{id}', 'CategoriesController@updateProduct');
    Route::put('newcart', 'CategoriesController@newCart');
    Route::put('createItem', 'CategoriesController@createItem');

    Route::get('categories', 'CategoriesController@getCategories');
    Route::get('product-names/{name}', 'CategoriesController@getProductNames');
    Route::get('products/{id}', 'CategoriesController@getProducts');
    Route::get('oneproduct/{id}', 'CategoriesController@getOneProduct');
    Route::put('allproductnames', 'CategoriesController@getProductNamesAll');
    Route::get('getCartId/{id}', 'CategoriesController@getCartId');
    Route::get('getCart/{id}', 'CategoriesController@getCart');
    Route::get('all_items/{id}', 'CategoriesController@getAllItems');

    Route::delete('deleteproduct/{id}', 'CategoriesController@deleteProduct');
    Route::put('deleteItem', 'CategoriesController@deleteItem');


});

















// Get list of Products
//Route::get('recipes','RecipeController@index');

// Get name of Recipe
//Route::get('recipe/{name}','RecipeController@recipeName');

// Get specific Product
//Route::get('specificrecipe/{id}','RecipeController@specificRecipe');

//Get Ingredients of specific product
//Route::get('recipe_ingredients/{id}','RecipeController@showIngredients');

// Delete a Product
//Route::delete('product/{id}','RecipeController@destroy');

// Update existing Product
//Route::put('recipe_up/{id}','RecipeController@update');

// Create new Recipe
//Route::put('recipe_nea','RecipeController@store');
