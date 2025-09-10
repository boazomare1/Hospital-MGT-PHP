<?php

session_start();

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$username = $_SESSION["username"];

$docno=$_SESSION["docno"];

$netamount=0.00;

$baname='';

$faname='';

$currency='';

ob_start();



$locationcodeget=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

$transactiondatefrom=isset($_REQUEST['transactiondatefrom'])?$_REQUEST['transactiondatefrom']:'';

$transactiondateto=isset($_REQUEST['transactiondateto'])?$_REQUEST['transactiondateto']:'';

$itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';

//$itemcode='';

$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';







	$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

 	$locationname = $res1["locationname"];

	$locationcode = $res1["locationcode"];

	

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }



	$query2 = "select * from master_company where auto_number = '$companyanum'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_fetch_array($exec2);

	$companyname = $res2["companyname"];

	$address1 = $res2["address1"];

	$area = $res2["area"];

	$city = $res2["city"];

	$pincode = $res2["pincode"];

	$phonenumber1 = $res2["phonenumber1"];

	$phonenumber2 = $res2["phonenumber2"];

	$tinnumber1 = $res2["tinnumber"];

	$cstnumber1 = $res2["cstnumber"];



	

	$query55 = "select entrydate,suppliername,suppliercode from manual_lpo where billnumber='$billnumber'";

	$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$num55=mysqli_num_rows($exec55);

	$res55=mysqli_fetch_array($exec55);

	$billdate = $res55['entrydate'];

	$suppliername = $res55['suppliername'];

	$suppliercode = $res55['suppliercode'];

	$remarks ='';

	

	$query14 = "select accountname,address,contact from master_accountname where id='$suppliercode'";

	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res14 = mysqli_fetch_array($exec14);

	$res14accountname = $res14['accountname'];

	$res14address = $res14['address'];

	$res14contact = $res14['contact'];

	include("print_header.php");

?>

<style>

.bodytext31

{font-size:14px;

}

.bodytext32

{

	font-size:12;

}

</style>



<table width="778"  border="1" align="left" cellpadding="1" cellspacing="2">

<tbody>

 <tr>

   <td height="40" colspan="9"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext32"><strong>Stock Adjustment Report.</strong> </td>

				</tr>

 <tr>

              <td width="24" height="40"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext32"><strong>No.</strong></td>

              <td width="64"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext32"><strong>Store</strong></td>

              <td width="144"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext32"><strong>Item Name </strong></td>

              <td width="50"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext32"><div align="right"><strong>Adj Add</strong></div></td>

              <td width="66"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext32"><div align="right"><strong>Adj Minus</strong></div></td>

              <td width="60"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext32"><div align="center"><strong>Date</strong></div></td>

              <td width="83"  align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext32"><strong>Particulars </strong></td>

              <td width="151"  class="bodytext32" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Remarks</strong></div></td>

                 <td width="98"  class="bodytext32" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Username</strong></div></td>

            </tr>

            <?php

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

			$query2 = "select * from master_stock where locationcode = '".$locationcodeget."' AND transactionmodule like '%ADJUSTMENT%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and quantity > 0";// and cstid='$custid' and cstname='$custname'";

			if($storecode!='')

			{

				$query2 .=" AND store = '".$storecode."'";

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

			$userfullname = '--';

			if($username_1 <> ''){
				$usernamedetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username_1' and locationcode ='$locationcodeget'");

				$resuser=mysqli_fetch_array($usernamedetail);

				$userfullname=$resuser['employeename'];
			}

			/*
			$usernamedetail=mysql_query("select employeename from master_employee where username='$username_1' and locationcode ='$locationcodeget'");

			$resuser=mysql_fetch_array($usernamedetail);

			$userfullname=$resuser['employeename'];
			*/

			

			$transactionmodule = $res2['transactionmodule'];

			$res2transactionparticular = $res2['transactionparticular'];

			 $storecode = $res2['store'];

			$query = "select * from master_store where storecode='$storecode' ";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res = mysqli_fetch_array($exec);

						

						$storename = $res["store"];

						

			$query3 = "select categoryname from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$res3categoryname = $res3['categoryname'];

			if ($res3categoryname == $res3categoryname)

			{

			

			/*if ($searchoption1 == 'DETAILED')

			{

				$sumquantity = $res2['quantity'];

				$sumamount = $res2['totalrate'];

			}

			if ($searchoption1 == 'CUMULATIVE')

			{*/

				$sumquantity = $res2['quantity'];

				$sumamount = $res2['totalrate'];

			/*}

			*/

			

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

					$adjustmentaddquantity = round($adjustmentaddquantity, 4);

					$totaladjustmentaddquantity = $totaladjustmentaddquantity + $adjustmentaddquantity;

				}

				if ($res2transactionparticular == 'BY ADJUSTMENT MINUS')

				{

					$adjustmentaddquantity = '';

					$adjustmentminusquantity = $sumquantity;

					$adjustmentminusquantity = round($adjustmentminusquantity, 4);

					$totaladjustmentminusquantity = $totaladjustmentminusquantity + $adjustmentminusquantity;

				}

			}

			else

			{	

				$quantity = '0';

			}

			

			

			/*if ($searchoption1 == 'DETAILED')

			{

				$quantity = $res2['quantity'];

				$stockdate = $res2['transactiondate'];

				$stockremarks = $res2['remarks'];

				$transactionparticular = $res2['transactionparticular'];

			}

			if ($searchoption1 == 'CUMULATIVE')

			{*/

				$quantity = $res2['quantity'];

			/*}*/

			

			

			$quantity = round($quantity, 4);

			

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

			

			?>

            <tr >

              <td  width="24" class="bodytext31" valign="center"  align="left">

			  <?php echo $sno; ?></td>

              <td width="64"  class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $storename; ?></div></td>

              <td width="144"  class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $itemcode.' - '.$itemname; ?></div></td>

              <td width="50"  class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="center"><?php echo $adjustmentaddquantity; ?></div>

              </div></td>

              <td width="66"  class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="center"><?php echo $adjustmentminusquantity; ?></div>

              </div></td>

              <td width="60"  class="bodytext31" valign="center"  align="center"><div class="bodytext31">

			  <?php echo $stockdate; ?></div></td>

              <td width="83"  class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="left"><?php echo $res2transactionparticular; ?></div>

              </div></td>

              <td width="151"  class="bodytext31" valign="center"  align="left"><div align="left">

			  <?php echo $stockremarks; ?>

			  </div></td>

              <td width="98"  class="bodytext31" valign="center"  align="left"><div align="left">

			  <?php echo $userfullname; ?>

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

			

			

			?>

          

            <tr>

              <td  width="24" height="28"  align="left" valign="center" class="bodytext31" 

                >&nbsp;</td>

              <td  width="64" class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td  width="144" class="bodytext32" valign="center"  align="left" 

                ><div align="right"><strong>Total Quantity</strong></div></td>

              <td  width="50" class="bodytext31" valign="center"  align="left" 

                ><div class="style1">

                <div align="center"><strong><?php echo $totaladjustmentaddquantity; ?></strong></div>

              </div></td>

              <td  width="66" class="bodytext31" valign="center"  align="left" 

                ><div class="style1">

                <div align="center"></strong><?php echo $totaladjustmentminusquantity; ?></strong></div>

              </div></td>

              <td  width="60" class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td  width="83" class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td  width="151" class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

                   <td  width="98" class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

            </tr>

            </tbody>

</table>



<?php	

require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4","landscape");

$dompdf->render();

$canvas = $dompdf->get_canvas();

$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("times-roman", "normal");

$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("Adjustment Report.pdf", array("Attachment" => 0)); 



?>