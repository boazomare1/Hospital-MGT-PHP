<?php

//session_start();

include ("db/db_connect.php");

//$customer = trim($_REQUEST['term']);

if (isset($_REQUEST["term"])) { $customer = $_REQUEST["term"]; } else { $customer = ""; }
if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }
if (isset($_REQUEST["templateid"])) { $templateid = $_REQUEST["templateid"]; } else { $templateid = ""; }

if($source!='')
{
$crm=0;
$query_wht1 = "SELECT itemname,quantity from purchase_templatelinking where template_id='$templateid'";
$exec_wht1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht1) or die ("Error in query_wht1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res_wht1 = mysqli_fetch_array($exec_wht1))
{ 
$itemname = $res_wht1['itemname'];
$quantity = $res_wht1['quantity'];
$crm=$crm+1;  

?>
<tr>

<td width="150" align="left" valign="left"><input name="template_item<?php echo $crm;?>" type="text" id="template_item<?php echo $crm;?>" size="25" autocomplete="off" value="<?php echo $itemname;?>" readonly="readonly"></td>
<td width="48" class="bodytext3"><input name="template_item_size<?php echo $crm;?>" type="number" id="template_item_size<?php echo $crm;?>" size="8" autocomplete="off" value="<?php echo $quantity;?>" onkeyup="cal_amt_second(this.value,'<?php echo $crm;?>')" onchange="cal_amt_second(this.value,'<?php echo $crm;?>')";/></td>
<td class="bodytext3"><input name="template_rate<?php echo $crm;?>" type="text" id="template_rate<?php echo $crm;?>"  autocomplete="off" value="" onkeyup="cal_amt(this.value,'<?php echo $crm;?>')" ; ></td>
<td class="bodytext3"><input name="template_tax" type="text" id="template_tax" style="width: 150px;"  value="0.0000"></td>
<td class="bodytext3"><input name="template_amount<?php echo $crm;?>" type="text" id="template_amount<?php echo $crm;?>" size="18" autocomplete="off" value="" ></td>
<td width="10"  align="left" valign="left"><input name="check_template<?php echo $crm;?>" type="checkbox" id="check_template<?php echo $crm;?>"  onClick="get_item('<?php echo $crm;?>');" ></td>
</tr>

<?php } 
}
if($source=='')
{
$customersearch='';


$stringbuild1 = "";

$a_json = array();

$a_json_row = array();
$customer=trim($customer);
if($customer!='')
{
   $query1 = "select * from purchase_template where template_name  LIKE '%$customer%' and recordstatus=''";
}
else
{
 $query1 = "select * from purchase_template where  recordstatus=''";	
}

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	 $id = $res1["template_id"];

	$accountname = $res1["template_name"];

	$acccountanum = $res1['auto_number'];

	$a_json_row["id"] = trim($id);

	$a_json_row["anum"] = trim($acccountanum);

	$a_json_row["value"] = trim($accountname);

	$a_json_row["label"] = trim($accountname);

	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;

echo json_encode($a_json);
}

?>

