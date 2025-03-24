<?php
require_once __DIR__ . '../../app/core/auth.php';
require_once __DIR__ . '../../app/Controllers/AuthController.php';
require_once __DIR__ . '../../app/controllers/DashboardController.php';
require_once __DIR__ . '../../app/controllers/UserController.php';



$action = $_GET['action'] ?? 'login';

$db = new PDO('mysql:host=localhost;dbname=gestion_utilisateurs', 'root', '');

$authController = new AuthController($db);
$dashboardController = new DashboardController($db);
$userController = new UserController($db);



switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;

    case 'register':
        $authController->register();
        break;

    case 'dashboardadmin':
        $dashboardController->dashboardAdmin();
        break;
    case 'utilisateur':
        $dashboardController->manageUsers();
        break;
    case 'sessions':
        $dashboardController->loginHistory();
        break;

    case 'addUser':
        $userController->addUser();
        break;
    case 'edit':
        $id = $_GET['id'];
        $userController->editUser($id);
        break;
    case 'toggleUser':
        $id = $_GET['id'];
        $userController->toggleUser($id);
        break;
    case 'deleteUser':
        $id = $_GET['id'];
        $userController->deleteUser($id);
        break;
    case 'utilisateuruser':
        $userController->listUsers();
        break;
    case 'logoutuser':
        $userController->logoutuser();
        break;
    case 'dashboard':
        $userController->dashboard();
        break;
    case 'editProfile':
        $userController->editProfile();
        break;
    case 'updateProfile':
        $userController->updateProfile();
        break;
    case 'loginHistory':
        $userController->loginHistory();
        break;
        // case 'logoutuser':
        //     $userController->logout();
        //     break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo 'Page not found';
        break;
}
