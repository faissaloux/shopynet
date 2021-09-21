<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Product;
use \App\Helpers\Paginator;
use \App\Models\ProductCategories;




defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsController extends Controller{
    
    

    // index Page
    public function index($request,$response) {
        $model          = new Product();
        $count          = $model->count();         
        $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
        $limit          = 200; 
        $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));   
        $skip           = ($page - 1) * $limit;
        $products         = $model->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();
        $urlPattern     = "?page=(:num)";
        $paginator = new Paginator($count, $limit, $page, $urlPattern);
        return $this->view->render($response, 'admin/products/index.twig', ['products'=> $products,'p'=>$paginator]);    
    }
    
    
    
    public function saveProduct($content,$request){
            $post   = clean($request->getParams());
            $dir         = $this->dir('products');

            if(!empty($_FILES['ProductThumbnail']['name'])){
                $uploader   = new \App\Helpers\Uploader('start');
                $thumbnail   = $uploader->file($_FILES['ProductThumbnail'])->dir($dir)->save();
            }else {
                $thumbnail   = '';
            }

            if($_FILES['galleryImages']['size'][0] !== 0){
                $gallery = $this->uploadGallery($_FILES['galleryImages']);
            }else {
                $gallery = null;
            }
           
            $content->thumbnail   =  $thumbnail;
            $content->name        =  $post['name'] ;
            $content->gallery     =  $gallery;
            $content->price       =  $post['price'];
            $content->price_2     =  $post['price_2'];
            $content->discount       =  $post['discount'];
            $content->categoryID       =  $post['category'];
            $content->size       =  $post['size']  ?? '';
            $content->color       =  $post['color'] ?? '';
            $content->description       =  $request->getParam('description');
            
            if($post['show_home'] == 'on'){
                $pinnedproducts = Product::where('show_home','on')->get();
                foreach($pinnedproducts as $product ) {
                    $product->show_home = 'off';
                    $product->save();
                }
            }
           
            
            if(empty($post['show_home'])){
                $post['show_home'] = 'off';
            }

            $content->show_home       =  $post['show_home'];
            $content->save();
          
    }
    
    public function create($request,$response){
       
       
       
        if( $request->getMethod() == 'GET')  { 
          
          $categories = ProductCategories::all();  
          
          return $this->view->render($response,'admin/products/create.twig',compact('categories'));
          
        }
       
       
        if($request->getMethod() == 'POST'){ 
          
           
            $content              = new Product;   
            $this->saveProduct($content,$request);
              
            $this->flashsuccess('تم اضافة المنتوج بنجاح');
            return $response->withRedirect($this->router->pathFor('products'));
        }
    }
    
    
    
    public function multiple_file_upload($my_files){
       $files = array();
        foreach ($my_files as $k => $l) {
         foreach ($l as $i => $v) {
         if (!array_key_exists($i, $files))
           $files[$i] = array();
           $files[$i][$k] = $v;
         }
        } 
        return $files;
    }



    public function uploadGallery($files){

        $to_upload = $this->multiple_file_upload($files);

        $gallery    = [];
        foreach ($to_upload as $image) {
            $uploader   = new \App\Helpers\Uploader('start');
            $dir        = $this->dir('products');
            $thumbnail   = $uploader->file($image)->dir($dir)->save();
            array_push($gallery, $thumbnail);
        }

        return json_encode($gallery);

    }    

    public function edit($request,$response,$args){
        
            // get the product id
            $id = rtrim($args['id'], '/');
            $product = Product::find($id);

            // show the edit page 
            if($request->getMethod() == 'GET'){ 
                $categories = ProductCategories::all();  
               return $this->view->render($response,'admin/products/edit.twig',compact('product','categories'));
            }
        
            if($request->getMethod() == 'POST'){

            $post  = clean($request->getParams());            
                
            $content = $product;
                
            if(!empty($_FILES['ProductThumbnail']['name'])){
                $uploader   = new \App\Helpers\Uploader('start');
                $dir         = $this->dir('products');
                $thumbnail   = $uploader->file($_FILES['ProductThumbnail'])->dir($dir)->save();
            }else {
                $thumbnail   = $content->thumbnail;
            }

            if(!empty($_FILES['galleryImages']['name']) and   ( $_FILES['galleryImages']['error']['0'] != 4 )   ){
                $gallery     = $this->uploadGallery($_FILES['galleryImages']);
            }else {
                $gallery  = $content->gallery;
            }
    
    
    
        
            $content->thumbnail   =  $thumbnail;
            $content->name   =  $post['name'];
            $content->gallery     =  $gallery;
            $content->price       =  $post['price'];
            $content->discount       =  $post['discount'];
            $content->categoryID       =  $post['category'];
            $content->size       =  $post['size']  ?? '';
            $content->color       =  $post['color'] ?? '';
            $content->description       =  $request->getParam('description');
            $content->price_2       =  $post['price_2'];
            

            
            if(empty($post['show_home'])){
                $post['show_home'] = 'off';
            }
            
       
            if($post['show_home'] == 'on'){
                $pinnedproducts = Product::where('show_home','on')->get();
                foreach($pinnedproducts as $product ) {
                    if($product->id != $content->id){
                        $product->show_home = 'off';
                        $product->save();
                    }
                }
            }
           
            
            

            $content->show_home       =  $post['show_home'];

            $content->save();

            // success & redirect
            $this->flashsuccess('تم تحديث المنتوج بنجاح');
            return $response->withRedirect($this->router->pathFor('products'));
            
        }
        
        
        
    }

    public function delete($request,$response,$args) {
        
        // get the product id
        $id = rtrim($args['id'], '/');
        
        $path = $this->container->conf['dir.products'];
        
        // Get the Product
        $product = Product::find($id);
        
        
        if($product){
            // Delete the Product
            $product->delete();
            $this->flashsuccess('تم حذف المنتوج بنجاح');
            
        }
        
        return $response->withRedirect($this->router->pathFor('products'));
        
    }
    
    
    
    
}
 