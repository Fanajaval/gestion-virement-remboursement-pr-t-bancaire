<?php
session_start();
include 'db.php';
require_once 'config_email.php';

$message_info = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    //verifier si email existe
    $query = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        //génération jeton sécurisé de 6 caractères
        $token = bin2hex(random_bytes(3));
        $expires_at = date("Y-m-d H:i:s", time() + 600);

        // suppression anciens jetons
        $delete_query = $conn->prepare("DELETE FROM jetons_reinit WHERE email = ?");
        $delete_query->bind_param("s", $email);
        $delete_query->execute();

        //nouveau jeton
        $insert_query = $conn->prepare("INSERT INTO jetons_reinit (email, jeton, expiration) VALUES (?, ?, NOW() + INTERVAL 10 MINUTE)");
        $insert_query->bind_param("ss", $email, $token);
        if ($insert_query->execute()) {
            $_SESSION['reset_token'] = $token;
            $_SESSION['reset_email'] = $email;
            
            // Tentative d'envoi d'email si activé
            if (EMAIL_ENABLED) {
                $sujet = "Réinitialisation de votre mot de passe - BankOnline";
                $message = "Bonjour,\n\n";
                $message .= "Vous avez demandé à réinitialiser votre mot de passe.\n\n";
                $message .= "Votre code de vérification est : " . $token . "\n\n";
                $message .= "Ce code est valide pendant 10 minutes.\n\n";
                $message .= "Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.\n\n";
                $message .= "Cordialement,\nL'équipe BankOnline";
                
                $result_email = envoyer_email($email, '', $sujet, $message);
                
                if ($result_email['success']) {
                    $_SESSION['message_info'] = "Un email contenant le jeton de réinitialisation a été envoyé à votre adresse.";
                } else {
                    $_SESSION['message_info'] = "Jeton généré mais l'email n'a pas pu être envoyé. Le jeton apparaîtra dans 20 secondes...";
                }
            } else {
                $_SESSION['message_info'] = "Un jeton de réinitialisation a été généré. Il apparaîtra dans 20 secondes...";
            }

            header("Location: forgot_pwd.php?show_token=1");
            exit();
        } else {
            $error = "Erreur lors de la création du jeton. Veuillez réessayer.";
        }
    } else {
        $error = "Adresse e-mail non trouvée.";
    }
}

// afficher le message sauvegardé en session
if (isset($_SESSION['message_info'])) {
    $message_info = $_SESSION['message_info'];
    unset($_SESSION['message_info']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="forgot_pwd.css">
</head>
<body>
    <div class="container">
        <h2>Réinitialisation du mot de passe</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="email" name="email" required>
                <label>Email :</label>
            </div>
                <button class="button" type="submit">Envoyer le jeton</button>
        </form>
        <div class="message" id="message"></div>
    </div>
        <?php if (!empty($message_info)): ?>
        <p style="color: white; font-size: 20px; font-weight: bold;"><?= htmlspecialchars($message_info) ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['show_token']) && isset($_SESSION['reset_token'])): ?>
            <script>
            setTimeout(function() {
                alert("Votre jeton de réinitialisation : <?= $_SESSION['reset_token'] ?>");
                window.location.href = 'enter_token.php';
            }, 20000);
            </script>
        <?php endif; ?>
    </div>
</body>
</html>