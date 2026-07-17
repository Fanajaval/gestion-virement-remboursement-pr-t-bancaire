<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'admin';

    $check = $conn->prepare("SELECT id from users where email = ?");
    $check->bind_parm("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email déjà utilisé!); window.location='register.php';</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (nom, email, password, role) values (?, ?, ?, ?)");
    $stmt->bind_parm("ssss", $nom, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<script>alert("Admin enregitré avec succés!"); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'inscription');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription Admin</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="container">
        <h2>inscription Admin</h2>
        <form action="register.php" method="post">
            <label for="">Nom</label>
            <input type="text" name="nom" required>

            <label for="">Email</label>
            <input type="text" name="email" required>

            <label for="">Mot de passe</label>
            <input type="password" name="password" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>