<?php

session_start();

include ("db/db_connect.php");

// $transactiondateto=date('Y-m-d');
$transactiondateto = date('Y-m-d');

$medicinesearch = $_REQUEST["medicinesearch"];

if(isset($_REQUEST['locationcode'])) { $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }

if(isset($_REQUEST['storecode'])) { $storecode = $_REQUEST['storecode']; } else { $storecode = ''; }
if(isset($_REQUEST['tostore'])) { $tostore = $_REQUEST['tostore']; } else { $tostore = ''; }


if(isset($_REQUEST['accountname'])) { $accountname = $_REQUEST['accountname']; } else { $accountname = '1'; }

//$medicinesearch = strtoupper($medicinesearch);

$searchresult2 = "";

$dose_measureanum ="";
$dose_measure="";

$query2 = "select * from master_medicine where itemcode = '$medicinesearch' order by itemname";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

	$itemcode = $res2["itemcode"];

	$itemname = $res2["itemname"];

    $itemname = strtoupper($itemname);

    //$rateperunit = $res2["rateperunit"];
    ////////// dose Measure
    $dose_measureanum = $res2["dose_measure"];

	 $query_prod_type = "select * from dose_measure where id='$dose_measureanum' ";
								     $exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while ($res_prod_type = mysqli_fetch_array($exec_prod_type))
								 {
								     $res_prod_id3 = $res_prod_type['id'];
								     $dose_measure = $res_prod_type['name'];
								 }
    ////////// dose Measure


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

	if($subanum=='')
      $subanum = 1;

	$rateperunit = $res2["subtype_".$subanum];

	$formula = $res2['formula'];

	$strength = $res2['roq'];

	$genericname = $res2['genericname'];

	$pkg = $res2['pkg'];

	if($storecode!=''&&$locationcode!='')

	{
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
		$query57 = "select sum(batch_quantity) as currentstock,itemcode from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and TRIM(batchnumber in(select TRIM(batchnumber) from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode') or TRIM(batchnumber in(select TRIM(batchnumber) from purchase_details where expirydate>now() and itemcode ='$itemcode')))";

		$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);

		$exec57 = mysqli_fetch_array($res57);

		$currentstock = intval($exec57['currentstock']);

		 $querycumstock2 = "SELECT sum(batch_quantity) as currentstock,itemcode from transaction_stock where storecode='".$tostore."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and TRIM(batchnumber in(select TRIM(batchnumber) from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode') or TRIM(batchnumber in(select TRIM(batchnumber) from purchase_details where expirydate>now() and itemcode ='$itemcode')))";

		 //  // $querycumstock2 = "SELECT sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode='1' and batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode')";

			$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescumstock2 = mysqli_fetch_array($execcumstock2);

			$currentstock1 = $rescumstock2["currentstock"];
			if($currentstock1==""){
				$currentstock1=0;
			}

			

			// echo $currentstock = $currentstock;

			// echo $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$locationcode' and storecode='STO1' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='1'";
			// $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			// $res1 = mysql_fetch_array($exec1);
			// $currentstock11 = $res1['currentstock'];

			// $query12 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$locationcode' and storecode='STO1' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='0'";
			// $exec12 = mysql_query($query12) or die ("Error in Query1".mysql_error());
			// $res12 = mysql_fetch_array($exec12);
			// $currentstock2 = $res12['currentstock'];

			// $currentstockt= $currentstock11-$currentstock2;
			// $currentstock1=intval($currentstockt);



	}

	else

	{

		$currentstock='';

	}

	if ($searchresult2 == '')

	{

	    $searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$pkg.'||'.$currentstock.'||'.$currentstock1.'||'.$dose_measureanum.'||'.$dose_measure.'||';

	}

	else

	{

		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$pkg.'||'.$currentstock.'||'.$currentstock1.'||'.$dose_measureanum.'||'.$dose_measure.'||';

	}

	

}

if ($searchresult2 != '')

{

 echo $searchresult2;

}

?>