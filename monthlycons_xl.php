<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$transferquantity2 = '';
$transferamount2 = '0';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="stockreportbyitem.xls"');
header('Cache-Control: max-age=80');

$storecode1=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$colorloopcount = '';

$curryear = date('Y');
$selectedyear =isset( $_REQUEST['year'])?$_REQUEST['year']:$curryear;
 $sno=0;
 
 $totaldiffday='';
 $searchmonth=isset($_REQUEST['month'])?$_REQUEST['month']:date('m');
$searchyear=isset($_REQUEST['year'])?$_REQUEST['year']:date('Y');
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 $fromdate=isset($_REQUEST['fromdate'])?$_REQUEST['fromdate']:'';
	 $todate=isset($_REQUEST['todate'])?$_REQUEST['todate']:'';
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>

<body >

	<table width="1426" cellpadding="2" cellspacing="0">

     <tr>
  <td class="bodytext31" valign="center"  align="left" width="34" 
                bgcolor="#ffffff"><div align="left"><strong>S.No</strong></div></td>
    <td class="bodytext31" valign="center"  align="left" width="80" 
                bgcolor="#ffffff"><div align="left"><strong>Itemcode</strong></div></td>
    <td class="bodytext31" valign="center"  align="left" width="107" 
                bgcolor="#ffffff"><div align="left"><strong>Item Name</strong></div></td>
    <td class="bodytext31" valign="center"  align="left" width="118"
                bgcolor="#ffffff"><div align="left"><strong>Generic Name</strong></div></td>
                 <td class="bodytext31" valign="center"  align="left" width="55"
                bgcolor="#ffffff"><div align="left"><strong>Batch No</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" width="130" 
                bgcolor="#ffffff"><div align="left"><strong>Movement Qty</strong></div></td>
    <td class="bodytext31" valign="center"  align="left" width="131" 
                bgcolor="#ffffff"><div align="left"><strong>Consumption per day</strong></div></td>
    <td class="bodytext31" valign="center"  align="left"  width="139"
                bgcolor="#ffffff"><div align="left"><strong>No of Days out of stock</strong></div></td>
    <td class="bodytext31" valign="center"  align="left"  width="191"
                bgcolor="#ffffff"><div align="left"><strong>Avg Monthly consumption</strong></div></td>
    <td class="bodytext31" valign="center"  align="left"  width="134"
                bgcolor="#ffffff"><div align="left"><strong>Max stock(6months)</strong></div></td>
    <td class="bodytext31" valign="center"  align="left" width="136" 
                bgcolor="#ffffff"><div align="left"><strong>Min Stock(2months)</strong></div></td>
    <td class="bodytext31" valign="center"  align="left" width="121" 
                bgcolor="#ffffff"><div align="left"><strong>ROL (3months)</strong></div></td>
  </tr>
     <?php
	   
 $itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';
 $genericcode=isset($_REQUEST['genericcode'])?$_REQUEST['genericcode']:'';


	if($itemcode !="" || $genericcode !="")
	{
   $querymedicine="select itemcode,itemname,genericname from master_medicine where (itemcode='$itemcode' or itemcode='$genericcode') order by auto_number desc";
	}
	else
	{
 		$querymedicine="select itemcode,itemname,genericname from master_medicine order by auto_number desc";
	}
 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymedicine) or die ("Error in querymedicine".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow=mysqli_num_rows($exec1);
			if($numrow>0)
			{
				while ($res1 = mysqli_fetch_array($exec1))
			{
			$itemcode1=$res1['itemcode'];
			$itemname1=$res1['itemname'];
			$genericname1=$res1['genericname'];
			
  $number = cal_days_in_month(CAL_GREGORIAN, $searchmonth, $searchyear); 

 // $fromdate=$searchyear.'-'.$searchmonth.'-'.'01';
// $todate=$searchyear.'-'.$searchmonth.'-'.$number;
 
  $outquery="select fifo_code,batchnumber from transaction_stock where storecode like '%$storecode1%' and  transaction_date between '$fromdate' and '$todate' and itemcode='$itemcode1' and locationcode='$locationcode' group by fifo_code,batchnumber order by auto_number desc";	
		$exeqry=mysqli_query($GLOBALS["___mysqli_ston"], $outquery)or die("Error in outquery".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($reqry=mysqli_fetch_array($exeqry))
		{
			$resbatch=$reqry['batchnumber'];
			$resfifo=$reqry['fifo_code'];
 
    $sumstock="select sum(transaction_quantity) as trans from transaction_stock where storecode like '%$storecode1%' and itemcode='$itemcode1' and  description like '%Sales%' and transaction_date between '$fromdate' and '$todate' and locationcode='$locationcode' and fifo_code='$resfifo' and batchnumber='$resbatch'";

 $exest=mysqli_query($GLOBALS["___mysqli_ston"], $sumstock) or die("Error in sumstock".mysqli_error($GLOBALS["___mysqli_ston"]));
 $resst=mysqli_fetch_array($exest);
 $sumst=$resst['trans'];
// echo "<br>";
  $sumstock1="select sum(transaction_quantity) as trans from transaction_stock where storecode like '%$storecode1%' and itemcode='$itemcode1' and description like '%Stock Transfer%' and transaction_date between '$fromdate' and '$todate' and locationcode='$locationcode' and fifo_code='$resfifo' and batchnumber='$resbatch'";
 $exest1=mysqli_query($GLOBALS["___mysqli_ston"], $sumstock1) or die("Error in sumstock1".mysqli_error($GLOBALS["___mysqli_ston"]));
 $resst1=mysqli_fetch_array($exest1);
 $sumst1=$resst1['trans'];
 
 $totst=$sumst+$sumst1;
 
 $totalcons=$number * $totst;
 // $totalcons= round($totst/$number);
			
		
	  		
         $queryoutofstock="Select transaction_date FROM transaction_stock Where storecode like '%$storecode1%' and  transaction_date between '$fromdate' and '$todate' and itemcode='$itemcode1' and batch_stockstatus = 0 and batch_quantity = 0 and locationcode='$locationcode' and fifo_code='$resfifo' and batchnumber='$resbatch' order by auto_number desc";
	$exoutofstock=mysqli_query($GLOBALS["___mysqli_ston"], $queryoutofstock) or die("error in queryoutofstock".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numout=mysqli_num_rows($exoutofstock);
	if($numout>0)
	{
		
	while($resoutofstock=mysqli_fetch_array($exoutofstock))
	{
		    $daysst=$resoutofstock['transaction_date'];
		 
		   $queryoutofstock1="Select transaction_date FROM transaction_stock Where storecode like '%$storecode1%' and  transaction_date >='$daysst' and itemcode='$itemcode1' and batch_stockstatus = 1 and batch_quantity > 0 and locationcode='$locationcode' and fifo_code='$resfifo' and batchnumber='$resbatch' order by auto_number asc";
	
	$exoutofstock1=mysqli_query($GLOBALS["___mysqli_ston"], $queryoutofstock1) or die("error in queryoutofstock1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resstout=mysqli_fetch_array($exoutofstock1);
	
	 $avst=$resstout['transaction_date'];

if($avst=='')
{
	$avst=$todate;
}

/* $diff = abs(strtotime($daysst)-strtotime($avst));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
  $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));*/
  
  
   
     $your_date = strtotime($daysst);
     $datediff = abs(strtotime($avst) - $your_date);
     $days= floor($datediff/(60*60*24));
  
 $totaldiffday=$totaldiffday+$days;
	}
	
	}
	else
	{
		   $queryoutofstock="Select transaction_date FROM transaction_stock Where storecode like '%$storecode1%' and  transaction_date between '$fromdate' and '$todate' and itemcode='$itemcode1' and batch_stockstatus = 1 and batch_quantity > 0 and locationcode='$locationcode' and fifo_code='$resfifo' and batchnumber='$resbatch' order by auto_number asc";
	$exoutofstock=mysqli_query($GLOBALS["___mysqli_ston"], $queryoutofstock) or die("error in queryoutofstock".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numout=mysqli_num_rows($exoutofstock);
	if($numout>0)
	{
	$resoutofstock=mysqli_fetch_array($exoutofstock);
	
	$daysst=$resoutofstock['transaction_date'];
	
	
	  $your_date = strtotime($daysst);
     $datediff = abs(strtotime($fromdate) - $your_date);
     $days= floor($datediff/(60*60*24));
  
 $totaldiffday=$totaldiffday+$days;
	
	}
	else
	{
		$totaldiffday='0';
	}
	}
	
	$nday=$number-$totaldiffday;
	if($nday >0)
	{
 	$consumst=round($number*($totst/($nday)));
	//$consumst=round(($totst/($nday)));
	}
	else
	{
		$consumst=round(($totst/(1)));
		//$consumst=round($number*($totst/(1)));
	}
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
	 /*	$itemlinking="select * from master_itemtosupplier where itemcode='$itemcode1' group by itemcode order by auto_number desc";	
		$exelink=mysql_query($itemlinking);
		$reslink=mysql_fetch_array($exelink);
		
		$max=$reslink['maximum'];
		$min=$reslink['minimum'];
		$rol=$reslink['rol'];
			*/
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
			<tr <?php //echo $colorcode; ?>  >
  <td class="bodytext31" valign="center"  align="left" width="34"><div align="left"><?php echo $sno+=1 ; ?></div></td>
     <td class="bodytext31" valign="center"  align="left" width="80"><div align="left"><?php echo $itemcode1 ; ?></div></td>
    <td class="bodytext31" valign="center"  align="left" width="107"><div align="left"><?php echo $itemname1 ; ?></div></td>
    <td class="bodytext31" valign="center"  align="left" width="118"><div align="left"><?php echo $genericname1 ; ?></div></td>
    <td class="bodytext31" valign="center"  align="left" width="55"><div align="left"><?php echo $resbatch; ?></div></td>
    <td class="bodytext31" valign="center"  align="left" width="130"><div align="left"><?php echo $totst; ?></div></td>
     <td class="bodytext31" valign="center"  align="left" width="131"><div align="left"><?php echo $totalcons ; ?></div></td>
     <td class="bodytext31" valign="center"  align="left" width="139"><div align="left"><?php echo $totaldiffday ; ?></div></td>
    <td class="bodytext31" valign="center"  align="left" width="191"><div align="left"><?php echo $consumst ; ?></div></td>
    <td class="bodytext31" valign="center"  align="left" width="134"><div align="left"><?php echo ($consumst *6); ?></div></td>
     <td class="bodytext31" valign="center"  align="left" width="136"><div align="left"><?php echo ($consumst *2); ?></div></td>
     <td class="bodytext31" valign="center"  align="left" width="121"><div align="left"><?php echo ($consumst *3); ?></div></td>
     
  </tr>
            <?php
			
			$totalcons='';
			$totaldiffday='';
			$consumst='';
			}
			}
			}
 ?>

  </table>
</table>
  </td>
  </tr>
      </table>

</body>
</html>
