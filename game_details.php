<?php
$url = "https://www.freetogame.com/api/games";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 30,
]);

$response = curl_exec($curl);
curl_close($curl);

// Traiter la réponse de l'API
$gamesData = json_decode($response, true);

// Parcourir les données des jeux
foreach ($gamesData as &$game) {
    // Récupérer le titre du jeu et la description
    $titreJeu = $game['title'];
    $descriptionJeu = $game['short_description']; // Supposons que 'short_description' est le champ de la description

    // Remplacer le titre du jeu par une chaîne de '*' de la même longueur
    $descriptionSansTitre = preg_replace("/$titreJeu/i", str_repeat('*', strlen($titreJeu)), $descriptionJeu);

    // Mettre à jour la description dans les données du jeu
    $game['short_description'] = $descriptionSansTitre;
}

// Retourner les données modifiées au format JSON
header('Content-Type: application/json');
echo json_encode($gamesData);
?>
