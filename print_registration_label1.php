<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

if (isset($_REQUEST["patientcode"])) {$patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

ob_start();

$query1 = "select * from master_company where auto_number = '$companyanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
	$companycode = $res1["companycode"];
	$phonenumber1 = $res1["phonenumber1"];
    $companyname1 = $res1["companyname"];
	
$query2 = "select * from master_customer where customercode ='$patientcode' ";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	
	$res2patientname = $res2["customerfullname"];
	$res2gender = $res2["gender"];
	$res2age = $res2["age"];
	$res2dateofbirth = $res2["dateofbirth"];
	$res2dateofbirth = strtotime($res2dateofbirth);
	$res2mobilenumber = $res2["mobilenumber"];

?>

<table border="0" cellpadding="2" cellspacing="0" width="350" align="center">
<tr>
    <td colspan="3" align="center" valign="center" 
                bgcolor="#ffffff" ><strong>&nbsp;</strong></td>
  </tr>
    
  <tr>
    <td colspan="3" align="center" valign="center" 
                bgcolor="#ffffff" style="border-bottom: solid 1px black; padding-left: 66px; padding-right: 66px; " class="bodytext31" nowrap="nowrap"><strong><?php echo $companyname1." -"."Tel No: "; ?><?php echo $phonenumber1; ?></strong></td>
  </tr>

  <tr>
  	   <td width="60"  align="left" valign="center" nowrap="nowrap" 
                bgcolor="#ffffff" class="bodytext31">		
				<strong>Reg No.</strong>   </td>
   <td width="282" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" id="pcode" >		
				<strong><?php echo $patientcode; ?></strong></td>
  </tr>
  <tr>
  <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong>Name </strong>   </td>
   <td width="282"   align="left" valign="center" nowrap="nowrap" 
                bgcolor="#ffffff" class="bodytext31">		
				<strong><?php echo $res2patientname; ?></strong>   </td>
   </tr>
  <tr>
    <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Gender </strong></td>
    <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong><?php echo $res2gender; ?></strong></td>
  </tr>
  <tr>
  <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Age</strong></td>
   <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong><?php echo $res2age; ?></strong></td>
  </tr>
  <tr>
  <td align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong>DOB </strong>   </td>
   <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?php echo date('d/m/y',$res2dateofbirth); ?></strong>   </td>
   </tr>
  <tr>
  <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong>Phone </strong>   </td>
   <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?php echo $res2mobilenumber; ?></strong>   </td>
   </tr>
</table>


<?php

    $content = ob_get_clean();

   include('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P',array(150,150), 'en', true, 'UTF-8', array(0,0,0,0));
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
        $html2pdf->Output('label.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>