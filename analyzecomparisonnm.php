<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$errmsg = '';
$bgcolorcode = '';
$sno = '';
$colorloopcount = '';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frm1submit1 == 'frm1submit1')
{
	
	foreach($_POST['itemname'] as $key => $value)
	{
	$itemname = $_POST['itemname'][$key];
	
	$suppliername =  $_POST['suppliercoa'][$key];
	$suppliercode =  $_POST['suppliercode'][$key];
	
	$paynowbillprefix = 'PO-';
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from master_nmrfqpurchaseorder where suppliercode = '$suppliercode' and recordstatus <> 'generated'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
 	$num2 = mysqli_num_rows($exec2);
	$res2 = mysqli_fetch_array($exec2);
 	$billnumber = $res2["billnumber"];

	$billdigit=strlen($billnumber);
	if($num2 > 0)
	{
	$billnumbercode = $billnumber;
	$status = 'generated';
	}
	else
	{
	$query24 = "select * from master_nmrfqpurchaseorder where recordstatus='generated' or recordstatus='ready' order by auto_number desc limit 0, 1";
	$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res24 = mysqli_fetch_array($exec24);
	$billnumber = $res24['billnumber'];
	$billdigit=strlen($billnumber);
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	
	 $billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;
     
	$maxanum = $billnumbercode;
	$status = 'ready';
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	}
	
	
	 $query56="insert into master_nmrfqpurchaseorder(companyanum,billnumber,itemname,username, ipaddress, billdate,suppliername,suppliercode,recordstatus)
          values('$companyanum','$billnumbercode','$itemname','$username','$ipaddress','$currentdate','$suppliername','$suppliercode','$status')";
	 $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		
	}
	
	$query16 = "update master_nmrfq set status = 'generated' where status = ''";
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query17 = "update master_nmrfqpurchaseorder set recordstatus = 'generated' where recordstatus = 'ready'";
	$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:menupage1.php?mainmenuid=MM029");
}



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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
-->
</style>
</head>
<script language="javascript">

function dataimport1verify()
{
	if (document.getElementById("uploadedfile").value == "")
	{
		alert ("Please Select The TAB Delimited File To Proceed.");
		return false;
	}
}

