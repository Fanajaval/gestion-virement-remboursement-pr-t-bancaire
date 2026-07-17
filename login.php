<?php
session_start();
include 'db.php';

// Raha avy nanao logout ilay utilisateur, dia aseho ny message
if (isset($_SESSION['logout_message'])) {
    $message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']); // Fafàna ilay message rehefa aseho indray mandeha
}

// Raha efa tafiditra dia alefa any amin'ny accueil
if (isset($_SESSION["utilisateur"])) {
    header("Location: head.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = $conn->prepare("SELECT * from utilisateur where email=? and mot_de_passe=?");
    $query->bind_param("ss", $email, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['utilisateur'] = $user;
        header("Location: head.php");
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - BankOnline</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="debut">
        <div class="head">
            <div class="login">
                <span>Connexion</span>
            </div>

            <?php if (isset($message)): ?>
                <p class="flash-message success"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <p class="flash-message error"><?= htmlspecialchars($error) ?></p>
                <script>
                    alert("<?= htmlspecialchars($error) ?>");
                </script>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="input">
                    <input type="email" id="user" name="email" class="input1" required>
                    <label for="user" class="label">Email</label>
                </div>

                <div class="input">
                    <input type="password" id="pass" name="password" class="input1" required>
                    <label for="pass" class="label">Mot de passe</label>
                </div>

                <div class="password">
                    <div class="forgot">
                        <a href="forgot_pwd.php">Mot de passe oublié?</a>
                    </div>
                </div>

                <div class="input">
                    <input type="submit" class="input-submit" value="Se connecter">
                </div>

                <div class="inscription">
                    <a href="inscription.php"><span>Vous n'avez pas un compte?</span></a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>