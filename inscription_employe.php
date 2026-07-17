<?php
session_start();
include 'db.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Employé</title>
    <link rel="stylesheet" href="insc_empl_adm.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Inscription Employé</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <form action="traitement.php" method="post">
                <input type="hidden" name="role" value="employe">
                
                <div class="input-box">
                    <label>Identifiant</label>
                    <input type="text" name="id" required>
                </div>

                <div class="input-box">
                    <label>Nom complet</label>
                    <input type="text" name="nom" required>
                </div>

                <div class="input-box">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-box">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" required>
                </div>

                <button type="submit" class="btn">S'inscrire</button>
            </form>
            <p class="return"><a href="inscription.php">Retour</a></p>
        </div>
    </div>
</body>
</html>