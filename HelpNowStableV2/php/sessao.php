<?php
class Sessao {
    public function __construct() {
        session_start();
    }

    public function iniciarSessao($userId, $userName) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $userName;
    }

    public function encerrarSessao() {
        session_destroy();
    }

    public function isSessaoAtiva() {
        return isset($_SESSION['user_id']);
    }

    public function getNomeUsuario() {
        return $this->isSessaoAtiva() ? $_SESSION['user_name'] : null;
    }
}
?>
