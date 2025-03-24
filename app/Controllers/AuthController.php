<?php
// Inclut les modèles nécessaires et le fichier d'authentification.
require_once __DIR__ . '/../models/UserModel.php'; // Modèle pour gérer les utilisateurs.
require_once __DIR__ . '/../models/LoginHistoryModel.php'; // Modèle pour l'historique de connexion.
require_once __DIR__ . '/../core/auth.php'; // Fichier contenant des fonctions d'authentification (non visible ici).

// Définition de la classe AuthController pour gérer l'authentification.
class AuthController {
    private $db; // Instance de la base de données.
    private $userModel; // Instance du modèle UserModel.
    private $loginHistoryModel; // Instance du modèle LoginHistoryModel.

    // Constructeur : initialise les modèles et la connexion à la base de données.
    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
        $this->loginHistoryModel = new LoginHistoryModel($db);
    }

    // Fonction de connexion (login).
    public function login() {
        session_start(); // Démarre la session.
        $error = null; // Initialise la variable d'erreur.

        // Vérifie si la requête est de type POST (formulaire soumis).
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Sanitize l'email pour prévenir les injections.
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                // Récupère le mot de passe ou une chaîne vide s'il n'est pas défini.
                $password = $_POST['password'] ?? '';

                // Validation des entrées.
                if (empty($email)) {
                    throw new Exception("L'email est requis");
                }
                if (empty($password)) {
                    throw new Exception("Le mot de passe est requis");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Format d'email invalide");
                }

                // Authentifie l'utilisateur via le modèle UserModel.
                $user = $this->userModel->authenticate($email, $password);

                // Si l'authentification échoue, lance une exception.
                if (!$user) {
                    throw new Exception("Identifiants incorrects");
                }

                // Protection contre les attaques de fixation de session.
                session_regenerate_id(true);

                // Stocke les informations de l'utilisateur dans la session.
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role_id' => $user['role_id']
                ];

                // Enregistre le log de connexion via le modèle LoginHistoryModel.
                if (!$this->loginHistoryModel->logLogin($user['id'])) {
                    // Si l'enregistrement échoue, enregistre une erreur dans le log.
                    error_log("Failed to log login for user ID: " . $user['id']);
                    // Ne pas bloquer l'utilisateur pour cette erreur.
                }

                // Redirection sécurisée vers le dashboard approprié.
                $redirect = ($user['role_id'] == 1) ? 'dashboardadmin' : 'dashboard';
                $this->safeRedirect("index.php?action=$redirect");

            } catch (Exception $e) {
                // Capture les exceptions et affiche le message d'erreur.
                $error = $e->getMessage();
                // Enregistre l'erreur dans le log.
                error_log("Login error for email: $email - " . $e->getMessage());
            }
        }

        // Inclut la vue du formulaire de connexion.
        require_once __DIR__ . '../../views/login.php';
    }

    // Fonction de déconnexion (logout).
    public function logout() {
        session_start(); // Démarre la session.

        // Efface toutes les données de session.
        $_SESSION = [];

        // Supprime le cookie de session.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy(); // Détruit la session.
        $this->safeRedirect('index.php?action=login'); // Redirige vers la page de connexion.
    }

    // Fonction d'inscription (register).
    public function register() {
        $error = null; // Initialise la variable d'erreur.

        // Vérifie si la requête est de type POST.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Sanitize les entrées.
                $username = trim($_POST['username'] ?? '');
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'] ?? '';
                $role_id = (int)($_POST['role_id'] ?? 2); // Default to 'user' role

                // Validation des entrées.
                if (empty($username)) {
                    throw new Exception("Le nom d'utilisateur est requis");
                }
                if (empty($email)) {
                    throw new Exception("L'email est requis");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Format d'email invalide");
                }
                if (strlen($password) < 8) {
                    throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
                }

                // Vérifie si l'email existe déjà.
                if ($this->userModel->getUserByEmail($email)) {
                    throw new Exception("Cet email est déjà utilisé");
                }

                // Crée l'utilisateur via le modèle UserModel.
                if ($this->userModel->createUser($username, $email, $password, $role_id)) {
                    $this->safeRedirect('index.php?action=login'); // Redirige vers la page de connexion.
                } else {
                    throw new Exception("Erreur lors de la création du compte");
                }

            } catch (Exception $e) {
                // Capture les exceptions et affiche le message d'erreur.
                $error = $e->getMessage();
                // Enregistre l'erreur dans le log.
                error_log("Registration error: " . $e->getMessage());
            }
        }

        // Inclut la vue du formulaire d'inscription.
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // Fonction de redirection sécurisée.
    private function safeRedirect($url) {
        // Sanitize l'URL pour prévenir les attaques d'en-tête.
        $cleanUrl = filter_var($url, FILTER_SANITIZE_URL);
        header("Location: $cleanUrl");
        exit();
    }
}
?>