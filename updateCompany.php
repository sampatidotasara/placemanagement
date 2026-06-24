<?php

include 'db.php';

$id =
$_GET['id'];

if(isset($_POST['update'])){

$company_name =
$_POST['company_name'];

$job_role =
$_POST['job_role'];

$package_lpa =
$_POST['package_lpa'];

$location =
$_POST['location'];

$deadline =
$_POST['deadline'];

$conn->query(

"UPDATE companies SET

company_name='$company_name',
job_role='$job_role',
package_lpa='$package_lpa',
location='$location',
deadline='$deadline'

WHERE id='$id'"

);

header(
"Location: companies.php"
);

exit();

}

$data =
$conn->query(

"SELECT *
FROM companies
WHERE id='$id'"

)->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Company</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Edit Company</h2>

<form method="POST">

<div class="mb-3">

<label>Company</label>

<input
type="text"
name="company_name"
class="form-control"
value="<?= $data['company_name'] ?>"
required>

</div>

<div class="mb-3">

<label>Role</label>

<input
type="text"
name="job_role"
class="form-control"
value="<?= $data['job_role'] ?>"
required>

</div>

<div class="mb-3">

<label>Package</label>

<input
type="number"
step="0.01"
name="package_lpa"
class="form-control"
value="<?= $data['package_lpa'] ?>"
required>

</div>

<div class="mb-3">

<label>Location</label>

<input
type="text"
name="location"
class="form-control"
value="<?= $data['location'] ?>"
required>

</div>

<div class="mb-3">

<label>Deadline</label>

<input
type="date"
name="deadline"
class="form-control"
value="<?= $data['deadline'] ?>"
required>

</div>

<button
name="update"
class="btn btn-success">

Update Company

</button>

</form>

</div>

</body>
</html>
