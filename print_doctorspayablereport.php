<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$totalat = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;

$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;
$totalammount = 0;
		  


//include ("autocompletebuild_doctor.php");


if (isset($_REQUEST["code"])) { $arraysuppliername = $_REQUEST["code"]; } else { $arraysuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center; text-decoration:underline;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td, th{padding: 5px; }
td{ vertical-align:;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;
font-family:Arial, Helvetica, sans-serif;
}
.width{ max-width:150px;}
.left{text-align:left;}
.right{text-align:right;}
</style>
<page backtop="10mm" backbottom="10mm" backright=6mm backleft="6mm">
<table align="center">
	<tr><td class="logo"><?php echo $companyname;?></td></tr>
    <tr><td class="logo">Doctors Payable Report</td></tr>
</table>

<table  align="center" border="1" width="700">
	
   <tr>
       <td class="bodytextbold" width="80">Bill No</td>
       <td class="bodytextbold"  width="80">Date</td>
       <td class="bodytextbold"  width="80">IP/OP No</td>
       <td class="bodytextbold" width="200">Patient Name</td>
       <td class="bodytextbold"  width="150">Amount</td>
   </tr>
   </table>
   <table  align="left" border="0">
   <tr><td class="bodytext left" colspan="5"><?php echo $arraysuppliername;?></td></tr>
   </table>
   <table  align="center" border="1">
			<?php
		$openingcreditamount = 0;
		$openingdebittamount = 0;
			 $query81 = "SELECT * FROM billing_externalreferal WHERE referalname = '".$arraysuppliername."' and paymentstatus ='unpaid' and billdate BETWEEN '".$ADate1."' AND '".$ADate2."'";
			 $exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res81 = mysqli_fetch_array($exec81))
			 {
				$res81date = $res81['billdate'];
			 $res81patientcode = $res81['patientcode'];
			 $res81billno = $res81['billnumber'];
			 $res81name = $res81['patientname'];
			 $res81amount = $res81['referalrate'];
			 $totalammount += $res81amount;
			 ?>
			 
   <tr>
       <td class="bodytext" width="80"><?php echo $res81billno; ?></td>
       <td class="bodytext" width="80"><?php echo date('d/m/Y',strtotime($res81date)); ?></td>
       <td class="bodytext" width="80"><?php echo $res81billno; ?></td>
       <td class="bodytext left" width="200"><?php echo $res81name; ?></td>
       <td class="bodytext right" width="150"><?php echo number_format($res81amount,2,'.',','); ?></td>
      
   </tr>

			<?php
			 }
			 $query82 = "SELECT * FROM billing_paylaterreferal WHERE referalname = '".$arraysuppliername."' and paymentstatus ='unpaid' and billdate BETWEEN '".$ADate1."' AND '".$ADate2."'";
			 $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die("error in query82: ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res82 = mysqli_fetch_array($exec82))
			 {
				$res82date = $res82['billdate'];
			 $res82patientcode = $res82['patientcode'];
			 $res82name = $res82['patientname'];
			 $res82billno = $res82['billnumber'];
			 $res82amount = $res82['referalrate'];
			 $totalammount += $res82amount;
			 ?>

			 

            <tr>
              <td class="bodytext "  width="80"><?php echo $res82billno; ?></td>
              <td  class="bodytext" width="80"><?php echo date('d/m/Y',strtotime($res82date)); ?></td>
              <td class="bodytext "  width="80"><?php echo $res82billno; ?></td>
              <td class="bodytext left"  width="200"><?php echo $res82name; ?></td>
              <td class="bodytext right"  width="150"><?php echo number_format($res82amount,2,'.',','); ?></td>
				
            </tr>

	
			<?php
			 }
			  $query83 = "SELECT * FROM billing_ipprivatedoctor WHERE description = '".$arraysuppliername."' and billstatus ='unpaid' and recorddate BETWEEN '".$ADate1."' AND '".$ADate2."'";
			 $exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die("error in query83: ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res83 = mysqli_fetch_array($exec83))
			 {
				$res83date = $res83['recorddate'];
			 $res83patientcode = $res83['patientcode'];
			 $res83name = $res83['patientname'];
			 $res83billno = $res83['docno'];
			 $res83amount = $res83['amount'];
			 $totalammount += $res83amount;
			 ?>
			 

           <tr>
              <td class="bodytext"  width="80"><?php echo $res83billno; ?></td>
              <td class="bodytext"  width="80"><?php echo date('d/m/Y',strtotime($res83date)); ?></td>
              <td class="bodytext"  width="80"><?php echo $res83billno; ?></td>
              <td class="bodytext left"  width="200"><?php echo $res83name; ?></td>
              <td class="bodytext right"  width="150"><?php echo number_format($res83amount,2,'.',','); ?></td>
				
            </tr>
	
			<?php
			 }
			?>

	</table>
    <table  align="right" border="" width="">
            <tr>
              	<td class="bodytextbold right" colspan="4" width="600">Grand Total:</td>
				<td class="bodytext right" width="150"><?php echo number_format($totalammount,2,'.',',');?></td>
              
            </tr>
    </table>
	
</page>
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
        $html2pdf->Output('print_doctorspayablereport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
