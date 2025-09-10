<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$currentdate = date("M d, Y");





$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:''; 



if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; }else{ $cbfrmflag1 = ""; }

if($cbfrmflag1 == "cbfrmflag1")

{

	$reqdatefrom = $_REQUEST["ADate1"];

	$reqdateto = $_REQUEST["ADate2"];

}

?>



<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

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

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

<script src="js/datetimepicker_css.js"></script> 

</head>





<body>

<table width="" border="0" cellspacing="0" cellpadding="2">

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

  

  <!--DESIGN FOR SEARCH IN DATE RANGE-->

  <tr>

      <td width="860">

              <form name="cbform1" id="cbform1" method="post" action="outpatientsattendancesummary.php">

              <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; margin-left:25px;">

                  <tbody>

                      <tr>

              <td colspan="2" bgcolor="#ecf0f5" align="left"  class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="left" ><strong>Search OP Attendance</strong></div></td>

                 <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

                        

                            

                        if ($location!='')

                        {

                        $query12 = "select locationname from master_location where locationcode='$location' order by locationname";

                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $res12 = mysqli_fetch_array($exec12);

                        

                        echo $res1location = $res12["locationname"];

						 //$locationcode1 = $res12["locationcode"];

                        //echo $location;

                        }

                        else

                        {

                        $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $res1 = mysqli_fetch_array($exec1);

                        

                        echo $res1location = $res1["locationname"];

                       // $locationcode1 = $res1["locationcode"];

                        }

                        ?>

                  </td>

              </tr>

              

          <tr>

           <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Location </strong></span></td>

          <td  colspan="3" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

           <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" >
            <option value="All">All</option>

          <?php
						

						$query01="select locationcode,locationname from master_location where status ='' order by locationname";

						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
	                    $loccode=array();
						while($res01=mysqli_fetch_array($exc01))

						{?>

							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		

						<?php 

						}

						?>

                      </select></span></td>

          </tr>



          <tr>

          <td width="100" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

          

          <input name="ADate1" id="ADate1" value="<?php if(isset($_REQUEST["cbfrmflag1"])){ echo $reqdatefrom; }else{ echo $transactiondatefrom; }?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php if(isset($_REQUEST["cbfrmflag1"])){ echo $reqdateto; }else{ echo $transactiondateto; }?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

          </span></td>

          </tr>

          

            <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                    <input  type="submit" value="Search" name="Submit" />

                    <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

              </tr>

            </tbody>

          </table>

        </form>		

      </td>

  </tr>

  <!--ENDS-->

  <tr><td colspan="9">&nbsp;</td></tr>

  <tr>

   

    <td colspan="8" width="" valign="top" >

    <!--DISPLAY REPORT AFTER SEARCH WITH DATE RANGE-->

    <?php

	if($cbfrmflag1 == "cbfrmflag1")

	{

		$reqdatefrom = $_REQUEST["ADate1"];

	    $reqdateto = $_REQUEST["ADate2"];

	

	

	$malecount_agebelow1 = 0;

	$femalecount_agebelow1 = 0;

	$malecount_agebelow1_1 = 0;

	$femalecount_agebelow1_1 = 0;

	

	if($location=='All')
	{
	$pass_location = "locationcode !=''";
	}
	else
	{
	$pass_location = "locationcode ='$location'";
	}	

	?>

   <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-left:20px;">

      <tr>

      

        <td colspan="8">

        	<table style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" align="left" border="1">

          <tbody>

           	<tr>

            	<td colspan="7" valign="middle" align="center" class="bodytext33" style="background-color: #CCC"><strong>A. OUT - PATIENTS (<?php echo date('d-m-Y',strtotime($reqdatefrom)).' - '.date('d-m-Y',strtotime($reqdateto)); ?>) </strong></td>

            </tr>

            <tr>

            	<td>&nbsp;</td>

                <td colspan="2" valign="middle" align="center" class="bodytext33"><strong>NEW</strong></td>

                <td colspan="2" valign="middle" align="center" class="bodytext33"><strong>REVISIT</strong></td>

                <td colspan="2" valign="middle" align="center" class="bodytext33"><strong>TOTAL</strong></td>

            </tr>

            <tr>

            	<td valign="middle" align="center" class="bodytext33"><strong>AGE GROUPS</strong></td>

                <td valign="middle" align="center" class="bodytext33"><strong>Male</strong></td>

                <td valign="middle" align="center" class="bodytext33"><strong>Female</strong></td>

                <td valign="middle" align="center" class="bodytext33"><strong>Male</strong></td>

                <td valign="middle" align="center" class="bodytext33"><strong>Female</strong></td>

                <td valign="middle" align="center" class="bodytext33"><strong>Male</strong></td>

                <td valign="middle" align="center" class="bodytext33"><strong>Female</strong></td>

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

					

					

						$colorcode1 = 'bgcolor="#CBDBFA"';

						$colorcode2 = 'bgcolor="#ecf0f5"';

					

			?>

             <tr <?php echo $colorcode1; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>Under 1 Year</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_under_1; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_under_1; ?></strong></td>

            </tr>

            <tr <?php echo $colorcode2; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>1 - 4 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_1_4 ; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_1_4; ?> </strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_1_4; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode1; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>5 - 14 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_5_14; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_5_14; ?></strong></td>

            </tr>

            <tr <?php echo $colorcode2; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>15 - 24 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_15_24; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_15_24; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode1; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>25 - 34 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_25_34; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_25_34; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode2; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>35 - 44 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_1_4; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_35_44; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_35_44; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode1; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>45 - 49 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_45_49; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_45_49; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode2; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>50 - 54 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_50_54; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_50_54; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode1; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>55 - 64 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_55_64; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_55_64; ?></strong></td>

            </tr>

             <tr <?php echo $colorcode2; ?>>

            	<td valign="middle" align="left" class="bodytext31"><strong>Over 65 YEARS</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $malecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $femalecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_malecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $old_femalecount_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_male_age_over_65; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $tot_female_age_over_65; ?></strong></td>

            </tr>

            <tr style="background-color: #999">

            	<td valign="middle" align="center" class="bodytext31"><strong>All Ages</strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_new_males; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_new_females; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_old_males; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_old_females; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_males; ?></strong></td>

                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $total_all_females; ?></strong></td>

                <td bgcolor="#ecf0f5" align="left" width="40" style="border: hidden; border-left: #000"><a target="_blank" href="print_opattendancesummary.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $reqdatefrom; ?>&&ADate2=<?php echo $reqdateto; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>

        		<td bgcolor="#ecf0f5" align="left" width="40" style="border: hidden;"><a href="print_opattendancesummaryxl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $reqdatefrom; ?>&&ADate2=<?php echo $reqdateto; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

            </tr>

          </tbody>

        </table>

        </td>

      </tr>

      <!--ENDS - DISPLAY REPORT-->

    </table>

    

    <?php

	} //close -- if($cbfrmflag1 == "cbfrmflag1")

	?>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



