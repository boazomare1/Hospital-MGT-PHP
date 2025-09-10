<?php
require_once('html2pdf/html2pdf.class.php');

ob_start();
session_start();
include("barcode/test.php");
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];


?> 

<style type="text/css">
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext3{FONT-WEIGHT: bolder; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none}
.bodytext4{FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none}
td{ height: 14px; }
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 23px; COLOR: #000000;  text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 23px; COLOR: #000000;  text-decoration:none
}
.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none
}
.bodytext34 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none
}
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none 
}
.bodytext36 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none 
}
table {
   display: table;
   width:100%;
   table-layout: fixed;
}
body {
	
}

</style>

    

<body onkeydown="escapeke11ypressed()">
<?php 	
if (isset($_REQUEST["patientcode"])) {$patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

	/*$query1 = "select * from master_company where auto_number = '$companyanum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$companyname = $res1["companyname"];
	$address1 = $res1["address1"];
	$area = $res1["area"];
	$city = $res1["city"];
	$pincode = $res1["pincode"];
	$phonenumber1 = $res1["phonenumber1"];
	$phonenumber1 = $res1["phonenumber1"];
	$tinnumber1 = $res1["tinnumber"];
	$cstnumber1 = $res1["cstnumber"];*/
	
$query2 = "select * from master_customer where customercode ='$patientcode' ";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	
	$res2patientname = $res2["customerfullname"];
	
	$res2patientname = $res2["customername"].' '.$res2["customerlastname"];
	$res2gender = $res2["gender"];
	$res2age= $res2["age"];
	$res2dateofbirth = $res2["dateofbirth"];
	$res2dateofbirth = strtotime($res2dateofbirth);
	$res2mobilenumber = $res2["mobilenumber"];
	
$query3 = "select * from master_visitentry where patientcode ='$patientcode' order by auto_number desc limit 0, 1";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
    $res3visitcode = $res3["visitcode"];
	$res3accountfullname = $res3["accountfullname"];
	$res3consultationdate= $res3["consultationdate"];
	$res3consultationdate = strtotime($res3consultationdate);
    $res3consultationtime= $res3["consultationtime"];
	$res3locationcode= $res3["locationcode"];
	$res3subtype = $res3["subtype"];
	/*$query3 = "select * from master_location where patientcode ='$patientcode' order by auto_number desc limit 0, 1";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);*/
    $res3visitcode = $res3["visitcode"];
	$res3username= $res3["username"];
		$query24 = "select subtype from master_subtype where auto_number = '$res3subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	 $subtype = $res4['subtype'];
	?>

	
<table width="auto" height="" border="" align="left" cellpadding="0" cellspacing="2" height="100px">

	
  <tr>
	<td colspan="2" align="left" width="" valign="center" 
	bgcolor="#ffffff"  >
    <table width="auto" border="" cellpadding="0" cellspacing="0" align="center">
	<tr >
		<?php 
		$query2 = "select * from master_location where locationcode = '$res3locationcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
		
		?>
        
        <td align="center" class="bodytext4" colspan="1" width="auto">
		
		<?php
			$strlen2 = strlen($locationname);
			$totalcharacterlength2 = 50;
			$totalblankspace2 = 50 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$locationname = ' '.$locationname.' ';
			}
			?>
            <strong><?php echo "".nl2br($locationname); ?></strong> 
		</td>
        <td align="left" class="bodytext4" colspan="2" width="100"><?php
			$address3 = "Tel: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 60;
			$totalblankspace3 = 60 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
            <strong><?php //echo $address3; ?></strong></td>
        </tr>
        
        
      
      <!--<tr>
    <td align="left" class="bodytext32">
            <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
	<strong><?php echo $address1; ?></strong></td>
  </tr>-->
      <!--<tr>
    <td align="left" class="bodytext32">
            <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
	<strong><?php echo $address2; ?></strong></td>
  </tr>-->
      
      <tr align="left">
        <td align="left" class="bodytext31"  colspan=""><?php
//			$address4 = " E-Mail: ".$emailid1;
//			$strlen3 = strlen($address4);
//			$totalcharacterlength3 = 35;
//			$totalblankspace3 = 35 - $strlen3;
//			$splitblankspace3 = $totalblankspace3 / 2;
//			for($i=1;$i<=$splitblankspace3;$i++)
//			{
//			$address4 = ' '.$address4.' ';
//			}
//			?><img src="<?php echo $applocation1; ?>/barcode/test.php?text=<?php echo $patientcode; ?>" width="0" height="35" /> </td>


                <td align="right" valign="middle" colspan=""
                bgcolor="#ffffff" class="bodytext4" >		
				<strong><?php echo date('d/m/Y',$res3consultationdate); ?></strong></td>
             <td align="left" valign="middle" colspan=""
                bgcolor="#ffffff" class="bodytext4"><strong><?php echo date('g.i A',strtotime($res3consultationtime)); ?></strong></td>
      </tr>
    </table></td>
  </tr>
  
    
  <tr>
  	   <td width="50%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext3" >		
				<strong><?php echo $patientcode; ?></strong>   </td>
                
   <td width="50%" align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext3" >		
				<strong>Case Visit : <?php echo $res3visitcode; ?>&nbsp;&nbsp;&nbsp;</strong></td>
  </tr>
  
  <tr>
  <td align="left" valign="center" width="100" colspan="2"
                bgcolor="#ffffff" class="bodytext4">		
				<strong><?php echo nl2br($res2patientname); ?></strong></td>
   
  </tr>
 
  <tr>
  <td colspan="2" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><?php echo strtoupper($res2gender); ?>&nbsp;&nbsp;&nbsp;<?php echo $res2age." Yrs"; ?></td>
  </tr>
  
  <tr>
  <td   align="left" valign="center" width="auto" colspan="2" 
                bgcolor="#ffffff" class="bodytext31" >		
				<?php echo nl2br($res3accountfullname); ?>  </td>
   
  </tr>
  <tr>
  <td   align="left" valign="center" width="auto"
                bgcolor="#ffffff" class="bodytext31" colspan="2" >		
				<?php echo nl2br($subtype); ?>  </td>
  </tr>
  
  <tr>
  	<td width="150" align="right" valign="center" nowrap="nowrap" colspan="2" 
                bgcolor="#ffffff" class="bodytext31"><?php echo "Reg By: ".strtoupper($res3username); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                
  </tr>
</table>

<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 3.39;
		$height_in_inches = 2.10;
		$width_in_mm = $width_in_inches * 30.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('L', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('opvisitlabel.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>
