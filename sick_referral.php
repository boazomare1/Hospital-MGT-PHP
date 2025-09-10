<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");

$grandtotal = '0.00';
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$patientcode = '';
$visitcode1='';
$res2username ='';
$custname = '';
$colorloopcount = '';
$sno = '';
$dm='';
$cardiac='';
$hypertension='';
$epilepsy='';
$renal='';
$respiratory='';
$none='';
$other='';
$res7reason = '';

if(isset($_REQUEST['patientcode'])) {$patientcode=$_REQUEST['patientcode']; } else{$patientcode="";}
if(isset($_REQUEST['visitcode'])) {$visitcode = $_REQUEST['visitcode']; } else{$visitcode="";}

$query6 = "select * from master_visitentry where patientcode = '$patientcode'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$res6age = $res6['age'];
$res6gender = $res6['gender'];
$res6patientfullname= $res6['patientfullname'];
$res6patientcode = $res6['patientcode'];
$res6visitcode = $res6['visitcode'];
$res6department = $res6['department'];

$query9 = "select * from master_customer where customercode = '$patientcode' ";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9phonenumber1 = $res9['phonenumber1'];

$query7 = "select * from sick_referral where patientcode = '$patientcode' and visitcode='$visitcode' order by auto_number desc ";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7referredto = $res7['referredto'];
$res7reason = $res7['reason'];
?>
<style type="text/css">
<!--
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
-->
</style>
<table width="500" border="0" cellspacing="0" cellpadding="2">
                
           <tr>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
			<td width="416" align="left">
				<?php
				$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
				$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3showlogo = mysqli_fetch_array($exec3showlogo);
				$showlogo = $res3showlogo['showlogo'];
				if ($showlogo == 'SHOW LOGO')
				{
				?>
				
				<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
				
				<?php
				}
				?>			</td>
			
			<td width="265" align="left"><?php
				echo '<strong>'.$companyname.'</strong>';
				echo '<br>'.$address1.' '.$area.' '.$city;
				echo '<br>'.$pincode;
				if($phonenumber1 != '')
				{
				echo '<br>Phone : '.$phonenumber1;
				}
				?></td>
  </tr>
		
            <tr>
              <td colspan="2"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>REFERRAL LETTER </strong></div></td>
            </tr>
            
			 
            <tr>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">
				<table width="685" border="0">
                
                <tr>
                  <td colspan="3" align="left"><strong>NAME </strong><?php echo $res6patientfullname; ?></td>
                  <td width="218" align="left"><strong>DATE&nbsp;&nbsp;&nbsp;</strong><?php echo date('Y-m-d',strtotime($updatedatetime)); ?></td>
                  </tr>
                <tr>
                  <td width="174" align="left"><strong>Reg No. </strong><?php echo $patientcode; ?></td>
                  <td width="125" align="left"><strong>AGE </strong><?php echo $res6age ; ?></td>
                  <td width="150"><strong>GENDER </strong><?php echo $res6gender ; ?></td>
                  <td><strong>PHONE</strong></td>
                  </tr>
                
                
                <tr>
                  <tH colspan="4" align="left">&nbsp;</th>
                </tr>
                <tr>
                  <tH colspan="4" align="left">Name of Hospital Referred To: <?php echo $res7referredto; ?>
                    <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?></th>
                  </tr>
                
		<?php
		 $query2="select * from master_triage where visitcode = '$visitcode'";
			$exec2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
			$res2=mysqli_fetch_array($exec2);
			$complaints = $res2['complanits'];
			$dm = $res2['dm'];
		            if($dm == '1')
					{
					$dm = 'YES';
					}
					else
					{
					$dm = '';
					}
					$cardiac = $res2['cardiac'];
					if($cardiac == '1')
					{
					$cardiac = 'YES';
					}
					else
					{
					$cardiac = '';
					}
					$hypertension = $res2['hypertension'];
					if($hypertension == '1')
					{
					$hypertension = 'YES';
					}
					else
					{
					$hypertension = '';
					}
					$epilepsy = $res2['epilepsy'];
					if($epilepsy == '1')
					{
					$epilepsy = 'YES';
					}
					else
					{
					$epilepsy = '';
					}
					$respiratory = $res2['respiratory'];
					if($respiratory == '1')
					{
					$respiratory = 'YES';
					}
					else
					{
					$respiratory = '';
					}
					$renal = $res2['renal'];
					if($renal == '1')
					{
					$renal = 'YES';
					}
					else
					{
					$renal = '';
					}
					$none = $res2['none'];
					if($none == '1')
					{
					$none = 'YES';
					}
					else
					{
					$none = '';
					}
					$other = $res2['other'];
					$triagedate = $res2['registrationdate'];
					$triageuser = $res2['user'];
					$smoking = $res2['smoking'];
					if($smoking == '1')
					{
					$smoking = 'YES';
					}
					else
					{
					$smoking = '';
					}
					$alcohol = $res2['alcohol'];
					if($alcohol == '1')
					{
					$alcohol = 'YES';
					}
					else
					{
					$alcohol = '';
					}
					$drugs = $res2['drugs'];
					if($drugs == '1')
					{
					$drugs = 'YES';
					}
					else
					{
					$drugs = '';
					}
					$gravida = $res2['gravida'];
					$para = $res2['para'];
					$abortion = $res2['abortion'];
					$familyhistory = $res2['familyhistory'];
					$surgicalhistory = $res2['surgicalhistory'];
					$transfusionhistory = $res2['transfusionhistory'];
					$lmp = $res2['lmp'];
					$edt = $res2['edt'];
					$bloodgroup = $res2['bloodgroup'];
					$hblevel = $res2['hblevel'];
					$vdrl = $res2['vdrl'];
					$pmtct = $res2['pmtct'];
					$urinalysis = $res2['urinalysis'];
					$gestationage = $res2['gestationage'];
					$noofvisit = $res2['noofvisit'];
					$urinedipstict = $res2['urinedipstict'];
					
	    ?>		
                
                <tr>
                  <tH colspan="4" align="left">&nbsp;</th>
                </tr>
                <tr>
                  <tH colspan="4" align="left">Chief Complaint: </th>
                </tr>
				<tr>
					<td colspan="4" align="left" ><?php echo wordwrap($complaints,105,"<br>\n"); ?></td>
                </tr>
                
				
                <tr>
                  <tH align="left">&nbsp;</th>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <tH align="left">Past Medical History : </th>
                  <td colspan="3">
 				    <span class="bodytext32">
					  <?php if($dm =='YES'){ ?>
				   DM (
				   <label style="color:black;"><?php echo $dm; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($cardiac =='YES'){ ?>
				   Cardiac (<label style="color:black;"><?php echo $cardiac; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hypertension =='YES'){ ?>
				   Hypertension (<label style="color:black;"><?php echo $hypertension; ?></label>)&nbsp;
				   <?php } ?>
				   </span>
				   <br/>
				   <span class="bodytext32">
				       <?php if($epilepsy =='YES'){ ?>
				   Epilepsy (<label style="color:black;"><?php echo $epilepsy; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($renal =='YES'){ ?>
				   Renal (<label style="color:black;"><?php echo $renal; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($respiratory =='YES'){ ?>
				   Respiratory (<label style="color:black;"><?php echo $respiratory; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($none =='YES'){ ?>
				   None (<label style="color:black;"><?php echo $none; ?></label>)&nbsp;
				   <?php } $other = trim($other);?>
				   <?php if($other !=''){ ?>
				   Other (<label style="color:black;"><?php echo $other; ?></label>)
				   <?php } ?>
			      </span></td>
                </tr>
                <tr>
                  <tH align="left">Obsterical History : </th>
                  <td colspan="3" >
				   <span class="bodytext32">
					  <?php if($gravida !=''){ ?>
				   Gravida (<label style="color:black;"><?php echo $gravida; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($para !=''){ ?>
				   Para (<label style="color:black;"><?php echo $para; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($abortion !=''){ ?>
				   Abortion (<label style="color:black;"><?php echo $abortion; ?></label>)&nbsp;
				   <?php } ?>
				   
				    <?php if($lmp !=''){ ?>
				   LMP (<label style="color:black;"><?php echo $lmp; ?></label>)&nbsp;
				   <?php } ?>
				   
				   <?php if($edt !=''){ ?>
				   EDT (<label style="color:black;"><?php echo $edt; ?></label>)&nbsp;
				   <?php } ?>
				  </span>				  </td>
                </tr>
                <tr>
                  <tH align="left">Surgical History : </th>
                  <td colspan="3" >
				    <span class="bodytext32">
					 <?php if($surgicalhistory !=''){ ?>
				   <label style="color:black;"><?php echo $surgicalhistory; ?></label>
				   <?php } ?>
				    </span>				  </td>
                </tr>
                <tr>
                  <tH align="left">Family History : </th>
                  <td colspan="3" >
				    <span class="bodytext32">
					 <?php if($familyhistory !=''){ ?>
				   <label style="color:black;"><?php echo $familyhistory; ?></label>
				   <?php } ?>
				    </span>				  </td>
                </tr>
                <tr>
                  <tH align="left">Intoxications: </th>
                  <td colspan="3" >
				   <span class="bodytext32">
					  <?php if($smoking =='YES'){ ?>
				   Smoking (
				   <label style="color:black;"><?php echo $smoking; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($alcohol =='YES'){ ?>
				   Alcohol (<label style="color:black;"><?php echo $alcohol; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($drugs =='YES'){ ?>
				   Drugs (<label style="color:black;"><?php echo $drugs; ?></label>)&nbsp;
				   <?php } ?>
				    </span>				  </td>
				 </tr>
				 <tr>
                  <tH align="left">Transfusions : </th>
				  <td colspan="3" align="left" valign="top" class="bodytext32">
			<label class="bodytext32">
				  <?php if($transfusionhistory !=''){ ?>
				   <label style="color:black;"><?php echo $transfusionhistory; ?></label>
				   <?php } ?></label>			</td>
		   </tr>
				 <tr>
				   			<?php if(($res6department == 'MCH  CONSULTATION')){?>
				   <tH align="left">Subsequent Visit : </th>
				   <td colspan="3" align="left" valign="middle" class="bodytext32"><?php if($gestationage !=''){ ?>
				   GestationAge (<label style="color:black;"><?php echo $gestationage; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($noofvisit !=''){ ?>
				   NoofVisit (<label style="color:black;"><?php echo $noofvisit; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($urinedipstict !=''){ ?>
				   Urinedipstict (<label style="color:black;"><?php echo $urinedipstict; ?></label>)&nbsp;
				   <?php } ?></td>
			      </tr>
				 <tr>
				   <tH align="left">ANC Profile : </th>
				   <td colspan="3" align="left" valign="middle" class="bodytext32">
				    <?php if($bloodgroup !=''){ ?>
				   BloodGroup (<label style="color:black;"><?php echo $bloodgroup; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hblevel !=''){ ?>
				   HB Level (<label style="color:black;"><?php echo $hblevel; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($vdrl !=''){ ?>
				   VDRL (<label style="color:black;"><?php echo $vdrl; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($pmtct !=''){ ?>
				   PMTCT (<label style="color:black;"><?php echo $pmtct; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($urinalysis !=''){ ?>
				   Urinalysis (<label style="color:black;"><?php echo $urinalysis; ?></label>)&nbsp;
			  <?php } ?>			</td>
			  <?php } ?>
			      </tr>
		   
          
                <tr>
                  <tH align="left">Prescription : </th>
                  </tr>
                <tr>
                  <td colspan="4" ><table width="99%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="22%" align="left" valign="middle" class="bodytext3"><strong>Medicine</strong></td>
                      <td width="12%" align="left" valign="middle"><strong>Dose</strong></td>
                      <td width="8%" align="left" valign="middle"><strong>Freq</strong></td>
                      <td width="11%" align="left" valign="middle"><strong>Days</strong></td>
                      <td width="11%" align="left" valign="middle"><strong>Quantity</strong></td>
                      <td width="12%" align="left" valign="middle"><strong>Route</strong></td>
                      <td width="24%" align="left" valign="middle"><strong>Instructions</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <?php
		    $query6="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6);
			while($res6=mysqli_fetch_array($exec6))
			 {
			$medicinename = $res6['medicinename'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
		    ?>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $medicinename; ?></td>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $dose; ?></td>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $frequencycode; ?></td>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $days; ?></td>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $quantity; ?></td>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $route; ?></td>
                      <td align="left" valign="middle"   class="bodytext3"><?php echo $instructions; ?></td>
                    </tr>
                    <?php } ?>
                  </table></td>
                </tr>
                <tr>
                  <tH colspan="4" align="left">&nbsp;</th>
                </tr>
                <tr>
                  <tH colspan="2" align="left">PHYSICAL EXAMINATION: </th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
				<tr>
					<th colspan="4" align="left">
					<?php
					$query3="select * from master_consultationlist where visitcode = '$visitcode'";
					$exec3=mysqli_query($GLOBALS["___mysqli_ston"], $query3);
					while($res3=mysqli_fetch_array($exec3))
					{
					echo $consultation = $res3['templatedata'];
					//echo "<br />\n";
					}
					?></th>
				</tr>
                <tr>
                  <tH colspan="2" align="left">INVESTIGATIONS : </th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
                <tr>
                  <tH colspan="2" align="left">Lab Tests : </th>
                  <td colspan="2" >
				   <?php
		    $query7="select * from consultation_lab where patientvisitcode = '$visitcode'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['labitemname'];
		    ?>
			<?php echo $labitemname; ?>
			<?php echo "<br>"; ?>
			<?php } ?>				  </td>
                </tr>
                <tr>
                  <tH colspan="2" align="left">Radiology Tests</th>
                  <td colspan="2" >
				    <?php
		    $query8="select * from consultation_radiology where patientvisitcode = '$visitcode'";
			$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			while($res8=mysqli_fetch_array($exec8))
			 {
			$radiologyitemname = $res8['radiologyitemname'];
		    ?>
                <?php echo $radiologyitemname; ?> <?php echo "<br>"; ?>
                <?php } ?>				  </td>
                </tr>
                <tr>
                  <tH colspan="2" align="left">Procedures</th>
                  <td colspan="2" >
				   <?php
		    $query9="select * from consultation_services where patientvisitcode = '$visitcode'";
			$exec9=mysqli_query($GLOBALS["___mysqli_ston"], $query9);
			while($res9=mysqli_fetch_array($exec9))
			 {
			$servicesitemname = $res9['servicesitemname'];
		    ?>
                <?php echo $servicesitemname; ?> <?php echo "<br>"; ?>
                <?php } ?>				  </td>
                </tr>
                <tr>
                  <tH colspan="4" align="left">&nbsp;</th>
                </tr>
                <tr>
                  <tH colspan="4" align="left">DIAGNOSIS : </th>
                  </tr>
                <tr>
                  <tH colspan="4" align="left"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="bodytext31"><strong>Primary Diagnosis: </strong></td>
                    </tr>
                     <tr>
                  <tH colspan="2" align="left">ICD Codes </th>
                  <td colspan="4" >&nbsp;</td>
                </tr>
                    <?php
		    $query4="select * from consultation_icd where patientvisitcode = '$visitcode'";
			$exec4=mysqli_query($GLOBALS["___mysqli_ston"], $query4);
			while($res4=mysqli_fetch_array($exec4))
			 {
			$res4disease = $res4['primarydiag'];
			$res4icdcode = $res4['primaryicdcode'];
			?>
                    <tr>
                      <td width="63%" align="left" valign="middle"  class="bodytext31"><?php echo $res4disease; ?></td>
                      <td width="37%" align="left" valign="middle"  class="bodytext31"><?php echo $res4icdcode; ?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  class="bodytext31">&nbsp;</td>
                      <td align="left" valign="middle"  class="bodytext31">&nbsp;</td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="2" align="left" valign="middle"  class="bodytext31"><strong>Secondary Diagnosis: </strong></td>
                    </tr>
                    <?php
		    $query5="select * from consultation_icd where patientvisitcode = '$visitcode'";
			$exec5=mysqli_query($GLOBALS["___mysqli_ston"], $query5);
			while($res5=mysqli_fetch_array($exec5))
			 {
			$res5disease = $res5['secondarydiag'];
			$res5icdcode = $res5['secicdcode'];
			?>
                    <tr>
                      <td width="63%" align="left" valign="middle" class="bodytext31"><?php echo $res5disease; ?></td>
                      <td width="37%" align="left" valign="middle" class="bodytext31"><?php echo $res5icdcode; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></th>
                  </tr>
                
                <tr>
                  <tH colspan="2" align="left">Treatment Given (IF ANY): </th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
                <tr>
                  <tH colspan="2" align="left">&nbsp;</th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
                <tr>
                  <tH colspan="2" align="left">Reason for Referral : </th>
                  <td colspan="2" ><?php echo $res7reason; ?></td>
                </tr>
                <tr>
                  <tH colspan="2" align="left">&nbsp;</th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
                
                <tr>
                  <tH colspan="2" align="left">Signature : </th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
                
                <tr>
                  <tH colspan="2" align="left">&nbsp;</th>
                  <td colspan="2" >&nbsp;</td>
                </tr>
              </table></td>
            </tr>
</table>


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
        $html2pdf->Output('referral.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

