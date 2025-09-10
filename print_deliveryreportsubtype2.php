<?php
ob_start();
session_start();
//error_reporting(0);
set_time_limit(0);
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$updatetime = date('H:i:s');
$currtime = date('H:i:s');

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d ');

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";
$month = date('M-Y');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d', strtotime('-1 month')); }

if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ''; }
if (isset($_REQUEST["accname"])) { $accname = $_REQUEST["accname"]; } else { $accname = ''; }

if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];



if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }

$query31 = "select locationcode from completed_billingpaylater where printno = '$printno' ";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res31 = mysqli_fetch_array($exec31);
	
	$locationcode=$res31['locationcode'];
?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}

</style>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

	<?php include("print_header_pdf.php"); ?>

<page_footer>

  <div class="page_footer"  style="width: 70%;margin-bottom: 20px; margin: auto; text-align: center">

                    <?= $footer=$locationname.' | '.$address1.' | '.$address2.' | '.$phone.' | '.$email.' | '.$website; ?>

                </div>

    </page_footer>
    <?php
	$query31 = "select * from completed_billingpaylater where printno = '$printno' ";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num12=mysqli_num_rows($exec31);
    if($num12>0){
	$res31 = mysqli_fetch_array($exec31);
	
	$subtype = $res31['subtype'];
	$locationnameget = $res31['locationname'];
	$batch = $res31['batch'];
	?>
   <div style="margin: 0px 30px 0px 60px;"> <hr></div>
    <div style="margin: 0px 30px -20px 60px;">
    	  <!-- date("l jS \of F Y h:i:s A") -->
    	<!-- <p>Date : <?=date(DATE_RFC850); ?></p> -->
    	
    	<p ><b >Date : <?php echo date("l\, jS F\, Y");  ?>.</b></p>
    	<p><b>To: <?=$subtype; ?></b>  </p>
    </div>
     <div style="margin: 0px 10px 0px 600px;">
    	
    	<p><b>Doc No: <?=$batch; ?></b>  </p>
    </div>
    <h4 align="center" style="text-decoration: underline;">INVOICES / DOCUMENTATION DISPATCH</h4>
     <!-- border-bottom:1px solid black; padding-bottom:2px; -->

     <div style="margin: 0px 30px 0px 60px;">
    	 <P style="text-align: justify; width: 80%; line-height: 1.6;">Please find enclosed the following invoice(s) and supporting documents. Kindly confirm receipt with stamp and signature and return a copy of this cover letter for our records.</P>
    </div>
    <style type="text/css">
    	
.td_class {
    border: 1px solid black;
    position: relative;
    padding: 5px 2px;
	font-size:10px;
}

    </style>

<table style="border-collapse: collapse;border: 1px solid black; margin: 20px 30px 0px 60px;" >
 
    
   
    <tr >
      <td class="td_class"   align="left" valign="left"   ><strong>No.</strong></td>
      <!-- <td align="left" valign="center"  width="60"> <strong>Reg No</strong> </td>   -->
      <td  class="td_class" align="left" valign="center"  width="140"><strong> Patient </strong></td>
	        <td class="td_class"    align="left" valign="left"   width="180"><strong>Account Name  </strong></td>

      <td class="td_class" align="left" valign="center"  width="70"><strong> Bill No </strong></td>
      <td class="td_class" align="left" valign="center"  width="70"><strong>Bill Date </strong></td>
      <td class="td_class" align="right" valign="center"  width="80"><strong>Amount</strong></td>
  </tr>
  
	<?php
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resloc = mysqli_fetch_array($execloc);
	$locshow=0;
		$locationcodecheck = $resloc['locationcode'];
		$locationnamecheck = $resloc['locationname'];
   ?>
	
    <?php
	$totalamount = '0.00';
	$query3 = "select * from completed_billingpaylater where printno = '$printno' group by accountnameid ORDER BY patientname ASC";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($res3 = mysqli_fetch_array($exec3))
	{
		$res3accountname = $res3['accountname'];
		$accountnameid = $res3['accountnameid'];

		/* $query21 = "select auto_number,accountname,id,subtype from master_accountname where  id = '$accountnameid' ";
			// and recordstatus <> 'DELETED' 
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$res21accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res21['accountname']); */

			
	?>
    <!--<tr>
      <td class="td_class" class="td_class"  colspan="6" ><strong><?php echo $res3accountname; ?></strong></td>
    </tr>-->
    <?php
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resloc = mysqli_fetch_array($execloc))
	{ $locshow=0;
		$locationcodecheck = $resloc['locationcode'];

	$query2 = "select * from completed_billingpaylater where locationcode = '".$locationcodecheck."' and printno = '$printno' and accountnameid = '$accountnameid' and completed = 'completed' ORDER BY billdate ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		 $locationcodecheck = $resloc['locationcode'];
		 $locationnamecheck = $resloc['locationname'];
		 
		$patientcode = $res2['patientcode'];
		$visitcode = $res2['visitcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['totalamount'];
		$accountname = $res2['accountname'];
		$subtype = $res2['subtype'];
		
		
			$query21 = "select accountfullname from master_visitentry where  visitcode = '$visitcode'
			UNION ALL 
			select accountfullname from master_ipvisitentry where  visitcode = '$visitcode' ";
			// and recordstatus <> 'DELETED' 
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$res21accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res21['accountfullname']);
	
	$totalamount = $totalamount + $amount;
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	   $locshow=$locshow+1;
	?>
    <?php if($locshow==1) {?>
    <!--<tr class="delivery">
      <td colspan="6" align="left"><strong><?php //echo $locationnamecheck;?></strong></td>
    </tr>-->
    <?php }?>
    <!-- <tr>
    	<td>1</td>
    	<td>1</td>
    	<td>1</td>
    	<td>1</td>
    	<td>1</td>
    	<td>1</td>
    </tr> -->
    <tr <?php echo $colorcode; ?>  >
      <td class="td_class" align="left" ><?php echo $colorloopcount; ?></td>
      <!-- <td class="td_class" align="left"  width="60"><?php //echo $patientcode; ?></td>  -->
      <td class="td_class" align="left"  width="140"><?php echo $patientname; ?></td>
	  <td class="td_class" align="left"  width="180"><?php echo $res21accountname; ?></td>

      <td class="td_class" align="left"  width="30"><?php echo $billno; ?></td>
      <td class="td_class" align="left"  width="20"><?php echo date("d/m/Y",strtotime($billdate)); ?></td>
      <td class="td_class" align="right"  width="100"><?php echo number_format($amount,2,'.',','); ?></td>
    </tr>
    <?php
	 $locshow=$locshow+1;
	}
	}
	}
	?>



    <tr>
      <td  class="td_class" colspan="5" align="right"  ><strong>Total :</strong></td>
      <td class="td_class" align="right"  ><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
    </tr>
    
	<?php
	}
	?>
