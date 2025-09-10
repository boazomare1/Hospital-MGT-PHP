<?php
header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="Sales_dump_.xls"');
header('Cache-Control: max-age=80');


session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$res5consamount= '0.00';
$reference_no='';
$resip12rate1='';
$resipdeprate1='';
$resip10rate1='';
$resip11rate1='';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$total = '0.00';
$total_pos= '0.00';
$refund_total = '0.00';
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$grandtotal = 0;
$refund_gtotal = 0;
$after_refund = 0;
$total_neg="0.00";
$total_final="0.00";
$total_postive="0.00";
$total_final="0.00";
$download="";
$res10username="";
$res5labusername="";
$total = '0.00';
$res5labitemrate1 = '0.00'; 
$res6servicesitemrate1 = '0.00';
$res7pharmacyitemrate1 = '0.00';
$res8radiologyitemrate1= '0.00';
 $res9referalitemrate1 = '0.00';
  $res10consultationitemrate1= '0.00'; 
  $resip1rate1= '0.00';
  $resip2rate1= '0.00';
  $resip3rate1= '0.00';
  $resip4rate1= '0.00';
  $resip5rate1= '0.00';
  $resip6rate1= '0.00';
  $resip7rate1= '0.00';
  $resip8rate1= '0.00';
  $resip9rate1= '0.00';
  
  $resr1consultationrate1= '0.00';
  $resr2rate1= '0.00';
  $resr3rate1= '0.00';
  $resr4rate1= '0.00';
  $resr5rate1= '0.00';
  $resr6rate1= '0.00';
  $resr7rate1= '0.00';

$res10username="";
$res5labusername="";
$res10consultationitemrate1=0;
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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

if (isset($_REQUEST["set_type"])) { $set_type = $_REQUEST["set_type"]; } else { $set_type = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["department"])) { $search_department = $_REQUEST["department"]; } else { $search_department = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }
$slocation =$locationcode1;
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

header('Content-Disposition: attachment;filename="_"'.$ADate1.'Detail_recon"_To_"'.$ADate2.'".xls"');

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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1546" 
            align="left" border="1">
          <tbody>
          	<tr> <td colspan="20" align="center"><strong><u><h3>Detail Recon REPORT</h3></u></strong></td></tr>
          	<!-- <tr ><td colspan="19" align="center"><strong>Department : <?php //if($search_department=='') { //echo 'All'; }else{ echo $search_department; } ?></strong></td></tr> -->
          
        <tr ><td colspan="20" align="center"><strong>Date From:    <?php echo date('d/m/Y',strtotime($ADate1));?>   To:  <?php echo date('d/m/Y',strtotime($ADate2));?></strong></td></tr>
        <tbody>
 			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
                <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Location Name</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>
                <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description </strong></td>
				
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname</strong></div></td>
				
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>
             

              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Item Name</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Category</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Qty</strong></div></td>
              
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
                 <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Txn Ref</strong></div></td>
                  <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Txn DateTime</strong></div></td>
				<td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>UserName</strong></div></td>
            </tr>
			<?php
			$totallab = $totalser = $totalpharm = $totalrad = $totalref = $totalcons = 0;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				
				
					
					if($slocation=='All')
					{
					$pass_location = "locationcode !=''";
					$pass_location1="locationname !=''";

					}
					else
					{
					$pass_location = "locationcode ='$slocation'";
					$pass_location1="locationname ='$slocation'";
					}	
					$locationcode1=$slocation;
					
						if($set_type=='Detailed')
						{
			
			
				
				$query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,locationname,sum(totalamount) as totalamount,source,username,created_at
                FROM (SELECT a.accountname,a.patientcode,a.visitcode,a.billno,a.billdate,a.patientname,a.locationname,a.totalamount,'billing_paynow' as source,a.username,b.created_at from billing_paynow  as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.billno=b.doc_number where a.$pass_location  and b.created_at between '$ADate1' and '$ADate2'  
			 	union all 
			 	SELECT a.accountname,a.patientcode, a.patientvisitcode as visitcode, a.billnumber as billno,a.billdate,a.patientname,a.locationname,a.transactionamount as totalamount,'billing_consultation' as source,a.username,b.created_at from billing_consultation as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.billnumber=b.doc_number where a.$pass_location  and b.created_at between '$ADate1' and '$ADate2'
			 	union all 
			 	SELECT a.accountname,a.patientcode,a.visitcode, a.billnumber as billno, a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'refund_paynow' as source,a.username,b.created_at  from refund_paynow as a  join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.billnumber=b.doc_number where  a.$pass_location and b.created_at between '$ADate1' and '$ADate2'  
			 	union all 
			 	SELECT a.accountname, a.patientcode, a.visitcode,a.billnumber as billno,a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'master_transactionip' as source,a.username,b.created_at from master_transactionip as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.billnumber=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' and accountnameano = 603
			 	union all 
			 	SELECT a.accountname, a.patientcode, a.visitcode,a.billnumber as billno,a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'master_transactionipcreditapproved ' as source,a.username,b.created_at from master_transactionipcreditapproved as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.billnumber=b.doc_number  where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' and accountnameano = 603
				union all 
			 	SELECT a.accountname, a.patientcode, a.visitcode, a.docno as billno, a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'master_transactionipdeposit' as source,a.username,b.created_at from master_transactionipdeposit as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.docno=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2'
				union all 
			 	SELECT  a.accountname, '' as patientcode, '' as visitcode, a.billno as billno, a.billdate as billdate, a.name as patientname,a.locationname,a.amount as totalamount,'other_sales_billing' as source,a.username,b.created_at from other_sales_billing as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.billno=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2'
				) u  group by billno order by created_at asc";

//union all SELECT a.accountname, a.patientcode, a.visitcode, a.docno as billno,a.recorddate as billdate, a.patientname,locationname,a.amount as totalamount,'billing_ipprivatedoctor' as source from billing_ipprivatedoctor as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.docno=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' and a.docno LIKE '%CF%'
		
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  $locationname = $res2['locationname'];
		  $bill_username = $res2['username'];
		   $check_source = $res2['source'];
		   $bill_created_at = $res2['created_at'];
		   $from_table=$check_source;
		   $transaction_number=$res2billno;
		   $reference_no='';
		  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$subtype_num=$res11['subtype'];
		
				$query112 = "SELECT * from master_subtype where auto_number='$subtype_num'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
				$subtype = $res112['subtype'];


		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';
		  $resr1consultationrate1 = '0.00';
		  $resr2rate1 = '0.00';
		  $resr3rate1 = '0.00';
		  $resr4rate1 = '0.00';
		  $resr5rate1 = '0.00';
		  $resr6rate1 = '0.00';
		  $resr7rate1 = '0.00';

		  $resr7ratec = '0.00';
		  $resr7ratep = '0.00';
		  $resr7ratel = '0.00';
		  $resr7rater = '0.00';
		  $resr7rates = '0.00';

$transactionmode='';
if($from_table == "billing_consultation")
{
 $query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactionmode from billing_consultation where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query_1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["transactionmode"]; 

if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}

$query11 = "select consultationtime,billingdatetime from master_billing where billnumber = '$transaction_number' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$billingdatetime= $res11['billingdatetime'];
$res11updatetime= $res11['consultationtime'];
$get_date=date('d/m/Y',strtotime($billingdatetime));
$get_time=$res11updatetime;
}

