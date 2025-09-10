<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

//include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");



$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$dateonly1 = date("Y-m-d");

$timeonly= date("H:i:s");

$titlestr = 'SALES BILL';

$colorloopcount = '';

$sno = '';

$pagebreak = '';



ob_start();

$billnumber=isset($_REQUEST['billnumber'])?$_REQUEST['billnumber']:'';



if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }

if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }



$query612 = "select * from consultation_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";

$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res612 = mysqli_fetch_array($exec612);

$orderedby = $res612['username'];

$Patientname=$res612['patientname'];

$accountname=$res612['accountname'];

$accountcode=$res612['accountcode'];

$doctor=$res612['doctor'];

$locationname=$res612['locationname'];

//$docno=$res612['resultdoc'];

$samplecollectedon=$res612['consultationdate'].' '.$res612['consultationtime'];

//$dob = $res612['dateofbirth'];

$billdatetime = $res612['preparation_datetime'];





$query613 = "select * from resultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";

$exec613 = mysqli_query($GLOBALS["___mysqli_ston"], $query613) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res613 = mysqli_fetch_array($exec613);

$docno = $res613['docnumber'];

$res38publisheddatetime = $res613['recorddate'].' '.$res613['recordtime'];

$res123recordtime=$res613['recordtime'];

$res123recorddate=$res613['recorddate'];







?>

<?php 

$query2 = "select * from master_company where auto_number = '$companyanum'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$companyname = $res2["companyname"];

$address1 = $res2["address1"];

$address2 = $res2["address2"];

$area = $res2["area"];

$city = $res2["city"];

$pincode = $res2["pincode"];

$emailid1 = $res2["emailid1"];

$phonenumber1 = $res2["phonenumber1"];

$phonenumber2 = $res2["phonenumber2"];

$faxnumber1 = $res2["faxnumber1"];

$cstnumber1 = $res2["cstnumber"];

$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];



$location= $locationname;



$query65= "select * from master_visitentry where patientcode='$patientcode' and visitcode = '$visitcode'";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));

$res65=mysqli_fetch_array($exec65);

$Patientname=$res65['patientfullname'];



$query8="select * from master_employee where username = '$username' ";

$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);

$num8=mysqli_num_rows($exec8);

$res8=mysqli_fetch_array($exec8);

$res8jobdescription=$res8['jobdescription'];



if($patientcode != 'walkin')

{

$query5 = "select * from master_customer where customercode = '$patientcode'";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$area12 = $res5['area'];

$fileno5 = $res5['fileno'];

$patientage=$res5['age'];

$patientgender=$res5['gender'];

$dob = $res5['dateofbirth'];

}

else

{

$query77 = "select * from resultentry_radiology where docnumber = '$docnumber' and billnumber='$billnumber'";

  $exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res77=mysqli_fetch_array($exec77);

$billnumber=$res77['billnumber'];

  $locationcode=$res78['locationcode'];

  

  $query771 = "select * from billing_external where billno = '$billnumber'";

  $exec771=mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res771=mysqli_fetch_array($exec771);

$Patientname=$res771['patientname'];

$patientage=$res771['age'];

 $patientgender=$res771['gender'];

 $dob = '0000-00-00';

}



if($dob != '0000-00-00')

{

	$today = new DateTime();

    $diff = $today->diff(new DateTime($dob));

	$diff1 = $diff->format('%y||%m||%d');

	$dayssplit = explode('||',$diff1);

	$year = $dayssplit[0];

	if($year > 1){ $yearname = 'Years'; } else { $yearname = 'Year'; }

	$month = $dayssplit[1];

	if($month > 1){ $monthname = 'Months'; } else { $monthname = 'Month'; }

	$day = $dayssplit[2];

	if($day > 1){ $dayname = 'Days'; } else { $dayname = 'Day'; }

	if($year == 0 && $month != 0)

	{

		$dob1 = $month.' '.$monthname.' '.$day.' '.$dayname;

	}

	else if($year == 0 && $month == 0)

	{

		$dob1 = $day.' '.$dayname;

	}	

	else if($year != 0 && $month != 0)

	{

		$dob1 = $year.' '.$yearname.' '.$month.' '.$monthname;

	}

	else

	{

		$dob1 = $year.' '.$yearname;

	}

}

else

{

$dob1 = $patientage;

}	

?>



<?php //include('a4pdfheader.php'); ?>

<style type="text/css">



.bodytext27 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}



.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; 

}





