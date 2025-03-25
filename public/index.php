<?php
// Inclusion des fichiers nécessaires
require_once __DIR__ . '../../app/core/auth.php';          // Fonctions d'authentification de base
require_once __DIR__ . '../../app/Controllers/AuthController.php';       // Contrôleur d'authentification
require_once __DIR__ . '../../app/controllers/DashboardController.php'; // Contrôleur du tableau de bord
require_once __DIR__ . '../../app/controllers/UserController.php';      // Contrôleur utilisateur
require_once __DIR__ . '../../app/controllers/LoginHistoryController.php'; // Contrôleur d'historique de connexion

// Récupération de l'action demandée (avec 'login' comme valeur par défaut)
$action = $_GET['action'] ?? 'login';

// Connexion à la base de données MySQL
$db = new PDO('mysql:host=localhost;dbname=gestion_utilisateurs', 'root', '');

// Initialisation des contrôleurs
$authController = new AuthController($db);
$dashboardController = new DashboardController($db);
$userController = new UserController($db);
$loginHistoryController = new loginHistoryController($db);

// Routeur principal - Gestion des différentes actions
switch ($action) {
    // Actions d'authentification
    case 'login':
        $authController->login();          // Affiche le formulaire de connexion
        break;
    case 'logout':
        $authController->logout();         // Déconnexion de l'utilisateur
        break;
    case 'register':
        $authController->register();       // Affiche le formulaire d'inscription
        break;

    // Actions pour l'administration (tableau de bord)
    case 'dashboardadmin':
        $dashboardController->dashboardAdmin();  // Tableau de bord admin
        break;
    case 'utilisateur':
        $dashboardController->manageUsers();     // Gestion des utilisateurs
        break;
    case 'sessions':
        $dashboardController->loginHistory();     // Historique des connexions
        break;

    // Actions de gestion des utilisateurs
    case 'addUser':
        $userController->addUser();        // Ajout d'un utilisateur
        break;
    case 'edit':
        $id = $_GET['id'];                // Récupère l'ID depuis l'URL
        $userController->editUser($id);    // Édition d'un utilisateur
        break;
    case 'toggleUser':
        $id = $_GET['id'];                // Active/désactive un utilisateur
        $userController->toggleUser($id);
        break;
    case 'deleteUser':
        $id = $_GET['id'];                // Suppression d'un utilisateur
        $userController->deleteUser($id);
        break;

    // Actions pour les utilisateurs normaux
    case 'utilisateuruser':
        $userController->listUsers();      // Liste des utilisateurs (vue user)
        break;
    case 'logoutuser':
        $userController->logoutuser();     // Déconnexion (vue user)
        break;
    case 'dashboard':
        $userController->dashboard();      // Tableau de bord utilisateur
        break;
    case 'editProfile':
        $userController->editProfile();    // Édition du profil
        break;
    case 'updateProfile':
        $userController->updateProfile();  // Mise à jour du profil
        break;

    // Historique des connexions
    case 'loginHistory':
        $loginHistoryController->showHistory(); // Affichage de l'historique
        break;

    // Action par défaut si aucune route ne correspond
    default:
        header('HTTP/1.0 404 Not Found'); // En-tête HTTP 404
        echo 'Page not found';             // Message d'erreur
        break;
}