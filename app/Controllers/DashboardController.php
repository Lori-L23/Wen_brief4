<?php
// Inclut le modèle UserModel pour interagir avec la table des utilisateurs.
require_once __DIR__ . '/../models/UserModel.php';

// Définition de la classe DashboardController pour gérer les fonctionnalités du tableau de bord.
class DashboardController {
    private $userModel; // Instance du modèle UserModel.

    // Constructeur : initialise le modèle UserModel avec la connexion à la base de données.
    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Fonction pour afficher le tableau de bord de l'administrateur.
    public function dashboardAdmin() {
        // Inclut la vue du tableau de bord de l'administrateur.
        require_once __DIR__ . '/../views/dashboard/admin.php';
    }

    // Fonction pour gérer les utilisateurs (afficher la liste des utilisateurs).
    public function manageUsers() {
        // Récupère tous les utilisateurs via le modèle UserModel.
        $users = $this->userModel->getAllUsers();
        // Inclut la vue pour afficher la liste des utilisateurs.
        require_once __DIR__ . '/../views/dashboard/users.php';
    }

    // Fonction pour afficher l'historique des connexions.
    public function loginHistory() {
        // Récupère l'historique des connexions via le modèle UserModel.
        $history = $this->userModel->getLoginHistory();
        // Inclut la vue pour afficher l'historique des connexions.
        require_once __DIR__ . '/../views/dashboard/sessions.php';
    }

    // Fonction pour la déconnexion de l'utilisateur.
    public function logout() {
        // Démarre la session (si elle n'est pas déjà démarrée).
        session_start();
        // Détruit toutes les données de la session.
        session_destroy();
        // Redirige l'utilisateur vers la page de connexion.
        header('Location: index.php?action=login');
        // Termine l'exécution du script après la redirection.
        exit();
    }
}
?>