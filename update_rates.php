<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

 ini_set('memory_limit','-1');
$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];

$errmsg = '';

$bgcolorcode = '';

$query = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];

$non_pharm = "SELECT * FROM dummy_doctor group by itemcode ";
			$exec_pharma= mysqli_query($GLOBALS["___mysqli_ston"], $non_pharm) or die("Error in Query_pharma_rate" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res_dummy = mysqli_fetch_array($exec_pharma)) {
			     $item_code=$res_dummy['itemcode'];
			     $costprice=$res_dummy['costprice'];  
			    $salesprice=$res_dummy['salesprice'];
			     $margin=$res_dummy['margin'];
			$fields = array();
			$queryChk = "SHOW COLUMNS FROM master_medicine";
			$execchk = mysqli_query($GLOBALS["___mysqli_ston"], $queryChk) or die("Error in queryChk" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($x = mysqli_fetch_assoc($execchk)) {

				if (stripos($x['Field'], "subtype_") !== false) {
					$fieldname = $x['Field'];
					$query1 = "update master_medicine set $fieldname='$salesprice' where itemcode='$item_code'";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
			$query2 = "update master_medicine set purchaseprice='$costprice',rateperunit='$salesprice' where itemcode='$item_code'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
	
			// select pharmacy rate templates
			$sql_pharma_rate = "SELECT * FROM pharma_rate_template WHERE recordstatus <> 'deleted'";
			$exec_pharma_rate = mysqli_query($GLOBALS["___mysqli_ston"], $sql_pharma_rate) or die("Error in Query_pharma_rate" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res_pharma_rate = mysqli_fetch_array($exec_pharma_rate)) {
				$temp_id = $res_pharma_rate['auto_number'];
				$markup = $res_pharma_rate['markup'];
					if($temp_id==1)
					{
					$markup=$margin;
					}
					if($temp_id==2)
					{
					$markup=$margin;
					}
				$margin = $markup;
				$item_id = $item_code;
				$item_price = (float)$costprice;

				$var_price = (($margin / 100) * $item_price);
				$new_price = ceil(($item_price + $var_price));
				if($markup==0)
				{
					$new_price=0;
				}
				$date = date("Y-m-d");
                $new_price=$salesprice;
				//insert new row in template rate mapping
				$sqlquerymap = "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus,margin) VALUES ('$temp_id','$item_id','$new_price','$username','$date','','$margin')";
				$exequerymap = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquerymap);
} 
}
			?>