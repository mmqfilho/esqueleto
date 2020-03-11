<?php

/**
 * Classe Ldap para pegar dados do usuário no AD
 */
class Ldap
{

    private $server;
    private $port;
    private $domain;
    private $user;
    private $password;
    private $baseDn;
    private $filter;
    public $error;

    /**
     * constructor.
     */
    public function __construct(){
        $this->server   = LDAP_SERVER;
        $this->port     = LDAP_PORT;
        $this->domain   = LDAP_DOMAIN;
        $this->user     = LDAP_USER;
        $this->password = LDAP_PASSWORD;
        $this->baseDn   = LDAP_BASE_DN;
        $this->filter   = LDAP_FILTER;
    }

    public function setServer($server){ $this->server = $server; }
    public function getServer(){ return $this->server; }

    public function setPort($port){ $this->port = $port; }
    public function getPort(){ return $this->port; }

    public function setDomain($domain){ $this->domain = $domain; }
    public function getDomain(){ return $this->domain; }

    public function setUser($user){ $this->user = $user; }
    public function getUser(){ return $this->user; }

    public function setPassword($pass){ $this->password = $pass; }
    public function getPassword(){ return '******'; } // heheheh

    public function setBaseDn($baseDn){ $this->baseDn = $baseDn; }
    public function getBaseDn(){ return $this->baseDn; }

    public function setFilter($filter){ $this->filter = $filter; }
    public function getFilter(){ return $this->filter; }

    public function getLdapData($matricula){

        // coloca a matricula no filtro de busca
        $this->filter = preg_replace('/\*/', $matricula, $this->filter);

        try {
            // faz a conexão no servidor do AD
            if (!$conn = ldap_connect($this->server, $this->port)){
                $this->error[] = "Não foi possível se conectar no servidor do AD";
                return false;
            }

            // conectou, ajusta opções
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($conn, LDAP_OPT_SIZELIMIT, 0);

            // autentica usuário para pegar informações
            if (!ldap_bind($conn, $this->user, $this->password)){
                $this->error[] = "Não foi possível se autenticar no AD";
                return false;
            }

            // pesquisa usuário específico do AD
            if (!$search = ldap_search($conn, $this->baseDn, $this->filter)){
                $this->error[] = "Dados de usuário não encontrados no AD";
                return false;
            }

            $total = ldap_count_entries($conn, $search);
            $info = ldap_get_entries($conn, $search);

            if ($total > 0){
                $retorno = array();
                $retorno['nome']            = (isset($info[0]['sn'][0]))?$info[0]['sn'][0]:null;
                $retorno['cargo']           = (isset($info[0]['description'][0]))?$info[0]['description'][0]:null;
                $retorno['departamento']    = (isset($info[0]['department'][0]))?$info[0]['department'][0]:null;
                $retorno['empresa']         = (isset($info[0]['company'][0]))?$info[0]['company'][0]:null;
                $retorno['user']            = (isset($info[0]['userprincipalname'][0]))?$info[0]['userprincipalname'][0]:null;
                $retorno['email']           = (isset($info[0]['mail'][0]))?$info[0]['mail'][0]:null;
                $retorno['matricula']       = (isset($info[0]['samaccountname'][0]))?$info[0]['samaccountname'][0]:null;

                return $retorno;
            }else{
                $this->error[] = "Dados de usuário não encontrados no AD";
                return false;
            }
            

        } catch (Exception $e) {
            //Erro::trataErro($e);
            $this->error[] = $e;
            return false;
        }
    }
}
