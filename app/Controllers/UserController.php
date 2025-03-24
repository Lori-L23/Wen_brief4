<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

 // Ajouter un utilisateur
 public function addUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if ($this->userModel->createUser($username, $email, $password, $role)) {
            header('Location: index.php?action=utilisateur');
            exit();
        } else {
            $error = "Erreur lors de la création de l'utilisateur.";
            require_once __DIR__ . '/../views/users/add.php';
        }
    } else {
        require_once __DIR__ . '/../views/users/add.php';
    }
}

// Modifier un utilisateur
public function editUser($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($this->userModel->updateUser($id, $username, $email, $role, $is_active)) {
            header('Location: index.php?action=utilisateur');
            exit();
        } else {
            $error = "Erreur lors de la modification de l'utilisateur.";
            require_once __DIR__ . '/../views/users/edit.php';
        }
    } else {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            header('Location: index.php?action=utilisateur');
            exit();
        }
        require_once __DIR__ . '/../views/users/edit.php';
    }
}

// Activer/Désactiver un utilisateur
public function toggleUser($id) {
    $is_active = $_GET['is_active'] ?? 0;
    if ($this->userModel->toggleUserStatus($id, $is_active)) {
        header('Location: index.php?action=utilisateur');
        exit();
    } else {
        $error = "Erreur lors de la modification du statut de l'utilisateur.";
        require_once __DIR__ . '/../views/users/list.php';
    }
}

// Supprimer un utilisateur
public function deleteUser($id) {
    if ($this->userModel->deleteUser($id)) {
        header('Location: index.php?action=utilisateur');
        exit();
    } else {
        $error = "Erreur lors de la suppression de l'utilisateur.";
        require_once __DIR__ . '/../views/users/list.php';
    }
}

// Lister les utilisateurs
public function listUsers() {
    $users = $this->userModel->getAllUsers();
    require_once __DIR__ . '/../views/users/list.php';
}

// Lister l'historique des connexions
public function listLoginHistory() {
    $history = $this->userModel->getLoginHistory();
    require_once __DIR__ . '../../Views/dashboard/sessions.php';
}
public function LoginHistory() {
    $history = $this->userModel->getLoginHistory();
    require_once __DIR__ . '../../Views/users/history.php';
}

// Déconnexion
public function logoutuser() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
}


 // Afficher le dashboard de l'utilisateur
 public function dashboard() {
    session_start(); // Démarrer la session
    if (!isset($_SESSION['user'])) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header('Location: index.php?action=login');
        exit();
    }
    else{
        require_once __DIR__ . '../../Views/users/dashboard.php';

    }

    // Récupérer les informations de l'utilisateur
    $user = $this->userModel->getUserById($_SESSION['user']['id']);
    if (!$user) {
        // Rediriger si l'utilisateur n'existe pas
        header('Location: index.php?action=login');
        exit();
    }
}

// Afficher le formulaire de modification du profil
public function editProfile() {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?action=login');
        exit();
    }

    $user = $this->userModel->getUserById($_SESSION['user']['id']);
    require_once __DIR__ . '../../Views/users/edit_profile.php';
}

// Traiter la modification du profil
public function updateProfile() {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?action=login');
        exit();
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