<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$doc_number=isset($_REQUEST['doc_number'])?$_REQUEST['doc_number']:'';

$filename = $doc_number."-StockVarianceReportView";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=80');

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$errmsg = "";





$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  if($locationcode!='')

  {

  $query4 = "select locationname,locationcode from master_location where locationcode = '$locationcode'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	  $locationnameget = $res4['locationname'];

	 $locationcodeget = $res4['locationcode'];

  }

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

   $storecode=isset($_REQUEST['store'])?$_REQUEST['store']:'';

   $storename = "";
   if($storecode !="")
   {



   $query = "select store from master_store where storecode='$storecode' ";

			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res = mysqli_fetch_array($exec);			

			$storename = $res["store"];
	}

   

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

$transactiondateto = date('Y-m-d');



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

	$transactiondateto = date('Y-m-d');

}



if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }

//$itemcode = $_REQUEST['itemcode'];

if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }

//$servicename = $_REQUEST['servicename'];



if ($servicename == '') $servicename = 'ALL';



if (isset($_REQUEST["searchoption1"])) { $searchoption1 = $_REQUEST["searchoption1"]; } else { $searchoption1 = ""; }

//$searchoption1 = $_REQUEST['searchoption1'];
$where_cond ="";
if($storecode !="")
{
	$where_cond = "and store='$storecode'";
}
$query = "select * from master_stock where doc_number='$doc_number' $where_cond limit 0,1";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $usernamedoc  = $res["username"];

	 $remarks = $res["remarks"];

	 $docdate = $res["transactiondate"];


 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>

