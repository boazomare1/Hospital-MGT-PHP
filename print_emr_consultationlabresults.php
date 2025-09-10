<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$companyanum = $_SESSION["companyanum"];
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
?>

<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
?>
<?php

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];
$consultationprefix = $res1['consultationprefix'];

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];
$consultationprefix = $res1['consultationprefix'];
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>

</head>
<body>
<table width="59%" border="0" cellspacing="0" cellpadding="2">
   <tr>
       <td colspan="7"><div align="center"><?php
	echo '<strong>'.$res1companyname.'</strong>';
	echo '<br>'.$res1address1.' '.$res1area;
	echo '<br>Phone : '.$res1phonenumber1;
	?>
</td>
</tr>
			  <tr >
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td><strong>Patient* </strong></td>
	  <td width="9%" align="left" valign="middle" nowrap="nowrap">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>
                <td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">&nbsp;</td>
				
				<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
						  <td width="12%"  >
                <input name="ADate" id="ADate" type ="hidden" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" /><?php echo $dateonly1; ?></td>
			 </tr>
			  <tr>
			    
                 <td width="11%" align="left" valign="middle" nowrap="nowrap"><strong>Patient Code</strong></td>
                <td align="left" valign="top" >
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">&nbsp;</td>
				<td width="12%" nowrap="nowrap"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Visit Code </strong></td>
				<td width="12%" nowrap="nowrap"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $visitcode; ?>" type="hidden" size="5"><?php echo $visitcode; ?></td>

</tr></table>

			  <table width="59%" border="0" cellspacing="0" cellpadding="2">
			 	  <tr>
				  <td width="15%" align="left" valign="middle"><strong>&nbsp;</strong></td>
				   </tr>
		     <tr><td width="15%"  align="left" valign="center" class="bodytext366">
			 <div align="left"><strong>Previous Visit Date<strong></div></td>
		     <td width="15%"  align="left" valign="center" class="bodytext366" >
			 <div align="left"><strong>Previous Visit Code</strong></div></td>
			 <td width="39.5%" align="left" valign="center" class="bodytext366"><strong>Previous Lab Test</strong>
			   <div align="left"></div>	</div></td>
			 <td width="15%"  align="left" valign="center" class="bodytext366">
			 <div align="left"><strong>Reference</strong></div></td>
			 <td width="15%"  align="left" valign="center" class="bodytext366">
			 <div align="left"><strong>Result</strong></div></td>
		  </tr></table>
		    
				
		 <?php 
				 $querylab="select * from resultentry_lab where patientcode='$patientcode'";
				  $execlab=mysqli_query($GLOBALS["___mysqli_ston"], $querylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   $item=1;
				   if($item==1)
				    {
				  while($reslab=mysqli_fetch_array($execlab))
				  {
				  $labitemname=$reslab['itemname'];
				  $i=$labitemname;
				 $date5=$reslab['recorddate'];
				  $vcode5=$reslab['patientvisitcode'];
				 $billnumber=$reslab['billnumber'];
				  $referencename=$reslab['referencename'];
	              $referencerange=$reslab['referencerange'];
	              $resultvalue=$reslab['resultvalue'];
				
	?>
	  <table width="59%" border="0" cellspacing="0" cellpadding="2">
			   <tr>
		       <tr><td width="15%" align="left" valign="center" class="bodytext366" nowrap="nowrap">
			 <?php echo $date5; ?></td>
			   <td width="15%" align="left" valign="center" class="bodytext366"><?php echo $vcode5; ?></td>
			   <td width="40%" align="left" valign="center" class="bodytext366"><?php if($labitemname==$i) { if($labitemname==strtoupper($labitemname)) echo $labitemname; $i++;}?></td>
              <td width="15%" align="left" valign="center" class="bodytext366"><?php echo $referencename; ?></td>
              <td  align="left" valign="center" class="bodytext366"><?php echo $resultvalue; ?></div></td>             
		      </tr></table>
			   
 <?php
		 }
		 $item--;
		 }
		 ?>
		 
			
		<table width="59%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left" valign="middle"   class="bodytext32">Results Posted By:
          <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><strong><?php echo strtoupper($_SESSION['username']); ?></strong></td>
          </tr>
</table>
</body>
</html>