<?php
include 'db.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $query = $conn->real_escape_string($_POST['query']); //securisati°

    $sql = "SELECT nom from client where nom like '%$query%' limit 5";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>" .htmlspecialchars($row['nom']) . "</p>";
        }
    } else {
        echo "<p>Aucun résultat trouvé</p>";
    }
}
?>