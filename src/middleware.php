<?php
function authenticate() {
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
        exit();
    }
}

function authorizeAdmin() {
    authenticate();
    if ($_SESSION['user']['role'] !== 'admin') {
        header('Location: ../unauthorized.php');
        exit();
    }
}
