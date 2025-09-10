<?php
ob_start();

session_start();
//error_reporting(0);
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

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

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d', strtotime('-1 month')); }

if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ''; }



?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer .page:after { content: counter(page, upper-roman); }

.page { page-break-after:always; }
</style>
<?php //include("a4pdfheader1.php"); ?>	
	
<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

	<?php include("print_header_pdf.php"); ?>
<div style="margin: 0px 30px 0px 60px;"> <hr></div>


<style type="text/css">
    	
.bodytext3 {
    position: relative;
    padding: 5px 2px;
	font-size:10px;
}

    </style>

	<table  style="border-collapse: collapse;border: 1px solid black; margin: 20px 30px 0px 60px;">
	<tbody>
	
  
	<?php
	$query31 = "select * from print_deliverysubtype where printno = '$printno' and status <> 'deleted' ORDER BY patientname ASC";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 = mysqli_fetch_array($exec31);
	
	$subtype = $res31['subtype'];
	?>
	<tr>
	<td colspan="7" align="left"><strong><?php echo $subtype; ?></strong></td>
	</tr>
	<tr>
	<td colspan="7" align="left">&nbsp;</td>
	</tr>

	<tr >
      <td class="bodytext31"   align="left" valign="left"  width="20"  ><strong>No.</strong></td>
      <td align="left" valign="center"  width="60" class="bodytext31"> <strong>Reg No</strong> </td> 
      <td  class="bodytext31" align="left" valign="center"  width="160"><strong> Patient </strong></td>

      <td class="bodytext31" align="left" valign="center"  width="70"><strong> Bill No </strong></td>
      <td class="bodytext31" align="left" valign="center"  width="70"><strong>Bill Date </strong></td>
      <td class="bodytext31" align="right" valign="center"  width="80"><strong>Amount</strong></td>
	  <td class="bodytext31" align="left" valign="center"  width=""><strong> </strong></td>
  </tr>

	<?php
	$totalamount = '0.00';
	$query3 = "select * from print_deliverysubtype where printno = '$printno' and status <> 'deleted' group by accountnameid ORDER BY patientname ASC";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
		$res3accountname = $res3['accountname'];
		$res3accountnameid = $res3['accountnameid'];

		$query21 = "select auto_number,accountname,id,subtype from master_accountname where  id = '$res3accountnameid' ";
			// and recordstatus <> 'DELETED' 
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$res21accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res21['accountname']);
	?>
	<tr>
	<td colspan="7" align="left">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="7" align="left"><strong><?php echo $res21accountname; ?></strong></td>
	</tr>
	<tr>
	<td colspan="7" align="left">&nbsp;</td>
	</tr>
	<?php	
	$query2 = "select * from print_deliverysubtype where printno = '$printno' and accountnameid = '$res3accountnameid' and status <> 'deleted'  ORDER BY patientname ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		$patientcode = $res2['patientcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['amount'];
		$accountname = $res2['accountname'];
		$subtype = $res2['subtype'];
	
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
	  
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $patientcode; ?></td>
	<td align="left" class="bodytext3"><?php echo $patientname; ?></td>
	<td align="left" class="bodytext3"><?php echo $billno; ?></td>
	<td align="left" class="bodytext3"><?php echo $billdate; ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>	
	<td align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<?php
	}
	}
	?>
	<tr>
	<td colspan="5" align="right" class="bodytext3"><strong>Total :</strong></td>	
	<td align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
	<td align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="7" >
	&nbsp;
	</td>
    </tr>
	<tr>
	<td colspan="7" >
	&nbsp;
	</td>
    </tr>
	<tr>
	<td colspan="7" >
	&nbsp;
	</td>
    </tr>
    <tr>
	<td colspan="7" >
	<div class="page_footer"  style="width: 70%;margin-bottom: 60px; margin: auto; text-align: center">

		   <strong>Despatching Officer</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Receiving Officer</strong>

	</div>
	</td>
    </tr>
	</tbody>
	</table> 
</page>	
	
	
	
<?php	
$content = ob_get_clean();
require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('DeliverysubReport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>