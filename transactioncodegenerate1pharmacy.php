<?php

	$query6 = "select * from master_transactionpharmacy order by auto_number desc limit 0, 1";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount6 = mysqli_num_rows($exec6);
	if ($rowcount6 == 0)
	{
		$transactioncode = 'TRS00000001';
	}
	else
	{
		$res6 = mysqli_fetch_array($exec6);
		$transactioncode = $res6["transactioncode"];
		$transactioncode = substr($transactioncode, 3, 8);
		$transactioncode = intval($transactioncode);
		$transactioncode = $transactioncode + 1;
	
		$maxanum = $transactioncode;
		if (strlen($maxanum) == 1)
		{
			$maxanum1 = '0000000'.$maxanum;
		}
		else if (strlen($maxanum) == 2)
		{
			$maxanum1 = '000000'.$maxanum;
		}
		else if (strlen($maxanum) == 3)
		{
			$maxanum1 = '00000'.$maxanum;
		}
		else if (strlen($maxanum) == 4)
		{
			$maxanum1 = '0000'.$maxanum;
		}
		else if (strlen($maxanum) == 5)
		{
			$maxanum1 = '000'.$maxanum;
		}
		else if (strlen($maxanum) == 6)
		{
			$maxanum1 = '00'.$maxanum;
		}
		else if (strlen($maxanum) == 7)
		{
			$maxanum1 = '0'.$maxanum;
		}
		else if (strlen($maxanum) == 8)
		{
			$maxanum1 = $maxanum;
		}
		
		$transactioncode = 'TRS'.$maxanum1;
	
		//echo $transactioncode;
	}
	//echo $transactioncode;


?>