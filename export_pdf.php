<?php 
// Vérifier si FPDF est installé
if (file_exists(__DIR__ . '/fpdf/fpdf.php')) {
    require __DIR__ . '/fpdf/fpdf.php';
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../fpdf186/fpdf.php')) {
    require __DIR__ . '/../fpdf186/fpdf.php';
} else {
    die("Erreur : La bibliothèque FPDF n'est pas installée. Veuillez télécharger FPDF depuis http://www.fpdf.org/ et placer le fichier fpdf.php dans le dossier 'fpdf' de ce projet.");
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, "Rapport des Transactions ($date_debut - $date_fin)", 0, 1, 'C');
    $pdf->Ln(10);

    function addTableHeader($pdf, $headers) {
        $pdf->SetFont('Arial', 'B', 12);
        foreach ($headers as $header) {
            $pdf->Cell(47, 10, $header, 1);
        }
        $pdf->Ln();
    }

    function addTableData($pdf, $result) {
        $pdf->SetFont('Arial', '', 10);
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $value) {
                $pdf->Cell(47, 10, $value, 1);
            }
            $pdf->Ln();
        }
    }

    $pdf->Cell(190, 10, "Virements", 0, 1, 'L');
    $query = "SELECT numCompte_expediteur, numCompte_beneficiaire, montant, dateTransfert from virement where dateTransfert between '$date_debut' and '$date_fin'";
    $result = $conn->query($query);
    addTableHeader($pdf, [utf8_decode('Expéditeur'), utf8_decode('Bénéficiaire'), 'Montant', 'Date']);
    addTableData($pdf, $result);
    $pdf->Ln(10);

    $pdf->Cell(190, 10, utf8_decode("Prêts"), 0, 1, 'L');
    $query = "SELECT num_pret, montant_prete, datepret from preter where datepret between '$date_debut' and '$date_fin'";
    $result = $conn->query($query);
    addTableHeader($pdf, [utf8_decode('Numéro'), 'Montant', 'Date']);
    addTableData($pdf, $result);
    $pdf->Ln(10);

    $pdf->Cell(190, 10, "Remboursements", 0, 1, 'L');
    $query = "SELECT num_rendu, num_pret, montant_rembourse, date_rendu from rendre where date_rendu between '$date_debut' and '$date_fin'";
    $result = $conn->query($query);
    addTableHeader($pdf, [utf8_decode('Numéro'), utf8_decode('Prêt'), 'Montant', 'Date']);
    addTableData($pdf, $result);
    $pdf->Ln(10);

    $pdf->Output('D', 'Rapport' .'.pdf');
}
?>