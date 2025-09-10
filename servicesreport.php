<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["ADate1"])) { $paymentreceiveddatefrom = $_REQUEST["ADate1"]; } else { $paymentreceiveddatefrom = date('Y-m-d'); }
 
if (isset($_REQUEST["ADate2"])) { $paymentreceiveddateto = $_REQUEST["ADate2"]; } else { $paymentreceiveddateto = date('Y-m-d'); }


$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';
$amount = '';
$processcount = 0;
$ipprocessstatus='';
$processstatus='';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["patientname"])) { $searchpatientname = $_REQUEST["patientname"]; } else { $searchpatientname = ""; }
if (isset($_REQUEST["patientcode"])) { $searchpatientcode = $_REQUEST["patientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $searchvisitcode = $_REQUEST["visitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }
if (isset($_REQUEST["processtype"])) { $processtype = $_REQUEST["processtype"]; } else { $processtype = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
//echo $department;


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype']; 
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];


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
<script src="js/jquery-1.11.1.min.js"></script>

<script>
$(document).ready(function(){
$('.showdocument').click(function(){
	var sno = $(this).attr('id');
	$('#show'+sno).toggle();	
});
fundisplaydpt();
});
</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
function fundisplaydpt()
{
if(document.cbform1.patienttype.value == 'op')
{
document.getElementById('departmentrow').style.display = '';
}
else
{
document.getElementById('departmentrow').style.display = 'none';
}
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




</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>

</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="servicesreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Report</strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
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
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="patientname" id="patientname" value="<?php echo $searchpatientname;?>" size="43">
              </span></td>
			  </tr>
					<tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="patientcode" id="patientcode" value="<?php echo $searchpatientcode; ?>" size="43">
              </span></td>
			  </tr>
              <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Visit Code</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="visitcode" id="visitcode" value="<?php echo $searchvisitcode; ?>" size="43">
              </span></td>
			  </tr>
              <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Patient Type</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <select name="patienttype" onChange="fundisplaydpt();">
             <option value="op" <?php if($patienttype=='op'){echo "selected";}?>>OP</option>
             <option value="ip" <?php if($patienttype=='ip'){echo "selected";}?>>IP</option>
             </select>
              </span></td>
			  </tr>
			  <tr id="departmentrow" <?php if($patienttype!='op'){echo 'style="display:none"';}?>>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Patient Type</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <select name="department">
			 <option value="all" <?php if($department=='all'){ echo 'selected';}?>>All</option>
           	<?php
			$qrydpt="select auto_number,department from master_department where recordstatus <> 'deleted'";
			$execdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qrydpt) or die("Error in Query Department".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdpt = mysqli_fetch_array($execdpt))
			{
			//echo $resdpt['auto_number']
			?>
			<option value='<?= $resdpt['auto_number']?>' <?php if($department==$resdpt['auto_number']){ echo 'selected';}?>><?= $resdpt['department']?></option>
			<?php
			}
			?>
             </select>
              </span></td>
			  </tr>
              <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Process Type</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <select name="processtype">
             <!--<option value="lab" <?php if($processtype=='lab'){echo "selected";}?>>LAB</option>
             <option value="radiology" <?php if($processtype=='radiology'){echo "selected";}?>>RADIOLOGY</option>-->
             <option value="services" <?php if($processtype=='services'){echo "selected";}?>>SERVICES</option>
             </select>
              </span></td>
			  </tr>
              <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			  <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select locationname,locationcode from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select></td>
			  </tr>
              
              <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="27%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="47%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
             
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1360" 
            align="left" border="0">
          <tbody>
		  <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
				if($department == 'all')
				{
				$dptqryst = '%%';
				}
				else
				{
				$dptqryst = $department;
				}
				$sno=1;
				
			?>
            <tr>
              <td width="24"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>
              <td width="107" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Request Date</strong></td>
              <td width="114" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>
              <td width="86" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
              <td width="141" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
				<td width="141" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Department</strong></td>
              <td width="156" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Package Code</strong></td>
                <td width="187" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Package Name</strong></td>
                <td width="125" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Package Quantity</strong></td>
                <td width="35" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Processed </strong></td>
               <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Request Time</strong></td>
				 <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Requested By</strong></td>
				<?php
				if($processtype=='services'){
				?>
				<td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Processed By</strong></td>
				<?php
				}
				?>
                  
            </tr>
			
			<?php

			if($processtype=='lab'){
			
			if($patienttype=='op')
			{
				  $queryservices="select auto_number,patientvisitcode,patientcode,labitemcode from consultation_lab where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' group by patientvisitcode,labitemcode,auto_number order by consultationdate desc";
				$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resservice=mysqli_fetch_array($exservice))
				{
					$patientcode=$resservice['patientcode'];
					$patientvisitcode=$resservice['patientvisitcode'];
					$labitemcode=$resservice['labitemcode'];
					$auto_number=$resservice['auto_number'];
					
					
					  $serviceqty="select pkg_process,1 as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,labitemcode,labitemname,labitemrate,username from consultation_lab where patientcode ='$patientcode' and patientvisitcode='$patientvisitcode' and labitemcode='$labitemcode'  and locationcode='$location' and auto_number='$auto_number' group by labitemcode";
					$exserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceqty) or die ("error in serviceqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($resqty=mysqli_fetch_array($exserqty))

{					
					 $servicesquantity=$resqty['servicesquantity'];
					
					
					$patientname=$resqty['patientname'];
					$consultationdate=$resqty['consultationdate'];
					$labitemname=$resqty['labitemname'];
					 $labitemrate=$resqty['labitemrate'];
					$requestedby=$resqty['username'];
					
					$pkg_process=$resqty['pkg_process'];
					
					if($pkg_process=='completed')
					{
						$processstatus='Yes';
						$processcount++;
					}
					else
					{
						$processstatus='No';
					}
					//$approvedby=$resqty['approvedby'];
					$approvedby='';
					
					
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $consultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $patientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $patientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $patientname;?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $labitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $labitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesquantity;?></td>
                 <td width="166"  align="left" 
                 class="bodytext31"><?php echo $processstatus;?></td>
                
                    </tr>
                    
					<?php	
				}
				}
			}
				
				if($patienttype=='ip')
				{
					   $queryipservices="select patientvisitcode,patientcode,labitemcode,auto_number from ipconsultation_lab where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' group by patientvisitcode,labitemcode,auto_number order by consultationdate desc";
				$exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryipservices) or die("error in queryipservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resipservice=mysqli_fetch_array($exipservice))
				{
					$ippatientcode=$resipservice['patientcode'];
					$ippatientvisitcode=$resipservice['patientvisitcode'];
					$ipservicesitemcode=$resipservice['labitemcode'];
					$auto_number = $resipservice['auto_number'];
					
					
					 $serviceipqty="select pkg_process,1 as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,labitemcode,labitemname,labitemrate,username from ipconsultation_lab where patientcode ='$ippatientcode' and patientvisitcode='$ippatientvisitcode' and labitemcode='$ipservicesitemcode' and locationcode='$location' and auto_number='$auto_number' group by labitemcode";
					$exipserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceipqty) or die ("error in serviceipqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resipqty=mysqli_fetch_array($exipserqty))
					{
					 $servicesipquantity=$resipqty['servicesquantity'];
					$servicesipquantity=number_format($servicesipquantity,2);
					
					
					$ippatientname=$resipqty['patientname'];
					$ipconsultationdate=$resipqty['consultationdate'];
					$ipservicesitemname=$resipqty['labitemname'];
					$ipservicesitemrate=$resipqty['labitemrate'];
					 $iprequestedby=$resipqty['username'];
					//$ipapprovedby=$resipqty['approvedby'];
					$ipprocess=$resipqty['pkg_process'];
					
					if($ipprocess=='completed')
					{
						$ipprocessstatus='Yes';
					}
					else
					{
						$ipprocessstatus='No';
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $ipconsultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $ippatientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $ippatientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $ippatientname;?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $ipservicesitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $ipservicesitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesipquantity;?></td>
                 <td width="166"  align="left" 
                 class="bodytext31"><?php echo $ipprocessstatus;?></td>
                
                    </tr>
                    
					<?php	
				}
				}
				}
			}

			if($processtype=='radiology'){
			
			if($patienttype=='op')
			{
				  $queryservices="select auto_number ,patientvisitcode,patientcode,radiologyitemcode from consultation_radiology  where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' group by patientvisitcode,radiologyitemcode,auto_number order by consultationdate desc";
				$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resservice=mysqli_fetch_array($exservice))
				{
					$patientcode=$resservice['patientcode'];
					$patientvisitcode=$resservice['patientvisitcode'];
					$radiologyitemcode=$resservice['radiologyitemcode'];
					$auto_number = $resservice['auto_number'];
					
					  $serviceqty="select pkg_process,sum(1) as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,radiologyitemcode,radiologyitemname,radiologyitemrate,username from consultation_radiology where patientcode ='$patientcode' and patientvisitcode='$patientvisitcode' and radiologyitemcode='$radiologyitemcode'  and locationcode='$location' and auto_number='$auto_number' group by radiologyitemcode";
					$exserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceqty) or die ("error in serviceqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($resqty=mysqli_fetch_array($exserqty))

{					
					 $servicesquantity=$resqty['servicesquantity'];
					
					
					$patientname=$resqty['patientname'];
					$consultationdate=$resqty['consultationdate'];
					$radiologyitemname=$resqty['radiologyitemname'];
					 $radiologyitemrate=$resqty['radiologyitemrate'];
					$requestedby=$resqty['username'];
					
					$pkg_process=$resqty['pkg_process'];
					
					if($pkg_process=='completed')
					{
						$processstatus='Yes';
					}
					else
					{
						$processstatus='No';
					}
					//$approvedby=$resqty['approvedby'];
					$approvedby='';
					
					
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $consultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $patientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $patientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $patientname;?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $radiologyitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $radiologyitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesquantity;?></td>
                 <td width="166"  align="left" 
                 class="bodytext31"><?php echo $processstatus;?></td>
                
                    </tr>
                    
					<?php	
				}
				}
			}
				
				if($patienttype=='ip')
				{
					   $queryipservices="select auto_number,patientvisitcode,patientcode,radiologyitemcode from ipconsultation_radiology where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' group by patientvisitcode,radiologyitemcode order by consultationdate desc";
				$exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryipservices) or die("error in queryipservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resipservice=mysqli_fetch_array($exipservice))
				{
					$ippatientcode=$resipservice['patientcode'];
					$ippatientvisitcode=$resipservice['patientvisitcode'];
					$ipservicesitemcode=$resipservice['radiologyitemcode'];
					$auto_number = $resipservice['auto_number'];
					
					
					 $serviceipqty="select pkg_process,sum(1) as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,radiologyitemcode,radiologyitemname,radiologyitemrate,username from ipconsultation_radiology where patientcode ='$ippatientcode' and patientvisitcode='$ippatientvisitcode' and radiologyitemcode='$ipservicesitemcode' and locationcode='$location' and auto_number='$auto_number' group by radiologyitemcode";
					$exipserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceipqty) or die ("error in serviceipqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resipqty=mysqli_fetch_array($exipserqty))
					{
					 $servicesipquantity=$resipqty['servicesquantity'];
					$servicesipquantity=number_format($servicesipquantity,2);
					$ippatientname=$resipqty['patientname'];
					$ipconsultationdate=$resipqty['consultationdate'];
					$ipservicesitemname=$resipqty['radiologyitemname'];
					$ipservicesitemrate=$resipqty['radiologyitemrate'];
					 $iprequestedby=$resipqty['username'];
					//$ipapprovedby=$resipqty['approvedby'];
					$ipprocess=$resipqty['pkg_process'];
					
					if($ipprocess=='completed')
					{
						$ipprocessstatus='Yes';
					}
					else
					{
						$ipprocessstatus='No';
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $ipconsultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $ippatientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $ippatientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $ippatientname;?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $ipservicesitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $ipservicesitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesipquantity;?></td>
                 <td width="166"  align="left" 
                 class="bodytext31"><?php echo $ipprocessstatus;?></td>
                
                    </tr>
                    
					<?php	
				}
				}
				}
			}

			
			if($processtype=='services'){
			
			if($patienttype=='op')
			{	
					if($dptqryst!='%%')
					{
				  $queryservices="select auto_number
,patientvisitcode,patientcode,servicesitemcode from consultation_services where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientvisitcode in (select visitcode from master_visitentry where department like '$dptqryst') and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' and servicesitemcode in (select itemcode from master_services where pkg like 'yes') group by patientvisitcode,servicesitemcode,username order by consultationdate,username desc";
				$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resservice=mysqli_fetch_array($exservice))
				{
					$patientcode=$resservice['patientcode'];
					$patientvisitcode=$resservice['patientvisitcode'];
					$servicesitemcode=$resservice['servicesitemcode'];
					$auto_number = $resservice['auto_number'];
					$drydptpt = "select department from master_department where auto_number in (select department from master_visitentry where visitcode='$patientvisitcode')";
					$execdptpt = mysqli_query($GLOBALS["___mysqli_ston"], $drydptpt) or die("error in drydptpt".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resdptpt = mysqli_fetch_array($execdptpt);
					$patientdepartment = $resdptpt['department'];
					
					  $serviceqty="select process,sum(serviceqty) as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,consultationtime,servicesitemcode,servicesitemname,servicesitemrate,username from consultation_services where patientcode ='$patientcode' and patientvisitcode='$patientvisitcode' and servicesitemcode='$servicesitemcode'  and locationcode='$location' and auto_number='$auto_number' group by servicesitemcode";
					$exserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceqty) or die ("error in serviceqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($resqty=mysqli_fetch_array($exserqty))

{					
					 $servicesquantity=$resqty['servicesquantity'];
					$patientname=$resqty['patientname'];
					$consultationdate=$resqty['consultationdate'];
					$consultationtime=$resqty['consultationtime'];
					$servicesitemname=$resqty['servicesitemname'];
					 $servicesitemrate=$resqty['servicesitemrate'];
					$requestedby=$resqty['username'];
					
					$process=$resqty['process'];
					
					if($process=='completed')
					{
						$processstatus='Yes';
						$processcount++;
					}
					else
					{
						$processstatus='No';
					}
					//$approvedby=$resqty['approvedby'];
					$approvedby='';
					
					
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $consultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $patientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $patientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $patientname;?></td>
				<td width="141"  align="left" 
                class="bodytext31"><?php echo $patientdepartment;?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $servicesitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $servicesitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesquantity;?></td>
                 <td width="20"  align="left" 
                 class="bodytext31"><?php echo $processstatus;?></td>
				 <td width="20"  align="left" 
                 class="bodytext31"><?php echo $consultationtime;?></td>
                <td width="60"  align="left" 
                 class="bodytext31"><?php echo $requestedby;?></td>
                    </tr>
                    
					<?php	
				}
				}
				}
				else
				{
				$queryservices="select auto_number
,patientvisitcode,patientcode,servicesitemcode from consultation_services where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientvisitcode in (select visitcode from master_visitentry where department like '$dptqryst') and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' and servicesitemcode in (select itemcode from master_services where pkg like 'yes') group by patientvisitcode,servicesitemcode,username order by consultationdate,username desc";
				$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resservice=mysqli_fetch_array($exservice))
				{
					$patientcode=$resservice['patientcode'];
					$patientvisitcode=$resservice['patientvisitcode'];
					$servicesitemcode=$resservice['servicesitemcode'];
					$auto_number = $resservice['auto_number'];
					$drydptpt = "select department from master_department where auto_number in (select department from master_visitentry where visitcode='$patientvisitcode')";
					$execdptpt = mysqli_query($GLOBALS["___mysqli_ston"], $drydptpt) or die("error in drydptpt".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resdptpt = mysqli_fetch_array($execdptpt);
					$patientdepartment = $resdptpt['department'];
					
					  $serviceqty="select process,sum(serviceqty) as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,consultationtime,servicesitemcode,servicesitemname,servicesitemrate,username,processedby from consultation_services where patientcode ='$patientcode' and patientvisitcode='$patientvisitcode' and servicesitemcode='$servicesitemcode' and locationcode='$location' and auto_number='$auto_number' group by servicesitemcode";
					$exserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceqty) or die ("error in serviceqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($resqty=mysqli_fetch_array($exserqty))

{					
					 $servicesquantity=$resqty['servicesquantity'];
					$patientname=$resqty['patientname'];
					$consultationdate=$resqty['consultationdate'];
					$consultationtime=$resqty['consultationtime'];
					$servicesitemname=$resqty['servicesitemname'];
					 $servicesitemrate=$resqty['servicesitemrate'];
					$requestedby=$resqty['username'];
					$processedby=$resqty['processedby'];
					$process=$resqty['process'];
					
					if($process=='completed')
					{
						$processstatus='Yes';
						$processcount++;
					}
					else
					{
						$processstatus='No';
					}
					//$approvedby=$resqty['approvedby'];
					$approvedby='';
					
					
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $consultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $patientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $patientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $patientname;?></td>
				<td width="141"  align="left" 
                class="bodytext31"><?php echo $patientdepartment;?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $servicesitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $servicesitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesquantity;?></td>
                 <td width="20"  align="left" 
                 class="bodytext31"><?php echo $processstatus;?></td>
				 <td width="20"  align="left" 
                 class="bodytext31"><?php echo $consultationtime;?></td>
                <td width="60"  align="left" 
                 class="bodytext31"><?php echo $requestedby;?></td>
				 <td width="60"  align="left" 
                 class="bodytext31"><?php echo $processedby;?></td>
                    </tr>
                    
					<?php	
				}
				}
				}
			}
				
				if($patienttype=='ip')
				{
					   $queryipservices="select auto_number,patientvisitcode,patientcode,servicesitemcode from ipconsultation_services where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$ADate1' and '$ADate2'  and locationcode='$location' group by patientvisitcode,servicesitemcode order by consultationdate,username desc";
				$exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryipservices) or die("error in queryipservices".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resipservice=mysqli_fetch_array($exipservice))
				{
					$ippatientcode=$resipservice['patientcode'];
					$ippatientvisitcode=$resipservice['patientvisitcode'];
					$ipservicesitemcode=$resipservice['servicesitemcode'];
					$auto_number = $resipservice['auto_number'];
					
					
					 $serviceipqty="select process,sum(serviceqty) as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,consultationtime,servicesitemcode,servicesitemname,servicesitemrate,username,processedby from ipconsultation_services where patientcode ='$ippatientcode' and patientvisitcode='$ippatientvisitcode' and servicesitemcode='$ipservicesitemcode' and locationcode='$location' and auto_number='$auto_number' group by servicesitemcode";
					$exipserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceipqty) or die ("error in serviceipqty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resipqty=mysqli_fetch_array($exipserqty))
					{
					 $servicesipquantity=$resipqty['servicesquantity'];
					$servicesipquantity=number_format($servicesipquantity,2);
					
					
					$ippatientname=$resipqty['patientname'];
					$ipconsultationdate=$resipqty['consultationdate'];
					$ipconsultationtime=$resipqty['consultationtime'];
					$ipservicesitemname=$resipqty['servicesitemname'];
					$ipservicesitemrate=$resipqty['servicesitemrate'];
					 $iprequestedby=$resipqty['username'];
					 $ipprocessedby=$resipqty['processedby'];
					//$ipapprovedby=$resipqty['approvedby'];
					$ipprocess=$resipqty['process'];
					
					if($ipprocess=='completed')
					{
						$ipprocessstatus='Yes';
						$processcount++;
					}
					else
					{
						$ipprocessstatus='No';
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
                    <td width="24"  align="left" 
               class="bodytext31"><?php echo $sno++;?></td>
                <td width="107"  align="left" 
                 class="bodytext31"><?php echo $ipconsultationdate;?></td>
                <td width="114"  align="left" 
                class="bodytext31"><?php echo $ippatientcode;?></td>
                <td width="86"  align="left" 
                class="bodytext31"><?php echo $ippatientvisitcode;?></td>
                <td width="141"  align="left" 
                class="bodytext31"><?php echo $ippatientname;?></td>
				<td width="141"  align="left" 
                class="bodytext31"><?php echo 'IN Patient';?></td>
                <td width="156"  align="left" 
                 class="bodytext31"><?php echo $ipservicesitemcode;?></td>
                 <td width="187"  align="left" 
                 class="bodytext31"><?php echo $ipservicesitemname;?></td>
                 <td width="125"  align="center" 
                 class="bodytext31"><?php echo $servicesipquantity;?></td>
                 <td width="20"  align="left" 
                 class="bodytext31"><?php echo $ipprocessstatus;?></td>
				 <td width="60"  align="left" 
                 class="bodytext31"><?php echo $ipconsultationtime;?></td>
				 <td width="60"  align="left" 
                 class="bodytext31"><?php echo $iprequestedby;?></td>
                <td width="60"  align="left" 
                 class="bodytext31"><?php echo $ipprocessedby;?></td>
                    </tr>
                    
					<?php	
				}
				}
				}
			}
				
			?>
			<tr>
              <td colspan='13'  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total Processed : <?= $processcount;?></strong> </td>
              
                  
            </tr>
			<?php	
				}
			?>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

