<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$searchsuppliername = "";

ob_start();

if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if(isset($_REQUEST['suppliername'])) { $suppliername = $_REQUEST["suppliername"]; } else { $suppliername = ""; }

?>
<style type="text/css">
@page {
	  margin: 0.20in 0.20in 0.20in 0.20in; 
}
body {
    font-family: 'Arial'
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 24px; font-family:Arial, Helvetica, sans-serif; COLOR: #000000; 
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 24px; font-family:Arial, Helvetica, sans-serif; COLOR: #000000; 
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 24px; font-family:Arial, Helvetica, sans-serif; COLOR: #000000; 
}
.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 17px; font-family:Arial, Helvetica, sans-serif; COLOR: #000000; 
}
.bodytext44 {FONT-WEIGHT: bold; FONT-SIZE: 17px; padding-left:8em; font-family:Arial, Helvetica, sans-serif;  COLOR: #000000; 
}
.bodytext45 {FONT-WEIGHT: bold; FONT-SIZE: 13px; font-family:Arial, Helvetica, sans-serif;  COLOR: #000000; 
}
</style>

<table width="374" border="0" cellspacing="1" cellpadding="1" align="center">
      <?php
		$query2 = "select * from master_transactionpharmacy where suppliername = '$suppliername' and docno = '$docno' and transactionmodule = 'PAYMENT' and transactionmode='CHEQUE' group by docno order by auto_number desc";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2 = mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$totalamount=0;
		$transactiondate = $res2['transactiondate'];
		$date = explode(" ",$transactiondate);
		$docno = $res2['docno'];
		$mode = $res2['transactionmode'];
		$chequedate = $res2['chequedate'];
		$suppliername = $res2['suppliername'];
		
			$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res51 = mysqli_fetch_array($exec51);
			$totalamount = $res51['transactionamount'];  
			$chequenumber = $res2['chequenumber'];

			include('convert_currency_to_words.php');
			$convertedwords = covert_currency_to_words1($totalamount); 
		
	 ?>
      
      <tr>
        <td width="20" colspan="2" align="right" valign="center" 
			bgcolor="#ffffff" class="bodytext43"><strong> <?php echo  date("d/m/Y", strtotime($chequedate)); ?></strong></td>
      </tr>
      <tr>
        <td colspan="2" align="right" valign="center" class="bodytext43">&nbsp;</td>
      </tr>
      <tr>
        <td width="309" align="left" valign="center" class="bodytext43"><strong><?php echo  $suppliername; ?></strong></td>
        <td width="65" align="right" valign="center" class="bodytext43"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="center" class="bodytext43">&nbsp;</td>
      </tr>
      <tr>
        <td width="320" colspan="2" align="left" valign="center" class="bodytext44"><strong><?php echo $convertedwords; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2" align="right" valign="center" class="bodytext45"><strong><?php echo  date("d/m/Y", strtotime($updatedate)); ?></strong></td>
      </tr>
</table>

<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$paper_size = array(0,0,480,170);
$dompdf->set_paper($paper_size);
$dompdf->render();
//$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
//$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("SupplierCheque.pdf", array("Attachment" => 0)); 
?>
