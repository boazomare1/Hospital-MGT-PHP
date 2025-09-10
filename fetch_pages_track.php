<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$pcode ='';	 
$patientcode1 ='';
$res5disease ='';
$res4disease ='';
$ADate1 = date('Y-m-d',strtotime('-1 month'));
$ADate2 = date('Y-m-d');  
 
 if (isset($_REQUEST["patientcode"])) {$patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
 if (isset($_REQUEST["visitcode"])) {$visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
  
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
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
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
.bali
{
text-align:right;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">

<table width="1300" border="0" align="center" valign="top" cellspacing="0" cellpadding="2" >
			
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
		<td>
				  <table width="100%" height="40" bgcolor="#cccccc" >
             
            <tr>
              <td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Date </strong></div></td>

				<td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				<td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>
              <td width="100"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
				<td width="25"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Gender</strong></div></td>
				<td width="100"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age</strong></div></td>
                <td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
                <td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Fees</strong></div></td>
				<td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Subtype</strong></div></td>
				<td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Created By</strong></div></td>
                <td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Payment Status</strong></div></td>
               
              </tr>
              <?php
			   function format_interval_dob(DateInterval $interval) {
			$result = "";
			if ($interval->y) { $result .= $interval->format("%y Years "); }
			if ($interval->m) { $result .= $interval->format("%m Months "); }
			if ($interval->d) { $result .= $interval->format("%d Days "); }

			return $result;
		}
		$colorloopcount=0;
              $query1 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		//$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['consultationdate'];
		$accountname=$res1['accountfullname'];
		$username=$res1['username'];
		$patientsubtype =$res1['subtype'];
		$gender =$res1['gender'];
		$billtype = $res1['billtype'];
	    $menusub=$res1['subtype'];
		$paymentstatus=$res1['paymentstatus'];
		$consultationfees=$res1['consultationfees'];
		
		$query44 = "select * from master_customer WHERE customercode = '$patientcode' ";
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num44 = mysqli_num_rows($exec44);
		$res44 = mysqli_fetch_array($exec44);		
		$patientname = $res44['customerfullname'];
		$dateofbirth=$res44['dateofbirth'];
		if($dateofbirth>'0000-00-00'){
		  $today = new DateTime($consultationdate);
		  $diff = $today->diff(new DateTime($dateofbirth));
		  $patientage = format_interval_dob($diff);
		}else{
		  $patientage = '<font color="red">DOB Not Found.</font>';
		}

		$querysub = "select * from master_subtype where auto_number='$patientsubtype'";
        $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], $querysub);
        $execsubtype=mysqli_fetch_array($querysubtype);
        $patientsubtype1=$execsubtype['subtype'];

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
			   
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientage; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">
			    <div align="center">			      <?php echo $accountname; ?>			      </div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationfees; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center">			      <?php echo $patientsubtype1; ?>			      </div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $username; ?></div></td>
                   <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $paymentstatus; ?></div></td>
              </tr>
		   <?php 
		   } 
		  
		   ?>
              </table>
              </td>
              </tr>
			
<tr>
		<td>
				  <table width="100%" height="40" bgcolor="#cccccc" >
				    <tr >
						<td width="100%" colspan="3"  align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
							<span class="bodytext3"> <strong>Medicine List </strong> </span></td>
						 
				 </tr>
				  <tr >
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Date </span></td>
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="30%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Medicine Name</span></td>
				   <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Price</span></td>
				   <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Payment Status</span></td>
				  <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Pharmacy Approval</span></td>
				  <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Medicine Issue Status</span></td>
					  </tr>
				  
				  <?php
				  $colorloopcount = '';
				  $querymed="select recorddate,patientvisitcode from master_consultationpharm where patientvisitcode='$visitcode' group by patientvisitcode order by auto_number DESC";
				  $execmed=mysqli_query($GLOBALS["___mysqli_ston"], $querymed);
				  while($resmed=mysqli_fetch_array ($execmed))
				  {
				  $medname='';
				  $date4=$resmed['recorddate'];
				  $vcode4=$resmed['patientvisitcode'];
				  
				   $vcode5=explode('-',$vcode4);
			       $vcodenew5=$vcode5[1];
				  
				   
				  if($vcodenew5)
				  {
				  $querymed1="select medicinename,pharmacybill,medicineissue,billtype,paymentstatus,rate from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$vcode4'";
				   $execmed1=mysqli_query($GLOBALS["___mysqli_ston"], $querymed1);
				  $nummed1=mysqli_num_rows($execmed1);
				  while($resmed1=mysqli_fetch_array ($execmed1))
				  {
				 $med=$resmed1['medicinename'];
				 $pharmacybill=$resmed1['pharmacybill'];
				 $medicineissue=$resmed1['medicineissue'];
				 $billtype=$resmed1['billtype'];
				 $bill_status=$resmed1['paymentstatus'];
				 $medrate=$resmed1['rate'];
				 if($billtype=='PAY LATER')
				 {
					 $bill_status='completed';
				 }
				
				  $colorloopcount = $colorloopcount + 1;
					$showcolor = ($colorloopcount & 1); 
					if ($showcolor == 0)
					{
						//echo "if";
						$colorcode = 'bgcolor="#FFFFFF"';
					}
					else
					{
						//echo "else";
						$colorcode = 'bgcolor="#FFFFFF"';
					}
		?>
		  <tr <?php echo $colorcode; ?>>
					<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date4;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode4;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $med;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $medrate;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $bill_status;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $pharmacybill;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $medicineissue;?></div> </td>
			   	</tr>
                <?php
				  }
				  }
				  }
				  ?>
			</table>
				  </td>
