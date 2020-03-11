<?php

/**
 * Classe para controlar tudo relacionado a view do MVC
 */
class View
{
    /**
     * Nome da View
     * @var String
     */
    private $name;

    /**
     * Titulo da View
     * @var String
     */
    private $title = APP_NAME;

    /**
     * Valores dinamicos que são passados para a View
     * @var array
     */
    private $vars = array();

    /**
     * vars de header da view
     */
    private $header = array();

    /**
     * Valores dinamicos que são passados para a View
     * @var String
     */
    private $errorMsg = null;

    /**
     * Construtor padrão.
     * @param String $view
     * @return void
     */
    public function __construct($view = 'index/index')
    {
        $this->name = strtolower($view);
    }

    /**
     * indica a view a ser exibida
     */
    public function setView($view){
        $view = preg_replace('/\.php/i', '', $view);
        $this->name = strtolower($view);
    }
    
    /**
     * indica arquivo de css a ser carregado
     */
    public function setHeaderCss($css){
        $this->header['css'][] = $css;
    }

    /**
     * indica js a ser colocado na pagina
     */
    public function setHeaderJs($js){
        $this->header['js'][] = $js;
    }

    /**
     * Carrega o(s) arquivo(s) da View

     * @param boolean $special
     * @return void
     */
    public function carregar($onlyView = false)
    {
        // transforma todas os indices de $this->vars em variáveis acessíveis na view
        extract($this->vars);

        if (!$onlyView) {
            include DIR_VIEW . '/includes/header.php';
            if (!file_exists(DIR_VIEW . $this->name . '.php')){
                Erro::log("[engine] View [$this->name] não encontrada", 'warning');
                require DIR_VIEW . 'error/view404.php';
            }else{
                require DIR_VIEW . $this->name . '.php';
            }
            include DIR_VIEW . '/includes/footer.php';
        } else {
            if (!file_exists(DIR_VIEW . $this->name . '.php')){
                Erro::log("[engine] View [$this->name] não encontrada", 'warning');
                require DIR_VIEW . 'error/view404.php';
            }else{
                include DIR_VIEW . $this->name . '.php';
            }
        }
    }

    /**
     * inclui cabeçalho json
     */
    public function viewJson($data){
        header('Content-type: application/json; charset=utf-8');
        echo $data;
        exit;
    }

    /**
     * Define um valor de transporte para a View
     * @param String $index , String $value
     * @return void
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * Retorna um valor de transporte da View
     * @param String $index
     * @return String $value
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }

    /**
     * Usa como base a definição REQUEST_PATH_BACK para re-escrever um link de redirecionamento
     * @param String $data
     * @return String $dataFormatada
     */
    private function link($caminho)
    {
        echo HOME_PATH . $caminho;
    }

    /**
     * @param string $url
     * @param bool $js
     */
    public static function redirect($url, $js = false)
    {
        if (!$js) {
            header('Location: ' . HOME_PATH . $url);
        } else {
            echo "<script>window.location.href = '" . HOME_PATH . $url . "';</script>";
        }
        exit();
    }

    /**
     * @param $mensagem
     */
    public static function mensagem($mensagem)
    {
        if (!is_array($mensagem)) {
            $arrMensagem = array();
            $arrMensagem[] = $mensagem;
        }
        $_SESSION['mensagens'] = $arrMensagem;
    }
}
