<?php
session_start();
include 'db.php';

$pret = null;

if (isset($_GET['num_pret']) && isset($_GET['numCompte'])) {
    $num_pret = $_GET['num_pret'];
    $numCompte = $_GET['numCompte'];

    $result = $conn->query("SELECT * FROM preter WHERE num_pret='$num_pret' AND numCompte='$numCompte'");
    $pret = $result->fetch_assoc();

    if (!$pret) {
        $_SESSION['error_message'] = "Prêt introuvable !";
        header("Location: preter.php");
        exit();
    }
}

if (isset($_POST['modifier'])) {
    $num_pret = $_POST['num_pret'];
    $numCompte = $_POST['numCompte'];
    $nouveau_montant = $_POST['montant_prete'];
    $datepret = $_POST['datepret'];

    $query_old = $conn->query("SELECT montant_prete FROM preter WHERE num_pret='$num_pret' AND numCompte='$numCompte'");
    $row = $query_old->fetch_assoc();
    $ancien_montant = $row['montant_prete'];

    $ancien_montant_net = $ancien_montant * 0.90;
    $conn->query("UPDATE client SET solde = solde - $ancien_montant_net WHERE numCompte = '$numCompte'");

    $nouveau_montant_net = $nouveau_montant * 0.90;
    $conn->query("UPDATE client SET solde = solde + $nouveau_montant_net WHERE numCompte = '$numCompte'");

    $conn->query("UPDATE preter SET montant_prete= '$nouveau_montant', datepret= '$datepret' WHERE num_pret= '$num_pret' AND numCompte= '$numCompte'");

    $_SESSION['success_message'] = "Modification réussie !";
    
    header("Location: preter.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Prêt</title>
    <link rel="stylesheet" href="preter.css">
</head>
<body>
    <div class="modal">
        <div id="modifierPretModal" class="modal-content">
            <span class="close" onclick="window.location='preter.php'">&times;</span>
            <h2>Modifier un Prêt</h2>
            <form action="modifier_pret.php" method="post">
                <input type="hidden" name="num_pret" value="<?= htmlspecialchars($pret['num_pret']) ?>">
                <input type="hidden" name="numCompte" value="<?= htmlspecialchars($pret['numCompte']) ?>">

                <label>Numéro du prêt</label>
                <input type="text" value="<?= htmlspecialchars($pret['num_pret']) ?>" readonly>

                <label>Numéro du compte</label>
                <input type="text" value="<?= htmlspecialchars($pret['numCompte']) ?>" readonly>

                <label>Montant prêté</label>
                <input type="number" name="montant_prete" value="<?= htmlspecialchars($pret['montant_prete']) ?>" required>

                <label>Date du prêt</label>
                <input type="date" name="datepret" value="<?= htmlspecialchars($pret['datepret']) ?>" required>

                <button type="submit" name="modifier" class="btn">Enregistrer</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector(".modal").style.display = "block";
        });
    </script>
</body>
</html>