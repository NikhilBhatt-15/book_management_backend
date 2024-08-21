<?php
use App\Http\Controllers\OrderController;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// admin funcs
$router->group(['prefix'=>'api/admin','middleware'=>'auth:admin'],function($router){
    // category related routes
    $router->post('/addcategory','AdminController@addCategory');
    $router->post('/modifycategory',['middleware'=>['cache:books,del'],'uses'=>'AdminController@modifyCategory']);
    $router->post('/deletecategory',['middleware'=>['cache:books,del'],'uses'=>'AdminController@deleteCategory']);
    $router->get('/getcategories','AdminController@categories');

    // book related routes
    $router->post('/addbook',['middleware'=>['cache:books,del'],'uses'=>'AdminController@addBook']);
    $router->post('/modifybook',['middleware'=>['cache:books,del'],'uses'=>'AdminController@modifyBook']);
    $router->post('/deletebook',['middleware'=>['cache:books,del'],'uses'=>'AdminController@deleteBook']);
    $router->get('/getbooks',['middleware'=>['cache:books',null],'uses'=>'AdminController@books']);
    $router->post('/getcategorisedbooks','AdminController@getbook');

    // request related routes
    $router->get('/getrequests','AdminController@getRequests');
    $router->post('/handlerequests','AdminController@handleRequest');
    $router->post('/removerequest','AdminController@removeRequest');

    // users related routes
    $router->get('/getusers','AdminController@users');
    $router->post('/removeuser','AdminController@removeUser');

    // order related routes
    $router->get('/getorders','AdminController@getOrders');


});

// user func
$router->group(['prefix'=>'api/user','middleware'=>['auth:api']],function($router){

    // cart related routes
    $router->post('/add','CartController@addItem');
    $router->post('/remove','CartController@removeItem');
    $router->post('/getcart','CartController@getcart');
    $router->post('/updatecart','CartController@updateCart');
    $router->post('/checkout','CartController@checkout');

    // rent related routes
    $router->post('/rent','RentController@rent');
    $router->post('/rentrequests','RentController@rentRequests');
    $router->post('/removerequest','RentController@removeRequest');
    $router->post('/returnbook','RentController@returnBook');

    // books related requests
    $router->get('/getcategories','RentController@getCategories');
    $router->post('/buy',['middleware'=>['cache:books,del'],'uses'=>'OrderController@buy']);
    $router->get('/ownedbooks','OrderController@getbook');
    $router->get('/getbooks',['middleware'=>['cache:books'],'uses' => 'OrderController@getbooks']);
    $router->get('/getorders','OrderController@getOrders');

});


// user login
$router->group(['prefix'=>'api/user'],function($router){
    $router->post('/login','UserAuthController@login');
    $router->post('/logout','UserAuthController@logout');
    $router->post('/register','UserAuthController@register');
    $router->post('/updateprofile','UserAuthController@update');
    $router->post('/profile','UserAuthController@profile');

});


// admin login
$router->group(['prefix'=>'api/admin'],function($router){
    $router->post('/login','AdminAuthController@login');
    $router->post('/logout','AdminAuthController@logout');
    $router->post('/register','AdminAuthController@register');
    $router->post('/profile','AdminAuthController@profile');
    $router->post('/updateprofile','AdminAuthController@updateProfile');
});
