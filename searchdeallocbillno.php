<?php

include ("db/db_connect.php");

$billno = $_REQUEST['billno'];

 $accountnameano = $_REQUEST['accountnameano'];

$docno = $_REQUEST['docno'];

$totalrow = $_REQUEST['totalrow'];

$sno = 0;			

$num=0;

$ssno = 0;

$colorloopcount = 0;

$totalbalance = 0;

$totalamount=0;

$rowcount21 = 0;

 $query5="select * from master_transactionpaylater where docno='$docno' group by docno";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$entrydate = $res5['transactiondate'];

$totalamount = $res5['receivableamount'];		  

$receivableamount = $totalamount;

$paymentmode = $res5['transactionmode'];


if($paymentmode == '')

{

$paymentmode = 'By Credit Note';

}

$number = $res5['chequenumber'];

$date = $res5['chequedate'];

$bankname = $res5['bankname'];

$suppliername = $res5['accountname'];



			   $query2 = "select * from master_transactionpaylater where docno='$docno' and billnumber like '%$billno%' and recordstatus='allocated' group by accountnameid, billnumber";

			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num2 = mysqli_num_rows($exec2);

			 // echo $num2;

			  while ($res2 = mysqli_fetch_array($exec2))

			  {

				  $sno = $sno + 1;

			 	  $billnumber = $res2['billnumber'];
			 		 $accountnameid123 = $res2['accountnameid'];
						$subtypeano123 = $res2['subtypeano'];
			 	   // $accountnameano1 = $res2['accountnameano'];
			 	   $discount = $res2['discount'];
				    $decline = $res2['decline'];
					$remarks = $res2['remarks'];
			 	   if($discount==""){
			 	   		$discount=0;
			 	   }
				   if($decline==""){
			 	   		$decline=0;
			 	   }

				  $patientname = $res2['patientname'];
				  
				  
				  $patientcode = $res2['patientcode'];

				  $visitcode = $res2['visitcode'];

				  if($patientname == '')

				  {

				  $query43 = "select * from master_visitentry where visitcode='$visitcode'";

				  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res43 = mysqli_fetch_array($exec43);

				  $patientname = $res43['patientfullname'];

				  }

				  

				  $query23 = "select * from billing_paylater where billno='$billnumber'";
				  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res23 = mysqli_fetch_array($exec23);
				  $billamount = $res23['totalamount'];
				  $transactiondate = $res2['transactiondate'];
				  $amount = $res2['transactionamount'];
				  $balanceamount = $res2['billbalanceamount'];

				  // if($billamount==''){	
						//    $query23 = "select * from billing_ip where billno='$billnumber'";
						//   $exec23 = mysql_query($query23) or die(mysql_error());
						//   $res23 = mysql_fetch_array($exec23);
						//   $billamount = $res23['transactionamount'];
						// }

				  if($billamount==''){	
						   $query23 = "SELECT transactionamount from master_transactionpaylater where  billnumber = '$billnumber' and transactiontype<>'PAYMENT' AND accountnameid='$accountnameid123' and subtypeano='$subtypeano123' ";
						  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res23 = mysqli_fetch_array($exec23);
						  $billamount = $res23['transactionamount'];
						}

			  

			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";

			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

			  //$res3 = mysql_fetch_array($exec3);

			  //$res3ipnumber = $res3['ipnumber'];

			  
			$query90 = "select customerfullname, memberno from master_customer where customercode = '$patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];
			  

			  $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($sno & 1); 

			  $colorcode = '';

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

				$split1 = $billnumber;
				$split1 = explode('-',$split1);
				$split2 = $split1['0'];

			$preauthno='';

				if($split2=='CB' || $split2=='OP'){
                    $bill_fetch_auth="SELECT preauthcode from billing_paylater where billno='$billnumber' ";
			        $exec_bill_auth = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch_auth) or die ("Error in bill_fetch_auth".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2_auth = mysqli_fetch_array($exec_bill_auth);
                    $preauthno=$res2_auth["preauthcode"];
				}elseif($split2=='IPF'){

					$bill_fetch_auth="SELECT preauthcode from billing_ip where billno='$billnumber' ";
			        $exec_bill_auth = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch_auth) or die ("Error in bill_fetch_auth".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2_auth = mysqli_fetch_array($exec_bill_auth);
                    $preauthno=$res2_auth["preauthcode"];

				}elseif(strpos($split2, 'IPFCA') !== false){
					$bill_fetch_auth="SELECT preauthcode from billing_ipcreditapproved where billno='$billnumber' ";
			        $exec_bill_auth = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch_auth) or die ("Error in bill_fetch_auth".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2_auth = mysqli_fetch_array($exec_bill_auth);
                    $preauthno=$res2_auth["preauthcode"];
				}

			  ?>

              <tr <?php echo $colorcode; ?>>

              
                <td class="bodytext31" valign="center"  align="left">
						<input type="hidden" name="accountnameid123[]" value="<?php echo $accountnameid123; ?>">
					              	<input type="hidden" name="subtypeano123[]" value="<?php echo $subtypeano123; ?>">


                	<?php echo $sno; ?></td>

                <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?>(<?php echo $visitcode; ?>)</td>
				
				<td class="bodytext31" valign="center"  align="left"><?php echo $mrdno; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $preauthno; ?></td>
				
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $billnumber; ?></span></div>
                </div></td><input type="hidden" name="billnum2[]" value="<?php echo $billnumber; ?>">

				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="center"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"><span class="bodytext32"><?php echo number_format($billamount,2,'.',',');   ?></span></div>

                </div></td>

                 <!-- <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="right"><span class="bodytext32"><?php echo $discount; ?></span></div> </div></td><input type="hidden" name="discount_dealloc" id="discount_dealloc<?php echo $sno; ?>"> -->
                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="right"><span class="bodytext32"><?php echo number_format($discount,2,'.',','); ?></span></div> </div></td><input type="hidden" name="discount_dealloc" id="discount_dealloc<?php echo $sno; ?>">
                 
                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="right"><span class="bodytext32"><?php echo number_format($decline,2,'.',','); ?></span></div> </div></td><input type="hidden" name="decline_dealloc" id="decline_dealloc<?php echo $sno; ?>">

					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="right"><span class="bodytext32"><?php echo number_format($amount,2,'.',','); ?></span></div> </div></td><input type="hidden" name="amt" id="amt<?php echo $sno; ?>">
					 

           <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="right"><span class="bodytext32"><?php echo number_format($balanceamount,2,'.',','); ?></span></div>

                </div></td>
                
                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="center"><span class="bodytext32"><?php echo $remarks; ?></span></div>

                </div></td>

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="center"><input type="checkbox" name="acknow1[]" id="acknow1<?php echo $sno; ?>" value="<?php echo $billnumber.'||'.$accountnameid123; ?>" onClick="updatebox1('<?php echo $sno; ?>','<?php echo $amount; ?>','<?php echo $num2; ?>')"></div></td>

                </tr>

			  <?php

			  }

			  //}

			  ?>