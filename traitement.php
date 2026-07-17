<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];

    //verification si email existe déja
    $check_email = $conn->prepare("SELECT id FROM utilisateur WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        $_SESSION['error'] = "Cet email est déjà utilisé.";
        header("Location: inscription_" . $role . ".php");
        exit();
    }

    $check_id = $conn->prepare("SELECT id from utilisateur where id = ?");
    $check_id->bind_param("s", $id);
    $check_id->execute();
    $check_id->store_result();

    if ($check_id->num_rows > 0) {
        $_SESSION['error'] = "Cet identifiant est déjà utilisé.";
        header("Location: inscription_" . $role . ".php");
        exit();
    }

    // verifier si l'ID suit le format requis
    if (($role == "employe" && !preg_match("/^EMP\d{3}$/", $id)) ||
        ($role == "admin" && !preg_match("/^ADM\d{3}$/", $id))) {
        $_SESSION['error'] = "Inscription refusée : Identité non reconnue.";
        header("Location: inscription_" . $role . ".php");
        exit();
    }

    // Insértion données
    $stmt = $conn->prepare("INSERT INTO utilisateur (id, nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $nom, $email, $mot_de_passe, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Inscription réussie ! Connectez-vous.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Une erreur est survenue. Réessayez.";
        header("Location: inscription_" . $role . ".php");
    }
    exit();
}
?>