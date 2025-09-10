<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$recorddate = date('Y-m-d');
$recordtime= date('H:i:s');
$username = $_SESSION['username'];
$docno1 = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$date = date('Ymd');
$colorloopcount = '';
$uniquecode=array();
$duplicated=array();
$uniquecode12=array();
$main_array=array();
$sub_array=array();
ini_set('display_errors',1);
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
 
$query018="select auto_number from master_location where locationcode='$locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];
//error_reporting(E_ALL);
//To populate the autocompetelist_services1.js
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if (isset($_REQUEST["lpodate"])) { $lpodate = $_REQUEST["lpodate"]; } else { $lpodate = ""; }
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

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

<?php
function calculate_age($birthday)
{
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
?>
<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
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
<!--<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>-->
<script type="text/javascript">
 $(function() {
  getValidityDays();
});
function getValidityDays() {
    var d1 = parseDate($('#todaydate').val());
   // var d2 = parseDate($('#lpodate').val());
    console.log(d1)
    console.log('d2'+d2)
    var oneDay = 24*60*60*1000;
    var diff = 0;
    if (d1 && d2) {
  
      diff = Math.round(Math.abs((d2.getTime() - d1.getTime())/(oneDay)));
      console.log('diff'+diff);
    }
    //$('#validityperiod').val(diff);
}
function parseDate(input) {
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}
function validcheck()
{
/*externallabvalue();	
if(document.getElementById("searchsuppliername").value == '')
{
alert("Please Select External Lab");
document.getElementById("searchsuppliername").focus();
return false;
}*/
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="110%" border="0" cellspacing="0" cellpadding="2">
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
		
			<form name="drugs" action="externalradpo_report.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="70%" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>External Lab Report</strong></td>
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
</script>
        
					 <tr>
          <td width="110" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="156" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="94" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><span class="style1"><strong>Date To</strong></span></td>
          <td width="122" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
		  <span class="bodytext31"><img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
         
          </tr>
          
          <tr>

<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

<td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

<select name="location" id="location">

<option value="All">All</option>

<?php



$query1 = "select * from master_location where status='' order by locationname";

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



</select>

</span></td>

<td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"></td>
<td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"></td>
</tr>

					
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly /></td>
          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><!--Item Code :--> <?php //echo $medicinecode; ?>
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		  <input  type="submit" value="Search" name="Submit" />
		  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
		  <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
		  </strong></td>
		  
		  
		  <?php 
      //$default_lpo_date = date('Y-m-d', strtotime('+1 month'));
      $default_lpo_date = date('Y-m-d', strtotime("+60 days"));
      ?>    
      
           
</tr>
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
		<form name="form1" id="form1" method="post" action="externalradpo_report.php" onSubmit="return validcheck()">	
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%"
            align="left" border="0">
          <tbody>
		  <?php
		  if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
$externallabsupplier = $_REQUEST['searchsuppliername'];
		  ?>
		 
		  <tr>
		     
		      <td width="23" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
				<td width="74" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="177" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
              <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg No</strong></td>
              <td width="77" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
                 <td width="77" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>PO No</strong></div></td>
              <td width="58" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
				 <td width="74" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
				 <td width="74" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample Id</strong></div></td>
				 <td width="229" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name</strong></div></td>
				
				<td width="140" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier</strong></div></td>
				 <td width="90" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
				
				<td width="90" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Tax%</strong></div></td>
				
				<td width="90" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
             </tr>
				<?php
				
$sno=0;
$sno1=0;
if($location=='All')
{
    $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'consultation_radiology' as tablename from consultation_radiology where exclude = 'yes'  and externalack='1'  and  consultationdate between '$fromdate' and '$todate') 
 union all
( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'ipconsultation_radiology' as tablename from ipconsultation_radiology where exclude = 'yes'  and externalack='1' and  consultationdate between '$fromdate' and '$todate') order by recorddate desc";
}
else
{
	 $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'consultation_radiology' as tablename from consultation_radiology where exclude = 'yes'  and externalack='1'  and  consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') 
 union all
( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'ipconsultation_radiology' as tablename from ipconsultation_radiology where exclude = 'yes'  and externalack='1' and  consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') order by recorddate desc";
}
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num7 = mysqli_num_rows($exec7);
							
while($res7 = mysqli_fetch_array($exec7))
{
$res7auto_number= $res7['auto_number'];
$res7docnumber = $res7['docnumber'];
$patientname6 = $res7['patientname'];
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sampleid = $res7['sampleid'];
$billnumber2 = $res7['billnumber'];
$res7tablename = $res7['tablename'];

  $query70 = "select * from manual_lpo where sample_autono = '$res7auto_number' and sample_table ='$res7tablename' ";
$exec70 = mysqli_query($GLOBALS["___mysqli_ston"], $query70) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res70 = mysqli_fetch_array($exec70);
$suppliername = $res70['suppliername'];
$quantity = $res70['quantity'];
$rate_val = $res70['rate'];
$totalamount= $res70['totalamount'];
$itemtaxpercentage= $res70['itemtaxpercentage'];
$purchaseindentdocno= $res70['billnumber'];

$query751 = "select * from master_customer where customercode = '$regno' ";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$dob = $res751['dateofbirth'];
$age = calculate_age($dob);
$gender = $res751['gender'];

$query68="select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$externallab = $res68['externallab'];

$sno=$sno+1;
$sno1=$sno1+1;
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
             
              <td align="left" valign="center"  class="bodytext31"><?php echo $sno; ?></td>
				 <td align="left" valign="center"    class="bodytext31"><div align="left"><?php echo $billdate6; ?></div>
				
				 </td>
              <td align="left" valign="center"    class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
				<td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $regno; ?></div>
				
				</td>
              <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $visitno; ?></div>
              
              </td>
              <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $purchaseindentdocno; ?></div>
			
			  </td>
             	 <td align="left" valign="center"  class="bodytext31"><div align="left"><?php echo $age; ?></div>
				
				 </td>
				 <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $gender; ?></div>
			
				 </td>
				 
				 <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $res7docnumber; ?></div>
				
				 </td>
				 <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $test; ?>
				 
				 </div></td>
				 <td align="left" valign="center"  class="bodytext31" size="20"><?php echo $suppliername; ?></td>
							
			 <td align="right" valign="center"   class="bodytext31"><?php echo $rate_val; ?></td>
				
			 <td class="bodytext31" valign="center"  align="right" ><?php echo $itemtaxpercentage; ?></td>
		     <td class="bodytext31" valign="center"  align="right" ><?php echo number_format($totalamount, 2, '.', ','); ?></td>
				</tr>
				<?php
				}
				?>
                
				<tr>
       
      </tr>
	  <?php
	  }
	  ?>
    <!--  <tr>
       <td class="bodytext31" valign="center"  align="right" colspan="13"><a href="print_externallabpo_report.php?fromdate=<?php echo $fromdate; ?>&&todate=<?php echo $todate ?>&&locationcode=<?php echo $location ?>"target="_blank"  ><img height="25" width="25" src="images25\pdfdownload.jpg"></a></td>
       </tr>-->
		  </tbody>
		  </table>
		  </form></td>
      </tr>
	  
      
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<script>
</script>
<?php include ("includes/footer1.php"); ?>
</body>
</html>