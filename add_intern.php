<?php

header("Content-Type: application/json");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$college = $data['college'];

$sql = "INSERT INTO interns(name,email,college)
VALUES('$name','$email','$college')";

if($conn->query($sql)){
    echo json_encode([
        "status"=>"success",
        "message"=>"Intern Added"
    ]);
}
else{
    echo json_encode([
        "status"=>"error"
    ]);
}

?>
