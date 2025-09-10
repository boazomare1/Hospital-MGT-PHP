<?php

session_start();

include ("db/db_connect.php");
if (isset($_REQUEST['docnumber'])) { $docnumber= $_REQUEST["docnumber"]; } else { $docnumber = ""; }
$query12 = "select locationname from purchase_indent where docno='$docnumber' and (approvalstatus='' or approvalstatus='rejected1')";
$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec12);				
$res12 = mysqli_fetch_array($exec12);

 $location_name = $res12['locationname'];
 
 
$updatedatetime = date('Y-m-d');

$curr_date= date('F d Y', strtotime($updatedatetime));

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="'.$location_name.'-Purchase Indent-'.$curr_date.'.xls"');

header('Cache-Control: max-age=80');




$ipaddress = $_SERVER['REMOTE_ADDR'];


$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('d-m-Y');

$paymentreceiveddateto1 = "2014-01-01";

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$sno = "";

$colorloopcount1="";

$grandtotal = '';

$grandtotal1 = "0.00";

$docno1 = $_SESSION['docno'];



//This include updatation takes too long to load for hunge items database.

//echo $amount;

if (isset($_REQUEST['docnumber'])) { $docnumber= $_REQUEST["docnumber"]; } else { $docnumber = ""; }



 $query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

 	$locationname  = $res["locationname"]; 

	$locationcode = $res["locationcode"]; 



$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);



$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

$store = $res75['store'];

$storecode = $res75['storecode'];






 $query1 = "select * from master_location where locationcode = '$locationcode'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['locationname'];

$res1address1 = $res1['address1'];

$res1area = $res1['address2'];

$res1emailid1= $res1['email'];

$res1phonenumber1 = $res1['phone'];

?>

<style type="text/css">

<!--

