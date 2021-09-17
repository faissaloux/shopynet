<?php

// make namespace short
use \App\Controllers\AuthController as auth;
use \App\Middleware\flashMiddleware as flash;
use \App\Middleware\OldInputMidddleware as old;
use \App\Middleware\logoutMiddleware as logout;
use \App\Controllers\SettingsController as settings;
use \App\Controllers\SliderController as slider;
use \App\Controllers\ProductsCategoriesController as productscats;
use \App\Controllers\CartController as cart;

// security , disable direct access
defined('BASEPATH') or exit('No direct script access allowed');

$app->get('[/]', Web::class.':index')->setName('website.index');
$app->get('/product/{id}', Web::class.':product')->setName('website.product');
$app->get('/thank-you', Web::class.':thankyou')->setName('website.thankyou');
$app->get('/categories/{slug}', Web::class.':categories')->setName('website.categories');

$app->get('/contact-us', Web::class.':contact_us')->setName('website.contact_us');
$app->get('/return-policy', Web::class.':return_policy')->setName('website.return_policy');
$app->get('/confidentiality-policy', Web::class.':confidentiality_policy')->setName('website.confidentiality_policy');
$app->get('/cart', cart::class.':cart')->setName('website.cart');
$app->post('/add-to-cart', cart::class.':addToCart')->setName('add_to_cart');
$app->post('/remove-from-cart', cart::class.':removeFromCart')->setName('remove_from_cart');
$app->post('/check-if-in-cart', cart::class.':checkIfInCart')->setName('check_if_in_cart');

$app->post('/login[/]', auth::class .':login')->setName('login');
$app->get('/logout[/]', auth::class .':logout')->setName('logout')->add( new logout($container) );

$app->group('/admin', function ($container) use($app) {

    // Dashboard index
    $this->get('[/]','Data:index')->setName('admin.index')->add( new App\Middleware\adminMiddleware($container));
   
   
    $this->get('/change/statue','Data:index')->setName('admin.index')->add( new App\Middleware\adminMiddleware($container));
    $this->post('/load/list','Data:load')->setName('admin.load');
    $this->post('/list/update','Data:update')->setName('admin.update');
    $this->post('/list/create','Data:create')->setName('admin.create');
    $this->post('/export/excel','ExcelExporter:exportData')->setName('admin.update');


    $this->post('/remove/item',function($request){
        $id = $_POST['id'];
        $list = \App\Models\NewOrders::find($id);
        $list->delete();
    });

    $this->post('/change/statue',function(){
        $id = $_POST['id'];
        $statue = trim($_POST['statue']);
        $list = \App\Models\NewOrders::find($id);
        $list->statue = $statue;
        $list->save();
    });

  
    // Slider System
    $this->group('/slider', function (){
       $this->any('[/]', slider::class .':index')->setName('slider');
       $this->any('/create', slider::class .':create')->setName('slider.create');
       $this->any('/edit/{id}[/]', slider::class .':edit')->setName('slider.edit');
       $this->get('/delete/{id}[/]', slider::class .':delete')->setName('slider.delete');
       $this->any('/beside-slider[/]', settings::class .':slider')->setName('beside-slider');
    });
 
    // products cateogies
    $this->group('/categories', function (){
        $this->any('[/]', productscats::class .':index')->setName('products.categories');
        $this->any('/edit/{id}[/]', productscats::class .':edit')->setName('products.categories.edit');
        $this->get('/delete/{id}[/]', productscats::class .':delete')->setName('products.categories.delete');
    });


    // new orders system
    $this->get('/data', 'Data:index')->setName('data');
    $this->get('/settings', settings::class.':index')->setName('settings.index');
    $this->post('/settings', settings::class.':update')->setName('settings.update');
    $this->post('/profile', settings::class.':profile')->setName('settings.profile');

    // Products system
    $this->group('/products', function (){
        $this->get('[/]', 'Products:index')->setName('products');
        $this->any('/create[/]', 'Products:create')->setName('products.create');
        $this->any('/edit/{id}[/]', 'Products:edit')->setName('products.edit');
        $this->get('/delete/{id}[/]', 'Products:delete')->setName('products.delete');
        $this->get('/duplicate/{id}[/]', 'Products:duplicate')->setName('products.duplicate');
        $this->get('/blukdelete[/]', 'Products:blukdelete')->setName('products.blukdelete');
    });

 
    
})->add( new App\Middleware\authMiddleware($container) );


$app->post('/storeApi[/]', function ($request, $response, $args) {

    $productIds = explode(',', $_POST['productsIds']);
    foreach($productIds as $productId){
        $data = [
            'name'  =>  $_POST['fullname'] ,
            'tel'  =>  $_POST['phone'] ,
            'adress'  =>  $_POST['address'] ,
            'city'  =>  $_POST['city'] ,
            'quantity' => $_SESSION['products'][$productId]['quantity'],
            'price' =>  $_SESSION['products'][$productId]['price'],
            'source' => '',
            'color' => '',
            'size' =>  '',
            'productID' => $productId,
        ];
    
        \App\Models\NewOrders::create($data);
        unset($_SESSION['products'][$productId]);
    }
    
    return $response->withJson(['success' => 'Order created successfully'], 200);
});


//   Middlewares
$app->add( new flash($container) );
$app->add( new old($container) );

$app->get('/adminer', function() {
    if(file_exists('../adminer.php')){
        require '../adminer.php';
    };
});
