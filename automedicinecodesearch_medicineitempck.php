<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
$medicinesearch = $_REQUEST["medicinesearch"];
$accountname = $_REQUEST["accountname"];
$subtypeano = $_REQUEST["subtypeano"];
$storeurl=$_REQUEST['store'];
if($storeurl!='')
$strchk="and storecode='$storeurl'";
else
$strchk="";
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];
$query = "select locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationcode = $res["locationcode"];
$storebuild = "''";
	$query_s = "select storecode from master_employeelocation where username = '$username' and locationcode = '$locationcode'";
	$exec_s = mysqli_query($GLOBALS["___mysqli_ston"], $query_s) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res_s = mysqli_fetch_array($exec_s))
	{
		$acc_store = $res_s['storecode'];
		$query_ss = "select store, storecode from master_store where auto_number = '$acc_store'";
		$exec_ss = mysqli_query($GLOBALS["___mysqli_ston"], $query_ss) or die ("Error in Query_ss".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ss = mysqli_fetch_array($exec_ss);
		$storecode = $res_ss['storecode'];
		if($storebuild == "''")
		{
		$storebuild = "'".$storecode."'";
		} else {
		$storebuild = $storebuild.",'".$storecode."'";
		}
	}
	//echo $storebuild;
	//$medicinesearch = strtoupper($medicinesearch);
	$searchresult2 = "";
	$query2 = "select * from master_medicine where itemcode = '$medicinesearch' order by itemname";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
		$itemcode = $res2["itemcode"];
		$itemname = $res2["itemname"];
		$dose_measureanum = $res2["dose_measure"];
		
		$drugtype = $res2['type'];
		
		if($drugtype=='DRUGS'){
		$querytype = "select drugs_store from master_location where locationcode='$locationcode' ";
		$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
		$restype = mysqli_fetch_array($exectype);
		$storecode = $restype['drugs_store'];
		} elseif($drugtype=='NON DRUGS'){
		$querytype = "select nondrug_store from master_location where locationcode='$locationcode'";
		$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
		$restype = mysqli_fetch_array($exectype);
		$storecode = $restype['nondrug_store'];	
		}
		
		$query_prod_type = "select * from dose_measure where id='$dose_measureanum' ";
		$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res_prod_type = mysqli_fetch_array($exec_prod_type))
		{
			$res_prod_id3 = $res_prod_type['id'];
			$dose_measure = $res_prod_type['name'];
		}
		$itemname = strtoupper($itemname);
		$subanum = 1;
		$fxrate=1;
		if(is_numeric($accountname))
		{
		$subanum=$accountname;
		}else{
		$querycurn= "select fxrate, auto_number from master_subtype where subtype like '$accountname'";
		$rescurn=mysqli_query($GLOBALS["___mysqli_ston"], $querycurn);
		if($execurn=mysqli_fetch_assoc($rescurn))
		{
		$fxrate=$execurn['fxrate'];
		$subanum=$execurn['auto_number'];
		}
		}
		//$rateperunit = $res2["subtype_".$subanum];
		$rateperunit = $res2["purchaseprice"];
		$rateperunit = $rateperunit/$fxrate;
		$formula = $res2['formula'];
		$strength = $res2['roq'];
		$genericname = $res2['genericname'];
		$query571 = "select itemcode,sum(batch_quantity) as currentstock from transaction_stock where locationcode='".$locationcode."' and itemcode='$itemcode' and batch_stockstatus='1' and storecode ='$storecode' and (batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode') or batchnumber in(select batchnumber from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode')) group by itemcode";
		$res571=mysqli_query($GLOBALS["___mysqli_ston"], $query571);
		$exec571 = mysqli_fetch_array($res571);	
		$stockitemcode = $exec571['itemcode'];	
		$currentstock = intval($exec571['currentstock']);
		$query_storeurl = "select itemcode,sum(batch_quantity) as currentstock from transaction_stock where locationcode='".$locationcode."' and itemcode='$itemcode' and batch_stockstatus='1' $strchk and (batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode') or batchnumber in(select batchnumber from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode')) group by itemcode";
		$res_storeurl=mysqli_query($GLOBALS["___mysqli_ston"], $query_storeurl);
		$exec_storeurl = mysqli_fetch_array($res_storeurl);	
		// $stockitemcodeurl = $exec_storeurl['itemcode'];	
		$currentstockurl = intval($exec_storeurl['currentstock']);
		$query22 = "select * from pharma_insurance where itemcode='$itemcode' and accountname='$accountname'";
		$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num22 = mysqli_num_rows($exec22);
		if ($searchresult2 == '')
		{
		$searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$num22.'||'.$currentstock.'||'.$currentstockurl.'||'.$dose_measureanum.'||'.$dose_measure.'||';
		}
		else
		{
		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$num22.'||'.$currentstock.'||'.$currentstockurl.'||'.$dose_measureanum.'||'.$dose_measure.'||';
		}
	}
	if ($searchresult2 != '')
	{
	echo $searchresult2;
	}
?>