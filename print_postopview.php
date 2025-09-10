<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$errmsg = "";

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if($visitcode!='' && $patientcode!='')
{
	$query1 = "select * from ip_otrequest where patientvisitcode='$visitcode' and patientcode='$patientcode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1 = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$patientname = $res1['patientname'];
	$patientcode = $res1['patientcode'];
	$visitcode = $res1['patientvisitcode'];
	$accoutname = $res1['accountname'];
	$operation = $res1['surgeryname'];
	$docno = $res1['docno'];
	$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$ward=$res2['ward'];
	$query3 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$wardname = $res3['ward'];
	$query4 = "select * from master_customer where customercode='$patientcode'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$age=$res4['age'];
	$gender=$res4['gender'];
	$query6 = "select * from postop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums6 = mysqli_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysqli_fetch_array($exec6);
		$oprecordtheatre = $res6["oprecordtheatre"];
		$oprecordward = $res6["oprecordward"];
		$ivtheatre = $res6["ivtheatre"];
		$ivward = $res6["ivward"];
		$intrafluidtheatre = $res6["intrafluidtheatre"];
		$intrafluidtheatrenot = $res6["intrafluidtheatrenot"];
		$intrafluidward = $res6["intrafluidward"];
		$postopdrugtheatre = $res6["postopdrugtheatre"];
		$postopdrugtheatrenot = $res6["postopdrugtheatrenot"];
		$postopdrugward = $res6["postopdrugward"];
		$nasotubetheatre = $res6["nasotubetheatre"];
		$nasotubetheatrenot = $res6["nasotubetheatrenot"];
		$nasotubeward = $res6["nasotubeward"];
		$roomobstheatre = $res6["roomobstheatre"];
		$roomobsward = $res6["roomobsward"];
		$preopfilmtheatre = $res6["preopfilmtheatre"];
		$preopfilmtheatrenot = $res6["preopfilmtheatrenot"];
		$preopfilmward = $res6["preopfilmward"];
		$xraytheatre = $res6["xraytheatre"];
		$xraytheatrenot = $res6["xraytheatrenot"];
		$xrayward = $res6["xrayward"];
		$drainstheatre = $res6["drainstheatre"];
		$drainsward = $res6["drainsward"];
		$dressingtheatre = $res6["dressingtheatre"];
		$dressingward = $res6["dressingward"];
		$dressingwardnot = $res6["dressingwardnot"];
		$forleytheatre = $res6["forleytheatre"];
		$forleyward = $res6["forleyward"];
		$nospecimentheatre = $res6["nospecimentheatre"];
		$nospecimenward = $res6["nospecimenward"];
		$specimentypetheatre = $res6["specimentypetheatre"];
		$specimentypeward = $res6["specimentypeward"];
		$investigationtheatre = $res6["investigationtheatre"];
		$investigationward = $res6["investigationward"];
		$username = $res6["username"];

		$temp = $res6["temp"];
		$c = $res6["c"];
		$p = $res6["p"];
		$r = $res6["r"];
		$bp = $res6["bp"];
	}
	else
	{
		$oprecordtheatre = '';
		$oprecordward = '';
		$ivtheatre = '';
		$ivward = '';
		$intrafluidtheatre = '';
		$intrafluidtheatrenot = '';
		$intrafluidward = '';
		$postopdrugtheatre = '';
		$postopdrugtheatrenot = '';
		$postopdrugward = '';
		$nasotubetheatre = '';
		$nasotubetheatrenot = '';
		$nasotubeward = '';
		$roomobstheatre = '';
		$roomobsward = '';
		$preopfilmtheatre = '';
		$preopfilmtheatrenot = '';
		$preopfilmward = '';
		$xraytheatre = '';
		$xraytheatrenot = '';
		$xrayward = '';
		$drainstheatre = '';
		$drainsward = '';
		$dressingtheatre = '';
		$dressingward = '';
		$dressingwardnot = '';
		$forleytheatre = '';
		$forleyward = '';
		$nospecimentheatre = '';
		$nospecimenward = '';
		$specimentypetheatre = '';
		$specimentypeward = '';
		$investigationtheatre = '';
		$investigationward = '';
		$temp = '';
		$c = '';
		$p = '';
		$r = '';
		$bp = '';
	}
}

