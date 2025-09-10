 <?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$docno = $_SESSION['docno'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

if(isset($_REQUEST['action'])){ $action = $_REQUEST['action'];}else{$action='';}



if(isset($_REQUEST['fromdate'])){ $fromdate = $_REQUEST['fromdate'];}else{$fromdate=$transactiondatefrom;}

if(isset($_REQUEST['todate'])){$todate = $_REQUEST['todate'];}else{$todate=$transactiondateto;}
if(isset($_REQUEST['searchstorecode'])){$searchstorecode = $_REQUEST['searchstorecode'];}else{$searchstorecode='';}
if(isset($_REQUEST['fromstockstore'])){$fromstockstore = $_REQUEST['fromstockstore'];}else{$fromstockstore='';}
if (isset($_REQUEST["sortfunc"])) { $sortfunc = $_REQUEST["sortfunc"]; } else { $sortfunc = ""; }


			$colorloopcount = '';

			$sno = '';

			
if($action == 'deletefunction'){
if(isset($_REQUEST['docno'])){ $docno = $_REQUEST['docno'];}else{$docno='';}	
	
	$query3 = "update master_internalstockrequest set recordstatus = 'deleted' where docno = '$docno' and recordstatus!='completed' and balance_qty=0";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query3 = "update master_internalstockrequest set recordstatus = 'partially deleted' where docno = '$docno' and recordstatus!='completed' and balance_qty>0";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}

else{

if(isset($_REQUEST['fromdate'])){ $fromdate = $_REQUEST['fromdate'];}else{$fromdate=$transactiondatefrom;}

if(isset($_REQUEST['todate'])){$todate = $_REQUEST['todate'];}else{$todate=$transactiondateto;}
if(isset($_REQUEST['searchstorecode'])){$searchstorecode = $_REQUEST['searchstorecode'];}else{$searchstorecode='';}
if(isset($_REQUEST['fromstockstore'])){$fromstockstore = $_REQUEST['fromstockstore'];}else{$fromstockstore='';}
if (isset($_REQUEST["sortfunc"])) { $sortfunc = $_REQUEST["sortfunc"]; } else { $sortfunc = ""; }


			$colorloopcount = '';

			$sno = '';

			

			if($searchstorecode!='')

			{

				//echo $query1 = "select fromstore,updatedatetime,docno,tostore,typetransfer,username from master_internalstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' group by docno order by tostore $sortfunc";			

				
				$query1 = "select b.store AS storename, a.fromstore AS fromstore,a.updatedatetime AS updatedatetime,a.docno AS docno,a.tostore AS tostore,a.typetransfer AS typetransfer,a.username AS username from master_internalstockrequest AS a
				JOIN  master_store as b ON (b.storecode = a.fromstore ) 
				where a.recordstatus='pending' and Date(a.updatedatetime) between '$fromdate' and '$todate' and a.tostore='$searchstorecode' AND a.fromstore LIKE '%$fromstockstore%'  group by docno order by storename $sortfunc";

			}

			else

			{

		 $query1 = "select fromstore,updatedatetime,docno,tostore,typetransfer,username from master_internalstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' AND fromstore LIKE '%$fromstockstore%'  group by docno order by tostore $sortfunc";

								

			}

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res1 = mysqli_fetch_array($exec1))

			{

			$from = $res1['fromstore'];

			$date = $res1['updatedatetime'];

			$docno = $res1['docno'];

			$to = $res1['tostore'];

			$typetransfer = $res1['typetransfer'];

			$requser = $res1['username'];

			$query4 = "select store from master_store WHERE storecode = '".$from."'";

			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res4 = mysqli_fetch_array($exec4);

			$storename = $res4["store"];

			

			$query3 = "select auto_number from master_store WHERE storecode = '".$to."'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$storeanum = $res3["auto_number"];

			

			$query2 = "select storecode from master_employeelocation WHERE storecode = '".$storeanum."' and username='$username'";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res2 = mysqli_fetch_array($exec2);

			$num2 = mysqli_num_rows($exec2);

			$store = $res2["storecode"];

			

			

			

			$timestamp = strtotime($date);



			$child1 = date('j.n.Y', $timestamp); // d.m.YYYY

			$child2 = date('H:i', $timestamp); // HH:ss

			if($typetransfer=='1')

			{

				$num2=1;

			}

			if($num2>0)

			{

				$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			

			

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}

			

			?>

			

            <tr <?php echo $colorcode; ?> id="TR<?php echo $sno ?>">

              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $child1; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $storename.' - '.$requser; ?></td>

              <td class="bodytext31" valign="center" align="left">

			    <div align="left"><a class="prevent" href="stocktransfer.php?docno=<?php echo $docno; ?>"><strong>View</strong></a></div></td>
<!--<td class="bodytext31" valign="center" align="left"><div align="left"><input type = "button" id="delete<?php echo $sno ?>" value = "Delete" onclick = "deleterequestion('<?php echo $sno ?>','<?php echo $docno ?>')"></div></td>-->

              </tr>

			<?php

			}    

			}

			?>

		
</tbody>

<?php } ?>
