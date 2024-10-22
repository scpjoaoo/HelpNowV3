<?php
class UserNotifier {
    private $observers = [];

    public function addObserver($observer) {
        $this->observers[] = $observer;
    }

    public function notify($message) {
        foreach ($this->observers as $observer) {
            $observer->update($message);
        }
    }
}

class UserObserver {
    public function update($message) {
        // Lógica de notificação, como exibir uma mensagem ao usuário
    }
}

?>