body {

	

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

</style>

</head>

<body>

<table cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

<tr>

					<td width="168" align="left" class="bodytext3"><?php echo $res1companyname; ?> </td>

					<td width="256" align="left" class="bodytext3">&nbsp;</td>

					<td width="88" align="left" class="bodytext3">&nbsp;</td>

					<td width="267" align="left" class="bodytext3">&nbsp;</td>

					<td width="151" align="left" class="bodytext3"><?php echo $transactiondateto; ?></td>

                    <td width="151" align="left" class="bodytext3">&nbsp;</td>

</tr>

<tr>

					<td width="168" align="left" class="bodytext3"><?php echo $res1address1; ?> </td>

					<td width="256" align="left" class="bodytext3">&nbsp;</td>

					<td width="88" align="left" class="bodytext3">&nbsp;</td>

					<td width="267" align="left" class="bodytext3">&nbsp;</td>

					<td width="151" align="left" class="bodytext3">Doc No. <?php echo $docnumber; ?></td>

                    <td width="151" align="left" class="bodytext3"></td>

</tr>

<tr>

					<td width="168" align="left" class="bodytext3"><?php echo $res1area; ?>   </td>

					<td width="256" align="left" class="bodytext3">&nbsp;</td>

					<td width="88" align="left" class="bodytext3">&nbsp;</td>

					<td width="267" align="left" class="bodytext3">&nbsp;</td>

					<td width="151" align="left" class="bodytext3"></td>

                    <td width="151" align="left" class="bodytext3"></td>

</tr>

<tr>

					<td width="168" align="left" class="bodytext3"> Tel : <?php echo $res1phonenumber1; ?>   </td>

					<td width="256" align="left" class="bodytext3">&nbsp;</td>

					<td width="88" align="left" class="bodytext3">&nbsp;</td>

					<td width="267" align="left" class="bodytext3">&nbsp;</td>

					<td width="151" align="left" class="bodytext3"></td>

                    <td width="151" align="left" class="bodytext3"></td>

</tr>

<tr>

					<td width="168" align="left" class="bodytext3"> Email : <?php echo $res1emailid1; ?>   </td>

					<td width="256" align="left" class="bodytext3">&nbsp;</td>

					<td width="88" align="left" class="bodytext3">&nbsp;</td>

					<td width="267" align="left" class="bodytext3">&nbsp;</td>

					<td width="151" align="left" class="bodytext3"></td>

                    <td width="151" align="left" class="bodytext3"></td>

</tr>

<tr>

					<td width="168" align="left" class="bodytext3">&nbsp;</td>

					<td width="256" align="left" class="bodytext3"></td>

					<td colspan="2" align="left" class="bodytext3">&nbsp;</td>

					<td width="151" align="left" class="bodytext3"></td>

                    <td width="151" align="left" class="bodytext3"></td>

</tr>

					<tr>

					<td colspan="6" align="left" class="bodytext3">

      <table width="2002" border="1" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

					

<tr bgcolor="#011E6A">

                       	 

                        <td width="6%" bgcolor="#ecf0f5" class="bodytext3"><strong>No </strong></td>

                        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Name</strong></td>

                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine Name</strong></td>

                        

                        <td width="8%" bgcolor="#ecf0f5" class="bodytext3"><strong>Req Qty</strong></td>

                        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Pack Size</strong></div></td>

                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Pkg Qty</strong></div></td>
                         <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Disc</strong></div></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>

						<td width="8%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate</strong></div></td>

						<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Amount</strong></div></td>



                      </tr>

					   <?php

		    $totalamount=0;	
			$taxamount = 0;	
          
		$query12 = "select * from purchase_indent where docno='$docnumber' and approvalstatus=''";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$numb=mysqli_num_rows($exec12);



		while ($res12 = mysqli_fetch_array($exec12))

		{

			
        $amount=0;
		$baserate=0; 
		$reqqty=0;
		$itemcode = $res12["medicinecode"];

		$itemname = $res12["medicinename"];

		$rate = $res12["rate"];

		$reqqty = $res12['quantity'];

		//$amount = $res12['amount'];

		

		

		include ('autocompletestockcount1include1.php');

		 $currentstock = $currentstock; 

		

		$query330 = "select sum(quantity) as totalquantitypurchasequantity from purchase_indent where medicinecode = '$itemcode' and status='Process'";

		$exec330 = mysqli_query($GLOBALS["___mysqli_ston"], $query330) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

		$res330 = mysqli_fetch_array($exec330);

		$purchasequantity = $res330['totalquantitypurchasequantity'];

		

		

		$query331 = "select sum(packagequantity) as totalquantity from purchase_indent where medicinecode = '$itemcode' and docno='$docnumber'";

		$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

		$res331 = mysqli_fetch_array($exec331);

		$quantity = $res331['totalquantity'];

		



		

		$query2 = "select * from master_medicine where itemcode = '$itemcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$package = $res2['packagename'];

		$taxpercent = 0;
		$taxid = $res2['taxanum'];

		$taxamount = 0;
		if($taxid)
		{
			// Get tax percentage
			$query11 = "select taxpercent from master_tax where auto_number='$taxid'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$taxpercent = $res11["taxpercent"];

			/*if($taxpercent > 0)
			{
				$taxamount = $amount * ($taxpercent / 100);
			}*/
		}
		
				

		$sno = $sno + 1;	

		$item_suppliers_qry = "SELECT `master_accountname`.`auto_number`,`suppliercode`,`master_accountname`.`accountname`,`master_itemmapsupplier`.`fav_supplier`,`master_itemmapsupplier`.`rate` FROM `master_accountname` inner join master_itemmapsupplier on `master_itemmapsupplier`.`suppliercode` = `master_accountname`.`id` WHERE `master_itemmapsupplier`.`itemcode`='$itemcode' group by `master_itemmapsupplier`.`suppliercode` order by fav_supplier desc limit 0,1 ";
		$item_supp_res = mysqli_query($GLOBALS["___mysqli_ston"], $item_suppliers_qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$baserate = 0;
					$incr = 0;
					$suppliername = "";
			while($supp_res = mysqli_fetch_array($item_supp_res))
					{
						
						$suppliername = $supp_res['accountname'];
						//$supp_res1 = $supp_res;
						$incr = $incr + 1;
						if($incr == 1)
						{
							$baserate = $supp_res['rate'];
						}
						if($supp_res['fav_supplier'])
						{
							$baserate = $supp_res['rate'];
							
						}
						$amount = $baserate * $reqqty;
						

						if($taxpercent > 0)
						{
							$taxamount = $amount * ($taxpercent / 100);
						}
						

						$amount = $amount + $taxamount;
						if($supp_res['fav_supplier'])
						{
							$suppliername = $supp_res['accountname'];
						}
					
				}
				$totalamount= $totalamount + $amount;

				

		?>

        <tr>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><?php echo $sno; ?></div></td>

                	 	<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><?php echo $suppliername; ?></div></td>


					    <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>

                       

                        <td align="left" valign="top"  class="bodytext3"><?php echo $reqqty; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $package; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $quantity; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"> </td>
                         <td align="left" valign="top"  class="bodytext3"><?php echo $taxpercent; ?> </td>
                        <td align="right" valign="top"  class="bodytext3"><?php echo number_format($baserate,'2','.',',');?></td>

                        <td align="right" valign="top"  class="bodytext3"><?php echo number_format($amount,'2','.',',');?></td>



						 </tr>

		<?php

		}

		?>
<tr>
			
			<td colspan="8" align="left" valign="top"  class="bodytext3">&nbsp;</td>
			<td align="left" valign="top"  class="bodytext3"><strong>Total</strong></td>
			
			
			<td align="right" valign="top"  class="bodytext3"><strong><?php echo number_format($totalamount,'2','.',','); ?></strong></td>
				 
               </tr>
		  </tbody>

        </table>

        </td>

      </tr>

   </tbody>      

</table>



</body>

</html>

