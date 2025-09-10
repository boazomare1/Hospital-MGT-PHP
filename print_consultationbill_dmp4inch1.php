<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');





$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

	include('convert_currency_to_words.php');

	

	$query11 = "select * from master_billing where billnumber = '$billautonumber' ";

	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_num_rows($exec11);

	$res11 = mysqli_fetch_array($exec11);

	$res11patientfirstname = $res11['patientfirstname'];

	$res11patientfullname = $res11['patientfullname'];

	$res11patientcode = $res11['patientcode'];

	$res11visitcode = $res11['visitcode'];

	$res11billnumber = $res11['billnumber'];

	$res11consultationfees = $res11['consultationfees'];

	$res11subtotalamount = $res11['subtotalamount'];

	$convertedwords = covert_currency_to_words($res11subtotalamount);

	$res11billingdatetime = $res11['billingdatetime'];

	$res11patientpaymentmode = $res11['patientpaymentmode'];

	$res11username = $res11['username'];

	$res11cashamount = $res11['cashamount'];

	$res11chequeamount = $res11['chequeamount'];

	$res11cardamount = $res11['cardamount'];

	$res11onlineamount= $res11['onlineamount'];

  $res11adjustamount= $res11['adjustamount'];

	$res11creditamount= $res11['creditamount'];

	$res11updatetime= $res11['consultationtime'];

	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];

	$res11cashgiventocustomer = $res11['cashgiventocustomer'];

	$res11locationcode = $res11['locationcode'];

	$res_doctor_fullname = $res11['consultingdoctor'];
	$mpesa_ref = $res11['mpesanumber'];
	$card_ref = $res11['creditcardnumber'];
	$reference='';
	if($mpesa_ref!='')
	{
	$reference= $mpesa_ref;   
	}
    if($card_ref!='')
	{
	 $reference= $card_ref;      
	}
	

	$queryuser="select employeename from master_employee where username='$res11username'";

		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resuser = mysqli_fetch_array($execuser);

		$res11username=$resuser['employeename'];


?>

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}.style2 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}

.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }

.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}



.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }

.bodytext30 { FONT-SIZE: 18px; FONT-WEIGHT: bold; COLOR: #000000; }

.bodytext{ text-decoration: underline; line-height:14px}

body {

	background-color: #ecf0f5;

}

body {

	width:421px;

	heigth:595px;

	margin:  auto;

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  }

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}



</style>

	<page pagegroup="new" backtop="2mm" backbottom="25mm" backleft="2mm" backright="3mm">

<!--	<page_footer>

                <div class="page_footer" style="width: 100%;text-align: center">

                    <?= $footer="Blood is FREE for all @ Maua Methodist Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@mckmauahospital.org"; ?>

                </div>

    </page_footer>-->



<div>

<?php include('print_header80x80.php'); ?>



<table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">

<tr>

<td width="20%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="50%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="20%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="10%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

</tr>

	<tr>

    <td class="bodytext32" >Name : </td>

    <td  colspan="3" class="bodytext33" ><?php echo $res11patientfullname; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

		

	</tr>

	<tr>

		<td align="left" class="bodytext32" >Reg No: </td>

        <td colspan="3" align="left" class="bodytext33" ><?php echo $res11patientcode; ?></td></tr>

	<tr>
		<td align="left" class="bodytext32" >Visit No: </td>
        <td colspan="3" align="left" class="bodytext32" ><?php echo $res11visitcode; ?></td></tr>

	<tr>

		<td class="bodytext32">Bill No: </td>

      <td class="bodytext33"><?php echo $res11billnumber; ?></td>

        <td class="bodytext32">Bill Date: </td>

        <td class="bodytext33"><?php echo date("d/m/Y", strtotime($res11billingdatetime)); ?></td>

	</tr>

	<tr>
		<td align="left" class="bodytext32" >Doctor: </td>
        <td colspan="3" align="left" class="bodytext33" ><?php echo $res_doctor_fullname; ?></td></tr>
	<tr>

<td width="20%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="50%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="20%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="10%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

</tr>

</table>



<table width="100%" border="" align="center" cellpadding="1" cellspacing="1">

  

<tr>

    <td class="bodytext32" width="20%">Consultation Charges:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11subtotalamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr>

    <td class="bodytext31 bodytext" colspan="3">Payment Mode:</td>

  </tr>
  <tr>
   <td class="bodytext32">Transaction Reference:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo $reference; ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>

  <?php if($res11cashgivenbycustomer != 0.00) { ?> 	

  <tr>

    <td class="bodytext32">Cash Received:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr>

    <td class="bodytext32">Cash Returned:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

   <?php } ?>

  

  <?php if($res11chequeamount != 0.00) { ?> 	

  <tr>

    <td class="bodytext32">Cheque Amount:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <?php } ?>

  <?php if($res11creditamount != 0.00) { ?> 

  <tr>

    <td class="bodytext32">MPESA Amount: </td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11creditamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

   <?php } ?>

   <?php if($res11cardamount != 0.00) { ?> 

  <tr>

    <td class="bodytext32">Card Amount: </td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11cardamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <?php } ?>

  <?php if($res11onlineamount != 0.00) { ?>

  <tr>

    <td class="bodytext32">Online Amount:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

   <?php } ?>



<?php if($res11adjustamount != 0.00) { ?>

  <tr>

    <td class="bodytext32">Deposit Adjusted:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11adjustamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

   <?php } ?>



  <tr>

    <td colspan="2" class="bodytext33"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

  </tr>

  <!--<tr>

    <td colspan="3">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>-->
  
  
  <?php
  $source_from='';
  include ("eTimsapi.php");
  ?>

  <tr>

    <td  class="bodytext31"><strong>Served By: </strong><?php echo strtoupper($res11username); ?></td>
    
    <td  align="right" class="bodytext31"><?php echo date("d/m/Y", strtotime($res11billingdatetime)). "&nbsp;". date('g.i A',strtotime($res11updatetime)); ?> </td>

  </tr>
 

</table>

</div>

</page>

<?php	

	$content = ob_get_clean();

   

    // convert to PDF

   

    try

    {	

		$width_in_inches = 4.39;

		$height_in_inches = 6.2;

		$width_in_mm = $width_in_inches * 25.4; 

		$height_in_mm = $height_in_inches * 25.4;

        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));

        $html2pdf->pdf->SetDisplayMode('fullpage');

		//$html2pdf->setDefaultFont('Helvetica');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_consultationbill.pdf');

		

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

	

?>

