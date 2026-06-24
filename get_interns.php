<?php

header("Content-Type: application/json");

include 'db.php';

$sql = "SELECT * FROM interns";

$result = $conn->query($sql);

$interns = [];

while($row = $result->fetch_assoc()){
    $interns[] = $row;
}

echo json_encode($interns);

?>
