<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

//$companyname = $_SESSION["companyname"];

?> 

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext41 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 16px; COLOR: #000000; 

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  }

</style>

<?php 

	

if (isset($_REQUEST["patientcode"])) {  $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $docnumber = $_REQUEST["billnumber"]; } else { $docnumber = ""; }



$itemcode = '';



 $query4 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";

$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$res4 = mysqli_fetch_array($exec4);

$res4itemname = $res4['medicinename'];

//echo $res4docnumber = $res4['docnumber'];



$query13 = "select * from master_medicine where itemname='$res4itemname' ";

$exec13=mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

$res13 = mysqli_fetch_array($exec13);





$query7 = "select patientfullname,locationcode from master_visitentry where patientcode='$patientcode' and visitcode = '$visitcode'";

$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

$res7 = mysqli_fetch_array($exec7);

$res7patientfullname=$res7['patientfullname'];

$locationcode=$res7['locationcode'];
$queryloc = "select * from master_location where locationcode = '$locationcode'";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$companyname = $resloc['locationname'];


$query9 = "select * from pharmacysales_details where patientcode = '$patientcode' and visitcode = '$visitcode' and docnumber = '$docnumber';";

$exec9=mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



while($res9 = mysqli_fetch_array($exec9))

{



$res9instructions = $res9['instructions'];

$res9batchnumber=$res9['batchnumber'];

$res9quantity = $res9['quantity'];

$res9quantity = intval($res9quantity);

$res9itemname = $res9['itemname'];

$res2medicinecode= trim($res9['itemcode']);





$zero='';



$pagecount='';

 $query2 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and medicinecode = '$res2medicinecode' and recordstatus !='deleted' and docnumber = '$docnumber' ";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$num2 = mysqli_num_rows($exec2);

$recorddate='';

 while( $res2 = mysqli_fetch_array($exec2))

   {

$pagecount++;   

$res2dose = $res2['dose'];

$res2patientname = $res2['patientname'];

$res2frequencynumber = $res2['frequencynumber'];

$frequencyauto_number = $res2['frequencyauto_number'];

$dosemeasure = ucwords($res2['dosemeasure']);

$res2days = $res2['days']; 

$res2route = $res2['route'];

$res2instructions = $res2['instructions']; 

$res2itemname = $res2['medicinename'];

$res2itemname = ucwords(strtolower($res2itemname));

$recorddate = $res2['recorddate'];

$phpdate = strtotime($recorddate);







 $query6 = "select expirydate,batchnumber,itemname from purchase_details where batchnumber = '$res9batchnumber' and itemcode = '$res2medicinecode'";

$exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

$res6 = mysqli_fetch_array($exec6);

$res6expirydate=$res6['expirydate'];

$res6batchnumber=$res6['batchnumber'];

$res6expirydate = strtotime($res6expirydate); 

$res6itemname=$res6['itemname'];

$drug_instructions='';
// echo $res2medicinecode;
 $query8 = "select formula,drug_instructions from master_medicine where itemcode='$res2medicinecode'";

$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

$res8 = mysqli_fetch_array($exec8);

$res8formula = $res8['formula']; 
$drug_instructionsanum = $res8['drug_instructions']; 

 $query81 = "select name from drug_instructions where id='$drug_instructionsanum'";
$exec81=mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$drug_instructions = $res81['name']; 
// $drug_instructions=strtoupper($drug_instructions);
if($drug_instructions==''){
  $drug_instructions='Take';
}

$res8formula = trim($res8formula);



 $query11 = "select timely_numeric from master_frequency where auto_number='$frequencyauto_number'";

$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

$res11 = mysqli_fetch_array($exec11);

$timely = $res11['timely_numeric']; 



   ?>

   <?php if($res9quantity!=0) { ?>

   <page>

  <table border="0" cellpadding="0" cellspacing="0" align=''>
  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
     <table border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;"><strong>Qty:<?php echo $res9quantity; ?>&nbsp;Batch : <?php echo $res6batchnumber;?>&nbsp; Exp : <?php echo date('m/y',$res6expirydate);?></strong></td>

  </tr>

  <tr>

    <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong><?php echo ucwords(strtoupper($res2itemname)); ?></strong></td>

    </tr>

	<tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"></td>
    </tr>

  <tr>

 

    <td   align="left" valign="center"

                bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;"><strong><?php //if($res8formula=="INCREMENT") 

				//{ 

				

				//echo "TAKE"."&nbsp;".$res2dose."&nbsp;"."TAB"."&nbsp;".$res2frequencynumber."&nbsp;"."TIMES A DAY FOR"."&nbsp;".$res2days."&nbsp;"."DAYS"."&nbsp;"."&nbsp;"."BY"."&nbsp;".$res2route."&nbsp;";



echo $drug_instructions."&nbsp;".$res2dose."&nbsp;".$dosemeasure."&nbsp;".$timely."&nbsp;"."FOR"."&nbsp;".$res2days."&nbsp;"."DAYS"."&nbsp;"."&nbsp;<br>"."BY"."&nbsp;".$res2route."&nbsp;";				

				//}

				?>

				<?php //if($res8formula=="CONSTANT") 

				//{ 

				//echo "By"."&nbsp;".$res2route."&nbsp;".$res9instructions;

				//}

				

				?>		</strong>		</td>

	</tr>

	<?php if($res2instructions!='') { ?>
	<tr >
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;"><?php echo ucwords(strtoupper($res2instructions)); ?></td>
    </tr>
  
<?php } ?>


 

  <tr>

    <td  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext41"><?php echo $res7patientfullname; ?></td>

    </tr>

	<tr>

    <td   class="bodytext41" valign="center"  

                bgcolor="#ffffff"><?php echo $patientcode; ?>&nbsp;&nbsp;<?php echo $visitcode; ?></td>

  </tr>

  <tr>

    <td  class="bodytext41"  valign="center"  align="left" 

                bgcolor="#ffffff">Date:<?php echo date('d/m/Y ',$phpdate); ?>&nbsp;&nbsp;<?php echo $companyname; ?></td>

  </tr>

 

</table>

</td>

</tr>
 
</table>
</page>

 <?php 

					if($pagecount < $num2)

					{

					?> 

				<?php }

				 ?>		

<?php }  ?>

<?php 

}

}

?>

<?php	

$content = ob_get_clean();



// convert in PDF



try

{

$html2pdf = new HTML2PDF('L', array(50,80),'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

$html2pdf->setDefaultFont('Arial');

$html2pdf->writeHTML($content, isset($_GET['vuehtml']));



$html2pdf->Output('Medicine Label.pdf');

}

catch(HTML2PDF_exception $e) {

echo $e;

exit;

}

?>

