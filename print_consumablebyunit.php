<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Consumablereport.xls"');
header('Cache-Control: max-age=80'); 

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
  $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;
  $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	$locationcode=$location;
	}
$data = '';
$status = '';
$searchsupplier = '';

$fromstore=isset($_REQUEST['fromstore'])?$_REQUEST['fromstore']:"";
$tostore=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:"";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST[frmflag1];
/*if ($frmflag1 == 'frmflag1')
{
	$searchsupplier = $_REQUEST['searchsupplier'];
	$status = $_REQUEST['status'];
}*/

$indiatimecheck = date('d-M-Y-H-i-s');
$foldername = "dbexcelfiles";
//$checkfile = $foldername.'/SupplierList.xls';
//if(!is_file($checkfile))
//{
$tab = "\t";
$cr = "\n";

//$data = "BILL Number: " . $tab .$billnumber. $tab . $tab . $tab ."BILL PARTICULARS". $tab. $cr. $cr;

$data .= "Supplier".$tab."Location" . $tab . "City" . $tab . "Phone1" . $tab . "Phone2" . $tab."Email1". $tab . "Email2" . $tab . "Fax1" . $tab . "Fax2" . $tab . "Address1". $tab . "Address2". $tab . $cr;

$i=0;


$query2 = "select * from master_supplier where status like '%$status%'  order by suppliername";// desc limit 0, 100";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
$res2supplieranum = $res2['auto_number'];
$res2suppliername = $res2['suppliername'];
//$res2contactperson1 = $res2['contactperson1'];
$res2location = $res2['area'];
$res2phonenumber1 = $res2['phonenumber1'];
$res2phonenumber2 = $res2['phonenumber2'];
$res2emailid1 = $res2['emailid1'];
$res2emailid2 = $res2['emailid2'];
$res2faxnumber1 = $res2['faxnumber'];
$res2faxnumber2 = '';
$res2anum = $res2['auto_number'];
$res2address1 = $res2['address1'];
$res2address2 = $res2['address2'];
$res2city1 = $res2['city'];
$res2suppliercode = $res2['suppliercode'];

$data .= $res2suppliername. $tab . $res2location . $tab . $res2city1 . $tab . $res2phonenumber1 . $tab . $res2phonenumber2 . $tab . $res2emailid1 . $tab . $res2emailid2 . $tab . $res2faxnumber1 . $tab . $res2faxnumber2 . $tab . $res2address1 . $tab . $res2address2 . $tab. $cr;		

}			

/* $data=preg_replace( '/\r\n/', ' ', trim($data) ); //to trim line breaks and enter key strokes.

$fp = fopen($foldername.'/SupplierList.xls', 'w+');
fwrite($fp, $data);
fclose($fp); */

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
window.onload = function()
{
	funcSelectFromStore();
}
function process1()
{
	if (document.form1.fromstore.value == "")
	{
		alert("Select From Store");
		document.form1.fromstore.focus();
		return false;
	}
/*	if (document.form1.tostore.value == "")
	{
		alert("Select To Store");
		document.form1.tostore.focus();
		return false;
	}
	if ((document.form1.fromstore.value) == (document.form1.tostore.value))
	{
		alert("From and To store cannot be same");
		document.form1.tostore.value = "";
		document.form1.tostore.focus();
		return false;
	}*/
}

