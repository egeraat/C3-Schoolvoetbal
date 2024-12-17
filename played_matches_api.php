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

// SQL-query: Haal gespeelde wedstrijden op met team-namen en scores
$sql = "
    SELECT 
        m.id AS match_id, 
        m.team1_id, 
        t1.name AS team1_name,
        m.team2_id, 
        t2.name AS team2_name,
        m.team1_score, 
        m.team2_score
    FROM matches m
    INNER JOIN teams t1 ON m.team1_id = t1.id
    INNER JOIN teams t2 ON m.team2_id = t2.id
    WHERE m.team1_score IS NOT NULL AND m.team2_score IS NOT NULL
";

$result = $conn->query($sql);

// Controleer of er resultaten zijn
if ($result->num_rows > 0) {
    $matches = array();

    // Haal elke rij op en voeg toe aan de array
    while ($row = $result->fetch_assoc()) {
        $matches[] = array(
            "match_id" => $row["match_id"],
            "team1_id" => $row["team1_id"],
            "team1_name" => $row["team1_name"],
            "team2_id" => $row["team2_id"],
            "team2_name" => $row["team2_name"],
            "team1_score" => $row["team1_score"],
            "team2_score" => $row["team2_score"]
        );
    }

    // Zet data om naar JSON
    header("Content-Type: application/json");
    echo json_encode($matches, JSON_PRETTY_PRINT);
} else {
    // Geen gespeelde wedstrijden gevonden
    echo json_encode(array("message" => "Geen gespeelde wedstrijden gevonden"));
}

// Sluit de databaseverbinding
$conn->close();
?>
