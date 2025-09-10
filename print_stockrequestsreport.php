<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
  $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;
  $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	$locationcode=$location;
	}
$data = '';
$status = '';
$searchsupplier = '';

ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="StockRequest.xls"');
header('Cache-Control: max-age=80');

$searchusername=isset($_REQUEST['user'])?$_REQUEST['user']:"";
$tostore=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:"";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>

<body>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1451" 
            align="left" border="1">
            <tbody>
              <tr>
                <td colspan="11" bgcolor="#FFF" class="bodytext31">
				<strong>Stock Request Report</strong></td>
                </tr>
              
             <?php
			  $colorloopcount = '';
			  $loopcount = '';
			  $totamount = 0;
			 $location=isset($_REQUEST['location'])?$_REQUEST['location']:"";
			if($searchusername == '')
			{
				$qry62 = "select username from master_internalstockrequest where date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."' and username <> '' group by username order by username";
				$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $qry62) or die ("Error in Qry62".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res62 = mysqli_fetch_array($exec62))
			 {
			 	$user = $res62['username'];
				?>
				
              <tr>
                <td colspan="10" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                
                </tr>
              <tr>
                
                <td align="left" valign="center" colspan="10" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo "Requests By: ".$user."";?></strong>
				</td>
                
               
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Type</strong></div></td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doc No </strong></div></td>
               <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong> From Store </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>To Store</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Date</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Itemname</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Request Qty </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Cost</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Total Amt</strong></div></td>
              </tr>
				<?php
			 $query66 = "select *,date(updatedatetime) as entrydate from master_internalstockrequest where  username like '$user' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res66 = mysqli_fetch_array($exec66))
			 {
			  $itemcode = $res66['itemcode'];
			  $docno = $res66['docno'];
			  $type = $res66['typetransfer'];
			  if($type == '1')
			  {
			  $typetransfer = 'Consumable';
			  }
			  else
			  {
			   $typetransfer = 'Tranfer';
			  }
			  $fromstore = $res66['fromstore'];
			  $tostore_code = $res66['tostore'];
			  $loopcount=$loopcount+1;
			  
			  $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore'");
			  $res22 = mysqli_fetch_array($query22);
			  $fromstore1 = $res22['store'];
			 
			 $query221 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$tostore_code'");
			  $res221 = mysqli_fetch_array($query221);
			  $tostore1 = $res221['store'];
			 
					  
			  $entrydate = $res66['entrydate'];
			  $itemname = $res66['itemname'];
			  $transaction_quantity = $res66['quantity'];
			  
			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $rate = $res3['purchaseprice'];
			  
			  $amount = $transaction_quantity * $rate;
			  $totamount = $totamount + $amount;
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	//$colorcode = 'bgcolor="#66CCFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#FFFFFF"';
			  }
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $typetransfer;?></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left"><?php echo $docno;?></div>
                </div></td>
               <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				  <div align="left"><?php echo $fromstore1; ?></div>
				</div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $tostore1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $entrydate; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo $transaction_quantity; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="right"><?php echo $rate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($amount,2); ?></div></td>
              </tr>
			  <?php
			  //}
			  }
			  ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total : </strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($totamount,2); ?></strong></td>
                </tr>
				 
	  <tr>
	  <td>&nbsp;</td>
	  </tr>
				<?php
				}
				}
				else
				{
				?>
			
    
              <tr>
                <td colspan="10" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                </tr>
              <tr>
                
                <td align="left" valign="center" colspan="10" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo "Requests By: ".$searchusername."";?></strong>
				</td>
                
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Type</strong></div></td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doc No </strong></div></td>
               <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong> From Store </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>To Store</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Date</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Itemname</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Request Qty </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Cost</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Total Amt</strong></div></td>
              </tr>
				<?php
				$query66 = "select *,date(updatedatetime) as entrydate from master_internalstockrequest where  username like '$searchusername' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res66 = mysqli_fetch_array($exec66))
			 {
			  $itemcode = $res66['itemcode'];
			  $docno = $res66['docno'];
			  $type = $res66['typetransfer'];
			  if($type == '1')
			  {
			  $typetransfer = 'Consumable';
			  }
			  else
			  {
			   $typetransfer = 'Tranfer';
			  }
			  $fromstore = $res66['fromstore'];
			  $tostore_code = $res66['tostore'];
			  $loopcount=$loopcount+1;
			  
			  $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore'");
			  $res22 = mysqli_fetch_array($query22);
			  $fromstore1 = $res22['store'];
			 
			 $query221 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$tostore_code'");
			  $res221 = mysqli_fetch_array($query221);
			  $tostore1 = $res221['store'];
			 
			if($typetransfer=="Consumable" || $tostore1==''){						
			  $query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore_code'";
			  $exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res2a = mysqli_fetch_array($exec2a);
			  $tostore1 = $res2a["accountname"];
			 }
			  
			  $entrydate = $res66['entrydate'];
			  $itemname = $res66['itemname'];
			  $transaction_quantity = $res66['quantity'];
			  
			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $rate = $res3['purchaseprice'];
			  
			  $amount = $transaction_quantity * $rate;
			  $totamount = $totamount + $amount;
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	//$colorcode = 'bgcolor="#66CCFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#FFFFFF"';
			  }
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $typetransfer;?></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left"><?php echo $docno;?></div>
                </div></td>
               <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				  <div align="left"><?php echo $fromstore1; ?></div>
				</div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $tostore1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $entrydate; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo $transaction_quantity; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="right"><?php echo $rate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($amount,2); ?></div></td>
              </tr>
			  <?php
			  //}
			  }
			  ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total : </strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($totamount,2); ?></strong></td>
                </tr>
				  
				<?php
				}
				?>
            </tbody>
        </table>