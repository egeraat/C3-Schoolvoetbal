<?php
// Database configuratie
$host = "localhost";          // Database host
$user = "root";               // Database gebruikersnaam
$password = "";               // Database wachtwoord
$dbname = "c3_schoolvoetbal"; // Jouw database naam

// Verbinding maken met MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// SQL-query om wedstrijden (games) op te halen
$sql = "SELECT id, team1_id, team2_id, status, field, uitslag, created_at FROM games";
$result = $conn->query($sql);

// Controleer of er resultaten zijn
if ($result->num_rows > 0) {
    $games = array();

    // Haal elke rij op en voeg toe aan de array
    while ($row = $result->fetch_assoc()) {
        $games[] = array(
            "game_id" => $row["id"],
            "team1_id" => $row["team1_id"],
            "team2_id" => $row["team2_id"],
            "status" => $row["status"],
            "field" => $row["field"],
            "uitslag" => $row["uitslag"],
            "created_at" => $row["created_at"]
        );
    }

    // Zet data om naar JSON
    header("Content-Type: application/json");
    echo json_encode($games, JSON_PRETTY_PRINT);
} else {
    // Geen resultaten gevonden
    echo json_encode(array("message" => "Geen wedstrijden gevonden"));
}

// Sluit de databaseverbinding
$conn->close();
?>
