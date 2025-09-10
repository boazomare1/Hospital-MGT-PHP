<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$updatedatetime = date('Y-m-d H:i:s');

$colorloopcount = '';
$sno = '';
$snocount = 0;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="RegistrationReport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["age"])) {  $searchage = $_REQUEST["age"]; } else { $searchage = ""; }
if (isset($_REQUEST["range"])) {  $range = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["cbcustomername"])) {  $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

if (isset($_REQUEST["searchgender"])) {  $searchgender = $_REQUEST["searchgender"]; } else { $searchgender = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
?>
</head>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td width="1900">
		  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1456" 
            align="left" border="0">
          <tbody>
			<tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="4%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Salu.</strong></td>
				
              <td width="4%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>First Name</strong></div></td>
              <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Middle Name</strong></div></td>
              <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Last Name</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></td>
				<td width="40%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Date</strong></div></td>
   				  <td width="2%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
   				  <td width="4%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
                
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>DOB</strong></div></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Marital Status</strong></div></td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Residence</strong></div></td>
                
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mobile</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Next Of Kin Name</strong></td>
   				  <td width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Kin.Mobile</strong></div></td>
                
   				  <td width="18%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registered By</strong></div></td>
			</tr>
			
			<?php
	if($searchgender!='')
		{
				if($range=='equal')
				{
		  		    $query7 = "select * from master_customer where username like '%$cbcustomername%' and age ='$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greater')
				{ 
		  		   $query7 = "select * from master_customer where username like '%$cbcustomername%' and age > '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesser')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age < '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greaterequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age >= '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesserequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age <= '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				else
				{
				$query7 = "select * from master_customer where username like '%$cbcustomername%' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'";
				}
		}
		else
		{
				if($range=='equal')
				{
		  		    $query7 = "select * from master_customer where username like '%$cbcustomername%' and age ='$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greater')
				{ 
		  		   $query7 = "select * from master_customer where username like '%$cbcustomername%' and age > '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesser')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age < '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greaterequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age >= '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesserequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age <= '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				else
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
		}

				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$customerfullname= $res4['customerfullname'];

				$customername= $res4['customername'];
				$salutation= $res4['salutation'];
				$customermiddlename= $res4['customermiddlename'];
				$customerlastname= $res4['customerlastname'];

				$patientcode= $res4['customercode'];
				$registeredby= $res4['username'];
				$registrationdate= $res4['registrationdate'];
				$age= $res4['age'];
				$gender= $res4['gender'];
				$mobilenumber= $res4['mobilenumber'];
				$kinname= $res4['kinname'];
				$kincontactnumber= $res4['kincontactnumber'];
				$gender= $res4['gender'];
				
				$dateofbirth= $res4['dateofbirth'];
				$maritalstatus= $res4['maritalstatus'];
				$residence= $res4['area'];
				$accountnum = $res4['accountname'];
				
				$qryacc = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number=$accountnum");
				$resacc = mysqli_fetch_assoc($qryacc);
				$accountname = $resacc['accountname'];
				
			
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
				<tr >
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $salutation; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customername; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customermiddlename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customerlastname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $age; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $dateofbirth; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $maritalstatus; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $residence; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $mobilenumber; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $kinname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $kincontactnumber; ?></div></td>
                
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $registeredby; ?></div></td>
				</tr>
			<?php
			}
			?>
			
          </tbody>
        </table>
		</td>
      </tr>
    </table>
</table>
</body>
</html>