</tr> 
 
<tr>
		<td>
				  <table width="100%" height="40" bgcolor="#cccccc" >
				   <tr >
						<td width="100%" colspan="3"  align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
							<span class="bodytext3"> <strong>Lab Tests </strong> </span></td>
						 
				 </tr>
				   
				  <tr >
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Date </span></td>
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="30%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Lab Test</span></td>
				  <td  width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span  class="bodytext3">Price</span></td>
				 <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Payment Collection</span></td>
				    <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Sample Collection</span></td>
				  <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Result Entry</span></td>
				
				  </tr>
				  <?php
				  $colorloopcount = '';
				  $sno = 0;
				  $querylab="select consultationdate,patientvisitcode,labsamplecoll,labitemname,resultentry,paymentstatus,labitemrate,billtype from consultation_lab where patientvisitcode='$visitcode'  order by auto_number DESC";
				   $execlab=mysqli_query($GLOBALS["___mysqli_ston"], $querylab);
				  while($reslab=mysqli_fetch_array ($execlab))
				  {
				  $labname='';
				  $date5=$reslab['consultationdate'];
				  $vcode5=$reslab['patientvisitcode'];
				  $labsamplecoll=$reslab['labsamplecoll'];
				  $labitemname=$reslab['labitemname'];
				   $labitemrate=$reslab['labitemrate'];
				  $resultentry=$reslab['resultentry'];
				  $paymentstatus=$reslab['paymentstatus'];
				  $billtype=$reslab['billtype'];
				
				 if($billtype=='PAY LATER')
				 {
					 $paymentstatus='completed';
				 }
				  
				   $vcode6=explode('-',$vcode5);
			       $vcodenew6=$vcode6[1];
				  
				   $colorloopcount = $colorloopcount + 1;
					$sno = $sno + 1;
					$showcolor = ($colorloopcount & 1); 
					if ($showcolor == 0)
					{
						//echo "if";
						$colorcode = 'bgcolor="#FFFFFF"';
					}
					else
					{
						//echo "else";
						$colorcode = 'bgcolor="#FFFFFF"';
					}
				
				  if($vcodenew6)
				  {
				?>	
		    <tr <?php echo $colorcode; ?>>
		     <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date5;?></div> </td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode5;?></div> </td>
			 <td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $labitemname;?></div> </td>
			 <td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $labitemrate;?></div> </td>
			 <td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $paymentstatus;?></div> </td>
			 <td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $labsamplecoll;?></div> </td>
			<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $resultentry;?></div> </td>
	          </tr>
              <?php
				}
			}
			?>
		</table>
				  </td>
</tr>

