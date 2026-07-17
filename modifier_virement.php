<?php
include 'db.php';
session_start();

$virement = null;

if (isset($_GET['numCompte_expediteur']) && isset($_GET['numCompte_beneficiaire'])) {
    $numCompte_expediteur = $_GET['numCompte_expediteur'];
    $numCompte_beneficiaire = $_GET['numCompte_beneficiaire'];

    $result = $conn->query("SELECT * FROM virement WHERE numCompte_expediteur='$numCompte_expediteur' AND numCompte_beneficiaire='$numCompte_beneficiaire'");
    $virement = $result->fetch_assoc();

    if (!$virement) {
        echo "<script>alert('Virement introuvable !'); window.location='virement.php';</script>";
        exit();
    }
}

if (isset($_POST['modifier'])) {
    $numCompte_expediteur = $_POST['numCompte_expediteur'];
    $numCompte_beneficiaire = $_POST['numCompte_beneficiaire'];
    $nouveau_montant = $_POST['montant'];
    $dateTransfert = $_POST['dateTransfert'];

    $query_old = $conn->query("SELECT montant FROM virement WHERE numCompte_expediteur='$numCompte_expediteur' AND numCompte_beneficiaire='$numCompte_beneficiaire'");
    $row = $query_old->fetch_assoc();
    $ancien_montant = $row['montant'];

    $conn->query("UPDATE client SET solde = solde + $ancien_montant WHERE numCompte = '$numCompte_expediteur'");
    $conn->query("UPDATE client SET solde = solde - $ancien_montant WHERE numCompte = '$numCompte_beneficiaire'");

    $conn->query("UPDATE client SET solde = solde - $nouveau_montant WHERE numCompte = '$numCompte_expediteur'");
    $conn->query("UPDATE client SET solde = solde + $nouveau_montant WHERE numCompte = '$numCompte_beneficiaire'");

    $ancienne_dateTransfert = $_POST['ancienne_dateTransfert'];
    $conn->query("UPDATE virement SET montant= '$nouveau_montant', dateTransfert= '$dateTransfert' WHERE numCompte_expediteur= '$numCompte_expediteur' AND numCompte_beneficiaire= '$numCompte_beneficiaire' AND dateTransfert = '$ancienne_dateTransfert'");

    $_SESSION['success_message'] = "Virement modifié avec succès !";
    header("Location: virement.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Virement</title>
    <link rel="stylesheet" href="virement.css">
</head>
<body>

    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>

    <div class="modal">
        <div id="addClientModal" class="modal-content">
            <span class="close" onclick="window.location='virement.php'">&times;</span>
            <h2>Modifier un Virement</h2>
            <form action="modifier_virement.php" method="post">
                <input type="hidden" name="numCompte_expediteur" value="<?= htmlspecialchars($virement['numCompte_expediteur'])?>">
                <input type="hidden" name="numCompte_beneficiaire" value="<?= htmlspecialchars($virement['numCompte_beneficiaire'])?>">

                <label>Numéro de compte expéditeur</label>
                <input type="text" name="numCompte_expediteur" value="<?= htmlspecialchars($virement['numCompte_expediteur'])?>" readonly>

                <label>Numéro de compte bénéficiaire</label>
                <input type="text" name="numCompte_beneficiaire" value="<?= htmlspecialchars($virement['numCompte_beneficiaire'])?>" readonly>

                <label>Montant</label>
                <input type="text" name="montant" value="<?= htmlspecialchars($virement['montant'])?>" required>

                <label>Date du transfert</label>
                <input type="date" name="dateTransfert" value="<?= htmlspecialchars($virement['dateTransfert'])?>" required>
                <input type="hidden" name="ancienne_dateTransfert" value="<?= htmlspecialchars($virement['dateTransfert'])?>">

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