<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

// include("barcode/test.php");

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



if (isset($_REQUEST["patientcode"])) {$patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }



?> 



<style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext3{FONT-WEIGHT: bolder; FONT-SIZE: 15px; COLOR: #000000;  text-decoration:none}

.bodytext4{FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none}

/*td{ height: 14px; }*/

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

$currentdate=date('Y-m-d H:i:s');

$query61 = "select patientname,sampleid, itemname,patientcode,patientvisitcode,recorddate,recordtime from opipsampleid_lab where docnumber = '$patientcode' order by sampleid ASC ";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

$res61 = mysqli_fetch_array($exec61);

$patientname = $res61['patientname'];

$sampleid = $res61['sampleid'];

$itemname = $res61['itemname'];

$patientcode=$res61['patientcode'];

$visitcode=$res61['patientvisitcode'];

$newrecorddate=$res61['recorddate'];

$newrecordtime=$res61['recordtime'];

$sampleanum = substr($sampleid,4);



$sampleanum1 =$sampleanum;

$sampln = strlen($sampleanum);

for($i=$sampln;$i<22;$i++)

{

$sampleanum1 = '0'.$sampleanum1;

}

$query61 = "select sample_id,sampledate from pending_test_orders where patientcode='$patientcode' and visitcode='$visitcode' and sample_id like '%$sampleanum' group by sample_id order by auto_number desc ";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

if(mysqli_num_rows($exec61)>0)

{

while ($res61 = mysqli_fetch_array($exec61))

{

$sampleid=$res61['sample_id'];

$datetime=$res61['sampledate'];

$sampleid = str_replace('-','',$sampleid);

$code = $sampleanum;
?>



    <table width="auto" border="" cellpadding="0" cellspacing="0" align="center">

	

      <tr align="center">

      <td align="center" class="bodytext31"  ><?php echo $patientname; ?> <br></td>

      </tr>
      <tr>
       <td align="center">
          <img src="<?php echo $applocation1; ?>/pdf417_image.php?id=<?= $sampleanum ?>"  width="100%"/>
		</td>
       </tr>

    </table>


 <br>
  <table width="auto" height="" border="" align="center" cellpadding="0" cellspacing="2">
 
  <tr>

  <td   align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >    

        <strong><?= $datetime ?> </strong> </td>

   

  </tr>

 </table>
  



<?php

}

}

else

{

$datetime = $newrecorddate.' '.$newrecordtime;

$sampleid = str_replace('-','',$sampleid);

?>


    <table width="auto" border="" cellpadding="0" cellspacing="0" align="center">

	

      <tr align="center">

      <td align="center" class="bodytext31"  ><?php echo $patientname; ?><br></td>

      </tr>

      <tr>

        <td align="left" > 
          <img src="<?php echo $applocation1; ?>/pdf417_image.php?id=<?= $sampleanum ?>"  width="100%"/>
        </td>

       </tr>

    </table>

 <br>
  <table width="auto" height="" border="" align="center" cellpadding="0" cellspacing="2">
 
  <tr>

  <td   align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext31" >		

				<strong><?= $datetime ?> </strong> </td>

   

  </tr>

 

  

</table>



<?php

}

?>



<?php	


$content = ob_get_clean();



// convert in PDF



try

{

$html2pdf = new HTML2PDF('L', array(28,48),'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

// $html2pdf->setDefaultFont('Arial');

$html2pdf->writeHTML($content, isset($_GET['vuehtml']));



$html2pdf->Output('LabSampleLabel.pdf');

}

catch(HTML2PDF_exception $e) {

echo $e;

exit;

} 
?>