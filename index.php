<?php
// Simple Router for User Frontend
session_start(); // Initialize session for Shopping Cart

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/CartController.php';

$controllerType = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($controllerType == 'cart') {
    $controller = new CartController();
} else {
    $controller = new HomeController();
}

// Ensure the action exists before calling it
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>
