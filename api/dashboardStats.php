<?php

include '../db.php';

header(
"Content-Type: application/json"
);

$selected =
$conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Selected'"
)->fetch_assoc()['total'];

$rejected =
$conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Rejected'"
)->fetch_assoc()['total'];

$pending =
$conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Applied'"
)->fetch_assoc()['total'];

echo json_encode([
"selected"=>$selected,
"rejected"=>$rejected,
"pending"=>$pending
]);

?>
