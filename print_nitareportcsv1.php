<?php
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
$colorloopcount = '';


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = date('Y'); }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];
$helbnumber = $res81['helbnumber'];
$employername = $res81['employername'];

ini_set('auto_detect_line_endings',TRUE);
$filename="HELBReport-".$searchmonth."-".$searchyear.".csv";
$list = array();

?>

	<?php
	if($frmflag1 == 'frmflag1')
	{
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
	 
	$totalamount = '0.00';
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
    	$res2employeecode = $res2['employeecode'];
    	$res2employeename = $res2['employeename'];
    
    	$name = trim(preg_replace('/[^A-Za-z0-9 ]/', '', $res2employeename));
    
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
    
    	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
    	$row778 = mysqli_num_rows($query778);
    	if($row778 > 0)
    	{
        	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
        	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
        	$res6 = mysqli_fetch_array($exec6);
        	$passportnumber = $res6['passportnumber'];
        	$pinno = $res6['pinno'];


        	    $totalamount = $totalamount + $componentamount;
        	    $data =  $passportnumber.',';
        	    $data.= $first_name.' '.$last_name.',';
        	    $data.= $pinno.',';        	 
        	 	$data.= '50,';
        	     array_push($list, $data);

    	}
	}
}
ob_end_clean();
$file = fopen($filename,"w")or die('Cannot open the file');;
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
$fp = fopen('php://output', 'w');
ini_set('auto_detect_line_endings',TRUE);
$list=preg_replace('/(\r\n|\r|\n)/s',"\n",$list);
foreach ( $list as $line ) {
$val = explode(",", $line);
fputcsv($fp, $val);
}
$lines = file($filename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$num_rows = count($lines);
foreach ($lines as $line) {
    $csv = str_getcsv($line);
     if (count(array_filter($csv)) == 0) {
        $num_rows--;
    }
}

fclose($fp);
exit();

?>
