<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="internalreferallist.xls"');
header('Cache-Control: max-age=80');

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$currentdate = date('d-m-Y');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$snocount = '';
$colorloopcount = '';
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
?>
</head>
<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            
            <tr>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
			  <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="17%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
			   <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Visit Code </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Gender </strong></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department From</strong></div></td>
				<td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department To</strong></div></td>
              <td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Referred By</strong></div></td>				
            </tr>
			
			<?php
			
			      
		  $query2 = "select * from consultation_departmentreferal where consultationdate between '$ADate1' and '$ADate2' order by consultationdate desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $nums = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2patientname = $res2['patientname'];
		  $res2patientcode= $res2['patientcode'];
		  $res2visitcode = $res2['patientvisitcode'];
		  $res2referalname = $res2['referalname'];
		  $res2username = $res2['username'];
		  $res2consultationdate = $res2['consultationdate'];
		
		  $query3 = "select * from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3= mysqli_fetch_array($exec3);
		  
		  $res3gender = $res3['gender'];
		  $res3age = $res3['age'];
		  $res3departmentname = $res3['departmentname'];
		 
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ffffff"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ffffff"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2consultationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3gender; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3age; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3departmentname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $res2referalname; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2username; ?></div></td>
			  
			 
           </tr>
			<?php
			}
			?>
            
  </tbody>
</table>
</body>
</html>