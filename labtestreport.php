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
		
		
              <form name="cbform1" method="post" action="labtestreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Test Report</strong></td>
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
	<form name="form1" id="form1" method="post" action="publishedlabresults.php">	
		
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
	
	/*}
	else
	{
	$searchpatient = '';
	$searchpatientcode= '';
	$searchvisitcode='';
	$docnumber='';
	$fromdate=$transactiondatefrom;
	$todate=$transactiondateto;*/

	
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

		
		$queryn21 = "select locationcode from consultation_lab where  locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed'";
		$execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numn21=mysqli_num_rows($execn21);
		
		
		 $query27 = "select locationcode from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='completed' and consultationdate between '$fromdate' and '$todate' ";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numexec26=mysqli_num_rows($exec27);
	     	$resnw1 = $numn21+$numexec26;
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1262" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="12" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Test Report </strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
			 </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>
                
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>
              
				
               
            
              
                
                               
               
               <!-- <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Publish DateTimg</strong></div></td>-->
			

             <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>visit date</strong></div></td>
                
                <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab Item code</strong></div></td>
                
                
                
                <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab Item name</strong></div></td>
				
                 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Request Date</strong></div></td>
                
                 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample type</strong></div></td>
                
                <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Date</strong></div></td>
                
                <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Time</strong></div></td>
                 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Publish Date</strong></div></td>
                
              </tr>
              
              

           <?php
		  $query23 = "select * from consultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numexec23=mysqli_num_rows($exec23);
			if($numexec23>0)
			while($res23 = mysqli_fetch_array($exec23))
			{
			$patientcode = $res23['patientcode'];
			$visitcode = $res23['patientvisitcode'];
			$patientname = $res23['patientname'];
			$itemname = $res23['labitemname'];
			$itemcode = $res23['labitemcode'];
			$itemrate = $res23['labitemrate'];
			$consultationdate = $res23['consultationdate'];
	 	/*$consultationtime = $res23['consultationtime'];*/
		
		$query24="select recorddate from master_consultation where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'";
		$exec24=mysqli_query($GLOBALS["___mysqli_ston"], $query24)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24=mysqli_fetch_array($exec24);
		$visitdate=$res24['recorddate'];
		/* to find sample */
		$query224="select sampletype from master_lab where itemcode='".$itemcode."'";
		$exec224=mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res224=mysqli_fetch_array($exec224);
		$sample=$res224['sampletype'];
		
		
		/*To get date time*/
		$queryd1="select recorddate,recordtime from samplecollection_lab where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."' and itemcode='".$itemcode."'";
		$execd1=mysqli_query($GLOBALS["___mysqli_ston"], $queryd1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resd1=mysqli_fetch_array($execd1);
		$sampledate=$resd1['recorddate'];
		$sampletime=$resd1['recordtime'];
		if($sampledate=='')
		{
			$queryd1="select recorddate,recordtime from samplecollection_laban where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."' and itemcode='".$itemcode."'";
			$execd1=mysqli_query($GLOBALS["___mysqli_ston"], $queryd1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resd1=mysqli_fetch_array($execd1);
			$sampledate=$resd1['recorddate'];
			$sampletime=$resd1['recordtime'];
		}	
				
		/*to get publish date time*/
		$queryp="select publishstatus,publishdatetime,datetime from resultentry_lab where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'and itemcode='".$itemcode."'";
		$execp=mysqli_query($GLOBALS["___mysqli_ston"], $queryp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resp=mysqli_fetch_array($execp);
		$publishstatus=$resp['publishstatus'];
		$publishsdatetime=$resp['publishdatetime'];
		$publishdtime=$resp['datetime'];
		$publishshow="";
		$publishshowtime="";
		
		if($publishstatus=="completed")
		{
			$publishshow=$publishsdatetime;	
		}
		else
		{
			$publishshow=$publishdtime;	
		}
		if($visitcode=='walkinvis')
		{
		$visitdate=$consultationdate;	
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
          
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
			<!--	<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              
			  
				<input type="hidden" name="docnumber[]" value="///*<?php echo $docnumber; ?>"> -->
         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $consultationdate; ?></div></td>
                  

              <td width="10%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sample;?></div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sampledate; ?></div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sampletime; ?></div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $publishshow; ?></div></td>
              
              
			  </tr>
              
           
		   <?php 
		   } 
		  
		   ?>   
           
           
           
		   
		   
		  <?php /*?> <?php 
		    $query25 = "select * from billing_externallab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'";
			$exec25 = mysql_query($query25) or die(mysql_error());
			$numexec25=mysql_num_rows($exec25);
			if($numexec25>0)
			while($res25 = mysql_fetch_array($exec25))
			{
		    $patientcode1 = $res25['patientcode'];
			$visitcode1 = $res25['patientvisitcode'];
			$patientname1 = $res25['patientname'];
			$itemname1 = $res25['labitemname'];
			$itemcode1 = $res25['labitemcode'];
			$itemrate1 = $res25['labitemrate'];
			$consultationdate1 = $res25['billdate'];
	 	
		
		$query26="select recorddate from master_consultation where patientcode='".$patientcode1."' and patientvisitcode='".$visitcode1."'";
		$exec26=mysql_query($query26)or die(mysql_error());
		$res26=mysql_fetch_array($exec26);
		$visitdate1=$res26['recorddate'];
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
		   
			}
		   ?>
            <tr <?php echo $colorcode; ?>>
          
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode1; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              
			  
				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 
         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate1; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode1; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemrate1; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname1; ?></div></td>
                  

              <td width="10%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $consultationdate1; ?> </div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center">     </div></td>
              
			  </tr><?php */?>
              
           
           <?php 
		    $query27 = "select * from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='completed' and labrefund <> 'refund' and consultationdate between '$fromdate' and '$todate' ";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numexec26=mysqli_num_rows($exec27);
			
			while($res27 = mysqli_fetch_array($exec27))
			{
		    $patientcode2 = $res27['patientcode'];
			$visitcode2 = $res27['patientvisitcode'];
			$patientname2 = $res27['patientname'];
			$itemname2 = $res27['labitemname'];
			$itemcode2 = $res27['labitemcode'];
			$itemrate2 = $res27['labitemrate'];
			$consultationdate2 = $res27['consultationdate'];
	 	
		
		$query28="select registrationdate from master_ipvisitentry where patientcode='".$patientcode2."' and visitcode='".$visitcode2."' order by auto_number desc";
		$exec28=mysqli_query($GLOBALS["___mysqli_ston"], $query28)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res28=mysqli_fetch_array($exec28);
		$visitdate2=$res28['registrationdate'];
		
		$query225="select sampletype from master_lab where itemcode='".$itemcode2."'";
		$exec225=mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res225=mysqli_fetch_array($exec225);
		$sample1=$res225['sampletype'];
		
		/*To get date time*/
		$queryd="select recorddate,recordtime from ipsamplecollection_lab where patientcode='".$patientcode2."' and patientvisitcode='".$visitcode2."' and itemcode='".$itemcode2."'";
		$execd=mysqli_query($GLOBALS["___mysqli_ston"], $queryd) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resd=mysqli_fetch_array($execd);
		$sampledate1=$resd['recorddate'];
		$sampletime1=$resd['recordtime'];
		
		/*to get publish date time*/
		$queryt="select recorddate,recordtime from ipresultentry_lab where patientcode='".$patientcode2."' and patientvisitcode='".$visitcode2."'and itemcode='".$itemcode2."'";
		$exect=mysqli_query($GLOBALS["___mysqli_ston"], $queryt) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$rest=mysqli_fetch_array($exect);
		$publishsdate=$rest['recorddate'];
		$publishdtime1=$rest['recordtime'];
		
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
			  <div class="bodytext31" align="center"><?php echo $patientname2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode2; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              
			  
				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 
         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate2; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode2; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname2; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $consultationdate2; ?></div></td>
                  

              <td width="10%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sample1;?></div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sampledate1;?></div></td>
              <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sampletime1;?></div></td>
               <td width="13%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $publishsdate;?></div></td>
               
			  </tr>
           
           
           
           <?php
           }
		   ?>
           
           
           
           
           
                   
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
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               

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
	  
	  </form>
      <?php }?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

