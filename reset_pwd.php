<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header("Location: reset_pwd.php");
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header("Location: reset_pwd.php");
        exit();
    }

    //verification s'il y a email
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $update_stmt = $conn->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $new_password, $email);
        if ($update_stmt->execute()) {
            $_SESSION['success'] = "Votre mot de passe a été réinitialisé avec succès.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour du mot de passe.";
        }
    } else {
        $_SESSION['error'] = "Aucun compte trouvé avec cet e-mail.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
   <link rel="stylesheet" href="reset_pwd.css">
</head>
<body>

<div class="container">
    <h2>Réinitialisation du mot de passe</h2>
    
    <?php if(isset($_SESSION['error'])): ?>
        <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="reset_pwd.php" method="post">
        <input type="email" name="email" placeholder="Votre e-mail" required>
        <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
        <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>
        <button type="submit">Réinitialiser</button>
    </form>
</div>

</body>
</html>