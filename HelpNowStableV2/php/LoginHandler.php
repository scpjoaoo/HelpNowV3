<?php
require_once 'UserHandler.php';
require_once 'UserNotifier.php';

class LoginHandler extends UserHandler {
    private $email;
    private $password;
    private $notifier;

    public function __construct($email, $password) {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
        $this->notifier = new UserNotifier();
        $this->notifier->addObserver(new UserObserver());
    }

    protected function preProcess() {
        // Pré-processamento, como sanitização de entrada
    }

    protected function process() {
        $sql = "SELECT * FROM usuários WHERE Email = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($this->password, $user['Senha'])) {
                // Login bem-sucedido
                session_start();
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['user_name'] = $user['Nome'];
                echo json_encode(["status" => "success", "message" => "Login realizado com sucesso!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Senha incorreta."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Usuário não encontrado."]);
        }
    }

    protected function postProcess() {
        // Pós-processamento, como registro de atividades
    }
}
?>
