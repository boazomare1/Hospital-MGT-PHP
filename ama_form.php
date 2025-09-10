<?php
session_start();
ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');
error_reporting(1);
include ("db/db_connect.php");

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if(isset($_REQUEST['locationcode'])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$docno=$_SESSION["docno"];
ob_start();


$query2 = "select * from master_location where locationcode = '$locationcode'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$address1 = $res2["address1"];

$address2 = $res2["address2"];

$emailid1 = $res2["email"];

$phonenumber1 = $res2["phone"];

$locationcode = $res2["locationcode"];
$locationname = $res2["locationname"];

?>
<style type="text/css">
body {
    font-family: Verdana, sans-serif; 
	font-size:13px;
	font-weight:100; 
	 text-align: justify;
}
.bodytext31{ font-size:13px; }
.bodytext312{ font-size:9px; }
.bodytext27{ font-size:12px; }
#footer { position: fixed; left: 0px; bottom: 110px; right: 0px; height: 30px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
		font-weight: 800;
}
.test  td{
border:1px solid #CCC;
}
.page_footer
{
	font-family: Arial;
	text-align:center;
	font-weight:bold;
	margin-bottom:50px;
	
}
</style>
<head>
<title>AMA Form</title>
</head>
<div pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
<?php
$query1 = "select patientfullname from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1=mysqli_num_rows($exec1);
while($res1 = mysqli_fetch_array($exec1))
{	
	$patientname=$res1['patientfullname'];
?>
<table width="520" border="0" cellspacing="0" cellpadding="3" >
	     <tr>
			<td  align="center" style="font-size:16px" colspan="2" ><span class="style1"><u>AGAINST MEDICAL ADVICE (AMA FORM)</span></td>
		</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>		
     <tr>
	<td  align="left" valign="middle" bgcolor="#ffffff" colspan="2"
	><p>This is to certify that I,<strong> <?php echo $patientname;?></strong>,
a patient at <strong><?php echo $locationname ;?></strong>, am refusing at my own insistence and without the authority of and against the advice of my attending physician(s)

_______________________________________, request to leave against
medical advice.
<br><br>
The medical risks/benefits have been explained to me by a member of the medical staff and I understand those risks.
<br><br>
I hereby release the medical center, its administration, personnel, and my attending and/or resident physician(s) from any responsibility for all consequences, which may result by my leaving under these circumstances.
</p></td>
	   
	  </tr>	  
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">MEDICAL RISKS</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" >_______Death</td>
	<td align="left" valign="middle" bgcolor="#ffffff" >_______Additional pain and/or suffering</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" >_______Risks to unborn fetus</td>
	<td align="left" valign="middle" bgcolor="#ffffff" >_______Permanent disability/disfigurement</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan ="2" >
	_______Other:____________________________________________________________________________________
	________________________________________________________________________________________________
	________________________________________________________________________________________________
</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">MEDICAL BENEFITS</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">_______ History/physical examination, further additional testing and treatment as indicated.
</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">_______ Radiological imaging such as:
_____CAT scan	____X-rays ____ ultrasound (sonogram)
</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">_______Laboratory testing _____ Potentional admission and/or follow-up</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">_______ Medications as indicated for infection, pain, blood pressure, etc.</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">_______Other:____________________________________________</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">Please return at any time for further testing or treatment</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" >Patient Signature_______________________</td>
	<td align="center" valign="middle" bgcolor="#ffffff" >Date_______________</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" >Physician Signature_____________________</td>
	<td align="center" valign="middle" bgcolor="#ffffff" >Date_______________</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" >Witness ______________________________</td>
	<td align="center" valign="middle" bgcolor="#ffffff" >Date_______________</td>
</tr>
</table>




	</div>

<?php	
}
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();	
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 814, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("AMA Form.pdf", array("Attachment" => 0)); 

?>