body {

	margin:0 auto; 

	width:100%;

	background-color: #FFFFFF;

	font-family:Arial, Helvetica, sans-serif;

}



.page{

    width: 612px; 

    height: 792px; 

    overflow: hidden; 

    position: relative; 

    page-break-after: always;

}

.last-page{

   width: 612px; 

   height: 792px; 

   overflow: hidden; 

   position: relative; 

  

 }



</style>



<body>



                <?php  include("print_header_pdf2.php"); ?>



	<table width="520" border="0" cellspacing="0" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">

	       

        <tr>

			<input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 

			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">

			<td width="60" class="bodytext27"><strong>Name:</strong></td>

		  <td width="110" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?> &nbsp; <b>Age: </b><?=$patientage;?>, 
		  	<b>Gender:</b> <?=$patientgender;?>

	<!-- 	<?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?> -->

	      <input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>	      </td>
<!-- 
		  <td width="60" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Gender: </strong> </td>

		  <td width="60" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?=$patientgender;?></td> -->

		  <td width="60" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Date</strong></td>

		  <td width="110" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime($samplecollectedon)); ?></td>

		</tr>


		<tr>

			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Reg. No:</strong></td>

			<td align="left" valign="middle" class="bodytext27"><?php echo $patientcode; ?>,&nbsp;&nbsp;&nbsp; <b>Visit No: </b><?=$visitcode; ?>

		  <input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	      </td>

			<!-- <td align="left" valign="top" class="bodytext27"><strong></strong></td>

			<td align="left" valign="top" class="bodytext27"></td> -->

			<td class="bodytext27"><strong>Account </strong></td>

		  <td class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>

	  </tr>

	   

</table>

    <table width="541" border="0" cellpadding="1" cellspacing="2" style="clear: both;">

      <tr>

        <td colspan="" align="center" valign="middle" style="font-size:16px; text-decoration:underline;"><strong>Radiology Report</strong> </td>

       </tr>

      				

		<?php

    if($visitcode=='walkinvis' && $patientcode=='walkin')

{

      $query31="select * from resultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billnumber' and acknowledge = 'completed' group by itemname";

}

else

{

	 $query31="select * from resultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' and acknowledge = 'completed' group by itemname";

}



	  

	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);

	  $num=mysqli_num_rows($exec31);

	  while($res31=mysqli_fetch_array($exec31))

	  { 

		$labname1=$res31['itemname'];

        $templatedata=$res31['templatedata'];

		$docnumber=$res31['docnumber'];

		$filename = $res31['filename'];

		$fileurl = $res31['fileurl'];

		$addendum = $res31['addendum'];

	   

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

		<tr>

			<td width="97" align="left" valign="center" class="bodytext31" ></td>		

		</tr>	

			  

		<tr>

 		 <td width="540"  align="left" valign="center" class="bodytext31" >

		 <strong>	<?php echo $labname1; ?></strong>

         <br />

		<br />



		 <?php 

         $templatedata = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $templatedata);

		$newcontent = preg_replace("/<p[^>]*?>/", "", $templatedata);
        $newcontent = str_replace("</p>", "<br/>", $newcontent);
        $newcontent = str_replace("</pre>", "<br/>", $newcontent);
	    $templatedata=$newcontent;
		 //$templatedata = preg_replace('/<span style="(.+?)">(.+?)<\/span>/i', "<span>$2</span>", $templatedata);

		 echo $templatedata;

		 

		 ?></td>

		</tr>

		 <?php

		 }

		 ?>

		    

               



	  <tr>

			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>

			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>

	  </tr>

	

     

	    <?php

				 if($addendum != ''){

					 ?>



					  <tr>

 		 <td width="540"  align="left" valign="center" class="bodytext31" >

		 <strong> Addendum: </strong>

		 <br />		 

		 <?php 
		 
		  $templatedata = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $addendum);

		$newcontent = preg_replace("/<p[^>]*?>/", "", $templatedata);
        $newcontent = str_replace("</p>", "<br/>", $newcontent);
        $newcontent = str_replace("</pre>", "<br/>", $newcontent);
	    $addendum=$newcontent;
		 echo $addendum; ?></td>

		</tr>



					 <?php

				 }

				 ?>

  </table>

      



<?php	

require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4");

$dompdf->render();

$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("times-roman", "normal");

$canvas->page_text(272, 814, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("RadiologyResultsFull.pdf", array("Attachment" => 0)); 

?>



</body>

</html>