?>
<table width="auto" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#" id="AutoNumber3" style="border-collapse: collapse">
     
            
            <tr bgcolor="#">
         <td height="66" colspan="1" bgcolor="#" class="bodytext3"><strong>Patient  * </strong></td>
          <td  colspan="5" class="bodytext3" align="left" valign="middle" bgcolor="#"><?php echo $patientname; ?></td>
          </tr>
           
             <tr bgcolor="#">
          <td width="15%" align="left" valign="middle"   class="bodytext3"><strong>Patient Code</strong></td>
          <td width="17%" class="bodytext3" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td  class="bodytext3"><strong>Date </strong></td>
          <td width="16%"  class="bodytext3"><?php echo $transactiondatefrom; ?>
           </td>
          <td width="19%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="15%" align="left" valign="middle" class="bodytext3"><?php echo $wardname; ?></td>
        </tr>
        <tr>
          <td align="left" valign="middle"   class="bodytext3"><span class="style4"></span><strong>Age</strong></td>
            <td align="left" valign="middle" class="bodytext3"><?php echo $age; ?></td>
          <td  align="left" valign="middle"   class="bodytext3"><strong>Visit Code </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Operation</strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $operation; ?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle"   class="bodytext3"><span class="style4"></span><strong> Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"> <?php echo $gender; ?></td>
          <td width="18%" align="left" valign="middle"   class="bodytext3"><strong>Ref. Dr. </strong></td>
		  <td colspan="1" align="left" valign="middle" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="middle" class="bodytext3"><strong>Doc no</strong></td>
		  <td colspan="1" align="left" valign="middle" class="bodytext3"><?php echo $docno; ?></td>
        </tr>
       <tr>
       <td width="510" colspan="6">
       </td>
       </tr> 
       </table>  
 		  <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>


     <table width="auto" height="282" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td bgcolor="#" class="bodytext3" colspan="8"><strong>Post-Operative Check </strong></td>
                <td colspan="2" bgcolor="#" class="bodytext3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="14" align="left" valign="middle">&nbsp;</td>
              </tr>
              
              
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>POST-OPERATIVE CHECK </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3"><strong>CHECK THE APPROPRIATE RESPONSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>CHARTS, RECORDS, E.T.C. PRESENT </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3"><strong> THEATRE NURSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>WARD NURSE</strong></td>
				  </tr>
				<tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Operation Record </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"><?php if($oprecordtheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($oprecordward == '1') echo 'Yes'; ?> </td>
                </tr>
				  <tr>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">IV Fluids and Transfussions Record </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($ivtheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td width="18%" align="left" valign="middle"  bgcolor="#"><?php if($ivward == '1') echo 'Yes'; ?> </td>
                <td width="17%" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
				  </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Nursing Instructions For: </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                </tr>
              <tr>
                <td width="2%" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td width="22%" align="left" valign="middle"  bgcolor="#" class="bodytext3">Intravenous Fluids </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#"> <?php if($intrafluidtheatre == '1') echo 'Yes'; ?> </td>
                <td align="left" valign="middle"  bgcolor="#">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($intrafluidward == '1') echo 'Yes'; ?> </td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Post-Operative Drugs </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#"><?php if($postopdrugtheatre == '1') echo 'Yes'; ?> </td>
                <td align="left" valign="middle"  bgcolor="#"> <?php if($postopdrugtheatrenot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($postopdrugward == '1') echo 'Yes'; ?> </td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Naso-Gastric Tube </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#"> <?php if($nasotubetheatre == '1') echo 'Yes'; ?> </td>
                <td align="left" valign="middle"  bgcolor="#"> <?php if($nasotubetheatrenot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($nasotubeward == '1') echo 'Yes'; ?> </td>
              </tr>
             
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Recovery Room Observations </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                 <?php echo $roomobstheatre; ?>
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $roomobsward; ?></td>
                </tr>
               <tr>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">X-Rays</td>
                 <td colspan="6" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
               </tr>
               <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Pre-Operative Films </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#"><?php if($preopfilmtheatre == '1') echo 'Yes'; ?> </td>
                <td align="left" valign="middle"  bgcolor="#"> <?php if($preopfilmtheatrenot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($preopfilmward == '1') echo 'Yes'; ?> </td>
                </tr>
               <tr>
                 <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                 <td align="left" valign="middle"  bgcolor="#" class="bodytext3">X-Ray Card For Post-Operative Films </td>
                 <td colspan="5" align="left" valign="middle"  bgcolor="#"><?php if($xraytheatre == '1') echo 'Yes'; ?> </td>
                 <td align="left" valign="middle"  bgcolor="#"><?php if($xraytheatrenot == '1') echo 'Yes'; ?> 
                   <span class="bodytext3">N/R</span></td>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php if($xrayward == '1') echo 'Yes'; ?></td>
               </tr>
                
              <tr>
                <td colspan="10" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>DRAINS, DRESSING, E.T.C. PRESENT </strong></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Drains (indicate number) </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($drainstheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $drainsward; ?></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Dressings Dry And Intact </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($dressingtheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($dressingward == '1') echo 'Yes'; ?> </td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($dressingwardnot == '1') echo 'Yes'; ?> 
                  N/R</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Forley Catheter </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($forleytheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php if($forleyward == '1') echo 'Yes'; ?> </td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>OTHER</strong></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
              </tr>
              
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>IF SPECIMEN TO GO WITH PATIENT </strong></td>
			     </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Number Of Specimen (s) </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"> <?php if($nospecimentheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $nospecimenward; ?></td>
                </tr>
				
				   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Type Of Specimen (s)</td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"> <?php if($specimentypetheatre == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $specimentypeward; ?></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Investigations Ordered </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php echo $investigationtheatre; ?>
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $investigationward; ?></td>
                </tr>
				 
			   <tr>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Vital Signs </td>
			     <td width="4%" align="left" valign="middle"  bgcolor="#"><spanp class="bodytext3">
			       <span class="bodytext3">Temp</span></span></td>
			     <td width="6%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $temp; ?>
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">C
                     
			     </span></td>
			     <td width="13%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $c; ?>
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3"> R                 </span></td>
			     <td width="12%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $r; ?> 
			     </span></td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#"><span class="bodytext3">BP                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $bp; ?> 
			     </span></td>
			     <td align="left" valign="middle"  bgcolor="#"><span class="bodytext3"> P                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			      <?php echo $p; ?> 
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     </tr>
			   
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>CHECKED BY:</strong> <?php echo $username; ?></td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>&nbsp;</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>&nbsp;</strong></td>
			     
                 
			   
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

