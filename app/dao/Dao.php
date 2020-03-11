<?php

/**
 * Classe Dao
 */
class Dao
{

    /**
     * constructor.
     */
    public function __construct (){
        
    }

    /**
     * Verifica se a matricula é administrador
     */
    public function msgLogError($objClass, $e, $query){
        Erro::log("[DAO] " . get_class($objClass) . ' -> ' . $e->getMessage() . chr(10) . $query, 'error');
    }

}
