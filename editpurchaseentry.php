<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$docno = $_REQUEST['docno'];	
	$totalamount=$_POST['totalamount'];
	$totalamount = str_replace(",", "",$totalamount);	
  	foreach($_POST['medicinename'] as $key => $value)
		{
			$medicinename=$_POST['medicinename'][$key];
			$itemcode=$_POST['itemcode'][$key];
		//echo "<br>".$itemcode;
			$reqqty=$_POST['reqqty'][$key];
			$pkgqty=$_POST['pkgqty'][$key];
			$amount=$_POST['amount'][$key];
			
			$amount = str_replace(",", "",$amount);	
			
			$query45="update master_stock set quantity='$pkgqty',totalrate='$amount',allpackagetotalquantity='$pkgqty' where billnumber='$docno' and itemcode='$itemcode'";
			$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			$query46="update master_transactionpharmacy set transactionamount='$totalamount',balanceamount='$totalamount',creditamount='$totalamount' where billnumber='$docno' and transactionmode = 'CREDIT'";
			$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			$query47="update master_transactionpharmacy set transactionamount='$totalamount' where billnumber='$docno' and transactionmode = 'BILL'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			$query48="update master_purchase set totalamount='$totalamount',subtotal='$totalamount',credit='$totalamount' where billnumber='$docno' and billtype='CREDIT'";
			$exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			$query49="update purchase_details set quantity='$reqqty', subtotal='$amount', totalamount='$amount',itemtotalquantity='$pkgqty', allpackagetotalquantity='$pkgqty' where billnumber='$docno' and itemcode='$itemcode'";
			$exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		
		}
		
		header("location:purchaseentrylist.php");
}









if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}

?>



<?php 
if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];
}

?>


<script>
function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}
function calc(serialnumber,totalcount)
{

var grandtotalamount = 0;
var serialnumber = serialnumber;

var totalcount = totalcount;
var reqqty=document.getElementById("reqqty"+serialnumber+"").value;
var packsize=document.getElementById("packsize"+serialnumber+"").value;
var packvalue=packsize.substring(0,packsize.length - 1);
var rate=document.getElementById("rate"+serialnumber+"").value;
var amount=parseFloat(reqqty) * parseFloat(rate);
amount=amount.toFixed(2);
amount=amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("amount"+serialnumber+"").value=amount;

packvalue=parseInt(packvalue);
var pkgqty=reqqty * packvalue;

//alert(reqqty);
document.getElementById("pkgqty"+serialnumber+"").value=Math.round(pkgqty);

for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;
totalamount=totalamount.replace(/,/g,'');
if(totalamount == "")
{
totalamount=0;
}
grandtotalamount=parseFloat(grandtotalamount)+parseFloat(totalamount);
grandtotalamount=grandtotalamount.toFixed(2);
}
grandtotalamount=grandtotalamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("totalamount").value=grandtotalamount;

}
</script>
<script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('app[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
</style>

<script src="js/datetimepicker_css.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="form1" id="frmsales" method="post" action="editpurchaseentry.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <?php
			$query1 = "select * from master_purchase where billnumber='$docno' group by billnumber";
			$exec1= mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec1);
			$res1 = mysqli_fetch_array($exec1);
			$supbillno = $res1['supplierbillnumber'];
			$supname = $res1['suppliername'];
			$supcode = $res1['suppliercode'];
			?>
			 
		
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DOC No</strong></td>
                <td width="27%" align="left" valign="top" class="bodytext3"><?php echo $docno; ?>
				<input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly"/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?>
								</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Bill No</strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $supbillno; ?></td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Name</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $supname; ?>
				
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Code</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $supcode; ?>
					</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;</td>
			    </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
             <tr>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Medicine Name</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pack Qty</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pack Size</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Qty</strong></td>
                      
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Rate</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Amount</strong></td>

                     </tr>
				  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;			
			$query12 = "select * from purchase_details where billnumber='$docno'";
			$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec12);
			
			while($res12 = mysqli_fetch_array($exec12))
         {
		$medicinename = $res12['itemname'];
		$itemcode = $res12['itemcode'];
		
		$reqqty = $res12['quantity'];
		
			$query2 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$package = $res2['packagename'];
			
			$packagequantity = $res12['itemtotalquantity'];
			$rate = $res12['rate'];
			$amount = $res12['totalamount']; 
			$itemcode = $itemcode;
		include ('autocompletestockcount1include1.php');
		$currentstock = $currentstock;
		
		$totalamount= $totalamount + $amount;
		$sno = $sno + 1;
		
?>
  <tr>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medicinename;?></div></td>
		<input type="hidden" name="medicinename[]" value="<?php echo $medicinename;?>">
		<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="reqqty[]" id="reqqty<?php echo $sno ; ?>" value="<?php echo intval($reqqty);?>" size="6" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="packsize[]" id="packsize<?php echo $sno ; ?>" value="<?php echo $package;?>" size="6" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="pkgqty[]" id="pkgqty<?php echo $sno ; ?>" size="6" value="<?php echo intval($packagequantity);?>" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="rate[]" id="rate<?php echo $sno ; ?>" value="<?php echo $rate;?>" size="6" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="amount[]" id="amount<?php echo $sno ; ?>" value="<?php echo number_format($amount,2,'.',',');?>" size="8" class="bal" readonly></div></td>
				</tr>
			<?php 
		
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
				
				 <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><input type="text" name="totalamount" id="totalamount" value="<?php echo number_format($totalamount,'2','.',','); ?>" size="8" class="bal" readonly></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               </tr>
           
          </tbody>
        </table>		</td>
      </tr>
				    
				  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="716">
     <tr>
	 <td width="66" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>User Name</strong></td>
	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <?php echo $username; ?></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
	   <td width="60" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> </td>
	    <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
	   <td width="120" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> </td>
	 </tr>
		</table>
		</td>
		</tr>				
		        
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save" class="button" style="border: 1px solid #001E6A"/>		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>