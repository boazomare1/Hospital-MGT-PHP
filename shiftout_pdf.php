<?php
session_start();
if(!isset($_SESSION['companyanum'])){ 
 header('Location : logout1.php');
  exit;
}

ob_start();

ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');
$currtime = date('H:i:s');

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d ');

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$temp = 0;

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$docno=$_SESSION["docno"];




$pharmacy_fxrate=2872.49;



// $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

// 	$exec = mysql_query($query) or die ("Error in Query1".mysql_error());

// 	$res = mysql_fetch_array($exec);


//  	$locationname = $res["locationname"];

// 	$locationcode = $res["locationcode"];



?>



<?php

function roundTo($number, $to){ 

    return round($number/$to, 0)* $to; 

} 



?>



<?php
$username_get=$_GET['username'];

		$query31 = "SELECT * from shift_tracking where username = '$username_get'  order by auto_number desc limit 1";

			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exe31);

			 $res31anum = $res31["auto_number"];

			 $shiftstarttime = $res31["shiftstarttime"];
			 $shiftouttime = $res31["shiftouttime"];
			 $physical_cash = $res31["physical_cash"];



		

?>

<style type="text/css">

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

	font-family:Arial, Helvetica, sans-serif;

}

.underline {text-decoration: underline;}

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}



</style>



<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

 <?php  include('print_header_pdf.php'); ?>

    

<!--<page_footer>

  <div class="page_footer" style="width: 100%; text-align: center">

                    <?= $footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; ?>

                </div>

    </page_footer>-->


 

		   <?php 



		   ?> 

			
<div style="margin: 0px 30px 0px 60px;"> <hr></div>
<!-- <h4 align="center">CLEARANCE FORM</h4> -->
<div style="margin: 0px 30px 0px 80px;"> 
	<br>
    	<p ><b >Date : <?php echo date("l\, jS F\, Y");  ?>.</b></p>
	<br>
<p>Dear : <b><?=ucwords($username_get); ?>,</b></p>
</div>
	
 
	<br>
	<br>
	<div style="margin: 40px 30px 80px 80px;"> 
		<p style="text-align: justify; width: 80%; line-height: 1.6;">You have successfully Shifted Out with Shift ID <?=$res31anum;?> at <?=$shiftstarttime;?>  and <?=$shiftouttime;?>.<br>
You have submitted <b>KES <?=$physical_cash; ?></b> for reconciliation with the Incharge in duty.</p>
		 
		 
</div>
<div style=" margin: 10px 30px 10px 80px;  ">
 <p>Wishing you a Nice time, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Haned Over To:</p>

<p>From  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Singnature:
<br>
<br>
<?=$locationname; ?> MANAGEMENT. </p>

	 
</div>

 
 

</page>

<?php	

/*require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4");

$dompdf->render();

$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("Arial", "normal");

$canvas->page_text(544, 1628,"1/21", $font, 10, array(0,0,0));

$canvas->page_text(272, 814," Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("FinalBill.pdf", array("Attachment" => 0)); */

?>

<?php

$content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_ip_final.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

