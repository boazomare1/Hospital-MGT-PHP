<?php
//$ADate1 = '2015-05-15';			
	$purchasequantity= '0';
	if($store == 'all')
	{
	$query1 = "select sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1' order by auto_number desc";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
	$query1 = "select sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1' order by auto_number desc";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}		 
	$res1 = mysqli_fetch_array($exec1);
	$totaladdstock = $res1['addstock'];
	
	if($store == 'all')
	{
	$query1 = "select sum(transaction_quantity) as minusstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0' order by auto_number desc";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
	$query1 = "select sum(transaction_quantity) as minusstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0' order by auto_number desc";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}		 
	$res1 = mysqli_fetch_array($exec1);
	$totalminusstock = $res1['minusstock'];
	
	$openingbalance = $totaladdstock-$totalminusstock;
						
?>
