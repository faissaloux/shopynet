<?php

namespace App\Controllers;

use \App\Models\{product , ProductCategories , Slider};

defined('BASEPATH') OR exit('No direct script access allowed');

class WebController extends Controller {


    public function index($request,$response,$args){

        if(!empty($_GET['q'])){
            $search = $_GET['q'];
            $products = Product::where('name','Like','%'.$search.'%')->orWhere('name','Like','%'.$search.'%')
            ->orderBy('created_at','DESC')->get()->toArray();;
        }else {
           $products = Product::orderBy('created_at','DESC')->get()->toArray(); 
        }

        $sliders = Slider::all()->toArray();
        $ProductCategories = ProductCategories::where('active','1')->get()->toArray();
        $pinnedproducts = Product::where('show_home','on')->first();
        $view = 'front/index.twig';
                $laterDate = (new \DateTime('tomorrow + 2 days'))->format('Y-m-d');

        return $this->view->render($response,$view,compact('products','sliders','ProductCategories','pinnedproducts','laterDate'));
    }
    
    
    public function categories($request,$response,$args){
        
        $category = ProductCategories::where('slug',$args['slug'])->first();
        
        
        $current_categorie = $args['slug'];
        
        
        if($category) {
            $products = $category->products()->get()->toArray();
        }else {
           $products = Product::all()->toArray();  
        }
    
        $view = 'front/categories.twig';
        return $this->view->render($response,$view,compact('products','current_categorie'));
        
        
    }
    
    

    public function bache($request,$response,$args){
        $view = 'front/bache.twig';
        return $this->view->render($response,$view);
    }
    
    
    
    public function product($request,$response,$args){
        $id = rtrim($args['id'], '/');
        $product = Product::find($id);
        $view = 'front/product.twig';
        $laterDate = (new \DateTime('tomorrow + 2 days'))->format('Y-m-d');
       
        $current_categorie = $product->category->name ;

        return $this->view->render($response,$view,compact('product','laterDate','current_categorie'));
    }
    
    public function thankyou($request,$response,$args){
        $request->getParams();
        $current_categorie = $request->getParam('products');
        
        $view = 'front/thankyou.twig';
        return $this->view->render($response,$view,compact('current_categorie'));
    }
    
    
    public function cuisine($request,$response,$args){
        $view = 'landing/cuisine.twig';
        return $this->view->render($response,$view);
    }
    
    public function cosmetic($request,$response,$args){
        $view = 'landing/cosmetic.twig';
        return $this->view->render($response,$view);
    }
    
    public function sport($request,$response,$args){
        $view = 'landing/sport.twig';
        return $this->view->render($response,$view);
    }
    
    public function voiture($request,$response,$args){
        $view = 'landing/voiture.twig';
        return $this->view->render($response,$view);
    }
    
    public function accessoires($request,$response,$args){
        $view = 'landing/accessoires.twig';
        return $this->view->render($response,$view);
    }
    
    public function clouthing($request,$response,$args){
        $view = 'landing/clouthing.twig';
        return $this->view->render($response,$view);
    }

    
    public function pixels($request,$response,$args){
        $options =  \App\Models\Options::all('name','value')->toArray();
        $la = [];
        foreach($options as $option){
            $la[$option['name']] = $option['value'];
        }
        $options = $la;
       //dd($options);
        $view = 'landing/pixels.twig';
        return $this->view->render($response,$view,compact('options'));
    }
    
        
        
        
    public function pixels_save($request,$response,$args){
        
       $option = new \App\Models\Options();
        
       $post = $request->getParams();

       foreach($post as $key => $value ){
            $option->update_option($key,$value);
       }
       
       
      return  $response->withRedirect($this->router->pathFor('pixels'));
    }

    public function contact_us($request,$response)
    {
        $view = 'front/contact_us.twig';
        return $this->view->render($response,$view);
    }

    public function return_policy($request,$response)
    {
        $view = 'front/return_policy.twig';
        return $this->view->render($response,$view);
    }

    public function confidentiality_policy($request,$response)
    {
        $view = 'front/confidentiality_policy.twig';
        return $this->view->render($response,$view);
    }
}
