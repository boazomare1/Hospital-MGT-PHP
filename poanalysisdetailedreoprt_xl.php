<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="poanalysisdetailedreport_xl.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//if(isset($_REQUEST["viewflag"])){ $viewflag = $_REQUEST["viewflag"];}else{$viewflag = "";}
if(isset($_REQUEST["viewponum"])){ $searchponumber = $_REQUEST["viewponum"];}else{$searchponumber = "";}
//if(isset($_REQUEST["suppnm"])){ $viewsupplier = $_REQUEST["suppnm"];}else{$viewsupplier = "";}

if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}
if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}

$subpo=$searchponumber;
$mlpo=$subpo[0];
 $mlpo;




?>


<body>
<?php 
if($frmflag1 == "frmflag1")
{
?>
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="" align="left" border="1">
          <tbody>
             <tr>
                <td colspan="8" class="bodytext31" align="center" valign="middle"><strong>PO Analysis Detatiled Report</strong></td>
             </tr>
             <tr>
             	<td colspan="4" align="left" valign="middle" class="bodytext31">PO Number : <strong><?php echo $searchponumber;?></strong></td>
                <td colspan="4" align="right" valign="middle" class="bodytext31">From <strong><?php echo $ADate1;?></strong> To <strong><?php echo $ADate2;?></strong></td>
             </tr>
             <tr>
                <td class="bodytext31" valign="middle"  align="center"><strong>No.</strong></td>
			    <td align="left" valign="middle"  class="bodytext31"><strong>Date</strong></td>
				<td align="left" valign="middle" class="bodytext31"><strong>Item Code</strong></td>
                <td align="left" valign="middle" class="bodytext31"><strong>Item Name</strong></td>
				<td align="left" valign="middle" class="bodytext31"><strong>Rate</strong></td>
                <td align="center" valign="middle" class="bodytext31"><strong>Quantity</strong></td>
                <td align="left" valign="middle" class="bodytext31"><strong>Username</strong></td>
                <td align="right" valign="middle" class="bodytext31"><strong>Amount</strong></td>
		     </tr>   
    
<?php
	$totamountval = 0;
	$sno = 0;
	//GET PURCHASE ORDER DETAILS
if($mlpo!='M')
	{
	 $qrypodetailed = "SELECT billdate,itemcode,itemname,rate,packagequantity,username,fxtotamount FROM purchaseorder_details WHERE billnumber = '$searchponumber' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";
	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($respodetailed = mysqli_fetch_array($execpodetailed))
	{
		$billdate = $respodetailed["billdate"];
		$itemcode = $respodetailed["itemcode"];
		$itemname = $respodetailed["itemname"];
		$rate = $respodetailed["rate"];
		$pkgqnty = $respodetailed["packagequantity"];
		$username = $respodetailed["username"];
		$fxamount = $respodetailed["fxtotamount"];
		
		$totamountval = $totamountval + $fxamount;
	?>
    <tr>
    	<td class="bodytext31" valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $rate;?></td>
        <td class="bodytext31" valign="middle"  align="center"><?php echo $pkgqnty;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $username;?></td>
        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount, 2, '.', ',');?></td>
    </tr>
    <?php	
	}//while--close
	}
	
	if($mlpo=='M')
	{
	  $qrypodetailed = "SELECT entrydate,suppliercode,itemname,rate,quantity,username,totalamount FROM manual_lpo WHERE billnumber = '$searchponumber' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";
	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($respodetailed = mysqli_fetch_array($execpodetailed))
	{
		$billdate = $respodetailed["entrydate"];
		//$itemcode = $respodetailed["itemcode"];
		$itemname = $respodetailed["itemname"];
		$rate = $respodetailed["rate"];
		$pkgqnty = $respodetailed["quantity"];
		$username = $respodetailed["username"];
		$fxamount = $respodetailed["totalamount"];
		
		$totamountval = $totamountval + $fxamount;
	?>
    <tr>
    	<td class="bodytext31" valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php //echo $itemcode;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $rate;?></td>
        <td class="bodytext31" valign="middle"  align="center"><?php echo $pkgqnty;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $username;?></td>
        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount, 2, '.', ',');?></td>
    </tr>
    <?php	
	}//while--close
	}
?> 
	<tr>
    	<td colspan="6">&nbsp;</td>
    	<td class="bodytext31" valign="middle"  align="right"><strong>Total</strong></td>
        <td class="bodytext31" valign="middle"  align="right"><strong><?php echo number_format($totamountval, 2, '.', ',');?></strong></td>
    </tr> 
         </tbody>
        </table>
<?php	
}
?>
 
</body>
</html>

