<?php

namespace App\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller {
    
    protected $container;
    protected $lang;
    protected $user;


        
    public function init( $model = false ) {
        if($model){
              return '\\App\\Models\\' . ucfirst($model);
        }
        if($this->model) {
            return '\\App\\Models\\' . ucfirst($this->model);
        }
        return false;
    }
    
    
    public function __construct($container){
       $this->container = $container; 
       $this->lang      = $_SESSION['l'] ?? [];
       $this->user      = isset($_SESSION['auth-user']) ? \App\Models\User::find($_SESSION['auth-user']) : [];

    } 
    
    public function dir($dir){
       return $this->container->conf['dir.'.$dir];
    }
    public function url($url){
        return $this->container->conf['url.'.$url];
    }
    
    public function flash($message, $type = 'success'){
        return $_SESSION['flash'][$type] = $message;
    }
    
    public function flasherror($message){
        return $this->flash->addMessage('error',$message);
    } 
    
    public function flashsuccess($message){
        return $this->flash->addMessage('success',$message);
    } 
    
    
    public function __get($name){
        return $this->container->$name;
    }
    
    
    
}