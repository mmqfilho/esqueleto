<?php

class ErroController extends Controller
{
    public function index()
    {
        if (empty($_SESSION['exception'])) {
            View::redirect('index/index');
        }

        $this->view->setView('error/trata_erro');
        $this->view->__set('exception', $_SESSION['exception']);
        $_SESSION['exception'] = null;
        $this->view->carregar();
    }
}
