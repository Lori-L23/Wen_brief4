<?php
require_once __DIR__ . '../../app/core/auth.php';
require_once __DIR__ . '../../app/Controllers/AuthController.php';
require_once __DIR__ . '../../app/controllers/DashboardController.php';


$action = $_GET['action'] ?? 'login';

$db = new PDO('mysql:host=localhost;dbname=gestion_utilisateurs', 'root', '');

$authController = new AuthController($db);
$dashboardController = new DashboardController($db);


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
    // case 'logout':
    //     $dashboardController->logout();
    //     break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo 'Page not found';
        break;
}
