<?php
session_start();
spl_autoload_register('carregaClasses');

//Define visualização de erros de acordo com o modo Debug true ou false
if (!defined('DEBUG') || DEBUG === FALSE) {
    error_reporting(0);
    ini_set("display_errors", 0);
} else {
    error_reporting(E_ALL & ~E_DEPRECATED);
    ini_set("display_errors", 1);
}

//Obtem via URL amigavel o valor do path (caso não seja informado, é definido index/index como padrão)(.htaccess)
$_GET['path'] = (isset($_GET['path']) ? $_GET['path'] : 'index/index');

//Separa o valor do controller do valor da action
$separatorPath = explode('/', $_GET['path']);

//Define o controller
$controller = ucfirst($separatorPath[0]) . 'Controller';

// Define o diretorio da view
$pathView = ucfirst($separatorPath[0]);

//Define a action (caso não seja informado, é definido index como padrão)
$action = (isset($separatorPath[1]) ? $separatorPath[1] : 'index');
if ($action == '') $action = 'index';

// cria o path para a view
$_GET['pathView'] = $pathView.DS.$action;

//Verificação de Parametros
$_PARAMETROS = Array();
if (count($separatorPath) >= 3) {
    for ($separatorPathCount = 2; $separatorPathCount < count($separatorPath); $separatorPathCount++) {
        $_PARAMETROS[$separatorPathCount - 2] = $separatorPath[$separatorPathCount];
    }
}

// se for assets é arquivo
if ($controller != 'AssetsController' && $controller != 'Favicon.icoController') {
    //Instancia Controller e chama a action
    if (class_exists($controller)) {
        $application = new $controller();
    }else{
        Erro::log("[engine] Classe [$controller] não encontrada", 'warning');
        $view = new View('error/404');
        $view->carregar(true);
        exit;
    }
    
    // se o metodo existir joga dados de post e parametros dentro do método
    if (method_exists ( $application , $action)) {

        // informa a controller
        $application->setController($controller);
        $application->setAction($action);

        // verifica se é a area administrativa
        if ($controller == "RhController" && $action != "index"){
            $auth = new AuthController();
            if (!$auth->validaAdminSession()){
                Logdata::log(LogTipoEnum::LOG_TIPO_ERRO_ACESSO, 0, 'ADM - erro acesso em ' . $_SERVER['REQUEST_URI']);
                Erro::display('Erro de acesso');
                View::redirect('/rh');
            }
        }

        // verifica se tem dados enviados e joga como parametro das actions
        if (empty($_POST)) {
            if (count($_PARAMETROS) >= 1) {
                $application->$action($_PARAMETROS);
            } else {
                $application->$action();
            }
        } else {
            if (count($_PARAMETROS) >= 1) {
                $application->$action(array_merge($_PARAMETROS, $_POST));
            } else {
                $application->$action($_POST);
            }
        }

    } else {
        Erro::log("[engine] Método [$action] não encontrado na classe [$controller]", 'warning');
        $view = new View('error/404');
        $view->carregar(true);
        exit;
    }
} else {
    $file = implode("/", $separatorPath);
    if (!file_exists(APPPATH . '/public/' . $file)){
        Erro::log("[__autoload] Arquivo não encontrado - " . APPPATH . "/public/" . $file, 'warning');
        $view = new View('error/404');
        $view->carregar(true);
        exit;
    }
}


function carregaClasses($classname)
{
    if (file_exists(DIR_CONTROLLER . $classname . '.php')) {
        require_once DIR_CONTROLLER . $classname . '.php';

    } else if (file_exists(DIR_MODEL . $classname . '.php')) {
        require_once DIR_MODEL . $classname . '.php';

    } else  if (file_exists(DIR_GLOBAL . $classname . '.php')) {
        require_once DIR_GLOBAL . $classname . '.php';

    } else  if (file_exists(DIR_DAO . $classname . '.php')) {
        require_once DIR_DAO . $classname . '.php';
    
    } else  if (file_exists(DIR_ENUM . $classname . '.php')) {
        require_once DIR_ENUM . $classname . '.php';

    } else  if (file_exists(DIR_LIBS . $classname . '.php')) {
        require_once DIR_LIBS . $classname . '.php';

    } // devido ao carregamento de libs de terceiro fora do padrao nao posso dar 404
    //else {
    //    Erro::log("[__autoload] Classe [$classname] não encontrada", 'warning');
    //    $view = new View('error/404');
    //    $view->carregar(true);
    //    exit;
    //}
}
