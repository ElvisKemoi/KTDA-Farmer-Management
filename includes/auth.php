<?php

function authorizeRole($allowedRoles) {
    if (!isset($_SESSION['role'])) {
        // User not logged in or session expired
        header("Location: index.html"); // or show an error
        exit();
    }

    $userRole = $_SESSION['role'];

    // Convert to array if a single role is passed
    if (!is_array($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    if (!in_array($userRole, $allowedRoles)) {
        // Role not allowed
        header("Location: ./logout.php"); 
        exit();

    }
}
