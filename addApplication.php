<?php

include 'db.php';

$student_name =
$_POST['student_name'];

$company_id =
$_POST['company_id'];

$status =
$_POST['status'];

$applied_date =
$_POST['applied_date'];

$resume="";

if(
isset($_FILES['resume'])
&&
$_FILES['resume']['name']!="")
{

$targetDir=
"uploads/resumes/";

if(
!file_exists($targetDir)
){
mkdir(
$targetDir,
0777,
true
);
}

$fileName=
time().
"_".
basename(
$_FILES['resume']['name']
);

$resume=
$targetDir.$fileName;

move_uploaded_file(
$_FILES['resume']['tmp_name'],
$resume
);

}

$sql=
"
INSERT INTO applications(

student_name,
company_id,
status,
resume_path,
applied_date

)

VALUES(

'$student_name',
'$company_id',
'$status',
'$resume',
'$applied_date'

)
";

$conn->query($sql);

header(
"Location: applications.php"
);
