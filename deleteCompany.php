<?php

include 'db.php';

$id =
$_GET['id'];

$conn->query(

"DELETE
FROM companies
WHERE id='$id'"

);

header(
"Location: companies.php"
);

exit();
