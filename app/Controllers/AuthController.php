<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->authenticate($email, $password);

            if ($user) {
                // Démarrer la session et rediriger vers le tableau de bord
                session_start();
                $_SESSION['user'] = $user;
                header('Location: index.php?action=dashboardadmin');
                exit();
            } else {
                // Afficher un message d'erreur
                $error = "Email ou mot de passe incorrect.";
                require_once __DIR__ . '../../views/login.php';
            }
        } else {
            require_once __DIR__ . '../../views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifier si l'email est déjà utilisé
            $existingUser = $this->userModel->getUserByEmail($email);
            if ($existingUser) {
                $error = "Cet email est déjà utilisé.";
                require_once __DIR__.  '../../Views/regiter.php';
                return;
            }

            // Créer un nouvel utilisateur
            if ($this->userModel->createUser($username, $email, $password)) {
                // Rediriger vers la page de connexion après l'inscription
                header('Location: index.php?action=login');
                exit();
            } else {
                $error = "Une erreur s'est produite lors de l'inscription.";
                require_once __DIR__ . '../../views/register.php';
            }
        } else {
            require_once __DIR__ . '../../Views/regiter.php';
        }
    }
}
?>