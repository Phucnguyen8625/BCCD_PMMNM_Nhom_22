<?php
// Simple Router for User Frontend
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/phuc_modules/helpers/vnpay.php';
require_once __DIR__ . '/config/database.php';

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/CheckoutController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/SearchController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/UserOrderController.php';
require_once __DIR__ . '/controllers/CollectionController.php';

$controllerType = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($controllerType == 'auth') {
    $controller = new AuthController();
} else if ($controllerType == 'cart') {
    $controller = new CartController();
} else if ($controllerType == 'checkout') {
    $controller = new CheckoutController();
} else if ($controllerType == 'search') {
    $controller = new SearchController();
} else if ($controllerType == 'category') {
    $controller = new CategoryController();
} else if ($controllerType == 'profile') {
    $controller = new ProfileController();
} else if ($controllerType == 'userorder') {
    $controller = new UserOrderController();
} else if ($controllerType == 'collection') {
    $controller = new CollectionController();
} else {
    $controller = new HomeController();
}

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>
