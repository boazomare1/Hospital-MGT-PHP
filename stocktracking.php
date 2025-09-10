<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$datetimeonly = date("Y-m-d H:i:s");
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];


$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



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
//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['medicinename'];
	//echo $searchsuppliername;
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("||", $searchsuppliername);
		$arraysuppliercode = $arraysupplier[0];
		$arraysuppliername = $arraysupplier[1];
		$arraysuppliername = trim($arraysuppliername);
		
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

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


.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

<?php //include("autocompletebuild_med.php"); ?><!--
<script type="text/javascript" src="js/autosuggestmed.js"></script> 
<script type="text/javascript" src="js/autocomplete_med.js"></script> -->
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<!--<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>-->

<script language="javascript">

$body = $("body");

/* $(document).on({
	
    ajaxStart: function() { $body.addClass("loading");
	//alert('hai');
	    },
     ajaxStop: function() { $body.removeClass("loading"); }    
}); */

function number(event)
{
	var charcode=(event.which)?event.which:event.keycode
	if(charcode>31 && (charcode<47 || charcode >57))
	{
		return false;
	}
		return true;
}
function ajaxlocationfunction(val)
{ 
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
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here


function cbsuppliername1()
{
	document.cbform1.submit();
}

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("medicinename"), new StateSuggestions());        
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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

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
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("location").value == "")
	{
		alert ("Please Select Location");
		document.getElementById("location").focus();
		return false;
	}
	if (document.getElementById("store").value == "")
	{
		alert ("Please Select Store");
		document.getElementById("store").focus();
		return false;
	}
	
	if (document.getElementById("medicinename").value == "")
	{
		//alert ("Enter The Medicine Name");
		//document.getElementById("medicinename").focus();
		//return false;
	}
	
	//if(confirm("Are You Want To Save The Record?")==false){return false;}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
	
	function functioncheklocationandstock()
	{
		if(document.getElementById("location").value=='')
		{
		alert('Please Select Location!');
		document.getElementById("location").focus();
		return false;
		}
		if(document.getElementById("store").value=='')
		{
		alert('Please Select Store!');
		document.getElementById("store").focus();
		return false;
		}
	}
	

	function stockactionchange(obj,sno11)
	{
		var id11='addstock'+sno11;
		var id12='minusstock'+sno11;
		document.getElementById(id11).value='';
		document.getElementById(id12).value='';
		if(obj.value==1)
		{
		document.getElementById(id11).readOnly = false;
		document.getElementById(id12).readOnly = false;
		}
		else if(obj.value==2)
		{
			document.getElementById(id11).readOnly = true;
			document.getElementById(id12).readOnly = false;
		}
		else if(obj.value==3)
		{
			document.getElementById(id11).readOnly = true;
			document.getElementById(id12).readOnly = false;
		}
		else
		{
			document.getElementById(id11).readOnly = true;
			document.getElementById(id12).readOnly = true;
		}
	}
</script>

<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>
<script >
$(document).ready(function(e) {
	$('#medicinename').autocomplete({
		
	source:"ajaxautosearchitempharmcy.php",		// by Kenique 27 Nov 2018
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var citemnamevalue=ui.item.value;
			var citemname=ui.item.citemname;
			var citemcode=ui.item.citemcode;
			$("#searchitem1hiddentextbox").val(citemnamevalue);
			$("#cbsuppliername").val(citemname);
			$("#searchsuppliercode").val(citemcode);
			
			},
	});	
});

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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="stocktracking.php" onSubmit="return paymententry1process2()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Stock Tracking </strong></td>
               <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
           
             
             
             
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td> 
              </tr>
                </tr>
        
       
            <tr>
              <td align="left" valign="middle" bgcolor="#FFFFFF"   class="bodytext3"><strong>Location</strong></td>
              <td   class="bodytext3"  colspan="3" bgcolor="#FFFFFF"><select name="location" id="location"  style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">
              <option value="">Select</option>
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
                   
                
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="104" align="left" bgcolor="#FFFFFF" valign="center" class="bodytext31"><strong>Store</strong> </td>
          <td width="680" align="left" bgcolor="#FFFFFF" valign="center"  class="bodytext31">
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
			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Drug </td>
			<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				<span class="bodytext3">
					<input name="medicinename" type="text" id="medicinename" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
					<input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox" size="50">
				</span>
			</td>
			
		</tr>
		
		<tr>
			<td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Drug </td>
			<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				<input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>
		</tr>
		
		<tr>
			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				<input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
			</td>
			<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				<input type="hidden" name="frmflag1" value="frmflag1">
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				<input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
				<input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />
			</td>
		</tr>
		
	</tbody>
	</table>
	</form>
	</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>
				<input type="hidden" name="locationcodenew" value="<?php echo $location;?>">
