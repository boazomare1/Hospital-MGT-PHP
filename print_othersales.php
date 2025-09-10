<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');


if (isset($_REQUEST["billno"])) { $billno = $_REQUEST["billno"]; } else { $billno = ""; }

if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }


include('convert_currency_to_words.php');

$query3118 = "select osno,billdate,totalamount,transactionmode,txnno,username,name from  other_sales_billing where osno='$docno' and billno='$billno'";
$exec3118 = mysqli_query($GLOBALS["___mysqli_ston"], $query3118) or die ("Error in Query3118".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3118 = mysqli_fetch_array($exec3118);
$docno1 = $res3118['osno'];
$consultationdate=$res3118['billdate'];
$totalamount=$res3118['totalamount'];
$transactionmode=$res3118['transactionmode'];
$txnno=$res3118['txnno'];
$res11username=$res3118['username'];
$name=$res3118['name'];
$convertedwords = covert_currency_to_words($totalamount);
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

    <td  colspan="3" class="bodytext33" ><?php echo $name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

	</tr>

	<tr>

    <td class="bodytext32" >Docno : </td>

    <td  colspan="3" class="bodytext33" ><?php echo $docno1; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

	</tr>
    
    <tr>

    <td class="bodytext32" >Bill No : </td>

    <td  colspan="3" class="bodytext33" ><?php echo $billno; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

	</tr>

	<tr>

		 <td class="bodytext32">Bill Date: </td>

        <td class="bodytext33"><?php echo date("d/m/Y", strtotime($consultationdate)); ?></td>

	

<td width="20%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="50%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="20%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td width="10%" class="bodytext32" >&nbsp;&nbsp;&nbsp;&nbsp;</td>

</tr>

<tr>


  <td class="bodytext32 bodytext" style="font-size:10px" colspan="2" width="80">Description</td>
 
 <td class="bodytext32 bodytext" style="font-size:10px" width="35">Units</td>
 
 <td class="bodytext32 bodytext" style="font-size:10px" width="35">Rate</td>
 
 <td class="bodytext32 bodytext" style="font-size:10px" width="35">Amount</td>


</tr>

<?php
$sno=0;
$query3118 = "select description,units,rate,amount from  other_sales_billing where osno='$docno' and billno='$billno'";
$exec3118 = mysqli_query($GLOBALS["___mysqli_ston"], $query3118) or die ("Error in Query3118".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3118 = mysqli_fetch_array($exec3118))
{
$description = $res3118['description'];
$units=$res3118['units'];
$rate=$res3118['rate'];
$amount=$res3118['amount'];
$sno=$sno+1;
?>
<tr>

 <td class="bodytext32" style="font-size:10px" colspan="2" width="80"><?php echo wordwrap($description,40,"<br>\n",TRUE); ?></td>
 
 <td class="bodytext32" style="font-size:10px" width="35"><?php echo $units; ?></td>
 
 <td class="bodytext32" style="font-size:10px" width="35"><?php echo number_format($rate, 2, '.', ','); ?></td>

 <td class="bodytext32" style="font-size:10px" width="35"><?php echo number_format($amount, 2, '.', ','); ?></td>
</tr>
<?php } ?>
</table>



<table width="100%" border="" align="center" cellpadding="1" cellspacing="1">

  

<tr>

    <td class="bodytext32" width="20%">Invoice Amount:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($totalamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr>

    <td class="bodytext32 bodytext" colspan="3">Payment Mode:</td>

  </tr>
  <tr>
   <td class="bodytext32">Transaction Reference:</td>

    <td width="21%" align="right" class="bodytext33"><?php echo $txnno; ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>

  <tr>

    <td class="bodytext32"><?php echo $transactionmode;?> Amount: </td>

    <td width="21%" align="right" class="bodytext33"><?php echo number_format($totalamount,2,'.',','); ?></td>

    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>





  <tr>

    <td colspan="2" class="bodytext33"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

  </tr>

  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>

  <tr>

    <td  colspan="2" align="right" class="bodytext33"><strong>Served By: </strong><?php echo strtoupper($res11username); ?></td>

  </tr>

  <tr>

    <td  colspan="2" width="400" align="right" class="bodytext30	"><?php echo date("d/m/Y", strtotime($consultationdate)); ?> </td>

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

