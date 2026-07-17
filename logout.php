<?php
session_start();
session_destroy();
session_start();
$_SESSION['logout_message'] = "Vous avez été déconnecté avec succès !";

header("Location: login.php");
exit();
?>
