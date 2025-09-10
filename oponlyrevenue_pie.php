<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();
$alldepartment = array();
$alldepartment1 = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

            $query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			  
			  if($res1consultationamount != 0)
			  {
			  $data1[] = $res1consultationamount;
              $alldepartment1[] = 'Consulation:' ;
			  }
			
			$query5 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5labitemrate = $res5['labitemrate1'];
			
			$query6 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6labitemrate = $res6['labitemrate1'];
			
			$query7 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7labitemrate = $res7['labitemrate1'];
			
			$totallabitemrate = $res5labitemrate + $res6labitemrate + $res7labitemrate;
			
			if($totallabitemrate != 0)
			  {
			  $data1[] = $totallabitemrate;
              $alldepartment1[] = 'Lab:' ;
			  }
			
			$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9radiologyitemrate = $res9['radiologyitemrate1'];
			
			$query10 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10radiologyitemrate = $res10['radiologyitemrate1'];
			
			$query11 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11radiologyitemrate = $res11['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res9radiologyitemrate + $res10radiologyitemrate + $res11radiologyitemrate;
			
			if($totalradiologyitemrate != 0)
			  {
			  $data1[] = $totalradiologyitemrate;
              $alldepartment1[] = 'Radiology:' ;
			  }
			
			$query13 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$res13servicesitemrate = $res13['servicesitemrate1'];
			
			$query14 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14servicesitemrate = $res14['servicesitemrate1'];
			
			$query15 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15servicesitemrate = $res15['servicesitemrate1'];
			
			$totalservicesitemrate = $res13servicesitemrate + $res14servicesitemrate + $res15servicesitemrate ;
			
			if($totalservicesitemrate != 0)
			  {
			  $data1[] = $totalservicesitemrate;
              $alldepartment1[] = 'Services:' ;
			  }
			
			$query17 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17referalitemrate = $res17['referalrate1'];
			
			$query18 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$res18referalitemrate = $res18['referalrate1'];
			
			$totalreferalitemrate = $res17referalitemrate + $res18referalitemrate;
			
			if($totalreferalitemrate != 0)
			  {
			  $data1[] = $totalreferalitemrate;
              $alldepartment1[] = 'Referral:' ;
			  }
//$_SESSION['totalop'] = array_sum($data1);			  
//print_r($data1);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_pie.php' );
//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->bg_colour = '0xFFFFFF';

// PIE chart, 60% alpha
//.
$g->pie(180,'#505050','{font-size: 12px; color: #404040;');
$pie = new pie();

$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
//$g->set_tool_tip( '#val# of #total#<br>#percent# of 100%' );
// pass in two arrays, one of data, the other data labels
//$alldepartment = array('Laboratory', 'Radiology', 'Services');

//print_r($c);
//$alldepartment = array('Cash', 'Direct Credit', 'Insurance', 'Staff', 'Charity');
//$data1 = array( 2,5,9,4,22 );
//$data2 = array( 97,37,52,0,5 );

$c = array_combine($data1, $alldepartment1);

foreach($c as $key => $value) {
  //echo "$key $value".' ';
  $key = number_format($key,2,'.','');
  $both[] = "$value $key".' ';
}
//print_r($data2);

//print_r($both);

$g->pie_values( $data1, $both,'' );

//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF','#FF00FF','#FFFF00') );

//$g->set_tool_tip( '#val# of #total# <br>#percent# of 100%' );

$g->title( 'OP Revenue', '{font-size:18px; color: #d01f3c; text-align:left}' );

echo $g->render();
?>
