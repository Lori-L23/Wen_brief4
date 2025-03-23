<?php
require_once __DIR__ . '/../models/UserModel.php';

class DashboardController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Afficher le tableau de bord admin
    public function dashboardAdmin() {
        // Vérifier si l'utilisateur est un admin (exemple)
        // if (!Auth::isAdmin()) {
        //     header('Location: index.php?action=login');
        //     exit();
        // }

        require_once __DIR__ . '/../views/dashboard/admin.php';
    }

    // Gérer les utilisateurs
    public function manageUsers() {
        $users = $this->userModel->getAllUsers();
        require_once __DIR__ . '/../views/dashboard/users.php';
    }

    // Afficher l'historique des connexions
    public function loginHistory() {
        $history = $this->userModel->getLoginHistory();
        require_once __DIR__ . '/../views/dashboard/sessions.php';
    }

    // Déconnexion
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}
?>