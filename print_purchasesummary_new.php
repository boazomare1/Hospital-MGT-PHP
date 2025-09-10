<?php
session_start();
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="purchaseSummary.xls"');
header('Cache-Control: max-age=80'); 
$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
$res2billnumber="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$colorloopcount=0;





if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }


if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom= $_REQUEST["ADate1"];} else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto= $_REQUEST["ADate2"];} else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>




<table width="101%" border="0" cellspacing="0" cellpadding="2">


       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
             cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%"   >&nbsp;</td>
              <td colspan="14"   ><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["searchmedicineanum1"])) { $searchmedicineanum1 = $_REQUEST["searchmedicineanum1"]; } else { $searchmedicineanum1 = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
				}
				else
				{
					//&&companyname=$companyname";
				}
				?>
 				
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
               <tr>
              <td   valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff"  ><div align="left"><strong>Supplier Name</strong></div></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff"  ><strong>  Rate </strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff"  ><strong> GRN Date </strong></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff"  ><strong> GRN Quantity </strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff"  ><strong> PO Date </strong></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff"  ><strong> PO Quantity </strong></td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>GRN Amount </strong></td>
            
            </tr>
			
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&username=$username&&companyanum=$companyanum&&searchmedicineanum1=$searchmedicineanum1";
			
			
			if($searchmedicineanum1=='')
			{
				 $query2212 = "select * from master_medicine where   status <>'DELETED' and itemcode IN (select itemcode from purchase_details where suppliername <> 'OPENINGSTOCK' and entrydate between '$ADate1' and '$ADate2' and suppliercode <> billnumber)";
			}
			else if($searchmedicineanum1!='')
			{
				 $query2212 = "select * from master_medicine where  itemcode='$searchmedicineanum1' and status <>'DELETED' and itemcode IN (select itemcode from purchase_details where entrydate between '$ADate1' and '$ADate2' and suppliername <> 'OPENINGSTOCK' and suppliercode <> billnumber)";
			}
			//echo $query2212;
			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec2212); 
			while($res2212 = mysqli_fetch_array($exec2212))
			{
			$itemname = $res2212['itemname'];
			$itemcode = $res2212['itemcode'];
			$auto_number = $res2212['auto_number'];

			$sno=1;
			$totalamount = 0;
			$totalquantity = 0;
			$totalpoquantity = 0;	

			/* $query9 = mysql_query("select subtype from master_subtype where auto_number = '$subtypeanum'");
			$res9 = mysql_fetch_array($query9);
			//$itemname = $res9['subtype']; */
			?>
			<tr>
            <td colspan="9"  align="left" valign="center"   ><strong><?php echo $itemname; ?> </strong></td>
            </tr> 
			
			<?php
		
				 $query221 = "select * from purchase_details where itemcode='$itemcode' and entrydate between '$ADate1' and '$ADate2' and suppliername <> 'OPENINGSTOCK' and suppliercode <> billnumber order by rate ASC";
		
			//echo $query221;  purchaseorder_details
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec221); 
			while($res221 = mysqli_fetch_array($exec221))
			{
			$billnumber = $res221['billnumber'];
			$res21accountnameano=$res221['auto_number'];
			$quantity = $res221['quantity'];
			$suppliername = $res221['suppliername'];
			$rate = $res221['rate'];	
						$grndate = $res221['entrydate'];	
						$ponumber = $res221['ponumber'];
            $query2213 = "select * from purchaseorder_details where itemcode='$itemcode' and billnumber='$ponumber' ";
			$exec2213 = mysqli_query($GLOBALS["___mysqli_ston"], $query2213) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum2=mysqli_num_rows($exec2212); 
			$res2213 = mysqli_fetch_array($exec2213);
			$poquantity = $res2213['quantity'];
			$podate = $res2213['billdate'];	
									

			$amount = $res221['subtotal'];	
			$totalquantity = $totalquantity + $quantity;
			$totalpoquantity = $totalpoquantity + $poquantity;	
			
			$totalamount = $totalamount + $amount;	
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = '';
			}
			else
			{
				//echo "else";
				$colorcode = '';
			}
	
			?>
           
           <tr >
		   <td   valign="center"  align="left"><?=$sno++;?></td>
                <td   valign="center"  align="left" 
                ><?php echo $suppliername.'-('.$billnumber.')'; ?></td>
                <td   valign="center"  align="right" 
                ><?php echo number_format($rate,2,'.',','); ?></td>
				  <td   valign="center"  align="right" 
                ><?php echo $grndate; ?></td>
				<td   valign="center"  align="right" 
                ><?php echo number_format($quantity,2,'.',','); ?></td>
				<td   valign="center"  align="right" 
                ><?php echo $podate; ?></td>
				<td   valign="center"  align="right" 
                ><?php echo number_format($poquantity,2,'.',','); ?></td>
				  <td   valign="center"  align="right" 
                ><?php echo number_format($amount,2,'.',','); ?></td>
				</tr>
				
				<?php
			}
			if($totalquantity > 0.00)
			{
			$avgrate = $totalamount/$totalquantity;
			}
			else{
				$avgrate = 0.00;
			}
				?>
           
           <tr >
		   <td   valign="center"  align="left"></td>
                <td   valign="center"  align="left" 
                >Total</td>
                <td   valign="center"  align="right" 
                ><?php echo number_format($avgrate,2,'.',','); ?></td>
				 <td   valign="center"  align="left"></td>
				  <td   valign="center"  align="right" 
                ><?php echo number_format($totalquantity,2,'.',','); ?></td>
				 <td   valign="center"  align="left"></td>
				<td   valign="center"  align="right" 
                ><?php echo number_format($totalpoquantity,2,'.',','); ?></td>
				  <td   valign="center"  align="right" 
                ><?php echo number_format($totalamount,2,'.',','); ?></td>
				</tr>
				
        
		
			   <?php
			   }
			   }
			   ?>
			 
          </tbody>
        </table></td>
			
      </tr>
	  
    </table>
</table>


