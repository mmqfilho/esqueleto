<?php
/**
 * Model Exemplo
 */
class ExemploModel extends Model
{
    /**
     * var
     */
    private $id;
    private $nome;

    /**
     * constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Getters and Setters
     */
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; }
}
