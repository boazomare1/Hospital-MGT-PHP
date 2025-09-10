<!-- <?php
/*
include ("db/db_connect.php");

$sno=0;
$query_ledger_ids = "SELECT * FROM `master_transactionpharmacy` WHERE `docno` LIKE '%SDBT%' ORDER BY `auto_number` DESC ";
$exec_ledger_ids = mysql_query($query_ledger_ids) or die ("Error in opening_query".mysql_error());
while($res_ledger_ids = mysql_fetch_array($exec_ledger_ids)){

				$docno=$res_ledger_ids['docno'];
				$td=$res_ledger_ids['transactiondate'];
				$auto_number=$res_ledger_ids['auto_number'];
                // $remarks=$res_ledger_ids['remarks'];


				$query_1 = "SELECT * FROM `supplier_debits` WHERE `invoice_id` LIKE '$docno'";
				$exec_1 = mysql_query($query_1) or die ("Error in opening_query".mysql_error());
				$y=mysql_num_rows($exec_1);
				 $res1 = mysql_fetch_array($exec_1);
				 $invoice_date=$res1['invoice_date'];
				 
                     if($td!=$invoice_date){ $sno+=1;  
                     	echo $sno.'=='.$docno;
                     	echo '<br>';

                     	// $query3 = "UPDATE `master_transactionpharmacy` set transactiondate='$invoice_date' where `docno` = '$docno'  and auto_number='$auto_number' ";
						// $exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());

                      }

				}	
				 
	*/
				?>			 
 -->


 <?php
include ("db/db_connect.php");

$sno=0;
$query_ledger_ids = "SELECT sum(transactionamount) as a,docno FROM `master_transactionpharmacy` WHERE `docno` LIKE '%SPE%' group by docno ORDER BY `auto_number` DESC ";
$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){

				$docno=$res_ledger_ids['docno'];
				// $td=$res_ledger_ids['transactiondate'];
				$aa=$res_ledger_ids['a'];
                // $remarks=$res_ledger_ids['remarks'];

// SELECT * FROM `paymententry_details` WHERE `docno` LIKE 'SPE-373-190'

				$query_1 = "SELECT * FROM `paymententry_details` WHERE `docno` LIKE '$docno'";
				$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
				$y=mysqli_num_rows($exec_1);
				 $res1 = mysqli_fetch_array($exec_1);
				 $supplieramount=$res1['supplieramount'];
				 $accountnameid=$res1['accountnameid'];
				 
                     if($aa!=$supplieramount){ $sno+=1;  
                     	echo $sno.'=='.$docno.'==su=='.$accountnameid.'==aa='.$aa.'==supa=='.$supplieramount; 
                     	echo '<br>';

                     	 

                      }

				}	
				 

				?>			 
