<?php
ob_start();
session_start();
//error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
 $updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$recorddate = date('Y-m-d');



//if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
//if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }


if($visitcode!='' && $patientcode!='')
{
	
	$query8 = "select * from ipconsentform where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums8 = mysqli_num_rows($exec8);
	if($nums8 > 0)
	{
	$res8 = mysqli_fetch_array($exec8);
	//$res8billdate=$res8['billdate'];
	$res8paymentmode = $res8['billtype'];
	//$res8patientfullname = $res8['customername'];
	$res8patientcode = $res8['patientcode'];
	$res8visitcode = $res8['visitcode'];
	$res8locationcode = $res8['locationcode'];
	$res8billtype = $res8['billtype'];
	$res8account = $res8['accountname'];
	$res8surgeon = $res8['surgeon'];
	$res8anaesthetist = $res8['anaesthetist'];
	$res8doctor = $res8['doctor'];

    }
	else
	{
	$res8billdate= '';
	$res8paymentmode = '';
	$res8patientfullname = '';
	$res8patientcode = '';
	$res8visitcode = '';
	$res8billtype = '';
	$res8account = '';
	$res8surgeon = '';
	$res8anaesthetist = '';
	$res8doctor = '';
	}
}

if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
//$locationcode = $_REQUEST["locationcode"];
//$docnumber=$_REQUEST["docnumber"];
}


//$frm1submit1 = $_REQUEST["frm1submit1"];
//
//if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
////$st = $_REQUEST["st"];
//if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
////$banum = $_REQUEST["banum"];
//if ($st == '1')
//{
//	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
//	$bgcolorcode = 'success';
//}
//if ($st == '2')
//{
//	$errmsg = "Failed. New Bill Cannot Be Completed.";
//	$bgcolorcode = 'failed';
//}

?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
$patientgender=$execlab['gender'];
$patientname = $execlab['customerfullname'];
$billtype = $execlab['billtype'];
$patienttype=$execlab['maintype'];
$patientaccount=$execlab['accountname'];
$dateofbirth=$execlab['dateofbirth'];
$locationcode = $execlab['locationcode'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];

$query19=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ");
$exec19=mysqli_fetch_array($query19);
$res19ward=$exec19['ward'];
$res19bed=$exec19['bed'];

$query30=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ward where auto_number='$res19ward' ");
$exec30=mysqli_fetch_array($query30);
$res30ward=$exec30['ward'];

$query31 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_bed where auto_number='$res19bed' ");
$exec31=mysqli_fetch_array($query31);
$res31bed=$exec31['bed'];

$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$ipdate = $res66['consultationdate'];
?>
<table width="89%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber" style="border-collapse: collapse">
  <tbody>
    <tr >
      <td colspan="12"  class="bodytext32"><strong>Patient Details</strong></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td  align="left" valign="middle"   class="bodytext3"><span class="bodytext32"> <strong>Patient * </strong></span></td>
      <td colspan="5"  align="left" valign="middle"  class="bodytext3"><input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden">
        <?php echo $patientname; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td width="8%" align="left" valign="middle"   class="bodytext3"><strong>Patientcode</strong></td>
      <td width="13%" align="left" valign="middle"   class="bodytext3"><input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden">
        <?php echo $patientcode; ?></td>
      <td width="8%"  align="left" valign="middle"    class="bodytext3"><strong>Visitcode</strong></td>
      <td  colspan="4" align="left" valign="middle"   class="bodytext3"><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />
        <?php echo $visitcode; ?></td>
      <td width="9%" align="left" valign="middle"   class="bodytext3"><strong>Date</strong></td>
      <td  align="left" valign="middle"   class="bodytext3"><strong> </strong>
        <input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
        <?php echo $dateonly; ?></td>
      <!--<td width="6%" align="left" valign="middle"   class="bodytext3"><strong>Doc No&nbsp;&nbsp;</strong></td>
				<td width="8%" align="left" valign="middle"   class="bodytext3"><strong> </strong><?php echo $billnumbercode; ?>
                  <input type="hidden" name="billno2" id="billno2" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/></td>-->
    </tr>
    <tr>
      <td height="25" align="left" valign="middle"   class="bodytext3"><strong>Age </strong></td>
      <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?>
        <input type="hidden" name="age" id="age" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;" size="45"></td>
      <td align="left"  valign="middle" class="bodytext3"><strong>Account</strong></td>
      <td align="left"  colspan="4" valign="middle" class="bodytext3"><input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
        <input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
        <?php echo $patientaccount1; ?></td>
      <td width="9%" align="left" valign="middle"   class="style1"><strong>Ward/Bed</strong></td>
      <td width="16%" align="left" valign="middle" class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle" class="bodytext3"><strong><span class="style1">Gender</span></strong></td>
      <td class="bodytext3"><?php echo $patientgender; ?></td>
      <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
      <?php
		         $query131 = "select * from master_location where locationcode = '$locationcode'";
         	     $exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
          		 $res131 = mysqli_fetch_array($exec131);
          		 $locationname = $res131['locationname'];
			?>
      <td align="left" colspan="4" valign="middle" class="bodytext3"><input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
        <?php echo $locationname; ?>
        <input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" ></td>
      <td class="bodytext3"><strong>DOB</strong></td>
      <td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>
      <?php echo $dateofbirth; ?></td>
    </tr>
    <tr>
      <td colspan="12" class="bodytext32"><strong>&nbsp;</strong></td>
    </tr>
</table>
<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
<p>&nbsp;</p>
			
		<p>&nbsp;</p>
		<p>&nbsp;</p>
<p>&nbsp;</p>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="52%" 
            align="left" border="0">
          
          
		        <tr>
				   <td colspan="8" align="left" valign="middle"   class="bodytext3"><span class="bodytext32"><strong>CONSENT FORM </strong></span></td>
          </tr>
				  
				<tr>
				 <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
		  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Surgeon</td>
				  <td colspan="6" align="left" valign="middle" class="bodytext3"><strong>
				    <?php echo $res8surgeon; ?>
				  </strong></td>
		  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Anaesthetist</td>
				  <td colspan="6" align="left" valign="middle" class="bodytext3"><strong>
				   <?php echo $res8anaesthetist; ?>
				  </strong></td>
		  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3"><span class="style2">Doctor</span></td>
				  <td colspan="6" align="left" valign="middle" class="bodytext3"><strong>
                  <?php echo $res8doctor; ?>
                  </strong></td>
		  </tr>
				
				
				<tr>
				 <td height="29" colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
		  </tr>
				
				<tr>
				  <td width="25" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="125" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="264" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                    
				  <td width="25" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="1" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="122" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				</tr>
		       
     
     
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
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Bankreport.pdf", array("Attachment" => 0)); 
?>
