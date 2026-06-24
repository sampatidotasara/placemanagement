<?php

include '../db.php';

header(
"Content-Type: application/json"
);

$sql = "
SELECT
c.company_name,
COUNT(a.id) total

FROM companies c

LEFT JOIN applications a
ON c.id = a.company_id

GROUP BY c.id
";

$result =
$conn->query($sql);

$data=[];

while(
$row=
$result->fetch_assoc()
){
$data[]=$row;
}

echo json_encode($data);

?>
