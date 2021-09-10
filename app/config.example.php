<?php 



define('SCRIPTURL','url');
define('SCRIPTDIR', BASEPATH.'/');



return  [
    
    'app' => [
        'version'            => '2.8.10',
        'debug'              => false,
    ],
      
      
      
    'db_live' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'db_name',
        'username'           => 'db_username',
        'password'           => 'db_password',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
        'prefix'             => 'na_'
    ],
    
    
    
    
    'db_sandbox' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'db_name',
        'username'           => 'db_username',
        'password'           => 'db_password',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
        'prefix'             => 'na_'
    ],
    
    'views'                  => '',
  
    'url' => [
        'base'               => SCRIPTURL,
        'ads'                => SCRIPTURL.'uploads/undetected/',
        'admin_assets'       => SCRIPTURL.'admin_assets/',
        'website_assets'     => SCRIPTURL.'assets/',
        'assets'             => '/assets/',
        'avatars'            => SCRIPTURL.'uploads/avatar/',
        'media'              => SCRIPTURL.'uploads/media/',    
        'products'           => SCRIPTURL.'uploads/products/',    
        'uploads'            => SCRIPTURL.'uploads/',    
        'sliders'            => SCRIPTURL.'uploads/sliders/',    
		'categories'         => SCRIPTURL.'uploads/categories/',    
    ],
    
    'dir' => [
        'base'               => SCRIPTDIR,
        'media'              => SCRIPTDIR.'public/uploads/media/',
        'filat'              => SCRIPTDIR.'public/uploads/filat/',
        'csv'                => SCRIPTDIR.'public/uploads/csv/',
        'products'           => SCRIPTDIR.'public/uploads/products/',    
        'sliders'            => SCRIPTDIR.'public/uploads/sliders/',     
		'categories'         => SCRIPTDIR.'public/uploads/categories/',     
    ] 

    
    
];