<?php
	$colorloopcount=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['medicinename'];
	//$searchsuppliername;
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("||", $searchsuppliername);
			$arraysuppliercode = $arraysupplier[0];
		$arraysuppliername = $arraysupplier[1];
		$arraysuppliername = trim($arraysuppliername);
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$itemcode=$arraysuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
		$itemcode='';
	}
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>SNo.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Item Code</strong></td>
              <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Itemname </strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Fifo Code</strong></div></td>
                
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Transaction Qty </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Batch Qty </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Transaction Function</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Total</strong></div></td>
				<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Status</strong></div></td>
               </tr>
           <?php
             $sno=0;
			$colorloopcount = 0;
			if($itemcode == ''){
				$itemcondition = "itemcode LIKE '%%'";
			}
			else{
				
				$itemcondition = "itemcode = '$itemcode'";
			}
			$itemquery = "SELECT itemcode,itemname FROM master_medicine WHERE $itemcondition AND status <> 'deleted' "; 
			$execitemquery = mysqli_query($GLOBALS["___mysqli_ston"], $itemquery) or die ("Error in itemquery".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resitemquery = mysqli_fetch_array($execitemquery))
			{
				$resitemcode= $resitemquery["itemcode"];
				$resitemname= $resitemquery["itemname"];
				?>
					<tr>
					<td colspan="8" align="left" bgcolor='#B6E3E8'><b><?php echo $resitemname ?></b></td>
					</tr>
				<?php
				
				 $querybatstock2 = "select fifo_code from transaction_stock where  itemcode='$resitemcode' and locationcode='$locationcode' and storecode ='$store' GROUP BY fifo_code";
				$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resbatstock2 = mysqli_fetch_array($execbatstock2))
				{
					$runningtotal=0;
					$fifo_code = $resbatstock2["fifo_code"];
					?>
					<tr>
					<td colspan="8" align="left" bgcolor = "#FFA78F" ><b>FIFO - <?php echo $fifo_code ?></b></td>
					</tr>
					<?php				
					$querybatstock3 = "select auto_number,itemname,transaction_quantity,batch_quantity,transactionfunction,batch_stockstatus from transaction_stock where  itemcode='$resitemcode' and locationcode='$locationcode' and storecode ='$store' AND fifo_code ='$fifo_code' ";
					$execbatstock3 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock3) or die ("Error in batQuery3".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					while($resbatstock3 = mysqli_fetch_array($execbatstock3))
					{
						$itemname = $resbatstock3["itemname"];
						$transactionquantity = $resbatstock3["transaction_quantity"];
						$batchquantity = $resbatstock3["batch_quantity"];
						$transactionfunction = $resbatstock3["transactionfunction"];
						$auto_number = $resbatstock3["auto_number"];
						$status = $resbatstock3["batch_stockstatus"];
						if($transactionfunction == 0){
							$runningtotal = $runningtotal - $transactionquantity;
						}
						else{
							$runningtotal = $runningtotal + $transactionquantity;
						}

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
					if($runningtotal != $batchquantity){
						$colorcode = 'bgcolor="#F7FF00"';
						
						/* echo $updatebatchqty = "UPDATE transaction_stock SET batch_quantity = '$runningtotal' WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store' AND auto_number = '$auto_number' ";
						$execbatchqty = mysql_query($updatebatchqty) or die ("Error in updatebatchqty".mysql_error());
						echo '<br>';
						echo '<br>'; 
			   						
						 echo $updatebatchqty2 = "UPDATE transaction_stock SET  batch_stockstatus = '1' WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store' AND batch_quantity > 0 ORDER BY auto_number DESC LIMIT 1";
						$execbatchqty2 = mysql_query($updatebatchqty2) or die ("Error in updatebatchqty2".mysql_error());
						echo '<br>';
						echo '<br>'; 
						
						echo $updatebatchqty3 = "UPDATE transaction_stock SET  batch_stockstatus = '0' WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store' AND batch_quantity > 0  AND  auto_number  != (SELECT MAX(auto_number) FROM (SELECT auto_number FROM transaction_stock WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store') AS a)";
						$execbatchqty3 = mysql_query($updatebatchqty3) or die ("Error in updatebatchqty3".mysql_error());*/
						?>
							<tr>
							<td colspan="2" >MISMATCH</td>
							</tr>
						<?php
					}
					else{
						//continue;
						
					}
					
						?>
						<tr <?php echo $colorcode; ?>>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo ($sno = $sno + 1)."--".$auto_number; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $resitemcode; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $itemname; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $fifo_code; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $transactionquantity; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $batchquantity; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $transactionfunction; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $runningtotal; ?></td>
							<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $status; ?></td>
						</tr>
					   <?php 
					}
			   
				}
			
			}
		   ?>
           
            <tr>
              <td class="bodytext311" colspan="8" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
          </tbody>
        </table>
<?php
}

?>	
		
		
		
		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
  <script>
  	function doSave(){
		document.getElementById("doSaveButton").disabled = true;
		return true;
	}
  </script>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

