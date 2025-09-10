<?php
$cashamount21='';
$cardamount21='';
$onlineamount21='';
$chequeamount21='';
$tdsamount21='';
$writeoffamount21='';
$number=0;

		$query2 = "select * from billing_paylater where referalname='$suppliername' and billstatus='paid' and doctorstatus='unpaid'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				$query66="select * from consultation_referal where patientvisitcode='$visitcode'";
				$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66);
				$res66=mysqli_fetch_array($exec66);
				$num66=mysqli_num_rows($exec66);
				if($num66 == 0)
				{
				$doctorname='';
				}
				else
				{
				$doctorname=$res66['referalname'];
				}
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				$billnumber = $res2['billno'];
				$billdate = $res2['billdate'];
				$referalname=$res2['referalname'];
				$query76="select * from master_doctor where doctorname='$referalname'";
				$exec76=mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res76=mysqli_fetch_array($exec76);
				$billtotalamount = $res76['consultationfees'];
				
				
				
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$taxamount1 = $res3['taxamount'];
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					$taxamount21 = $taxamount21 + $taxamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
	
			if ($balanceamount != '0.00')
			{
			$number=$number+1;
			}
			
			//echo $balanceamount3;
			$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
				
				
	}
	
	$query2 = "select * from billing_paynow where referalname='$suppliername' and billstatus='paid' and doctorstatus='unpaid'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				$query66="select * from consultation_referal where patientvisitcode='$visitcode'";
				$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66);
				$res66=mysqli_fetch_array($exec66);
				$num66=mysqli_num_rows($exec66);
				if($num66 == 0)
				{
				$doctorname='';
				}
				else
				{
				$doctorname=$res66['referalname'];
				}
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				$billnumber = $res2['billno'];
				$billdate = $res2['billdate'];
				$referalname=$res2['referalname'];
			
				$query77="select * from master_doctor where doctorname='$referalname'";
				$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res77=mysqli_fetch_array($exec77);
				$billtotalamount = $res77['consultationfees'];
				
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$taxamount1 = $res3['taxamount'];
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					$taxamount21 = $taxamount21 + $taxamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
			if ($balanceamount != '0.00')
			{
			$number=$number+1;
			}
			
			//echo $balanceamount3;
			$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
				
				
	}
	$query2 = "select * from billing_ipprivatedoctor where description='$suppliername' and billstatus='paid' and doctorstatus='unpaid'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				$billnumber = $res2['docno'];
				$billdate = $res2['recorddate'];
				$referalname=$res2['description'];
				$billtotalamount = $res2['amount'];
				
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and accountname = '$suppliername' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$taxamount1 = $res3['taxamount'];
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					$taxamount21 = $taxamount21 + $taxamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
			if ($balanceamount != '0.00')
			{
			$number=$number+1;
			
			}
			
			//echo $balanceamount3;
			$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
				
				
	}
			
			$query411 = "select * from master_visitentry where consultingdoctor='$suppliername' and billtype = 'PAY NOW'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec411 = mysqli_query($GLOBALS["___mysqli_ston"], $query411) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec411);
			//echo $rowcount2;
			while ($res411 = mysqli_fetch_array($exec411))
			{
				$suppliername1 = $res411['patientfullname'];
				$patientcode = $res411['patientcode'];
				$visitcode = $res411['visitcode'];
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				
				$query29 = "select * from billing_consultation where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
				$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res29 = mysqli_fetch_array($exec29);
				
				
				$billnumber = $res29['billnumber'];
				$billdate = $res29['billdate'];
				$referalname=$res411['consultingdoctor'];
				
				$billtotalamount = $res29['consultation'];
				
				
				
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and accountname = '$suppliername' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			
			$billdate = substr($billdate, 0, 10);
			$date1 = $billdate;

			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			
			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and accountname = '$suppliername' and companyanum='$companyanum' and recordstatus = '' order by auto_number desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			 $numb=mysqli_num_rows($exec3);
			 $totalnumb=$totalnumb+$numb;
			 
			$lastpaymentdate = $res3['transactiondate'];
			$lastpaymentdate = substr($lastpaymentdate, 0, 10);
			
			if ($lastpaymentdate != '')
			{
				$date1 = $lastpaymentdate;
				$date2 = date("Y-m-d");  
				$diff = abs(strtotime($date2) - strtotime($date1));  
				$days = floor($diff / (60*60*24));  
				$daysafterpaymentdate = $days;
				
				$dotarray = explode("-", $lastpaymentdate);
				$dotyear = $dotarray[0];
				$dotmonth = $dotarray[1];
				$dotday = $dotarray[2];
				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
				
			}
			else
			{
				$daysafterpaymentdate = '';
				$lastpaymentdate = '';
			}			

			//echo $balanceamount;
			if ($balanceamount != '0.00')
			{
			$number=$number+1;
			
			}
			
			//echo $balanceamount3;
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
				
	}		
			$query412 = "select * from master_visitentry where consultingdoctor='$suppliername' and billtype = 'PAY LATER'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec412 = mysqli_query($GLOBALS["___mysqli_ston"], $query412) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec412);
			//echo $rowcount2;
			while ($res412 = mysqli_fetch_array($exec412))
			{
				$suppliername1 = $res412['patientfullname'];
				$patientcode = $res412['patientcode'];
				$visitcode = $res412['visitcode'];
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				
				$query30 = "select * from billing_paylaterconsultation where patientcode = '$patientcode' and visitcode = '$visitcode'";
				$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res30 = mysqli_fetch_array($exec30);
				
				
				$billnumber = $res30['billno'];
				$billdate = $res30['billdate'];
				$referalname=$res412['consultingdoctor'];
				
				$billtotalamount = $res30['totalamount'];
				
				
				
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and accountname = '$suppliername' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			
			$billdate = substr($billdate, 0, 10);
			$date1 = $billdate;
			if($billdate != '')
			{
			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
			}
			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			
			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and accountname = '$suppliername' and companyanum='$companyanum' and recordstatus = '' order by auto_number desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			 $numb=mysqli_num_rows($exec3);
			 $totalnumb=$totalnumb+$numb;
			 
			$lastpaymentdate = $res3['transactiondate'];
			$lastpaymentdate = substr($lastpaymentdate, 0, 10);
			
			if ($lastpaymentdate != '')
			{
				$date1 = $lastpaymentdate;
				$date2 = date("Y-m-d");  
				$diff = abs(strtotime($date2) - strtotime($date1));  
				$days = floor($diff / (60*60*24));  
				$daysafterpaymentdate = $days;
				
				$dotarray = explode("-", $lastpaymentdate);
				$dotyear = $dotarray[0];
				$dotmonth = $dotarray[1];
				$dotday = $dotarray[2];
				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
				
			}
			else
			{
				$daysafterpaymentdate = '';
				$lastpaymentdate = '';
			}			

			//echo $balanceamount;
			if ($balanceamount != '0.00')
			{
			$number=$number+1;
			
			}
			
			//echo $balanceamount3;
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
				
	}		
		
	
	

?>