<?php
session_start();
include 'db.php';

$conn->query("SET time_zone = '+02:00'");
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = trim($_POST['token']);

    $query = $conn->prepare("SELECT email FROM jetons_reinit WHERE jeton = ? AND expiration > NOW() AND utilise = 0");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['reset_email'] = $row['email'];
        
        header("Location: reset_pwd.php");
        exit();
    } else {
        $error = "Jeton invalide ou expiré. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrer le jeton</title>
    <link rel="stylesheet" href="enter_token.css">
</head>
<body>
    <div class="container">
        <h2>Vérification du jeton</h2>

        <?php if (!empty($error)): ?>
            <p class="error-message" style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="token" required>
                <label for="token">Entrez le jeton reçu</label>
            </div>
                <button class="button" type="submit">Valider</button>
        </form>
    </div>
</body>
</html>