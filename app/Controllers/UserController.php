<?php
// Inclut le modèle UserModel, qui contient les fonctions d'interaction avec la table des utilisateurs.
require_once __DIR__ . '/../models/UserModel.php';

// Définition de la classe UserController pour gérer les opérations liées aux utilisateurs.
class UserController {
    private $userModel; // Instance du modèle UserModel.

    // Constructeur : initialise le modèle UserModel avec la connexion à la base de données.
    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Ajouter un utilisateur.
    public function addUser() {
        // Vérifie si la requête est de type POST (formulaire soumis).
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données du formulaire.
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            // Crée un nouvel utilisateur via le modèle UserModel.
            if ($this->userModel->createUser($username, $email, $password, $role)) {
                // Redirige vers la liste des utilisateurs en cas de succès.
                header('Location: index.php?action=utilisateur');
                exit();
            } else {
                // Affiche un message d'erreur et inclut la vue d'ajout en cas d'échec.
                $error = "Erreur lors de la création de l'utilisateur.";
                require_once __DIR__ . '/../views/users/add.php';
            }
        } else {
            // Inclut la vue du formulaire d'ajout d'utilisateur si la requête n'est pas POST.
            require_once __DIR__ . '/../views/users/add.php';
        }
    }

    // Modifier un utilisateur.
    public function editUser($id) {
        // Vérifie si la requête est de type POST (formulaire soumis).
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données du formulaire.
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $is_active = isset($_POST['is_active']) ? 1 : 0; // Vérifie si la case à cocher 'is_active' est cochée.

            // Met à jour l'utilisateur via le modèle UserModel.
            if ($this->userModel->updateUser($id, $username, $email, $role, $is_active)) {
                // Redirige vers la liste des utilisateurs en cas de succès.
                header('Location: index.php?action=utilisateur');
                exit();
            } else {
                // Affiche un message d'erreur et inclut la vue d'édition en cas d'échec.
                $error = "Erreur lors de la modification de l'utilisateur.";
                require_once __DIR__ . '/../views/users/edit.php';
            }
        } else {
            // Récupère l'utilisateur par son ID via le modèle UserModel.
            $user = $this->userModel->getUserById($id);
            // Si l'utilisateur n'existe pas, redirige vers la liste des utilisateurs.
            if (!$user) {
                header('Location: index.php?action=utilisateur');
                exit();
            }
            // Inclut la vue du formulaire d'édition avec les données de l'utilisateur.
            require_once __DIR__ . '/../views/users/edit.php';
        }
    }

    // Activer/Désactiver un utilisateur.
    public function toggleUser($id) {
        // Récupère le statut 'is_active' à partir des paramètres GET.
        $is_active = $_GET['is_active'] ?? 0;
        // Met à jour le statut de l'utilisateur via le modèle UserModel.
        if ($this->userModel->toggleUserStatus($id, $is_active)) {
            // Redirige vers la liste des utilisateurs en cas de succès.
            header('Location: index.php?action=utilisateur');
            exit();
        } else {
            // Affiche un message d'erreur et inclut la vue de la liste des utilisateurs en cas d'échec.
            $error = "Erreur lors de la modification du statut de l'utilisateur.";
            require_once __DIR__ . '/../views/users/list.php';
        }
    }

    // Supprimer un utilisateur.
    public function deleteUser($id) {
        // Supprime l'utilisateur via le modèle UserModel.
        if ($this->userModel->deleteUser($id)) {
            // Redirige vers la liste des utilisateurs en cas de succès.
            header('Location: index.php?action=utilisateur');
            exit();
        } else {
            // Affiche un message d'erreur et inclut la vue de la liste des utilisateurs en cas d'échec.
            $error = "Erreur lors de la suppression de l'utilisateur.";
            require_once __DIR__ . '/../views/users/list.php';
        }
    }

    // Lister les utilisateurs.
    public function listUsers() {
        // Récupère tous les utilisateurs via le modèle UserModel.
        $users = $this->userModel->getAllUsers();
        // Inclut la vue de la liste des utilisateurs.
        require_once __DIR__ . '/../views/users/list.php';
    }

    // Lister l'historique des connexions (pour le dashboard)
    public function listLoginHistory() {
        // Récupère l'historique des connexions via le modèle UserModel.
        $history = $this->userModel->getLoginHistory();
        // Inclut la vue de l'historique des connexions (dans le dashboard).
        require_once __DIR__ . '../../Views/dashboard/sessions.php';
    }

    // Lister l'historique des connexions (pour le profil utilisateur)
    public function LoginHistory() {
        // Récupère l'historique des connexions via le modèle UserModel.
        $history = $this->userModel->getLoginHistory();
        // Inclut la vue de l'historique des connexions (via le profil utilisateur).
        require_once __DIR__ . '../../Views/users/history.php';
    }

    // Déconnexion de l'utilisateur.
    public function logoutuser() {
        // Démarre la session.
        session_start();
        // Supprime toutes les variables de session.
        session_unset();
        // Détruit la session.
        session_destroy();
        // Redirige vers la page de connexion.
        header('Location: index.php?action=login');
    }

    // Afficher le dashboard de l'utilisateur.
    public function dashboard() {
        // Démarre la session.
        session_start();
        // Vérifie si l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
            header('Location: index.php?action=login');
            exit();
        } else {
            // Inclut la vue du dashboard utilisateur.
            require_once __DIR__ . '../../Views/users/dashboard.php';
        }

        // Récupère les informations de l'utilisateur via le modèle UserModel.
        $user = $this->userModel->getUserById($_SESSION['user']['id']);
        // Vérifie si l'utilisateur existe.
        if (!$user) {
            // Redirige vers la page de connexion si l'utilisateur n'existe pas.
            header('Location: index.php?action=login');
            exit();
        }
    }

    // Afficher le formulaire de modification du profil.
    public function editProfile() {
        // Démarre la session.
        session_start();
        // Vérifie si l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
            header('Location: index.php?action=login');
            exit();
        }

        // Récupère les informations de l'utilisateur via le modèle UserModel.
        $user = $this->userModel->getUserById($_SESSION['user']['id']);
        // Inclut la vue du formulaire d'édition du profil.
        require_once __DIR__ . '../../Views/users/edit_profile.php';
    }

    // Traiter la modification du profil.
    public function updateProfile() {
        // Démarre la session.
        session_start();
        // Vérifie si l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
            header('Location: index.php?action=login');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];

        if ($this->userModel->updateProfile($_SESSION['user']['id'], $username, $email)) {
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
            header('Location: index.php?action=dashboard');
            exit();
        } else {
            $error = "Erreur lors de la mise à jour du profil.";
            require_once __DIR__ . '../../views/users/edit_profile.php';
        }
    }
}
}

?>