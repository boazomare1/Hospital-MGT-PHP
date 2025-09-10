<?php 
		
ini_set('max_execution_time', '0');
ini_set("memory_limit",'1024M');
include ("db/db_connect.php");

$bankname ='02-4000-1';

	/*	$query5 = "select * from bankentryform where (tobankid = '$bankname' or frombankid = '$bankname') and  amount > 0  and creditamount = 0  group by docnumber";

			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

			$bknums = mysql_num_rows($exec5);

			//$query45 = "select * from bank_record where notes = 'misc' and status IN ('Posted','Unpresented','Uncleared')";

			$query45 = "select * from bank_record where notes = 'misc'";

			$exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());

			$post45 = mysql_num_rows($exec45);

			$bknums = $bknums - $post45;

			if(true)

			{?>

			

		   <?php

			while ($res5 = mysql_fetch_array($exec5))

			{

			

			$bkdocno = $res5['docnumber'];

			$bktransactiondate =$res5['transactiondate'];

			$bktransactiondate = date("d-m-Y", strtotime($bktransactiondate));

			$dramount = $res5['amount'];

			$cramount = $res5['creditamount'];

			$bktransactionamount = $cramount + $dramount;

			$bkchequeno = $res5['chequenumber'];

			if($bkchequeno=='')
			{
				$bkchequeno = 'Dr';
			}

			$bkpostedby = $res5['personname'];

			$bkremarks = $res5['remarks'];

			$bkbankname = $res5['bankname'];		

			$querybankname5 = "select * from master_bank where bankname like '%$bkbankname%' and bankstatus <> 'deleted'";

			$execbankname5 = mysql_query($querybankname5) or die ("Error in Query5".mysql_error());

			$resbankname5 = mysql_fetch_array($execbankname5);

			$bkbankcode = $resbankname5['bankcode'];

			$bkaccountname = strtoupper($res5['transactiontype']);

			//$query25 = "select * from bank_record where docno = '$bkdocno' and status IN ('Posted','Unpresented','Uncleared')";

			$query25 = "select * from bank_record where docno = '$bkdocno'  limit 0,1";

			$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());

			

			//$bkposttotalamount = $bkposttotalamount + $res25['amount'];

			$bkposttotalamount = 0;

			$post25 = mysql_num_rows($exec25);

			if($post25 ){

				 $res25 = mysql_fetch_array($exec25);

				 $autono = $res25['auto_number'];

				 

				 if($res25['instno'] =='')
				 {
				 	 echo $res25['docno'].'  #  '.$res25['amount'].'<br>';
				 	 $query1 = "update bank_record set instno = 'Dr' where auto_number = '$autono'";
		             $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				 }
				 

			}

		}

	}*/


			$query5 = "select * from bankentryform where (tobankid = '$bankname' or frombankid = '$bankname') and  amount <= 0  and creditamount > 0  group by docnumber";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$bknums = mysqli_num_rows($exec5);

			//$query45 = "select * from bank_record where notes = 'misc' and status IN ('Posted','Unpresented','Uncleared')";

			$query45 = "select * from bank_record where notes = 'misc'";

			$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post45 = mysqli_num_rows($exec45);

			$bknums = $bknums - $post45;

			if(true)

			{?>

			

		   <?php

			while ($res5 = mysqli_fetch_array($exec5))

			{

			

			$bkdocno = $res5['docnumber'];

			$bktransactiondate =$res5['transactiondate'];

			$bktransactiondate = date("d-m-Y", strtotime($bktransactiondate));

			$dramount = $res5['amount'];

			$cramount = $res5['creditamount'];

			$bktransactionamount = $cramount + $dramount;

			$bkchequeno = $res5['chequenumber'];

			if($bkchequeno=='')
			{
				$bkchequeno = 'Dr';
			}

			$bkpostedby = $res5['personname'];

			$bkremarks = $res5['remarks'];

			$bkbankname = $res5['bankname'];		

			$querybankname5 = "select * from master_bank where bankname like '%$bkbankname%' and bankstatus <> 'deleted'";

			$execbankname5 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname5 = mysqli_fetch_array($execbankname5);

			$bkbankcode = $resbankname5['bankcode'];

			$bkaccountname = strtoupper($res5['transactiontype']);

			//$query25 = "select * from bank_record where docno = '$bkdocno' and status IN ('Posted','Unpresented','Uncleared')";

			$query25 = "select * from bank_record where docno = '$bkdocno'  limit 0,1";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			//$bkposttotalamount = $bkposttotalamount + $res25['amount'];

			$bkposttotalamount = 0;

			$post25 = mysqli_num_rows($exec25);

			if($post25 ){

				 $res25 = mysqli_fetch_array($exec25);

				 $autono = $res25['auto_number'];

				 

				 if($res25['instno'] =='')
				 {
				 	 echo $res25['docno'].'  #  '.$res25['amount'].'<br>';
				 	// $query1 = "update bank_record set instno = 'Dr' where auto_number = '$autono'";
		             //$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				 }
				 

			}

		}

	}
?>