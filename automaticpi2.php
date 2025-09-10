<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$docno = $_SESSION['docno'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frmflag45"])) { $frmflag45 = $_REQUEST["frmflag45"]; } else { $frmflag45 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
//echo $location;
if ($frm1submit1 == 'frm1submit1')
{

}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PO-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript">
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


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function itemcheck(totalcount)
{
var totalcount = totalcount;
for(i=1;i<=totalcount;i++)
{
var supplier=document.getElementById("supplier"+i+"").value;
var itemname = document.getElementById("itemname"+i+"").value;
var packsize = document.getElementById("packsize"+i+"").value;
var requiredquantity = document.getElementById("requiredquantity"+i+"").value;

if(document.getElementById("select"+i+"").value != "")
{
if(supplier == '')
{
alert(itemname+" "+"is not mapped to supplier");
return false;
}
if(packsize == '')
{
alert("Pack Size for"+" "+itemname+" "+"is empty");
return false; 
}
if(requiredquantity == 0)
{
alert("Required Quantity for"+" "+itemname+" "+"Zero");
return false;
}
if(requiredquantity < 0)
{
alert("Required Quantity for"+" "+itemname+" "+"is Negative");
return false;
}
}
}
}

function Valid1()
{
	if(document.getElementById("location").value == "")
	{
		alert("Select Location");
		document.getElementById("location").focus();
		return false;
	}
	if(document.getElementById("store").value == "")
	{
		alert("Select Store");
		document.getElementById("store").focus();
		return false;
	}
}
function storefunction(loc)
{
	var username=document.getElementById("username").value;
	
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("store").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
xmlhttp.send();

}
function Uncheckall()
{
var inputs = document.getElementsByClassName('selectall');
var chklength = inputs.length;
//alert(chklength);
if(document.getElementById('chkall').innerHTML == "Check"){
for(var i=1;i<=chklength;i++){
document.getElementById('select'+i).checked = true;
document.getElementById('chkall').innerHTML = "Uncheck";}
}else{
for(var i=1;i<=chklength;i++){document.getElementById('select'+i).checked = false;
document.getElementById('chkall').innerHTML = "Check"; }
}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
             <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><strong>Automatic PI</strong></td>
             </tr>
               
			  <form method="post" name="form2" id="form2" action="automaticpi2.php" onSubmit="return Valid1();">
			   <tr>
              <td colspan="2" class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"><strong>Location</strong></td>
              <td colspan="9" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">
			  <?php if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; } ?>
			  <select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
              <option value="">-Select Location-</option>
                  <?php
					$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
					$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res = mysqli_fetch_array($exec))
					{
					$reslocation = $res["locationname"];
					$reslocationanum = $res["locationcode"];
					?>
					<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
					<?php 
					}
					?>
                  </select>
				   <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
			  </td>
			 </tr>
			 <tr>
		  <td colspan="2" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Store</strong> </td>
          <td colspan="9" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag45=isset($_REQUEST['frmflag45'])?$_REQUEST['frmflag45']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
                 <select name="store" id="store">
		   <option value="">-Select Store-</option>
           <?php if ($frmflag45 == 'frmflag45')
{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 $query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["storecode"];
				$res5name = $res5["store"];
				//$res5department = $res5["department"];
?>
<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>
<?php }}?>
		  </select>
		  </td>
		  </tr>
		  <tr> 
		  <td colspan="2" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>Date</strong></td>
           <td colspan="9" bgcolor="#FFFFFF" align="left" class="bodytext3">
		   <input type="text" name="ADate1" id="ADate1" readonly value="<?php echo date('Y-m-d'); ?>" size="10"></td>
            </tr>
		  <tr> 
		  <td colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;</td>
           <td colspan="9" bgcolor="#FFFFFF" align="left" class="bodytext3"><input type="hidden" name="frmflag45" id="frmflag45" value="frmflag45">
		   <input type="submit" value="Search" name="submit56">
		   </td>
            </tr>	
			</form>
			<tr>
              <td width="69"  align="left" valign="center" class="bodytext31">&nbsp;</td>
			</tr>  
			<?php
			if($frmflag45 == 'frmflag45')
			{ ?>
			<form method="post" name="form1" action="automaticpi2.php">
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center">
				<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $location; ?>">
				<strong>No.</strong></div></td>
				<td width="25"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
			    <td width="163"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ItemName </strong></div></td>
				<td width="63"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl.Stock</strong></div></td>
				<td width="71"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROL</strong></div></td>
				<td width="77"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Min</strong></div></td>
				<td width="79"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Max</strong></div></td>
              <td width="73"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROQ</strong></div></td>
			    <td width="159"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>
			
			 <td width="70" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pack Size</strong></div></td>
			 <td width="78" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				<td width="77" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
			$location = $_REQUEST['location'];
			$query11 = "select itemcode,itemname,rol,minimum,maximum from master_itemtosupplier where recordstatus <> 'Deleted' and locationcode = '$location' and storecode = '$store' and rol <> '0' group by itemcode order by itemname ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num11 = mysqli_num_rows($exec11);
			while($res11=mysqli_fetch_array($exec11))
			{
			
			$itemcode = $res11['itemcode'];
			$itemname = $res11['itemname'];
			$rol = $res11['rol'];
			$min = $res11['minimum'];
			$max = $res11['maximum'];
			
			$query12 = "select packagename from master_medicine where itemcode = '$itemcode' and status <> 'deleted'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			$res12=mysqli_fetch_array($exec12);
			if($num12==0)
			{
			//echo  '<br>'.$itemcode;
			}
			$packsize = $res12['packagename'];
			
			$query65 = "select suppliercode,suppliername from master_itemtosupplier where itemcode='$itemcode' and locationcode = '$location' and storecode = '$store'";
			$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res65 = mysqli_fetch_array($exec65);
			$suppliername1=$res65['suppliername'];
			$suppliercode1=$res65['suppliercode'];
			$locationcode = $location;
			
			$query8 = "select itemcode,billdate from purchaseorder_details where itemcode = '$itemcode' and locationcode = '$location' and storecode = '$store' and recordstatus<>'deleted' and goodsstatus=''";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8itemcode = $res8['itemcode'];
			$billdate = $res8['billdate'];
			
			if($res8itemcode!='')
			{
				$status='PO is Generated';
			}
			else
			{
				$status='';
			}
			$itemcode = $itemcode;
			//include ('autocompletestockcount1include5.php');
			$reorderquery1 = "select SUM(batch_quantity) as cum_quantity from transaction_stock where itemcode = '$itemcode' and batch_stockstatus='1' and locationcode = '$location' and storecode = '$store'";
			$reorderexec1 = mysqli_query($GLOBALS["___mysqli_ston"], $reorderquery1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$reordernum1 = mysqli_num_rows($reorderexec1);
			$reorderres1=mysqli_fetch_array($reorderexec1);
			$currentstock = $reorderres1['cum_quantity'];	
			if($currentstock=='')
			{
				$currentstock='0';
			}
			$currentstock = $currentstock;
			//echo $rol;
			$roq = $max - $currentstock;
			if($currentstock <= $rol)
			{
			if($roq >= 0)
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
			if($status!='')
			{
				$colorcode = 'bgcolor="#9966FF"';
			}
			?>
			  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div>
			  </td>
			   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?><input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>" id="itemname<?php echo $sno; ?>"></div></td>
				<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $currentstock; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $rol; ?></div></td>
				<input type="hidden" name="rol[]" id="rol<?php echo $sno; ?>" value="<?php echo $rol; ?>">
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $min; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $max; ?></div></td>
			  <input type="hidden" name="max[]" id="max<?php echo $sno; ?>" value="<?php echo $max; ?>">
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $roq; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $suppliername1; ?></div></td>
			  <input type="hidden" name="supplier[]" id="supplier<?php echo $sno; ?>" value="<?php echo $suppliername1; ?>">
		   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $packsize; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $status; ?></div></td>
		<input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packsize; ?>">
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><input type="hidden" class="selectall" name="select[]" id="select<?php echo $sno; ?>" checked="checked" value="<?php echo $itemcode; ?>"></div></td>
            </tr>
			  <?php
			}
			}
			
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
           <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             		 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
           		 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
          </tbody>
        </table></td>
      </tr>
	  <tr>
	   <td align="left" colspan="7"> <a target="_blank" href="print_automaticpixl.php?store=<?= $store;?>&&location=<?= $location;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a> </td>
	  </tr>
	  </form>
	  <?php } ?>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

