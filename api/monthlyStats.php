<?php

include '../db.php';

header(
"Content-Type: application/json"
);

$sql="
SELECT
MONTH(applied_date) month,
COUNT(*) total

FROM applications

GROUP BY
MONTH(applied_date)

ORDER BY
MONTH(applied_date)
";

$result=
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