<tr>
		<td>
				  <table width="100%" height="40" bgcolor="#cccccc" >
				   <tr >
						<td width="100%" colspan="3"  align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
							<span class="bodytext3"> <strong>Radiology Tests</strong> </span></td>
						 
				 </tr>
				  
				  <tr >
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Date </span></td>
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="30%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Radiology Test</span></td>
				   <td  width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span  class="bodytext3">Price</span></td>
				  <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Patient Prepare</span></td>
				   <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Image Aquisition</span></td>
				   <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Result Entry</span></td>
				
				  </tr>
				<?php  
		$colorloopcount = '';
		$queryrad="select consultationdate,patientvisitcode,docnumber from consultation_radiology where patientvisitcode='$visitcode' group by patientvisitcode order by auto_number DESC";
		$execrad=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad);
		while($resrad=mysqli_fetch_array ($execrad))
		{  
			$radname='';
			$date6=$resrad['consultationdate'];
			$vcode6=$resrad['patientvisitcode'];
			$resraddocnumber=$resrad['docnumber'];
								  
			$vcode7=explode('-',$vcode6);
			$vcodenew7=$vcode7[1];
					
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#FFFFFF"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#FFFFFF"';
				}			
			
			if($vcodenew7)
			{
			
			$queryrad1="select radiologyitemname ,docnumber,prepstatus,radiologyitemrate,imgaquistatus,resultentry from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$vcode6' and resultentry='pending' ";
				$execrad1=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad1);
				$numrad1=mysqli_num_rows($execrad1);

				while($resrad1=mysqli_fetch_array ($execrad1))
				{   

					$radiologyitemname=$resrad1['radiologyitemname'];
					$prepstatus=$resrad1['prepstatus'];
					$radiologyitemrate=$resrad1['radiologyitemrate'];
					$imgaquistatus=$resrad1['imgaquistatus'];
					$resultentry=$resrad1['resultentry'];
					
                   ?>
                 <tr <?php echo $colorcode; ?>>
					<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date6;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode6;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $radiologyitemname;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $radiologyitemrate;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $prepstatus;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $imgaquistatus;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $resultentry;?></div> </td>
					 </tr>
                     <?php
		}	
	}
}
?>
			</table>
    </td>
</tr>
<tr>
		<td>
				  <table width="100%" height="40" bgcolor="#cccccc" >
				    <tr >
						<td width="100%" colspan="3"  align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
							<span class="bodytext3"> <strong> Procedures </strong> </span></td>
						 
				 </tr>
				
				  
				  <tr >
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Date </span></td>
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="30%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Previous Services</span></td>
				   <td  width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span  class="bodytext3">Price</span></td>
				  <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Patient Prepare</span></td>
				   <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Process</span></td>
				  <td width="10%" align="left" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3"></span></td>
				 				
				  </tr>
                  <?php
				   
					  $colorloopcount = '';
					  $queryrad="select consultationdate,patientvisitcode,docnumber from consultation_services where patientvisitcode='$visitcode' group by patientvisitcode order by auto_number DESC";
					  	$execrad=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad);
						  while($resrad=mysqli_fetch_array ($execrad))
							  {
								  $radname='';
								  $date7=$resrad['consultationdate'];
								  $vcode7=$resrad['patientvisitcode'];
								  $resraddocnumber=$resrad['docnumber'];
								  
								   $vcode8=explode('-',$vcode7);
							 	   $vcodenew8=$vcode8[1];
 
									  if($vcodenew8)
									  {
										   $queryrad1="select servicesitemname,servicesitemrate,paymentstatus,process from consultation_services where patientcode='$patientcode' and patientvisitcode='$vcode7' ";
										   	$execrad1=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad1);
										  $numrad1=mysqli_num_rows($execrad1);
											  while($resrad1=mysqli_fetch_array ($execrad1))
											  {
												 $rad=$resrad1['servicesitemname'];
												 $servicesitemrate=$resrad1['servicesitemrate'];
												 $paymentstatus=$resrad1['paymentstatus'];
												 $process=$resrad1['process'];
												
											 
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							//echo "if";
							$colorcode = 'bgcolor="#FFFFFF"';
						}
						else
						{
							//echo "else";
							$colorcode = 'bgcolor="#FFFFFF"';
						}
				 
		
				 ?>
                 <tr <?php echo $colorcode; ?>>
					<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date7;?></div> </td>
					<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode7;?></div></td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $rad;?></div></td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $servicesitemrate;?></div></td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $paymentstatus;?></div></td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $process;?></div></td>
					<td class="bodytext3" valign="center"  align="left"><div align="left"></div></td>
					 </tr>
				<?php
				  }
				  }
				 } 
				 ?>

			</table>
    </td>
