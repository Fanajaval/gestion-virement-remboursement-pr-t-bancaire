<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    
    if ($role == "employe") {
        header("Location: inscription_employe.php");
    } elseif ($role == "admin") {
        header("Location: inscription_admin.php");
    } else {
        header("Location: inscription.php");
    }
    exit();
}
?>