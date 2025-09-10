<?php
session_start();
ob_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
//This include updatation takes too long to load for hunge items database.
?>
<script>
//This include updatation takes too long to load for hunge items database.
<?php
if (isset($_REQUEST["billno"])) {} 
?>
</script>

<?php 
if (isset($_REQUEST["customer"])) { $customer = $_REQUEST["customer"]; } else { $customer = ""; }
if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	$patientcode = $_REQUEST['patientcode'];
	$accountname = $_REQUEST['accountname'];
	$planname = $_REQUEST['planname'];
	$availablelimit = $_REQUEST['availablelimit'];
	$availablelimit = str_replace(',','',$availablelimit);
	$availablelimitip = $_REQUEST['availablelimitip'];
	$availablelimitip = str_replace(',','',$availablelimitip);
	
	foreach($_REQUEST['d_patientcode'] as $key => $value)
	{
		$d_patientcode = $_REQUEST['d_patientcode'][$key];
		$d_patientname = $_REQUEST['d_patientname'][$key];
		$d_accountname = $_REQUEST['d_accountname'][$key];
		$d_planname = $_REQUEST['d_planname'][$key];
		$d_oppercent = $_REQUEST['d_oppercent'][$key];
		$d_ippercent = $_REQUEST['d_ippercent'][$key];
		$d_opoverall = $_REQUEST['d_opoverall'][$key];
		$d_opoverall = str_replace(',','',$d_opoverall);
		$d_ipoverall = $_REQUEST['d_ipoverall'][$key];
		$d_ipoverall = str_replace(',','',$d_ipoverall);
		if($d_patientcode != '')
		{
			$query99 = "INSERT INTO `family_dependant`(`primary_code`, `primary_account`, `primary_plan`, `primary_availablelimit`, `primary_availablelimitip`, `dependant_code`, `dependant_oplimit`, `dependant_iplimit`, `username`, `ipaddress`, `updatedatetime`) 
			VALUES ('$patientcode', '$accountname', '$planname', '$availablelimit', '$availablelimitip', '$d_patientcode', '$d_opoverall', '$d_ipoverall', '$username', '$ipaddress', '$updatedatetime')";
			$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query98 = "UPDATE master_customer SET overalllimit = '$d_opoverall', ipoveralllimit = '$d_ipoverall' WHERE customercode = '$d_patientcode'";
			$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die ("Error in Query98".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	
	header("location:familylimitupdate.php?st=success");
	exit();
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
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
<script type="text/javascript" src="js/insertnewdependant.js"></script>
<script language="javascript">


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

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
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
function validchecking()
{
var customer = document.getElementById("customercode").value;
if(customer == '')
{
	alert("Please Select a Patient");
	document.getElementById("customer").focus();
	return false;
}
}

function ValidSubmit()
{
	var availablelimit = document.getElementById ('availablelimit').value;	
	availablelimit=availablelimit.replace(/,/g,'');
	var availablelimitip = document.getElementById ('availablelimitip').value;
	availablelimitip=availablelimitip.replace(/,/g,'');	
	var totaloplimit = document.getElementById ('totaloplimit').value;	
	totaloplimit=totaloplimit.replace(/,/g,'');
	var totaliplimit = document.getElementById ('totaliplimit').value;
	totaliplimit=totaliplimit.replace(/,/g,'');
	
	if(parseFloat(availablelimit) != parseFloat(totaloplimit))
	{
		alert("OP limit not matching with Available limit");
		return false;	
	}
	if(parseFloat(availablelimitip) != parseFloat(totaliplimit))
	{
		alert("IP limit not matching with Available limit");
		return false;	
	}
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>
$(document).ready(function(e) {
   
	$('#customer').autocomplete({
		
	source:'ajaxcustomerlimitsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			$('#customercode').val(customercode);			
			},
    });
	
	$('.dependantsearch').autocomplete({
		
	source:'ajaxcustomerlimitsearch_1.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			var planname = ui.item.planname;
			$('#d_patientcode').val(customercode);	
			$('#d_accountname').val(accountname);	
			$('#d_planname').val(planname);			
			},
    });
	
	$("#d_patientname").keyup(function(){
		$('#d_patientcode').val("");	
		$('#d_accountname').val("");	
		$('#d_planname').val("");	
	});
		
});

function btnDeleteClick1(delID14)
{
	var varDeleteID14= delID14;
	//alert(varDeleteID14);
	
	var fRet14; 
	fRet14 = confirm('Are You Sure Want To Delete This Entry?'); 
	if (fRet14 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child14 = document.getElementById('idTR'+varDeleteID14);  
	//alert (child3);//tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.

	if (child14 != null) 
	{
		document.getElementById ('insertrow').removeChild(child14);
	}
	
	totalCalc();
}

function totalCalc()
{
	var totaloplimit = 0;	
	var totaliplimit = 0;	
	var sno = document.getElementById ('serialnumber').value;
	for(var i=0;i<=sno;i++)
	{
		if(document.getElementById ('d_opoverall'+i)!=null)
		{
			var op = document.getElementById ('d_opoverall'+i).value;
			op=op.replace(/,/g,'');
			var ip = document.getElementById ('d_ipoverall'+i).value;
			ip=ip.replace(/,/g,'');
			totaloplimit = parseFloat(totaloplimit) + parseFloat(op);
			totaloplimit = totaloplimit.toFixed(2);
			totaliplimit = parseFloat(totaliplimit) + parseFloat(ip);
			totaliplimit = totaliplimit.toFixed(2);
		}
	}
	totaloplimit = totaloplimit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	totaliplimit = totaliplimit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById ('totaloplimit').value = totaloplimit;	
	document.getElementById ('totaliplimit').value = totaliplimit;
}

function limitCalc(id)
{
	var availablelimit = document.getElementById ('availablelimit').value;	
	var availablelimitip = document.getElementById ('availablelimitip').value;	
	var d_oppercent = document.getElementById ('d_oppercent').value;	
	var d_ippercent = document.getElementById ('d_ippercent').value;
	var d_opoverall = document.getElementById ('d_opoverall').value;	
	var d_ipoverall = document.getElementById ('d_ipoverall').value;
	var totaloplimit = document.getElementById ('totaloplimit').value;	
	var totaliplimit = document.getElementById ('totaliplimit').value;
	
	if(d_oppercent==""){ d_oppercent = 0; }
	if(d_ippercent==""){ d_ippercent = 0; }
	if(totaloplimit==""){ totaloplimit = 0; }
	if(totaliplimit==""){ totaliplimit = 0; }
	var op = 0;
	var ip = 0;
	if(id=='P')
	{
		if(parseFloat(d_oppercent)<=100 && parseFloat(d_oppercent) >= 0)
		{
			op = parseFloat(availablelimit) * (parseFloat(d_oppercent)/100);
			op = op.toFixed(2);
			op1 = op.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById ('d_opoverall').value = op1;
			var optotal = parseFloat(totaloplimit) + parseFloat(op);
			if(parseFloat(optotal) > parseFloat(availablelimit))
			{
				alert("OP Limit Greaterthan Available Limit");
				document.getElementById('d_opoverall').value = 0;
				return false;
			}
		} 
		if(parseFloat(d_ippercent)<=100 && parseFloat(d_ippercent) >= 0)
		{
			ip = parseFloat(availablelimitip) * (parseFloat(d_ippercent)/100);
			ip = ip.toFixed(2);
			ip1 = ip.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById ('d_ipoverall').value = ip1;
			var iptotal = parseFloat(totaliplimit) + parseFloat(ip);
			if(parseFloat(iptotal) > parseFloat(availablelimitip))
			{
				alert("IP Limit Greaterthan Available Limit");
				document.getElementById('d_ipoverall').value = 0;
				return false;
			}
		} 
		else
		{
			
		}
	}
	else
	{
		var d_opoverall = document.getElementById('d_opoverall').value;
		d_opoverall=d_opoverall.replace(/,/g,'');
		var optotal = parseFloat(totaloplimit) + parseFloat(d_opoverall);
		if(parseFloat(optotal) > parseFloat(availablelimit))
		{
			alert("OP Limit Greaterthan Available Limit");
			document.getElementById('d_opoverall').value = 0;
			return false;
		}
		var d_ipoverall = document.getElementById('d_ipoverall').value;
		d_ipoverall=d_ipoverall.replace(/,/g,'');
		var iptotal = parseFloat(totaliplimit) + parseFloat(d_ipoverall);
		if(parseFloat(iptotal) > parseFloat(availablelimitip))
		{
			alert("IP Limit Greaterthan Available Limit");
			document.getElementById('d_ipoverall').value = 0;
			return false;
		}
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



<body onLoad="return funcOnLoadBodyFunctionCall()">
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
		
		
              <form name="cbform1" method="post" action="familylimitupdate.php" onSubmit="return validchecking()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Limit Update </strong></td>
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
          <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
           <tr>
				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search </td>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF">
				  <input name="customer" id="customer" value="<?php echo $customer; ?>" style="border: 1px solid #001E6A;" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="<?php echo $customercode; ?>" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;">
                  </td>    
            </tr>
          
            <tr>
            <td colspan="1" bgcolor="#FFFFFF">&nbsp;</td>
            <td colspan="3"  align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
            </td>
            </tr>
			    
             </tbody>
        </table>
		</form>		</td>
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
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_REQUEST['customer'];
	$customercode=$_REQUEST['customercode'];
	
		
?>
<form name="form1" id="form1" method="post" action="familylimitupdate.php">	
	  
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1226" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="13%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="9%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="9%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Plan Name</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>OP Visit Limit</strong></div></td>
                <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>OP Overall Limit</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>OP Available Limit</strong></div></td>
                <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit Limit</strong></div></td>
                <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Overall Limit</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Available Limit</strong></div></td>
				 <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			
              </tr>
           <?php
		  if($searchpatient != '')
		  { 
            $query34 = "select * from master_customer where customercode = '".$customercode."'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['customerfullname'];
		   $patientcode = $res34['customercode'];
		   $accountname = $res34['accountname'];
		   $planname=$res34['planname'];
		   
		   $query4 = "select * from master_accountname where auto_number = '$accountname'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4accountname = $res4['accountname'];
		   
		   $query5 = "select * from master_planname where auto_number = '$planname'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			//$plannameanum = $res4['auto_number'];
			$res4planname = $res5['planname'];
			$res4planstatus = $res5['recordstatus'];
			$res4smartap = $res5['smartap'];
			$planapplicable = $res5['planapplicable'];
			$planstartdate = $res5["planstartdate"];
			$planexpirydate = $res5["planexpirydate"];
			
			$res4planfixedamount = $res34['planfixedamount'];
			$res4planpercentage = $res34['planpercentage'];
			$visitlimit = $res34["visitlimit"];
			$overalllimit = $res34["overalllimit"];
			$ipvisitlimit = $res34["ipvisitlimit"];
			$ipoveralllimit = $res34["ipoveralllimit"];
			
			$patientspent=$res34['opdue'];
			$availablelimit = $overalllimit - $patientspent;
			
			$patientspentip=$res34['ipdue'];
			$availablelimitip = $ipoveralllimit - $patientspentip;
			
			if($planapplicable=='1')
			{
				$query88 = "select sum(plandue) as overallplandue from master_customer where planname = '$planname'";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res88 = mysqli_fetch_array($exec88);
				$overallplandue = $res88['overallplandue'];
				$availablelimit = $overalllimit - $overallplandue;	
				
				$query88ip = "select sum(ipplandue) as overallplandue from master_customer where planname = '$planname'";
				$exec88ip = mysqli_query($GLOBALS["___mysqli_ston"], $query88ip) or die ("Error in Query88ip".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res88ip = mysqli_fetch_array($exec88ip);
				$overallplandueip = $res88ip['overallplandue'];
				$availablelimitip = $ipoveralllimit - $overallplandueip;	
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
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div>
                <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
                <input type="hidden" name="accountname" id="accountname" value="<?php echo $accountname; ?>">
                <input type="hidden" name="planname" id="planname" value="<?php echo $planname; ?>"></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res4planname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($visitlimit,2); ?></div></td>	 	
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($overalllimit,2); ?></div></td>	
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($availablelimit,2); ?></div>
                <input type="hidden" name="availablelimit" id="availablelimit" value="<?php echo $availablelimit; ?>"></td>	 	
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($ipvisitlimit,2); ?></div></td>	
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($ipoveralllimit,2); ?></div></td>	 	
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($availablelimitip,2); ?></div>
                <input type="hidden" name="availablelimitip" id="availablelimitip" value="<?php echo $availablelimitip; ?>"></td>	 	  
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res4accountname; ?></div></td>
				
              </tr>
		  <?php
		  }	   
          ?>
            <tr>
              <td colspan="11" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
            
             <tr>
              <td colspan="11" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#fff"><strong>Select Dependant</strong></td>
			</tr>
            <tr>
            <td colspan="11">
                <table border="0" width="100%" style="border-collapse:collapse;" cellpadding="5" cellspacing="5">
                    <tr bgcolor="#CCC">
                    <td align="left" class="bodytext3"><strong>Patient Code</strong></td>
                    <td align="left" class="bodytext3"><strong>Patient Name</strong></td>
                    <td align="left" class="bodytext3"><strong>Account Name</strong></td>
                    <td align="left" class="bodytext3"><strong>Plan Name</strong></td>
                    <td align="left" class="bodytext3"><strong>OP Limit %</strong> </td>
                    <td align="left" class="bodytext3"><strong>OP Overall Limit</strong> </td>
                    <td align="left" class="bodytext3"><strong>IP Limit %</strong> </td>
                    <td align="left" class="bodytext3"><strong>IP Overall Limit</strong></td>
                    <td align="left" class="bodytext3"><strong>Action</strong></td>
                    </tr>
                    <tbody id="insertrow">
                    </tbody>
                    <tr>
                    <td align="left" class="bodytext3"><input type="text" size="10" name="d_patientcode[]" id="d_patientcode" readonly></td>
                    <td align="left" class="bodytext3"><input type="text" class="dependantsearch" size="35" name="d_patientname[]" id="d_patientname"></td>
                    <td align="left" class="bodytext3"><input type="text" size="35" name="d_accountname[]" id="d_accountname" readonly></td>
                    <td align="left" class="bodytext3"><input type="text" size="10" name="d_planname[]" id="d_planname" readonly></td>
                    <td align="left" class="bodytext3"><input type="text" size="5" name="d_oppercent[]" id="d_oppercent" onKeyUp="return limitCalc('P');"></td>
                    <td align="left" class="bodytext3"><input type="text" name="d_opoverall[]" id="d_opoverall" onKeyUp="return limitCalc('F');"></td>
                    <td align="left" class="bodytext3"><input type="text" size="5" name="d_ippercent[]" id="d_ippercent" onKeyUp="return limitCalc('P');"></td>
                    <td align="left" class="bodytext3"><input type="text" name="d_ipoverall[]" id="d_ipoverall" onKeyUp="return limitCalc('F');"></td>
                    <td align="left" class="bodytext3"><input type="button" name="add" id="add" value="Add" onClick="return insertitem2();"></td>
                    </tr>
                    <tr>
                    <td colspan="5" align="right" class="bodytext3"><strong>Total:</strong></td>
                    <td align="left" class="bodytext3"><strong><input type="text" name="totaloplimit" id="totaloplimit" readonly ></strong></td>
                    <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
                    <td align="left" class="bodytext3"><strong><input type="text" name="totaliplimit" id="totaliplimit" readonly ></strong></td>
                    <td align="left" class="bodytext3"><strong><input type="hidden" name="serialnumber" id="serialnumber" value="1"></strong></td>
                    </tr>
                </table>
            </td>
            </tr>
		  <?php
		  }
		  ?>
          <tr>
          <td align="left" class="bodytext3">
          <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
          <input type="submit" name="submit56" value="Submit" onClick="return ValidSubmit();">
          </td>
          </tr>
          </tbody>
        </table>
         
	  </form>
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
<?php include ("includes/footer1.php"); ?>
</body>
</html>

