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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
    $patientname=$_REQUEST['patientname'];
	$patientcode=$_REQUEST['patientcode'];
	$visitcode=$_REQUEST['visitcode'];
	$account=$_REQUEST['account'];
	$totalamount=$_REQUEST['totalamount'];
	$locationcode=$_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
		   
	$totalamount=$_REQUEST['totalamount'];
	
	$billdate=date('Y-m-d');
	//echo $_POST['typename'];
	foreach($_POST['typename'] as $key => $value)
		{
			//echo 'ok',$key;
		$typename=$_POST['typename'][$key];
		//echo $typename;
		$description=$_POST['description'][$key];
		$calories=$_POST['calories'][$key];
		$amountkitchen=$_POST['amountkitchen'][$key];
		$freestatus=$_POST['freestatus'][$key];
		
	
		if($typename != '')
		{
		$query65="insert into ipkitchen (patientcode,patientvisitcode,patientname,accountname,total,billdate,rate,typename,description,calories,freestatus,locationname,locationcode)
	values ('".$patientcode."','".$visitcode."','".$patientname."','".$account."','".$totalamount."','".$billdate."','".$amountkitchen."','".$typename."','".$description."'
	,'".$calories."','".$freestatus."','".$locationname."','".$locationcode."')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		}
	//header("location:ipkitchen.php");
	//exit;
	
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

include ("autocompletebuild_customeripbilling.php");
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
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
<script type="text/javascript" src="js/insertnewitemkitchen.js"></script>

<?php include ("js/dropdownlistipkitchen.php"); ?>

<script type="text/javascript" src="js/autocomplete_ipkitchen.js"></script>
<script type="text/javascript" src="js/autosuggestipkitchen.js"></script> 
<script type="text/javascript" src="js/autoipkitchensearch.js"></script>

<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>
<script language="javascript">
function isNumberDecimal(evt) {
        //getting key code of pressed key  
        var charCode = (evt.which) ? evt.which : evt.keyCode
  //comparing pressed keycodes
  
        if (  (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        return true;
    }
	
	
function btnDeleteClick1(delID1,vrate1)
{

	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	alert('ok');
	
	var totalamount = document.getElementById ('totalamount').value; //alert(varDeleteID1);
	//alert(totalamount); alert('amountkitchen'+varDeleteID1);
	var amountkitchen = document.getElementById('amountkitchen1'+varDeleteID1).value;
	//alert(document.getElementById('amountkitchen1151').value);
	//alert(amountkitchen);
	alert(parseFloat(totalamount)-parseFloat(amountkitchen));
	document.getElementById ('totalamount').value=parseFloat(totalamount)-parseFloat(amountkitchen);
	
	
	//end of minus 
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	
	//var currenttotal3=document.getElementById('total1').value;
//	//alert(currenttotal);
//	newtotal3= currenttotal3-vrate1;
//	newtotal3=newtotal3.toFixed(2);
//	//alert(newtotal3);
//	
//	document.getElementById('total1').value=newtotal3;
//	if(document.getElementById('total').value=='')
//	{
//	 totalamount11=0;
//	//alert(totalamount11);
//	}
//	else
//	{
//	totalamount11=document.getElementById('total').value;
//	}
//	if(document.getElementById('total2').value=='')
//	{
//	 totalamount21=0;
//	//alert(totalamount21);
//	}
//	else
//	{
//	totalamount21=document.getElementById('total2').value;
//	}
//	if(document.getElementById('total3').value=='')
//	{
//	 totalamount31=0;
//	//alert(totalamount31);
//	}
//	else
//	{
//	 totalamount31=document.getElementById('total3').value;
//	}
//	if(document.getElementById('total5').value=='')
//	{
//	 totalamount41=0;
//	//alert(totalamount41);
//	}
//	else
//	{
//	 totalamount41=document.getElementById('total5').value;
//	}
//	if(document.getElementById('totalr').value=='')
//	{
//	totalamountrr=0;
//	}
//	else
//	{
//	totalamountrr=document.getElementById('totalr').value;
//	}
//	
//	
//	newgrandtotal3=parseFloat(totalamount11)+parseFloat(newtotal3)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
//	//alert(newgrandtotal3);
//	document.getElementById('total4').value=newgrandtotal3.toFixed(2);
	
	

}

function submitform()
{
	if(document.getElementById("serial1").value==1)
	{
		if(document.getElementById("typename").value=='')
		{
			alert("Please Select Name");
			document.getElementById("typename").focus();
			return false;
			}
		if(document.getElementById("description").value=='')
		{
			alert("Please Enter Description");
			document.getElementById("description").focus();
			return false;
			}
		if(document.getElementById("calories").value=='')
		{
			alert("Please Enter Calories");
			document.getElementById("calories").focus();
			return false;
			}
		if((document.getElementById("amountkitchen").value=='')&&(document.getElementById("freestatus").value=='No'))
		{
			alert("Please Enter Amount");
			document.getElementById("amountkitchen").focus();
			return false;
			}
		}
		form11.method="post";
		form11.action="ipkitchen.php";
		form11.submit();
	}






	
function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2(); 
	//To handle ajax dropdown list.
	funcPopupOnLoad1();
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


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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

<script>
function funcPopupOnLoad1()
{
<?php  
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }
?>
var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";
var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";
var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";
//alert(billnumbers);
	if(patientcodes != "") 
	{
		window.open("print_ipfinalinvoice1.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
}


</script>

<script src="js/datetimepicker_css.js"></script>



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
		
		
              <form name="cbform1" method="post" action="ipkitchen.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Master Kitchen</strong></td>
              </tr>
          <tr>
          				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="location" id="location"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationcode; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
                  </td>
				  </tr>

           <tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
				
             
              <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input   type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
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

	$searchpatient = $_POST['customer'];
	$searchlocation = $_POST['location'];
	
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Type.</strong></div></td>
					 <td width="22%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
					 <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
			<!-- <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
			
				    <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Credit Approval</strong></div></td>-->
			
              </tr>
           <?php
		  
		  if($searchpatient != '')
		  { 
           $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $paymentstatus = $res34['paymentstatus'];
		//   $creditapprovalstatus = $res34['creditapprovalstatus'];
		  
		   $query71 = "select * from ip_discharge where locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 == 0)
		   {
		   $status = 'Active';
		   }
		   else
		   {
		   $status = 'Discharged';
		   }
		   
		   $query82 = "select * from master_ipvisitentry where locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $accountname = $res82['accountfullname'];
		   
		   $patientlocationcode = $res82['locationcode'];
		   $patientlocationname = $res82['locationname'];
		   
		   $type = $res82['type'];
		   if($type=='hospital')
		   {
			$type='H';   
		   }
		   if($type=='private')
		   {
			$type='P';   
		   }
		 
		   if($paymentstatus == '')
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
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $type; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div>
                <input type="hidden" name="patientname" value="<?php echo $patientname;?>">
                <input type="hidden" name="patientcode" value="<?php echo $patientcode;?>">
                <input type="hidden" name="visitcode" value="<?php echo $visitcode;?>">
                <input type="hidden" name="account" value="<?php echo $accountname;?>">
                
                <input type="hidden" name="locationcode" value="<?php echo $patientlocationcode;?>">
                <input type="hidden" name="locationname" value="<?php echo $patientlocationname;?>">
                <?php include ("autocompleteipkitchencode.php"); ?>
                </td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $status; ?></div></td>
				
						<?php /*?><td class="bodytext31" valign="center"  align="center"><a href="creditapprovalrequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Request</a></td><?php */?>
			     </tr>
		  <?php
		  
		  }
		 }
		  }
           ?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				  
			</tr>
			
          </tbody>
        </table>
<?php
}
?>	
		 <form name="form11" id="form11" method="post" action="ipkitchen.php">	
     <table>
       <tr class="bodytext311">
       	<td>Name</td><td>Description</td><td>Calories</td><td>Amount</td><td>Free</td>
       </tr>
       <tr> <div id="insertrow1">					 </div></tr>
       <tr>			 <input type="hidden" name="patientname" value="<?php echo $patientname;?>">
                <input type="hidden" name="patientcode" value="<?php echo $patientcode;?>">
                <input type="hidden" name="visitcode" value="<?php echo $visitcode;?>">
                <input type="hidden" name="account" value="<?php echo $accountname;?>">
                
                <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $patientlocationcode;?>">
                <input type="hidden" name="locationname" id="locationname" value="<?php echo $patientlocationname;?>">
                
					 
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td >
                       <input type="text" name="typename[]" id="typename">
                          <!-- <option value="">Select Name</option>
                           <option value="Breakfast">Breakfast</option>
                           <option value="Lunch">Lunch</option>
                           <option value="Dinner">Dinner</option>
                       </select>-->
                       <input type="hidden" name="serial1" id="serial1" value="1"> 
					  <input type="hidden" name="serialnumber1" id="serialnumber1" value="1">
                     
					  <input type="hidden" name="typecode" id="typecode" value="">
                       
                      </td>
				      <td ><input name="description[]" type="text" id="description"  size="60"></td>
                      <td ><input name="calories[]" type="text" id="calories"  size="8" onKeyPress="return isNumberDecimal(event)"></td>
                      <td ><input name="amountkitchen[]" type="text" id="amountkitchen"  size="8" onKeyPress="return isNumberDecimal(event)"></td>
                       <td >
                       <select name="freestatus[]" id="freestatus">
                           <option value="No">No</option>
                           <option value="Yes">Yes</option>
                       </select>
                       </td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem2()" class="button" >
                       </label></td>
					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">&nbsp;</div></td>
					  
					   <td height="28" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">
				 </td>
                  </tr>
                  <tr><td colspan="5" class="bodytext31" align="right"><b>Total :</b><input type="text" name="totalamount" id="totalamount" value="" readonly></td>
                  <input type="hidden" name="frmflag2" value="frmflag2">
                  </tr>
                  <tr><td colspan="5" class="bodytext31" align="right"><input type="button" value="Submit" onClick="submitform()"></td></tr>
                  </table>
                  </form>
     </td>
      </tr>
	  
	  
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

