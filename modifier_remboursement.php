<?php
session_start();
include 'db.php';

if (!isset($_GET['num_rendu'])) {
    $_SESSION['error_message'] = "Erreur : Numéro de remboursement manquant !";
    header("Location: rendre.php");
    exit();
}

$num_rendu = $_GET['num_rendu'];
$result = $conn->query("SELECT * FROM rendre WHERE num_rendu = '$num_rendu'");

if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "Erreur : Remboursement introuvable !";
    header("Location: rendre.php");
    exit();
}

$rendre = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $montant_rembourse = intval($_POST['montant_rembourse']);
    $date_rendu = $_POST['date_rendu'];

    $query_old = $conn->query("SELECT num_pret, montant_rembourse FROM rendre WHERE num_rendu = '$num_rendu'");
    if ($query_old->num_rows == 0) {
        $_SESSION['error_message'] = "Erreur : Données invalides !";
        header("Location: rendre.php");
        exit();
    }
    
    $data_old = $query_old->fetch_assoc();
    $num_pret = $data_old['num_pret'];
    $ancien_montant_rembourse = $data_old['montant_rembourse'];

    $query_pret = $conn->query("SELECT numCompte, montant_prete FROM preter WHERE num_pret = '$num_pret'");
    if ($query_pret->num_rows == 0) {
        $_SESSION['error_message'] = "Erreur : Prêt introuvable !";
        header("Location: rendre.php");
        exit();
    }

    $pret_data = $query_pret->fetch_assoc();
    $numCompte = $pret_data['numCompte'];
    $montant_total_pret = $pret_data['montant_prete'];

    $conn->query("UPDATE client SET solde = solde + $ancien_montant_rembourse WHERE numCompte = '$numCompte'");

    $conn->query("UPDATE client SET solde = solde - $montant_rembourse WHERE numCompte = '$numCompte'");

    $rembourse_total = $conn->query("SELECT SUM(montant_rembourse) AS total FROM rendre WHERE num_pret = '$num_pret' AND num_rendu != '$num_rendu'");
    $rembourse_data = $rembourse_total->fetch_assoc();
    $total_rembourse = ($rembourse_data['total'] ?? 0) + $montant_rembourse;

    if ($total_rembourse > $montant_total_pret) {
        $_SESSION['error_message'] = "Erreur : Le montant total remboursé dépasse le montant du prêt !";
        header("Location: rendre.php");
        exit();
    }

    $stmt = $conn->prepare("UPDATE rendre SET montant_rembourse = ?, date_rendu = ? WHERE num_rendu = ?");
    
    if ($stmt === false) {
        $_SESSION['error_message'] = "Erreur de préparation de la requête : " . $conn->error;
        header("Location: rendre.php");
        exit();
    }
    
    $stmt->bind_param("dss", $montant_rembourse, $date_rendu, $num_rendu);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Remboursement modifié avec succès !";
    } else {
        $_SESSION['error_message'] = "Erreur SQL lors de la modification.";
    }

    header("Location: rendre.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Remboursement</title>
    <link rel="stylesheet" href="rendre.css">
</head>
<body>
    <?php if (isset($_SESSION['error_message'])) : ?>
        <div class="error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>

    <div class="modal">
        <div id="addRemboursementModal" class="modal-content">
            <span class="close" onclick="window.location='rendre.php'">&times;</span>
            <h2>Modifier un Remboursement</h2>
            <form action="modifier_remboursement.php?num_rendu=<?= htmlspecialchars($rendre['num_rendu']) ?>" method="post">
                <label>Numéro du remboursement</label>
                <input type="text" name="num_rendu" value="<?= htmlspecialchars($rendre['num_rendu']) ?>" readonly>

                <label>Numéro du prêt</label>
                <input type="text" name="num_pret" value="<?= htmlspecialchars($rendre['num_pret']) ?>" readonly>

                <label>Montant remboursé</label>
                <input type="number" name="montant_rembourse" value="<?= htmlspecialchars($rendre['montant_rembourse']) ?>" required>

                <label>Date du remboursement</label>
                <input type="date" name="date_rendu" value="<?= htmlspecialchars($rendre['date_rendu']) ?>" required>

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