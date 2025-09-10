<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$currentdate = date("Y-m-d");



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

 $reqdatefrom=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';

 $reqdateto=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';

 

   if ($locationcode!='')

	{

	$query12 = "select locationname from master_location where locationcode='$locationcode' order by locationname";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res12 = mysqli_fetch_array($exec12);

	

	$res1location = $res12["locationname"];

	 //$locationcode1 = $res12["locationcode"];

	//echo $location;

	}

	else

	{

	$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	

	 $res1location = $res1["locationname"];

   // $locationcode1 = $res1["locationcode"];

	}

//$getcanum = $_GET['canum'];





?>



<table width="" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-left:0px; background-color:#FFF;">

          <tr><td colspan="10">&nbsp;</td></tr>

          <tr>

            <td width="2%">&nbsp;</td>

            <td colspan="8" valign="middle" align="center" class="bodytext32"><hr/>MINISTRY OF HEALTH<hr/></td>

            <td width="2%">&nbsp;</td>

          </tr>

          <tr><td colspan="10">&nbsp;</td></tr>

          <tr><td colspan="10">&nbsp;</td></tr>

          <tr>

          	<td width="2%">&nbsp;</td>

            <td colspan="8" width="" align="center" class="bodytext32"><strong>OUT-PATIENT ATTENDANCE SUMMARY</strong></td>

            <td width="2%">&nbsp;</td>

          </tr>

          <tr>

            <td width="2%">&nbsp;</td>

          	<td width="35" align="left" class="bodytext31"><strong>Institution : </strong></td>

            <td width="" align="left" class="bodytext31"><strong><?php echo  $res1location;?></strong></td>

            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>

            <td align="right" class="bodytext31"><strong>Medical Stastical</strong></td>

          </tr>

         <tr>

         	<td width="2%">&nbsp;</td>

            <td colspan="8" width="" align="right" class="bodytext31"><strong>Form 1A for month ending</strong></td>

            <td width="2%">&nbsp;</td>

          </tr>

          <tr>

           	<td width="2%">&nbsp;</td>

          	<td width="35" align="left" class="bodytext31"><strong>District : </strong></td>

            <td colspan="7" align="left" class="bodytext31"><strong><?php echo  $res1location;?></strong></td>

            <td width="2%">&nbsp;</td>

          </tr>

          <tr>

          	<td width="2%">&nbsp;</td>

          	<td width="35" align="left" class="bodytext31"><strong>Region : </strong></td>

            <td align="left" class="bodytext31"><strong>KENYA</strong></td>

            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>

            <td align="right" class="bodytext31"><strong><?php echo $currentdate; ?></strong></td>

            <td width="2%">&nbsp;</td>

          </tr>

          <tr>

          	<td colspan="10">&nbsp;</td>

          </tr>

      <tr>

      	<td width="16">&nbsp;</td>

        <td colspan="8">

        	<table style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" align="left" border="1">

          <tbody>

           	<tr>

            	<td colspan="7" valign="middle" align="center" class="bodytext33" ><strong>A. OUT - PATIENTS  (<?php echo date('d-m-Y',strtotime($reqdatefrom)).' - '.date('d-m-Y',strtotime($reqdateto)); ?>)</strong></td>

            </tr>

            <tr>

            	<td width="200">&nbsp;</td>

                <td colspan="2" valign="middle" align="center" class="bodytext33"><strong>NEW</strong></td>

                <td colspan="2" valign="middle" align="center" class="bodytext33"><strong>REVISIT</strong></td>

                <td colspan="2" valign="middle" align="center" class="bodytext33"><strong>TOTAL</strong></td>

            </tr>

            <tr>

            	<td width="150" valign="middle" align="center" class="bodytext33"><strong>AGE GROUPS</strong></td>

                <td width="80" valign="middle" align="center" class="bodytext33"><strong>Male</strong></td>

                <td width="80" valign="middle" align="center" class="bodytext33"><strong>Female</strong></td>

                <td width="80" valign="middle" align="center" class="bodytext33"><strong>Male</strong></td>

                <td width="80" valign="middle" align="center" class="bodytext33"><strong>Female</strong></td>

                <td width="80" valign="middle" align="center" class="bodytext33"><strong>Male</strong></td>

                <td width="80" valign="middle" align="center" class="bodytext33"><strong>Female</strong></td>

            </tr>

           <?php

				//GET NEW VISIT PATIENTS COUNT,MALE, FEMALE UNDER AGE ==> 1 - 4 YEARS

				//FOR MALE

				//variables for MALE count in NEW

				$malecount_under_1 = 0;

				$malecount_age_1_4 = 0;

				$malecount_age_5_14 = 0;

				$malecount_age_15_24 = 0;

				$malecount_age_25_34 = 0;

				$malecount_age_35_44 = 0;

				$malecount_age_45_49 = 0;

				$malecount_age_50_54 = 0;

				$malecount_age_55_64 = 0;

				$malecount_age_over_65 = 0;

				

				//Variables for FEMALE COUNT in NEW

				$femalecount_under_1 = 0;

				$femalecount_age_1_4 = 0;

				$femalecount_age_5_14 = 0;

				$femalecount_age_15_24 = 0;

				$femalecount_age_25_34 = 0;

				$femalecount_age_35_44 = 0;

				$femalecount_age_45_49 = 0;

				$femalecount_age_50_54 = 0;

				$femalecount_age_55_64 = 0;

				$femalecount_age_over_65 = 0;
				
				if($locationcode=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$locationcode'";
				}	

			



				//***--GET DATA FOR NEW VISITS FOR MALE AND FEMALE --**//

				//FOR NEW VISIT MALES

				$qrynewvisitsmale = "SELECT a.age,b.ageduration FROM master_visitentry a JOIN master_customer b ON (a.patientcode=b.customercode) WHERE a.gender='Male' AND  a.visitcount='1' AND a.consultationdate BETWEEN '$reqdatefrom' AND '$reqdateto' and a.$pass_location";

				$execnewvisitsmale  = mysqli_query($GLOBALS["___mysqli_ston"], $qrynewvisitsmale) or die ("Error in qrynewvisitsmale".mysqli_error($GLOBALS["___mysqli_ston"]));				

				while($resnewvisitsmale_age =  mysqli_fetch_array($execnewvisitsmale))

				{

					$age_male = $resnewvisitsmale_age["age"];

					$duration_male = $resnewvisitsmale_age["ageduration"];

				

					//MALE COUNT IN AGE -- UNDER 1 Year

					if(($age_male<1 && $duration_male=="YEARS") || $duration_male!='YEARS')

					{

						$malecount_under_1++;

					}

					

					//MALE COUNT IN AGE -- 1 - 4 YEARS

					else if($age_male>=1 && $age_male<=4 && $duration_male=="YEARS")

					{

						$malecount_age_1_4++;

					}

					

					//MALE COUNT IN AGE -- 5 -14 YEARS

					else if($age_male>=5 && $age_male<=14 && $duration_male=="YEARS")

					{

						$malecount_age_5_14++;

					}

					

					//MALE COUNT IN AGE -- 15 -24 YEARS

					else if($age_male>=15 && $age_male<=24 && $duration_male=="YEARS")

					{

						$malecount_age_15_24++;

					}

					

					//MALE COUNT IN AGE -- 25 -34 YEARS

					else if($age_male>=25 && $age_male<=34 && $duration_male=="YEARS")

					{

						$malecount_age_25_34++;

					}

					

					//MALE COUNT IN AGE -- 35 -44 YEARS

					else if($age_male>=35 && $age_male<=44 && $duration_male=="YEARS")

					{

						$malecount_age_35_44++;

					}

					

					//MALE COUNT IN AGE -- 45 -59 YEARS

					else if($age_male>=45 && $age_male<=49 && $duration_male=="YEARS")

					{

						$malecount_age_45_49 = $malecount_age_45_49+1;

					}

					

					//MALE COUNT IN AGE -- 50 -54 YEARS

					else if($age_male>=50 && $age_male<=54 && $duration_male=="YEARS")

					{

						$malecount_age_50_54++;

					}

					

					//MALE COUNT IN AGE -- 55 -64 YEARS

					else if($age_male>=55 && $age_male<=64 && $duration_male=="YEARS")

					{

						$malecount_age_55_64++;

					}

					

					//MALE COUNT IN AGE -- over 65 YEARS

					else if($age_male>=65 && $duration_male=="YEARS")

					{

						$malecount_age_over_65++;

					}

				

					

				}

				

				

				//FOR NEW VISIT FEMALES

				$qrynewvisitsfemale = "SELECT a.age,b.ageduration FROM master_visitentry a JOIN master_customer b ON (a.patientcode=b.customercode) WHERE a.gender='Female' AND  a.visitcount='1' AND a.consultationdate BETWEEN '$reqdatefrom' AND '$reqdateto' and a.$pass_location";

				$execnewvisitsfemale  = mysqli_query($GLOBALS["___mysqli_ston"], $qrynewvisitsfemale) or die ("Error in qrynewvisitsfemale".mysqli_error($GLOBALS["___mysqli_ston"]));

				

				while($resnewvisitsfemale_age =  mysqli_fetch_array($execnewvisitsfemale))

				{

					$age_female=$resnewvisitsfemale_age["age"];

					$duration_female = $resnewvisitsfemale_age["ageduration"];

					

					//FEMALE COUNT IN AGE -- UNDER 1 Year

					if(($age_female<1 && $duration_female=="YEARS") || $duration_female!='YEARS')

					{

						$femalecount_under_1++;

					}

					

					//FEMALE COUNT IN AGE -- 1 - 4 YEARS

					else if($age_female>=1 && $age_female<=4 && $duration_female=="YEARS")

					{

						$femalecount_age_1_4++;

					}

					

					//FEMALE COUNT IN AGE -- 5 -14 YEARS

					else if($age_female>=5 && $age_female<=14 && $duration_female=="YEARS")

					{

						$femalecount_age_5_14++;

					}

					

					//FEMALE COUNT IN AGE -- 15 -24 YEARS

					else if($age_female>=15 && $age_female<=24 && $duration_female=="YEARS")

					{

						$femalecount_age_15_24++;

					}

					

					//FEMALE COUNT IN AGE -- 25 -34 YEARS

					else if($age_female>=25 && $age_female<=34 && $duration_female=="YEARS")

					{

						$femalecount_age_25_34++;

					}

					

					//FEMALE COUNT IN AGE -- 35 -44 YEARS

					else if($age_female>=35 && $age_female<=44 && $duration_female=="YEARS")

					{

						$femalecount_age_35_44++;

					}

					

					//FEMALE COUNT IN AGE -- 45 -59 YEARS

					else if($age_female>=45 && $age_female<=49 && $duration_female=="YEARS")

					{

						$femalecount_age_45_49++;

					}

					

					//FEMALE COUNT IN AGE -- 50 -54 YEARS

					else if($age_female>=50 && $age_female<=54 && $duration_female=="YEARS")

					{

						$femalecount_age_50_54++;

					}

					

					//FEMALE COUNT IN AGE -- 55 -64 YEARS

					else if($age_female>=55 && $age_female<=64 && $duration_female=="YEARS")

					{

						$femalecount_age_55_64++;

					}

					

					//FEMALE COUNT IN AGE -- over 65 YEARS

					else if($age_female>=65 && $duration_female=="YEARS")

					{

						$femalecount_age_over_65++;

					}

				}

				//echo $agecount;

				//***--ENDS FOR NEW VISITS FOR MALE AND FEMALE --**//

				

				//***--GET DATA FOR OLD VISITS FOR MALE AND FEMALE --**//

				

				//variables for MALE count in OLD

				$old_malecount_under_1 = 0;

				$old_malecount_age_1_4 = 0;

				$old_malecount_age_5_14 = 0;

				$old_malecount_age_15_24 = 0;

				$old_malecount_age_25_34 = 0;

				$old_malecount_age_35_44 = 0;

				$old_malecount_age_45_49 = 0;

				$old_malecount_age_50_54 = 0;

				$old_malecount_age_55_64 = 0;

				$old_malecount_age_over_65 = 0;

				

				//Variables for FEMALE COUNT in PLD

				$old_femalecount_under_1 = 0;

				$old_femalecount_age_1_4 = 0;

				$old_femalecount_age_5_14 = 0;

				$old_femalecount_age_15_24 = 0;

				$old_femalecount_age_25_34 = 0;

				$old_femalecount_age_35_44 = 0;

				$old_femalecount_age_45_49 = 0;

				$old_femalecount_age_50_54 = 0;

				$old_femalecount_age_55_64 = 0;

				$old_femalecount_age_over_65 = 0;

				

				//FOR OLD VISITS FOR -- MALE									

				$qryoldvisitsmale = "SELECT a.age,b.ageduration FROM master_visitentry a JOIN master_customer b ON (a.patientcode=b.customercode) WHERE a.gender='Male' AND  a.visitcount<>'1' AND a.consultationdate BETWEEN '$reqdatefrom' AND '$reqdateto' and a.$pass_location";

				$execoldvisitsmale  = mysqli_query($GLOBALS["___mysqli_ston"], $qryoldvisitsmale) or die ("Error in qryoldvisitsmale".mysqli_error($GLOBALS["___mysqli_ston"]));

				

				while($resoldvisitsmale_age =  mysqli_fetch_array($execoldvisitsmale))

				{

					$age_male = $resoldvisitsmale_age["age"];

					$duration_male = $resoldvisitsmale_age["ageduration"];

					$malecount = 1;



					//MALE COUNT IN AGE -- UNDER 1 Year

					if(($age_male<1 && $duration_male=="YEARS") || $duration_male!='YEARS')

					{

						$old_malecount_under_1 =$old_malecount_under_1+$malecount;

					}

					

					//MALE COUNT IN AGE -- 1 - 4 YEARS

					if($age_male>=1 && $age_male<=4 && $duration_male=="YEARS" )

					{

						$old_malecount_age_1_4 = $old_malecount_age_1_4+$malecount;

					}

					

					//MALE COUNT IN AGE -- 5 -14 YEARS

					if($age_male>=5 && $age_male<=14 && $duration_male=="YEARS" )

					{

						$old_malecount_age_5_14 = $old_malecount_age_5_14+$malecount;

					}

					

					//MALE COUNT IN AGE -- 15 -24 YEARS

					if($age_male>=15 && $age_male<=24 && $duration_male=="YEARS" )

					{

						$old_malecount_age_15_24 = $old_malecount_age_15_24+$malecount;

					}

					

					//MALE COUNT IN AGE -- 25 -34 YEARS

					if($age_male>=25 && $age_male<=34 && $duration_male=="YEARS" )

					{

						$old_malecount_age_25_34 = $old_malecount_age_25_34+$malecount;

					}

					

					//MALE COUNT IN AGE -- 35 -44 YEARS

					if($age_male>=35 && $age_male<=44 && $duration_male=="YEARS" )

					{

						$old_malecount_age_35_44 = $old_malecount_age_35_44+$malecount;

					}

					

					//MALE COUNT IN AGE -- 45 -59 YEARS

					if($age_male>=45 && $age_male<=49 && $duration_male=="YEARS" )

					{

						$old_malecount_age_45_49 = $old_malecount_age_45_49+$malecount;

					}

					

					//MALE COUNT IN AGE -- 50 -54 YEARS

					if($age_male>=50 && $age_male<=54 && $duration_male=="YEARS" )

					{

						$old_malecount_age_50_54 = $old_malecount_age_50_54+$malecount;

					}

					

					//MALE COUNT IN AGE -- 55 -64 YEARS

					if($age_male>=55 && $age_male<=64 && $duration_male=="YEARS" )

					{

						$old_malecount_age_55_64 = $old_malecount_age_55_64+$malecount;

					}

					

					//MALE COUNT IN AGE -- over 65 YEARS

					if($age_male>=65 && $duration_male=="YEARS" )

					{

						$old_malecount_age_over_65 = $old_malecount_age_over_65+$malecount;

					}

				

				}

				

				

				//FOR OLD VISITS FEMALE

				$qryoldvisitsfemale = "SELECT a.age,b.ageduration FROM master_visitentry a JOIN master_customer b ON (a.patientcode=b.customercode) WHERE a.gender='Female' AND  a.visitcount<>'1' AND a.consultationdate BETWEEN '$reqdatefrom' AND '$reqdateto' and a.$pass_location";

				$execoldvisitsfemale  = mysqli_query($GLOBALS["___mysqli_ston"], $qryoldvisitsfemale) or die ("Error in qryoldvisitsfemale".mysqli_error($GLOBALS["___mysqli_ston"]));

				

				while($resoldvisitsfemale_age =  mysqli_fetch_array($execoldvisitsfemale))

				{

					$age_female = $resoldvisitsfemale_age["age"];

					$duration_female = $resoldvisitsfemale_age["ageduration"];

//					$femalecount = $resoldvisitsfemale_age["femalecount"];

					$femalecount = 1;

					

					//FEMALE COUNT IN AGE -- UNDER 1 Year

					if(($age_female<1 && $duration_female=="YEARS") || $duration_female!='YEARS')

					{

						$old_femalecount_under_1 = $old_femalecount_under_1+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 1 - 4 YEARS

					if($age_female>=1 && $age_female<=4 && $duration_female=="YEARS")

					{

						$old_femalecount_age_1_4 = $old_femalecount_age_1_4+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 5 -14 YEARS

					if($age_female>=5 && $age_female<=14 && $duration_female=="YEARS")

					{

						$old_femalecount_age_5_14 = $old_femalecount_age_5_14+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 15 -24 YEARS

					if($age_female>=15 && $age_female<=24 && $duration_female=="YEARS")

					{

						$old_femalecount_age_15_24 = $old_femalecount_age_15_24+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 25 -34 YEARS

					if($age_female>=25 && $age_female<=34 && $duration_female=="YEARS")

					{

						$old_femalecount_age_25_34 = $old_femalecount_age_25_34+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 35 -44 YEARS

					if($age_female>=35 && $age_female<=44 && $duration_female=="YEARS")

					{

						$old_femalecount_age_35_44 = $old_femalecount_age_35_44+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 45 -59 YEARS

					if($age_female>=45 && $age_female<=49 && $duration_female=="YEARS")

					{

						$old_femalecount_age_45_49 = $old_femalecount_age_45_49+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 50 -54 YEARS

					if($age_female>=50 && $age_female<=54 && $duration_female=="YEARS")

					{

						$old_femalecount_age_50_54 = $old_femalecount_age_50_54+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- 55 -64 YEARS

					if($age_female>=55 && $age_female<=64 && $duration_female=="YEARS")

					{

						$old_femalecount_age_55_64 = $old_femalecount_age_55_64+$femalecount;

					}

					

					//FEMALE COUNT IN AGE -- over 65 YEARS

					if($age_female>=65 && $duration_female=="YEARS")

					{

						$old_femalecount_age_over_65 = $old_femalecount_age_over_65+$femalecount;

					}

					

				}

				

					

					//TOTAL MALE & FEMALE COUNT (NEW+OLD) IN AGE 

					$tot_male_under_1 = $malecount_under_1 + $old_malecount_under_1;

					$tot_female_under_1 = $femalecount_under_1 + $old_femalecount_under_1;

					

					$tot_male_age_1_4 = $malecount_age_1_4 + $old_malecount_age_1_4;

					$tot_female_age_1_4 = $femalecount_age_1_4 + $old_femalecount_age_1_4;

					

					$tot_male_age_5_14 = $malecount_age_5_14 + $old_malecount_age_5_14;

					$tot_female_age_5_14 = $femalecount_age_5_14 + $old_femalecount_age_5_14;

					

					$tot_male_age_15_24 = $malecount_age_15_24 + $old_malecount_age_15_24;

					$tot_female_age_15_24 = $femalecount_age_15_24 + $old_femalecount_age_15_24;

					

					$tot_male_age_25_34 = $malecount_age_25_34 + $old_malecount_age_25_34;

					$tot_female_age_25_34 = $femalecount_age_25_34 + $old_femalecount_age_25_34;

					

					$tot_male_age_35_44 = $malecount_age_35_44 + $old_malecount_age_35_44;

					$tot_female_age_35_44 = $femalecount_age_35_44 + $old_femalecount_age_35_44;

					

					$tot_male_age_45_49 = $malecount_age_45_49 + $old_malecount_age_45_49;

					$tot_female_age_45_49 = $femalecount_age_45_49 + $old_femalecount_age_45_49;

					

					$tot_male_age_50_54 = $malecount_age_50_54 + $old_malecount_age_50_54;

					$tot_female_age_50_54 = $femalecount_age_50_54 + $old_femalecount_age_50_54;

					

					$tot_male_age_55_64 = $malecount_age_55_64 + $old_malecount_age_55_64;

					$tot_female_age_55_64 = $femalecount_age_55_64 + $old_femalecount_age_55_64;

					

					$tot_male_age_over_65 = $malecount_age_over_65 + $old_malecount_age_over_65;

					$tot_female_age_over_65 = $femalecount_age_over_65 + $old_femalecount_age_over_65;

					

					

					//TOTAL MALE, FEMALE COUNT FOR ALL AGES IN NEW AND REVISITS

					$total_all_new_males = $malecount_under_1 + $malecount_age_1_4 + $malecount_age_5_14 + $malecount_age_15_24 +  $malecount_age_25_34 +  $malecount_age_35_44 + $malecount_age_45_49 + $malecount_age_50_54 + $malecount_age_55_64 + $malecount_age_over_65;

					

					$total_all_new_females = $femalecount_under_1 + $femalecount_age_1_4 + $femalecount_age_5_14 + $femalecount_age_15_24 +  $femalecount_age_25_34 +  $femalecount_age_35_44 + $femalecount_age_45_49 + $femalecount_age_50_54 + $femalecount_age_55_64 + $femalecount_age_over_65;

					

					$total_all_old_males = $old_malecount_under_1 + $old_malecount_age_1_4 + $old_malecount_age_5_14 + $old_malecount_age_15_24 +  $old_malecount_age_25_34 +  $old_malecount_age_35_44 + $old_malecount_age_45_49 + $old_malecount_age_50_54 + $old_malecount_age_55_64 + $old_malecount_age_over_65;

					

					$total_all_old_females = $old_femalecount_under_1 + $old_femalecount_age_1_4 + $old_femalecount_age_5_14 + $old_femalecount_age_15_24 +  $old_femalecount_age_25_34 +  $old_femalecount_age_35_44 + $old_femalecount_age_45_49 + $old_femalecount_age_50_54 + $old_femalecount_age_55_64 + $old_femalecount_age_over_65;

					

					$total_all_males = $tot_male_under_1 + $tot_male_age_1_4 + $tot_male_age_5_14 + $tot_male_age_15_24 + $tot_male_age_25_34 + $tot_male_age_35_44 + $tot_male_age_45_49 + $tot_male_age_50_54 + $tot_male_age_55_64 + $tot_male_age_over_65;

					

					$total_all_females = $tot_female_under_1 + $tot_female_age_1_4 + $tot_female_age_5_14 + $tot_female_age_15_24 + $tot_female_age_25_34 + $tot_female_age_35_44 + $tot_female_age_45_49 + $tot_female_age_50_54 + $tot_female_age_55_64 + $tot_female_age_over_65;

			?>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>Under 1 Year</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_under_1; ?></strong></td>

            </tr>

            <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>1 - 4 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_1_4 ; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_1_4; ?> </strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_1_4; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>5 - 14 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_5_14; ?></strong></td>

            </tr>

            <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>15 - 24 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_15_24; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>25 - 34 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_25_34; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>35 - 44 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_35_44; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>45 - 49 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_45_49; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>50 - 54 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_50_54; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>55 - 64 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_55_64; ?></strong></td>

            </tr>

             <tr>

            	<td valign="middle" align="left" class="bodytext31"><strong>Over 65 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_over_65; ?></strong></td>

            </tr>

            <tr>

            	<td valign="middle" align="center" class="bodytext31"><strong>All Ages</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_new_males; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_new_females; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_old_males; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_old_females; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_males; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_females; ?></strong></td>

            </tr>

          </tbody>

        </table>

        </td>

        <td width="46">&nbsp;</td>

      </tr>

      <tr><td width="16">&nbsp;</td><td colspan="8">&nbsp;</td><td width="46">&nbsp;</td></tr>

      <tr><td width="16">&nbsp;</td><td colspan="8">&nbsp;</td><td width="46">&nbsp;</td></tr>

      <tr><td width="16">&nbsp;</td><td colspan="8" align="right">................................</td><td width="46">&nbsp;</td></tr>

      <tr>

      	<td width="16">&nbsp;</td>

        <td colspan="8" valign="middle" align="right" class="bodytext31"><strong>Medical Officer-in-Charge</strong></td>

        <td width="46">&nbsp;</td>

      </tr>

       <tr>

      	<td colspan="10">&nbsp;</td>

      </tr>

       <tr>

      	<td colspan="10">&nbsp;</td>

      </tr>

      <tr>

      	<td width="16">&nbsp;</td>

      	<td colspan="8" class="bodytext31">

        	<strong>*To be despatched not later than the Tuesday of the month immediately following to the District Medical Officer of Health with copies to :

            <br/>

            <span style="margin-left:50px">1.   <span style="margin-left:30px;">REGIONAL DIRECTOR OF HEALTH SERVICES</span></span></strong>

        </td>

        <td width="46">&nbsp;</td>

      </tr>

      <tr><td colspan="10">&nbsp;</td></tr>

    </table>





<?php



   $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('daybookreport.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    } 

?>



