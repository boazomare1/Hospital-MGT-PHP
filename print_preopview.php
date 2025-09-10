<?php
//require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();


include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$errmsg = "";

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
//if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if($visitcode!='' && $patientcode!='')
{
	$query1 = "select * from ip_otrequest where patientvisitcode='$visitcode' and patientcode='$patientcode' and docno = '$docno'";
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
	
	$query6 = "select * from preop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums6 = mysqli_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysqli_fetch_array($exec6);
		$opconsentward = $res6["opconsentward"];
		$opconsenttheatre = $res6["opconsenttheatre"];
		$spconsentward = $res6["spconsentward"];
		$spconsentnot = $res6["spconsentnot"];
		$spconsenttheatre = $res6["spconsenttheatre"];
		$spconsenttheatrenot = $res6["spconsenttheatrenot"];
		$filenotesward = $res6["filenotesward"];
		$filenotestheatre = $res6["filenotestheatre"];
		$tpbpchartward = $res6["tpbpchartward"];
		$tpbpcharttheatre = $res6["tpbpcharttheatre"];
		$treatmentsheetward = $res6["treatmentsheetward"];
		$treatmentsheettheatre = $res6["treatmentsheettheatre"];
		$allergiesward = $res6["allergiesward"];
		$allergiestheatre = $res6["allergiestheatre"];
		$xrayward = $res6["xrayward"];
		$xraywardnot = $res6["xraywardnot"];
		$xraytheatre = $res6["xraytheatre"];
		$haemoglobinward = $res6["haemoglobinward"];
		$haemoglobinwardnot = $res6["haemoglobinwardnot"];
		$haemoglobintheatre = $res6["haemoglobintheatre"];
		$bloodsugarward = $res6["bloodsugarward"];
		$bloodsugarwardnot = $res6["bloodsugarwardnot"];
		$bloodsugartheatre = $res6["bloodsugartheatre"];
		$ucrossmatchward = $res6["ucrossmatchward"];
		$ucrossmatchwardnot = $res6["ucrossmatchwardnot"];
		$ucrossmatchtheatre = $res6["ucrossmatchtheatre"];
		$ucrossmatchtheatrenot = $res6["ucrossmatchtheatrenot"];
		$idbandward = $res6["idbandward"];
		$idbandtheatre = $res6["idbandtheatre"];
		$gownward = $res6["gownward"];
		$gowntheatre = $res6["gowntheatre"];	
		$underclothward = $res6["underclothward"];
		$underclothnot = $res6["underclothnot"];
		$undercloththeatre = $res6["undercloththeatre"];
		$dentureward = $res6["dentureward"];
		$denturenot = $res6["denturenot"];
		$denturetheatre = $res6["denturetheatre"];
		$wighairward = $res6["wighairward"];
		$wighairwardnot = $res6["wighairwardnot"];
		$wighairtheatre = $res6["wighairtheatre"];
		$lensward = $res6["lensward"];
		$lenswardnot = $res6["lenswardnot"];
		$lenstheatre = $res6["lenstheatre"];
		$jewelward = $res6["jewelward"];
		$jewelwardnot = $res6["jewelwardnot"];
		$jeweltheatre = $res6["jeweltheatre"];
		$makeupnailward = $res6["makeupnailward"];
		$makeupnailwardnot = $res6["makeupnailwardnot"];
		$makeupnailtheatre = $res6["makeupnailtheatre"];
		$shavingward = $res6["shavingward"];
		$shavingwardnot = $res6["shavingwardnot"];
		$shavingtheatre = $res6["shavingtheatre"];
		$skinward = $res6["skinward"];
		$skinwardnot = $res6["skinwardnot"];
		$skintheatre = $res6["skintheatre"];
		$intradipward = $res6["intradipward"];
		$intradipwardnot = $res6["intradipwardnot"];
		$intradiptheatre = $res6["intradiptheatre"];
		$nasotubeward = $res6["nasotubeward"];
		$nasotubewardnot = $res6["nasotubewardnot"];
		$nasotubewardtheatre = $res6["nasotubewardtheatre"];
		$catheterward = $res6["catheterward"];
		$catheterwardnot = $res6["catheterwardnot"];
		$cathetertheatre = $res6["cathetertheatre"];	
		$lastvoidward = $res6["lastvoidward"];
		$lastvoidtheatre = $res6["lastvoidtheatre"];
		$temp = $res6["temp"];
		$c = $res6["c"];
		$p = $res6["p"];
		$r = $res6["r"];
		$bp = $res6["bp"];
		$dipstickward = $res6["dipstickward"];
		$lastfeedward = $res6["lastfeedward"];
		$premedward = $res6["premedward"];
		$timeward = $res6["timeward"];
		$hivwardpos = $res6["hivwardpos"];
		$hivwardneg = $res6["hivwardneg"];
		$hivwardnot = $res6["hivwardnot"];
		$anaesthetist = $res6["anaesthetist"];
		$reviewnotes = $res6["reviewnotes"];
		$username = $res6["username"];
	}
	else
	{
		$opconsentward = '';
		$opconsenttheatre = '';
		$spconsentward = '';
		$spconsentnot = '';
		$spconsenttheatre = '';
		$spconsenttheatrenot = '';
		$filenotesward = '';
		$filenotestheatre = '';
		$tpbpchartward = '';
		$tpbpcharttheatre = '';
		$treatmentsheetward = '';
		$treatmentsheettheatre = '';
		$allergiesward = '';
		$allergiestheatre = '';
		$xrayward = '';
		$xraywardnot = '';
		$xraytheatre = '';
		$haemoglobinward = '';
		$haemoglobinwardnot = '';
		$haemoglobintheatre = '';
		$bloodsugarward = '';
		$bloodsugarwardnot = '';
		$bloodsugartheatre = '';
		$ucrossmatchward = '';
		$ucrossmatchwardnot = '';
		$ucrossmatchtheatre = '';
		$ucrossmatchtheatrenot = '';
		$idbandward = '';
		$idbandtheatre = '';
		$gownward = '';
		$gowntheatre = '';	
		$underclothward = '';
		$underclothnot = '';
		$undercloththeatre = '';
		$dentureward = '';
		$denturenot = '';
		$denturetheatre = '';
		$wighairward = '';
		$wighairwardnot = '';
		$wighairtheatre = '';
		$lensward = '';
		$lenswardnot = '';
		$lenstheatre = '';
		$jewelward = '';
		$jewelwardnot = '';
		$jeweltheatre = '';
		$makeupnailward = '';
		$makeupnailwardnot = '';
		$makeupnailtheatre = '';
		$shavingward = '';
		$shavingwardnot = '';
		$shavingtheatre = '';
		$skinward = '';
		$skinwardnot = '';
		$skintheatre = '';
		$intradipward = '';
		$intradipwardnot = '';
		$intradiptheatre = '';
		$nasotubeward = '';
		$nasotubewardnot = '';
		$nasotubewardtheatre = '';
		$catheterward = '';
		$catheterwardnot = '';
		$cathetertheatre = '';	
		$lastvoidward = '';
		$lastvoidtheatre = '';
		$temp = '';
		$c = '';
		$p = '';
		$r = '';
		$bp = '';
		$dipstickward = '';
		$lastfeedward = '';
		$premedward = '';
		$timeward = '';
		$hivwardpos = '';
		$hivwardneg = '';
		$hivwardnot = '';
		$anaesthetist = '';
		$reviewnotes = '';
		$username = '';
	}
}
?>


      
      
      

  

