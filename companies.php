<?php

include 'auth.php';
include 'db.php';

$result = $conn->query(
"SELECT * FROM companies ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Company Management</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<div class="d-flex justify-content-between">

<h2>Company Management</h2>

<a
href="dashboard.php"
class="btn btn-secondary">

Dashboard

</a>

</div>

<form
action="addCompany.php"
method="POST"
class="card p-4 mt-4">

<div class="row">

<div class="col-md-3">

<input
type="text"
name="company_name"
class="form-control"
placeholder="Company Name"
required>

</div>

<div class="col-md-2">

<input
type="text"
name="job_role"
class="form-control"
placeholder="Job Role"
required>

</div>

<div class="col-md-2">

<input
type="number"
step="0.01"
name="package_lpa"
class="form-control"
placeholder="Package"
required>

</div>

<div class="col-md-2">

<input
type="text"
name="location"
class="form-control"
placeholder="Location"
required>

</div>

<div class="col-md-2">

<input
type="date"
name="deadline"
class="form-control"
required>

</div>

<div class="col-md-1">

<button
class="btn btn-success">

Add

</button>

</div>

</div>

</form>

<table
class="table table-bordered mt-4">

<tr>

<th>ID</th>
<th>Company</th>
<th>Role</th>
<th>Package</th>
<th>Location</th>
<th>Deadline</th>
<th>Action</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= $row['company_name'] ?></td>

<td><?= $row['job_role'] ?></td>

<td><?= $row['package_lpa'] ?> LPA</td>

<td><?= $row['location'] ?></td>

<td><?= $row['deadline'] ?></td>

<td>

<a
href="updateCompany.php?id=<?= $row['id'] ?>"
class="btn btn-primary btn-sm">

Edit

</a>

<a
href="deleteCompany.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Company?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>
