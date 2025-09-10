<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d');

$paymentreceiveddateto = date('Y-m-d');

$totalprivatedoctoramount=0;

$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '0.00';

$refexternal = 0;

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$rowtot1 = 0;

$rowtot2 = 0;

$rowtot3 = 0;

$holetotal1 = 0;



if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	



}





if (isset($_REQUEST["ADate1"])) { $fromdate=$ADate1 = $_REQUEST["ADate1"]; } else { $fromdate=$ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $todate=$ADate2 = $_REQUEST["ADate2"]; } else { $todate=$ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];





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

<script language="javascript">





function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here





function cbsuppliername1()

{

	document.cbform1.submit();

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>



</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1900" border="0" cellspacing="0" cellpadding="2">

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

    

       <td width="860">

		<form name="cbform1" method="post" action="iprevenuereport_t1.php">

          <!--TABLE FOR OP/IP REVENUE REPORT -->

           <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

             <tbody>

             <tr bgcolor="#011E6A">

                 <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Revenue Report </strong></td>

             <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php //echo $errmgs; ?>&nbsp;</td>-->

                 <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

                      <?php

						if ($location!='')

						{

						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

			     </td> 

             </tr>

             <tr>

                 <td class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"> <strong>Date From</strong> </td>

                 <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" /><img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>

                 <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>

                 <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                    <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span>

                 </td>

             </tr>

			 <tr>

  			   <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

               <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF">

               	<span class="bodytext3">

			    <select name="location" id="location">

                    <?php

						$query1="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$loccode=array();

						while ($res1 = mysqli_fetch_array($exec1))

						{

							$locationname = $res1["locationname"];

							$locationcode = $res1["locationcode"];

						?>

						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>

						<?php

						} 

						?>

                </select></span>

               </td>

			    <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ward</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <select name="ward" id="ward">

						<option value="" selected="selected"> All</option>

						  <?php 

		  $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 

           $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res = mysqli_fetch_array($exec);

			

	 		$locationname  = $res["locationnanum"]; 

	 		$locationcode2 = $res["locationcode"];

			

						  $query78 = "select * from master_ward where  locationcode='$locationcode2' and recordstatus=''";

						  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						  while($res78 = mysqli_fetch_array($exec78))

						  {

						  $wardanum = $res78['auto_number'];

						  $wardname = $res78['ward'];

						    ?>

                          <option value="<?php echo $wardanum; ?>"><?php echo $wardname; ?></option>

						  <?php

						  }

			

                          ?>

                      </select>

              </span></td>

			 </tr>

			 <tr>

               <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

               <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                 	<input  type="submit" value="Search" name="Submit" />

                    <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />

               </td>

             </tr>

            </tbody>

           </table>

           <!--ENDS OP/IP REVENUE REPORT-->

           </form>		

        </td>

  </tr>

       

  <tr>

      <td>&nbsp;</td>

  </tr>

 



   

        <!-- TABLE FOR OP REVENUE REPORT-->

       

      

		   <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

				if (isset($_REQUEST["ward"])) { $searchward = $_REQUEST["ward"]; } else { $searchward = ""; }

				// $searchward = $_POST['ward'];

				

				?>

            

            

			

        

         

       

    

  

      

  

   <tr>

      <td>

         <!--TABLE FOR IP REVENUE REPORT-->

        <table width="auto" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">

          <tbody>

            <tr>

             <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><strong>Ip Renenue  &nbsp; From &nbsp;<?php echo date('d-M-Y',strtotime($ADate1)); ?> To <?php echo date('d-M-Y',strtotime($ADate2)); ?> </strong></td>

              <!--<td width="10%" bgcolor="#ecf0f5" class="bodytext31">Ip Renenue</td>-->

              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

					$fromdate = $_REQUEST['ADate1'];

					$todate = $_REQUEST['ADate2'];

				}	

					?>

               </td>

            </tr>

            

		    <tr <?php //echo $colorcode; ?> margin='10'>

              <td width="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"></td>

              <td width="126"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adm Fee</strong> </div></td>

                  <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP&nbsp;Package</strong></div></td>

			      <td width="56"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bed</strong></div></td>

			      <td width="68"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Nursing</strong></div></td>

			      <td width="26"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>MO</strong></div></td>



				  <td width="26"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultant</strong></div></td>



  				    <td width="31"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

  				    <td width="24"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rad</strong></div></td>

  				    <td width="42"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharma</strong></div></td>

  				    <td width="49"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>

  				    <td width="63"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>

                     <td width="58"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>

			      <td width="43"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pvt Dr</strong></div></td>

				  <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Misc&nbsp;Billing</strong></div></td>

                    <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td>

                    <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rebate</strong></div></td>

                  <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Others</strong></div></td>

              <td width="55" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>

             </tr>

            <?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

		        if($location!='All')

				{
					$totalpackagecharge=0;
			 	$query1 = "select  auto_number,patientname,patientcode,visitcode,'billing' as type  from billing_ip where locationcode='$locationcode1' and  accountnameano = '47' and billdate between '$ADate1' and '$ADate2'
		UNION ALL 
	 SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where locationcode='$locationcode1' and  accountnameano = '47' and billdate between '$ADate1' and '$ADate2' group by visitcode  order by auto_number DESC ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$visitcode=$res1['visitcode'];
		
		
		
		$query800 = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor where  patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$ADate1' and '$ADate2'  ";
                $exec800 = mysqli_query($GLOBALS["___mysqli_ston"], $query800) or die("Error in Query800" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num800                     = mysqli_num_rows($exec800);
                while($res800 = mysqli_fetch_array($exec800))
				{
                		if($res800['visittype'] =="IP")
							{
								if($res800['coa'] !="")
								 $privatedoctoramount = $res800['transactionamount'];
								else
								 $privatedoctoramount = $res800['original_amt'];
							}
							else
							{
								$privatedoctoramount = $res800['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			                $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
            		}
		
		
		
		
		

				if($res1['type']=='billing') {

				    $query112 = "select sum(amountuhx) as amountuhx from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 

				  UNION ALL SELECT sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";

				}
				else{

                    $query112 = "select sum(amountuhx) as amountuhx from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN  ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges','Nursing Charges') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2'

				   UNION ALL SELECT  sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges','Nursing Charges') and patientvisitcode='$visitcode' ";

				}		 

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['amountuhx'];
		// echo '<br>#'.$packagecharge.'#<br>';

	 	$totalpackagecharge=$totalpackagecharge + $packagecharge; 
	

}
				
				$querysearch = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered'

				             UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered'";



				if($searchward=='')

				{

				 $querysearch = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47'";

				 //$querysearch = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47'";

				}

				else {



                   $querysearch = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')			   

				   ";

				  /* $querysearch = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1' )

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1' )			   

				   ";*/

				}

				//echo $querysearch;exit;

				

				$totadmn = 0;

				$totpkg = 0;

				$totbed = 0;

				$totnur = 0;

				$totrmo = 0;

				$totrmo1 = 0;

				$totlab = 0;

				$totrad = 0;

				$totpha = 0;

				$totser = 0;

				$totamb = 0;

				$tothom = 0;

				$totdr = 0;

				$totmisc = 0;

				$totdiscount = 0;

				$totothers = 0;	

				$totrebate = 0;	

		

				$j = 0;

				$crresultcash = array();

				$querycr1cash = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE   a.billdate BETWEEN '$ADate1' AND '$ADate2'   and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'    and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'    and patientvisitcode IN ($querysearch)

								UNION ALL SELECT (SUM(`servicesitemrateuhx`) - sum(sharingamount)) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1   and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearch)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description = 'Bed Charges' AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch) 

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description = 'Nursing Charges' AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE (description = 'RMO Charges' or description ='Daily Review charge') AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch)

								 UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch) 

								

								UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearch)

								/*UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano = '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber) and patientvisitcode IN ($querysearch)*/
								
								UNION ALL SELECT sum(-1*rate) as income from ip_discount where  patientvisitcode IN ($querysearch)  and consultationdate between '$ADate1' and '$ADate2'

								UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE accountnameano = '47' and billdate BETWEEN '$ADate1' AND '$ADate2' group by billno) and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano = '47' and billnumber = patientcode and billnumber like 'ipdr%'

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description = 'Bed Charges' and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description = 'Nursing Charges' and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description = 'RMO Charges' and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description = 'Lab' and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description = 'Radiology' and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description = 'Service' and patientvisitcode IN ($querysearch)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY NOW' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Lab','Radiology','Service') and patientvisitcode IN ($querysearch)

								

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description = 'Consultant Fee' AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode IN ($querysearch)

								UNION ALL SELECT sum(1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL'
								";

								

				$execcrcash1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1cash) or die ("Error in querycr1cash".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($rescrcash1 = mysqli_fetch_array($execcrcash1))

				{

				$j = $j+1;

				$crresultcash[$j] = $rescrcash1['income'];

				}

				$totalipcash = array_sum($crresultcash);

				$totalipcash = $totalipcash + $totalpackagecharge +$totalprivatedoctoramount-$crresultcash[24];

				$totadmn = $totadmn + $crresultcash[5];

				//$totpkg = $totpkg + $crresultcash[10];


				$totpkg = $totpkg + $totalpackagecharge;

				$totbed = $totbed + ($crresultcash[7]+$crresultcash[16]);

				$totnur = $totnur + ($crresultcash[8]+$crresultcash[17]);

				$totrmo = $totrmo + ($crresultcash[9]+$crresultcash[18]);



				$totrmo1 = $totrmo1 + $crresultcash[24];



				$totlab = $totlab + ($crresultcash[2]+$crresultcash[19]);

				$totrad = $totrad + ($crresultcash[3]+$crresultcash[20]);

				$totpha = $totpha + $crresultcash[1];

				$totser = $totser + ($crresultcash[4]+$crresultcash[21]);

				$totamb = $totamb + $crresultcash[6];

				$tothom = $tothom + $crresultcash[11];

				$totdr = $totdr + $totalprivatedoctoramount;

				$totmisc = $totmisc + ($crresultcash[12]);

				//$totdiscount = $totdiscount + ($crresultcash[13]+$crresultcash[14]);

				$totdiscount = $totdiscount + ($crresultcash[13]);

				$totothers = $totothers + ($crresultcash[15]+$crresultcash[22]);	

				$totrebate = $totrebate + $crresultcash[24];	

				//$totalipcash -= $crresultcash[25];

				?>

			 <tr bgcolor="#ecf0f5">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Cash</strong></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=admission"><?php echo number_format($crresultcash[5],2,'.',','); ?></a></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=package"><?php echo number_format($totalpackagecharge,2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=bed"><?php echo number_format($crresultcash[7]+$crresultcash[16],2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=nursing"><?php echo number_format($crresultcash[8]+$crresultcash[17],2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=mo"><?php echo number_format($crresultcash[9]+$crresultcash[18],2,'.',','); ?></a></div></td>



				<td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=consultant"><?php echo number_format($crresultcash[23],2,'.',','); ?></a></div></td>



                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=lab"><?php echo number_format($crresultcash[2]+$crresultcash[19],2,'.',','); ?></a></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=rad"><?php echo number_format($crresultcash[3]+$crresultcash[20],2,'.',','); ?></a></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=pharma"><?php echo number_format($crresultcash[1],2,'.',','); ?></a></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=services"><?php echo number_format($crresultcash[4]+$crresultcash[21],2,'.',','); ?></a></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=ambulance"><?php echo number_format($crresultcash[6],2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=homecare"><?php echo number_format($crresultcash[11],2,'.',','); ?></a></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=pvtdr"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></a></div></td>

				   <td  align="left" valign="center" class="bodytext31"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=misc"><?php echo number_format($crresultcash[12],2,'.',','); ?></a></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=cash&name=discount"> <?php echo number_format($crresultcash[13]+$crresultcash[14],2,'.',','); ?></a></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"> <?php echo number_format($crresultcash[24],2,'.',','); ?></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"> <?php echo number_format($crresultcash[15]+$crresultcash[22],2,'.',','); ?></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totalipcash,2,'.',','); ?></strong></div></td>

                  </tr>

     				<?php
$totalprivatedoctoramount=0;
					$j = 0;
					$totalpackagecharge = 0;
				 $query186 = "select  auto_number,patientname,patientcode,visitcode,'billing' as type from billing_ip where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'  and accountnameano != '47' 
	 UNION ALL SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1'  and accountnameano != '47'  group by visitcode  order by auto_number DESC ";

		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num186=mysqli_num_rows($exec186);
		while($res186 = mysqli_fetch_array($exec186))

		{ 
		$patientname=$res186['patientname'];

		$patientcode=$res186['patientcode'];

		 $visitcode=$res186['visitcode'];
		 
		 
		 
		 
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		$query8 = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$ADate1' and '$ADate2'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);
		while($res8 = mysqli_fetch_array($exec8)){

				if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount = $res8['transactionamount'];
								else
								 $privatedoctoramount = $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount = $res8['original_amt'];
							}
		// $privatedoctoramount=$res8['sum(transactionamount)'];

		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		}

		 
		 

		 if($res186['type']=='billing') {

		  $query112 = "select sum(amountuhx) AS amountuhx from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 

		  UNION ALL SELECT sum(fxamount)  as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";

		}else{

		   $query112 = "select sum(amountuhx) AS amountuhx from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN  ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges','Nursing Charges') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2'

		   UNION ALL SELECT  sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges','Nursing Charges') and patientvisitcode='$visitcode'

		   ";

		}
		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['amountuhx'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge;
}

				$querysearchnew2 =$querysearchnew1 =$querysearchnew = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered'

				             UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered'";



				if($searchward=='')

				{

				 //$querysearchnew = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and accountnameano <> '47' and '$ADate2' and  locationcode='$locationcode1'";

				  $querysearchnew = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1'  and '$ADate2' and accountnameano <> '47' and  locationcode='$locationcode1'";



				 $querysearchnew1 = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1' ";



				 ///$querysearchnew2 = "SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and accountnameano <> '47' and '$ADate2' and  locationcode='$locationcode1'";

				 $querysearchnew2 = "SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1'  and '$ADate2' and accountnameano <> '47' and  locationcode='$locationcode1'";



				}else {



                   $querysearchnew = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1')

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1')			   

				   ";



				   $querysearchnew1 = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1')

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  and  locationcode='$locationcode1')			   

				   ";



				   $querysearchnew2 = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1'  and '$ADate2' and accountnameano <> '47' and  locationcode='$locationcode1')

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1'  and '$ADate2' and accountnameano <> '47' and  locationcode='$locationcode1')			   

				   ";



				}





				
				//echo $querysearchnew.'<br>';
				//echo $querysearchnew2;exit;
				$crresultcredit = array();

				$querycr1credit = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE   a.billdate BETWEEN '$ADate1' AND '$ADate2'    and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'     and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'    and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT (SUM(`servicesitemrateuhx`) - SUM(sharingamount)) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1    and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'     and visitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description = 'Bed Charges' AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew)

								

								

								UNION ALL SELECT sum(amountuhx) as income  from billing_ipbedcharges where  description='Nursing Charges' and recorddate between '$ADate1' and '$ADate2' and visitcode IN ($querysearchnew)

								

								UNION ALL select sum(amount) as income from (

									select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description = 'RMO Charges' and A.misreport != '3' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')

									UNION ALL

									select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description = 'Daily Review charge' and A.misreport != '3' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')

									) as amount1

								UNION ALL select sum(billing_ipbedcharges.amountuhx) as income FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and A.misreport != '3' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')

								


								UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew)

								

								UNION ALL SELECT sum(-1*rate) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano != '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber) and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT sum(-1*rate) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE accountnameano != '47' and billdate BETWEEN '$ADate1' AND '$ADate2' group by billno) and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano <> '47' and billnumber = patientcode and billnumber like 'ipdr%'

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Bed Charges' and patientvisitcode IN ($querysearchnew)

								 UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Nursing Charges' and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'RMO Charges' and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Lab' and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Radiology' and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Service' and patientvisitcode IN ($querysearchnew)

								UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Lab','Radiology','Service') and patientvisitcode IN ($querysearchnew)

								/*UNION ALL SELECT SUM(`transactionamount`) as income FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode IN ($querysearchnew)*/

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description = 'Consultant Fee' AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew)



								 UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE description = 'Ward Dispensing Charges' AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew2)

								UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE (description = 'Resident Doctor Charges') AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode IN ($querysearchnew2)

								UNION ALL SELECT sum(1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL'

								

								";
								//echo $querycr1credit;exit;
				$execcrcredit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1credit) or die ("Error in querycr1credit".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($rescrcredit1 = mysqli_fetch_array($execcrcredit1))

				{

				$j = $j+1;

				$crresultcredit[$j] = $rescrcredit1['income'];

				}

				$totalipcredit = array_sum($crresultcredit);						  

				$totalipcredit = $totalipcredit + $totalpackagecharge +$totalprivatedoctoramount-$crresultcredit[26];

				$totadmn = $totadmn + $crresultcredit[5];

				//$totpkg = $totpkg + $crresultcredit[10];
				$totpkg = $totpkg + $totalpackagecharge;
				

				$totbed = $totbed + ($crresultcredit[7]+$crresultcredit[16]);

				//$totnur = $totnur + ($crresultcredit[8]+$crresultcredit[17]+ $crresultcredit[25] + $crresultcredit[28]);

				$totnur = $totnur + ($crresultcredit[8]+$crresultcredit[17]+ $crresultcredit[24]);

				$totrmo = $totrmo + ($crresultcredit[9]+$crresultcredit[18]+ $crresultcredit[25]);



				$totrmo1 = $totrmo1 + $crresultcredit[23];



				$totlab = $totlab + ($crresultcredit[2]+$crresultcredit[19]);

				$totrad = $totrad + ($crresultcredit[3]+$crresultcredit[20]);

				$totpha = $totpha + $crresultcredit[1];

				$totser = $totser + ($crresultcredit[4]+$crresultcredit[21]);

				$totamb = $totamb + $crresultcredit[6];

				$tothom = $tothom + $crresultcredit[11];

				$totdr = $totdr + $totalprivatedoctoramount;

				$totmisc = $totmisc + ($crresultcredit[12]);

				$totdiscount = $totdiscount + ($crresultcredit[13]+$crresultcredit[14]);

				$totothers = $totothers + ($crresultcredit[15]+$crresultcredit[22]);

				$totrebate = $totrebate + $crresultcredit[26];	

				//$totalipcredit -= $crresultcredit[27];

				?>

			  <tr bgcolor="#CBDBFA">

              <td class="bodytext31" valign="center"  align="right"><div align="center"><strong>Credit</strong></div></td>

               <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=admission"><?php echo number_format($crresultcredit[5],2,'.',','); ?></a></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=package"><?php echo number_format($totalpackagecharge,2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=bed"><?php echo number_format($crresultcredit[7]+$crresultcredit[16],2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=nursing"><?php echo number_format($crresultcredit[8]+$crresultcredit[17],2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=mo"><?php echo number_format($crresultcredit[9]+$crresultcredit[18]+ $crresultcredit[25],2,'.',','); ?></a></div></td>



				<td class="bodytext31" valign="center"  align="left"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=consultant"><?php echo number_format($crresultcredit[23],2,'.',','); ?></a></div></td>



                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=lab"><?php echo number_format($crresultcredit[2]+$crresultcredit[19],2,'.',','); ?></a></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=rad"><?php echo number_format($crresultcredit[3]+$crresultcredit[20],2,'.',','); ?></a></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=pharma"><?php echo number_format($crresultcredit[1],2,'.',','); ?></a></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=services"><?php echo number_format($crresultcredit[4]+$crresultcredit[21],2,'.',','); ?></a></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=ambulance"><?php echo number_format($crresultcredit[6],2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=homecare"><?php echo number_format($crresultcredit[11],2,'.',','); ?></a></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=pvtdr"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></a></div></td>

				   <td  align="left" valign="center" class="bodytext31"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=misc"><?php echo number_format($crresultcredit[12],2,'.',','); ?></a></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><a target="_blank" href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=credit&name=discount"> <?php echo number_format($crresultcredit[13]+$crresultcredit[14],2,'.',','); ?></a></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"> <?php echo number_format($crresultcredit[26],2,'.',','); ?></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"> <?php echo number_format($crresultcredit[15]+$crresultcredit[22],2,'.',','); ?></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totalipcredit,2,'.',','); ?></strong></div></td>

                  </tr>

         			<?php
         			$totbrfbeddisc = 0;
		$totbrfnursedisc = 0;
		$totbrfrmodisc = 0;
		 $totbrflabdisc = 0;
		 $totbrfraddisc = 0;
		 $totbrfpharmadisc = 0;
		 $totbrfservdisc = 0;
		 $totalbrfotherdisc = 0;
		 
		 	if($searchward=='')

				{

				 $querysearch = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1'";

				
				}

				else {



                   $querysearch = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2'   and  locationcode='$locationcode1')

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2'  and  locationcode='$locationcode1')			   

				   ";

				}
        /* $qrycreditbrf = "select patientcode, patientvisitcode,patientname from ip_creditnotebrief where locationcode = '$locationcode1' and consultationdate between '$ADate1' and '$ADate2' and patientvisitcode like '%IPV%' group by patientcode ";*/
        	if($searchward=='')

				{

				 $querysearch = "select visitcode from billing_ip where locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where locationcode='$locationcode1'";

				 

				}

				else {



                   $querysearch = "select visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1'  and visitcode in (select visitcode from billing_ip  where locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where locationcode='$locationcode1')

				   UNION  select visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and visitcode in (select visitcode from billing_ip where locationcode='$locationcode1'  UNION ALL SELECT visitcode from billing_ipcreditapproved where locationcode='$locationcode1')			   

				   ";

				

				}
        
        $qrycreditbrf = "select patientcode, patientvisitcode,patientname from ip_creditnotebrief where locationcode = '$locationcode1' and consultationdate between '$ADate1' and '$ADate2' and patientvisitcode IN($querysearch) group by patientcode ";
        

		$execcredibrf = mysqli_query($GLOBALS["___mysqli_ston"], $qrycreditbrf) or die ("Error in qrycreditbrf".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescreditbrf = mysqli_fetch_array($execcredibrf))

		{

   			$pcode = $rescreditbrf["patientcode"];

   			$vcode =$rescreditbrf["patientvisitcode"]; 

			$patienname = $rescreditbrf["patientname"];

		  

		  //TO GET DISCOUT FOR BED CHGS -- ip_creditnotebrief

		  $qrybrfbedchgsdisc = "select sum(rate) as brfbedchgsdisc from ip_creditnotebrief where description='Bed Charges'  AND patientcode = '$pcode' AND patientvisitcode = '$vcode'  and locationcode = '$locationcode1' and consultationdate between '$ADate1' and '$ADate2'";

		   $execbrfbedchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfbedchgsdisc) or die ("Error in qrybrfbedchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

		   $rescbrfbedchgsdisc= mysqli_fetch_array($execbrfbedchgsdisc);

		   $brfbedchgsdiscount = $rescbrfbedchgsdisc['brfbedchgsdisc'];

		   $totbrfbeddisc = $totbrfbeddisc + $brfbedchgsdiscount;

		   

		   	//TO GET DISCOUT FOR LAB CHGS -- ip_creditnotebrief

			$qrybrflabchgsdisc = "SELECT sum(rate) AS brflabchgsdisc FROM ip_creditnotebrief WHERE description='Lab'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrflabchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrflabchgsdisc) or die ("Error in qrybrflabchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrflabchgsdisc= mysqli_fetch_array($execbrflabchgsdisc);

			$brflabchgsdiscount = $rescbrflabchgsdisc['brflabchgsdisc'];

			$totbrflabdisc = $totbrflabdisc + $brflabchgsdiscount;

			

			//TO GET DISCOUT FOR NURSING CHGS -- ip_creditnotebrief

			$qrybrfnursechgsdisc = "SELECT sum(rate) AS brfnursechgsdisc FROM ip_creditnotebrief WHERE description='Nursing Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrfnursechgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfnursechgsdisc) or die ("Error in qrybrfnursechgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfnursechgsdisc= mysqli_fetch_array($execbrfnursechgsdisc);

			$brfnursechgsdiscount = $rescbrfnursechgsdisc['brfnursechgsdisc'];

			$totbrfnursedisc = $totbrfnursedisc + $brfnursechgsdiscount;

			

			//TO GET DISCOUT FOR PHARMACY CHGS  -- ip_creditnotebrief

			$qrybrfpharmachgsdisc = "SELECT sum(rate) AS brfpharmachgsdisc FROM ip_creditnotebrief WHERE description='Pharmacy'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrfpharmachgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfpharmachgsdisc) or die ("Error in qrybrfpharmachgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfpharmachgsdisc= mysqli_fetch_array($execbrfpharmachgsdisc);

			$brfpharmachgsdiscount = $rescbrfpharmachgsdisc['brfpharmachgsdisc'];

			$totbrfpharmadisc = $totbrfpharmadisc + $brfpharmachgsdiscount ;

			

			

			//TO GET DISCOUT FOR RADIOLOGY CHGS  -- ip_creditnotebrief

			$qrybrfradchgsdisc = "SELECT sum(rate) AS brfradchgsdisc FROM ip_creditnotebrief WHERE description='Radiology'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrfradchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfradchgsdisc) or die ("Error in qrybrfradchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfradchgsdisc= mysqli_fetch_array($execbrfradchgsdisc);

			$brfradchgsdiscount = $rescbrfradchgsdisc['brfradchgsdisc'];

				

			$totbrfraddisc = $totbrfraddisc + $brfradchgsdiscount;

			

			//TO GET DISCOUT FOR RMO CHGS -- ip_creditnotebrief

			$qrybrfrmochgsdisc = "SELECT sum(rate) AS brfrmochgsdisc FROM ip_creditnotebrief WHERE description='RMO Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrfrmochgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfrmochgsdisc) or die ("Error in qrybrfrmochgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfrmochgsdisc= mysqli_fetch_array($execbrfrmochgsdisc);

			$brfrmochgsdiscount = $rescbrfrmochgsdisc['brfrmochgsdisc'];

				

			$totbrfrmodisc = $totbrfrmodisc + $brfrmochgsdiscount;

			

			//TO GET DISCOUT FOR SERVICEE CHGS-- ip_creditnotebrief

			$qrybrfservchgsdisc = "SELECT sum(rate) AS brfservchgsdisc FROM ip_creditnotebrief WHERE description='Service'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrfservchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfservchgsdisc) or die ("Error in qrybrfservchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfservchgsdisc= mysqli_fetch_array($execbrfservchgsdisc);

			$brfservchgsdiscount = $rescbrfservchgsdisc['brfservchgsdisc'];

				

			$totbrfservdisc = $totbrfservdisc + $brfservchgsdiscount;

			

			

			//VENU - 04-06-2016

			//GET OTHERS CREDIT NOTE -- brfotherdisc

			$qrybrfotherdisc = "SELECT sum(rate) AS brfotherdisc FROM ip_creditnotebrief WHERE description='Others'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";

			$execbrfotherdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfotherdisc) or die ("Error in qrybrfotherdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfotherdisc= mysqli_fetch_array($execbrfotherdisc);

			$brfotherdisc = $rescbrfotherdisc['brfotherdisc'];

			

			$totalbrfotherdisc = $totalbrfotherdisc + $brfotherdisc;

			//ends

			

		
			}

		 ?>

         <!--DISPLAY CREDITNOTE DETAILS-->

         

         <!--DISPLAY ENDS-->

				<?php

				

				

				//$totadmn += $totaladmissionamount;

				//$totpkg += $totalpackagecharge;


					

		//////////////////////////////////////////////////////////////////////////////////////

					$j = 0;

					$crresultcreditnote = array();
/*
					$querycr1creditnote = "SELECT SUM(-1*`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and billnumber = patientcode and billnumber like 'ipcr%'

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description = 'Bed Charges' and patientvisitcode IN ($querysearch)

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description = 'Nursing Charges' and patientvisitcode IN ($querysearch)

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description = 'RMO Charges' and patientvisitcode IN ($querysearch)

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description = 'Lab' and patientvisitcode IN ($querysearch)

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description = 'Radiology' and patientvisitcode IN ($querysearch)

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description = 'Service' and patientvisitcode IN ($querysearch)

											UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Lab','Radiology','Service') and patientvisitcode IN ($querysearch)";

					$execcrcreditnote1 = mysql_query($querycr1creditnote) or die ("Error in querycr1creditnote".mysql_error());

					while($rescrcreditnote1 = mysql_fetch_array($execcrcreditnote1))

					{

					$j = $j+1;

					$crresultcreditnote[$j] = $rescrcreditnote1['income'];

					}*/

					//$totalipcreditnote = array_sum($crresultcreditnote);						  

					$totalipcreditnote = $totbrfbeddisc + $totbrfnursedisc + $totbrfrmodisc + $totbrflabdisc + $totbrfraddisc + $totbrfservdisc + $totalbrfotherdisc;

					$sumtransaction = $totalipcredit+$totalipcash-$totalipcreditnote;

					

					//$totbed = $totbed + ($crresultcreditnote[2]);
					$totbed = $totbed - $totbrfbeddisc;

					

					//$totnur = $totnur + ($crresultcreditnote[3]);
					$totnur = $totnur - $totbrfnursedisc;
					

					//$totrmo = $totrmo + ($crresultcreditnote[4]);
					$totrmo = $totrmo - $totbrfrmodisc;
					

					//$totlab = $totlab + ($crresultcreditnote[5]);

					$totlab = $totlab - $totbrflabdisc;
					

					//$totrad = $totrad + ($crresultcreditnote[6]);

					$totrad = $totrad - $totbrfraddisc;
					

					//$totser = $totser + ($crresultcreditnote[7]);
					$totser = $totser - $totbrfservdisc;
					

					//$totothers = $totothers + ($crresultcreditnote[1]+$crresultcreditnote[8]);
					$totothers = $totothers - $totalbrfotherdisc;
					


					

					?>

				<tr bgcolor="#ecf0f5">

              	<td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Credit Note</strong></div></td>

			 		<td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=bed"><?php echo "-".number_format($totbrfbeddisc,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=nursing"><?php echo "-".number_format($totbrfnursedisc,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=mo"><?php echo "-".number_format($totbrfrmodisc,2,'.',','); ?></a></div></td>

					<td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=consultant"><?php echo number_format(0,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=lab"><?php echo "-".number_format($totbrflabdisc,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=rad"><?php echo "-".number_format($totbrfraddisc,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=pharma"><?php echo number_format(0,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=services"><?php echo "-".number_format($totbrfservdisc,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target='_blank' href="iprevenuereport_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&type=note&name=others"><?php echo "-".number_format($totalbrfotherdisc,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><strong><?php echo "-".number_format($totalipcreditnote,2,'.',','); ?></strong></div></td>

              	</tr>

				<?php

				}

				}

				

			?>

			

			<tr bgcolor="#CCC">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Total</strong></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totadmn,2,'.',','); ?></strong></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totpkg,2,'.',','); ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totbed,2,'.',','); ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totnur,2,'.',','); ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totrmo,2,'.',','); ?></strong></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totrmo1,2,'.',','); ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totlab,2,'.',','); ?></strong></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totrad,2,'.',','); ?></strong></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totpha,2,'.',','); ?></strong></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totser,2,'.',','); ?></strong></div></td>

              

				  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totamb,2,'.',','); ?></strong></div></td>

                    <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($tothom,2,'.',','); ?></strong></div></td>

				   <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totdr,2,'.',','); ?></strong></div></td>

               

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totmisc,2,'.',','); ?></strong></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totdiscount,2,'.',','); ?></strong></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totrebate,2,'.',','); ?></strong></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totothers,2,'.',','); ?></strong></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($sumtransaction,2,'.',','); ?></strong></div></td>

                  

                  </tr>

				  <tr><td>&nbsp;</td>

				  </tr>

				

				<?php 

				

				

				// unfinalized start

				

				 ?>

          </tbody>

        </table>

      </td>

   </tr> 

   

   

   

   

   

  

   

    <tr>

               	<td colspan="7" style="border-color: light-grey;"><br></td>

               </tr>

		<tr>







   

       <td width="860">	   

			   

         <!--TABLE FOR IP REVENUE REPORT-->

        <table width="auto" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">

          <tbody>

            <tr>

             <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><strong>Ip unfinalized Renenue  &nbsp; From &nbsp;<?php echo date('d-M-Y',strtotime($ADate1)); ?> To <?php echo date('d-M-Y',strtotime($ADate2)); ?> </strong></td>

              <!--<td width="10%" bgcolor="#ecf0f5" class="bodytext31">Ip Renenue</td>-->

              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

					$fromdate = $_REQUEST['ADate1'];

					$todate = $_REQUEST['ADate2'];

				}	

					?>

               </td>

            </tr>

            

