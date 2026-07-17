<?php
require('../fpdf186/fpdf.php');
include 'db.php';

if (isset($_GET['numCompte_expediteur']) && isset($_GET['numCompte_beneficiaire'])) {
    $numCompte_expediteur = $_GET['numCompte_expediteur'];
    $numCompte_beneficiaire = $_GET['numCompte_beneficiaire'];

    $result = $conn->query("SELECT * FROM virement WHERE numCompte_expediteur='$numCompte_expediteur' AND numCompte_beneficiaire='$numCompte_beneficiaire'");
    $virement = $result->fetch_assoc();

    $expediteur = $conn->query("SELECT * FROM client WHERE numCompte = '$numCompte_expediteur'")->fetch_assoc();
    $beneficiaire = $conn->query("SELECT * FROM client WHERE numCompte = '$numCompte_beneficiaire'")->fetch_assoc();

    $solde_restant = $expediteur['solde'];

    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(190, 10, utf8_decode('BankOnline'), 0, 1, 'C');
            $this->Ln(10);
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(190, 10, utf8_decode("Date : ") . date("d/m/Y", strtotime($virement['dateTransfert'])), 0, 1, 'R');
    $pdf->Cell(190, 10, utf8_decode("AVIS DE VIREMENT N°") . rand(100, 999), 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, utf8_decode("Expéditeur :"), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 8, utf8_decode("N° de compte : ") . $expediteur['numCompte'], 0, 1);
    $pdf->Cell(50, 8, utf8_decode(strtoupper($expediteur['Nom']) . " " . $expediteur['Prenoms']), 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, utf8_decode("Bénéficiaire :"), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 8, utf8_decode("N° de compte : ") . $beneficiaire['numCompte'], 0, 1);
    $pdf->Cell(50, 8, utf8_decode(strtoupper($beneficiaire['Nom']) . " " . $beneficiaire['Prenoms']), 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, utf8_decode("Montant viré :"), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 8, number_format($virement['montant'], 0, ',', ' ') . " Ar", 0, 1);
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, utf8_decode("Reste du solde actuel :"), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 8, number_format($solde_restant, 0, ',', ' ') . " Ar", 0, 1);
    $pdf->Ln(10);

    $pdf->Output('D', 'Avis_Virement_' . $numCompte_expediteur . '.pdf');
} else {
    echo "<script>alert('Virement introuvable !'); window.location='virement.php';</script>";
}
?>