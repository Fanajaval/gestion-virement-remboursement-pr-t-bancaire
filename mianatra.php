<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $heure_connexion = 17;
        if($heure_connexion < 16){
            echo "Passez une bonne journée.....<br>";
            $journee = "oui";
        }
        else{
            echo "Passez une bonne soirée......<br>";
            $journee = "non";
        }
        echo 'Fait-il jour? La réponse est'.$journee. '.';

    ?>
</body>
</html>