<?php
require_once __DIR__ . '/../models/LoginHistoryModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class LoginHistoryController {
    private $loginHistoryModel;
    private $userModel;

    public function __construct($db) {
        $this->loginHistoryModel = new LoginHistoryModel($db);
        $this->userModel = new UserModel($db);
    }

    // Afficher l'historique des connexions
    public function showHistory() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }

        $history = $this->loginHistoryModel->getLoginHistory();
        require_once __DIR__ . '../../Views/users/history.php';
    }

    // Enregistrer une connexion (à appeler après une connexion réussie)
    public function logLogin($user_id) {
        return $this->loginHistoryModel->logLogin($user_id);
    }
}
?>