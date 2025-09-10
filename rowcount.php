<?php

$cashamount31='';
$cardamount31='';
$onlineamount31='';
$chequeamount31='';
$tdsamount31='';
$writeoffamount31='';
$taxamount31 = '';
$number=0;



		$query21 = "select * from master_purchase where suppliername like '%$suppliername%' and recordstatus <> 'deleted' and companyanum = '$companyanum';";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$billnumber = $res21['billnumber'];
			$billtotalamount = $res21['totalamount'];
			$query25 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = 'allocated'";
			
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25=mysqli_fetch_array($exec25))
			{
			$cashamount1 = $res25['cashamount'];
					$onlineamount1 = $res25['onlineamount'];
					$chequeamount1 = $res25['chequeamount'];
					$cardamount1 = $res25['cardamount'];
					$tdsamount1 = $res25['tdsamount'];
					$writeoffamount1 = $res25['writeoffamount'];
					$taxamount1 = $res25['taxamount'];
					
					$cashamount31 = $cashamount31 + $cashamount1;
					$cardamount31 = $cardamount31 + $cardamount1;
					$onlineamount31 = $onlineamount31 + $onlineamount1;
					$chequeamount31 = $chequeamount31 + $chequeamount1;
					$tdsamount31 = $tdsamount31 + $tdsamount1;
					$writeoffamount31 = $writeoffamount31 + $writeoffamount1;
					$taxamount31 = $taxamount31 + $taxamount1;
				}
				$totalpayment3 = $cashamount31 + $chequeamount31 + $onlineamount31 + $cardamount31 + $taxamount31;
				$netpayment3 = $totalpayment3 + $tdsamount31 + $writeoffamount31;
				$balanceamount3 = $billtotalamount - $netpayment3;
				//echo $balanceamount3;
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment3 = number_format($netpayment3, 2, '.', '');
				$balanceamount3 = number_format($balanceamount3, 2, '.', '');
				if ($balanceamount3 != '0.00')
			{
			$number=$number+1;
			
}
$cashamount31 = '0.00';
				$cardamount31 = '0.00';
				$onlineamount31 = '0.00';
				$chequeamount31 = '0.00';
				$tdsamount31 = '0.00';
				$writeoffamount31 = '0.00';
				$taxamount31 = '0.00';

				$totalpayment3 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billstatus = '0.00';
				}
			
?>