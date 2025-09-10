<?php
ob_start();
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");

$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$docnumber=$_REQUEST['docnum'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientname=$res78['patientfullname'];
$patientgender=$res78['gender'];
$accountname=$res78['accountname'];

/*$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];*/

		$query31 = "select * from resultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' and acknowledge = 'completed' group by itemname";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$labname1=$res31['itemname'];
		$templatedata=$res31['templatedata'];
		$docnumber=$res31['docnumber'];
?>

<table  cellspacing="0" cellpadding="2" width="752" align="left" border="0">
			 <tr>
              <td width="311" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Patient  </strong><?php echo $patientname; ?></td>
				 <td width="267" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Age  <?php echo $patientage; ?></strong></td>		
				 <td width="162" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Gender  <?php echo $patientgender; ?></strong></td>				
             </tr>
			 <tr>
               <td>&nbsp;</td>	
			 </tr> 
</table>			 		 <?php echo $templatedata;  ?>
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
        $html2pdf->Output('printipinteriminvoice.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>