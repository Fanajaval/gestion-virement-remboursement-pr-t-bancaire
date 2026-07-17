<?php
include 'db.php';
session_start();

if (isset($_GET['numCompte'])) {
    $numCompte = $_GET['numCompte'];
    $result = $conn->query("SELECT*FROM client WHERE numCompte='$numCompte'");
    $client = $result->fetch_assoc();
}

if (isset($_POST['modifier'])) {
    $numCompte = $_POST['numCompte'];
    $nom = $_POST['nom'];
    $prenoms = $_POST['prenoms'];
    $tel = $_POST['tel'];
    $mail = $_POST['mail'];
    $solde = $_POST['solde']; 

    $conn->query("UPDATE client SET Nom= '$nom', Prenoms= '$prenoms', Tel='$tel', mail='$mail', solde='$solde' WHERE numCompte= '$numCompte'");
    $_SESSION['success_message'] = "Client modifié avec succès !";
    header("Location: client_banq.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client</title>
    <link rel="stylesheet" href="client.css">
</head>
<body>
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>

    <div class="modal">
        <div id="addClientModal" class="modal-content">
            <span class="close" onclick="window.location='client_banq.php'">&times;</span>
            <h2>Modifier un Client</h2>
            <form action="modifier_client.php" method="post">
                <input type="hidden" name="numCompte" value="<?= htmlspecialchars($client['numCompte'])?>">

                <label>Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($client['Nom'])?>" required>

                <label>Prenoms</label>
                <input type="text" name="prenoms" value="<?= htmlspecialchars($client['Prenoms']) ?>" required>

                <label>Telephone</label>
                <input type="text" name="tel" value="<?= htmlspecialchars($client['Tel'])?>" required>

                <label>Email</label>
                <input type="email" name="mail" value="<?= htmlspecialchars($client['mail'])?>" required>

                <label>Solde</label>
                <input type="number" step="0.01" name="solde" value="<?= htmlspecialchars($client['solde'])?>" required> 

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