<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$datetimeonly = date("Y-m-d H:i:s");
$i='';
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$locationname = $res1location;
$locationcode = $res1["locationcode"];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{	

	$serial_mainnumber = $_POST['serial_mainnumber'];
	for($j=1;$j<=$serial_mainnumber;$j++)
	{
		if(isset($_REQUEST['item_approve'.$j]))
		{
			$appid = $_REQUEST['appid'.$j];
			$docno = $_REQUEST['docno'.$j];
		
			
			$query2 = "select * from branch_stock_transfer WHERE  auto_number='$appid' and docno='$docno'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$num2 = mysqli_num_rows($exec2);
			$itemcode = $res2["itemcode"];
			$itemname = $res2["itemname"];
			$fromloct = $res2["locationcode"];
			$fromloctname = $res2["locationname"];
			$to_location = $res2["tolocationcode"];
			$tolocationname = $res2["tolocationname"];
			$fifo_code = $res2["fifo_code"];
			$fromstore = $res2["fromstore"];
			$tostore = $res2["tostore"];
			$batchnumber = $res2["batch"];
			$rate = $res2["rate"];
			$amount = $res2["amount"];
			$typetransfer = $res2["typetransfer"];
			$requestdocno = $res2["requestdocno"];
			$fromstorequantitybeforetransfer = $res2["fromstorequantitybeforetransfer"];
			$fromstorequantityaftertransfer = $res2["fromstorequantityaftertransfer"];
			$tostorequantitybeforetransfer = $res2["tostorequantitybeforetransfer"];
			$tostorequantityaftertransfer = $res2["tostorequantityaftertransfer"];
			$transferquantity=$tnxquantity = $res2["transferquantity"];
			
			$query67 = "select purchaseprice,ledgercode,ledgername,ledgerautonumber from master_medicine where itemcode='$itemcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res67 = mysqli_fetch_array($exec67);
			$costprice = $res67['purchaseprice'];
			$ledgercode = $res67['ledgercode'];
			$ledgername = $res67['ledgername'];
			$ledgeranum = $res67['ledgerautonumber'];
			
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$categoryname = $res31['categoryname'];
			
			$exist_quantity=0;
			$querybatstock21 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$to_location' and fifo_code='$fifo_code' and storecode ='$tostore'";
			$execbatstock21 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock21) or die ("Error in batQuery21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbatstock21 = mysqli_fetch_array($execbatstock21);
			$exist_quantity = $resbatstock21["batch_quantity"];
			$bat_quantity=$exist_quantity+$tnxquantity;
			$cum_quantity=$exist_quantity+$tnxquantity;
			
			$queryupdatebatstock21 = "UPDATE transaction_stock set cum_stockstatus='0', batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$to_location' and storecode='$tostore' and fifo_code='$fifo_code'";
			$execupdatebatstock21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock21) or die ("Error in updatebatQuery21".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,batchnumber, batch_quantity, transaction_quantity,cum_quantity,entrydocno,docstatus,cum_stockstatus,batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgercode,ledgername,ledgeranum)values ('$fifo_code','master_stock_transfer','$itemcode', '$itemname', '$dateonly','1', 'Stock Transfer To', '$batchnumber', '$bat_quantity', '$tnxquantity', '$cum_quantity', '$docno', '','1','1', '$to_location','','$tostore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount','$ledgercode','$ledgername','$ledgeranum')";
			$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$medicinequery2="INSERT into master_stock_transfer(fifo_code,docno,fromstore,tostore,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,locationcode,recordstatus,entrydate,categoryname,typetransfer,locationname,requestdocno,tolocationname,tolocationcode)values('$fifo_code','$docno','$fromstore','$tostore','$itemcode','$itemname','$transferquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','$fromloct','completed','$updatedatetime','$categoryname','$typetransfer','$fromloctname','$requestdocno','$tolocationname','$to_location')";
			$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 
			$query55="update branch_stock_transfer set recordstatus='completed' where auto_number='$appid'";
			$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
		
		header("location:branch_git.php");
		exit;
	
}


if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];
$query43 = "select * from branch_stock_transfer where docno='$docno'";
$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
$res43 = mysqli_fetch_array($exec43);
$fromloct = $res43['locationname'];
$fromloctcode = $res43['locationcode'];
$toloct = $res43['tolocationname'];
$toloctcode = $res43['tolocationcode'];
$from = $res43['fromstore'];
$to = $res43['tostore'];
$requestdocno = $res43['requestdocno'];

