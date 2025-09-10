<?php
include ("db/db_connect.php");
$tot=0;
$query4="SELECT accountname,id FROM `master_accountname` where accountssub=12";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
echo '<table border=1>';
while($res4 = mysqli_fetch_array($exec4))
{
	$cr=0;
	$dr=0;
	$lname=$res4['id'];
	$lid=$res4['id'];
    $query44="SELECT sum(transaction_amount) as cr  FROM `tb` WHERE `ledger_id` = '$lid' and transaction_date<='2020-12-31' and transaction_type='C' group by `ledger_id`";
	$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res44 = mysqli_fetch_array($exec44);
    $cr= $res44['cr'];
    
	$query44="SELECT sum(transaction_amount) as dr  FROM `tb` WHERE `ledger_id` = '$lid' and transaction_date<='2020-12-31' and transaction_type='D' group by `ledger_id`";
	$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res44 = mysqli_fetch_array($exec44);
    $dr= $res44['dr'];

	$bal=$cr-$dr;
    $tot=$tot+$bal;
	if($bal!=0){
        echo '<tr><td>'.$lname.'</td><td>'.$bal.'</td></tr>';
		

	}

}
echo '<tr><td></td><td>'.$tot.'</td></tr>';
echo '</table>';

?>