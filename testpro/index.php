<?php
//équation du second degré
function second_degre($a, $b, $c) {
    $delta = (($b*$b) - (4*$a*$c));

    if ($delta <0) {
        echo "Pas de solution car delta est négatif";
    } else if ($delta > 0) {
        $x1 = (-$b -sqrt($delta))/(2*$a);
        $x2 = (-$b + sqrt($delta))/(2*$a);

        echo "Delta > 0 <br>";
        echo "X1 = ". $x1 . ", et X2 = " . $x2;
    } else {
        echo "Delta = 0 <br>";
        $x= -$b / 2*$a;

        echo "X =" . $x;
    }
}

$a = 4;
$b = 2;
$c = 1;
$test = second_degre($a, $b, $c);

echo "<br><br><br>";




    $nom = "Jean";
    $age = 25;
    $poids = 65.5;

    echo "Nom : " . $nom . ", Age : " . $age . "ans, Poids: " .$poids ."<br>";

    $note = 15;
    $note =10;
    if (($note >= 10) and  ($note < 12)) {
        echo "Passable";
    } else if (($note >= 12) and  ($note < 14)){
        echo "Assez-bien";
    } else if (($note >= 14) and  ($note < 16)){
        echo "Bien";
    } else if ($note >=16){
        echo "Très bien";
    }
    echo "<br><br><br>";

    $note =15;
    switch($note) {
        case (($note >= 10) and  ($note < 12)):
        echo "Passable"; break;
        case (($note >= 12) and  ($note < 14)):
        echo "Assez-bien";
        break;
        case (($note >= 14) and  ($note < 16)):
        echo "Bien";
        break;
        case ($note >=16):
        echo "Très bien";
        break;
        default:
        echo "Non admis";
    }

    echo "<br><br><br>";
    for ($i=1; $i<=5;$i++) {
        echo "Tour n°" .$i. "<br>";
    }

    echo "<br><br><br>";
    
    $i = 1;
    while ($i<=3) {
        echo "<em><u>Bonjour n°</u></em>" .$i. "<br>";
        $i++;
    }
    
    echo "<br><br><br>";
    $i=1;
    do {
        echo "Teste n°" .$i;
        echo "<br>";
        $i++;
    } while ($i<=4);


    echo "<br><br><br>";

    include "mianatra.php";

    function somme($a, $b) {
        $somme = $a + $b;
        return $somme;
    
    }


    $somme = somme(20, 30);

    echo "Somme=" .$somme;

    echo "<br><br><br>";

    function incrementer(&$valeur) { 
        $valeur = $valeur + 1;
    } 
    $a = 1; 
    incrementer($a); 
    echo $a; // affiche "2"


?>