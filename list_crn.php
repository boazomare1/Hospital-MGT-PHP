<?php
include ("db/db_connect.php");

$allocatedamount=0;
$sno=0;

$bills="'Cr.N-11-19', 'Cr.N-15-19', 'Cr.N-18-19', 'Cr.N-19-19', 'Cr.N-20-19', 'Cr.N-27-19', 'Cr.N-28-19', 'Cr.N-29-19', 'Cr.N-30-19', 'Cr.N-31-19', 'Cr.N-32-19', 'Cr.N-34-19', 'Cr.N-41-19', 'Cr.N-44-19', 'Cr.N-45-19', 'Cr.N-46-19', 'Cr.N-49-19', 'Cr.N-53-19', 'Cr.N-55-19', 'Cr.N-56-19', 'Cr.N-57-19', 'Cr.N-58-19', 'Cr.N-59-19', 'Cr.N-61-19', 'Cr.N-62-19', 'Cr.N-63-19', 'Cr.N-64-19', 'Cr.N-65-19', 'Cr.N-66-19', 'Cr.N-67-19', 'Cr.N-68-19', 'Cr.N-72-19', 'Cr.N-74-19', 'Cr.N-77-19', 'Cr.N-78-19', 'Cr.N-80-19', 'Cr.N-81-19', 'Cr.N-82-19', 'Cr.N-83-19', 'Cr.N-84-19', 'Cr.N-85-19', 'Cr.N-87-19', 'Cr.N-88-19', 'Cr.N-90-19', 'Cr.N-91-19', 'Cr.N-93-19', 'Cr.N-101-19', 'Cr.N-102-19', 'Cr.N-104-19', 'Cr.N-156-19', 'Cr.N-321-20'";



// `auto_number`, `billno`, `patientname`, `patientcode`, `visitcode`, `totalamount`, `finamount`, `billdate`, `accountnameano`, `accountnameid`, `accountname`, `accountcode`, `referalname`, `billstatus`, `doctorstatus`, `finalizationbillno`, `locationname`, `locationcode`, `cashcode`, `mpesacode`, `bankcode`, `transactionmode`, `transactionamount`, `cashamount`, `chequeamount`, `cardamount`, `onlineamount`, `creditamount`, `exchrate`, `currency`, `fxrate`, `fxamount`, `username` FROM `refund_paylater` 



// `auto_number`, `transactiondate`, `transactiontime`, `docno`, `upload_id`, `particulars`, `patientcode`, `patientname`, `visitcode`, `paymenttype`, `subtype`, `accountname`, `accountcode`, `aop_id`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, `transactionamount`, `discount`, `cashamount`, `onlineamount`, `creditamount`, `chequeamount`, `cardamount`, `mpesaamount`, `tdsamount`, `writeoffamount`, `balanceamount`, `billnumber`, `billanum`, `openingbalance`, `closingbalance`, `chequenumber`, `mpesanumber`, `onlinenumber`, `creditcardnumber`, `chequedate`, `bankname`, `bankbranch`, `remarks`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`, `collectionnumber`, `financialyear`, `doctorname`, `billstatus`, `billbalanceamount`, `receivableamount`, `paylaterdocno`, `locationname`, `locationcode`, `username`, `billamount`, `cashcode`, `mpesacode`, `bankcode`, `currency`, `exchrate`, `fxamount`, `fxrate`, `accountnameano`, `accountnameid`, `subtypeano`, `acc_flag` FROM `master_transactionpaylater_19apr` WHERE 1

// S.No	 Transaction Number	 Date	 Against Invoice	 Account	 Sub Type	 Amount	 Remarks	 Posted by

$querya = "SELECT * from refund_paylater where billno in ($bills)  ";
		$execa = mysqli_query($GLOBALS["___mysqli_ston"], $querya) or die ("Error in Querya".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($resa = mysqli_fetch_array($execa)){
			 $docnoa = $resa['billno'];
			$billnumberas = $resa['finalizationbillno'];
  $query214 = "SELECT * from master_transactionpaylater where docno='$docnoa' and billnumber=''";
$exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die ("Error in Query214".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res214 = mysqli_fetch_array($exec214))
{
	  $docno = $res214['docno'];
	  $transactiondate = $res214['transactiondate'];

	  $subtype = $res214['subtype'];
	  $accountname = $res214['accountname'];
	  $transactionamount = $res214['transactionamount'];

	 //  $query214 = "select * from master_transactionpaylater where docno in ($docno) and recordstatus='allocated'";
		// $exec214 = mysql_query($query214) or die ("Error in Query214".mysql_error());
		// while ($res214 = mysql_fetch_array($exec214))



 
  $query1 = " SELECT username  from refund_paylaterambulance where billnumber = '$docno'
union all SELECT username  from refund_paylaterconsultation where billnumber = '$docno'
union all SELECT username  from refund_paylaterhomecare where billnumber = '$docno'
union all SELECT username  from refund_paylaterlab where billnumber = '$docno'
union all SELECT username  from refund_paylaterpharmacy where billnumber = '$docno'
union all SELECT username  from refund_paylaterradiology where billnumber = '$docno'
union all SELECT username  from refund_paylaterreferal where billnumber = '$docno'
union all SELECT username  from refund_paylaterservices where billnumber = '$docno'
union all SELECT username  from refund_paynow where billnumber = '$docno'
union all SELECT username  from refund_paynowlab where billnumber = '$docno'
union all SELECT username  from refund_paynowpharmacy where billnumber = '$docno'
union all SELECT username  from refund_paynowradiology where billnumber = '$docno'
union all SELECT username  from refund_paynowservices where billnumber = '$docno'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount1 = mysqli_num_rows($exec1);
			while($res1 = mysqli_fetch_array($exec1)){
				$username=$res1['username'];
				 }
				$sno+=1; 

echo $sno.'--'.$docno;
echo '--'.$transactiondate;
echo '--'.$billnumberas;
echo '--'.$subtype;
echo '--'.$accountname;
echo '--'.$transactionamount;
echo '--'.$username;
echo '<br>';
 
}
}