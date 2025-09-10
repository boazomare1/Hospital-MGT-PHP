
				  <?php
				  	$sno = '';
					$query2 = "select * from bankentryform where bankname = '$bankname1' and accnumber = '$bankname2' and transactiondate < '$transactiondateto'";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res2 = mysqli_fetch_array($exec2))
					{			
						$res2bankname = $res2["bankname"];
						$res2branch = $res2["branch"];
						$res2accnumber = $res2["accnumber"];
						$res2amount = $res2["amount"];
						$res2transactiontype = $res2["transactiontype"];
						$transactiondate = $res2["transactiondate"];
						$transactionmode = $res2["transactionmode"];
						$chequedate = $res2["chequedate"];
						$chequenumber = $res2["chequenumber"];
						$chequebank = $res2["chequebankname"];
						$chequebankbranch = $res2["chequebankbranch"];
						$personname = $res2["personname"];
						$remarks = $res2["remarks"];	
			
				
						if($res2transactiontype == 'OPENING BALANCE')
						{
							$res2openingbalanceamount = $res2amount;
							$res2openingbalanceamount1open = $res2openingbalanceamount1open + $res2openingbalanceamount;
							
						}
						if($res2transactiontype == 'DEPOSIT')
						{
							$res2depositamount = $res2amount;
							$res2depositamount1open = $res2depositamount1open + $res2depositamount;
							
						}
						if ($res2transactiontype == 'WITHDRAWAL')
						{
							$res2withdrawamount = $res2amount;
							$res2withdrawamount1open = $res2withdrawamount1open + $res2withdrawamount;
						}
						if ($res2transactiontype == 'BANK CHARGES')
						{
							$res2bankchargesamount = $res2amount;
							$res2bankchargesamount1open = $res2bankchargesamount1open + $res2bankchargesamount;
						}
						if ($res2transactiontype == 'INTEREST')
						{
							$res2interestamount = $res2amount;
							$res2interestamount1open = $res2interestamount1open + $res2interestamount;
						}
						
						$res2closingbalanceopen = $res2openingbalanceamount1open + $res2depositamount1open - $res2withdrawamount1open - $res2bankchargesamount1open + $res2interestamount1open;
				}
				?>


