<?php
include ("db/db_connect.php");
$billno = $_REQUEST['billno'];
$accountnameano = $_REQUEST['accountnameano'];
$docno = $_REQUEST['docno'];
$ADate1 = $_REQUEST['ADate1'];
$ADate2 = $_REQUEST['ADate2'];
$searchallinvoiceno = trim($_REQUEST['searchallinvoiceno']);
$searchallaccountsearchid = $_REQUEST['searchallaccountsearchid'];
//$sno = $_REQUEST['totalrow'];
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
			if($searchallaccountsearchid=='' || $searchallaccountsearchid==0){
			  $query213 = "select subtype,id from master_accountname where auto_number='$accountnameano'";
			  $exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die ("Error in Query213".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num213 = mysqli_num_rows($exec213);
			  $res213 = mysqli_fetch_array($exec213);
			  $subtype3 = $res213['subtype'];
			  $accountnameid = $res213['id'];
			} else{
				$subtype3=$searchallaccountsearchid;
			}
			  $query214 = "select id, auto_number, accountname from master_accountname where subtype = '$subtype3' ";
			  $exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die ("Error in Query214".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res214 = mysqli_fetch_array($exec214))
			  {
				  $accountnameid4 = $res214['id'];
				  $accountnameano4 = $res214['auto_number'];
				  $suppliername = $res214['accountname'];
				  
			 // $query2 = "SELECT patientname, patientcode, visitcode, billnumber, docno, transactiondate, billbalanceamount,discount, accountname, accountnameid, accountnameano from master_transactionpaylater where docno!='$docno' and accountnameano = '$accountnameano4' and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype not in ('pharmacycredit','paylatercredit') and transactiondate between '$ADate1' and '$ADate2' order by transactiondate ASC";
			 
			  $query2 = "SELECT a.patientname, a.patientcode, a.visitcode, a.billnumber, a.docno, b.transactiondate, a.billbalanceamount,a.discount, a.accountname, a.accountnameid, a.accountnameano from master_transactionpaylater as a left join  master_transactionpaylater as b on a.billnumber=b.billnumber and a. accountcode=b.accountcode and b.transactiontype='finalize'	  
			  where a.docno!='$docno' and a.accountnameano = '$accountnameano4'  and a.transactionstatus <> 'onaccount' and a.acc_flag = '0'  and a.transactiontype not in ('pharmacycredit','paylatercredit') and b.transactiondate between '$ADate1' and '$ADate2' and a.billnumber like '%$searchallinvoiceno%' order by b.transactiondate ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount21 = $rowcount21 + $rowcount2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$accountnameid = $res2['accountnameid'];
				$accountnameano = $res2['accountnameano'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				$doctorname='';
				$name = $suppliername1;
				$billnumber = $res2['billnumber'];
				if($billnumber == '')
				{
					$billnumber = $res2['docno'];
				}
				$billdate = $res2['transactiondate'];
				
				$billdate_one = $res2['transactiondate'];
				$billtotalamount = $res2['billbalanceamount'];
				
				// $accountname = ($suppliername!="")?$suppliername:$res2['accountname'];
				$query_accountname = "select id, auto_number, accountname from master_accountname where id = '$accountnameid' and recordstatus <> 'deleted'";
				$exec_accountname = mysqli_query($GLOBALS["___mysqli_ston"], $query_accountname) or die ("Error in Query_accountname".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_accountname = mysqli_fetch_array($exec_accountname)){
					$accountname=$res_accountname['accountname'];
				}
				$query90 = "select customerfullname, memberno from master_customer where customercode = '$patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];
				
				$ssno = $ssno + 1;
				
				$balanceamount = $billtotalamount;
				$netpayment = '0.00';
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
			//echo $balanceamount;
			// if ($balanceamount != '0.00' ){
			// 	$balanceamount -= $res2['discount'];
			// }
			if ($balanceamount != '0.00' )
			{
			
				$sno = $sno + 1;
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($sno & 1); 
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" class="chkalloc" id="acknowpending<?php echo $sno; ?>" value="<?php echo $billnumber.'||'.$accountnameid; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php // echo $name; ?>(<?php // echo $visitcode; ?>)</div></td> -->
              <?php 	
			  $split1 = $billnumber;
				$split1 = explode('-',$split1);
				$split2 = $split1['0'];
				$split3 = $split1['1'];
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
			  if($split2=='DBI'){ 
			  	$query55 = "select itemname from debtors_invoice where billnumber='$billnumber'";
				$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res55 = mysqli_fetch_array($exec55);
				$refno_billn = $res55['itemname'];
				// we can bring the refbillno from here too, but its added in future
				$query552 = "select patientname from crdradjustment_detail where debtor_billnum='$billnumber'";
				$exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res552 = mysqli_fetch_array($exec552);
				$refno_patientname = $res552['patientname'];
			   ?>
			  	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $refno_patientname; ?>(<?php echo $refno_billn; ?>)</div></td>
			  <?php 	}else{	?>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
               <?php 	}	?>
			  <input type="hidden" name="patientcode[]" id="patientcode<?php echo $sno; ?>" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode<?php echo $sno; ?>" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname<?php echo $sno; ?>" value="<?php echo $suppliername; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">
			  <input type="hidden" name="docno1" value="<?php echo $docno; ?>">
			  <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">
			  <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">
			  <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">
			  <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">
              <input type="hidden" name="accountnameano[]" id="accountnameano<?php echo $sno; ?>" value="<?php echo $accountnameano; ?>">
			  <input type="hidden" name="accountnameid[]" id="accountnameid<?php echo $sno; ?>" value="<?php echo $accountnameid; ?>">
			  <input type="hidden" name="receivableamount1" id="receivableamount<?php echo $sno; ?>" value="<?php echo $receivableamount; ?>" size="6" class="bal">
			  
			  
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $accountname; ?></div></td>
			  
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $mrdno; ?></div></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $preauthno; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div>
             </td>
              
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
			  <input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php echo $balanceamount; ?>">
                <?php if ($balanceamount != '0.00') echo number_format($balanceamount,2,'.',','); //echo number_format($balanceamount, 2); ?>
              </div></td>
               <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><input autocomplete="off" class="bali" type="text" name="discount[]" id="discount<?php echo $sno; ?>" size="7" onClick="checkboxcheck('<?php echo $sno; ?>')" onKeyup="balancecalc_dis('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
               
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><input autocomplete="off" class="bali" type="text" name="decline[]" id="decline<?php echo $sno; ?>" size="7" onClick="checkboxcheck('<?php echo $sno; ?>')" onKeyup="balancecalc_dec('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"> <input type="hidden" name="bill_date_one[]" id="bill_date_one<?php echo $sno; ?>" value="<?php echo $billdate_one; ?>"></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><input autocomplete="off" class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" size="7" onClick="checkboxcheck('<?php echo $sno; ?>')" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
			     
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input autocomplete="off" type="text" name="remarks[]" id="remarks<?php echo $sno; ?>" size="20" onKeyup="resaonsearch('<?php echo $sno;?>')" placeholder="Search Reasons.."/></td>
            </tr>
			
            <?php
				//$totalbalance = $totalbalance + $balanceamount;
				}
			}
			}
			
			?>
            