<?php
// função para preenchimento dos dados
function setIni($arquivo, $indices, $default = null){
    $i = explode('/', $indices);
    return (isset($arquivo[$i[0]][$i[1]]) && !is_null($arquivo[$i[0]][$i[1]]) && $arquivo[$i[0]][$i[1]] != '') ? $arquivo[$i[0]][$i[1]] : $default;
}

// ajusta o timezone
ini_set('date.timezone', 'America/Sao_Paulo');

// abre dados do arquivo ini
$ini = parse_ini_file('config.ini', true);

// Define tipo de servidor
if ($_SERVER['HTTP_HOST'] == ''){
    define( 'SERVER_TYPE', 'LOCAL');
}elseif($_SERVER['HTTP_HOST'] == ''){
    define( 'SERVER_TYPE', 'DESENVOLVIMENTO');
}elseif($_SERVER['HTTP_HOST'] == ''){
    define( 'SERVER_TYPE', 'HOMOLOGACAO');
}else{
    define( 'SERVER_TYPE', 'PRODUCAO');
}

/**
 * Campos de uso da aplicação, NÃO ALTERAR
 */
//Diretórios do Framework (NÃO ALTERAR)
define( 'DS', DIRECTORY_SEPARATOR);
define( 'APPPATH', dirname( __FILE__ ) );
define( 'DIR_CONTROLLER', APPPATH . DS . 'app' . DS . 'controller' . DS);
define( 'DIR_VIEW', APPPATH . DS .'app' . DS . 'view' . DS);
define( 'DIR_MODEL', APPPATH . DS . 'app' . DS . 'model' . DS);
define( 'DIR_GLOBAL', APPPATH . DS . 'app' . DS . 'global' . DS);
define( 'DIR_DAO', APPPATH . DS . 'app' . DS . 'dao' . DS);
define( 'DIR_ENUM', APPPATH . DS . 'app' . DS . 'enum' . DS);
define( 'DIR_LIBS', APPPATH . DS . 'libs' . DS);
define( 'DIR_LOGS', APPPATH . DS . 'logs' . DS);
define( 'DIR_IMG', APPPATH . DS . 'public' . DS . 'img' . DS);

//Diretórios de arquivos de carga (NÃO ALTERAR)
define( 'DIR_DATA', APPPATH . DS . 'data' . DS);
define( 'DIR_DATA_INPUT', DIR_DATA . 'input' . DS);
define( 'DIR_DATA_OUTPUT', DIR_DATA . 'output' . DS);
define( 'DIR_DATA_DOCUMENTOS', DIR_DATA . 'documentos' . DS);

//Configurações da Aplicação (NÃO ALTERAR)
define( 'APP_NAME', '' );
define( 'APP_OWNER', '' );
define( 'APP_VERSION_BIG', '0' );
define( 'APP_VERSION_MID', '0' );
define( 'APP_VERSION_MIN', '0' );

/**
 * Campos disponíveis para alteração
 */
// Modo Debug
define( 'DEBUG', true );

//Configurações do Banco de Dados
define( 'DB_HOSTNAME', setIni($ini, 'database/DB_HOSTNAME') );
define( 'DB_USERNAME', setIni($ini, 'database/DB_USERNAME') );
define( 'DB_PASSWORD', setIni($ini, 'database/DB_PASSWORD') );
define( 'DB_DATABASE', setIni($ini, 'database/DB_DATABASE') );
define( 'DB_CHARSET', 'utf-8' );
define( 'DB_SELECT_DEFAULT_MAX_LIMIT', 50);

//Dados do superusuário
define( 'USERNAME_ADMIN', setIni($ini, 'admin/USERNAME_ADMIN', 'admin') );
define( 'PASSWORD_ADMIN', setIni($ini, 'admin/PASSWORD_ADMIN', 'admin') );

// Dados do LDAP/AD
define( 'LDAP_WSDL',        setIni($ini, 'ldap/LDAP_WSDL') );
define( 'LDAP_SERVER',      setIni($ini, 'ldap/LDAP_SERVER') );
define( 'LDAP_PORT',        setIni($ini, 'ldap/LDAP_PORT') );
define( 'LDAP_DOMAIN',      setIni($ini, 'ldap/LDAP_DOMAIN') );
define( 'LDAP_USER',        setIni($ini, 'ldap/LDAP_USER') );
define( 'LDAP_PASSWORD',    setIni($ini, 'ldap/LDAP_PASSWORD') );
define( 'LDAP_BASE_DN',     setIni($ini, 'ldap/LDAP_BASE_DN') );
define( 'LDAP_FILTER',      setIni($ini, 'ldap/LDAP_FILTER') );

//Dados de email
define( 'SMTP_HOST',        setIni($ini, 'email/SMTP_HOST') );
define( 'SMTP_PORT',        setIni($ini, 'email/SMTP_PORT') );
define( 'SMTP_USER',        setIni($ini, 'email/SMTP_USER') );
define( 'SMTP_PASS',        setIni($ini, 'email/SMTP_PASS') );
define( 'SMTP_FROM',        '' );
define( 'SMTP_FROM_NAME',   '');
define( 'EMAIL_ENGINE',     'sendPhp');

//Endereco do sistema
define( 'HOME_PATH', setIni($ini, 'sistema/HOME_PATH') );
