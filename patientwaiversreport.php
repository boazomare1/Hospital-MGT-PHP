<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

 $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$cbfrmflag1=isset($_REQUEST['cbfrmflag1'])?$_REQUEST['cbfrmflag1']:'';

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$numml=0;

function calculate_age($birthday)
{
	
	if($birthday=="0000-00-00")
	{
		return "0 Days";
	}
	
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}


			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			
			$query1111 = "select * from master_employee where username = '$username'";
				$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1111 = mysqli_fetch_array($exec1111))
			 {
			   $locationnumber = $res1111["location"];
			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
				$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1112 = mysqli_fetch_array($exec1112))
			 {
			   $locationname = $res1112["locationname"];    
				 $locationcode = $res1112["locationcode"];
			 }
			 }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
if(isset($_POST['ADate1'])){ $fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
$query112 = "select * from master_department where auto_number = '$department'";
$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
$res112 = mysqli_fetch_array($exec112);
$res112department = $res112['department'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{
foreach($_POST['visit'] as $key => $value)
{
 $visit = $_POST['visit'][$key];
 $status = $_POST['status'][$key];

		
		$querytr1="update master_visitentry set triagestatus='$status' where visitcode='$visit'";
		$exectr1=mysqli_query($GLOBALS["___mysqli_ston"], $querytr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$querytr="update master_billing set triagestatus='$status' where visitcode='$visit'";
		$exectr=mysqli_query($GLOBALS["___mysqli_ston"], $querytr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}

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
padding-left:800px;
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
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

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




</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="patientwaiversreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Discount Report</strong></td>
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
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
						<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit Code </td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
					  </span></td>
             		 </tr>
					 
					  <tr>
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
					
			 <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Department</td>
				  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
				    <select name="department" id="department">
                      <option value="">Select Department</option>
                      <?php
				     $query51 = "select * from master_department where recordstatus <> 'deleted' ";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51department = $res51["department"];
				       ?>
					  
                      <option value="<?php echo $res51anum; ?>" ><?php echo $res51department; ?></option>
                      <?php
				     }
				  ?>
                    </select>
				  </strong></td>
			</tr>-->
			
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
	  
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  
  <tr>
    
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1289" 
            align="left" border="0">
          <tbody>
          <?php if($cbfrmflag1=="cbfrmflag1")
			{?>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="12" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>OP Discount Report</strong>
                  <label class="number">&nbsp;</label></div></td>
                
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>S.No.</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Date </strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient code </strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit code </strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name </strong></div></td>
              <td width="12%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></td>
              <td width="6%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
              <td width="8%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Lab </strong></div></td>
				 <td width="8%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Radiology </strong></div></td>
              <td width="8%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>
             <td width="8%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy </strong></div></td>
			
              <!--<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Status</strong></td>
              -->
              <td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Given By</strong></div></td>
              </tr>
			<?php
			
			?>
		
 
 			<?php
			
			$total_cons=0.00;
			$total_lab=0.00;
			$total_rad=0.00;
			$total_ser=0.00;
			$total_others=0.00;
			
					     $query1 = "select * from patientweivers where patientname like '%$searchpatient%'and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and  entrydate between '$fromdate' and '$todate' order by auto_number desc";
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$entrydate = $res1['entrydate'];
			$patientvisitcode = $res1['visitcode'];
			 $patientcode = $res1['patientcode'];
			 $accountname = $res1['accountname'];
			 $cons=$res1['consult_discamount'];
			$lab=$res1['lab_discamount'];
			$radiology = $res1['radiology_discamount'];
			$services = $res1['services_discamount'];
			 $others = $res1['pharmacy_discamount'];
			 $username = $res1['username'];
			$patientname = $res1['patientname'];
				
            $total_cons+=$cons;
			$total_lab+=$lab;
			$total_rad+=$radiology;
			$total_ser+=$services;
			$total_others+=$others;

					$queryusername="select employeename from master_employee where username='$username'";
					$userexec=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
					$resuser=mysqli_fetch_array($userexec);
				    $givenby=$resuser['employeename'];
				
				
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			if($radiology>0 || $services>0 || $others>0 || $lab>0)
			{
			
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left" width="7%">
			    <div align="left"><?php echo $entrydate;?> </div></td>
				 <td class="bodytext31" valign="center"  align="left" width="9%">
			    <div align="left"><?php echo $patientcode;?></div></td>
				<td class="bodytext31" valign="center"  align="left" width="8%">
			    <div align="left"><?php echo $patientvisitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" width="14%">
			  <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" width="12%"><?php echo $accountname; ?></td>
              <td class="bodytext31" valign="center"  align="right" width="6%"><?php echo number_format($cons,2); ?></td>
              <td class="bodytext31" valign="center"  align="right" width="8%">
			    <div align="right"><?php echo number_format($lab,2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="right" width="8%">
			    <div align="right"><?php echo number_format($radiology,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="right" width="8%">
			    <div align="right"><?php echo number_format($services,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="right" width="8%">
			    <div align="right"><?php echo number_format($others,2); ?></div></td>
                <td class="bodytext31" valign="center"  align="center" width="8%">
			    <div align="center"><?php echo $givenby; ?></div></td>
               
              </tr>
			<?php
			}}
			?>
 

            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan="4"></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"> <b> Total </b> </td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><b>
                <?= number_format($total_cons,2); ?>
              </b></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><b><?= number_format($total_lab,2); ?> </b></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><b><?= number_format($total_rad,2); ?> </b></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><b><?= number_format($total_ser,2); ?> </b></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><b><?= number_format($total_others,2); ?> </b></td>
				 <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"> <b> Grand Total : <?= number_format($total_cons+$total_lab+$total_rad+$total_ser+$total_others,2); ?></b></td>

			</tr>
             
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
        </table><?php }?></td>
      </tr>
    </table>
	</td>
	</tr>
	<tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

