<?php

namespace API\Controller;

class Controller {
    
    protected $request = [];
    
    function __construct() {
        $this->request['post'] = empty($_POST) ? json_decode(file_get_contents('php://input'), true) : $_POST;
    }
   
}
