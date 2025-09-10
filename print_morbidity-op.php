<?php
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
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;
$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;
$colorloopcount=''; 

$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$res1location = $res12["locationname"];

?>

<style type="text/css">
<!--

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;
}
-->
</style>

         <?php 
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					?>
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 
            align="left" border="1">
          <tbody>		 
                 <tr>
                <td colspan="4" valign="center"  align="center" bgcolor="#ffffff"><strong><?= strtoupper($res1location); ?></strong></td>
				</tr>
                 <tr>
                <td colspan="2" valign="center"  align="left" bgcolor="#fff" class="bodytext31">Diagnosis [Morbidity]:OP</td>
                <td colspan="2" valign="center"  align="left" bgcolor="#fff" class="bodytext31">Printed On : <?php echo date('d-m-Y'); ?></td>
				</tr>
                 <tr>
                <td colspan="4" valign="center"  align="left" bgcolor="#ffffff" class="bodytext31"><strong>Period : &nbsp;&nbsp;From &nbsp; <?php echo $ADate1; ?>&nbsp;&nbsp;&nbsp; To &nbsp;<?php echo $ADate2; ?></strong></td>
				</tr>
                <tr>
                <td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="5%"><strong>RANK</strong></td>
				<td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="77%"><strong>DISEASE</strong></td>
				<td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="9%"><strong>NO OF CASES</strong></td>
                <td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="9%"><strong>% TOTAL</strong></td>
				</tr>
                <?php 
				//echo $query1 = "select description,icdcode from master_icd where recorddate between '$ADate1' and '$ADate2' and locationcode='$location' limit 0,50";
				
					if($location=='All'){
					$locationcodewise="and locationcode like '%%'";
					}else{
					$locationcodewise="and locationcode = '$location'";	
					}
				
				$totalcases=1;
				
				 $query02 = "SELECT count(primaryicdcode) as countprimaryicdcode FROM consultation_icd WHERE auto_number IN ( SELECT MAX(auto_number) FROM consultation_icd where consultationdate between '$ADate1' and '$ADate2' $locationcodewise and patientvisitcode not like '%-IP' GROUP BY patientvisitcode ) and consultationdate between '$ADate1' and '$ADate2' $locationcodewise and patientvisitcode not like '%-IP'";

				$exec02 = mysqli_query($GLOBALS["___mysqli_ston"], $query02) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res02 = mysqli_fetch_array($exec02)){
					 $totalcases = $res02['countprimaryicdcode'];
				}
				$data=array();
				$noofcases=array();
				$query2 = "select primaryicdcode,count(primaryicdcode) as countprimaryicdcode from consultation_icd where auto_number IN ( SELECT MAX(auto_number) FROM consultation_icd where consultationdate between '$ADate1' and '$ADate2' $locationcodewise and patientvisitcode not like '%-IP' GROUP BY patientvisitcode ) and consultationdate between '$ADate1' and '$ADate2' $locationcodewise and patientvisitcode not like '%-IP' group by primaryicdcode";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2)){
				$nocases='';
				$nocases=$res2['countprimaryicdcode'];
				$primaryicdcode=$res2['primaryicdcode'];
                $query1 = "select description,icdcode from master_icd where icdcode='$primaryicdcode'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$description = $res1['description'];
				$icdcode = $res1['icdcode'];
					
					if($nocases>0){
					
									$data[] = array('name' => $description, 'noofcases' => $nocases,'total' => number_format (round(($nocases/$totalcases)*100,2),2,'.','')) ;
					}
					
					}
					

				foreach ($data as $key => $row) {
					$name[$key]  = $row['name'];
					$noofcases[$key] = $row['noofcases'];
					$total[$key] = $row['total'];
				}
				
				array_multisort($noofcases, SORT_DESC, $data);
				
				foreach ($data as $key => $row) {

						$colorloopcount = $colorloopcount + 1;
					?>
            		
                <tr>
                <td align="center" valign="center" class="bodytext31"><?php echo $colorloopcount; ?></td>
				<td align="left" valign="center" class="bodytext31"><?php echo $row['name']; ?></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $row['noofcases']; ?></td>
                <td align="right" valign="center" class="bodytext31"><?= $row['total']; ?></td>
				</tr>
                <?php 
					}
				?>
          </tbody>
        </table>
        <?php 
				}
		?>
        
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("Arial", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("print_opmorbiditymortalitysummary.pdf", array("Attachment" => 0));  
?>


