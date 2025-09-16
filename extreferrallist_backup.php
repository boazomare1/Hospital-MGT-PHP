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



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];



$docno = $_SESSION['docno'];


$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

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

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

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

<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

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





function loadprintpage1(banum)

{

	var banum = banum;

	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

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


<table width="100%" border="0" cellspacing="0" cellpadding="2">

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

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

       	<tr>

			<td width="860">

		

		

              <form name="cbform1" method="post" action="extreferrallist.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>External Referral</strong></td>

              </tr>

          

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="visitcode" type="text" id="patient" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			      

          <!--<tr>

          <td width="76" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>-->

           

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

			</tr>

            <tr>

			<td>

			<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchpatient = $_POST['patient'];

	$searchpatientcode=$_POST['patientcode'];

	

	$searchvisitcode=$_POST['visitcode'];

	$today = date('Y-m-d');

	$startdate = date('Y-m-d',strtotime('-3 day'));

	

	?>

	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

             <tr>

			 <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Referral Request</strong></div></td>

			 </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>OP Date </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>

              <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>

                <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Account</strong></div></td>

              <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>

              </tr>

			<?php

			$colorloopcount = '';

			$sno = '';

			

			$query76 = "select * from master_visitentry where paymentstatus='completed' and  patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and consultationdate between '$startdate' and '$today' and locationcode='$locationcode' group by visitcode order by consultationdate desc";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res76 = mysqli_fetch_array($exec76))

			{

			$patientcode = $res76['patientcode'];

			$patientvisitcode=$res76['visitcode'];

			$consultationdate=$res76['consultationdate'];

				$patientname=$res76['patientfullname'];

				$accountname=$res76['accountfullname'];

				$billtype = $res76['billtype'];

				

			$query8 = "select * from billing_paylater where patientcode = '$patientcode' and visitcode = '$patientvisitcode'";	

			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rows8 = mysqli_num_rows($exec8);

			if($rows8 == 0)

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

			?>

			<tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $consultationdate; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientvisitcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="center">

			      <?php echo $accountname; ?>			      </div></td>

             

             <td class="bodytext31" valign="center"  align="left"><a href="consultationreferral.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>"><strong>Referral</strong></a>			  </td>

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

				

              </tr>

			    </tbody>

        </table>

		<?php

}





?>	

		</td>

		</tr>

          </tbody>

        </table></td>

      </tr>

    </table>

</table>

<?php include ("includes/footer1.php"); ?>
    <!-- Modern JavaScript -->
    <script src="js/extreferrallist-modern.js?v=<?php echo time(); ?>"></script>
</body>

</html>



