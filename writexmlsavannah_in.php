<?php
$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '';
$databasenamesmart = 'policyplus';
//Folder Name Change Only Necessary
$appfoldername = 'case';

$fileData1 = '';

date_default_timezone_set('Africa/Nairobi'); 

$link = ($GLOBALS["___mysqli_ston_policyplus"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston_policyplus"]));
mysqli_select_db($GLOBALS["___mysqli_ston_policyplus"], $databasenamesmart) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston_policyplus"]));


$sno = 0;
$claimdate = date('Y-m-d');
$claimtime = date('H:i:s');


 //$importData = $fileDatatop.$fileData1;

$updatedate = date('Y-m-d H:i:s');
if($savannah_authflag=='yes'){
$sql = "INSERT into exchange_files  (Exchange_File,Exchange_Date ,Progress_Flag , Member_Nr) values ('$importData','$updatedate', '5','$savannah_authid')";

$current_id = mysqli_query($GLOBALS["___mysqli_ston_policyplus"], $sql) or die("<b>Error:</b> Problem on File Insert<br/>" . mysqli_error($GLOBALS["___mysqli_ston_policyplus"]));
}
else
{
$sql = "UPDATE exchange_files SET Exchange_File = '$importData', Exchange_Date = '$updatedate', Progress_Flag = '4' WHERE Member_Nr = '$memberno' AND Progress_Flag = '2' order by ID desc limit 1";

$current_id = mysqli_query($GLOBALS["___mysqli_ston_policyplus"], $sql) or die("<b>Error:</b> Problem on File Insert<br/>" . mysqli_error($GLOBALS["___mysqli_ston_policyplus"]));
}
//header("location:billing_pending_op2.php?billautonumber=$billautonumber&&st=success&&printbill=$printbill");
//exit;
?>
