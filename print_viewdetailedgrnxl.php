<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="print_viewdetailedgrn.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
		
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
$suplrname=isset($_REQUEST['suplrname'])?$_REQUEST['suplrname']:'';
$docnumber=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';
 $itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';


	$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
	$res1location = $res1["locationname"];
	 $res1locationcode= $res1["locationcode"];


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PO-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>


<?php 
$query1 = "select entrydate,billnumber,suppliername,supplierbillnumber,ponumber,sum(totalamount) as amount from purchase_details where  suppliername LIKE '%".$suplrname."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'grn%' group by billnumber";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			$resnw1=mysqli_num_rows($exec1);
			 $query2 = "select entrydate,billnumber,suppliername,ponumber,sum(totalamount) as amount from purchase_details where  suppliername LIKE '%".$suplrname."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'mgr%' group by billnumber";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw2=mysqli_num_rows($exec2);
			//$resnwcount=$resnw1+$resnw2;
?>

	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{?>
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1006" 
            align="left" border="0">
          <tbody>
          
          
              
         
            <tr>
              
              <td colspan="10" bgcolor="#ffffff" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="center"><strong>Purchase Invoice</strong><label class="number"></label></div></td>
              </tr>
   
	        <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>GRN No</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item Code</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Qty (In Units)</strong></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch No</strong></div></td>
                <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>EXP Dt</strong></div></td> 
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Username</strong></div></td>
              <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Entry Date</strong></div></td>
				 
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			

			
			$query1 = "select a.entrydate,a.mrnno,a.billnumber,a.suppliername,a.supplierbillnumber,a.ponumber,b.username,sum(a.totalamount) as amount, a.store from purchase_details a JOIN materialreceiptnote_details b ON (a.mrnno=b.billnumber) where  a.suppliername LIKE '%".$suplrname."%' and a.entrydate between '$ADate1' and '$ADate2' and a.billnumber LIKE 'grn%' and a.billnumber like '%$docnumber%' group by a.billnumber ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			
			while($res1=mysqli_fetch_array($exec1))
			{
			$date=$res1['entrydate'];
			$grnno=$res1['billnumber'];
			$suppliername=$res1['suppliername'];
			$invoiceno=$res1['supplierbillnumber'];
			$pono=$res1['ponumber'];		
			$mrnno=$res1['mrnno'];		
			$store = $res1['store'];
			$res1username = $res1['username'];
			
	
	
			
		 	$query11 = "select * from purchase_details where billnumber = '$grnno' and itemcode LIKE '%$itemcode%' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			 {
			$res11itemname= $res11['itemname'];
			$res11quantity = $res11['quantity'];
			//$res11itemquantity = $res11['itemquantity'];
			$res11itemfreequantity = $res11['itemfreequantity'];
			$res11batchnumber = $res11['batchnumber'];
			$res11expirydate = $res11['expirydate'];
			$res11packagename= $res11['packagename'];
			$res11itemcode= $res11['itemcode'];
			$res11itemtotalquantity= $res11['itemtotalquantity'];
			$res11allpackagetotalquantity= $res11['allpackagetotalquantity'];
			$res11quantityperpackage= $res11['quantityperpackage'];
			$res11rate= $res11['rate'];
			$res11totalamount= $res11['totalfxamount'];
			$res11discountpercentage= $res11['discountpercentage'];
			$res11itemtaxpercentage= $res11['itemtaxpercentage'];
			$res11subtotal= $res11['subtotal'];
			$res11costprice= $res11['costprice'];
			$entrydate= $res11['entrydate'];
			$username= $res11['username'];
			//$amount = $res11costprice * $res11itemtotalquantity;
		
			//$balanceqty = $orderedquantity - $res11quantity;
			
		    /*$query76 = "select * from materialreceiptnote_details where billnumber='$res11ponumber' and itemstatus=''";
			$exec76 = mysql_query($query76) or die(mysql_error());
			$number = mysql_num_rows($exec76);
		    $res76 = mysql_fetch_array($exec76);
			$itemname = $res76['itemname'];*/
			
			/*$query761 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
			$exec761 = mysql_query($query761) or die(mysql_error());
			$res761 = mysql_fetch_array($exec761);
			$orderedquantity = $res761['packagequantity'];*/
			
	
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
            <tr <?php echo $colorcode; ?>>
			               <td class="bodytext31" valign="center"  width="80"   align="center"><?php echo $sno = $sno + 1; ?></td>

        <td class="bodytext3 border" width="100"  align="left"><?php echo $grnno; ?></td>
				        <td class="bodytext3 border" width="200"  align="left"><?php echo $suppliername; ?></td>

		        <td class="bodytext3 border" width="200"  align="left"><?php echo $res11itemname; ?></td>
        <td class="bodytext3 border" width="80"  align="left"><?php echo $res11itemcode; ?></td>
        <td class="bodytext3 border" width="82" align="center"><?php echo number_format($res11allpackagetotalquantity,2,'.',','); ?></td>

        <td class="bodytext3 border" width="82" align="center"><?php echo $res11batchnumber; ?></td>
        <td class="bodytext3 border" width="100" align="center"><?php echo date('m/y',strtotime($res11expirydate)); ?></td>
        <td class="bodytext3 border" width="100" align="center" ><?php echo $res1username; ?></td>
        <td class="bodytext3 border" width="100" align="center"><?php echo $entrydate; ?></td>
       
    </tr>
    <?php 
	
	}
			}
		
			}
            ?>
              
              
              
         
              
          </tbody>
        </table>
