<?php

/**
 * Class IndexController
 */
class IndexController extends Controller
{  
    /**
     * Index da Aplicação
     */
    public function index(){
        try {
            $this->view->__set("xxx", $xxx ));

            // informa css a ser inserido
            $this->view->setHeaderCss('app.css');

            // informa js a ser inserido
            //$this->view->setHeaderJs('app.js');

            $this->view->carregar();
        } catch (Exception $e) {
            Erro::trataErro($e);
        }
    }
}
