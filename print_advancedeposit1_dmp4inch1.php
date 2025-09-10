<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");





$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



 $patientcode = $_REQUEST['patientcode'];

 $billnumbercode = $_REQUEST['billnumbercode'];

 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

?>





<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.style2 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; 

}.style2 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; 

}

.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; }

.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}



.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;

}

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}

</style>



	<page pagegroup="new" backtop="2mm" backbottom="25mm" backleft="2mm" backright="3mm">

	<?php include('print_header80x80.php'); ?>

          

<?php include ('convert_currency_to_words.php'); ?>

<?php 

	$query1 = "select * from master_customer where  customercode = '$patientcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		$res1 = mysqli_fetch_array($exec1);

		

		$patientname=$res1['customerfullname'];

		$patientcode=$res1['customercode'];

		$accountname = $res1['accountname'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		

		

		$query67 = "select * from master_accountname where locationcode='$locationcode' and auto_number='$accountname'";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 

		$res67 = mysqli_fetch_array($exec67);

		$accname = $res67['accountname'];

		

		$query1 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and patientcode = '$patientcode' order by auto_number desc limit 0, 1";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		$transactionamount = 0.00;

		

		$res1 = mysqli_fetch_array($exec1);

	     $patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];

		 $transactionmode = $res1['transactionmode'];

	    $transactionamount = $res1['transactionamount'];

	    $transactiondate = $res1['transactiondate'];

		$transactiontime = $res1['transactiontime'];

		$locationname=$res1['locationname'];

		$billnumbercode=$res1['docno'];

		//if transaction mode is split

		 $cashamount=$res1['cashamount'];

		$onlineamount=$res1['onlineamount'];

		$creditamount=$res1['creditamount'];

		$chequeamount=$res1['chequeamount'];

		$cardamount=$res1['cardamount'];

		$remarks=$res1['remarks'];

		

		$mpesanumber=$res1['mpesanumber'];

		$chequenumber=$res1['chequenumber'];

		$chequedate=$res1['chequedate'];

		$bankname=$res1['bankname'];

		$creditcardnumber=$res1['creditcardnumber'];

		$creditcardbankname=$res1['creditcardbankname'];

		$creditcardname=$res1['creditcardname'];

		$onlinenumber=$res1['onlinenumber'];

		//ends here

		

	    $transactiondate = strtotime($transactiondate);

		

	  $transactionamount=number_format($transactionamount,2,'.',',');

	   $transactionamountinwords = covert_currency_to_words($transactionamount); 



		?>





<table width="100%" border="0" align="center" cellpadding="2" cellspacing="5">





	<tr>

    <td class="bodytext37" width="">Name : </td>

    <td width="" class="bodytext36" ><?php echo $patientname; ?></td>

	  <td width="50%" class="bodytext37">Rec. No: </td>

      <td width="50%" class="bodytext36"><?php echo $billnumbercode; ?></td>

		

	</tr>

	<tr>

		<td  align="left" class="bodytext37" >Reg No: </td>

        <td width="50%"   align="left" class="bodytext36" ><?php echo $patientcode; ?></td>

        <td width="50%"  class="bodytext37">Date: </td>

        <td width="50%" class="bodytext36"><?php echo date('d/m/Y',$transactiondate); ?></td>

	</tr>

</table>

<table width="100%" align="center" border="" cellspacing="5" cellpadding="0">

<tr>

			<td class="bodytext38" colspan="3" ><strong>Deposit Amount: </strong><?php echo $transactionamount; ?></td>

  </tr>



<tr>

			<td colspan="3" class="bodytext40" >Remarks: <strong><?php echo nl2br($remarks); ?></strong></td>

			

          

</tr>

<tr>

  <td class="bodytext bodytext37" colspan="3">Payment Mode :</td>

</tr>





<tr>

			<td class="bodytext38" >Cash: </td>

			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($cashamount,2,'.',','); ?></td>

            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>

  </tr>



<tr>

			<td class="bodytext38" >Online: </td>

			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($onlineamount,2,'.',','); ?></td>

            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>

  </tr>



<tr>

			<td class="bodytext38" >Mobile Money: </td>

			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($creditamount,2,'.',','); ?></td>

            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>

  </tr>

<tr>

			<td class="bodytext38" >Cheque: </td>

			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($chequeamount,2,'.',','); ?></td>

            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>

  </tr>



<tr>

			<td class="bodytext38" >Credit Card: </td>

			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($cardamount,2,'.',','); ?></td>

            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>

  </tr>

<tr>

			<td class="bodytext38" >&nbsp;</td>

			<td nowrap="nowrap" align="right" class="bodytext36">&nbsp;</td>

            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>

  </tr>

		<tr>

		<td class="bodytext36" colspan="3"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$transactionamountinwords); ?></td>

	</tr>



<tr>

  <td class="bodytext36" align="right" colspan="2"><strong>Served By: </strong><?php echo strtoupper($username); ?></td>

</tr>

</table>

</page>

<?php	



    $content = ob_get_clean();



    // convert in PDF

 

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

		

        $html2pdf->Output('print_advancedeposit.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

	?>