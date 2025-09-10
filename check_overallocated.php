<?php
include ("db/db_connect.php");

$allocatedamount=0;
$sno=0;
$query214 = "select id, auto_number, accountname from master_accountname  ";
$exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die ("Error in Query214".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res214 = mysqli_fetch_array($exec214))
{
	  $accountnameid4 = $res214['id'];
	  $accountnameano4 = $res214['auto_number'];
	  $suppliername = $res214['accountname'];
 
	  $query1 = "SELECT *  from master_transactionpaylater where accountnameano = '$accountnameano4' and transactionstatus <> 'onaccount'   and transactiontype in ('finalize') order by transactiondate ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount1 = mysqli_num_rows($exec1);
			while($res1 = mysqli_fetch_array($exec1)){

				$auto_number1=$res1['auto_number'];
				$amount=$res1['fxamount'];
				$accflag=$res1['acc_flag'];
				$subtype1=$res1['subtypeano'];
				$billno=$res1['billnumber'];
				$accountnameid=$res1['accountnameid'];

				// OVER ALLOCATION
			$query2 = "SELECT  SUM(fxamount) as allocam, sum(discount) as dis from master_transactionpaylater where billnumber = '$billno' and recordstatus='allocated' and accountnameid='$accountnameid' and subtypeano='$subtype1' order by auto_number asc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
					$allocatedamount=$res2['allocam']+$res2['dis'];

					// if($allocatedamount>$amount){
						if(round($allocatedamount, 2) > round($amount, 2)){
						$sno+=1;
						echo $sno.'--'.$billno. '--'.$amount.'--'.$allocatedamount.'<br>';
					}

	} // RES1 CLOSE

}