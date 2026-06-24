<?php

session_start();

include 'db.php';

$message = "";

if(isset($_POST['login'])){

$email =
trim($_POST['email']);

$password =
trim($_POST['password']);

$sql =
"SELECT *
FROM users
WHERE email='$email'";

$result =
$conn->query($sql);

if($result->num_rows > 0){

$user =
$result->fetch_assoc();

if(
password_verify(
$password,
$user['password']
)
){

$_SESSION['user_id'] =
$user['id'];

$_SESSION['user_name'] =
$user['name'];

$_SESSION['user_email'] =
$user['email'];

header(
"Location: dashboard.php"
);

exit();

}
else{

$message =
"<div class='alert alert-danger'>
Wrong Password
</div>";

}

}
else{

$message =
"<div class='alert alert-danger'>
User Not Found
</div>";

}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

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

Login

</h2>

<?= $message ?>

<form method="POST">

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
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

<div class="text-center mt-3">

<a href="register.php">

Create Account

</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
