<?php
$fruits = ["Banane", "Pomme", "Orange"];
echo $fruits[1];

echo "<br><br><br>";

$personne = ["Nom" => "RAKOTO", "Age" => 20];
echo "Bonjour " .$personne["Nom"] . ", Age :" .$personne["Age"];


echo "<br><br><br>";

$couleurs = ["Rouge", "Bleu", "Vert", "Gris"];

foreach ($couleurs as $couleur) {
    echo $couleur . "<br>";
}



echo "<br><br><br>";

$personne = ["Nom" => "RANDRIA", "age" => 18];

foreach ($personne as $test) {
    echo $test . "<br>";
}


echo "<br><br><br>";

$couleurs = ["Rouge", "Bleu", "Vert", "Gris"];

for ($i=0; $i<count($couleurs); $i++){
    echo $couleurs[$i] . "<br>";
}


echo "<br><br><br>";

$couleurs = ["Rouge", "Bleu", "Vert", "Gris"];

$i=0;
while($i<count($couleurs)){
    echo $couleurs[$i] . "<br>";
    $i++;
}


echo "<br><br><br>";

$couleurs = ["Rouge", "Bleu", "Vert", "Gris"];

$i=0;
do {
    echo $couleurs[$i] . "<br>";
    $i++;
} while ($i<count($couleurs));



?>