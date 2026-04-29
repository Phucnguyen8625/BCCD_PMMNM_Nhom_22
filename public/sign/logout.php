<?php
require_once __DIR__ . '/../../config/webConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['user_login']);
unset($_SESSION['user_token']);
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
unset($_SESSION['user']);

header('Location: ' . BASE_URL . '/public/sign/up/login.php');
exit;