$queryfrom751 = "select store from master_store where storecode='$from'";
$execfrom751 = mysqli_query($GLOBALS["___mysqli_ston"], $queryfrom751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resfrom751 = mysqli_fetch_array($execfrom751);
$fromname = $resfrom751['store'];

$queryto751 = "select store from master_store where storecode='$to'";
$execto751 = mysqli_query($GLOBALS["___mysqli_ston"], $queryto751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resto751 = mysqli_fetch_array($execto751);
$toname = $resto751['store'];


}
?>
<style type="text/css">
 <!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
.ui-menu .ui-menu-item{ zoom:1 !important; }
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
 
.bal
{
border-style:none;
background:none;
text-align:center;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script>

</script>

<body onLoad="">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
	<td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>&nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="80%">
			<form name="cbform1" id="cbform1" method="post" action="branch_git_view.php"  onSubmit="return validcheck()">
			
                <table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><strong>Branch Stock transfer </strong></td>
                    </tr>
					<tr>
                      <td width="" align="left" valign="middle"  class="bodytext32"><strong>Doc No</strong></td>
                      <td width="" align="left" valign="middle"><span class="bodytext32"><?php echo $docno; ?></span></td>
                      <td width="" align="left" valign="middle" class="bodytext32"><strong>From </strong></td>                   
                      <td width="" align="left" valign="middle" class="bodytext32"><?php echo $fromloct .'--'. $fromname; ?> 
					  <input type="hidden" name="fromstore" id="fromstore" value="<?php echo $from; ?>">
                      <input type="hidden" name="fromlocation" id="fromlocation" value="<?php echo $fromloctcode; ?>">                     
                      </td>
                      <td width="" align="middle" valign="middle" class="bodytext32"><strong>To </strong></td>
                      <td colspan="" align="left" valign="middle" class="bodytext32"><?php echo $toloct .'--'. $toname; ?>
					  <input type="hidden" name="tostore" id="tostore" size="18" autocomplete="off" value="<?php echo $to; ?>">
					  <input type="hidden" name="tolocation" id="tolocation" size="18" autocomplete="off" value="<?php echo $toloctcode; ?>"></td>
                      <td width="" align="middle" valign="middle"><span class="bodytext32"><strong>Date</strong></span></td>
					  <td align="left" valign="top"><span class="bodytext32">&nbsp;
					  <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo date('d/m/Y', strtotime($updatedatetime)); ?>" size="8" autocomplete="off" readonly>
					  </span></td>
                    </tr>
					<tr>
					 <td width="" align="left" valign="middle"  class="bodytext32"><strong>Req Doc.No</strong></td>
                      <td width="" align="left" valign="middle"><span class="bodytext32"><?php echo $requestdocno; ?></span></td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					
				 <table width="75%" border="0" align="left" cellpadding="4" cellspacing="0"  style="border-collapse: collapse" >
                  <tbody>	
					
					<tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>NO</strong></td>
                      <td width="" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Item</strong></td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Req.Qty</strong></td>
                      <td align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Approved Qty</strong></td>
                      <td  align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Receivable Qty</strong></td>
                      <td align="right" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Cost</strong></td>
                      <td  align="right" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Amount</strong></td>			  
                    </tr>
					<?php
					$sno =0;
					$grdtot =0;
					$inc =0;
					$colorloopcount=0;
					$serial_mainnumber=0;
					
					$query34 = "select * from branch_stock_transfer where docno='$docno' and recordstatus = 'pending'";
					$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$nums34 = mysqli_num_rows($exec34);
					while($res34 = mysqli_fetch_array($exec34))
					{
					$itemname = $res34['itemname'];
					$itemcode = $res34['itemcode'];
					$transferquantity = $res34['transferquantity'];
					$requestdocno = $res34['requestdocno'];
					$rate = $res34['rate'];
					$amount = $res34['amount'];
					$auto_number = $res34['auto_number'];
					$grdtot=$grdtot+$amount;
					$query551 = "select * from master_branchstockrequest where docno='$requestdocno' and  itemcode='$itemcode'";
					$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res551 = mysqli_fetch_array($exec551);
					$tot_quantity = $res551['quantity'];
					
					$query55 = "select * from master_stock_transfer where requestdocno='$requestdocno' and itemcode='$itemcode'";
					$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res55 = mysqli_fetch_array($exec55);
					$rec_quantity = $res55['transferquantity'];
					
					$colorloopcount = $colorloopcount + 1;
					$serial_mainnumber=$serial_mainnumber+1;
					$sno = $sno + 1;
					$showcolor = ($colorloopcount & 1); 
					if ($showcolor == 0)
					{
						//echo "if";
						$colorcode = 'bgcolor="#CBDBFA"';
					}
					else
					{
						//echo "else";
						$colorcode = 'bgcolor="#ecf0f5"';
					}
		
					?>
					<tr  <?php echo $colorcode; ?>>
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $itemname; ?>
					<input type="hidden" name="appid<?php echo $sno;?>" value="<?php echo $auto_number; ?>"> 
					<input type="hidden" name="docno<?php echo $sno;?>" value="<?php echo $docno; ?>">
					</div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $tot_quantity; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $transferquantity; ?> </div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $transferquantity; ?> </div></td>
					<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $rate; ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $amount; ?></div></td>
					<td class="bodytext31" valign="center"  align="left" style="display:none" >
					<div class="bodytext31" align="center"><input type="checkbox"  name="item_approve<?php echo $sno;?>" id="item_approve<?php echo $sno;?>" value="<?php echo $auto_number; ?>"   checked onclick="return statuscheck('<?php echo $sno;?>')"> &nbsp; 
					</td>
					</tr>
					
					
					<?php } ?>
					<tr>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc"><strong>Total</strong></td>
					<td class="bodytext31" valign="center"  align="right" bgcolor="#cccccc"><strong><?php echo number_format($grdtot,2,'.',','); ?></strong></td>
					
					</tr>
					
					<tr>
					<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8" class="bodytext31" valign="center"  align="right">
					<input type="hidden" name="frm1submit1" value="frm1submit1" />
					<input type="hidden" id="serial_mainnumber" name="serial_mainnumber" value="<?php echo $serial_mainnumber;?>" />
					<input type="submit" name="submit" value="Receive Stock" id="savebtrn"></td>
					</tr>
					
				   </tbody>
				</table>

				</tbody>
				</table>
			</form>
		
		
		</td>
	   </tr>
	</td>
  
 </table>
 </body>