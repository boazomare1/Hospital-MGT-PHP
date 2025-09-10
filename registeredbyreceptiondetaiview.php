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

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$res1suppliername = '';

$total1 = '0.00';



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");





if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

//echo $cbcustomername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];



?>

<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

   

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

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

     

      <tr>

        <td>&nbsp;</td>

      </tr>

     

	   <?php if($cbfrmflag2 == 'cbfrmflag1'){?>

        

          

          <?php

		  if($slocation=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$slocation'";
				}	
				

			$cbcustomername=trim($cbcustomername);

			if($cbcustomername == '')

			{	
			
			

			//echo 'Received';

			 $query1 = "select username from master_customer where registrationdate between '$ADate1' and '$ADate2' and $pass_location group by username order by username";

			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));

			 while($res1 = mysqli_fetch_array($exec1))

			 {

			 $cbcustomername = $res1['username'];

			   $query7 = "select username from master_customer where username like '$cbcustomername' and registrationdate between '$ADate1' and '$ADate2' and $pass_location"; 

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numcount=mysqli_num_rows($exec7);



		  ?>

		    <tr>

		  <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="725" 

            align="left" border="0">

          <tbody>

            <tr>

              <td colspan='6' bgcolor="#ecf0f5" class="bodytext31"><?php echo 'Total No of Registered by '.strtoupper($cbcustomername)?> ( <?php echo $numcount;?> )</td>

            </tr>

            <tr>

              <th width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></th>

				

              <th width="14%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></th>

				 

   				  <th width="9%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></th>

				<th width="9%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></th>

   				  <th width="12%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registered Date</strong></div></th>

   				  <th width="11%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registered By</strong></div></th>

            </tr>

			

			<?php

			

		      

		

		  		  $query4 = "select a.customerfullname as customerfullname,a.customercode as customercode,a.username as username,a.registrationdate as registrationdate,b.accountname as accountname from master_customer as a JOIN master_accountname AS b ON (a.accountname = b.auto_number) where a.username like '$cbcustomername' and a.registrationdate between '$ADate1' and '$ADate2' and a.$pass_location"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numcount=mysqli_num_rows($exec4); 

		  while($res4 = mysqli_fetch_array($exec4))

			{

				$customerfullname= $res4['customerfullname'];

				$patientcode= $res4['customercode'];

				$registeredby= $res4['username'];

				$registrationdate= $res4['registrationdate'];

				$accountname= $res4['accountname'];

				

/*		  $query6 = "select visitcode from master_consultationlist where patientcode = '$patientcode' and registrationdate between '$ADate1' and '$ADate2' auto_number desc"; 

		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

		  $numcount=mysql_num_rows($exec6);

		  $res6 = mysql_fetch_array($exec6);

		  $visitcode=$res6['visitcode'];



				//$consultingdoctor= $res4['user'];

				

/*master_consultationlist		  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.user as triageby,a.visitcode, c.username as pharmacyby from master_visitentry a, master_triage b,pharmacysales_details c where (a.visitcode = '$visitcode') and  (b.visitcode = '$visitcode') and  (c.visitcode = '$visitcode')"; 

	  

  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.username as consultby,c.visitcode, c.username as pharmacyby,

  d.patientvisitcode, d.username as sampleby,e.patientvisitcode, e.username as serviceby,d.patientvisitcode, d.username as radiologyby from master_visitentry as a  LEFT JOIN master_consultationlist as b ON a.visitcode=b.visitcode LEFT JOIN pharmacysales_details as c  ON a.visitcode=c.visitcode LEFT JOIN samplecollection_lab as d ON a.visitcode=d.patientvisitcode LEFT JOIN consultation_services as e ON a.visitcode=e.patientvisitcode LEFT JOIN consultation_radiology as f ON a.visitcode=f.patientvisitcode where a.visitcode = '$visitcode' "; 

  

  		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

			$res5 = mysql_fetch_array($exec5);	

				$visitdate= $res5['consultationdate'];

				$visitby= $res5['visitby'];

				$consultingdoctor= $res5['consultby'];

				$pharmacyby= $res5['pharmacyby'];

				$sampleby= $res5['sampleby'];

				$serviceby= $res5['serviceby'];

				$radiologyby= $res5['radiologyby'];

*/			

						

				

			

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

				<tr <?php echo $colorcode; ?>>

				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

				<td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31"><?php echo $customerfullname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31"><?php echo $patientcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">

				<div class="bodytext31"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>

				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">

				<div class="bodytext31"><?php echo $registeredby; ?></div></td>

				</tr>

			<?php

			}

			?>

			

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td colspan="10" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                

				

				 

			  

			</tr>

          </tbody>

        </table></td>

		</tr>

		 <tr>

        <td>&nbsp;</td>

      </tr>

			<?php }

			 }

			 else

			 { 

			    $query7 = "select username from master_customer where username like '$cbcustomername' and registrationdate between '$ADate1' and '$ADate2' and $pass_location"; 

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numcount=mysqli_num_rows($exec7);

		  

				$query02="select employeename from master_employee where username='$cbcustomername'";

				$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);

				$res02=mysqli_fetch_array($exec02);

				if($res02['employeename']!='')

				{

					 $cbcustomernames=$res02['employeename'];

				}



		  ?>

		  <tr><td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="725" 

            align="left" border="0">

          <tbody>

            <tr>

              <td colspan='6' bgcolor="#ecf0f5" class="bodytext31"><strong ><?php echo strtoupper($cbcustomernames);?>(<?php echo $numcount;?>) </strong></td>

            </tr>

            <tr>

              <td width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

				

              <td width="14%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>

				 

   				  <td width="9%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></td>

				<td width="9%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>

   				  <td width="12%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registered Date</strong></div></td>

   				  <td width="11%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registered By</strong></div></td>

            </tr>

			

			<?php

			

		      

		

			$query4 = "select a.customerfullname as customerfullname,a.customercode as customercode,a.username as username,a.registrationdate as registrationdate,b.accountname as accountname from master_customer as a JOIN master_accountname AS b ON (a.accountname = b.auto_number) where a.username like '$cbcustomername' and a.registrationdate between '$ADate1' and '$ADate2' and a.$pass_location";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numcount=mysqli_num_rows($exec4);

		  while($res4 = mysqli_fetch_array($exec4))

			{

				$customerfullname= $res4['customerfullname'];

				$patientcode= $res4['customercode'];

				$registeredby= $res4['username'];

				$registrationdate= $res4['registrationdate'];

				$accountname = $res4['accountname'];

				

/*		  $query6 = "select visitcode from master_consultationlist where patientcode = '$patientcode' and registrationdate between '$ADate1' and '$ADate2' auto_number desc"; 

		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

		  $numcount=mysql_num_rows($exec6);

		  $res6 = mysql_fetch_array($exec6);

		  $visitcode=$res6['visitcode'];



				//$consultingdoctor= $res4['user'];

				

/*master_consultationlist		  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.user as triageby,a.visitcode, c.username as pharmacyby from master_visitentry a, master_triage b,pharmacysales_details c where (a.visitcode = '$visitcode') and  (b.visitcode = '$visitcode') and  (c.visitcode = '$visitcode')"; 

	  

  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.username as consultby,c.visitcode, c.username as pharmacyby,

  d.patientvisitcode, d.username as sampleby,e.patientvisitcode, e.username as serviceby,d.patientvisitcode, d.username as radiologyby from master_visitentry as a  LEFT JOIN master_consultationlist as b ON a.visitcode=b.visitcode LEFT JOIN pharmacysales_details as c  ON a.visitcode=c.visitcode LEFT JOIN samplecollection_lab as d ON a.visitcode=d.patientvisitcode LEFT JOIN consultation_services as e ON a.visitcode=e.patientvisitcode LEFT JOIN consultation_radiology as f ON a.visitcode=f.patientvisitcode where a.visitcode = '$visitcode' "; 

  

  		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

			$res5 = mysql_fetch_array($exec5);	

				$visitdate= $res5['consultationdate'];

				$visitby= $res5['visitby'];

				$consultingdoctor= $res5['consultby'];

				$pharmacyby= $res5['pharmacyby'];

				$sampleby= $res5['sampleby'];

				$serviceby= $res5['serviceby'];

				$radiologyby= $res5['radiologyby'];

*/			

						

				



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

				<tr <?php echo $colorcode; ?>>

				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

				<td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31"><?php echo $customerfullname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31"><?php echo $patientcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">

				<div class="bodytext31"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>

				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">

				<div class="bodytext31"><?php echo $registeredby; ?></div></td>

				</tr>

			<?php

			}

			?>

			

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td colspan="10" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                

				

				 

			  

			</tr>

          </tbody>

        </table></td></tr>

			<?php }

		  		 }?>

      

	  

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

