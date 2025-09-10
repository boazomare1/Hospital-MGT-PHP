<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$transferquantity2 = '';
$transferamount2 = '0';

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//To populate the autocompetelist_services1.js
//include ("autocompletebuild_item1pharmacy.php");

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

if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
//$servicename = $_REQUEST['servicename'];

//if ($servicename == '') $servicename = 'ALL';

if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<?php include ("js/dropdownlist1scripting1stock1.php"); ?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
<script type="text/javascript">


function stockinwardvalidation1()
{
	
	if (document.stockinward.itemcode.value == "")
	{
		alert ("Please Select Item Name.")
		return false;
	}
	else if (document.stockinward.servicename.value == "")
	{
		alert ("Please Select Item Name.")
		document.stockinward.servicename.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (isNaN(document.stockinward.stockquantity.value))
	{
		alert ("Please Enter Only Numbers Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.00")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.000")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}

}


function itemcodeentry2()
{
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
		//itemcodeentry1();
		return false;
	}
	else
	{
		return true;
	}
}

function Locationcheck()
{
if(document.getElementById("location").value == '')
{
alert("Please Select Location");
document.getElementById("location").focus();
return false;
}
if(document.getElementById("store").value == '')
{
alert("Please Select Store");
document.getElementById("store").focus();
return false;
}
}

//ajax function to get store for corrosponding location
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
</script>
<body onLoad="return funcCustomerDropDownSearch1();">
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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<form name="stockinward" action="" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Closing Stock - Report By Item</strong></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="center"  
                 bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#cbdbfa'; } ?>" class="bodytext31"><?php echo $errmsg; ?>&nbsp;</td>
          </tr>
        <script language="javascript">

function disableEnterKey()
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


function process1rateperunit()
{
	servicenameonchange1();
}


function deleterecord1(varEntryNumber,varAutoNumber)
{
	var varEntryNumber = varEntryNumber;
	var varAutoNumber = varAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete the stock entry no. '+varEntryNumber+' ?');
	//alert(fRet);
	if (fRet == false)
	{
		alert ("Stock Entry Delete Not Completed.");
		return false;
	}
	else
	{
		window.location="stockreport2.php?task=del&&delanum="+varAutoNumber;		
	}
}


</script>
       
         <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
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
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="104" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Store</strong> </td>
          <td colspan="4" width="680" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
                 <select name="store" id="store">
		   <option value="">-Select Store-</option>
           <?php if ($frmflag1 == 'frmflag1')
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
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><select name="categoryname" id="categoryname">
            <?php
			$categoryname = $_REQUEST['categoryname'];
			if ($categoryname != '')
			{
			?>
            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
            <option value="">Show All Category</option>
            <?php
			}
			else
			{
			?>
            <option selected="selected" value="">Show All Category</option>
            <?php
			}
			?>
            <?php
			$query42 = "select categoryname from master_medicine where status = '' group by categoryname order by categoryname";
			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res42 = mysqli_fetch_array($exec42))
			{
			$categoryname = $res42['categoryname'];
			?>
            <option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>
            <?php
			}
			?>
          </select></td>
        </tr>
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Search</strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="itemname" type="text" id="itemname" value="<?php echo $searchitemname; ?>" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off">
		  <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
		  <input type="hidden" name="searchitemcode" id="searchitemcode">
            <input name="searchbutton12" type="submit" id="searchbutton12" style="border: 1px solid #001E6A" value="Search Item Name" /></td>
        </tr>
        <tr>
          <td width="104" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
          <td width="680" colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="servicename" id="servicename">
            <option value="">All Items</option>
           <?php
				$query42 = "select itemcode, itemname from master_medicine where status <> 'DELETED' and itemcode <> '' order by itemname";
				$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res42 = mysqli_fetch_array($exec42))
				{
				$itemcode42 = $res42['itemcode'];
				$itemname42 = $res42['itemname'];
				?>
            <option value="<?php echo $itemcode42; ?>" <?php if($servicename == $itemcode42) { echo 'selected="selected"'; } ?>><?php echo $itemcode42.' - '.$itemname42; ?></option>
            <?php
				}
				?>
          </select>          
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
			<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
          </tr>
		  
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly /></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">&nbsp;		  </td>
          </tr>
      </tbody>
    </table>
    </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="15%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                  <td width="19%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                    <td width="11%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
                     <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			    <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>

            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch Number</strong></td>
				     <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Stock </strong></div></td>
                             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Stock In</strong></div></td>
			      <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Stock Out </strong></div></td>
                <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Balance </strong></div></td>
                <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Fifo Code </strong></div></td>
        
            </tr>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
			//$frmflag1 = $_REQUEST['frmflag1'];
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
			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$rateperunitvar = $location.'_rateperunit';
			if($searchcode=='')
			{

				$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode='$store' and a.categoryname like '%$categoryname%' and a.status <> 'DELETED' group by a.itemcode";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
/*				$query2 = "select auto_number,itemcode,itemname,categoryname,`$rateperunitvar`,packageanum,packagename,purchaseprice from master_medicine where categoryname like '%$categoryname%' and status <> 'DELETED'";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
	*/
			}
			else
			{
				
$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode='$store' and a.itemcode = '$searchcode' and a.categoryname like '%$categoryname%' and a.status <> 'DELETED' group by a.itemcode";
				/*
				$query2 = "select auto_number,itemcode,itemname,categoryname,`$rateperunitvar`,packageanum,packagename,purchaseprice from master_medicine where itemcode = '$searchcode' and categoryname like '%$categoryname%' and status <> 'DELETED'";
		*/
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$costprice = $res2['purchaseprice'];
			$res2categoryname = $res2['categoryname'];
			
			
			$itemrate = $res2[$location.'_rateperunit']; //Unit price is calculated below.
			//$stockdate = $res2['transactiondate'];
			//$stockremarks = $res2['remarks'];
			//$transactionparticular = $res2['transactionparticular'];
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
			
			$query77 = "select batchnumber, fifo_code from transaction_stock where itemcode='$itemcode' and locationcode='$location' and storecode ='$store' group by fifo_code";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res77 = mysqli_fetch_array($exec77))
			{
			$batchnumber = $res77['batchnumber'];
			$fifo_code = $res77['fifo_code'];
			
			$query1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$location' and storecode ='$store' and fifo_code = '$fifo_code'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock = $res1['currentstock'];
			
			$query52 = "select sum(transaction_quantity) as sumpurchase from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode='$store' and transactionfunction='1' and fifo_code = '$fifo_code'";
			$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res52 = mysqli_fetch_array($exec52);
			$totalpurchase = $res52['sumpurchase'];
			
			$query53 = "select sum(transaction_quantity) as sumsales from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode='$store' and transactionfunction = '0' and fifo_code = '$fifo_code'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die ("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$totalsales = $res53['sumsales'];
			
			$balance = $totalpurchase - $totalsales;
			
			if (true)
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
			$st = '';
			if($currentstock != $balance)
			{
				$colorcode = 'bgcolor="#FF0000"';
				$st = 'mismatch';
			}
			
			$sno = $sno + 1;

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno.'. '.$st; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $res2categoryname; ?>&nbsp;</div>
              </div></td>
			  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $batchnumber; ?>&nbsp;</div>
              </div></td>
			    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><?php echo number_format($currentstock,2); ?>&nbsp;</div>
			  </div></td>
             <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo number_format($totalpurchase,2,'.',','); ?>&nbsp;</div>
              </div></td>
			    <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo number_format($totalsales,2,'.',','); ?>&nbsp;</div>
              </div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo number_format($balance,2,'.',','); ?>&nbsp;</div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><strong><a target="_blank" href="stockmovementdetail_update.php?itemcode=<?php echo $itemcode; ?>&store=<?php echo $store; ?>&fifocode=<?php echo $fifo_code; ?>"><?php echo $fifo_code; ?></a></strong></div>
              </div></td>
            </tr>
            <?php
			$currentstock = '';
			$itemrate = '';
			$totalitemrate = '';
			
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
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp; </strong></div></td>
                        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
                   <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
                   
            </tr>
			<?php
			}
			?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
