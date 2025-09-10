<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$department = '';
if(isset($_REQUEST['department']))
{
$department = $_REQUEST['department'];
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
.number1
{
text-align:right;
padding-left:700px;
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<?php $query12= "select * from master_triage where  triagestatus = 'completed' and overallpayment='' and consultationdate >= NOW() - INTERVAL 2 DAY order by consultationdate DESC";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12=mysqli_num_rows($exec12);
			?>
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
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	      
		        
      <tr>
	  <tr>
        <td><table width="100%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31">
                <div align="left"><strong>Review List </strong></div></td>
				<td colspan="5" bgcolor="#ecf0f5" class="bodytext31" align="right"><label><strong> <a href="consultationlist1.php">Click to See Consultation List</a></strong></label></td>
			    </tr>
	
            <tr>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Token</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP Date  </strong></div></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.No</strong></div></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No </strong></div></td>
              <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient</strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor </strong></div></td>
             <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Dept</strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
            				  <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Consultation Date</strong></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Action</strong></div></td>
			  </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
			$query1 = "select * from master_triage where triagestatus = 'completed' and ipconvert='' and consultationdate >= NOW() - INTERVAL 2 DAY order by consultationdate DESC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$department = $res1['department'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];
			$consultationtime = $res1['consultationtime']; 
			$consultationfees = $res1['consultationfees'];
			$urgentstatus = $res1['urgentstatus'];
			$accountname= $res1['accountname'];
			$consultation=$res1['consultation'];
			$token = $res1['token'];
			
			
						if($consultation == 'incomplete')
			{
			$status = 'Pending';
			}
			if($consultation == 'Inprogress')
			{
			$status = 'Inprogress';
			}
			if($consultation == 'completed')
			{
			$status = 'Completed';
			}
			
			$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
			$waitingtime = round($waitingtime);
			
			if($status == 'Pending')
			{
			
			$waitingtime1 = $waitingtime;
			}
			else
			{
			$waitingtime1 = '';
			}

			
			$query21 = "select * from master_consultationlist where visitcode='$visitcode' order by auto_number";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num21 = mysqli_num_rows($exec21);
			
			$res21 = mysqli_fetch_array($exec21);
			$consultationdatetime = $res21['consultationdate'];
			$consultationdatetime2 = strtotime($consultationdatetime);
		    $consultationdatetime1 = strtotime($consultationdatetime . ' + 1 day');
			$updatedatetime1 = strtotime($updatedatetime);
			
			$consultationdate1 = date('Y-m-d', $consultationdatetime2);
			
			if(($status == 'Completed')&&($consultationdatetime1 >= $updatedatetime1))
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
		
		    if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="FFFF00"';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $token; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo substr($consultationdate, 0, 10); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $consultingdoctorname;?>			      </div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $department;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accountname; ?></div></td>
              
			   <td class="bodytext31" valign="center"  align="center"><?php echo $consultationdate1; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><strong><a href="consultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Consult</a></strong></div></td>
              </tr>
			<?php
			}
			}    
			?>
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
			    </tr>
          </tbody>
		  
        </table>
      </td> 
	  <td width="98"><iframe marginwidth="19" src="labtestscrolling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" frameborder="0" scrolling="no"></iframe></td>   
      </tr>
	  <tr>
	  <td>
	   <td width="98"><iframe marginwidth="19" src="radiologytestscrolling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" frameborder="0" scrolling="no"></iframe></td>   
	   </tr>
	</table>
	  <div align="right"></div>
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

