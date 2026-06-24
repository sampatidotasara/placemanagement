<?php

include 'db.php';

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

$sql = "

INSERT INTO companies(

company_name,
job_role,
package_lpa,
location,
deadline

)

VALUES(

'$company_name',
'$job_role',
'$package_lpa',
'$location',
'$deadline'

)

";

$conn->query($sql);

header(
"Location: companies.php"
);

exit();
