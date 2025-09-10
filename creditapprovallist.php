<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
//$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Credit Approval List</title>
<!-- Modern CSS -->
<link href="css/creditapprovallist-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/creditapprovallist-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php
<!-- Inline styles moved to external CSS file -->
<!-- Modern CSS -->
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<!-- Inline JavaScript moved to external JS file -->

<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
}
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<!-- Modern JavaScript -->
<script type="text/javascript" src="creditapprovallist.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<?php $querynw1 = "select * from ip_creditapproval where recordstatus='' group by visitcode order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
			
			?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" ><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" ><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" ><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">
    <form name="cbform1" method="post" action="creditapprovallist.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3"  class="bodytext3"><strong> Search Patient to Bill </strong></td>
              <td colspan="1"  class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
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
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			  <tr>
          <td width="136" align="left" valign="center"  
 class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"   class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  ><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>	
   
    </td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%"  class="bodytext31">&nbsp;</td>
              <td colspan="9"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Credit Approval List</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
><div align="left"><strong>No.</strong></div></td>
               <td width="8%"  align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>IP Date </strong></div></td>
          
              <td width="8%"  align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="6%"  align="left" valign="center"   class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="3%"  align="left" valign="center"   class="bodytext31"><div align="left"><strong></strong></div></td>
              <td width="16%"  align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				
             
              <td width="11%"  align="left" valign="center" 
 class="bodytext31"><strong>Account</strong></td>
                <td width="11%"  align="left" valign="center" 
 class="bodytext31"><strong>Location</strong></td>
              <td width="5%"  align="left" valign="center" 
 class="bodytext31" colspan="2"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			$colorloopcount = '';
			$sno = '';
			$query2 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
						 $locationname = $res2["locationname"];
						 $locationcode = $res2["locationcode"];
			}
?>		
				
				
	<?php
	$colorloopcount1=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{		
				
	 $searchpatient = $_POST['patient'];
	 $searchpatientcode=$_POST['patientcode'];
	 $searchvisitcode = $_POST['visitcode'];
	 $fromdate=$_POST['ADate1'];
	 $todate=$_POST['ADate2'];		
				
			if( $searchpatientcode !="" || $searchvisitcode!="" )
			{
				$query190 = "select * from ip_creditapproval where recordstatus!='approved' and (patientcode='$searchpatientcode' or visitcode ='$searchvisitcode')   ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec190 = mysqli_query($GLOBALS["___mysqli_ston"], $query190) or die ("Error in Query190".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else if($searchpatient!="")
			{
				$query19 = "select * from ip_creditapproval where recordstatus!='approved' and patientname like '%$searchpatient%'  ";
				$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query190) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else if($searchpatient =="" || $searchpatientcode =="" || $searchvisitcode =="" )
			{
				
			$query190 = "select * from ip_creditapproval where recordstatus!='approved' and recorddate between '$fromdate' and '$todate'   order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec190= mysqli_query($GLOBALS["___mysqli_ston"], $query190) or die ("Error in Query1900".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			while ($res190 = mysqli_fetch_array($exec190))
			{
			$patientcode = $res190['patientcode'];
			$visitcode = $res190['visitcode'];
			$patientname = $res190['patientname'];
			$account = $res190['accountname'];
			$locationcodeget=$res190['locationcode'];
			$locationnameget=$res190['locationname'];
			
			
		
			
			$query111 = "select consultationdate, auto_number from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$ipdate = $res111['consultationdate'];
			$ipvist_autonumber = $res111['auto_number'];
			
			$query671 = "select visitcode from billing_ipcreditapproved where visitcode = '$visitcode'";
			$exec671 = mysqli_query($GLOBALS["___mysqli_ston"], $query671) or die ("Error in query671".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row671= mysqli_num_rows($exec671);
			if($row671 == 0)
			{
			 include ('ipcreditaccountreport3_ipcredit.php');
			 	$total = $overalltotal;
			$colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			
			
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = '';
			}
			
			
			 
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ipdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left"> <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              	<a style="cursor: pointer;" onclick="window.open('ipbilling_notes.php?ipvist_autonumber=<?=$ipvist_autonumber?>', '_blank', 'location=yes,height=570,width=700,scrollbars=yes,status=yes');">
					<img src="images/b_edit.png">
				</a>
              </td>
              <td class="bodytext31" valign="center"  align="left"> <div align="left"><?php echo $patientname; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $locationnameget; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($total>0){ ?><a href="creditapprovalform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Process</strong></a> <?php } ?></div></td>

			  <td class="bodytext31" valign="center" align="left">
			    <div align="left">
			    <a href="creditapprovalcancel.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Cancel</strong></a></div>
			  </td>
              </tr>
			<?php
			}  
			}
			}
			?>
			
            <tr>
               <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
			    <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			    <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
          
              </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>
</body>
</html>

