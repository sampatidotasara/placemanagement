<?php

include 'auth.php';
include 'db.php';

$id = $_GET['id'];

if(isset($_POST['update'])){

$status = $_POST['status'];

$conn->query(
"UPDATE applications
SET status='$status'
WHERE id='$id'"
);

header("Location: applications.php");
exit();

}

$data = $conn->query(
"SELECT *
FROM applications
WHERE id='$id'"
)->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

<title>Update Application</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Update Application Status</h2>

<form method="POST">

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-select"
required>

<option value="Applied"
<?= $data['status']=="Applied" ? "selected" : "" ?>>
Applied
</option>

<option value="OA Scheduled"
<?= $data['status']=="OA Scheduled" ? "selected" : "" ?>>
OA Scheduled
</option>

<option value="OA Cleared"
<?= $data['status']=="OA Cleared" ? "selected" : "" ?>>
OA Cleared
</option>

<option value="Interview Scheduled"
<?= $data['status']=="Interview Scheduled" ? "selected" : "" ?>>
Interview Scheduled
</option>

<option value="HR Interview"
<?= $data['status']=="HR Interview" ? "selected" : "" ?>>
HR Interview
</option>

<option value="Selected"
<?= $data['status']=="Selected" ? "selected" : "" ?>>
Selected
</option>

<option value="Rejected"
<?= $data['status']=="Rejected" ? "selected" : "" ?>>
Rejected
</option>

<option value="Offer Accepted"
<?= $data['status']=="Offer Accepted" ? "selected" : "" ?>>
Offer Accepted
</option>

</select>

</div>

<button
type="submit"
name="update"
class="btn btn-success">

Update Status

</button>

<a
href="applications.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</body>

</html>
