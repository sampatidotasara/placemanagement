<?php

include 'auth.php';
include 'db.php';

$result = $conn->query(

"SELECT
a.id,
a.student_name,
c.company_name,
a.applied_date,
a.status

FROM applications a

JOIN companies c
ON a.company_id = c.id

WHERE a.status='Rejected'

ORDER BY a.id DESC"

);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title>
Rejected Students
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.card{
border:none;
border-radius:15px;
box-shadow:0 4px 12px rgba(0,0,0,.08);
}

</style>

</head>

<body>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="text-danger">

Rejected Students

</h2>

<a
href="dashboard.php"
class="btn btn-secondary">

Back Dashboard

</a>

</div>

<div class="alert alert-info">

<strong>Keep Going!</strong>

Every rejection is feedback.

Many software engineers receive
multiple rejections before their first offer.

Keep improving your DSA,
projects, communication,
and interview skills.

Your next application could be the one.

</div>

<div class="card">

<div class="card-header bg-danger text-white">

Rejected Applications

</div>

<table class="table table-bordered mb-0">

<tr>

<th>ID</th>
<th>Student Name</th>
<th>Company</th>
<th>Status</th>
<th>Applied Date</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= $row['student_name'] ?></td>

<td><?= $row['company_name'] ?></td>

<td>

<span class="badge bg-danger">

<?= $row['status'] ?>

</span>

</td>

<td><?= $row['applied_date'] ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>
