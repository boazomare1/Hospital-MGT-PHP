<?php
$totalearnings = '0.00';
$employeetotaldeductions = '0.00';
$employeenettpay = '0.00';
$employeegrosspay = '0.00';

$query3 = "select * from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
$res3componentanum = $res3['componentanum'];


	$res3componentname = $res3['componentname'];
	$res3componentrate = $res3['componentrate'];
	$res3componentunit = $res3['componentunit'];
	$res3componentamount = $res3['componentamount'];
	
	$employeegrosspay = $employeegrosspay + $res3componentamount;		
}
//echo $employeegrosspay;	
$query4 = "select * from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and typecode = '20' and status <> 'deleted' order by auto_number";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res4 = mysqli_fetch_array($exec4))
{
$res4componentanum = $res4['componentanum'];


	$res4componentname = $res4['componentname'];
	$res4componentrate = $res4['componentrate'];
	$res4componentunit = $res4['componentunit'];
	$res4componentamount = $res4['componentamount'];
	
	$employeetotaldeductions = $employeetotaldeductions + $res4componentamount;		
}
//echo $employeetotaldeductions;
$employeenettpay = $employeegrosspay - $employeetotaldeductions;

$query87 = "select * from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and componentname = 'GROSSPAY' and status <> 'deleted'";
$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die ("Error in Query87".mysqli_error($GLOBALS["___mysqli_ston"]));
$res87 = mysqli_fetch_array($exec87);
$res87employeecode = $res87['employeecode'];
if($res87employeecode == "")
{
	 $query161 = "insert into details_employeepayroll(employeecode, employeename, componentanum, componentname, componentrate, componentunit, componentamount, paymonth, ipaddress, username, updatedatetime, typecode)
			values('$employeecode', '$employeename', '0', 'GROSSPAY', '0.00', '0.00', '$employeegrosspay', '$assignmonth', '$ipaddress', '$username', '$updatedatetime', '0')";
	 $exec161 = mysqli_query($GLOBALS["___mysqli_ston"], $query161) or die ("Error in Query161".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
else
{
	$query162 = "update details_employeepayroll set componentrate = '0.00', componentunit = '0.00', componentamount = '$employeegrosspay', updatedatetime = '$updatedatetime', typecode = '0'
				where employeecode = '$employeecode' and employeename = '$employeename' and componentanum = '0' and componentname = 'GROSSPAY' and paymonth = '$assignmonth'";
	$exec162 = mysqli_query($GLOBALS["___mysqli_ston"], $query162) or die ("Error in Query162".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
$query871 = "select * from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and componentname = 'TOTALDEDUCTIONS' and status <> 'deleted'";
$exec871 = mysqli_query($GLOBALS["___mysqli_ston"], $query871) or die ("Error in Query871".mysqli_error($GLOBALS["___mysqli_ston"]));
$res871 = mysqli_fetch_array($exec871);
$res871employeecode = $res871['employeecode'];
if($res871employeecode == "")
{
	 $query161 = "insert into details_employeepayroll(employeecode, employeename, componentanum, componentname, componentrate, componentunit, componentamount, paymonth, ipaddress, username, updatedatetime, typecode)
			values('$employeecode', '$employeename', '0', 'TOTALDEDUCTIONS', '0.00', '0.00', '$employeetotaldeductions', '$assignmonth', '$ipaddress', '$username', '$updatedatetime', '0')";
	 $exec161 = mysqli_query($GLOBALS["___mysqli_ston"], $query161) or die ("Error in Query161".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
else
{
	$query162 = "update details_employeepayroll set componentrate = '0.00', componentunit = '0.00', componentamount = '$employeetotaldeductions', updatedatetime = '$updatedatetime', typecode = '0'
				where employeecode = '$employeecode' and employeename = '$employeename' and componentanum = '0' and componentname = 'TOTALDEDUCTIONS' and paymonth = '$assignmonth'";
	$exec162 = mysqli_query($GLOBALS["___mysqli_ston"], $query162) or die ("Error in Query162".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
$query872 = "select * from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and componentname = 'NETTPAY' and status <> 'deleted'";
$exec872 = mysqli_query($GLOBALS["___mysqli_ston"], $query872) or die ("Error in Query872".mysqli_error($GLOBALS["___mysqli_ston"]));
$res872 = mysqli_fetch_array($exec872);
$res872employeecode = $res872['employeecode'];
if($res872employeecode == "")
{
	 $query161 = "insert into details_employeepayroll(employeecode, employeename, componentanum, componentname, componentrate, componentunit, componentamount, paymonth, ipaddress, username, updatedatetime, typecode)
			values('$employeecode', '$employeename', '0', 'NETTPAY', '0.00', '0.00', '$employeenettpay', '$assignmonth', '$ipaddress', '$username', '$updatedatetime', '0')";
	 $exec161 = mysqli_query($GLOBALS["___mysqli_ston"], $query161) or die ("Error in Query161".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
else
{
	$query162 = "update details_employeepayroll set componentrate = '0.00', componentunit = '0.00', componentamount = '$employeenettpay', updatedatetime = '$updatedatetime', typecode = '0'
				where employeecode = '$employeecode' and employeename = '$employeename' and componentanum = '0' and componentname = 'NETTPAY' and paymonth = '$assignmonth'";
	$exec162 = mysqli_query($GLOBALS["___mysqli_ston"], $query162) or die ("Error in Query162".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
?>

		
		
