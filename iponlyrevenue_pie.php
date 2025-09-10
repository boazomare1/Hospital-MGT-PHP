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

            $query2 = "select sum(amount) from billing_ipadmissioncharge where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
			$totalipadmissionamount =$res2['sum(amount)'];
			
			$query3 = "select sum(packagecharge) as packagecharge from master_ipvisitentry where consultationdate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3=mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			$totalippackageamount =$res3['packagecharge'];
			
			$query4 = "select sum(amount) from billing_ipbedcharges where description='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num4 = mysqli_num_rows($exec4);
			$res4 = mysqli_fetch_array($exec4);
			$totalbedcharges =$res4['sum(amount)'];
			
			$totalhospitalrevenue = $totalbedcharges + $totalippackageamount + $totalipadmissionamount;
			  
			  if($totalhospitalrevenue != 0)
			  {
			  $data1[] = $totalhospitalrevenue;
              $alldepartment1[] = 'Hospital:' ;
			  }
			
			$query8 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8labitemrate = $res8['labitemrate1'];
			
			
			if($res8labitemrate != 0)
			  {
			  $data1[] = $res8labitemrate;
              $alldepartment1[] = 'Lab:' ;
			  }
		    
			$query12 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12radiologyitemrate = $res12['radiologyitemrate1'];
			
			if($res12radiologyitemrate != 0)
			  {
			  $data1[] = $res12radiologyitemrate;
              $alldepartment1[] = 'Radiology:' ;
			  }
			
		
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			if($res16servicesitemrate != 0)
			  {
			  $data1[] = $res16servicesitemrate;
              $alldepartment1[] = 'Services:' ;
			  }
	
print_r($data1);

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

$g->title( 'IP Revenue', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
