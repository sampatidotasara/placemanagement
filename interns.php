<?php
include 'db.php';

$result=
$conn->query(
"SELECT * FROM interns"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Interns</title>
</head>
<body>

<h1>Intern List</h1>

<a href="addIntern.php">
Add Intern
</a>

<table border="1">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Status</th>
</tr>

<?php
while(
$row=$result->fetch_assoc()
){
?>

<tr>

<td>
<?=$row['id']?>
</td>

<td>
<?=$row['name']?>
</td>

<td>
<?=$row['email']?>
</td>

<td>
<?=$row['department']?>
</td>

<td>
<?=$row['status']?>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>
