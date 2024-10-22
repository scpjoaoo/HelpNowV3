<?php
require_once 'UserHandler.php';
require_once 'UserNotifier.php';

class CadastroHandler extends UserHandler {
    private $username;
    private $email;
    private $password;
    private $telefone;
    private $notifier;

    public function __construct($username, $email, $password, $telefone) {
        parent::__construct();
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->telefone = $telefone;
        $this->notifier = new UserNotifier();
        $this->notifier->addObserver(new UserObserver());
    }

    protected function preProcess() {
        // Pré-processamento, como verificação de entradas
    }

    protected function process() {
        // Verificar se o usuário já existe
        $sql_check = "SELECT * FROM usuários WHERE Nome = ? OR Email = ?";
        $stmt_check = $this->conexao->prepare($sql_check);
        $stmt_check->bind_param('ss', $this->username, $this->email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $this->notifier->notify("Nome de usuário ou email já existente. Tente outro.");
        } else {
            // Inserir novo usuário
            $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuários (Nome, Email, Senha, Telefone) VALUES (?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('ssss', $this->username, $this->email, $hashed_password, $this->telefone);

            if ($stmt->execute()) {
                $this->notifier->notify("Cadastro realizado com sucesso!");
            } else {
                $this->notifier->notify("Erro ao cadastrar: " . $stmt->error);
            }
        }
    }

    protected function postProcess() {
        // Pós-processamento, como envio de email de boas-vindas
    }
}
?>
