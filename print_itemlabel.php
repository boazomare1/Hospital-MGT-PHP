<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  
 // header("Content-Disposition: attachment; filename=sample.pdf");
  
 
?> 

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext41 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 16px; COLOR: #000000; 

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  }

</style>

<?php 



if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; }
if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
}

	

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }
if ($frmflag1 == 'frmflag1')
{
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';

			$salesquantity = '';
			$salesreturnquantity = '';
			$purchasequantity = '';
			$purchasereturnquantity = '';
			$adjustmentaddquantity = '';
			$adjustmentminusquantity = '';
			$totalsalesquantity = '';
			$totalsalesreturnquantity = '';
			$totalpurchasequantity = '';
			$totalpurchasereturnquantity = '';
			$totaladjustmentaddquantity = '';
			$totaladjustmentminusquantity = '';
			$transferquantity1 = '';
			$transferquantity = '';
			
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';
			$grandtotalcogs = '';
			$grandtotalcogs = '0.00';
			
			if($searchitemcode == ''){ $searchcode = $servicename; } else { $searchcode = $searchitemcode; }
			$rateperunitvar = $location.'_rateperunit';
			if($store=='')
               $store_search = "like '%$store%'";
			else
               $store_search = "='$store'";
			if($categoryname=='')
				$cate_search = "like '%$categoryname%'";
			else
               $cate_search = "='$categoryname'";
			if($searchcode=='')
			{
				$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode $store_search and a.categoryname $cate_search and  b.recorddate <= '$transactiondateto' group by a.itemcode";
			}
			else
			{
$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode $store_search and a.itemcode = '$searchcode' and a.categoryname $cate_search  and b.recorddate <= '$transactiondateto' group by a.itemcode";
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$costprice = $res2['purchaseprice'];
			$res2categoryname = $res2['categoryname'];
			
			$query123 = "SELECT itemname FROM master_medicine WHERE itemcode = '$itemcode'";
			$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die ("Error in Query123".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res123 = mysqli_fetch_array($exec123);
			$itemname = $res123['itemname'];
			
			$query1232 = "SELECT store FROM master_store WHERE storecode = '$store'";
			$exec1232 = mysqli_query($GLOBALS["___mysqli_ston"], $query1232) or die ("Error in Query1232".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1232 = mysqli_fetch_array($exec1232);
			$storename = $res1232['store'];
			
			
			$itemrate = $res2[$location.'_rateperunit']; 
			$itempackageanum = $res2['packageanum'];
			$res2packagename = $res2['packagename'];
			if($res2packagename == '')
			{
			$res2packagename='1S';
			}
			$res2packagename = stripslashes($res2packagename);
			
			$itempackageanum = '14';
			//To calculate price for packaged items to divide by number of items count.
			$query31 = "select quantityperpackage from master_packagepharmacy where auto_number = '$itempackageanum'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
			
			@$itemrate = $itemrate / $quantityperpackage;
			$itemrate = number_format($itemrate, 2, '.', '');
			@$itempurchaserate = $purchaseprice / $quantityperpackage;
			$itempurchaserate = number_format($itempurchaserate, 2, '.', '');
			
			$query77 = "select batchnumber from transaction_stock where itemcode='$itemcode' and locationcode='$location' and storecode $store_search and recorddate <= '$transactiondateto' group by batchnumber";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res77 = mysqli_fetch_array($exec77))
			{
			$batchnumber = $res77['batchnumber'];
			
			$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='1'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock1 = $res1['currentstock'];

			$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='0'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock2 = $res1['currentstock'];

			$currentstock= $currentstock1-$currentstock2;

			$query33 = "select rate from transaction_stock where itemcode='$itemcode' and locationcode='$location' and batchnumber='$batchnumber' and recorddate <= '$transactiondateto' and storecode $store_search order by recorddate desc limit 0,1";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numLab1 = mysqli_num_rows($exec33);
            //if($numLab1>0){
			$res33 = mysqli_fetch_array($exec33);
			  $costprice = $res33['rate'];
			
			$query1 = "select sum(transaction_quantity) as sumpurchase,sum(totalprice) as totalpurchaseamount from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and docstatus='New Batch' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalpurchase = $res1['sumpurchase'];
			$totalpurchaseamount = $res1['totalpurchaseamount'];
			
			$query1 = "select sum(transaction_quantity) as sumsales from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description in('Sales','IP Direct Sales','IP Sales') and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsalesquantity = $res1['sumsales'];
			//$totalpurchaseamount = $res1['totalpurchaseamount'];
			
			$query1 = "select sum(transaction_quantity) as sumreturn from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description in('Sales Return','IP Sales Return') and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsalesreturn = $res1['sumreturn'];
			//$totalpurchaseamountreturn = $res1['totalpurchaseamount'];			
			
			$query34 = "select sum(transaction_quantity) as transferquantity,sum(totalprice) as transferamount from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description = 'Stock Transfer To' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res34 = mysqli_fetch_array($exec34);
		    $transferquantity = $res34['transferquantity'];	
			$transferamount = $res34['transferamount'];
			
			 $query6 = "select expirydate,batchnumber,itemname from purchase_details where batchnumber = '$batchnumber' and itemcode = '$itemcode'";
			 $exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res6 = mysqli_fetch_array($exec6);
			 $res6expirydate=$res6['expirydate'];
			 $res6batchnumber=$res6['batchnumber'];
			 $res6expirydate = strtotime($res6expirydate); 
			
			
			
			
			
			if(($totalpurchase == '') && ($transferquantity != ''))
			{
			$totalpurchase = $transferquantity + $transferquantity;
			$totalpurchaseamount = $transferamount + $transferamount;
			}
			
			if ($currentstock > 0)
			{			
			$colorloopcount = $colorloopcount + 1;
			
			
			$sno = $sno + 1;
			//echo $itemrate;
			$totalitemrate = $itemrate * $currentstock;
			$totalitemrate = number_format($totalitemrate, 2, '.', '');
			$totalpurchaseprice = $totalpurchaseamount;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			if($totalpurchase==0)
			{$purchaseprice= number_format($totalpurchaseprice, 2, '.', '');}
			else
			{
				$purchaseprice = $totalpurchaseprice/intval($totalpurchase);
				$purchaseprice = number_format($purchaseprice, 2, '.', '');
			}
			
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			$totalinventoryvalue = $currentstock * $costprice;
			$totalinventoryvalue = number_format($totalinventoryvalue, 2, '.', '');
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalinventoryvalue;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');
			$cogs = ($totalsalesquantity - $totalsalesreturn)*$costprice;
			if($cogs < 0)
			{
			$cogs = 0;
			}
			$grandtotalcogs = $grandtotalcogs + $cogs;
			$cogs = number_format($cogs, 2, '.', '');
			

			?>

   <page>

  <table border="0" cellpadding="0" cellspacing="0" align=''>
  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
   
<td>
     <table border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="left" valign="center" colspan="2"  bgcolor="#ffffff" class="bodytext41">&nbsp;</td>
    </tr>
	
	 <tr>
    <td  align="left" valign="center" colspan="2"   bgcolor="#ffffff" class="bodytext41">&nbsp;</td>
    </tr>
	
  <tr>
    <td  align="left" valign="center"   bgcolor="#ffffff" class=""><b>CODE  :</b></td>
	 <td  align="left" valign="center"   bgcolor="#ffffff" class=""><b><?php echo $itemcode; ?></b></td>
    </tr>
	<tr>
    <td   align="left" valign="center"   colspan="2"  bgcolor="#ffffff"  class=""><b><?php echo $itemname; ?></b></td>
  </tr>
  <tr>
    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b>BATCH :</b></td>
	<td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b><?php echo $batchnumber; ?></b></td>
  </tr>
  <tr>
    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b>EXP DT :</b></td>
	    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b><?php echo date('m/y',$res6expirydate);?></b></td>
  </tr>
  <tr>
    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b>STORE :</b></td>
	<td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b><?php echo $storename; ?></b></td>
  </tr>
</table>

</td>

</tr>
 
</table>
</page>

 <?php 
			$currentstock = '';
			$itemrate = '';
			$totalitemrate = '';
			
			}
			}
			}
			$grandtotalcogs = number_format($grandtotalcogs, 2, '.', '');
			if($totalpurchaseprice1 == '')
			{
			$totalpurchaseprice1 = 0;
			}
			}
			

				

?>

<?php	

$content = ob_get_clean();
// convert in PDF
try
{
$html2pdf = new HTML2PDF('L', array(50,80),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
$fileName = 'Item_labels_' . $storename . '.pdf';
//$html2pdf->Output($fileName);
$html2pdf->Output($fileName, 'D');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
} 
?>

