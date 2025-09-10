<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");



$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];



$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));

$transactiondateto = date('Y-m-d');

$dateonly1 = date("Y-m-d");

$timeonly= date("H:i:s");

$titlestr = 'SALES BILL';

$colorloopcount = '';

$sno = '';

?>



<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {

	font-size: 36px;

	font-weight: bold;

}

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }



</style>

<?php

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

$docnumber = $_REQUEST["docno"];

?>



<?php

if (isset($_REQUEST["viewstatus"])) { $viewstatus = $_REQUEST["viewstatus"]; } else { $errcode = ""; }

if($viewstatus == 'viewed')

{

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

$docnumber = $_REQUEST["docnumber"];

	   $query26="update ip_vitalio set viewstatus ='$viewstatus' where patientcode='$patientcode' and visitcode='$visitcode' and docno='$docnumber' ";

	    $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}

?>

<script>

function popup()

{

  NewWindow=window.open('vitalinputchart1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>','newWin','width=700,height=400,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');

  //NewWindow.focus();

}

</script>



<script src="js/datetimepicker_css.js"></script>

<?php

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

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcrange('<?php echo $sn; ?>')">

<form name="frm" id="frmsales" method="post" action="viewvitalinputs.php" onKeyDown="return disableEnterKey(event)">

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

<!--  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

-->

  <tr>

    <td width="0%">&nbsp;</td>

	<td width="0%">&nbsp;</td>

    <td width="84%" valign="top">

	<table width="525" border="0" cellspacing="0" cellpadding="2">

    <tr>

    <td>&nbsp;</td>

	</tr>

	

     <tr>

	  <td colspan="10" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365">

				 <strong>VITALS INPUT </strong></td> 

      <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><!--<a href="" onclick='popup();'><strong>Click</strong></a>--></td>

      </tr>

				  

				   <tr>

		    <td width="10%" class="bodytext366" valign="center"  align="center" 

                bgcolor="#ffffff"><strong>Date</strong></td>

			<td width="10%"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><strong>Time</strong></td>

			<td width="10%"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><strong>Systolic</strong></td>

			<td width="10%"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><strong>Diastolic</strong></td>

			<td width="10%"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><strong>Pulse</strong></td>

			<td width="10%"  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext366"><strong>Resp</strong></td>

			<td width="10%"  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext366"><strong>Temp(C)</strong></td>

			<td width="10%"  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext366"><strong>Temp(F)</strong></td>

            <td width="10%"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><strong>Head Cir.</strong></td>
            <td width="15%"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><strong>BSA</strong></td>

			<td width="10%"  align="center" valign="center" 

				bgcolor="#ecf0f5" class="bodytext366">&nbsp;</td>	

		  </tr>

				  <?php

      $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc";

	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);

	  $num=mysqli_num_rows($exec31);

	  while($res31=mysqli_fetch_array($exec31))

	  { 

       $recorddate=$res31['recorddate'];

	   $recorddate=date("d/m/Y",strtotime($recorddate));

	   $recordtime=$res31['recordtime'];

	 

	   $systolic=$res31['systolic'];

	   $stolic_array[] =$systolic;

	   $highstolic=rsort($stolic_array);

	   echo $highstolic[0];

	  

	   $diastolic=$res31['diastolic'];

	   $diastolic_array[]=$diastolic;

	   $diasort[]=sort($diastolic_array);

	   $diasort[6];

	   //echo end($diastolic_array);

	   $lastIndex = key($diastolic_array);  

	   $last[] = $diastolic_array[$lastIndex];

	   

	  

	   

	 

	   $resp=$res31['resp'];

	   $pulse=$res31['pulse'];

	   $tempc=$res31['tempc'];

	   $tempc = number_format($tempc,2,'.','');

	   $tempf=$res31['tempf'];

       

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

		 

		  <td height="25" width="10%" class="bodytext3" valign="center"  align="center" 

               ><?php echo $recorddate; ?></td>

		   <td width="10%" class="bodytext3" valign="center"  align="center" 

               ><?php echo $recordtime; ?></td>

		  <td width="10%" class="bodytext3" valign="center"  align="center" 

               ><?php echo $systolic; ?></td>

		  <td width="10%" class="bodytext3" valign="center"  align="center"><?php echo $diastolic; ?>

	      

		  <td width="10%" class="bodytext3" valign="center"  align="center" 

               ><?php echo $pulse; ?></td> 

			   <td width="10%" class="bodytext3" valign="center"  align="center" 

               ><?php echo $resp; ?></td>   

		<td width="10%"  align="center" valign="center" 

				class="bodytext366"><?php echo $tempc; ?></td>

		<td width="10%"  align="center" valign="center" 

				class="bodytext366"><?php echo $tempf; ?></td>

		<td width="10%"  align="center" valign="center" bgcolor="#ecf0f5" 

				class="bodytext366">&nbsp;</td>         	   	   	   

		 </tr>

		  <?php

		 }

		 ?>

		  

		  <tr>

               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>

          </tr>     

			   <tr>

                <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name:

               <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><?php echo strtoupper($_SESSION['username']); ?></td>

               </tr>

	    </table>

		

	  </td>

    <td width="16%" valign="top">&nbsp;</td>

	</tr>

  </table>   



</form>

<?php include ("includes/footer1.php"); ?>



</body>

</html>