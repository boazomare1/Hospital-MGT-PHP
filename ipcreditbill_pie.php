<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

$query34 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = '' ";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num1 = mysqli_num_rows($exec34);
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $docnumberr = $res34['docno'];
		   
		   $query36 = "select * from ip_bedtransfer where patientcode= '$patientcode' and visitcode='$visitcode' order by auto_number desc ";
		   $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num36 = mysqli_num_rows($exec36);
		   $res36 = mysqli_fetch_array($exec36);
		   $nbed = $res36['bed'];
		   
           $query35 = "select * from ip_bedallocation where patientcode= '$patientcode' and visitcode='$visitcode' and docno = '$docnumberr' and paymentstatus = '' and creditapprovalstatus = '' ";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res35 = mysqli_fetch_array($exec35);
		   $bednumber = $res35['bed'];
		   $paymentstatus = $res35['paymentstatus'];
		   $creditapprovalstatus = $res35['creditapprovalstatus'];
		   
		     
		   if($num36 > 0)
		     {
			   $bednumber = $nbed; 
			  }
		   
		   $query50 = "select * from master_bed where auto_number='$bednumber'";
		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res50 = mysqli_fetch_array($exec50);
						  $bednames = $res50['bed'];
		 
		  
			include ('ipcreditaccountreport3.php');
			$total = $overalltotal;
		
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $accountname = $res82['accountfullname'];
		   $registrationdate = $res82['registrationdate'];
		   $billtype = $res82['billtype'];
		   $overalllimit = $res82['overalllimit'];
		   //$consultationfee = $res82['admissionfees'];
		   
		     $query83 = "select sum(transactionamount) from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
		     $exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		     $res83 = mysqli_fetch_array($exec83);
			$transactionamount = $res83['sum(transactionamount)'];
			}
			//echo $transactionamount;
$data = array($sumtotalamountcash,$sumtotalamountdirect,$sumtotalamountinsurance,$sumtotalamountstaff,$sumtotalamountcharity);

//print_r($data);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_pie.php' );


$g = new graph();
$g->bg_colour = '0xFFFFFF';

// PIE chart, 60% alpha
//.
$g->pie(180,'#505050','{font-size: 12px; color: #404040;');
$pie = new pie();

$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
// pass in two arrays, one of data, the other data labels
$alldepartment = array('Cash:', 'Direct Credit:', 'Insurance:','Staff','Charity');

$c = array_combine($data, $alldepartment);

//print_r($c);
foreach($c as $key => $value) {
  //echo "$key $value".' ';
  $key = number_format($key,2,'.','');
  $both[] = "$value $key".' ';
}
//print_r($both);

$g->pie_values( $data, $both,'' );

//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF') );

//$g->set_tool_tip( '#val# of #total# <br>#percent# of 100%' );

$g->title( 'IP Final Bill', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
