<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

date_default_timezone_set('Asia/Calcutta'); 





$docno = $_SESSION['docno'];

$username = $_SESSION['username'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"]; 

$financialyear = $_SESSION["financialyear"];



$data = '';

$user = '';

$status = '';

$searchsupplier = '';



	$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;

	$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;

	$location=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';

	if(isset($_REQUEST['fromstore'])){  $fromstore=$_REQUEST['fromstore']; }else{ $fromstore=''; }
if(isset($_REQUEST['tostore'])){  $tostore=$_REQUEST['tostore']; }else{ $tostore=''; }


	$searchusername=isset($_REQUEST['user'])?$_REQUEST['user']:"";



	if($searchusername =='')

	{

		$searchusername=$username;

	}



	if($location!='')

	{

		$locationcode=$location;

	}



	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_fetch_array($exec2);

	$companyname = $res2["companyname"];

	$address1 = $res2["address1"];

	$area = $res2["area"];

	$city = 

	

	$res2["city"];

	$pincode = $res2["pincode"];

	$phonenumber1 = $res2["phonenumber1"];

	$phonenumber2 = $res2["phonenumber2"];

	$tinnumber1 = $res2["tinnumber"];

	$cstnumber1 = $res2["cstnumber"];

	

	include('convert_currency_to_words.php');

	

	

	$billamount=0;

?>



<?php 

$query2 = "select * from master_location where locationcode = '$locationcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		//$companyname = $res2["companyname"];

		$address1 = $res2["address1"];

		$address2 = $res2["address2"];

//		$area = $res2["area"];

//		$city = $res2["city"];

//		$pincode = $res2["pincode"];

		$emailid1 = $res2["email"];

		$phonenumber1 = $res2["phone"];

		$locationcode = $res2["locationcode"];

//		$phonenumber2 = $res2["phonenumber2"];

//		$tinnumber1 = $res2["tinnumber"];

//		$cstnumber1 = $res2["cstnumber"];

		$locationname =  $res2["locationname"];

		$prefix = $res2["prefix"];

		$suffix = $res2["suffix"];

?>

<style type="text/css">

.bodytext31 { FONT-SIZE: 8px; COLOR: #000000; }

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000; }

.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; }

