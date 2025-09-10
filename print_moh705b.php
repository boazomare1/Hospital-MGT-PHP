<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");


$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d'); 

$location =isset( $_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$selectedmonth=isset($_REQUEST['month'])?$_REQUEST['month']:$transactiondatefrom;
$selectedyear=isset($_REQUEST['year'])?$_REQUEST['year']:$transactiondateto;


if ($location!='')
{
	$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	
	$res1location = $res12["locationname"];
	//echo $location;
}
else
{
	$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
	$res1location = $res1["locationname"];
	//$res1locationanum = $res1["locationcode"];
}
?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
-->
</style>      
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;
}
-->
</style>

         <?php 
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$selectedmonth = $_REQUEST["month"];
					$selectedyear = $_REQUEST["year"];
					$daycount = cal_days_in_month(CAL_GREGORIAN,$selectedmonth,$selectedyear);
					
					if($location=='All'){
				$locationcodewise="locationcode like '%%'";
				}else{
				$locationcodewise="locationcode = '$location'";	
				}
		?>	
        		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse; margin-top:50px;" bordercolor="#666666" cellspacing="0" cellpadding="4" width="" align="left" border="1">
                	<tbody>	
                    	 <tr>
                			<td colspan="35" valign="center"  align="center" bgcolor="#ffffff"><strong>OVER 5 YEARS DAILY OUTPATIENT MORBIDITY SUMMARY SHEET</strong></td>
						 </tr>
                          <tr>
                			<td colspan="35" valign="center"  align="center" bgcolor="#ffffff">&nbsp;</td>
						  </tr>
                          <tr>
                            <td colspan="7" valign="center"  align="left"  class="bodytext31"><strong>DISTRICT : <?php echo strtoupper($res1location); ?></strong></td>
                            <td colspan="13" valign="center"  align="left"  class="bodytext31"><strong>FACILITY: <?= strtoupper($res1location) ?></strong></td>
                            <td colspan="5" valign="center"  align="left"  class="bodytext31"><strong>MONTH: <?php echo strtoupper($selectedmonth); ?></strong></td>
                            <td colspan="5" valign="center"  align="left"  class="bodytext31"><strong>YEAR: <?php echo $selectedyear; ?></strong></td>	
                            <td colspan="5" valign="center"  align="left"  class="bodytext31"><strong>M.O.H.705B</strong></td>
                         </tr>
                         <tr>
                            <td colspan="" valign="center"  align="left"  class="bodytext31"></td>
                            <td colspan="34" valign="center"  align="left"  class="bodytext31"><strong>Days of The Month</strong></td>
                        </tr>
                         <tr>
                            <td colspan="2" align="center" valign="center" class="bodytext31" width="5%"><strong>Diseases (New cases only)</strong></td>
                            <?php
                                $no = 1;
                                for($i=0; $i<$daycount; $i++)
                                {
                            ?>	
                                 <td align="center" valign="center" class="bodytext31" width="5%"><strong><?php echo $no; ?></strong></td>	
                                 
                            <?php
                                $no++;		
                                }
                            ?>
                            <td align="center" valign="center" class="bodytext31" width="5%"><strong>TOTAL</strong></td>
                        </tr>
                   <?php
					
					//GET DISEASE NAMES FROM master_icd
					$sno=0;
					$colorloopcount = 0;
					$showcolor = 0;
					$totalvisits = 0;
					
					$old_array=array();
					
					$qrydiseases = "SELECT description FROM `master_icd` group by icdcode";					 
					$execdiseases = mysqli_query($GLOBALS["___mysqli_ston"], $qrydiseases) or die ("Error in qrydiseases".mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($resdiseases = mysqli_fetch_array($execdiseases))
					{
						$rptname = trim($resdiseases["description"]);
						$rptname = addslashes($rptname);

					 	if($rptname==''){
							continue;	
						}		
                     		
						 	
						if(in_array($rptname,$old_array)){
							continue;
						}
						else
						array_push($old_array,$rptname);


							$qryvisitcount01 = "SELECT ci.auto_number as anumber FROM consultation_icd as ci JOIN master_icd as mi on ci.primaryicdcode=mi.icdcode join master_customer mc on ci.patientcode = mc.customercode WHERE ci.primaryicdcode <> '' AND ci.consultationdate like '$selectedyear-$selectedmonth-__' AND mi.description ='$rptname' AND (mc.dateofbirth < ci.consultationdate - INTERVAL 5 YEAR) and ci.$locationcodewise";					 
							$execvisitcount01 = mysqli_query($GLOBALS["___mysqli_ston"], $qryvisitcount01) or die ("Error in qryvisitcount".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($execvisitcount01)==0)
								continue;

						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							//echo "if";
							 $colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							//echo "else";
							$colorcode = 'bgcolor="#ecf0f5"';
						}

	
				?>	
                 <tr>
                    <td colspan="" valign="center"  align="left"  class="bodytext31"><?php echo $sno=$sno+1; ?></td>
                    <td width="80%" colspan="" valign="center"  align="left"  class="bodytext31"><?php echo strtoupper($rptname); ?></td>            
                  
                   <?php 

						$totalvisits = 0;
						for($dateval=1; $dateval<=$daycount; $dateval++)
						{
							if($dateval<10)
							{
								$dateval ="0".$dateval;
							}
							$visitdate = $selectedyear."-".$selectedmonth."-".$dateval;
							//GET VISIT COUNT ON EACH DATE FROM consultation_icd
							$dayvisitcount = 0;
				
							$qryvisitcount1 = "SELECT ci.auto_number as anumber FROM consultation_icd as ci JOIN master_icd as mi on ci.primaryicdcode=mi.icdcode join master_customer mc on ci.patientcode = mc.customercode WHERE ci.primaryicdcode <> '' AND ci.consultationdate = '$visitdate' AND mi.description ='$rptname'  AND (mc.dateofbirth < ci.consultationdate - INTERVAL 5 YEAR) and ci.$locationcodewise";					 
							$execvisitcount1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryvisitcount1) or die ("Error in qryvisitcount".mysqli_error($GLOBALS["___mysqli_ston"]));
							$dayvisitcount=mysqli_num_rows($execvisitcount1);
													
								if($dayvisitcount == "")
								{
									$dayvisitcount = 0;
								}
								
					?>	
                    	<td align="center" valign="center" class="bodytext31" width="5%"><?php echo $dayvisitcount; ?></td>
                 	<?php
							$totalvisits = $totalvisits + $dayvisitcount;
						} //CLOSE -- for($dateval=1; $dateval<=$daycount; $dateval++)
					?>	
                    <td colspan="" valign="center"  align="right"  class="bodytext31"><?php echo $totalvisits; ?></td>
                    </tr>

                 <?php 
					}
					}//close -- while
				 ?> 
                </tbody>
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
        $html2pdf->Output('moh705b.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    } 
?>


