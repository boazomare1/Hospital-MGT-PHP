<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$grandtotal='0.00';

$docno = $_SESSION['docno'];
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$res21itemname='';
$res21itemcode='';
$docnumber1 = '';
$testname='';
//This include updatation takes too long to load for hunge items database.

if (isset($_REQUEST["rowcount"])) { echo $rowcount = $_REQUEST["rowcount"]; } else { $rowcount = ""; }

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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];

}
else
{
	$searchpatient = '';
	$searchpatientcode='';
	
	$searchvisitcode='';
	$fromdate=date('Y-m-d');
	$todate=date('Y-m-d');
	$docnumber='';
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
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

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
		
		
              <form name="cbform1" method="post" action="phlebotomyreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Phlebotomy Report </strong></td>
                 <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchpatient; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchpatientcode; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchvisitcode; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Test Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="testname" type="text" id="testname" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			     
            <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $fromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $todate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
			  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$testname=$_POST['testname'];
	

?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1196" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="13" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Phlebotomy Report </strong></div></td>
			 </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>
                
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>
              
               <!-- <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Publish DateTimg</strong></div></td>-->
			
             <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit date</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab Item Code</strong></div></td>
                 <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab Item Name</strong></div></td>
               <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab Item Rate</strong></div></td>
                <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Test Requested</strong></div></td>
             <!--   <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Collected</strong></div></td>
                -->
                 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample type</strong></div></td>
                 
                 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Date </strong></div></td>												<td width="8%"  align="left" valign="center"                 bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Collected By</strong></div></td>								
              </tr>
              
              

           <?php
		 $samplelab="select * from samplecollection_lab where  recorddate between '$fromdate' and '$todate' and itemname like '%$testname%' group by itemname"; 
		 $exesample=mysqli_query($GLOBALS["___mysqli_ston"], $samplelab);
		 while($ressamp22=mysqli_fetch_array($exesample))
		 {
			 $itemcode=$ressamp22['itemcode'];
			 $itemname=$ressamp22['itemname'];
			 ?>
             <tr>
              <td class="bodytext31" valign="center" colspan="12"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"><strong><?= $itemname ?></strong></div></td>
              </tr>
             <?php
			 $subtotal='0.00';
			 $samplelab_data=mysqli_query($GLOBALS["___mysqli_ston"], "select * from samplecollection_lab where itemcode='$itemcode' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and recorddate between '$fromdate' and '$todate'");
			 while($ressamp=mysqli_fetch_array($samplelab_data))
			  {
			 $patientcode=$ressamp['patientcode'];
			 $visitcode=$ressamp['patientvisitcode'];
			 $sampleid=$ressamp['sampleid'];
			 $itemtype="select sampletype from master_lab where itemcode='$itemcode'";
			 $exeitem=mysqli_query($GLOBALS["___mysqli_ston"], $itemtype);
			 $resitem=mysqli_fetch_array($exeitem);
			 $itemsampletype=$resitem['sampletype'];
			 $sampledate=$ressamp['recorddate'];
			 $sampletime=$ressamp['recordtime'];			 			 $ressampusername=$ressamp['username'];
			 $sampledatetime=$sampledate.' '.$sampletime;
			
			$vistquery="select recorddate from master_consultation where patientcode ='$patientcode' and  patientvisitcode='$visitcode'";
			$exevisit=mysqli_query($GLOBALS["___mysqli_ston"], $vistquery)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resvisit=mysqli_fetch_array($exevisit);
			$visitdate=$resvisit['recorddate'];
			
			$itemratequery="select labitemrate,username,consultationdate from consultation_lab where labitemcode='$itemcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' ";
			$exeitemrate=mysqli_query($GLOBALS["___mysqli_ston"], $itemratequery);
			$resitemrate=mysqli_fetch_array($exeitemrate);
			$itemrate=$resitemrate['labitemrate'];
			$requestuser=$resitemrate['username'];
			$consultationdate=$resitemrate['consultationdate'];
			if($visitdate =='')
			{
				$visitdate=$consultationdate;
			}
			
			$entry=mysqli_query($GLOBALS["___mysqli_ston"], "select username from samplecollection_lab where itemcode='$itemcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' ");
			$resentry=mysqli_fetch_array($entry);
			$resultenteredby=$resentry['username'];
			
			$subtotal=$subtotal+$itemrate;
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
          
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?= $ressamp['patientname'] ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?= $ressamp['patientcode'] ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?= $ressamp['patientvisitcode'] ?></div></td>
			         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate; ?></div></td>
               
                
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $ressamp['itemcode'] ?></div></td>
                <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $itemname ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?= number_format($itemrate); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $requestuser; ?></div></td>
             <!--  <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $resultenteredby; ?></div></td> -->
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemsampletype; ?></div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?= $sampledatetime ?> </div></td>								<td class="bodytext31" valign="center"  align="center"><div align="center"><?= $ressampusername; ?></div></td>
             
              
			  </tr>
              
           
		   <?php 
			 }?>
			 <tr>
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="7"><div align="right"><strong>Sub Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($subtotal,2); ?></strong></div></td>
             </tr>
			 <?php
			 $grandtotal=$grandtotal+$subtotal;
		   } 
		  
		   ?>   
             <?php
			 $subtotal1='0.00';
		 $samplelab1="select * from ipsamplecollection_lab where  recorddate between '$fromdate' and '$todate' and itemname like '%$testname%'"; 
		 $exesample1=mysqli_query($GLOBALS["___mysqli_ston"], $samplelab1);
		 while($ressamp12=mysqli_fetch_array($exesample1))
		 {
			 
			 $itemcode1=$ressamp12['itemcode'];
			 $itemname1=$ressamp12['itemname'];
			 ?>
             <tr>
              <td class="bodytext31" valign="center" colspan="12"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"><strong><?= $itemname1 ?></strong></div></td>
              </tr>
             <?php
			 $samplelab1_date=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ipsamplecollection_lab where itemcode='$itemcode1' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and recorddate between '$fromdate' and '$todate' ");
			 while($ressamp1=mysqli_fetch_array($samplelab1_date))
			 {
			 $patientcode1=$ressamp1['patientcode'];
			 $visitcode1=$ressamp1['patientvisitcode'];
			 $sampleid1=$ressamp1['sampleid'];
			
			 $itemsampletype1=$ressamp1['sample'];
			 $sampledate1=$ressamp1['recorddate'];
			 $sampletime1=$ressamp1['recordtime'];			 			 $ressamp1username=$ressamp1['username'];
			 $sampledatetime1=$sampledate1.' '.$sampletime1;
			 
			 $vistquery1="select consultationdate from master_ipvisitentry where patientcode ='$patientcode1' and visitcode='$visitcode1'";
			$exevisit1=mysqli_query($GLOBALS["___mysqli_ston"], $vistquery1);
			$resvisi1t1=mysqli_fetch_array($exevisit1);
			$visitdate1=$resvisi1t1['consultationdate'];
			
		 	$itemratequery1="select labitemrate,username from ipconsultation_lab where labitemcode='$itemcode1' and patientcode='$patientcode1' and patientvisitcode='$visitcode1' ";
			$exeitemrate1=mysqli_query($GLOBALS["___mysqli_ston"], $itemratequery1);
			$resitemrate1=mysqli_fetch_array($exeitemrate1);
			$itemrate1=$resitemrate1['labitemrate'];
			$requestuser1=$resitemrate1['username'];
			
			$entry1=mysqli_query($GLOBALS["___mysqli_ston"], "select username from ipresultentry_lab where itemcode='$itemcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' ");
			$resentry1=mysqli_fetch_array($entry1);
			$resultenteredby1=$resentry1['username'];
			
			$subtotal1=$subtotal1+$itemrate1;
			
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
          
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?= $ressamp1['patientname'] ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?= $ressamp1['patientcode'] ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?= $ressamp1['patientvisitcode'] ?></div></td>
			         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate1; ?></div></td>
               
                
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $ressamp1['itemcode'] ?></div></td>
                <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $itemname1 ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $itemrate1; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $requestuser1; ?></div></td>
             <!--  <td class="bodytext31" valign="center"  align="center"><div align="center"><?= $resultenteredby1; ?></div></td> -->
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemsampletype1; ?></div></td>
                 
                  

              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?=$sampledatetime1 ?> </div></td><td class="bodytext31" valign="center"  align="center"><div align="center"><?= $ressamp1username; ?></div></td>
             
              
			  </tr>
          <?php }
		   $grandtotal=$grandtotal+$subtotal1;?>    
           
		  <tr>
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="7"><div align="right"><strong>Sub Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?= number_format($subtotal1,2,'.','') ?></div></td>
             </tr>
              
			 <?php
		   } 
		 
		   ?>   
           
		<tr>
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="7"><div align="right"><strong>Grand Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?= number_format($grandtotal,2,'.','') ?></div></td>
             </tr>
           
           
           
                   
            <tr>
             
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"></td>
			             
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
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                  <td  colspan="2" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
               

			</tr>
          </tbody>
        </table>
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
	  
	
      <?php }?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