.bodytext36{ FONT-WEIGHT: normal; FONT-SIZE: 9px; COLOR: #000000; }

.bodytext34 { FONT-SIZE: 22px; COLOR: #000000; vertical-align:bottom;}





table {

   display: table;

   width: 100%;

   table-layout: fixed;

   border-collapse:collapse;

}

.tableborder{

   border-collapse:collapse;

   border:1px solid black;}

.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; text-decoration:underline;}

border{border:1px solid #000000; }

borderbottom{border-bottom:1px solid #000000;}

</style>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
 <?php include('print_header_pdf4.php'); ?>

<!-- <table width="400"  border="" align="center" cellpadding="0" cellspacing="0">

	<tr valign="middle"><td  width="270" class="bodytext32" align="center" >&nbsp;</td></tr>

		<tr valign="middle">

			<td  width="270" class="bodytext34" align="center" ><?php echo "".$locationname; ?>

		      <?php

			$strlen3 = strlen($address1);

			$totalcharacterlength3 = 35;

			$totalblankspace3 = 35 - $strlen3;

			$splitblankspace3 = $totalblankspace3 / 2;

			for($i=1;$i<=$splitblankspace3;$i++)

			{

			$address1 = ' '.$address1.' ';

			}

			?>

            </td>

            </tr>

            <tr valign="middle"  >

			<td  width="270"  class="bodytext35" align="center" nowrap="nowrap" >

				<?php echo "TEL: ".$phonenumber1; ?>

		        <?php

			/*$address3 = "TEL: ".$phonenumber1;

			$strlen3 = strlen($address3);

			$totalcharacterlength3 = 35;

			$totalblankspace3 = 35 - $strlen3;

			$splitblankspace3 = $totalblankspace3 / 2;

			for($i=1;$i<=$splitblankspace3;$i++)

			{

			$address3 = ' '.$address3.' ';

			}*/

			?></td>

		</tr>
 

		



  <tr>

    <td>&nbsp;</td>

  </tr>

  

</table>
 -->


	<table width="80"  border="1" align="center" cellpadding="0" cellspacing="0">

	

		<tbody>

		

			<tr>

				<td colspan="17" align="center" class="bodytext33"> <strong>Stock Request Report</strong> </td>

			</tr>

			

			<?php

			$colorloopcount = '';

			$loopcount = '';

			$tranferqty = '';

			$reqtotamount = 0;

			$transfertotamount = 0;

			$totamount = 0;

			$location=isset($_REQUEST['location'])?$_REQUEST['location']:"";

			//if(1)
			//{

			// $qry62 = "select username from master_internalstockrequest where date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."' and username <> '' group by username order by username";

			// $exec62 = mysql_query($qry62) or die ("Error in Qry62".mysql_error());

			//  while($res62 = mysql_fetch_array($exec62))

			//  {

			//  	$user = $res62['username'];

			?>

			<!-- <tr>

				<td align="left" valign="" colspan="13" class="bodytext32"><strong><?php //echo "Requests By: ".$user."";?></strong></td>

			</tr> -->

			

			<tr>

				<td align="left" class="bodytext32"><strong>No.</strong></td>

				<td align="left" class="bodytext32"><strong>Type</strong></td>

				<td align="left" class="bodytext32"><strong>Doc No </strong></td>

				<td align="left" class="bodytext32"><strong>From Store </strong></td>

				<td align="left" class="bodytext32"><strong>To Store</strong></td>

				<td align="left" class="bodytext32"><strong>Date</strong></td>
				
				<td align="left" class="bodytext32"><strong>Time</strong></td>
				
				<td align="left" class="bodytext32"><strong>Itemcode</strong></td>

				<td align="left" class="bodytext32" width="180" ><strong>Itemname</strong></td>
				
				<td align="left" class="bodytext32"><strong>Request By </strong></td>

				<td align="left" class="bodytext32"><strong>Request Qty </strong></td>
				
				<td align="left" class="bodytext32"><strong>Transfer By </strong></td>

				<td align="left" class="bodytext32"><strong>Transfer Qty </strong></td>

				<td align="left" class="bodytext32"><strong>Status </strong></td>

				<td align="left" class="bodytext32"><strong>Cost </strong></td>

				<td align="left" class="bodytext32"><strong>Total Transfer Value </strong></td>

				<td align="left" class="bodytext32"><strong>Total Request Amt</strong></td>

			</tr>

			

			<?php

			// $query66 = "select *,date(updatedatetime) as entrydate from master_internalstockrequest where  username like '$user' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";

			if($tostore!="" && $fromstore!='' ){  
			  $query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where  fromstore = '".$fromstore."' and tostore = '".$tostore."' and   date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";
			}
			elseif($fromstore!="" && $tostore==''){
				$query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where  fromstore = '".$fromstore."' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";

			}elseif($fromstore=="" && $tostore!=''){

			 $query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where  tostore = '".$tostore."' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";

			}elseif($fromstore=="" && $tostore=='' ){
			  $query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where   date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";
			}

			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res66 = mysqli_fetch_array($exec66))

			{

				$itemcode = $res66['itemcode'];

				$docno = $res66['docno'];

				$type = $res66['typetransfer'];

				if($type == '1')

				{

					$typetransfer = 'Consumable';

				}

				else

				{

					$typetransfer = 'Tranfer';

				}

				$fromstore = $res66['fromstore'];

				$tostore_code = $res66['tostore'];

				$loopcount=$loopcount+1;

				

				$query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore'");

				$res22 = mysqli_fetch_array($query22);

				$fromstore1 = $res22['store'];

				

				$query221 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$tostore_code'");

				$res221 = mysqli_fetch_array($query221);

				$tostore1 = $res221['store'];

			 

				if($typetransfer=="Tranfer" ){						

					$query2a1 = "select sum(transferquantity) as transferquantity ,username from master_stock_transfer where itemcode='$itemcode' AND requestdocno='$docno' ";

					$exec2a1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2a1) or die ("Error in Query2a1".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res2a1 = mysqli_fetch_array($exec2a1);

					$tranferqty = $res2a1["transferquantity"];
					
					$tranferusername = $res2a1["username"];

				}

				
				 $updatedatetime = $res66['updatedatetime'] ;
			 
			 	$res66updatetime =date('h:i a', strtotime($updatedatetime));
				
				$entrydate = $res66['entrydate'];
				
				$itemcode = $res66['itemcode'];

				$itemname = $res66['itemname'];
				
				$res66username = $res66['username'];

				$transaction_quantity = $res66['quantity'];

				$status = $res66['recordstatus'];

				

				$query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res3 = mysqli_fetch_array($exec3);

				$rate = $res3['purchaseprice'];

				

				$requestamount = $transaction_quantity * $rate;

				$reqtotamount = $reqtotamount + $requestamount;

				

				$transferamount = $tranferqty * $rate;

				$transfertotamount = $transfertotamount + $transferamount;

				

				$colorloopcount = $colorloopcount + 1;

				$showcolor = ($colorloopcount & 1); 

				$colorcode = '';

				if ($showcolor == 0)

				{

					//$colorcode = 'bgcolor="#66CCFF"';

				}

				else

				{

					$colorcode = 'bgcolor="#FFFFFF"';

				}

			?>

			

			<tr >

				<td align="center" class="bodytext35" ><?php echo $loopcount; ?></td>

				<td align="center" class="bodytext35" ><?php echo $typetransfer;?></td>

				<td align="left" class="bodytext35" ><?php echo $docno;?></td>

				<td align="left" class="bodytext35" ><?php echo $fromstore1; ?></td>

				<td align="left" class="bodytext35" ><?php echo $tostore1; ?></td>

				<td align="center" class="bodytext35" ><?php echo $entrydate; ?></td>
				
				<td align="center" class="bodytext35" ><?php echo $res66updatetime; ?></td>
				
				<td align="left" class="bodytext35"  ><?php echo $itemcode; ?> </td>

				<td align="left" class="bodytext36" width="180" ><?php echo $itemname; ?> </td>
				
				<td align="left" class="bodytext35" style="text-transform:uppercase;" ><?php echo $res66username; ?></td>

				<td align="center" class="bodytext35" ><?php echo $transaction_quantity; ?></td>
				
				<td align="left" class="bodytext35" style="text-transform:uppercase;" ><?php echo $tranferusername; ?></td>

				<td align="center" class="bodytext35" ><?php echo $tranferqty; ?></td>

				<td align="center" class="bodytext35" ><?php echo $status; ?></td>

				<td align="right" class="bodytext35" ><?php echo $rate; ?></td>

				<td align="right" class="bodytext35" ><?php echo number_format($transferamount,2); ?></td>

				<td align="right" class="bodytext35" ><?php echo number_format($requestamount,2); ?></td>

			</tr>

			

			<?php

			

			}

			?>

			

			<tr>

				<td align="right" colspan="15" ><strong>Total : </strong></td>

				<td align="right" ><strong><?php echo number_format($transfertotamount,2); ?></strong></td>

				<td align="right" ><strong><?php echo number_format($reqtotamount,2); ?></strong></td>

			</tr>

				

			<tr>

				<td colspan="17" >&nbsp;</td>

			</tr> 

			<?php

			// }

			//}

			 ?>

		</tbody>

		

	</table>


</page>


<?php	

	$content = ob_get_clean();

   

    // convert to PDF

   

    try

    {	

		$width_in_inches = 3.38;

		$height_in_inches = 3.38;

		$width_in_mm = $width_in_inches * 25.4; 

		$height_in_mm = $height_in_inches * 25.4;

        $html2pdf = new HTML2PDF('L', 'A3', 'en', true, 'UTF-8', array(0, 0, 0,0));

        $html2pdf->pdf->SetDisplayMode('fullpage');

		$html2pdf->setDefaultFont('Helvetica');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_consultationbill.pdf');

		

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

	

?>

