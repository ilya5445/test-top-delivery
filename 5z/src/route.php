<?php

namespace API;

use \Bramus\Router\Router;

class Route {

    public function run() {

        // Create Router instance
        $router = new Router();

        $router->post('/auth/', "API\Controller\UserController@auth");
        $router->post('/validate-token/', "API\Controller\UserController@validateToken");

        $router->run();

    }

}
