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

 $query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and transactionamount <>'0.00' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount= $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype'and totalamount <> '0.00' and billingdatetime between '$transactiondatefrom' and '$transactiondateto'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount= $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount= $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  if($revenueamount != 0)
			  {
			  $data1[] = $revenueamount;
              $alldepartment1[] = $res2paymenttype.':';
			  }
			}


//print_r($data);

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
print_r($data2);

//print_r($both);

$g->pie_values( $data1, $both,'' );

//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF','#FF00FF','#FFFF00') );

//$g->set_tool_tip( '#val# of #total# <br>#percent# of 100%' );

$g->title( 'Revenue Report By Type', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
