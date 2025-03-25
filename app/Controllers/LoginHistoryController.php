<?php
// Inclut le modèle LoginHistoryModel pour gérer l'historique de connexion.
require_once __DIR__ . '/../models/LoginHistoryModel.php';
// Inclut le modèle UserModel, potentiellement utilisé pour des opérations liées aux utilisateurs.
require_once __DIR__ . '/../models/UserModel.php';

// Définition de la classe LoginHistoryController pour gérer les opérations liées à l'historique de connexion.
class LoginHistoryController {
    private $loginHistoryModel; // Instance du modèle LoginHistoryModel.
    private $userModel; // Instance du modèle UserModel.

    // Constructeur : initialise les modèles LoginHistoryModel et UserModel avec la connexion à la base de données.
    public function __construct($db) {
        $this->loginHistoryModel = new LoginHistoryModel($db);
        $this->userModel = new UserModel($db);
    }

    // Fonction pour afficher l'historique des connexions.
    public function showHistory() {
        // Démarre la session (si elle n'est pas déjà démarrée).
        session_start();

        // Vérifie si l'utilisateur est connecté (si la variable de session 'user' est définie).
        if (!isset($_SESSION['user'])) {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion.
            header('Location: index.php?action=login');
            // Termine l'exécution du script après la redirection.
            exit();
        }

        // Récupère l'historique des connexions via le modèle LoginHistoryModel.
        $history = $this->loginHistoryModel->getLoginHistory();
        // Inclut la vue pour afficher l'historique des connexions.
        require_once __DIR__ . '../../Views/users/history.php';
    }

    // Fonction pour enregistrer une connexion (à appeler après une connexion réussie).
    public function logLogin($user_id) {
        // Appelle la fonction logLogin du modèle LoginHistoryModel pour enregistrer la connexion.
        return $this->loginHistoryModel->logLogin($user_id);
    }
}
?>