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
            'productsIds' => implode(',', array_keys($products)),
            'cartCounter' => count($products),
            'total' => $total
        ]);
    }

    public function addToCart($request, $response)
    {
        $product = $request->getParam('product');
        $quantity = $request->getParam('quantity');
        $price = $request->getParam('price');

        $_SESSION['products'][$product]['price'] = $price;
        $_SESSION['products'][$product]['quantity'] = $quantity;

        return $response->withJson(['success' => 'Added to cart successfully'], 200);
    }

    public function checkIfInCart($request, $response)
    {
        $product = $request->getParam('product');
        $exist = isset($_SESSION['products'][$product]);

        return $response->withJson(['exist' => $exist], 200);
    }

    public function removeFromCart($request, $response)
    {
        $total = 0;
        $product = $request->getParam('product');
        unset($_SESSION['products'][$product]);
        
        foreach($_SESSION['products'] as $product => $data){
            $total += $data['price'];
        }

        return $response->withJson([
            'success' => 'Removed from cart successfully',
            'total' => $total
        ], 200);
    }
}