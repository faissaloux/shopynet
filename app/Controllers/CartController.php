<?php

namespace App\Controllers;

use App\Models\Product;

defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends Controller
{
    public function cart($request, $response)
    {
        $total = 0;
        $products = $_SESSION['products'];

        foreach($products as $product => $data){
            $total += $data['price'];
            $productDB = Product::where('id', $product)->first();
            $_SESSION['products'][$product]['name'] = $productDB->name;
            $_SESSION['products'][$product]['thumbnail'] = $productDB->thumbnail;
        }
        
        $products = $_SESSION['products'];
        $view = 'front/cart.twig';

        return $this->view->render($response,$view, [
            'products' => $products,
            'cartCounter' => count($products),
            'total' => $total
        ]);
    }

    public function addToCart($request)
    {
        $product = $request->getParam('product');
        $quantity = $request->getParam('quantity');
        $price = $request->getParam('price');

        $_SESSION['products'][$product]['price'] = $price;
        $_SESSION['products'][$product]['quantity'] = $quantity;
    }
}