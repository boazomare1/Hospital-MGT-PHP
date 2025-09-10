<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];


$searchmedicinename1 = $_REQUEST['searchmedicinename1'];

$locationcode = $_REQUEST['searchlocation'];
$searchstore = $_REQUEST['searchstore'];
$stringbuild100='';
//$res7storeanum = $res23['store'];

$query75 = "select * from master_store where storecode='$searchstore'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$storecode = $res75['storecode'];
$ratecolumn = $locationcode.'_rateperunit';

$query200 = "select itemcode,itemname,disease,genericname,pkg,`$ratecolumn` from master_medicine where (itemname like '%$searchmedicinename1%' or disease like '%$searchmedicinename1%' or genericname like '%$searchmedicinename1%') and status <> 'Deleted' order by itemname";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{
	$res200itemcode = $res200['itemcode'];	
	$res200medicine = $res200['itemname'];
	$disease = $res200['disease'];
	$itemcode = $res200itemcode;
	$genericname = $res200['genericname'];
	$rateperunit = $res200[$locationcode.'_rateperunit'];
	$pkg = $res200['pkg'];
	
	$query6 = "select shownostockitems from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$stocks = $res6['shownostockitems'];
	
	/*$query57 = "select sum(batch_quantity) as currentstock from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
	
	$res57=mysql_query($query57);
	$exec57 = mysql_fetch_array($res57);
	$currentstock = $exec57['currentstock'];
	*/
	//echo $res200itemcode;
	//include ('autocompletestockcount1include1.php');
	
//echo $res200itemcode;
	//$currentstock = $currentstock;
	$currentstock = '';

	$query57 = "select sum(batch_quantity) as currentstock from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' limit 0,1";
	
	$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
	$exec57 = mysqli_fetch_array($res57);
	$currentstock = $exec57['currentstock'];

	if($currentstock>0) { 
	
	$res200medicine = addslashes($res200medicine);

	$res200medicine = strtoupper($res200medicine);
	
	$res200medicine = trim($res200medicine);
	
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.
	
	$stocks = 'yes';
	if($stocks == 'NO')
	{
		if($currentstock > 0)
		{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
		}
		
	}
	else
	{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
	}
}
}
echo $stringbuild100;

	

?>