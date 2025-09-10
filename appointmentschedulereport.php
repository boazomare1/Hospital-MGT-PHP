<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d');

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');



$errmsg = "";

$supplieranum = "";

$searchsuppliername = "";

$snocount = "";

$colorcode = "";

$colorloopcount = "";

$range = "";

$emailarray1 = '';

$emailarray = '';



//This include updatation takes too long to load for hunge items database.





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $ADate2;



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{

	$fromdate = $_REQUEST['ADate1'];

	$todate = $_REQUEST['ADate2'];

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query33 = "DELETE FROM appointmentschedule_entry WHERE auto_number = '$delanum' ";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	$errmsg = "Appointed Deleted Successfully";

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

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>



<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script src="js/datetimepicker_css.js"></script>





<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

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

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

</style>

</head>



<body>

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

  <tr>

    <td width="2%" valign="top">&nbsp; </td>

	

     

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      

      <tr>

        <td width="860">

              <form name="cbform1" id="cbform1" method="post" action="appointmentschedulereport.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

		    <tr bgcolor="#011E6A">

              <td colspan="5" bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>

           </tr>

		    <tr bgcolor="#011E6A">

              <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Appointment Schedule Report</strong></td>

              </tr>

            <!--<tr>

              <td width="15%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              </span></td>

           </tr>-->

		    <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php if(isset($fromdate)){ echo $fromdate; }else{ echo $paymentreceiveddatefrom; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php if(isset($todate)){ echo $todate; }else{ echo $paymentreceiveddateto; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

            </tr>

		    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      

       <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

		

<?php

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }



if ($cbfrmflag1 == 'cbfrmflag1')

{

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="943" 

            align="left" border="0">

          <tbody>

             

			  <tr>

				<td width="44"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">No  </td>

				<td width="268"  align="left" valign="center" 

				bgcolor="#ffffff" class="bodytext31"><strong>Patient</strong></td>	

				<td width="59"  align="left" valign="center"  bgcolor="#ffffff" class="style1">Reg No. </td>
				<td width="90"  align="left" valign="center"  bgcolor="#ffffff" class="style1">Phone </td>

				<td width="63"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Date </td>

				<td width="58"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Time </td>

				<td width="145"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Department</td>

				<td width="135"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Doctor</td>

			    <td width="48"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Remarks</td>

				<td width="48"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Action</td>

			    <td width="51"  align="center" valign="center" 

				bgcolor="#ffffff" class="style1">Cancel</td>

			  </tr>					

           <?php

		$query1 = "select * from appointmentschedule_entry where visitstatus = '' and appointmentdate between '$fromdate' and '$todate' and department in (SELECT departmentanum FROM `master_employeedepartment` where username like '$username') order by auto_number desc ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

				$res1auto_number =$res1['auto_number'];

				$res1patientname =$res1['patientname'];

				$res1patientcode =$res1['patientcode'];
				$phone =$res1['phone'];

				$res1appointmentdate =$res1['appointmentdate'];

				$res1appointmenttime =$res1['appointmenttime'];

				$res1session =$res1['session'];

				$res2doctorname=$res1['consultingdoctor'];

				$res1department=$res1['department'];

				$remarks = $res1['remarks'];
				   

									

					$query3 = "select * from master_department where auto_number = '$res1department' and recordstatus = '' ";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num3=mysqli_num_rows($exec3);

					$res3 = mysqli_fetch_array($exec3);

					$res3department=$res3['department'];

					  

					

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

				<td width="44" align="left" valign="center" 

				class="bodytext31"><?php echo $snocount = $snocount + 1; ?></td>

					<td width="268"  align="left" valign="center" class="bodytext31"><?php echo $res1patientname; ?></td>

			    <td  align="left" valign="center" class="bodytext31"><?php echo $res1patientcode; ?></td>
			    <td  align="left" valign="center" class="bodytext31"><?php echo $phone; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $res1appointmentdate; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo date('H:m',strtotime($res1appointmenttime)).'&nbsp;'.strtoupper($res1session); ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $res3department; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $res2doctorname; ?></td>

				<td  align="left" valign="center" class="bodytext31">
					<textarea readonly="readonly"><?php echo $remarks; ?>	</textarea>
			    </td>

                <?php if($res1patientcode==''){ ?>
                   <td  align="left" valign="center" class="bodytext31"><a target="_blank" href="register.php?&apnum=<?php echo $res1auto_number; ?>"><strong>Register</strong></a></td>
				<?php } else {?>
			    <td  align="left" valign="center" class="bodytext31"><a target="_blank" href="visitentry_op_new.php?patientcode=<?php echo $res1patientcode; ?>&&apnum=<?php echo $res1auto_number; ?>"><strong>OP Visit</strong></a></td>

				<?php } ?>

		 	    <td  align="center" valign="center" class="bodytext31"><a href="appointmentschedulereport.php?st=del&&anum=<?php echo $res1auto_number; ?>">

				  <img src="images/b_drop.png" width="16" height="16" border="0" /></a>

				</td>

		 	</tr>	

		 <?php } ?>	 
		 <tr>
		 	  <td colspan="11" align="right"><a href="appointmentschedulereport_xl.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
				 
		 </tr> 


          </tbody>

        </table>

<?php

}

?></td>


</tr>

</table>



<?php include ("includes/footer1.php"); ?>

</body>

</html>

