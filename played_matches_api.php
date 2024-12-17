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

// SQL-query: Haal gespeelde wedstrijden op met team-namen en uitslagen
$sql = "
    SELECT 
        g.id AS game_id, 
        g.team1_id, 
        t1.name AS team1_name,
        g.team2_id, 
        t2.name AS team2_name,
        g.uitslag AS result,
        g.field,
        g.created_at
    FROM games g
    INNER JOIN teams t1 ON g.team1_id = t1.id
    INNER JOIN teams t2 ON g.team2_id = t2.id
    WHERE g.uitslag IS NOT NULL
";

$result = $conn->query($sql);

// Controleer of er resultaten zijn
if ($result->num_rows > 0) {
    $games = array();

    // Haal elke rij op en voeg toe aan de array
    while ($row = $result->fetch_assoc()) {
        $games[] = array(
            "game_id" => $row["game_id"],
            "team1_id" => $row["team1_id"],
            "team1_name" => $row["team1_name"],
            "team2_id" => $row["team2_id"],
            "team2_name" => $row["team2_name"],
            "result" => $row["result"],
            "field" => $row["field"],
            "created_at" => $row["created_at"]
        );
    }

    // Zet data om naar JSON
    header("Content-Type: application/json");
    echo json_encode($games, JSON_PRETTY_PRINT);
} else {
    // Geen gespeelde wedstrijden gevonden
    echo json_encode(array("message" => "Geen gespeelde wedstrijden gevonden"));
}

// Sluit de databaseverbinding
$conn->close();
?>
