<?php
//session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
 $total = "0.00";
 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="deliveryreportsubtype.xls"');
header('Cache-Control: max-age=80');
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_accounts.php");

if ($companyanum == '') //For print view.
{
	if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
	//$username = $_SESSION['username'];
	if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_SESSION['companyanum'];
	if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }
	//$companyname = $_SESSION['companyname'];
	if (isset($_SESSION["financialyear"])) { $financialyear = $_SESSION["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_SESSION['financialyear'];
}
if ($companyanum == '')  // For excel export.
{
	if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
	//$username = $_REQUEST['username'];
	if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_REQUEST['companyanum'];
	if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
	//$companyname = $_REQUEST['companyname'];
	if (isset($_REQUEST["financialyear"])) { $financialyear = $_REQUEST["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_REQUEST['financialyear'];
}

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["account"])) { $searchsuppliername = $_REQUEST["account"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	
	
		//For generating first code
		include ("transactioncodegenerate1pharmacy.php");

		$query2 = "select * from settings_approval where modulename = 'collection' and status <> 'deleted'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$approvalrequired = $res2['approvalrequired'];
		if ($approvalrequired == 'YES')	{
			$approvalstatus = 'PENDING';
		}
		else {
			$approvalstatus = 'APPROVED';
		}
	
		$query8 = "select * from master_supplier where auto_number = '$cbfrmflag2'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$res8suppliername = $res8['suppliername'];
		
		//echo "inside if";
		$paymententrydate = $_REQUEST['paymententrydate'];
		$paymentmode = $_REQUEST['paymentmode'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['ADate1'];
		$bankname = $_REQUEST['bankname'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$paymentamount = $_REQUEST['paymentamount'];
		$pendingamount = $_REQUEST['pendingamount'];
		$remarks = $_REQUEST['remarks'];
			
		$balanceamount = $pendingamount - $paymentamount;
		$transactiondate = $paymententrydate;
		
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		
		$ipaddress = $ipaddress;
		$updatedate = $updatedatetime;
		
		$transactionmodule = 'PAYMENT';
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		//$cashamount = $paymentamount;
		//include ("transactioninsert1.php");
		foreach($_POST['billnum'] as $key => $value)
		{
		$billnum=$_POST['billnum'][$key];
		$name=$_POST['name'][$key];
		$accountname=$_POST['accountname'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
		$doctorname=$_POST['doctorname'][$key];
		//echo $doctorname;
		$balamount=$_POST['balamount'][$key];
		//echo $balamount;
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='unpaid';
		}
		//echo $billstatus;
		$adjamount=$_POST['adjamount'][$key];
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum)
		{
		$query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query99);
		$query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query89);
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$paymentamount', 
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	}
	}
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
			foreach($_POST['billnum'] as $key => $value)
		{
		$billnum3=$_POST['billnum'][$key];
		$name1=$_POST['name'][$key];
			$accountname=$_POST['accountname'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
			$doctorname=$_POST['doctorname'][$key];
			$balamount=$_POST['balamount'][$key];
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='unpaid';
		}
	
		$adjamount=$_POST['adjamount'][$key];
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum3)
		{
		
		//include ("transactioninsert1.php");
		$query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum3'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query99);
		
		$query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum3'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query89);
		
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus) 
		values ('$transactiondate','$particulars', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$paymentamount', 
		'$billnum3',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name1','$patientcode','$visitcode','$accountname','$doctorname','$billstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	}
	}
		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		
		foreach($_POST['billnum'] as $key => $value)
		{
		$billnum1=$_POST['billnum'][$key];
		$name2=$_POST['name'][$key];
		$accountname=$_POST['accountname'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
			$doctorname=$_POST['doctorname'][$key];
		$balamount=$_POST['balamount'][$key];
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='unpaid';
		}
	
		$adjamount=$_POST['adjamount'][$key];
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum1)
		{
		//include ("transactioninsert1.php");
		$query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum1'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query99);
		
		$query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum1'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query89);
		
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype', '$transactionamount',
		'$paymentamount','$chequenumber',  '$billnum1',  '$billanum', 
		'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$name2','$patientcode','$visitcode','$accountname','$doctorname','$billstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		}
		
		if ($paymentmode == 'WRITEOFF')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'WRITEOFF';
		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		
		foreach($_POST['billnum'] as $key => $value)
		{
		$billnum2=$_POST['billnum'][$key];
		$name3=$_POST['name'][$key];
			$accountname=$_POST['accountname'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
			$doctorname=$_POST['doctorname'][$key];
		$balamount=$_POST['balamount'][$key];
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='unpaid';
		}

		$adjamount=$_POST['adjamount'][$key];
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum2)
		{
		//include ("transactioninsert1.php");
		$query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum2'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query99);
		$query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum2'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query89);
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,  
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus) 
		values ('$transactiondate', '$particulars',
		'$transactionmode', '$transactiontype', '$transactionamount', '$paymentamount', 
		'$billnum2',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name3','$patientcode','$visitcode','$accountname','$doctorname','$billstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		}
		header ("location:detailedfinalizedbillsreport.php?st=1");
		exit;
		
		//$errmsg = "Success. Payment Entry Updated.";

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $searchsuppliername; ?></strong></td>
              <td colspan="3" bgcolor="#ffffff" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
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
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="12%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
              <td width="17%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
              <td width="12%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
              <td width="2%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="24%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$query25 = "select * from master_subtype where subtype = '$searchsuppliername'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$searchsubtypeanum1 = $res25['auto_number'];
			
			$query21 = "select * from master_accountname where subtype = '$searchsubtypeanum1' and recordstatus <> 'DELETED' order by subtype desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select * from billing_paylater where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			
			$query23 = "select * from billing_ip where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2'"; 
		    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res23 = mysqli_fetch_array($exec23);
			$res23accountname = $res23['accountname'];
			
			$query24 = "select * from billing_ipcreditapproved where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2'"; 
		    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res24 = mysqli_fetch_array($exec24);
			$res24accountname = $res24['accountname'];
			
			if( $res22accountname != '' || $res23accountname != '' || $res24accountname != '')
			{
			?>
			<tr bgcolor="#ffffff">
            <td colspan="6"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
            </tr>
			<?php
		  $query2 = "select * from billing_paylater where accountname = '$res22accountname' and billdate between '$ADate1' and '$ADate2' group by billno order by accountname, billdate desc"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
          $res2totalamount = $res2['totalamount'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  $res2accountname = $res2['accountname'];
		  
		  $total = $total + $res2totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ffffff"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ffffff"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res2totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ffffff"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ffffff"class="bodytext31" valign="center"  align="left">&nbsp;</td>
           </tr>
			<?php
			}
			
		  $query3 = "select * from billing_ip where accountname = '$res23accountname' and billdate between '$ADate1' and '$ADate2' group by billno order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];

		  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ffffff"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ffffff"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ffffff"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ffffff"class="bodytext31" valign="center"  align="left">&nbsp;</td>
           </tr>
			<?php
			}
			 $query3 = "select * from billing_ipcreditapproved where accountname = '$res24accountname' and billdate between '$ADate1' and '$ADate2' group by billno order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];

		  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ffffff"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ffffff"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ffffff"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ffffff"class="bodytext31" valign="center"  align="left">&nbsp;</td>
           </tr>
			<?php
			}
			}
			}
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
                bgcolor="#ffffff"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
			</tr>
          </tbody>
        </table>