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



if(!empty($_REQUEST['billnumber']) && !empty($_REQUEST['visitcode']) && !empty($_REQUEST['remarks'])){



//echo $name_rm="remark".$_REQUEST['remark_id'];

$billnumber=$_REQUEST['billnumber'];

$v_code=$_REQUEST['visitcode'];

$remark_text=$_REQUEST['remarks'];



			$query76 = "select auto_number from master_billing where refund_status='' and  billnumber = '$billnumber' and visitcode = '$v_code' limit 0,1";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res76 = mysqli_fetch_array($exec76))

			{

			//$query8 = "select auto_number from billing_paylater where patientcode = '$p_code' and visitcode = '$v_code'";	

			//$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

			//$rows8 = mysql_num_rows($exec8);

			//	if($rows8 == 0)

			//	{

					$query81 = "update master_billing set refund_status='requested',refundremarks='$remark_text',refundrequestedby='$username',updatetime=updatetime  where billnumber = '$billnumber' and visitcode = '$v_code'";	

					$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

					

			//	}

			}

			

header('location:consultationrefundrequestlist.php');

}



?>

<!-- Modern CSS -->
<link href="css/consultationrefundrequestlist-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/consultationrefundrequestlist-modern.js?v=<?php echo time(); ?>"></script>

<!-- Form submission function moved to external JS -->

<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

// Auto-suggest initialization moved to external JS





// Key handling function moved to external JS





// Print function moved to external JS





</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<!-- Additional styles moved to external CSS -->

</head>



<body>

<?php $querynw1 = "select * from master_visitentry where itemrefund='refund' and overallpayment='completed' order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resnw1=mysqli_num_rows($execnw1);

?>

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

		

		

              <form name="cbform1" method="post" action="consultationrefundrequestlist.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Refund Request </strong></td>

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
              
			   <tr>


              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill No.</td>


              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">


                <input name="billno" type="text" id="billno" value="" size="50" autocomplete="off">


              </span></td>


              </tr>

			      

            <tr>

          <td width="76" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date From </strong></td>

          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

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

	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];

    $searchbillno=$_POST['billno'];

	

	

	?>

	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

             <tr>

			 <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Consultation Refund</strong></div></td>

			 </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date </strong></div></td>

               <td width="13%"  align="left" valign="center" 


                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No. </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>

              <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>

                	

				<td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Bill Amt</strong></div></td>	

                <td width="25%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Remarks</strong></div></td>

              <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>

              </tr>

			<?php

			$colorloopcount = '';

			$sno = '';

			

			//$query76 = "select * from master_visitentry where paymentstatus='completed' and consultationrefund='torefund' and doctorfeesstatus = '' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' group by visitcode order by consultationdate desc";

              $query76 = "select * from master_billing where  patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and billnumber like '%$searchbillno%' and billingdatetime between '$fromdate' and '$todate' and refund_status=''  group by visitcode,billnumber order by billingdatetime desc";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res76 = mysqli_fetch_array($exec76))

			{

			$patientcode = $res76['patientcode'];

			$patientvisitcode=$res76['visitcode'];

			$consultationdate=$res76['billingdatetime'];

				$patientname=$res76['patientfullname'];

				//$accountname=$res76['accountfullname'];

				//$billtype = $res76['billtype'];
				//$departmentname = $res76['departmentname'];
				$consultationfees = $res76['patientbillamount'];
				//$res76username = $res76['username'];
				$billnumber = $res76['billnumber'];

				

			//$query8 = "select * from billing_paylater where patientcode = '$patientcode' and visitcode = '$patientvisitcode'";	

			//$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

			//$rows8 = mysql_num_rows($exec8);

			if(true)

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


			    <div align="center"><?php echo $billnumber; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientvisitcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>

              
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($consultationfees,2); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="center">

				<textarea id="remark<?= $sno?>" name="remark<?= $sno?>" cols="18" rows="2" class="remarks-textarea" placeholder="Enter refund remarks..."></textarea>

				</div></td>

             

             <td class="bodytext31" valign="center"  align="left"><a href="#" onClick="return putRequest('<?= $billnumber ?>','<?= $patientvisitcode ?>','<?= $sno ?>');" class="action-link process"><strong>Process</strong></a>			  </td>

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



<!-- Refund processing function moved to external JS -->

<?php include ("includes/footer1.php"); ?>

</body>

</html>