if($from_table == "other_sales_billing")
{
$query_1 = "select txnno,transactionmode,description,created_at from other_sales_billing where billno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["txnno"]; 
$res2patientname = $res_1["description"]; 
$patientcode = ''; 
$transactionmode = $res_1["transactionmode"]; 
$created_at = $res_1["created_at"]; 
$reference_no=$mpesanumber;
$get_date=date('d/m/Y',strtotime($created_at));
$get_time=date('H:i:s',strtotime($created_at));
}

if($from_table == "master_transactionip" || $from_table == "master_transactionipcreditapproved" ||   $from_table == "master_transactionipdeposit")
{
 $query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime,paymenttype from $from_table where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["paymenttype"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;

}

if($from_table == "refund_paynow" )
{

 $query_1 = "select mpesanumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime,transactionmode from $from_table where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["transactionmode"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}

if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;

	
}


/*if($from_table == "billing_ipprivatedoctor")
{

$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime from $from_table where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}	
	
	
	
 $query_1 = "select recorddate as transactiondate,recordtime as transactiontime from $from_table where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;

}*/


if($check_source=='master_transactionipdeposit')
{
	
$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime,transactionmode from $from_table where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["transactionmode"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;	
	
	
		  
/*$query1128 = "SELECT * from billing_ip where  patientcode='$res2patientcode' and visitcode='$res2visitcode'";
$exec1128 = mysqli_query($GLOBALS["___mysqli_ston"], $query1128) or die ("Error in Query1128".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1128 = mysqli_num_rows($exec1128);

$query11281 = "SELECT * from billing_ipcreditapproved where  patientcode='$res2patientcode' and visitcode='$res2visitcode'";
$exec11281 = mysqli_query($GLOBALS["___mysqli_ston"], $query11281) or die ("Error in Query11281".mysqli_error($GLOBALS["___mysqli_ston"]));
$num11281 = mysqli_num_rows($exec11281);
if($num1128>0 || $num11281>0)
{
$res10consultationitemrate=0;
}*/
}


if($from_table == "billing_paynow")
{
$query11 = "select transactiondate,transactiontime,mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactionmode from master_transactionpaynow where billnumber = '$transaction_number' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11billingdatetime = $res11['transactiondate'];
$res11updatetime= $res11['transactiontime'];
$mpesanumber = $res11["mpesanumber"]; 
$onlinenumber = $res11["onlinenumber"];
$creditcardnumber = $res11["creditcardnumber"];
$chequenumber = $res11["chequenumber"];
$patientcode = $res11["patientcode"]; 
$transactionmode = $res11["transactionmode"]; 

if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$get_date=date('d/m/Y',strtotime($res11billingdatetime));
$get_time=$res11updatetime;
}

if($from_table == "billing_paylater")
{
$query_1 = "select preauthcode,patientcode from billing_paylater where billno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1188".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
}

if($from_table == "billing_ipadmissioncharge")
{
$query_1 = "select preauthcode,patientcode,recorddate,recordtime from billing_ipadmissioncharge where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1180".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
$preauthcode = $res_1["recordtime"]; 
$patientcode = $res_1["recorddate"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
$get_date=date('d/m/Y',strtotime($recorddate));
$get_time=$patientcode;
}		
	
		  
		  
		  $query12 = "select * from master_transactionpaylater where $pass_location and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize'  ";
          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res12 = mysqli_fetch_array($exec12);
		  $res12username = $res12['username'];
		  
		 $query3 = "select * from master_visitentry where $pass_location and visitcode = '$res2visitcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  $res10paymenttype = $res3['paymenttype'];
		  $memberno = $res3['memberno'];
		  
		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];
		  
		  $query4 = "select * from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4planname = $res4['planname'];
		  
		    $query58 = "SELECT transactionamount,username,locationname,billdate,mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode from billing_consultation where $pass_location and billnumber = '$res2billno'";
		  $exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die ("Error in Query58".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res58 = mysqli_fetch_array($exec58))
		  {
		   
		  	$res5labbilldescription='Consultation';
		  $res5cons = $res58['transactionamount'];
		  $res5labitemname = '';
		  $res5labitemcode = '';
	      $locationname = $res58['locationname'];
		  $res5consamount = $res5consamount + $res5cons; 
		  $res5consamount = number_format($res5consamount,'2','.','');
		  
		$res11billingdatetime = $res58['billdate'];
		$res2billdate=$res11billingdatetime;
		$mpesanumber = $res58["mpesanumber"]; 
		$onlinenumber = $res58["onlinenumber"];
		$creditcardnumber = $res58["creditcardnumber"];
		$chequenumber = $res58["chequenumber"];
		$patientcode = $res58["patientcode"]; 
		
		if($mpesanumber!='' && $mpesanumber!='0')
		{
		$reference_no=$mpesanumber;
		}
		if($onlinenumber!='' && $onlinenumber!='0')
		{
		$reference_no=$onlinenumber;
		}
		if($creditcardnumber!='' && $creditcardnumber!='0')
		{
		$reference_no=$creditcardnumber;
		}
		if($chequenumber!='' && $chequenumber!='0')
		{
		$reference_no=$chequenumber;
		}
		$get_date=date('d/m/Y',strtotime($res11billingdatetime));
		$get_time='';

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
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


		   <tr>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res5labbilldescription; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labbilldescription; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labbilldescription; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5cons,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5cons,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php }
			 $query58 = "SELECT amount,username,locationname,created_at,txnno,username,description,units,transactionmode from other_sales_billing where $pass_location and billno = '$res2billno'";
		  $exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die ("Error in Query58".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res58 = mysqli_fetch_array($exec58))
		  {
		   
		  	$res5labbilldescription=$res58['description'];
		  $res5cons = $res58['amount'];
		  $res5labitemname = '';
		  $res5labitemcode = '';
	      $locationname = $res58['locationname'];
		  $res5consamount = $res5consamount + $res5cons; 
		  $res5consamount = number_format($res5consamount,'2','.','');
		  
		$res11billingdatetime = $res58['created_at'];
		$transactionmode = $res58['transactionmode'];
		$res2billdate=$res11billingdatetime;
		$mpesanumber = $res58["txnno"]; 
		$onlinenumber = $res58["txnno"];
		$creditcardnumber = $res58["txnno"];
		$chequenumber = $res58["txnno"];
		$unit = $res58["units"];
		$patientcode = ''; 
		//$bill_username = $res58["username"]; 
		
		if($mpesanumber!='' && $mpesanumber!='0')
		{
		$reference_no=$mpesanumber;
		}
		if($onlinenumber!='' && $onlinenumber!='0')
		{
		$reference_no=$onlinenumber;
		}
		if($creditcardnumber!='' && $creditcardnumber!='0')
		{
		$reference_no=$creditcardnumber;
		}
		if($chequenumber!='' && $chequenumber!='0')
		{
		$reference_no=$chequenumber;
		}
		$get_date=date('d/m/Y',strtotime($res11billingdatetime));
		$get_time=date('H:i:s',strtotime($res11billingdatetime));

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
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


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res5labbilldescription; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labbilldescription; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labbilldescription; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5cons,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $unit; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5cons,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <!--<td class="bodytext31"  valign="center"  align="left"><?php echo $get_date;?> &nbsp;&nbsp;&nbsp;<?php echo $get_time;?></td>-->
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?> </td>
           </tr>
		  <?php }
		 
		   $query5 = "SELECT labitemrate,labitemcode,labitemname,username,locationname from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res5 = mysqli_fetch_array($exec5))
		  {
		   
		  	$res5labbilldescription='Laboratory';
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemname = $res5['labitemname'];
		  $res5labitemcode = $res5['labitemcode'];
	      $locationname = $res5['locationname'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate; 
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
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


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res5labbilldescription; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labitemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labbilldescription; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php }

		 $query6 = "SELECT servicesitemcode,servicesitemname,servicesitemrate,serviceqty,amount,locationname from billing_paynowservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $res6servicesitemcode = $res6['servicesitemcode'];
		  $res6servicesitemname = $res6['servicesitemname'];
		  $res6servicesitemcat = 'Services';
		  $res6servicesitemratefixed = $res6['servicesitemrate'];
		  $res6servicesitemqty = $res6['serviceqty'];
		  $res6servicesitemrate = $res6['amount'];
		    $locationname = $res6['locationname'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
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


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res6servicesitemcat; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			 

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemcat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemratefixed,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemqty; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php }

		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		   $query7 = "SELECT medicinecode,medicinename,quantity,rate, amount,locationname from billing_paynowpharmacy where $pass_location and billnumber = '$res2billno'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res7 = mysqli_fetch_array($exec7))
		  {
		  	
		  $res7pharmacycode = $res7['medicinecode'];
		  $res7pharmacyname = $res7['medicinename'];
		  $res7pharmacycat = 'Pharmacy';
		  $res7pharmacyqty = $res7['quantity'];
		  $res7pharmacyrate = $res7['rate'];
		  $res7pharmacyitemrate = $res7['amount'];
		    $locationname = $res7['locationname'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res7pharmacycat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
		
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacyname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacycat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacyqty; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyitemrate,2,'.',','); ?></div></td>
            <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		   $query8 = "SELECT radiologyitemcode,radiologyitemname,radiologyitemrate,locationname from billing_paynowradiology where $pass_location and billnumber = '$res2billno' ";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res8 = mysqli_fetch_array($exec8))
		  {
		  $res8radiologycode = $res8['radiologyitemcode'];
		  $res8radiologyname = $res8['radiologyitemname'];
		  $res8radiologycat = 'Radiology';
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		   $locationname = $res8['locationname'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res8radiologycat; ?></td>
		
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res8radiologyname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res8radiologycat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate,2,'.',','); ?></div></td>
           <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  $query9 = "SELECT  referalcode,referalname,referalrate,locationname from billing_paynowreferal where $pass_location and billnumber = '$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res9 = mysqli_fetch_array($exec9))
		  {
		  $res9referalcode = $res9['referalcode'];
		  $res9referalname = $res9['referalname'];
		  $res9referalcat='Referal';
		  $res9referalitemrate = $res9['referalrate'];
		    $locationname = $res9['locationname'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res9referalcat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
		

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res9referalname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res9referalcat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate,2,'.',','); ?></div></td>
            <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		 $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');

		  $queryr1 = "SELECT consultation,locationname from refund_consultation where $pass_location and billnumber = '$res2billno' ";

		  $execr1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr1) or die ("Error in Queryr1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr1 = mysqli_fetch_array($execr1))
		  {
		  $resr1consultationrate = $resr1['consultation'];
		  $resr1cat='Refund Consultation';
		  $locationname = $resr1['locationname'];
		  
		  $resr1consultationrate1 = $resr1consultationrate1 + $resr1consultationrate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr1cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
		
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
		

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ''; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr1cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr1consultationrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr1consultationrate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $resr1consultationrate1 = number_format($resr1consultationrate1,'2','.','');
		  
		  $queryr2 = "SELECT labitemcode,labitemname,labitemrate,locationname from refund_paynowlab where $pass_location and billnumber = '$res2billno' ";

		  $execr2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr2) or die ("Error in Queryr2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr2 = mysqli_fetch_array($execr2))
		  {
		  $resr2code = $resr2['labitemcode'];
		  $resr2name = $resr2['labitemname'];
		  $resr2rate = $resr2['labitemrate'];
		  $resr2cat='Refund Laboratory';
		    $locationname = $resr2['locationname'];
		  $resr2rate1 = $resr2rate1 + $resr2rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr2cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
		

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo 'resr2name'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr2cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr2rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr2rate,2,'.',','); ?></div></td>
          <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
           <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $resr2rate1 = number_format($resr2rate1,'2','.','');

		  $queryr3 = "SELECT servicesitemcode, servicesitemname, servicesitemrate, servicequantity as servicesitemqty, serviceamount as amount,locationname from refund_paynowservices where $pass_location and billnumber = '$res2billno' ";

		  $execr3 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr3) or die ("Error in Queryr3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr3 = mysqli_fetch_array($execr3))
		  {
		  $resr3code = $resr3['servicesitemcode'];
		  $resr3name = $resr3['servicesitemname'];
		  $resr3singlerate = $resr3['servicesitemrate'];
		  $resr3qty = $resr3['servicesitemqty'];
		  $resr3rate = $resr3['amount'];
		    $locationname = $resr3['locationname'];
		  $resr3cat='Refund Services';
		  
		  $resr3rate1 = $resr3rate1 + $resr3rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr3cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
		

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr3singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr3rate,2,'.',','); ?></div></td>
            <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $resr3rate1 = number_format($resr3rate1,'2','.','');

		  $queryr4 = "SELECT medicinecode, medicinename, rate, quantity, amount,locationname from refund_paynowpharmacy where $pass_location and billnumber = '$res2billno' ";

		  $execr4 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr4) or die ("Error in Queryr4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr4 = mysqli_fetch_array($execr4))
		  {
		  $resr4code = $resr4['medicinecode'];
		  $resr4name = $resr4['medicinename'];
		  $resr4singlerate = $resr4['rate'];
		  $resr4qty = $resr4['quantity'];
		  $resr4rate = $resr4['amount'];
		    $locationname = $resr4['locationname'];
		  $resr4cat='Refund Pharmacy';
		  
		  $resr4rate1 = $resr4rate1 + $resr4rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr4cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr4singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr4rate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $resr4rate1 = number_format($resr4rate1,'2','.','');

		  $queryr5 = "SELECT radiologyitemcode, radiologyitemname, radiologyitemrate,locationname from refund_paynowradiology where $pass_location and billnumber = '$res2billno' ";

		  $execr5 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr5) or die ("Error in Queryr5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr5 = mysqli_fetch_array($execr5))
		  {
		  $resr5code = $resr5['radiologyitemcode'];
		  $resr5name = $resr5['radiologyitemname'];
		  $resr5qty = '1.00';
		  $resr5rate = $resr5['radiologyitemrate'];
		  $resr5cat='Refund Radiology';
		    $locationname = $res2['locationname'];
		  $resr5rate1 = $resr5rate1 + $resr5rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr5cat; ?></td>
		
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr5rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr5rate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $resr5rate1 = number_format($resr5rate1,'2','.','');

		   $queryr6 = "SELECT referalcode, referalname, referalrate,locationname from refund_paynowreferal where $pass_location and billnumber = '$res2billno' ";

		  $execr6 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr6) or die ("Error in Queryr6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr6 = mysqli_fetch_array($execr6))
		  {
		  $resr6code = $resr6['referalcode'];
		  $resr6name = $resr6['referalname'];
		  $resr6qty = '1.00';
		  $resr6rate = $resr6['referalrate'];
		    $locationname = $resr6['locationname'];
		  $resr6cat='Refund Referal';
		  
		  $resr6rate1 = $resr6rate1 + $resr6rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr6cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
		

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr6rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr6rate,2,'.',','); ?></div></td>
           <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		  $resr6rate1 = number_format($resr6rate1,'2','.','');
		  $queryr7 = "SELECT consultationfxamount, pharmacyfxamount, labfxamount, radiologyfxamount, servicesfxamount,locationname from billing_patientweivers where $pass_location and billno = '$res2billno' ";

		  $execr7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr7) or die ("Error in Queryr7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr7 = mysqli_fetch_array($execr7))
		  {
	   
		  $resr7ratec = $resr7['consultationfxamount'];
		  $resr7ratep = $resr7['pharmacyfxamount'];
		  $resr7ratel = $resr7['labfxamount'];
		  $resr7rater = $resr7['radiologyfxamount'];
		  $resr7rates = $resr7['servicesfxamount'];
		    $locationname = $resr7['locationname'];
		  $resr7rate1 = $resr7rate1 + $resr7ratec+$resr7ratep+$resr7ratel+$resr7rater+$resr7rates;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
		

		if($resr7ratec!='0.00'){ ?>
			<tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Consultation Waivers"; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
		

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Consultation Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratec,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratec,2,'.',','); ?></div></td>
          <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
               <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php }
		  if($resr7ratep!='0.00'){ ?>
			<tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Pharmacy Waivers"; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Pharmacy Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratep,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratep,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php }
		  if($resr7ratel!='0.00'){ ?>
			<tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Laboratory Waivers"; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Laboratory Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratel,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratel,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php }
		  if($resr7rater!='0.00'){ ?>
			<tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Radiology Waivers"; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Radiology Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rater,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rater,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php }
		  if($resr7rates!='0.00'){ ?>
			<tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Service Waivers"; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Service Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rates,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rates,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php }
		}// end while of resr7
		  $resr7rate1 = number_format($resr7rate1,'2','.','');
			  $resip1rate1 = '0.00';
		  $resip2rate1 = '0.00';
		  $resip3rate1 = '0.00';
		  $resip4rate1 = '0.00';
		  $resip5rate1 = '0.00';
		  $resip6rate1 = '0.00';
		  $resip7rate1 = '0.00';
		  $resip8rate1 = '0.00';
		  $resip9rate1 = '0.00';

		   $queryip1 = "SELECT  labitemcode, labitemrate,labitemname,locationname  from billing_iplab where $pass_location and billnumber = '$res2billno'  ";
		  $execip1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip1) or die ("Error in Queryip1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip1 = mysqli_fetch_array($execip1))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip1code = $resip1['labitemcode'];
		  $resip1name = $resip1['labitemname'];
		  $resip1singlerate = $resip1['labitemrate'];
		  $resip1qty = '1.00';
		  $resip1rate = $resip1['labitemrate'];
		    $locationname = $resip1['locationname'];
		  $resip1cat='IP Laboratory';
		  
		  $resip1rate1 = $resip1rate1 + $resip1rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip1cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip1rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip1rate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
            <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip1rate1 = number_format($resip1rate1,'2','.','');

		   $queryip2 = "SELECT  servicesitemcode, servicesitemrate,servicesitemname,locationname  from billing_ipservices where $pass_location and billnumber = '$res2billno'  ";

		  $execip2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip2) or die ("Error in Queryip2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip2 = mysqli_fetch_array($execip2))
		  {
		  $resip2code = $resip2['servicesitemcode'];
		  $resip2name = $resip2['servicesitemname'];
		  $resip2qty = '1.00';
		  $resip2rate = $resip2['servicesitemrate'];
		   $locationname = $resip2['locationname'];
		  $resip2cat='IP Services';
		  
		  $resip2rate1 = $resip2rate1 + $resip2rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip2cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip2rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip2rate,2,'.',','); ?></div></td>
             
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip2rate1 = number_format($resip2rate1,'2','.','');

		  $queryip3 = "SELECT  medicinecode, medicinename, quantity, rate, amount,locationname  from billing_ippharmacy where $pass_location and billnumber = '$res2billno'  ";

		  $execip3 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip3) or die ("Error in Queryip3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip3 = mysqli_fetch_array($execip3))
		  {
		  $resip3code = $resip3['medicinecode'];
		  $resip3name = $resip3['medicinename'];
		  $resip3singlerate = $resip3['rate'];
		  $resip3qty = $resip3['quantity'];
		  $resip3rate = $resip3['amount'];
		  $locationname = $resip3['locationname'];
		  $resip3cat='IP Pharmacy';
		  
		  $resip3rate1 = $resip3rate1 + $resip3rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip3cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip3singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip3rate,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip3rate1 = number_format($resip3rate1,'2','.','');

		   $queryip4 = "SELECT  radiologyitemcode, radiologyitemname, radiologyitemrate,locationname  from billing_ipradiology where $pass_location and billnumber = '$res2billno'  ";

		  $execip4 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip4) or die ("Error in Queryip4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip4 = mysqli_fetch_array($execip4))
		  {
		  $resip4code = $resip4['radiologyitemcode'];
		  $resip4name = $resip4['radiologyitemname'];
		  $resip4singlerate = $resip4['radiologyitemrate'];
		    $locationname = $resip4['locationname'];
		  $resip4qty = '1.00';
		  $resip4rate = $resip4['radiologyitemrate'];
		  $resip4cat='IP Radiology';
		  
		  $resip4rate1 = $resip4rate1 + $resip4rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip4cat; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip4singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip4rate,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip4rate1 = number_format($resip4rate1,'2','.','');

		  $queryip5 = "SELECT  description, bed, quantity, rate, amount,locationname  from billing_ipbedcharges where $pass_location and docno = '$res2billno'  ";

		  $execip5 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip5) or die ("Error in Queryip5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip5 = mysqli_fetch_array($execip5))
		  {
		  $resip5code = $resip5['bed'];
		  $resip5dis = $resip5['description'];
		  $resip5name = 'Bed';
		  $resip5singlerate = $resip5['rate'];
		  $resip5qty = $resip5['quantity'];
		  $resip5rate = $resip5['amount'];
		    $locationname = $resip5['locationname'];
		  $resip5cat='IP Bed Charges';
		  
		  $resip5rate1 = $resip5rate1 + $resip5rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip5dis; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip5singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip5rate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip5rate1 = number_format($resip5rate1,'2','.','');

		  $queryip6 = "SELECT quantity, rate, amount,locationname  from billing_ipadmissioncharge where $pass_location and docno='$res2billno'  ";

		  $execip6 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip6) or die ("Error in Queryip6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip6 = mysqli_fetch_array($execip6))
		  {
		  $resip6code = "";
		  $resip6dis = "IP Admission Charges";
		  $resip6name = '';
		  $resip6singlerate = $resip6['rate'];
		  $resip6qty = $resip6['quantity'];
		  $resip6rate = $resip6['amount'];
		    $locationname = $resip6['locationname'];
		  $resip6cat='IP Admission Charges';
		  
		  $resip6rate1 = $resip6rate1 + $resip6rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr  >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip6dis; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			 

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip6singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip6rate,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip6rate1 = number_format($resip6rate1,'2','.','');

		   $queryip7 = "SELECT description, rate, amount,locationname  from billing_ipmiscbilling where $pass_location and docno='$res2billno'  ";
		  
		  $execip7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip7) or die ("Error in Queryip7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip7 = mysqli_fetch_array($execip7))
		  {
		
		  $resip7code = "";
		  $resip7dis = $resip7['description'];
		  $resip7name = '';
		  $resip7singlerate = $resip7['rate'];
		  $resip7qty = '1';
		  $resip7rate = $resip7['amount'];
		    $locationname = $resip7['locationname'];
		  $resip7cat='IP Miscellaneous Charges';
		  
		  $resip7rate1 = $resip7rate1 + $resip7rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip7dis; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
		

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip7singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip7rate,2,'.',','); ?></div></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip7rate1 = number_format($resip7rate1,'2','.','');

		  $queryip8 = "SELECT description, rate, quantity, amount,locationname  from billing_ipambulance where $pass_location and docno='$res2billno'  ";

		  $execip8 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip8) or die ("Error in Queryip8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip8 = mysqli_fetch_array($execip8))
		  {
		  $resip8code = "";
		  $resip8dis = $resip8['description'];
		  $resip8name = '';
		  $resip8singlerate = $resip8['rate'];
		  $resip8qty = $resip8['quantity'];
		  $resip8rate = $resip8['amount'];
		    $locationname = $resip8['locationname'];
		  $resip8cat='IP Abulance';
		  
		  $resip8rate1 = $resip8rate1 + $resip8rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip8dis; ?></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip8singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip8rate,2,'.',','); ?></div></td>
             
               <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
           </tr>
		  <?php 
		  }
		  
		  $resip8rate1 = number_format($resip8rate1,'2','.','');

		 /*  $queryip9 = "SELECT description, rate, quantity, amount,locationname  from billing_ipprivatedoctor where $pass_location and docno='$res2billno'  ";

		  $execip9 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip9) or die ("Error in Queryip9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip9 = mysqli_fetch_array($execip9))
		  {
		  $resip9code = "";
		  $resip9dis = $resip9['description'];
		  $resip9name = '';
		  $resip9singlerate = $resip9['rate'];
		  $resip9qty = $resip9['quantity'];
		  $resip9rate = $resip9['amount'];
		    $locationname = $resip9['locationname'];
		  $resip9cat='IP Private Doctor';
		  if($resip9rate>0)
		  {
		  $resip9rate1 = $resip9rate1 + $resip9rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			} */
	
	?>


		   <!--<tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip9dis; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    /* $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department']; */

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip9singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip9rate,2,'.',','); ?></div></td>
                <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $get_date;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $get_time;?></td>
           </tr>
           </tr>-->
		  <?php 
		   //}
		  //}
		  
		  $resip9rate1 = number_format($resip9rate1,'2','.','');

		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1+$resip1rate1+$resip2rate1+$resip3rate1+$resip4rate1+$resip5rate1+$resip6rate1+$resip7rate1+$resip8rate1+$resip9rate1+$res5consamount;


		  $refund_total=$resr1consultationrate1+$resr2rate1+$resr3rate1+$resr4rate1+$resr5rate1+$resr6rate1+$resr7rate1;

		  $totallab += $res5labitemrate1;
		  $totalser += $res6servicesitemrate1;
		  $totalpharm += $res7pharmacyitemrate1;
		  $totalrad += $res8radiologyitemrate1;
		  $totalref += $res9referalitemrate1;
		  $totalcons += $res10consultationitemrate1;

		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  $refund_gtotal=$refund_gtotal+$refund_total;
		  $after_refund=$grandtotal-$refund_gtotal;
			?>
          
			<?php 
			$res21accountname ='';
				
			
			$res22accountname ='';

					$resip10rate1="0.00";
			$queryip10 = "SELECT * from ip_discount where $pass_location and consultationdate between '$ADate1' and '$ADate2'  and billtype='PAY NOW'  order by consultationdate";

		  $execip10 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip10) or die ("Error in Queryip10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip10 = mysqli_fetch_array($execip10))
		  {
		  $resip10code = $resip10['docno'];
		  $resip10dis = $resip10['description'];
		  $resip10name = '';
		  $resip10singlerate = $resip10['rate'];
		  $resip10qty = '1';
		  $resip10rate = $resip10['rate'];
		    $locationname = $resip10['locationname'];
		  $resip10cat='IP Discount';

		   $res10accountname = $resip10['accountname'];
		   $res10patientcode = $resip10['patientcode'];
		  $res10visitcode = $resip10['patientvisitcode'];
		  $bill_username = $resip10['username'];
		  $res10billno = '';
		  $res10billdate = $resip10['consultationdate'];
		  $res10billtime = $resip10['consultationtime'];
		  
		  $res10patientname = $resip10['patientname'];
		  $get_date=date('d/m/Y',strtotime($res10billdate));
          $get_time=$res10billtime;
		  
		  $resip10rate1 = $resip10rate1 + $resip10rate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res10patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res10visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res10billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res10billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip10dis; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res10patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res10accountname; ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res10visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo '';//$res11paymenttype; ?></div></td>
			

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resip10singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resip10rate,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no;?><?php echo $from_table;?></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $get_date;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $get_time;?></td>
			    <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		  }
		  
		   $resip10rate1 = number_format($resip10rate1,'2','.','');

		   $resip11rate1="0.00";
			
		   
		     $resipdeprate1="0.00";
		  $resip12rate1="0.00";
		    	$queryipdep = "SELECT * from master_transactionipdeposit where $pass_location and transactiondate between '$ADate1' and '$ADate2' and docno='$res2billno'  order by docno";

		  $execipdep = mysqli_query($GLOBALS["___mysqli_ston"], $queryipdep) or die ("Error in Queryipdep".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resipdep = mysqli_fetch_array($execipdep))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip11code = '';
		  $resip11dis = 'IP Deposit';
		  $resip11name = '';
		  $resip11singlerate = $resipdep['transactionamount'];
		  $resip11qty = '1';
		  $resipdeprate = $resipdep['transactionamount'];
		   $chequenumber = $resipdep['chequenumber'];
		  $resip11cat='Adv Deposit';

		   $res11accountname = $resipdep['accountname'];
		   $res11patientcode = $resipdep['patientcode'];
		  $res11visitcode = $resipdep['visitcode'];
		  $res11billno = $resipdep['docno'];
		  $res11billdate = $resipdep['transactiondate'];
		  $transactiontime= $resipdep['transactiontime'];
		  $transactionmode = $resipdep['transactionmode'];
		  $res11patientname = $resipdep['patientname'];
		  $locationname = $resipdep['locationname'];
		  $get_date=date('d/m/Y',strtotime($res11billdate));
		  $get_time=$transactiontime;
		  
		$mpesanumber = $resipdep["mpesanumber"]; 
		$onlinenumber = $resipdep["onlinenumber"];
		$creditcardnumber = $resipdep["creditcardnumber"];
		$chequenumber = $resipdep["chequenumber"];
		$patientcode = $resipdep["patientcode"]; 
		
		if($mpesanumber!='' && $mpesanumber!='0')
		{
		$reference_no=$mpesanumber;
		}
		if($onlinenumber!='' && $onlinenumber!='0')
		{
		$reference_no=$onlinenumber;
		}
		if($creditcardnumber!='' && $creditcardnumber!='0')
		{
		$reference_no=$creditcardnumber;
		}
		if($chequenumber!='' && $chequenumber!='0')
		{
		$reference_no=$chequenumber;
		}
		  // $res11patienttype = $resip11['patienttype'];
		  
		  
	$query1128 = "SELECT * from billing_ip where  patientcode='$res2patientcode' and visitcode='$res2visitcode'";
	$exec1128 = mysqli_query($GLOBALS["___mysqli_ston"], $query1128) or die ("Error in Query1128".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1128 = mysqli_num_rows($exec1128);
	
	$query11281 = "SELECT * from billing_ipcreditapproved where  patientcode='$res2patientcode' and visitcode='$res2visitcode'";
	$exec11281 = mysqli_query($GLOBALS["___mysqli_ston"], $query11281) or die ("Error in Query11281".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num11281 = mysqli_num_rows($exec11281);
	if($num1128>0 || $num11281>0)
	{
	$resipdeprate=0;
	$resip11singlerate=0;
	}
if($resip11singlerate>0)
{
		  
		  $resipdeprate1 = $resipdeprate1 + $resipdeprate;

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
	?>


		   <tr >
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $locationname; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res11billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip11dis; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode;//$res11paymenttype; ?></div></td>
			 

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip11singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resipdeprate,2,'.',','); ?></div></td>
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no; ?></td>
             <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
          }
		  }
		   } // while big  query2 end loop
		   $resipdeprate1 = number_format($resipdeprate1,'2','.','');

		   $resip12rate1="0.00";
		
		

		  $total_neg="0.00";
		  $total_final="0.00";
		  $total_postive="0.00";
		  $total_final="0.00";

		  $total_postive = $grandtotal+$resip12rate1+$resipdeprate1;

		   $total_neg = $refund_gtotal+$resip10rate1+$resip11rate1;
		 $total_pos=$total_postive;
		    $total_final = $total_postive-$total_neg;
			
			$total = $res10consultationitemrate1;
		  $refund_total=0;
          $total_postive=0;
		  $total_neg=0;
		 

		  $total = number_format($total,'2','.','');
		  $total_final=$total;
		  $grandtotal = $grandtotal + $total;
		  $refund_gtotal=$refund_gtotal+$refund_total;
		  $after_refund=$grandtotal-$refund_gtotal;
		  $total_postive=0;
		  $total_neg=0;
		

		  	$total_postive = $grandtotal+$resip12rate1+$resipdeprate1;

		   $total_neg = $refund_gtotal+$resip10rate1+$resip11rate1;
		   
		   $total_final = $total_postive-$total_neg;
		  ?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td>

               
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                          
  
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_postive,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>-<?php echo number_format($total_neg,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total_final,2,'.',','); ?></strong></td>
			  <td align="right" valign="center" class="bodytext31">&nbsp;</td>
			  
			 
			</tr>
	       <?php
				}
				
				else
				{
					 $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,locationname,sum(totalamount) as totalamount,source,username,created_at
                FROM (SELECT a.accountname,a.patientcode,a.visitcode,a.billno,a.billdate,a.patientname,a.locationname,a.totalamount,'billing_paynow' as source,a.username,b.created_at from billing_paynow  as a join  tb as b on a.billno=b.doc_number where a.$pass_location  and b.created_at between '$ADate1' and '$ADate2'  group by b.doc_number
			 	union all 
			 	SELECT a.accountname,a.patientcode, a.patientvisitcode as visitcode, a.billnumber as billno,a.billdate,a.patientname,a.locationname,a.transactionamount as totalamount,'billing_consultation' as source,a.username,b.created_at from billing_consultation as a join  tb as b on a.billnumber=b.doc_number where a.$pass_location  and b.created_at between '$ADate1' and '$ADate2' group by b.doc_number
			 	union all 
			 	SELECT a.accountname,a.patientcode,a.visitcode, a.billnumber as billno, a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'refund_paynow' as source,a.username,b.created_at  from refund_paynow as a  join  tb as b on a.billnumber=b.doc_number where  a.$pass_location and b.created_at between '$ADate1' and '$ADate2'  group by b.doc_number
			 	union all 
			 	SELECT a.accountname, a.patientcode, a.visitcode,a.billnumber as billno,a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'master_transactionip' as source,a.username,b.created_at from master_transactionip as a join  tb as b on a.billnumber=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' and accountnameano = 603 group by b.doc_number
			 	union all 
			 	SELECT a.accountname, a.patientcode, a.visitcode,a.billnumber as billno,a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'master_transactionipcreditapproved ' as source,a.username,b.created_at from master_transactionipcreditapproved as a join  tb as b on a.billnumber=b.doc_number  where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' and accountnameano = 603 group by b.doc_number
				union all 
			 	SELECT a.accountname, a.patientcode, a.visitcode, a.docno as billno, a.transactiondate as billdate, a.patientname,a.locationname,a.transactionamount as totalamount,'master_transactionipdeposit' as source,a.username,b.created_at from master_transactionipdeposit as a join  tb as b on a.docno=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' group by b.doc_number
				union all 
			 	SELECT  a.accountname, '' as patientcode, '' as visitcode, a.billno as billno, a.billdate as billdate, a.name,a.locationname,a.totalamount as totalamount,'other_sales_billing' as source,a.username as bill_username,b.created_at from other_sales_billing as a inner join  tb as b on a.billno=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' group by b.doc_number
				) u  group by billno order by created_at asc";
//union all SELECT a.accountname, a.patientcode, a.visitcode, a.docno as billno,a.recorddate as billdate, a.patientname,locationname,a.amount as totalamount,'billing_ipprivatedoctor' as source from billing_ipprivatedoctor as a join (SELECT DISTINCT doc_number,created_at FROM tb) as b on a.docno=b.doc_number where a.$pass_location and b.created_at between '$ADate1' and '$ADate2' and a.docno LIKE '%CF%'
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
		$get_date='';
		$get_time='';
		$reference_no='';
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  $locationname = $res2['locationname'];
		  $check_source = $res2['source'];
		  $bill_username = $res2['username'];
		  $bill_created_at = $res2['created_at'];
	
		
		  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$subtype_num=$res11['subtype'];
				$query112 = "SELECT * from master_subtype where auto_number='$subtype_num'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
				$subtype = $res112['subtype'];

		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  //$res10consultationitemrate1 = '0.00';
		  $resr1consultationrate1 = '0.00';
		  $resr2rate1 = '0.00';
		  $resr3rate1 = '0.00';
		  $resr4rate1 = '0.00';
		  $resr5rate1 = '0.00';
		  $resr6rate1 = '0.00';
		  $resr7rate1 = '0.00';

		  $resr7ratec = '0.00';
		  $resr7ratep = '0.00';
		  $resr7ratel = '0.00';
		  $resr7rater = '0.00';
		  $resr7rates = '0.00';

		  
		  $query12 = "select * from master_transactionpaylater where $pass_location and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize'  ";
          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res12 = mysqli_fetch_array($exec12);
		  $res12username = $res12['username'];
		  
		 $query3 = "select * from master_visitentry where $pass_location and visitcode = '$res2visitcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  $res10paymenttype = $res3['paymenttype'];
		  $memberno = $res3['memberno'];
		  
		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];
		  
		  $query4 = "select * from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4planname = $res4['planname'];
		   $res10consultationitemrate = $res2['totalamount'];
		   $from_table=$check_source;
		   $transaction_number=$res2billno;
	

$transactionmode='';
if($from_table == "billing_consultation")
{
$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactionmode from billing_consultation where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["transactionmode"]; 

if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}

$query11 = "select consultationtime,billingdatetime from master_billing where billnumber = '$transaction_number' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$billingdatetime= $res11['billingdatetime'];
$res11updatetime= $res11['consultationtime'];
$get_date=date('d/m/Y',strtotime($billingdatetime));
$get_time=$res11updatetime;
}

if($from_table == "other_sales_billing")
{
$query_1 = "select txnno,transactionmode,description,created_at from other_sales_billing where billno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["txnno"]; 
$res2patientname = $res_1["description"]; 
$patientcode = ''; 
$transactionmode = $res_1["transactionmode"]; 
$created_at = $res_1["created_at"]; 
$reference_no=$mpesanumber;
$get_date=date('d/m/Y',strtotime($created_at));
$get_time=date('H:i:s',strtotime($created_at));
}


if($from_table == "master_transactionip" || $from_table == "master_transactionipcreditapproved" ||  $from_table == "master_transactionipdeposit")
{
 $query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime,paymenttype from $from_table where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode=$res_1["paymenttype"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;

}

if($from_table == "refund_paynow" )
{

 $query_1 = "select mpesanumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime,transactionmode from $from_table where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["transactionmode"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}

if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;

	
}


/*if($from_table == "billing_ipprivatedoctor")
{

$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime from $from_table where billnumber='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}	
	
	
	
 $query_1 = "select recorddate as transactiondate,recordtime as transactiontime from $from_table where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;

}*/


if($check_source=='master_transactionipdeposit')
{
	
$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactiondate,transactiontime,transactionmode from $from_table where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 
$transactionmode = $res_1["transactionmode"]; 


if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$billingdatetime= $res_1['transactiondate'];
$res11updatetime= $res_1['transactiontime'];
if($billingdatetime!='')
{
$get_date=date('d/m/Y',strtotime($billingdatetime));
}
$get_time=$res11updatetime;	
	
	
		  
$query1128 = "SELECT * from billing_ip where  patientcode='$res2patientcode' and visitcode='$res2visitcode'";
$exec1128 = mysqli_query($GLOBALS["___mysqli_ston"], $query1128) or die ("Error in Query1128".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1128 = mysqli_num_rows($exec1128);

$query11281 = "SELECT * from billing_ipcreditapproved where  patientcode='$res2patientcode' and visitcode='$res2visitcode'";
$exec11281 = mysqli_query($GLOBALS["___mysqli_ston"], $query11281) or die ("Error in Query11281".mysqli_error($GLOBALS["___mysqli_ston"]));
$num11281 = mysqli_num_rows($exec11281);
if($num1128>0 || $num11281>0)
{
$res10consultationitemrate=0;
}
}


if($from_table == "billing_paynow")
{
$query11 = "select transactiondate,transactiontime,mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode,transactionmode from master_transactionpaynow where billnumber = '$transaction_number' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11billingdatetime = $res11['transactiondate'];
$res11updatetime= $res11['transactiontime'];
$mpesanumber = $res11["mpesanumber"]; 
$onlinenumber = $res11["onlinenumber"];
$creditcardnumber = $res11["creditcardnumber"];
$chequenumber = $res11["chequenumber"];
$patientcode = $res11["patientcode"]; 
$transactionmode = $res11["transactionmode"]; 

if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}
$get_date=date('d/m/Y',strtotime($res11billingdatetime));
$get_time=$res11updatetime;
}

if($from_table == "billing_paylater")
{
$query_1 = "select preauthcode,patientcode from billing_paylater where billno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1188".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
}

if($from_table == "billing_ipadmissioncharge")
{
$query_1 = "select preauthcode,patientcode,recorddate,recordtime from billing_ipadmissioncharge where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1180".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
$preauthcode = $res_1["recordtime"]; 
$patientcode = $res_1["recorddate"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
$get_date=date('d/m/Y',strtotime($recorddate));
$get_time=$patientcode;
}		
		

		  	$res10c='';
	
		 
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate; 

		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}?>

		  <tr >
		  	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $locationname; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res10c; ?></td>
			
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
			

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactionmode; ?></div></td>
			 

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res10c; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31"  valign="center"  align="left"><?php echo $reference_no; ?> 
             <?php /*?> <?php
			  if($reference_no =='')
			  { 
			  echo $from_table;
                  
			  }
			  ?><?php */?>
              </td>
               <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_created_at;?></td>
			   <td class="bodytext31"  valign="center"  align="left"><?php echo $bill_username;?></td>
           </tr>
		  <?php 
		 }
		  $total = $res10consultationitemrate1;
		  $refund_total=0;
          $total_postive=0;
		  $total_neg=0;
		 

		  $total = number_format($total,'2','.','');
		  $total_final=$total;
		  $grandtotal = $grandtotal + $total;
		  $refund_gtotal=$refund_gtotal+$refund_total;
		  $after_refund=$grandtotal-$refund_gtotal;
		  $total_postive=0;
		  $total_neg=0;
			?>
          
			<?php 
			$res21accountname ='';
			
				
         /*  $total = $res10consultationitemrate1;
		  $refund_total=0;
          $total_postive=0;
		  $total_neg=0;
		 

		  $total = number_format($total,'2','.','');
		  $total_final=$total;
		  $grandtotal = $grandtotal + $total;
		  $refund_gtotal=$refund_gtotal+$refund_total;
		  $after_refund=$grandtotal-$refund_gtotal;
		  $total_postive=0;
		  $total_neg=0; */
		

		  	$total_postive = $grandtotal+$resip12rate1+$resipdeprate1;

		   $total_neg = $refund_gtotal+$resip10rate1+$resip11rate1;
		   
		   $total_final = $total_postive-$total_neg;
		  ?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
                          
  
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_postive,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>-<?php echo number_format($total_neg,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total_final,2,'.',','); ?></strong></td>
			  <td align="right" valign="center" class="bodytext31">&nbsp;</td>
			  
			 
			</tr>
	       <?php } ?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>

