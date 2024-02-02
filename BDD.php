<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "jeux";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configuration des options PDO pour afficher les erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données de l'API
    $json_data = file_get_contents("https://www.freetogame.com/api/games");
    $games = json_decode($json_data, true);
    

    // Requête SQL pour insérer les données dans la table jeux
    $sql = "INSERT INTO liste (Titre,ID, Genre, Descr, Date_sortie) VALUES ";
    foreach ($games as $game) {
        // Échapper les caractères spéciaux pour éviter les injections SQL
        $titre = addslashes($game['title']);
        $id=addslashes($game['id']);
        $genre = addslashes($game['genre']);
        $description = addslashes($game['short_description']);
        $date_sortie = addslashes($game['release_date']);
        $sql .= "('$titre', '$id' , '$genre', '$description', '$date_sortie'),";
    }
    // Supprimer la virgule en trop à la fin de la requête
    $sql = rtrim($sql, ',');

    // Exécution de la requête
    $conn->exec($sql);
    echo "Les données ont été insérées avec succès dans la table jeux !";
} catch(PDOException $e) {
    echo "Erreur lors de l'insertion des données : " . $e->getMessage();
}
var_dump($games);
// Fermeture de la connexion
$conn = null;
?>
