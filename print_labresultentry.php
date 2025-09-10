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
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

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
       <td colspan="5"><div align="center"><?php
	echo '<strong>'.$res1companyname.'</strong>';
	echo '<br>'.$res1address1.' '.$res1area;
	echo '<br>Phone : '.$res1phonenumber1;
	?>
    
</div></td>
<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#labresult';
        window.location.reload();
    }
}
</script>
</tr>

			  <tr>
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td><strong>Patient* </strong></td>
	  <td width="9%" align="left" valign="middle" nowrap="nowrap">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>
                <td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">&nbsp;</td>
				
				<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
						  <td width="68%"  >
                <input name="ADate" id="ADate" type ="hidden" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" /><?php echo $dateonly1; ?>				</td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
              </tr>
			  <tr>
			    
                 <td width="11%" align="left" valign="middle" nowrap="nowrap"><strong>Patient Code</strong></td>
                <td align="left" valign="top" >
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">&nbsp;</td>
				<td align="left" valign="top" ><strong>Account</strong>                
				<td align="left" valign="top" ><input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
			  <?php echo $accountname; ?></tr>
			  
				  
				  <table width="59%" border="0" cellspacing="0" cellpadding="2">
				  
			 	  <tr>
				  <td width="4%" align="left" valign="middle"   ><strong>&nbsp;</strong></td>
				   <tr>
		     <td width="15%" class="bodytext366" valign="center"  align="left">
			 <div align="left">Test</div></td>
			<td width="15%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">Reference</div></td>
			<td width="15%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">Results</div></td>
		  </tr>
		  	  <?php
	  $query31="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber='$docnumber'";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  $item=1;
	  if($item==1) {
	  while($res31=mysqli_fetch_array($exec31))
	  { 
	   $labname1=$res31['itemname'];
	   $itemcode2=$res31['itemcode'];
	     
	   $itemname=$res31['itemname'];
	                  
       $referencename=$res31['referencename'];
	   $referencerange=$res31['referencerange'];
	   $resultvalue=$res31['resultvalue'];
	
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
			$sno = $sno + 1;
			
		?>		  
			      <table width="59%" border="0" cellspacing="0" cellpadding="2"> 
			  <tr>
			  <td width="15%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong><?php if($item==1) echo $itemname;  $item++?></strong></div></td>              </tr></table>
			    <table width="59%" border="1" cellspacing="0" cellpadding="2">
			  <td width="39%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><?php echo $referencename; ?></div></td>             
			  <td width="28%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">
			    <div align="left"><?php echo $referencerange; ?></div></td>             
			  <td width="33%" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $resultvalue; ?></div>              </td>              
              </tr>
			  </table>
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

</form> 


</body>
</html>