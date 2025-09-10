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



$query612 = "select * from ipconsultation_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";

$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res612 = mysqli_fetch_array($exec612);

$orderedby = $res612['username'];

$Patientname=$res612['patientname'];

$accountname=$res612['accountname'];

$accountcode=$res612['accountcode'];

$doctor=$res612['doctor'];

$locationname=$res612['locationname'];

//$docno=$res612['resultdoc'];

$samplecollectedon=$res612['consultationdate'];

//$dob = $res612['dateofbirth'];

$billdatetime = $res612['sampledatetime'];

$sampleid = $res612['sampleid'];

$res38publisheddatetime = $res612['publishdatetime'];



 $query613 = "select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";

$exec613 = mysqli_query($GLOBALS["___mysqli_ston"], $query613) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res613 = mysqli_fetch_array($exec613);

$docno = $res613['docnumber'];



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



$location= $locationname;



$query65= "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode = '$visitcode'";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));

$res65=mysqli_fetch_array($exec65);

$Patientname=$res65['patientfullname'];



$query8="select * from master_employee where username = '$username' ";

$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);

$num8=mysqli_num_rows($exec8);

$res8=mysqli_fetch_array($exec8);

$res8jobdescription=$res8['jobdescription'];

$query77 = "select * from ipresultentry_radiology where docnumber = '$docnumber' and billnumber='$billnumber'";

  $exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res77=mysqli_fetch_array($exec77);
$recorddate=$res77['recorddate'];
$recordtime=$res77['recordtime'];

 $samplecollectedon=$recorddate.' '.$recordtime;

if($patientcode != 'walkin')

{

$query5 = "select * from master_customer where customercode = '$patientcode'";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$area12 = $res5['area'];

$fileno5 = '';

$patientage=$res5['age'];

$patientgender=$res5['gender'];

$dob = $res5['dateofbirth'];



}

else

{

 $query77 = "select * from ipresultentry_radiology where docnumber = '$docnumber' and billnumber='$billnumber'";

  $exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res77=mysqli_fetch_array($exec77);

$billnumber=$res77['billnumber'];
$recorddate=$res77['recorddate'];
$recordtime=$res77['recordtime'];

 $samplecollectedon=$recorddate.' '.$recordtime;

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

<style>

body {

    font-family: 'Arial'; font-size:11px;	 

}

.bodytext31{ font-size:13px; }

.bodytext27{ font-size:12px; }

#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height: 30px; }

#footer .page:after { content: counter(page, upper-roman); }

.style1 {

	font-size: 10px;

	font-weight: bold;

}



.top {

    border-top:1px #ecf0f5;

    border-color:#ecf0f5;

}



.bottom {

    border-bottom:1px #ecf0f5;

    border-color:#ecf0f5;

}



.left {

    border-left:1px #ecf0f5;

    border-color:#ecf0f5;

}



.right {

    border-right:1px #ecf0f5;

    border-color:#ecf0f5;

}

div.page_header { padding-top:0mm;}

div.page_footer { padding:0mm; }



     @page { margin: 50px 50px; }

     #header { position: fixed; left: 0px; top: -80px; right: 0px;  }

</style>

<?php //include('a4pdfheader.php'); ?>
 

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

    <table width="541" border="0" cellpadding="1" cellspacing="2">

      <tr>

        <td colspan="" align="center" valign="middle" style="font-size:16px; text-decoration:underline;"><strong>Radiology Report</strong> </td>

      </tr>

      <tr>

        <td  align="left" valign="middle">&nbsp;</td>

	    <td  align="left" valign="middle">&nbsp;</td>

        <td  align="left" valign="middle">&nbsp;</td>

		<td  align="left" valign="middle">&nbsp;</td>

        <td align="left" valign="middle">&nbsp;</td>

		<td align="left" valign="middle">&nbsp;</td>

      </tr>

      

      				

		<?php

    if($visitcode=='walkinvis' && $patientcode=='walkin')

{

      $query31="select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billnumber' and acknowledge = 'completed' group by itemname";

}

else

{

	 $query31="select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' and acknowledge = 'completed' group by itemname";

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

		$templatedata = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $templatedata);
		$newcontent = preg_replace("/<p[^>]*?>/", "", $templatedata);
        $newcontent = str_replace("</p>", "<br/>", $newcontent);
        $newcontent = str_replace("</pre>", "<br/>", $newcontent);
		$templatedata=$newcontent;

		$addendum1 = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $addendum);
		$newcontent1 = preg_replace("/<p[^>]*?>/", "", $addendum1);
        $newcontent1 = str_replace("</p>", "<br/>", $newcontent1);
        $newcontent1 = str_replace("</pre>", "<br/>", $newcontent1);
		$addendum=$newcontent1;
	   

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



		 <?php echo $templatedata; ?></td>

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

		 <?php echo $addendum; ?></td>

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

$dompdf->stream ("RadiologyResultsFull.pdf", array("Attachment" => 0)); 

?>

