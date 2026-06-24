<?php

include 'db.php';

$companies =
$conn->query(
"SELECT * FROM companies"
);

$applications =
$conn->query(
"
SELECT
a.*,
c.company_name

FROM applications a

JOIN companies c
ON a.company_id=c.id

ORDER BY a.id DESC
"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Applications</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Application Management</h2>

<form
action="addApplication.php"
method="POST"
enctype="multipart/form-data"
class="card p-4 mt-3">

<div class="row">

<div class="col-md-4">

<input
type="text"
name="student_name"
class="form-control"
placeholder="Student Name"
required>

</div>

<div class="col-md-4">

<select
name="company_id"
class="form-control"
required>

<option value="">
Select Company
</option>

<?php while($c=$companies->fetch_assoc()){ ?>

<option
value="<?=$c['id']?>">

<?=$c['company_name']?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-4">

<input
type="date"
name="applied_date"
class="form-control"
required>

</div>

</div>

<div class="row mt-3">

<div class="col-md-4">

<select
name="status"
class="form-control">

<option>Applied</option>
<option>OA Scheduled</option>
<option>OA Cleared</option>
<option>Interview</option>
<option>Selected</option>
<option>Rejected</option>

</select>

</div>

<div class="col-md-4">

<input
type="file"
name="resume"
class="form-control">

</div>

<div class="col-md-4">

<button
class="btn btn-success w-100">

Add Application

</button>

</div>

</div>

</form>

<table
class="table table-bordered mt-4">

<tr>

<th>ID</th>
<th>Name</th>
<th>Company</th>
<th>Status</th>
<th>Date</th>
<th>Resume</th>
<th>Action</th>

</tr>

<?php while($row=$applications->fetch_assoc()){ ?>

<tr>

<td><?=$row['id']?></td>

<td><?=$row['student_name']?></td>

<td><?=$row['company_name']?></td>

<td><?=$row['status']?></td>

<td><?=$row['applied_date']?></td>

<td>

<?php
if($row['resume_path']!=""){
?>

<a
href="<?=$row['resume_path']?>"
target="_blank">

View Resume

</a>

<?php } ?>

</td>

<td>

<a
href="updateApplication.php?id=<?=$row['id']?>"
class="btn btn-primary btn-sm">

Edit

</a>

<a
href="deleteApplication.php?id=<?=$row['id']?>"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>
