<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
	$query1 = "truncate table details_employeepayroll";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table details_loanpay";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table insurance_relief";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table loan_assign";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table nhif_monthwise";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table paye_monthwise";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	//$query1 = "truncate table payroll_assign";
	//$exec1 = mysql_query($query1);
	
	$query1 = "truncate table payroll_assignmonthwise";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	
	
	$errmsg1 = "Table First Batch Truncate Completed.";
}





?>
<script language="javascript">
function btnClick1()
{
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete All Data In DB And Reset To Original State?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		alert ("Data In Table First Batch Not Deleted.");
		return false;
	}
}



</script>
<form id="form1" name="form1" method="post" action="" onsubmit="return btnClick1()">
  <p>Batch One : Will Delete All Data And Restore To Original State. </p>
  <p>
    <input type="submit" name="Submit" value="Truncate All Data" />
    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
  </p>
</form>
<?php echo $errmsg1; ?>