<tr <?php //echo $colorcode; ?> margin='10'>

              <td width="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"></td>

              <td width="126"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adm Fee</strong> </div></td>

                  <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP&nbsp;Package</strong></div></td>

			      <td width="56"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bed</strong></div></td>

			      <td width="68"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Nursing</strong></div></td>

			      <td width="26"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>RMO</strong></div></td>

  				    <td width="31"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

  				    <td width="24"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rad</strong></div></td>

  				    <td width="42"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharma</strong></div></td>

  				    <td width="49"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>

  				    <td width="63"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>

                     <td width="58"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>

			      <td width="43"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pvt Dr</strong></div></td>

				  <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Misc&nbsp;Billing</strong></div></td>

                  <td width="78"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Others</strong></div></td>

              <td width="55" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>

             </tr>            <?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

		        if($location!='All')

				{

				$updatetime = date('H:i:s');

				$updatedate = date('Y-m-d');

				$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$packageanum1="";

$ipunfinalizeamount='';

$ipfinalizedamount='';

$totalbedcharges='0.00';

$labtotal = "0.00";

$totalradiologyitemrate = "0.00";

$totalservicesitemrate = "0.00";

$totalprivatedoctoramount = "0.00";

$totalpharmacysaleamount = "0.00";

$totalpharmacysalereturnamount = "0.00";

$totalambulanceamount = "0.00";

$totalipmis = "0.00";

$totaldiscountrate = "0.00";

$totalnhifamount = "0.00";

$totalipdepositamount = "0.00";

$totalbedcharges = "0.00";

$totalbedtransfercharges = "0.00";

$totalpackage = "0.00";

$totaladmncharges = "0.00";

$depbalance = "0.00";

				

		$admissionamount=0.00;

		$ipdiscountamount = 0.00;

		$totaladmissionamount = 0.00;

		$totallabamount = 0.00;

		$totalpharmacyamount = 0.00;

		$totalradiologyamount = 0.00;

		$totalservicesamount = 0.00;

		//$totalotamount = 0.00;

		$totalambulanceamount = 0.00;

		$totalprivatedoctoramount = 0.00;

		$totalipbedcharges = 0.00;

		$totalipnursingcharges = 0.00;

		$totaliprmocharges = 0.00;

		$totalipdiscountamount = 0.00;

		$totalipmiscamount = 0.00;

		$totaltransactionamount = 0.00;

		$colorcode = '';

		$transactionamount = 0.00;

		$totalhospitalrevenue = '0.00';

		$totalpackagecharge=0.00;

		$totalhomecareamount=0.00;

		$totalotamount=0.00;

		$totaliprefundamount=0.00;

		$totalnhifamount =0.00;

		

		//VARIABLES FOR -- CREDITNOTE--

		

		

		$bedchgsdiscount=0;

		$labchgsdiscount=0;

		$nursechgsdiscount=0;

		$pharmachgsdiscount=0;

		$radchgsdiscount = 0;

		$rmochgsdiscount = 0;

		$servchgsdiscount = 0;

		

		$totbedchgdisc=0;

		$totlabchgdisc=0;

		$totnursechgdisc=0;

		$totpharmachgdisc=0;

		$totradchgdisc=0;

		$totrmochgdisc=0;

		$totservchgdisc=0;

		

		$brfbedchgsdiscount = 0;

		$brflabchgsdiscount = 0;

		$brfnursechgsdiscount = 0;

		$brfpharmachgsdiscount=0;

		$brfradchgsdiscount=0;

		$brfrmochgsdiscount = 0;

		$brfservchgsdiscount  = 0;

		

		$totbrfbeddisc=0;

		$totbrflabdisc=0;

		$totbrfnursedisc=0;

		$totbrfpharmadisc=0;

		$totbrfraddisc=0;

		$totbrfrmodisc=0;

		$totbrfservdisc=0;

		

		$totcreditnotebedchgs = 0;

		$totcreditnotelabchgs = 0; 

		$totcreditnotenursechgs = 0;

		$totcreditnotepharmachgs = 0; 

		$totcreditnoteradchgs = 0;

		$totcreditnotermochgs = 0;

		$totcreditnoteservchgs = 0;

		 $totalnurcingcharges=0;

		$totadmn = 0;

		$totpkg = 0;

		$totbed = 0;

		$totnur = 0;

		$totrmo = 0;

		$totlab = 0;

		$totrad = 0;

		$totpha = 0;

		$totser = 0;

		$totamb = 0;

		$tothom = 0;

		$totdr = 0;

		$totmisc = 0;

		$totothers = 0;		

	

		 $query41 = "select patientcode,visitcode from ip_bedallocation where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered'

				             UNION  select patientcode,visitcode from ip_bedtransfer where ward = '$searchward'  and locationcode='$locationcode1' and recordstatus !='transfered'";



		if($searchward=='')

		{

		 $query41 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip)  and locationcode='$locationcode1'  and consultationdate between '$ADate1' and '$ADate2'";

		}

		

		$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res41 = mysqli_fetch_array($exec41))

		{

		

		$patientcode = $res41['patientcode'];

		

		

		 $visitcode = $res41['visitcode'];

		 

		$totalquantity = 0;

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

		//$ADate1='2015-01-31';

		//$ADate2='2015-02-28';

		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip UNION ALL select visitcode from billing_ipcreditapproved) and visitcode='$visitcode' and patientcode='$patientcode'  and consultationdate between '$ADate1' and '$ADate2'";

		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res66 = mysqli_fetch_array($exec66))

		{

			$patientcode = $res66['patientcode'];

			$visitcode = $res66['visitcode'];

			

			$querymenu = "select * from master_customer where customercode='$patientcode'";

			$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$nummenu=mysqli_num_rows($execmenu);

			$resmenu = mysqli_fetch_array($execmenu);

			$menusub=$resmenu['subtype'];

			

			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$menusub'");

			$execsubtype=mysqli_fetch_array($querysubtype);

			$patientsubtype1=$execsubtype['subtype'];

			$bedtemplate=$execsubtype['bedtemplate'];

			$labtemplate=$execsubtype['labtemplate'];

			$radtemplate=$execsubtype['radtemplate'];

			$sertemplate=$execsubtype['sertemplate'];

			$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";

			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtt32 = mysqli_num_rows($exectt32);

			$exectt=mysqli_fetch_array($exectt32);

			$bedtable=$exectt['referencetable'];

			if($bedtable=='')

			{

				$bedtable='master_bed';

			}

			$bedchargetable=$exectt['templatename'];

			if($bedchargetable=='')

			{

				$bedchargetable='master_bedcharge';

			}

			$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";

			$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtl32 = mysqli_num_rows($exectl32);

			$exectl=mysqli_fetch_array($exectl32);		

			$labtable=$exectl['templatename'];

			if($labtable=='')

			{

				$labtable='master_lab';

			}

			

			$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";

			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtt32 = mysqli_num_rows($exectt32);

			$exectt=mysqli_fetch_array($exectt32);		

			$radtable=$exectt['templatename'];

			if($radtable=='')

			{

				$radtable='master_radiology';

			}

			

			$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";

			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtt32 = mysqli_num_rows($exectt32);

			$exectt=mysqli_fetch_array($exectt32);

			$sertable=$exectt['templatename'];

			if($sertable=='')

			{

				$sertable='master_services';

			}

			$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";

			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$mastervalue = mysqli_fetch_array($exec32);

			$currency=$mastervalue['currency'];

			$fxrate=$mastervalue['fxrate'];

			$subtype=$mastervalue['subtype'];

		

		$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			$packageanum1 = $res17['package'];

			

			$totaladmncharges = $totaladmncharges + $consultationfee;

			

			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res53 = mysqli_fetch_array($exec53);

			$refno = $res53['docno'];

			

					  $packageamount = 0;

					  $packageamountuhx=0;

			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$packageanum1 = $res731['package'];

			$packagedate1 = $res731['consultationdate'];

			$packageamount = $res731['packagecharge'];

			

			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";

			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res741 = mysqli_fetch_array($exec741);

			$packdays1 = $res741['days'];

			$packagename = $res741['packagename'];

			

			$packageamountuhx=$packageamount*$fxrate;

			$totalpackage = $totalpackage + $packageamountuhx;

			 

			$totalbedallocationamount = 0;

			$totalbedallocationamountuhx=0;

			 $requireddate = '';

			 $quantity = '';

			 $allocatenewquantity = '';

			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res18 = mysqli_fetch_array($exec18);

			$ward = $res18['ward'];

			$allocateward = $res18['ward'];

			

			$bed = $res18['bed'];

			$refno = $res18['docno'];

			$date = $res18['recorddate'];

			$bedallocateddate = $res18['recorddate'];

			$packagedate = $res18['recorddate'];

			$newdate = $res18['recorddate'];

			

			

			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res73 = mysqli_fetch_array($exec73);

			$packageanum = $res73['package'];

			$type = $res73['type'];

			

			

			$query74 = "select * from master_ippackage where auto_number='$packageanum'";

			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res74 = mysqli_fetch_array($exec74);

			$packdays = $res74['days'];

			

		   $query51 = "select * from `$bedtable` where auto_number='$bed'";

		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res51 = mysqli_fetch_array($exec51);

		   $bedname = $res51['bed'];

		   $threshold = $res51['threshold'];

		   $thresholdvalue = $threshold/100;

		   

		   //bed

		     $totalbedallocationamount=0;

			   $totalbedallocationamountuhx=0;

		   //nurcing

		   

		   $totalbedallocationamountn=0;

			   $totalbedallocationamountnuhx=0;

			  	   

				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res18 = mysqli_fetch_array($exec18))

				{

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

					if($leavingdate=='0000-00-00')

					{

						$leavingdate=$updatedate;

					}

					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res51 = mysqli_fetch_array($exec51);

					$bedname = $res51['bed'];

					$threshold = $res51['threshold'];

					$thresholdvalue = $threshold/100;

					$time1 = new DateTime($bedallocateddate);

					$time2 = new DateTime($leavingdate);

					$interval = $time1->diff($time2);			  

					$quantity1 = $interval->format("%a");

					if($packdays1>$quantity1)

					{

						$quantity1=$quantity1-$packdays1; 

						$packdays1=$packdays1-$quantity1;

					}

					else

					{

						$quantity1=$quantity1-$packdays1;

						$packdays1=0;

					}

					$quantity='0';

					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));

					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$num91 = mysqli_num_rows($exec91);

					while($res91 = mysqli_fetch_array($exec91))

					{

						$charge = $res91['charge'];

						$rate = $res91['rate'];	

						

						if($charge!='Bed Charges')

						{

							//$quantity=$quantity1+1;

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						else

						{

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						$amount = $quantity * $rate;						

						$allocatequantiy = $quantity;

						$allocatenewquantity = $quantity;

						if($quantity>0)

						{

							if($type=='hospital'||$charge!='Resident Doctor Charges')

							{

								$colorloopcount = $sno + 1;

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

								

								if($charge!='Nursing Charges')

								{

								$totalbedallocationamount=$totalbedallocationamount+($amount);

								$amountuhx = $rate*$quantity;

								$totalbedallocationamountuhx = $totalbedallocationamountuhx + ($amountuhx*$fxrate);

								$totalbedcharges = $totalbedcharges + ($amountuhx*$fxrate);

								}

								else

								{

								$totalbedallocationamountn=$totalbedallocationamountn+($amount);

								$amountnuhx = $rate*$quantity;

								$totalbedallocationamountnuhx = $totalbedallocationamountnuhx + ($amountuhx*$fxrate);

								$totalnurcingcharges = $totalnurcingcharges + ($amountnuhx*$fxrate);

								

								}

							}

						}

					}

				}

				

				//bed 

				$totalbedtransferamount=0;

				$totalbedtransferamountuhx=0;

				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res18 = mysqli_fetch_array($exec18))

				{

					$quantity1=0;

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					//$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];



					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

					if($leavingdate=='0000-00-00')

					{

						$leavingdate=$updatedate;

					}

					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res51 = mysqli_fetch_array($exec51);

					$bedname = $res51['bed'];

					$threshold = $res51['threshold'];

					$thresholdvalue = $threshold/100;

					$time1 = new DateTime($date);

					$time2 = new DateTime($leavingdate);

					$interval = $time1->diff($time2);			  

					$quantity1 = $interval->format("%a");

					if($packdays1>$quantity1)

					{

						$quantity1=$quantity1-$packdays1; 

						$packdays1=$packdays1-$quantity1;

					}

					else

					{

						$quantity1=$quantity1-$packdays1;

						$packdays1=0;

					}

					$bedcharge='0';

					$quantity='0';

					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));

					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$num91 = mysqli_num_rows($exec91);

					while($res91 = mysqli_fetch_array($exec91))

					{

						$charge = $res91['charge'];

						$rate = $res91['rate'];	

						

						if($charge!='Bed Charges')

						{

							//$quantity=$quantity1+1;

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						else

						{

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						//echo $quantity;

						$amount = $quantity * $rate;						

						$allocatequantiy = $quantity;

						$allocatenewquantity = $quantity;

						//echo $bedcharge;

						if($bedcharge=='0')

						{

							//$quantity;

							if($quantity>0)

							{

								if($type=='hospital'||$charge!='Resident Doctor Charges')

								{

									$colorloopcount = $sno + 1;

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

									

									if($charge!='Nursing Charges')

									{

									$totalbedtransferamount=$totalbedtransferamount+($amount);

									$amountuhx = $rate*$quantity;

									$totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx*$fxrate);

									$totalbedtransfercharges = $totalbedtransfercharges + ($amountuhx*$fxrate);

									}

									else

									{

									$totalbedallocationamountn=$totalbedallocationamountn+($amount);

									$amountnuhx = $rate*$quantity;

									$totalbedallocationamountnuhx = $totalbedallocationamountnuhx + ($amountuhx*$fxrate);

									$totalnurcingcharges = $totalnurcingcharges + ($amountnuhx*$fxrate);

									}

								}

							}

							else

							{

								if($charge=='Bed Charges')

								{

									//$bedcharge='1';

								}

							}

						}

					}

				}

			 

			 

			$totalpharm=0;

			$totalpharmuhx=0;

			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res23 = mysqli_fetch_array($exec23))

			{

			$phaquantity=0;

			$quantity1=0;

			$phaamount=0;

			$phaquantity1=0;

			$totalrefquantity=0;

			$phaamount1=0;

			$phadate=$res23['entrydate'];

			$phaname=$res23['itemname'];

			 $phaitemcode=$res23['itemcode'];

			$pharate=$res23['rate'];

			$quantity=$res23['quantity'];

			$refno = $res23['ipdocno'];

			$pharmfree = $res23['freestatus'];

			$amount=$pharate*$quantity;

			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res33 = mysqli_fetch_array($exec33))

			{

			$quantity=$res33['quantity'];

			$phaquantity=$phaquantity+$quantity;

			$amount=$res33['totalamount'];

			$phaamount=$phaamount+$amount;

			}

   			$quantity=$phaquantity;

			$amount=$pharate*$quantity;

			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";

			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		    $res331 = mysqli_fetch_array($exec331);

			

			$quantity1=$res331['quantity'];

			//$phaquantity1=$phaquantity1+$quantity1;

			$amount1=$res331['totalamount'];

			//$phaamount1=$phaamount1+$amount1;

			

			

			$resquantity = $quantity;

			$resamount = $amount;

						

			$resamount=number_format($resamount,2,'.','');

			//if($resquantity != 0)

			{

			if($pharmfree =='No')

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

			

			$resamount=$resquantity*($pharate/$fxrate);

			$totalpharm=$totalpharm+$resamount;

			

			 $resamountuhx = $pharate*$resquantity;

			 $resamountreturnuhx = $pharate*$quantity1;

		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;

			$totalpharmacysaleamount = $totalpharmacysaleamount + $resamountuhx;

			$totalpharmacysalereturnamount = $totalpharmacysalereturnamount + $resamountreturnuhx;

			

			}

			  }

			  }

			

			  $totallab=0;

			    $totallabuhx=0;

			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res19 = mysqli_fetch_array($exec19))

			{

			$labdate=$res19['consultationdate'];

			$labname=$res19['labitemname'];

			$labcode=$res19['labitemcode'];

			$labrate=$res19['labitemrate'];

			$labrefno=$res19['iptestdocno'];

			$labfree = $res19['freestatus'];

			

			if($labfree == 'No')

			{

			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];

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

			$totallab=$totallab+$labrate;

			

			 $labrateuhx = $labrate*$fxrate;

		   $totallabuhx = $totallabuhx + $labrateuhx;

		   $labtotal = $labtotal + $labrateuhx;

			}

			  }

			  ?>

			  

			    <?php 

				$totalrad=0;

				$totalraduhx=0;

			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res20 = mysqli_fetch_array($exec20))

			{

			$raddate=$res20['consultationdate'];

			$radname=$res20['radiologyitemname'];

			$radrate=$res20['radiologyitemrate'];

			$radref=$res20['iptestdocno'];

			$radiologyfree = $res20['freestatus'];

			$radiologyitemcode = $res20['radiologyitemcode'];

			if($radiologyfree == 'No')

			{

			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";

			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resr51 = mysqli_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];

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

			$totalrad=$totalrad+$radrate;

			

			 $radrateuhx = $radrate*$fxrate;

		   $totalraduhx = $totalraduhx + $radrateuhx;

		   $totalradiologyitemrate = $totalradiologyitemrate + $radrateuhx;

			}

			  }

			  					

					$totalser=0;

					$totalseruhx=0;

		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname,iptestdocno";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res21 = mysqli_fetch_array($exec21))

			{

			$serdate=$res21['consultationdate'];

			$sername=$res21['servicesitemname'];

			$serrate=$res21['servicesitemrate'];

			$serref=$res21['iptestdocno'];

			$servicesfree = $res21['freestatus'];

			$servicesdoctorname = $res21['doctorname'];

			$sercode=$res21['servicesitemcode'];

			$serviceledgercode=$res21['incomeledgercode'];

			$serviceledgername=$res21['incomeledgername'];

			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";

			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$ress51 = mysqli_fetch_array($execs51);

			$serrate = $ress51['rateperunit'];

			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";

			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrow2111 = mysqli_num_rows($exec2111);

			$res211 = mysqli_fetch_array($exec2111);

			$serqty=$res21['serviceqty'];

			if($serqty==0){$serqty=$numrow2111;}

			

			if($servicesfree == 'No')

			{	

			$totserrate=$res21['amount'];

			 if($totserrate==0){

			$totserrate=$serrate*$numrow2111;

			  }

			/*$totserrate=$serrate*$numrow2111;*/

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

				$totserrate=($serqty*$serrate);

			$totalser=$totalser+$totserrate;

			

			 $totserrateuhx = ($serrate*$fxrate)*$serqty;

		   $totalseruhx = $totalseruhx + $totserrateuhx;

		   $totalservicesitemrate = $totalservicesitemrate + $totserrateuhx;

			 }

			  }

		

			$totalambulanceamount = 0;

			$totalambulanceamountuhx=0;

			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res63 = mysqli_fetch_array($exec63))

		   {

			$ambulancedate = $res63['consultationdate'];

			$ambulancerefno = $res63['docno'];

			$ambulance = $res63['description'];

			$ambulancerate = $res63['rate'];

			$ambulanceamount = $res63['amount'];

			$ambulanceunit = $res63['units'];

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

			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);

			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;

			 $totalambulanceamount = $totalambulanceamount + $ambulanceamountuhx;

		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;

			

				}

				?>

				<?php

			$totalmiscbillingamount = 0;

			$totalmiscbillingamountuhx=0;

			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res69 = mysqli_fetch_array($exec69))

		   {

			$miscbillingdate = $res69['consultationdate'];

			$miscbillingrefno = $res69['docno'];

			$miscbilling = $res69['description'];

			$miscbillingrate = $res69['rate'];

			$miscbillingamount = $res69['amount'];

			$miscbillingunit = $res69['units'];

			

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

			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);

			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;

			

			 $miscbillingamountuhx = $miscbillingrate*$miscbillingunit;

			 $totalipmis = $totalipmis + $miscbillingamountuhx;

		   $totalmiscbillingamountuhx = $totalmiscbillingamountuhx + $miscbillingamountuhx;

			

				}

				?>

				<?php

			$totaldiscountamount = 0;

			$totaldiscountamountuhx=0;

			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res64 = mysqli_fetch_array($exec64))

		   {

			$discountdate = $res64['consultationdate'];

			$discountrefno = $res64['docno'];

			$discount= $res64['description'];

			$discountrate = $res64['rate'];

			$discountrate1 = $discountrate;

			$discountrate = $discountrate;

			$authorizedby = $res64['authorizedby'];

			

						

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

			$discountrate = 1*($discountrate1/$fxrate);

			$totaldiscountamount = $totaldiscountamount + $discountrate;

			

			 $discountrateuhx = $discountrate1;

			 $totaldiscountrate = $totaldiscountrate + $discountrateuhx;

		   $totaldiscountamountuhx = $totaldiscountamountuhx + $discountrateuhx;

			

				}	

				

				

				

				//deposit

					

				$colorloopcount = '';

				$orderid1 = '';

				$lid = '';

				$openingbalance = "0.00";

				$sumopeningbalance = "0.00";

				$totalamount2 = '0.00';

				$totalamount12 = '0.00';

				$depbalance = '0.00';

				$sumbalance = '0.00';

				$parentid=21;

				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";

				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res267 = mysqli_fetch_array($exec267))

				{  

					$accountsmain2 = $res267['accountname'];

					$orderid1 = $orderid1 + 1;

					$parentid2 = $res267['auto_number'];

					$ledgeranum = $parentid2;

					//$id2 = $res2['id'];

					$id = $res267['id'];

					//$id2 = trim($id2);

					$lid = $lid + 1;

					$opening = 0;

					if($id != '')

					{		

						/* */			 

						$i = 0;

						$drresult = array();

						$querydr1dp = "SELECT SUM(`amount`) as depositref FROM `deposit_refund` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'

									   UNION ALL SELECT SUM(ABS(`deposit`)) as depositref FROM `billing_ip` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'

									   UNION ALL SELECT SUM(`debitamount`) as depositref FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";

						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1dp) or die ("Error in querydr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($resdr1 = mysqli_fetch_array($execdr1))

						{

						$i = $i+1;

						$drresult[$i] = $resdr1['depositref'];

						}

						

						$j = 0;

						$crresult = array();

						$querycr1dp = "SELECT SUM(`transactionamount`) as deposit FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2'

									   UNION ALL SELECT SUM(`transactionamount`) as deposit FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'

									   UNION ALL SELECT SUM(`creditamount`) as deposit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";

						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1dp) or die ("Error in querycr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($rescr1 = mysqli_fetch_array($execcr1))

						{

						$j = $j+1;

						$crresult[$j] = $rescr1['deposit'];

						}

						

						$depbalance = array_sum($crresult) - array_sum($drresult);

					}

					else

					{

						$depbalance = 0;

					}	

					

				//	$sumbalance = $sumbalance + $depbalance;

					

			//		$colorloopcount = $colorloopcount + 1;

				//	$showcolor = ($colorloopcount & 1); 

					

					

					}

					//deposit		  

		

		} //ipvisit

		

		}   //ward

			 $totadmn = $totadmn + $totaladmissionamount;

			$totpkg = $totpkg + $totalpackagecharge;

			$totbed = $totbed + $totalipbedcharges;

			$totnur = $totnur + $totalipnursingcharges;

			$totrmo = $totrmo + $totaliprmocharges;

			$totlab = $totlab + $totallabamount;

			$totrad = $totrad + $totalradiologyamount;

			$totpha = $totpha + $totalpharmacyamount;

			$totser = $totser + $totalservicesamount;

			$totamb = $totamb + $totalambulanceamount;

			$tothom = $tothom + $totalhomecareamount;

			$totdr = $totdr + $totalprivatedoctoramount;

			$totmisc = $totmisc + $totalipmiscamount;

			

			$rowtot1 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+$totallabamount+$totalradiologyamount+

						$totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount;

						 

		  $ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage+$totalnurcingcharges;

			

		

			 ?>

			 <tr bgcolor="#ecf0f5">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>IP Unfinalized</strong></div></td>

                <td class="bodytext31" valign="center"  align="right"><div  class="bodytext31"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=admission"><?php echo number_format($totaladmncharges,2,'.',','); ?></a></div></td>

                 <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=package"><?php echo number_format($totalpackage,2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=bed"><?php echo number_format($totalbedcharges,2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="right"><div  class="bodytext31"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=nursing"><?php echo number_format($totalnurcingcharges,2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=rmo"><?php echo number_format($totaliprmocharges,2,'.',','); ?></a></div></td>

                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=lab"><?php echo number_format($labtotal,2,'.',','); ?></a></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=rad"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></a></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=pharma"><?php echo number_format(($totalpharmacysaleamount-$totalpharmacysalereturnamount),2,'.',','); ?></a></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=services"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></a></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=ambulance"><?php echo number_format($totalambulanceamount,2,'.',','); ?></a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=homecare"><?php echo number_format($totalhomecareamount,2,'.',','); ?></a></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=pvtdr"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></a></div></td>

				   <td  align="left" valign="center" class="bodytext31"><div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=misc"><?php echo number_format($totalipmis,2,'.',','); ?></a></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><a target="_blank" href="iprevenuereportunfinalize_details.php?cbfrmflag1=cbfrmflag1&ward=<?php echo $searchward;?>&locationcode=<?php echo $locationcode1; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&name=others"> <?php echo number_format($totalbedtransfercharges-$totaldiscountrate,2,'.',','); ?></a></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($ipunfinalizeamount,2,'.',','); ?></strong></div></td>

                  </tr>

     

				  <tr><td>&nbsp;</td>

				  </tr>

				

				<?php 

				}

				}

				}

				 ?>

          </tbody>

        </table>

   

	  

   </td>

   </tr>

   

   

    

</table></table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



