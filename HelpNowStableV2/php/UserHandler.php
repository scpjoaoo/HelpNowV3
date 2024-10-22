<?php
require_once 'Conexao.php'; // Certifique-se de que este caminho está correto

abstract class UserHandler {
    protected $conexao;

    public function __construct() {
        $this->conexao = Conexao::getInstance()->getConexao();
    }

    public function handleUser() {
        $this->preProcess();
        $this->process();
        $this->postProcess();
    }

    protected abstract function preProcess();
    protected abstract function process();
    protected abstract function postProcess();
}
