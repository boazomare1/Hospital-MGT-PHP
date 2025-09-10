<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = "2014-01-01";
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//This include updatation takes too long to load for hunge items database.


//$getcanum = $_GET['canum'];
$locationcode1=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';


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
<?php /*include ("autocompletebuild_package2.php");*/  ?>
<!--<script type="text/javascript" src="js/autosuggestippackage.js"></script>  For searching customer 
<script type="text/javascript" src="js/autocomplete_ippackage1.js"></script>-->
<script>

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

</script>
<script type="text/javascript">
/*window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("packagename"), new StateSuggestions());        
}*/


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
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}

function funcvalid()
{
	if(document.cbform1.package.value == "")
	{
		alert("Please Select Package");
		return false;
	}
}
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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

<script src="js/datetimepicker_css.js"></script>

<body onLoad=" funcOnLoadBodyFunctionCall">
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
        <td>&nbsp;</td>
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
	  
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
	$fromdate=$_REQUEST['from'];
	$todate=$_REQUEST['to'];
	$packagecode = $_REQUEST['pkgid'];
	$status = $_REQUEST['status'];
	if($status == 1)
	{
	$status1 = 'yes';
	}
	else
	{
	$status1='no';
	}
	if($status == 1)
	{
	$status2 = 'FREE';
	}
	else
	{
	$status2='BILLED';
	}
	  
		$query40 = "select packagename from master_ippackage where locationcode='$locationcode1' and auto_number = '$packagecode'";
		$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res40 = mysqli_fetch_array($exec40);
		$packagename = $res40['packagename'];
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr><td colspan="10" bgcolor="#ecf0f5" class="bodytext3"><strong> <?=$status2.' Pharmacy Items - '.$packagename?> </strong></td></tr>
				<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Quantity</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Issued by</strong></div></td>	
			
              </tr>
           
           <?php
        $amount = 0;
		$sno = 0;	
		$colorloopcount=0;
		$query2 = "select patientvisitcode,consultationdate,servicesitemname,iptestdocno,serviceqty,servicesitemrate,username from ipconsultation_services where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  freestatus='$status1' and patientvisitcode in (select visitcode from master_ipvisitentry where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  package='$packagecode' and finalbillno <> '') order by consultationdate ASC";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		
		while($res2 = mysqli_fetch_array($exec2))
		{
		
		$visitcode = $res2['patientvisitcode'];
		$date= $res2['consultationdate'];
		$itemname= $res2['servicesitemname'];
		$docno= $res2['iptestdocno'];
		$qty= $res2['serviceqty'];
		$rate= $res2['servicesitemrate'];
		$username = $res2['username'];
		$item_amt = $qty*$rate;
		$amount +=$item_amt;
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo date('d-m-Y',strtotime($date)); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				    <div align="center"><?php echo $visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docno; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo intval($qty); ?></div></td>
				
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo number_format($rate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo number_format($item_amt,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $username; ?></div></td>
					  
			         </tr>
         
		   <?php 
		   } 
		  
		   ?>
		   <tr>
		   <td colspan="7" bgcolor="#ecf0f5" class="bodytext31" valign="center"  align="right"><strong>Total Amount</strong></td>
		   <td bgcolor="#ecf0f5" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($amount,2,'.',',');?></strong></td>
		   <td bgcolor="#ecf0f5" class="bodytext31" valign="center"  align="right"></td>
		  </tr>
		   
		   </table>
            
			
          </tbody>
        </table>
<?php



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
<?php include ("includes/footer1.php"); ?>
</body>
</html>