</script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popupcoasearchcomparison.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function validate()
{
var hasChecked = false;
var k=0;
var serial = document.getElementById("serial").value;

for(j=1;j<=serial;j++)
{

var chks = document.getElementById("paynowlabcode"+j+"").value;

if (chks != '')
{
k=k+1;
}
//alert(k);
//alert(serial);
if(parseInt(k) == parseInt(serial))
{

hasChecked = true;
}
}

if (hasChecked == false)
{
alert("Please select a Supplier for all items or click back button on the browser to exit Analyze Comparison");
return false;
}
return true;
}
</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
     <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
       <td width="97%" valign="top"><form action="analyzecomparisonnm.php" method="post" name="form1" id="form1" onSubmit="return validate()">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td colspan="2">
                  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
					<tr>
	  <td>&nbsp;
	  </td>
	  </tr>
			<tr>
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>NM Analyze</strong></td>
			 
		</tr>
					<tr>
					<td align="center" valign="center" class="bodytext31"><strong>Date</strong></td>
					<td align="left" valign="center" class="bodytext31"><?php echo $currentdate; ?></td>
					<td align="center" valign="center" class="bodytext31"><strong>User</strong></td>
					<td align="left" valign="center" class="bodytext31"><?php echo $username; ?></td>
					</tr>
					</tbody>
                  </table>				  </td>
		  </tr>
		  <tr>
  <td colspan="2">&nbsp;</td>
  </tr>
					<tr>
        <td colspan="2"><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0" >
          <tbody>
		  
		  <tr  bgcolor="#ffffff">
              <td align="left" valign="center" class="bodytext31"><strong>S.No</strong></td>
              <td align="left" valign="center" class="bodytext31" width="200"><strong>ITEM (Quantity)</strong></td>
    <?php
	$query1 = "select * from master_nmrfq where status='' group by suppliername order by auto_number asc";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$suppliername = $res1['suppliername'];
	?>
	 <td align="right" valign="center" class="bodytext31" width="70"><strong><?php echo $suppliername; ?></strong></td>
         
		 <?php
		 }
		 ?> 
		 <td align="left" valign="center" class="bodytext31"><strong>Select Supplier</strong></td>
		 </tr>
		
		 <?php
		 
		 $query11 = "select * from master_nmrfq where status='' and suppliername = '$suppliername' order by auto_number asc";
		 $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res11 = mysqli_fetch_array($exec11))
		 {
		 $itemname = $res11['itemname'];
		 
		 
		 $packagequantity = $res11['quantity'];
		 
		 $sno = $sno + 1;
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
		  <tr <?php echo $colorcode; ?>>
		  <td align="left" valign="center" class="bodytext31"><?php echo $sno; ?></td>
		  <td align="left" valign="center" class="bodytext31"><?php echo $itemname; ?>(<?php echo $packagequantity; ?>)</td>
		  <input type="hidden" name="itemname[]" id="itemname" value="<?php echo $itemname; ?>">
		  
		  <?php
		  $query12 = "select * from master_nmrfq where itemname='$itemname' and status = '' order by auto_number asc ";
		 $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res12 = mysqli_fetch_array($exec12))
		 {
		  $rate = $res12['rate'];
		
		  $query13 = "select min(rate) as lowestrate from master_nmrfq where rate <> '0.00' and itemname='$itemname' and status = ''";
		  $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res13 = mysqli_fetch_array($exec13);
		  $lowestrate = $res13['lowestrate'];
		  
		  $query14 = "select max(rate) as higherrate from master_nmrfq where rate <> '0.00' and itemname='$itemname' and status = ''";
		  $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res14 = mysqli_fetch_array($exec14);
		  $higherrate = $res14['higherrate'];
		  
		  $query15 = "select avg(rate) as averagerate from master_nmrfq where rate <> '0.00' and itemname='$itemname' and status = ''";
		  $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res15 = mysqli_fetch_array($exec15);
		  $averagerate = $res15['averagerate'];
		  
		  if($lowestrate == $rate)
		  {
		  $subcolorcode = 'bgcolor="#40FF00"';
		  }
		  else if($higherrate == $rate)
		  {
		   $subcolorcode = 'bgcolor="#FA5858"';
		  } 
		   else if($averagerate == $rate)
		  {
		  $subcolorcode = 'bgcolor="yellow"';
		  } 
		  else
		  {
		  $subcolorcode = '';
		  }
		 
		  
		 
		  ?>
		  <td align="right" valign="center" class="bodytext31" <?php echo $subcolorcode; ?>><?php echo $rate; ?></td>
		  <?php
		  }
		  ?>
		  <td align="left" valign="center" class="bodytext31">
		   <input type="text" name="suppliercoa[]" id="paynowlabcoa<?php echo $sno; ?>" size="40"/>
						 <input type="button" onClick="javascript:coasearch('<?php echo $sno; ?>')" value="Map" accesskey="m" style="border: 1px solid #001E6A">
						 <input type="hidden" name="paynowlabtype6" id="paynowlabtype<?php echo $sno; ?>" size="10"/>
						 <input type="hidden" name="suppliercode[]" id="paynowlabcode<?php echo $sno; ?>" size="10"/>		  </td>
		  </tr>
		 <?php
		 
		 }
		 ?>
		 <input type="hidden" name="serial" id="serial" value="<?php echo $sno; ?>">
		  </tbody>
		  </table>		 </td>
		 </tr>
				  <tr>
	  <td width="63%"  align="right" valign="center" class="bodytext31">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	 
	    <input type="submit" name="submit" value="Save"></td>
	  <td width="37%"  align="right" valign="center" class="bodytext31">&nbsp;</td>
		  </tr>
        </table>
		</form>
                </td>
            </tr>
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