<body>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
		  <tr>
              <td colspan="5" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>View Stock Variance Items</strong></td>
		  </tr>		
          
                 <tr >

              <td colspan="2" class="bodytext31" valign="center"  align="left" 

                ><strong>Doc No</strong></td>
                 <td class="bodytext31" valign="center"  align="left" 

                ><strong><?=  $doc_number;?></strong></td>
                <td align="left" valign="center"  

                 class="bodytext31"><strong>Store</strong></td>

                <td align="left" valign="center"  

                 class="bodytext31"><strong><?=  $storename;?></strong></td>
            </tr>

              <tr>

              <td colspan="2" align="left" valign="center"  

                class="bodytext31"><strong>Date </strong></td>
                  <td align="left" valign="center"  

                class="bodytext31"><strong><?=  $docdate;?> </strong></td>
                 <td align="left" valign="center"  

                 class="bodytext31"><strong>User </strong></td>
                  <td align="left" valign="center"  

                 class="bodytext31"><strong><?=  $usernamedoc;?> </strong></td>
            </tr>

              <tr>
            	<!-- <td colspan="2"></td> -->
            	<td colspan="2" align="left" valign="center"  

                class="bodytext31"><strong>Remarks </strong></td>

                 <td align="left" valign="center"  

                 class="bodytext31"><strong><?=  $remarks;?> </strong></td>

                 <td align="left" valign="center"  

                class="bodytext31"><strong> </strong></td>

                 <td align="left" valign="center"  

                 class="bodytext31"><strong> </strong></td>

            </tr>
        </tbody>
    </table>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="1">
          <tbody>
                 <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Code</strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Item </strong></td>
                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Particulars </strong></td>

                 <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td>

                <td align="right" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><strong>Phy Qty</strong></td>

                 <td align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Sys. Qty</strong></td>
                 <td align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Variance</strong></td>

              <td  width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Add Stock</strong></div></td>

              <td width="6%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Minus Stock</strong></div></td>

              <td align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost</strong></div></td>

              

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Amount</strong></div></td>

              

            </tr>

           <?php

			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

			//$categoryname = $_REQUEST['categoryname'];

			
			$running_total = 0;
			$colorloopcount = '';

			$sno = '';

			$stockdate = '';

			$transactionparticular = '';

			$stockremarks = '';

			$totalquantity = '';

			$totalsalesamount = '';

			$totalsalesquantity = '';

			$totalsalesreturnamount = '';

			$totalsalesreturnquantity = '';

			$totalpurchaseamount = '';

			$totalpurchasequantity = '';

			$totalpurchasereturnamount = '';

			$totalpurchasereturnquantity = '';

			$totaldccustomerquantity = '';

			$totaldccustomeramount = '';

			$totaldcsupplierquantity = '';

			$totaldcsupplieramount = '';

			$totaladjustmentaddquantity = '';

			$totaladjustmentminusquantity = '';

			

			if ($locationcode != '') //To list all categories, if not selected.

			{

			

			/*if ($searchoption1 == 'DETAILED')

			{

				$query2 = "select * from master_stock where locationcode = '".$locationcodeget."' AND itemcode like '%$itemcode%' and transactionmodule like '%ADJUSTMENT%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum' ";

				if($storecode!='')

				{

					$query2 .=" AND store = '".$storecode."'";

					}

				$query2 .=" order by lastupdate";

				// and cstid='$custid' and cstname='$custname'";

			}*/
			
			$searchitemcode=$itemcode;

			$searchstorecode=$storecode;

			 	$query2 = "select * from master_stock where locationcode = '".$locationcodeget."' AND transactionmodule like '%ADJUSTMENT%' and  recordstatus <> 'DELETED' and doc_number='$doc_number' ";// and cstid='$custid' and cstname='$custname'";

				if($store!='')

				{

					$query2 .=" AND store = '".$store."'";

					}

				$query2 .="order by itemname";

			

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrows=mysqli_num_rows($exec2);

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2anum = $res2['auto_number'];

			$itemcode = $res2['itemcode'];

			$itemname = $res2['itemname'];

			$username_1=$res2['username'];

			$stockdate = $res2['transactiondate'];

			$storecode = $res2['store'];

			$stockremarks = $res2['remarks'];

			$quantity = $res2['quantity'];

			$sumquantity = $res2['quantity'];

			$sumamount = $res2['totalrate'];

			$batch = $res2['batchnumber'];

			$physical_qty = $res2['physical_quantity'];
			$system_qty = $res2['system_current_stock'];
			$variance = $res2['variance'];
			$cost = $res2['rateperunit'];
			$amount = 
			$usernamedetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username_1' and locationcode ='$locationcodeget'");

			$resuser=mysqli_fetch_array($usernamedetail);

			$userfullname=$resuser['employeename'];

			

			$transactionmodule = $res2['transactionmodule'];

			$res2transactionparticular = $res2['transactionparticular'];

			$storecode = $res2['store'];

			

			$query = "select store from master_store where storecode='$storecode' ";

			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res = mysqli_fetch_array($exec);			

			$storename = $res["store"];

						

			$query3 = "select categoryname from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$res3categoryname = $res3['categoryname'];

			if ($res3categoryname == $res3categoryname)

			{

			

			

			

			if ($transactionmodule == 'ADJUSTMENT')

			{

				$salesquantity = '';

				$salesreturnquantity = '';

				$purchasequantity = '';

				$purchasereturnquantity = '';

				$dccustomerquantity = '';

				$dcsupplierquantity = '';

				if ($res2transactionparticular == 'BY ADJUSTMENT ADD')

				{

					$adjustmentaddquantity = $sumquantity;

					$adjustmentminusquantity = '';

					//$adjustmentaddquantity = round($adjustmentaddquantity, 4);

					$totaladjustmentaddquantity = $totaladjustmentaddquantity + $adjustmentaddquantity;

					//$amount = $sumquantity * $cost;
					$amount = $adjustmentaddquantity * $cost;

				}

				if ($res2transactionparticular == 'BY ADJUSTMENT MINUS')

				{

					$adjustmentaddquantity = '';

					$adjustmentminusquantity = $sumquantity;

					//$adjustmentminusquantity = round($adjustmentminusquantity, 4);

					$totaladjustmentminusquantity = $totaladjustmentminusquantity + $adjustmentminusquantity;

					//$amount = -($sumquantity * $cost);

					$amount = -($adjustmentminusquantity * $cost);

				}

			}

			else

			{	

				$quantity = '0';

			}

			

			

			

			

			//$quantity = round($quantity, 4);

			

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

			

			$sno = $sno + 1;

			

			$totalquantity = $totalquantity + $quantity;

			$running_total = $running_total + $amount;

			?>

            <tr >

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $sno; ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $itemcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="left"><?php echo $res2transactionparticular; ?></div>

              </div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="left"><?php echo $batch; ?></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="right"><?php echo $physical_qty; ?></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="right"><?php echo $system_qty; ?></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="center"><div class="bodytext31">

			  <?php echo $variance; ?></div></td>

             

              <td class="bodytext31" valign="center"  align="left"><div align="right">

			  <?php echo $adjustmentaddquantity; ?>

			  </div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right">

			  <?php echo $adjustmentminusquantity; ?>

			  </div></td>

			   <td class="bodytext31" valign="center"  align="right"><div align="right">

			 
			  <?php echo number_format($cost,'2','.',',');?>

			  </div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">

			 
			   <?php echo number_format($amount,'2','.',',');?>

			  </div></td>

            </tr>

            <?php

			$sumamount = '';

			$sumquantity = '';

			$salesquantity = '';

			$salesreturnquantity = '';

			$purchasequantity = '';

			$purchasereturnquantity = '';

			$adjustmentaddquantity = '';

			$adjustmentminusquantity = '';

			$purchasereturnquantity = '';

			$totalpurchasereturnquantity = '';

			

			$salesamount = '';

			$salesreturnamount = '';

			$purchaseamount = '';

			$purchasereturnamount = '';

			$adjustmentaddamount = '';

			$adjustmentminusamount = '';

			$totalpurchasereturnamount = '';

			$totalpurchasereturnamount = '';



			}

			

			}

			

			}

			?>

             <tr >

              <td  colspan="11" valign="center"  align="left">&nbsp;</td>
              

                <td  class="bodytext31" valign="top"   align="right"> 

                <strong><?php echo number_format($running_total,'2','.',',');?></strong>

                </td>

            </tr> 
          </tbody>
        </table>
</body>
</html>
