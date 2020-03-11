<?php

/**
 * Classe LogdataDao
 */
class LogdataDao
{

    /**
     * constructor.
     */
    public function __construct (){
        
    }

    /**
     * Insere log
     */
    public function insertData($arrayData){
        try {
            if (!isset($arrayData['log_funcionario_id']) || $arrayData['log_funcionario_id'] ==''){
                $arrayData['log_funcionario_id'] = null;
            }
            if (is_null($arrayData['log_periodo_id']) || $arrayData['log_periodo_id'] == ''){
                $arrayData['log_periodo_id'] = 0;
            }
            $query = 'INSERT INTO reop_log (log_tipo_id, log_periodo_id, log_obs, log_funcionario_id) 
                           VALUES (:tipo_id, :periodo_id, :obs, :funcionario_id)';
            $conexao = Database::getInstance()->prepare($query);
            $conexao->bindValue(':tipo_id',         $arrayData['log_tipo_id']);
            $conexao->bindValue(':periodo_id',      $arrayData['log_periodo_id']);
            $conexao->bindValue(':obs',             $arrayData['log_obs']);
            $conexao->bindValue(':funcionario_id',  $arrayData['log_funcionario_id']);
            return $conexao->execute();
        } catch (Exception $e) {
            Erro::log("[DAO] " . get_class($this) . ' -> ' . $e->getMessage() . chr(10) . $query, 'error');
            throw new Exception('Erro ao adicionar log');
        }
    }

    /**
     * Devolve registro de ações
     */
    public function getLogsByFiltros($tipo_id, $periodo_id, $obs, $funcionario_id = null, $limite = 25){
        try {
            $query = "SELECT l.log_id, l.log_tipo_id, t.log_tipo_nome, l.log_periodo_id, 
                             l.log_obs, DATE_FORMAT(l.log_data, '%d/%m/%Y %H:%i:%s') AS log_data
                        FROM reop_log l
                        JOIN reop_log_tipo t ON (t.log_tipo_id = l.log_tipo_id)
                       WHERE 1=1 ";

            if (!is_null($tipo_id)){
                $query .= " AND l.log_tipo_id = :tipo";
            }
            if (!is_null($periodo_id)){
                $query .= " AND l.log_periodo_id = :periodo";
            }
            if (!is_null($obs)){
                $query .= " AND l.log_obs LIKE :obs";
            }
            if (!is_null($funcionario_id)){
                $query .= " AND l.log_funcionario_id = :funcionario";
            }
            $query .= " ORDER BY l.log_id DESC LIMIT 0, ".$limite;

            $conexao = Database::getInstance()->prepare($query);
            if (!is_null($tipo_id)){
                $conexao->bindValue(':tipo', $tipo_id);
            }
            if (!is_null($periodo_id)){
                $conexao->bindValue(':periodo', $periodo_id);
            }
            if (!is_null($obs)){
                $conexao->bindValue(':obs', '%'.$obs.'%');
            }
            if (!is_null($funcionario_id)){
                $conexao->bindValue(':funcionario', $funcionario_id);
            }
            
            $conexao->execute();
            return $conexao->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            Erro::log("[DAO] " . get_class($this) . ' -> ' . $e->getMessage() . chr(10) . $query, 'error');
            throw new Exception($e->getMessage());
        }
    }
}
