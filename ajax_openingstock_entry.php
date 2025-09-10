<?php
session_start();

if (!isset($_SESSION["username"])) header("location:index.php");

include "db/db_connect.php";
$updatedate = date('Y-m-d');
$ipaddress = $_SERVER['REMOTE_ADDR'];
$username = $_SESSION['username'];
$docsession = $_SESSION['docno'];

if (isset($_REQUEST["action"])) {$action = $_REQUEST["action"]; } else { $action = ""; }
if (isset($_REQUEST["id"])) {$id = $_REQUEST["id"]; } else { $id = ""; }
if (isset($_REQUEST["term"])) {$docno = $_REQUEST["term"]; } else { $term = ""; }
$a_json = array();
$a_json_row = array();
if($action=='searchdocno')
{
$query1 = "select locationcode from login_locationdetails where username='$username' and docno='$docsession' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationcode"];	
	
$docno=trim($docno);
$query281 = "select locationcode,location,store,storename,docno from openingstock_dataentry where  docno like '%$docno%' and locationcode='$res1location' and  recordstatus=''";
$exec281 = mysqli_query($GLOBALS["___mysqli_ston"], $query281) or die ("Error in Query281".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while ($res281 = mysqli_fetch_array($exec281))
{
$locationcode = $res281["locationcode"];
$location = $res281["location"];
$store = $res281["store"];
$storename = $res281["storename"];
$docno1 = $res281["docno"];

$a_json_row["location"] = $location;

$a_json_row["locationcode"] = $locationcode;

$a_json_row["store"] = $store;

$a_json_row["storename"] = $storename;

$a_json_row["value"] = $docno1;

$a_json_row["label"] = $docno1.'||'.$storename;

array_push($a_json, $a_json_row);

}
echo json_encode($a_json);
}
else if($action=='insert_data')
{
	$s=0;
	if (isset($_REQUEST["medicinename"])) {$medicinename = $_REQUEST["medicinename"]; } else { $medicinename = ""; }
	if (isset($_REQUEST["medicinecode"])) {$medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
	if (isset($_REQUEST["salesrate"])) {$salesrate = $_REQUEST["salesrate"]; } else { $salesrate = ""; }
	if (isset($_REQUEST["quantity"])) {$quantity = $_REQUEST["quantity"]; } else { $quantity = ""; }
	if (isset($_REQUEST["batch"])) {$batch = $_REQUEST["batch"]; } else { $batch = ""; }
	if (isset($_REQUEST["expirydate"])) {$expirydate = $_REQUEST["expirydate"]; } else { $expirydate = ""; }
	if (isset($_REQUEST["docnumber"])) {$docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
	if (isset($_REQUEST["store"])) {$store = $_REQUEST["store"]; } else { $store = ""; }
	if (isset($_REQUEST["storecode"])) {$storecode = $_REQUEST["storecode"]; } else { $storecode = ""; }
	if (isset($_REQUEST["location"])) {$location = $_REQUEST["location"]; } else { $location = ""; }
	if (isset($_REQUEST["producttype"])) {$producttype = $_REQUEST["producttype"]; } else { $producttype = ""; }
	if (isset($_REQUEST["locationcodenew"])) {$locationcode = $_REQUEST["locationcodenew"]; } else { $locationcodenew = ""; }
/*	
$expirymonth = substr($expirydate, 0, 2);
$expiryyear = substr($expirydate, 3, 2);
$expiryday = '01';
$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;*/
	
	if($medicinecode!='')
	{
	 $medicinequery2="insert into openingstock_data (itemcode, itemname, transactiondate,quantity, username, ipaddress, rateperunit, batchnumber,expirydate,store,storecode,location,locationcode,docno,producttype)
values ('$medicinecode', '$medicinename', '$updatedate', '$quantity', '$username', '$ipaddress', '$salesrate','$batch','$expirydate', '$store','$storecode','$location','$locationcode','$docnumber','$producttype')";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
/*if($producttype=='')
{
 $query1 = "select * from openingstock_data where docno='$docnumber'";	
}
else
{
$query1 = "select * from openingstock_data where docno='$docnumber' and producttype='$producttype'";	
}*/
 $query1 = "select * from openingstock_data where docno='$docnumber' and recordstatus=''";	
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec))

{
    $s=$s+1;
	$itemcode = $res1['itemcode'];
	$itemname = $res1['itemname'];
	$rate = $res1['rateperunit'];
	$qty = $res1['quantity'];
	$batch = $res1['batchnumber'];
	$expirydate = $res1['expirydate'];
	$auto_number = $res1['auto_number'];
	?>
<TR id="idTRP" class="idTRP">
<td id="idTD1<?php echo $s; ?>" align="left">
<input name="itemname<?php echo $s; ?>" value="<?php echo $itemname; ?>" id="itemname<?php echo $s;?>" size="65" class="ui-autocomplete-input" readonly/>
<input type="hidden" id="itemcode<?php echo $s;?>" name="itemcode<?php echo $s;?>" value="<?php echo $itemcode; ?> " readonly/>
</td>
<td id="idTD1<?php echo $s; ?>" align="left">
<input name="salesrate<?php echo $s; ?>" value="<?php echo $rate; ?>" id="salesrate<?php echo $s;?>" style="text-align:right" size="8" readonly/>
</td>
<td id="idTD1<?php echo $s; ?>" align="left"><input name="formula<?php echo $s; ?>" value="" id="formula<?php echo $s;?>" size="8"/></td>
<td id="idTD1<?php echo $s; ?>" align="left"><input name="rol<?php echo $s; ?>" value="" id="rol<?php echo $s;?>"  size="8"/></td>

<td id="idTD1<?php echo $s; ?>" align="left" >
<input name="qty<?php echo $s; ?>" value="<?php echo $qty; ?>" id="qty<?php echo $s;?>"  style="text-align:right"  size="8"  />
</td>

<td id="idTD1<?php echo $s; ?>" align="left">
<input name="batch<?php echo $s; ?>" value="<?php echo $batch; ?>" id="batch<?php echo $s;?>" style="text-align:right"  class=""  size="8"  />
</td>

<td id="idTD1<?php echo $s; ?>" align="left" >
<input name="expirydate<?php echo $s; ?>" value="<?php echo $expirydate; ?>" style="text-align:right" id="expirydate<?php echo $s;?>" size="8"  /></td>
<td id="idTD1<?php echo $s; ?>" align="left" >
<input onClick="return btnDeleteClickitem('<?php echo $auto_number;?>','<?php echo "Update";?>','<?php echo $s;?>')" name="btndelete<?php echo $s; ?>" id="btndelete<?php echo $s; ?>" type="button" value="Update" class="button"/></td> 
<td id="idTD1<?php echo $s; ?>" align="right" >
<input onClick="return btnDeleteClickitem('<?php echo $auto_number;?>','<?php echo "Delete";?>','<?php echo $s;?>')" name="btndelete<?php echo $s; ?>" id="btndelete<?php echo $s; ?>" type="button" value="Del" class="button"/></td>
</TR>
              <?php }



}
else if($action=='delete_data')
{
	$s=0;
	if (isset($_REQUEST["auto_number"])) {$auto_number = $_REQUEST["auto_number"]; } else { $auto_number = ""; }
	if (isset($_REQUEST["producttype"])) {$producttype = $_REQUEST["producttype"]; } else { $producttype = ""; }
	if (isset($_REQUEST["docnumber"])) {$docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
	if (isset($_REQUEST["status"])) {$status = $_REQUEST["status"]; } else { $status = ""; }
	
	if (isset($_REQUEST["qty"])) {$qty = $_REQUEST["qty"]; } else { $qty = ""; }
	if (isset($_REQUEST["batch"])) {$batch = $_REQUEST["batch"]; } else { $batch = ""; }
	if (isset($_REQUEST["expirydate"])) {$expirydate = $_REQUEST["expirydate"]; } else { $expirydate = ""; }
	
	if($status=='Delete')
	{
$medicinequery2="update openingstock_data set recordstatus='deleted' where auto_number='$auto_number' and docno='$docnumber'";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
$medicinequery2="update openingstock_data set quantity='$qty',batchnumber='$batch',expirydate='$expirydate' where auto_number='$auto_number' and docno='$docnumber'";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
$query1 = "select * from openingstock_data where docno='$docnumber' and recordstatus=''";	

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec))

{
    $s=$s+1;
	$itemcode = $res1['itemcode'];
	$itemname = $res1['itemname'];
	$rate = $res1['rateperunit'];
	$qty = $res1['quantity'];
	$batch = $res1['batchnumber'];
	$expirydate = $res1['expirydate'];
	$auto_number = $res1['auto_number'];
	?>
<TR id="idTRP" class="idTRP">
<td id="idTD1<?php echo $s; ?>" align="left">
<input name="itemname<?php echo $s; ?>" value="<?php echo $itemname; ?>" id="itemname<?php echo $s;?>" size="65" class="ui-autocomplete-input" readonly/>
<input type="hidden" id="itemcode<?php echo $s;?>" name="itemcode<?php echo $s;?>" value="<?php echo $itemcode; ?> " readonly/>
</td>
<td id="idTD1<?php echo $s; ?>" align="left">
<input name="salesrate<?php echo $s; ?>" value="<?php echo $rate; ?>" id="salesrate<?php echo $s;?>" size="8" readonly/>
</td>
<td id="idTD1<?php echo $s; ?>" align="left"><input name="formula<?php echo $s; ?>" value="" id="formula<?php echo $s;?>" size="8"/></td>
<td id="idTD1<?php echo $s; ?>" align="left"><input name="rol<?php echo $s; ?>" value="" id="rol<?php echo $s;?>"  size="8"/></td>
<td id="idTD1<?php echo $s; ?>" align="left" >
<input name="qty<?php echo $s; ?>" value="<?php echo $qty; ?>" id="qty<?php echo $s;?>"    size="8"  />
</td>

<td id="idTD1<?php echo $s; ?>" align="left">
<input name="batch<?php echo $s; ?>" value="<?php echo $batch; ?>" id="batch<?php echo $s;?>"  class=""  size="8"  />
</td>

<td id="idTD1<?php echo $s; ?>" align="left" >
<input name="expirydate<?php echo $s; ?>" value="<?php echo $expirydate; ?>" id="expirydate<?php echo $s;?>" size="8"  /></td>
<td id="idTD1<?php echo $s; ?>" align="left" >
<input onClick="return btnDeleteClickitem('<?php echo $auto_number;?>','<?php echo "Update";?>','<?php echo $s;?>')" name="btndelete<?php echo $s; ?>" id="btndelete<?php echo $s; ?>" type="button" value="Update" class="button"/></td>
<td id="idTD1<?php echo $s; ?>" align="right" >
<input onClick="return btnDeleteClickitem('<?php echo $auto_number;?>','<?php echo "Delete";?>','<?php echo $s;?>')" name="btndelete<?php echo $s; ?>" id="btndelete<?php echo $s; ?>" type="button" value="Del" class="button"/></td>
</TR>
              <?php }



}
else if($action=='delete_indv')
{

	if (isset($_REQUEST["auto_number"])) {$auto_number = $_REQUEST["auto_number"]; } else { $auto_number = ""; }

$medicinequery2="update openingstock_data set recordstatus='deleted' where auto_number='$auto_number'";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}
else if($action=='checkvalidation')
{

if (isset($_REQUEST["medicinecode"])) {$medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
if (isset($_REQUEST["docnumber"])) {$docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
if (isset($_REQUEST["batch"])) {$batch = $_REQUEST["batch"]; } else { $batch = ""; }

 $query1 = "select * from openingstock_data where docno='$docnumber' and itemcode='$medicinecode' and batchnumber='$batch'";	
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num38=mysqli_num_rows($exec);
if($num38>0)
{
	echo $num38;
}
else
{
	echo "0";
}
}
else
{
  if($id=='undefined')
  {
	  $id='';
  }

	if($id!='')
	{
	   $querymed = "select * from master_medicine where itemname like '%$docno%' and categoryname='$id' and status <> 'Deleted' order by itemcode";
	}
	else
	{
	 $querymed = "select * from master_medicine where itemname like '%$docno%' and  status <> 'Deleted' order by itemcode";	
	}
	$execmed = mysqli_query($GLOBALS["___mysqli_ston"], $querymed) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resmed = mysqli_fetch_array($execmed))

{

	$res1itemcode = $resmed['itemcode'];
	$purchaseprice = $resmed['purchaseprice'];

	$res1itemcode = trim($res1itemcode);

	$res1itemname = $resmed['itemname'];
	$formula = $resmed['formula'];
	$rol = $resmed['rol'];
	
	$res1itemname = addslashes($res1itemname);
	$res1itemname = strtoupper($res1itemname);
	$res1itemname = trim($res1itemname);
	$res1itemname = preg_replace('/,/', ' ', $res1itemname);

	$a_json_row["itemname"] = $res1itemname;
	
	$a_json_row["itemcode"] = $res1itemcode;
	
	$a_json_row["purchaseprice"] = $purchaseprice;
	
	$a_json_row["formula"] = $formula;
	
	$a_json_row["rol"] = $rol;
	
	$a_json_row["value"] = $res1itemname;

   $a_json_row["label"] = $res1itemname.' ||'.$purchaseprice;
	

	array_push($a_json, $a_json_row);
 }
echo json_encode($a_json);
}
?>

