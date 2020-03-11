<?php

class Controller
{

    private $controller;
    private $action;
    private $pathView;
    private $parameters;

    protected $view;

    public function setController($controller) { $this->controller = $controller; }
    public function getController() { return $this->controller; }
    public function setAction($action) { $this->action = $action; }
    public function getAction() { return $this->action; }
    public function setPathView($path) { $this->pathView = $path; }
    public function getPathView() { return $this->pathView; }
    public function getParameters() { return $this->parameters; }

    public function __construct(){
        $this->pathView = (isset($_GET['pathView'])) ? $_GET['pathView'] : 'index/index';

        // seta a view baseado na url
        $this->view = new View($this->pathView);        
    }

    public function redirect($controller) {
        header('Location: ' . HOME_PATH . DS . $controller);
        exit();
    }

    protected function isLogged(){
        
    }
}
