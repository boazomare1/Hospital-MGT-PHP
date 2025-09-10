<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$icddatefrom = date('Y-m-d', strtotime('-1 month'));
$icddateto = date('Y-m-d');

$colorloopcount = '';
$sno = '';
$snocount = '';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Testwise Report.xls"');
header('Cache-Control: max-age=80');

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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$icddatefrom = $_REQUEST['ADate1'];
$icddateto = $_REQUEST['ADate2'];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$icdddatefrom = $_REQUEST['ADate1'];
	$icdddateto = $_REQUEST['ADate2'];
}
else
{
	$icdddatefrom = date('Y-m-d', strtotime('-1 month'));
	$icdddateto = date('Y-m-d');
}

?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="947" 
            align="left" border="1">
          <tbody>
          <tr>
            <td colspan="8" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Testwise Report</strong></td>
            </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				 {
				 $searchage = $_REQUEST['searchage'];
				 $searchrange = $_REQUEST['searchrange'];
				 $searchicdcode = $_REQUEST['searchicdcode'];
				 $searchicdcode = trim($searchicdcode);
		     ?>
			<tr>
				<td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></td>
				<td width="25%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Name</td>
				<td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg NO</td>
				<td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Code</td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Age</td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Gender</td>
				<td width="25%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Result</td>
			</tr>
			
			<?php
		  if($searchicdcode == '')
		  {
		 $query1 = "select * from resultentry_lab where itemname = '$searchicdcode' and recorddate between '$icddatefrom' and '$icddateto' and resultvalue !='' order by auto_number desc ";
		  }
		   else
		   {
		    $query1 = "select * from resultentry_lab where itemname='$searchicdcode' and recorddate between '$icddatefrom' and '$icddateto' and resultvalue !='' order by auto_number desc ";
		   }
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			 {
				$res1patientcode= $res1['patientcode'];
				$res1patientvisitcode= $res1['patientvisitcode'];
				$res1consultationdate= $res1['recorddate'];
				$res1patientname= $res1['patientname'];
				$res1resultvalue= $res1['resultvalue'];
				$res1referencename=$res1['referencename'];
				
				$query751 = "select * from master_customer where customercode = '$res1patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];
				$gender = $res751['gender'];
			
			        $today = new DateTime();
					$diff = $today->diff(new DateTime($dob));
					
					if ($diff->y)
					{
					$res2age= $diff->y . ' Years';
					}
					elseif ($diff->m)
					{
					$res2age=$diff->m . ' Months';
					}
					else
					{
					$res2age=$diff->d . ' Days';
					}
			if ($res1patientcode == 'walkin')
			{ 
			  //$res2age=$res1['age'];
			}  

			if ($searchrange == '')
		     { 
    	  	$snocount = $snocount + 1;
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
            
            <tr>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
			
		  if ($searchrange == 'equal')
		  { 
		  if($searchage == $diff->y)
		  {
		  	$snocount = $snocount + 1;
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
            
            <tr>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		 }
		  }
		  else if ($searchrange == 'greater')
		  {
		  if($searchage < $diff->y)
		  {
		 	$snocount = $snocount + 1;
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
            
            <tr>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
		  else if ($searchrange == 'lesser')
		  {
		  if($searchage > $diff->y)
		  {
		  	$snocount = $snocount + 1;
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
            
            <tr>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
		  else if ($searchrange == 'greaterequal')
		  {
		   if($searchage <= $diff->y)
		  {
		 	$snocount = $snocount + 1;
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
            
            <tr >
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
		  else if ($searchrange == 'lesserequal')
		  {
		    if($searchage >= $diff->y)
		  {
		  	$snocount = $snocount + 1;
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
            
            <tr >
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
			
			
			 }
		   }
		   ?>
            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff">&nbsp;</td>
              <td align="right" valign="center" 
                bgcolor="#fff" class="bodytext31">&nbsp;</td>
				<td colspan="5" align="right" valign="center"  class="bodytext31">&nbsp;</td>
			   </tr>
          </tbody>
        </table>