<table width="auto"  border="" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            
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
         
         <table width="auto" height="282"   border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">   
              <tr>
                <td  class="bodytext3" colspan="8"><strong>Pre-Operative Check </strong></td>
                <td colspan="2"  class="bodytext3">&nbsp;</td>
           </tr>
              <tr>
                <td colspan="14" align="left" valign="middle">&nbsp;</td>
              </tr>
              
              
				<tr>
				  <td colspan="2" align="left" valign="middle"   class="bodytext3"><strong>PRE-OPERATIVE CHECK </strong></td>
				  <td colspan="6" align="left" valign="middle"  ><span class="bodytext3"><strong>CHECK THE APPROPRIATE RESPONSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"   class="bodytext3"><strong>&nbsp;</strong></td>
		   </tr>
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>FORMS, CHARTS, E.T.C. PRESENT </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3"><strong>WARD NURSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>THEATRE NURSE </strong></td>
		   </tr>
				<tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Operation Consent </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"><?php if($opconsentward == '1') echo 'Yes'; ?></td>
                
                
             
              
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php if($opconsenttheatre == '1') echo 'Yes'; ?> </td>
                </tr>
				  <tr>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Parent/Guardian spouse's consent </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($spconsentward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($spconsentnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R</span></td>
                <td width="18%" align="left" valign="middle"  bgcolor="#"> <?php if($spconsenttheatre == '1') echo 'Yes'; ?> </td>
                <td width="17%" align="left" valign="middle"  bgcolor="#"> <?php if($spconsenttheatrenot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
				  </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">File with complete notes </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"> <?php if($filenotesward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $filenotestheatre; ?> </td>
           </tr>
             
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">TPR and BPChart </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"><?php if($tpbpchartward == '1') echo 'Yes'; ?></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $tpbpcharttheatre; ?></td>
           </tr>
               <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Treatment Sheet </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"><?php if($treatmentsheetward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $treatmentsheettheatre; ?></td>
           </tr>
                
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Allergies Noted </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"> <?php if($allergiesward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $allergiestheatre; ?></td>
           </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">X-Rays</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($xrayward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($xraywardnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $xraytheatre; ?></td>
           </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Haemoglobin Results </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php echo $haemoglobinward; ?> 
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($haemoglobinwardnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $haemoglobintheatre; ?></td>
           </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Blood Sugar Results </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                 <?php echo $bloodsugarward; ?>
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php if($bloodsugarwardnot == '1') echo 'Yes'; ?> 
</span><span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $bloodsugartheatre; ?></td>
           </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">No. of Units Cross-Matched</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php echo $ucrossmatchward; ?>
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($ucrossmatchwardnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $ucrossmatchtheatre; ?></td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php if($ucrossmatchtheatrenot == '1') echo 'Yes'; ?>
                  N/R</td>
              </tr>
              
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>PATIENT PREPARATION COMPLETED </strong></td>
	       </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Identification band </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"> <?php if($idbandward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"> <?php if($idbandtheatre == '1') echo 'Yes'; ?> </td>
           </tr>
				
				   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Theatre Gown </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#"> <?php if($gownward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $gowntheatre; ?></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Personal Items Removed or Absent </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
           </tr>
				 <tr>
                <td width="2%" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td width="22%" align="left" valign="middle"  bgcolor="#" class="bodytext3">Underclothes</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($underclothward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($underclothnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $undercloththeatre; ?></td>
                </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Dentures</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($dentureward == '1') echo 'Yes'; ?> </td>
				
                <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($denturenot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $denturetheatre; ?></td>
           </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Wig and Hairpins </td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($wighairward == '1') echo 'Yes'; ?> </td>
				    <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($wighairwardnot == '1') echo 'Yes'; ?>
                            <span class="bodytext3">N/R </span></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $wighairtheatre; ?></td>
             </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Contact Lenses</td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($lensward == '1') echo 'Yes'; ?> </td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($lenswardnot == '1') echo 'Yes'; ?> 
					      <span class="bodytext3">N/R</span></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $lenstheatre; ?></td>
             </tr>
				
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Jewellery</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($jewelward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($jewelwardnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php echo $jeweltheatre; ?>
                </span></td>
           </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#" class="bodytext3">Make Up and Nail Varnish </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"><?php if($makeupnailward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($makeupnailwardnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php echo $makeupnailtheatre; ?>
                </span></td>
           </tr>
              
              <tr>
                <td colspan="2" align="middle"  bgcolor="#"><div align="left"><span class="bodytext3">Shaving</span></div></td>
                <td colspan="4" align="middle"  bgcolor="#">
				  <div align="left">
				     <?php if($shavingward == '1') echo 'Yes'; ?>
				  </div></td>
                <td colspan="2" align="middle"  bgcolor="#">
                <div  align="left">
                  <?php if($shavingwardnot == '1') echo 'Yes'; ?>
                  <span class="bodytext3">N/R </span></div></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $shavingtheatre; ?></td>
           </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Skin Preparation </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($skinward == '1') echo 'Yes'; ?></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($skinwardnot == '1') echo 'Yes'; ?>
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                  <?php echo $skintheatre; ?>
                </span></td>
           </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Intravenous Drip In Place </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($intradipward == '1') echo 'Yes'; ?> </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($intradipwardnot == '1') echo 'Yes'; ?> 
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
                 <?php echo $intradiptheatre; ?>
                </span></td>
           </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Naso-Gastric Tube In Place </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($nasotubeward == '1') echo 'Yes'; ?> </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"> <?php if($nasotubewardnot == '1') echo 'Yes'; ?> 
			       <span class="bodytext3">N/R</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			      <?php echo $nasotubewardtheatre; ?>
			     </span></td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Catheter In Place </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#"> <?php if($catheterward == '1') echo 'Yes'; ?> </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($catheterwardnot == '1') echo 'Yes'; ?> 
			       <span class="bodytext3">N/R </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $cathetertheatre; ?>
			     </span></td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Time of Last Void </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $lastvoidward; ?>
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $lastvoidtheatre; ?>
			     </span></td>
	       </tr>
			   <tr>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Vital Signs </td>
			     <td width="5%" align="left" valign="middle"  bgcolor="#">
			       <span class="bodytext3">Temp</span></td>
			     <td width="5%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			      <?php echo $temp; ?>
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">C
                     
			     </span></td>
			     <td width="13%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			     <?php echo $c; ?>
			     </span></td>
			     <td width="2%" align="left" valign="middle"  bgcolor="#"><span class="bodytext3"> R                 </span></td>
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
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Dipstick Urinalysis Result </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $dipstickward; ?>
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Time Of Last Feed </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php echo $lastfeedward; ?>
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">Time Pre-Medication Given </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			      <?php echo $premedward; ?>
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">TIME:
			      <?php echo $timeward; ?>
			     </span></td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><p><strong>INFECTION PRECAUTIONS</strong></p></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">HIV TEST</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php if($hivwardpos == '1') echo 'Yes'; ?> 
			     +ve</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><?php if($hivwardneg == '1') echo 'Yes'; ?> 
			       <span class="bodytext3">-ve</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#"><span class="bodytext3">
			       <?php if($hivwardnot == '1') echo 'Yes'; ?> 
			       Not Done </span></td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3">ANAESTHETIST </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#" class="bodytext3">REVIEW NOTES </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $anaesthetist; ?></td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#" class="bodytext3"><?php echo $reviewnotes; ?></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
	       </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#" class="bodytext3"><strong>CHECKED BY:</strong> <?php echo $username; ?> </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#">&nbsp;</td>
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