</tr>
<tr>
			<td>
            
            <table width="100%" height="40" bgcolor="#cccccc" >
				   <tr >
						<td width="100%" colspan="3"  align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
							<span class="bodytext3"> <strong>Bill Details</strong> </span></td>
						 
				 </tr>
                  <tr >
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Bill No </span></td>
				  <td width="10%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Bill Amt</span></td>
                  </tr>
            <?php
            $query1 = "select * from master_visitentry where  visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1=mysqli_num_rows($exec1);
$res1 = mysqli_fetch_array($exec1);

$patientcode=$res1['patientcode'];

$visitcode=$res1['visitcode'];

$consultationdate=$res1['consultationdate'];

$accountname=$res1['accountfullname'];

$planpercentage=$res1['planpercentage'];


/*$query1 = "select * from billing_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and  locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";

$query2 = "select * from billing_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
if($planpercentage==0){?>
               <a target="_blank" href="print_billpaynowbill_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Bill Paynow</strong></a></td>
               
               <?php } else {?>
			    <a target="_blank" href="print_billpaynowbill_dmp4inch_copay.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Bill Paynow</strong></a></td>
			   <?php }?>
               
               
               $query7 = "select a.* from billing_paylater as a,master_visitentry as b where a.patientcode like '%$searchpatientcode%' and a.visitcode like '%$searchvisitcode%' and a.patientname like '%$searchpatient%' and a.billno like '%$billnumber%' and a.locationcode='$locationcode1' and a.patientcode <> '' and a.billdate between '$transactiondatefrom' and '$transactiondateto' and a.visitcode=b.visitcode order by a.auto_number desc ";
               <?php*/
		
		
	     $query128 = "select source,patientcode,patientvisitcode,billdate,patientname,billnumber,username,locationcode,amount from (select 'print_consultationbill_dmp4inch1.php' as source, patientcode,patientvisitcode,billdate,patientname,billnumber,username,locationcode,consultation as amount from billing_consultation where patientvisitcode='$visitcode'
	UNION ALL
	select 'print_billpaynowbill_dmp4inch1.php' as source,patientcode,visitcode as patientvisitcode,billdate,patientname,billno as billnumber,username,locationcode,totalamount as amount from billing_paynow where visitcode='$visitcode'
	UNION ALL
	select 'print_paylater_detailed.php' as source,patientcode,visitcode as patientvisitcode,billdate,patientname,billno as billnumber,username,locationcode,totalamount as amount from billing_paylater where visitcode='$visitcode') u GROUP BY billnumber";
		$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in query128".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res128 = mysqli_fetch_array($exec128))
		{
		$res128patientcode= $res128['patientcode'];
		$res128patientvisitcode= $res128['patientvisitcode'];
		$res128billdate= $res128['billdate'];
		$res128patientname= $res128['patientname'];
		$billnumber= $res128['billnumber'];
		$res128username= $res128['username'];
		$res128locationcode1= $res128['locationcode'];
		$res128source= $res128['source'];
		$totalamount= $res128['amount'];
		
		if($planpercentage>0 && $res128source=='print_billpaynowbill_dmp4inch1.php')
		{
		$res128source='print_billpaynowbill_dmp4inch_copay.php';	
		}
		
		/*if($res128source=='print_paylater_detailed.php')
		{
			$querysub1 = "select fxamount as totalamount,billno as billnumber from billing_paylater where visitcode='$visitcode' group by billnumber";
			
		}
		else
		{
			echo $querysub1 = "select sum(cash + cheque + card + mpesa + online + adjust) as totalamount,billnumber from paymentmodedebit where patientvisitcode='$visitcode' group by billnumber";
		}
		
        $querysubtype1=mysqli_query($GLOBALS["___mysqli_ston"], $querysub1);
		$execsubtype1 = mysqli_fetch_array($querysubtype1);

		$totalamount=$execsubtype1['totalamount'];
		$billnumber=$execsubtype1['billnumber'];*/
		?>
		 <tr <?php echo $colorcode; ?>>

			             <td class="bodytext31" valign="center"  align="center"> <a target="_blank" href="<?php echo $res128source;?>?locationcode=<?php echo $res128locationcode1; ?>&&billautonumber=<?php echo $billnumber; ?>&&patientcode=<?php echo $res128patientcode; ?>" target="_blank"><strong><?php echo $billnumber; ?></strong></a></td>      
 <td class="bodytext31" valign="center"  align="center"><div align="center"> <?php echo number_format($totalamount,2,'.',''); ?></div></td>
         

              </tr>
              <?php
		}
		
				 ?>
				
			</td>
	   </tr>
</table>
