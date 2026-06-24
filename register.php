<?php

include 'db.php';

$message = "";

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $check =
    $conn->query(
    "SELECT * FROM users
    WHERE email='$email'"
    );

    if($check->num_rows > 0){

        $message =
        "<div class='alert alert-danger'>
        Email already exists
        </div>";

    }
    else{

        $hash =
        password_hash(
        $password,
        PASSWORD_DEFAULT
        );

        $sql =
        "INSERT INTO users(
        name,
        email,
        password
        )
        VALUES(
        '$name',
        '$email',
        '$hash'
        )";

        if($conn->query($sql)){

            header(
            "Location: login.php"
            );

            exit();

        }

    }

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Register</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card p-4">

<h2 class="text-center mb-4">
Register
</h2>

<?= $message ?>

<form method="POST">

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
name="register"
class="btn btn-success w-100">

Register

</button>

</form>

<div class="text-center mt-3">

<a href="login.php">

Already have an account?

</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
