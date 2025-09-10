<?php 
include ("db/db_connect.php");
$q = "Truncate master_consultationtype";
$e = mysqli_query($GLOBALS["___mysqli_ston"], $q);
$q = "select * from cons_upload2 where cons_type <> '' order by cons_type";
$e = mysqli_query($GLOBALS["___mysqli_ston"], $q);
while($r = mysqli_fetch_array($e))
{
	echo '<br>'.$r['dpt'].'==>'.$r['dtpanum'];
	$q1 = "select * from master_subtype";
	$e1 = mysqli_query($GLOBALS["___mysqli_ston"], $q1);
	while($r1 = mysqli_fetch_array($e1))
	{
		echo '<br>'.$r1['auto_number'].'==>'.$r1['maintype'];
		if($r1['auto_number'] == '1')
		{
			$fee = $r['cash'];
		}
		else
		{
			if($r1['maintype'] == '3')
			{
				$fee = $r['direct'];
			}
			else
			{
				$fee = $r['ins_loc'];
			}
		}
		
		echo '<br>'.$qq = "INSERT INTO `master_consultationtype`(`consultationtype`, `department`, `consultationfees`, `recordstatus`, `ipaddress`, `recorddate`, `username`, `paymenttype`, `subtype`, `locationname`, `locationcode`, `condefault`) VALUES ('".$r['cons_type']."', '".$r['dtpanum']."','".$fee."','','127.0.0.1','2018-07-24','ADMIN','".$r1['maintype']."','".$r1['auto_number']."','1','LTC-1','')";
		$ee = mysqli_query($GLOBALS["___mysqli_ston"], $qq);
	}
}
?>