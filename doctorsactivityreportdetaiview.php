<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>


 
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 


<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
  <script>

$(function() {

$('#cbcustomername').autocomplete({
		 
	source:'ajaxdoctorsearch.php', 

	minLength:3,
	delay: 0,	
	html: true, 
		select: function(event,ui){
			var customercode=ui.item.auto_number;
			var username=ui.item.username;
				$('#cbcustomercode').val(customercode);
				$('#usernamenew').val(username);
			}
    });
});
</script>    
<style type="text/css">

.ui-menu .ui-menu-item{ zoom:1.6 !important; }
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>



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
		
		
              <form name="cbform1" method="post" action="doctorsactivityreportdetaiview.php">
		<table width="658" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Activity Detail Report</strong></td>
              </tr>
              
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> User </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">
                 <input name="cbcustomercode" type="hidden" id="cbcustomercode" value="" size="50" autocomplete="off">
                 
                 <input name="usernamenew" type="hidden" id="usernamenew" value="" size="50" autocomplete="off">
              </span>
                    </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        &nbsp;</td>
                  </tr>	
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	
                  
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
              <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag2" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
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
	   <?php if($cbfrmflag2 == 'cbfrmflag1'){?>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1323" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="16" bgcolor="#ecf0f5" class="bodytext31">				  </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				
              <td width="10%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
				 
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Date</strong></div></td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit By</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Assgn Doc </strong></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Doc. Code </td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Cons. Fee </td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Department</td>
   				  <td width="5%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Triaged By</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulted By</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Pharmacy By</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sampled By</strong></div></td>
   				  <td width="5%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Service By</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Radiology By</strong></div></td>
            </tr>
			
			<?php
			
		 	$cbcustomercode=isset($_REQUEST['cbcustomercode'])?$_REQUEST['cbcustomercode']:'';
			$cbcustomername=$_REQUEST['usernamenew'];
		 	$cbcustomername=trim($cbcustomername); 
			
	if($slocation!=''){
		    $query44 = "select username from master_consultationlist where username like '%$cbcustomername%' and locationcode='$slocation' and date between '$ADate1' and '$ADate2' group by username"; 
	}
	else
	{
			    $query44 = "select username from master_consultationlist where username like '%$cbcustomername%' and date between '$ADate1' and '$ADate2' group by username"; 
	}
		  $exec44= mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numcount=mysqli_num_rows($exec44); 
		  while($res44 = mysqli_fetch_array($exec44))
			{
		  $doctorcheck= $res44['username'];   
		  
		  ?>
          <tr <?php //echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  colspan="5" align="left"><strong>
				
				<?php
							$query02="select employeename from master_employee where username='$doctorcheck'";
				$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
				$res02=mysqli_fetch_array($exec02);
				if($res02['employeename']!='')
				{
					 $doctorname=$res02['employeename'];
				}
	
				?>
				<?php echo strtoupper($doctorname); ?></strong>
                
                </td>
                </tr>
          <?php
		  
			if($slocation!=''){
		   $query4 = "select * from master_consultationlist where username ='$doctorcheck' and locationcode='$slocation' and date between '$ADate1' and '$ADate2' group by visitcode"; 
			}
			else
			{
		  $query4 = "select * from master_consultationlist where username ='$doctorcheck' and date between '$ADate1' and '$ADate2' group by visitcode"; 
				
			}
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numcount=mysqli_num_rows($exec4);
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$patientname= $res4['patientfirstname'];
				$patientmiddlename= $res4['patientmiddlename'];
				$patientlastname= $res4['patientlastname'];
				$patientcode= $res4['patientcode'];
				$visitcode= $res4['visitcode'];
				$consultingdoctor= $res4['username'];
				
/*		  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.user as triageby,a.visitcode, c.username as pharmacyby from master_visitentry a, master_triage b,pharmacysales_details c where (a.visitcode = '$visitcode') and  (b.visitcode = '$visitcode') and  (c.visitcode = '$visitcode')"; 
*/		  
  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.consultingdoctor,a.consultingdoctorcode,a.departmentname,a.consultationfees,a.username as visitby,b.visitcode,b.user as triageby,c.visitcode, c.username as pharmacyby,
  d.patientvisitcode, d.username as sampleby,e.patientvisitcode, e.username as serviceby,f.patientvisitcode, f.username as radiologyby from master_visitentry as a  LEFT JOIN master_triage as b ON a.visitcode=b.visitcode LEFT JOIN pharmacysales_details as c  ON a.visitcode=c.visitcode LEFT JOIN samplecollection_lab as d ON a.visitcode=d.patientvisitcode LEFT JOIN consultation_services as e ON a.visitcode=e.patientvisitcode LEFT JOIN resultentry_radiology as f ON a.visitcode=f.patientvisitcode where a.visitcode = '$visitcode' "; 
  
  		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);	
				$visitdate= $res5['consultationdate'];
				$visitby= $res5['visitby'];
				$triagedby= $res5['triageby'];
				$pharmacyby= $res5['pharmacyby'];
				$sampleby= $res5['sampleby'];
				$serviceby= $res5['serviceby'];
				$radiologyby= $res5['radiologyby'];
				$doctorname = $res5['consultingdoctor'];
				$doctorcode = $res5['consultingdoctorcode'];
				$department = $res5['departmentname'];
				$consultationfees = $res5['consultationfees'];
			//echo	$count= $res5['count'];
			
						
				
			
				$snocount=$snocount+1;
				//echo $cashamount;
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
				<td width="4%"class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td width="10%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientname.' '.$patientmiddlename.' '.$patientlastname; ?></div></td>
				<td width="7%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td width="9%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"> <a target="_blank" href="emrcasesheet.php?visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?> </a></div></td>				
				<td width="7%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $visitdate; ?></div></td>
				<td width="7%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $visitby; ?></div></td>
				<td width="6%"class="bodytext31" valign="center"  align="left"><?php echo $doctorname; ?></div></td>
				<td width="6%"class="bodytext31" valign="center"  align="left"><?php echo $doctorcode; ?></div></td>
				<td width="6%" class="bodytext31" valign="center"  align="left"><?php echo $consultationfees; ?></div></td>
				<td width="7%" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></div></td>
				<td width="5%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $triagedby; ?></div></td>
				<td width="6%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $consultingdoctor; ?></div></td>
				<td width="6%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $pharmacyby; ?></div></td>
				<td width="6%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $sampleby; ?></div></td>
				<td width="5%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $serviceby; ?></div></td>
				<td width="6%"class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $radiologyby; ?></div></td>
				</tr>
			<?php
			}}
			?>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td colspan="14" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                
				
				 
			  
			</tr>
          </tbody>
        </table></td><?php }?>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