function funcSelectFromStore(id)
{ 
	<?php 
	$query12 = "select * from master_location where status <> 'deleted'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12anum = $res12["auto_number"];
	$res12locationcode = $res12["locationcode"];
	?>
	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{
		document.getElementById("fromstore").options.length=null; 
		var combo = document.getElementById('fromstore'); 
		<?php
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
		<?php
		$query10 = "select * from master_store where location = '$res12anum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10anum = $res10["storecode"];
		$res10store = $res10["store"];
		?>
		var newOptionfm = document.createElement('option');
		newOptionfm.text = "<?php echo $res10store;?>";
		newOptionfm.value = "<?php echo $res10anum;?>";
		if(newOptionfm.value == "<?php echo $fromstore; ?>"){
		newOptionfm.selected = "selected";}
		document.getElementById("fromstore").options.add(newOptionfm, null);
		

		<?php 
		}
		?>
	}
	<?php
	}
	?>
}	
function loadprintpage1(canum)
{
	var varcanum = canum;
	//alert (varqanum);
	window.open("print_renewal1.php?canum="+varcanum+"","Window"+varcanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

</script>
<script src="js/datetimepicker_css.js"></script>
<?php include("js/dropdownlist1scriptingtostore.php"); ?>
<script type="text/javascript" src="js/autocomplete_store.js"></script>
<script type="text/javascript" src="js/autosuggeststore.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="2">
 
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1311" 
            align="left" border="1">
            <tbody>
              <tr>
                <td  class="bodytext31" colspan="12"><strong>STOCK CONSUMPTION REPORT </strong></td>
                </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
                
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
				<td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
				 <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                                
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                ><strong>No.</strong></td>
                
                <td width="5%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong> Doc No </strong></div></td>
                
                <td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong> Store</strong></div></td>                
                <td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong>Date</strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong>Item Code</strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong>Item Name</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong>Category</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong>Batch </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong>Qty. </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong>Rate</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong>Amount</strong></div></td>
				
                <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong>Remarks </strong></div></td>
				
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong>Username </strong></div></td>
              </tr>
			  <?php
			  $colorloopcount = '';
			  $loopcount = '';
			  $totamount = 0;
			 $location=isset($_REQUEST['location'])?$_REQUEST['location']:$res1locationanum;
			if($location=='')
			 {
			$query66 = "select * from master_stock_transfer where typetransfer = 'Consumable' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
			 
			 }
			 else
			 {
			if($fromstore!=''){
			 $query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and typetransfer = 'Consumable' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
			}else
			{
			$query66 = "select * from master_stock_transfer where locationcode = '".$location."' and typetransfer = 'Consumable' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
		
			}
			 }
			 $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res66 = mysqli_fetch_array($exec66))
			 {
			  $itemcode = $res66['itemcode'];
			  $docno = $res66['docno'];
			  $typetransfer = $res66['typetransfer'];
			  $fromstore = $res66['fromstore'];
			  $categoryname = $res66['categoryname'];
			  $transferuser = $res66['username'];
			  $loopcount=$loopcount+1;
			  
			  $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore'");
			  $res22 = mysqli_fetch_array($query22);
			  $fromstore1 = $res22['store'];
			 
			 			  
			  $batch = $res66['batch'];
			  $fifo_code = $res66['fifo_code'];
			  $transaction_quantity = $res66['transferquantity'];
			  $entrydate = $res66['entrydate'];
			  $itemname = $res66['itemname'];
			  $locationname = $res66['locationname'];
			  $expirydate = '';
			   $remarks = $res66['remarks'];
			 			  
			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $rate = $res3['purchaseprice'];
			  
			  $amount = $transaction_quantity * $rate;
			  $totamount = $totamount + $amount;
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	//$colorcode = 'bgcolor="#66CCFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#cbdbfa"';
			  }
			  ?>
              <tr >
                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>
                
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left"><?php echo $docno;?></div>
                </div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				  <div align="left"><?php echo $fromstore1; ?></div>
				</div></td>
               
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo date('d/m/Y',strtotime($entrydate)); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="left">
				<?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $itemname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $categoryname; ?></div></td>

				  
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $batch; ?></div></td>
               
                  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo $transaction_quantity; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="right"><?php echo $rate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($amount,2); ?></div></td>
				  
                  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo $remarks; ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo $transferuser; ?></div></td>
              </tr>
			  <?php
			  //}
			  }
			  ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total : </strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totamount,2); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                
                </tr>
				
            </tbody>
        </table></td>
      </tr>
    </table>
</table>
</body>
</html>

