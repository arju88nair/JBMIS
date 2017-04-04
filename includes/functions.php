<?php

require '../vendor/autoload.php';
require '../vendor/danjam/slim-mustache-view/src/Mustache.php';

function init(){

    $app = new \Slim\App(array('debug'=>true));
    $container = $app->getContainer();
    $container['view'] = function(){
        $view = new \Slim\Views\Mustache([
            'loader' => new Mustache_Loader_FilesystemLoader('../templates'),
            'partials_loader' => new Mustache_Loader_FilesystemLoader('../templates/partials')
        ]);
        return $view;
    };
    $container['db'] = function(){
        $conn = oci_connect("memp", "memp", "10.0.0.11");
        return $conn;
    };
    return $app;
}

?>