</table>
 <style type="text/css">
 	.tr_c{
 		padding-top: 30px;
 	}
 	.tr_b{
 		padding-top: 8px;
 	}
 </style>
<table width="100%"  style="margin: 20px 30px 0px 60px;" >
	<tr>
		<td style="padding-right: 130px;">
			<table style="width: 100%;">
				<tr ><td class="tr_c"><b>Verified BY:</b></td></tr>
				<tr  ><td class="tr_b">Name : ________________________</td></tr>
				<tr  ><td class="tr_c">Signature : _____________________</td></tr>
				<tr  ><td class="tr_c"><b>Credit Controller</b></td></tr>
				<tr  ><td class="tr_b">Stamp : </td></tr>
			</table>
		</td>
		<td>
			<table>
				<tr ><td class="tr_c"><b>Received BY:</b></td></tr>
				<tr ><td class="tr_b">Name : ___________________________</td></tr>
				<tr ><td class="tr_c">Signature : ________________________</td></tr>
				<tr ><td class="tr_c"><b>Designation : </b>_____________________</td></tr>
				<tr ><td class="tr_b">Stamp : </td></tr>
			</table>
		</td>
	</tr>
</table>

</page>
<?php	
/*
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("DeliveryReport.pdf", array("Attachment" => 0)); 
*/
	$content = ob_get_clean();
  // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('DeliveryReport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
