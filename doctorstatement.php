<?php 

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

$billnumbers=array();

$billnumbers1=array();

$billnumbers11=array();

$billnumbers2=array();

$billnumbers3=array();

$billnumbers4=array();

$billnumbers5=array();



$totalvisitcodes='';

$totalbillnumbers='';

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;



$totalamount30 = 0;

$totalamount60 = 0;

$totalamount90 = 0;

$totalamount120 = 0;

$totalamount180 = 0;

$totalamountgreater = 0;

		  

$docno = $_SESSION['docno'];



$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

$res01=mysqli_fetch_array($exe01);

 $locationcode=$res01['locationcode'];



include ("autocompletebuild_doctor1.php");





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }





$searchsuppliername1=explode('#',$searchsuppliername);

$searchsuppliername=trim($searchsuppliername1[0]);

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }

$paymentreceiveddatefrom=$ADate1;



//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }

$paymentreceiveddateto=$ADate2;

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



?>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }


<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script>

function funcAccount()

{

if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))

{

alert('Please Select Doctor.');

return false;

}

}


function loadprintpagepdf2(billnumber,doctorcode)

{


		window.open("print_doctorstmtbill.php?billnumber="+billnumber+'&&doctorcode='+doctorcode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

}
</script>



<script type="text/javascript" src="js/autocomplete_doctor.js"></script>

<script type="text/javascript" src="js/autosuggestdoctor_stmt.js"></script>

<script type="text/javascript">
	window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

function coasearch(varCallFrom)

{

	var varCallFrom = varCallFrom;

	

	window.open("showinvoice.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}

function coasearch1(varCallFrom1)

{



	var varCallFrom1 = varCallFrom1;

	

	window.open("showwthinvoice.php?callfrom1="+varCallFrom1,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}


function validateForm(){

  var to_date = document.getElementById('ADate2').value;

  var now = new Date().toISOString().slice(0,10);

  //alert(now);

  if(to_date > now){
    alert("Date to cannot be a future date!");
    document.getElementById('ADate2').focus;
    return false;
  }

  return true;
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="auto" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="doctorstatement.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Statement - By Doctor</strong></td>

              </tr>

           <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Doctor </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              </span></td>

           </tr>

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span>-->
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2','yyyyMMdd','','','','','past','07-01-2019','<?php echo date('m-d-Y');?>')" style="cursor:pointer"/>
                      </td>

                    </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <td>
        	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 

            align="left" border="0">

          <tbody>

            

            <tr>

              <th class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></th>

              <th width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></th>

              <th width="25%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></th>
                <th width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></th>
                 <th width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Type </strong></th>

                 <th width="7%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill.Amt </strong></th>
                 <th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Sharing %</strong></th>

              <th width="10%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit</strong></div></th>
                 <th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Tax Amt</strong></div></th>

              <th width="10%" align="left" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></th>

				<th width="4%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></th>

				<th width="16%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></th>

            </tr>

            <?php 

            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

				$openingcreditamount = 0;

				$openingdebittamount = 0;

				$openingbalance=0;
        $openingbalance_deb=0;

        $openingbalance_p = 0;

        $openingbalance_m = 0;


				if (isset($_REQUEST["searchsuppliername"])) { $suppliername = $_REQUEST["searchsuppliername"]; } else { $suppliername = ""; }

				if (isset($_REQUEST["searchsuppliercode"])) {  $suppliercode = $_REQUEST["searchsuppliercode"]; } else { $suppliercode = ""; }

					$arraysupplier = explode("#", $suppliername);

					$suppliername = $arraysupplier[0];

					$suppliername = trim($suppliername);

					$res21accountname = $suppliername ;

					$snocount = 0;


					// OB
					$querycr1op = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
            //echo $querycr1op.'<br>';
            
						$rescr1 = mysqli_fetch_array($execcr1);
						$openingbalance = $rescr1['openingbalance']; 

            //echo $openingbalance.'<br>';

					$querycr1ip = "SELECT IFNULL(SUM(`sharingamount`),0) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
						$execcr12 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1ip) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
           // echo $querycr1ip.'<br>';
						$rescr12 = mysqli_fetch_array($execcr12);
						$openingbalance1 = $rescr12['openingbalance1']; 
           // echo $openingbalance1.'<br>';
						$openingbalance =$openingbalance +$openingbalance1;



            $query = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from master_transactiondoctor where doctorcode='$suppliercode' and transactiondate <'$ADate1' and debit_reference_no IS NULL" ;
            $exec_dr = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_dr = mysqli_fetch_array($exec_dr);
            $openingbalance_deb = $res_dr['opbaldebit']; 
           
            //echo $openingbalance1.'<br>';
            $final_opening_balance = $openingbalance - $openingbalance_deb;
            //echo  $final_opening_balance .'<br>';
            //$openingbalance = $final_opening_balance;

            // for adp bills
            $query22 = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from advance_payment_entry where ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate <'$ADate1' " ;
            $exec_dr2 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_dr2 = mysqli_fetch_array($exec_dr2);
            $openingbalance_deb_adp = $res_dr2['opbaldebit']; 
           
            $final_opening_balance = $openingbalance - $openingbalance_deb_adp;


            // doctor debit note
            $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1'";

             $exec_note = mysqli_query($GLOBALS["___mysqli_ston"], $query_note) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_note = mysqli_fetch_array($exec_note);
            $openingbalance_p = $res_note['docamt']; 

             $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1'";
             //echo $query_note;
             $exec_note = mysqli_query($GLOBALS["___mysqli_ston"], $query_note) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_note = mysqli_fetch_array($exec_note);
            $openingbalance_m = $res_note['docamt']; 
           
            $openingbalance_doct_debcre = $openingbalance_p - $openingbalance_m;

           

            $openingbalance = $final_opening_balance + $openingbalance_doct_debcre;


             $query_refunds = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance_r  FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1'  and amount <> '0.00' and amount > 0  and docno <> ''";
             //  and visittype='OP'
             $exec_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query_refunds) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_refunds = mysqli_fetch_array($exec_refunds);
            $openingbalance_ref = $res_refunds['openingbalance_r']; 

             $openingbalance = $openingbalance - $openingbalance_ref;


				    ?>
    
    <tr bgcolor="#ffffff">

            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $suppliername;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>

            </tr>

			<tr>

			<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>

				
  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
              

              <td width="15%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong> Opening Balance </strong></td>
              
                <td width="9%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

              <td width="10%" align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

			 <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
                 <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
                 <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
                 <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
                 <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	

				<td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>

			</tr>


					<?php // OB



				

          $query234 = "SELECT mainset.* from ((select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by docno,doccoa order by recorddate,docno)

           union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate between '$ADate1' and '$ADate2' order by transactiondate,auto_number)

           -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'advance' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and transactiondate between '$ADate1' and '$ADate2' and recordstatus<>'deleted' order by transactiondate,auto_number)



            union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage, sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2'  group by accountcode,ref_no  order by consultationdate) 

            union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage, sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2'  group by accountcode,ref_no  order by consultationdate) 

          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,visittype as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate between '$ADate1' and '$ADate2' group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";

//echo $query234;exit;
			$exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num234=mysqli_num_rows($exec234);
			while($res234 = mysqli_fetch_array($exec234))
			{
				

        $res45doctorperecentage = "";
				$res45transactiondate = $res234['transdate'];
        //$n_billdate = $res234
				$billnumber = $res234['documentno'];

				$billtype = $res234['billtype'];
				$res45visitcode = $res234['visitcode'];

				$query124 = "select * from master_visitentry where visitcode = '$res45visitcode'";
				$exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($exec124) == 0)
				{
				$query124 = "select * from master_ipvisitentry where visitcode = '$res45visitcode'";
				$exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				}

				$res124 = mysqli_fetch_array($exec124);
				$billtype = $res124['billtype'];

				$res45patientname = $res234['patientname'];
				$res45patientcode = $res234['patientcode'];
				
				$res45accountname = $res234['accountname'];
				$res45vistype = $res234['visittype'];

        $transtable = $res234['transtable'];

        $description = "";
        $res45billamount = $res234['original_amt'];

        $refno = $res234['refno'];

        $res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor')
        {

              $res45transactionamount = $res234['sharingamount'];

              if($res45vistype == "OP")
              {

              $res45doctorperecentage = $res234['percentage'];

              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {

              $res45doctorperecentage = $res234['pvtdr_percentage'];

              }
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
			
				 }

         ///////////// CASH REFUNDS/////////////
         if($transtable == 'billing_ipprivatedoctor_refund')
        {
              $res45transactionamount = $res234['sharingamount'];
              if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
         }
         ///////////// CASH REFUNDS/////////////

				
				 if($transtable == 'master_transactiondoctor')
        {
           $res45transactionamount = $res234['transactionamount'];

          $taxamount = $res234['taxamount'];

          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";
          if($res45patientcode=='advance'){
            $description =  "Payment (".$res234['particulars']." )";
          }


            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
            $res45vistype = $res124['visittype'];
             if($res45vistype == "OP")
              {

              $res45doctorperecentage = $res234['percentage'];

              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {

              $res45doctorperecentage = $res234['pvtdr_percentage'];

              }
              
            
        }
         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";

        
       }

        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
				$res45locationcode = $res234['locationcode'];
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

			

			 $t1 = strtotime($ADate2);

       

      $t2 = strtotime($res45transactiondate);


     

		  $days_between = ceil(abs($t1 - $t2) / 86400);

     
	
		   $snocount = $snocount + 1;

		 
		  $res2transactionamount =  $res45transactionamount;

      

		  $debit_total = 0;

    
			if($snocount == 1)

		  {

		 // $totalat = $openingbalance + $res45amount;
		  
		  if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $openingbalance + $res45transactionamount ;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
          $totalat = $openingbalance - $res45transactionamount;
        }
		  
		  


		  }

		  else

		  {

		 // $totalat = $totalat + $res45amount;
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
		  $totalat = $totalat + $res45transactionamount ;
		  	}
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
		  	
		  }
      
		  //echo "grand total".$totalat.'<br>';

		   
		  //$res45doctorperecentage = preg_replace('~\.0+$~','',$res45doctorperecentage);
		  ?>
		  	  <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php  echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $res45transactiondate; ?></div></td>
                

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php  echo $description;?></div></td>

                 <td class="bodytext31" valign="center"  align="left">
             <?php	
			$q="select billno as billno,'billing_ip' as fromtb  from billing_ip where billno='$billnumber'
			UNION ALL select billno as billno,'billing_ipcreditapproved' as fromtb  from billing_ipcreditapproved where billno='$billnumber'
			UNION ALL select billnumber as billno,'billing_consultation' as fromtb  from billing_consultation where billnumber='$billnumber'
			UNION ALL select billno as billno,'billing_paylater' as fromtb  from billing_paylater where billno='$billnumber'
			UNION ALL select billnumber as billno,'refund_consultation' as fromtb  from refund_consultation where billnumber='$billnumber'";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("Error in Q".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$fromtb = $res222["fromtb"];		
					
					
		$url = "";
		if( $fromtb== 'billing_ipcreditapproved') {
		   
		    $url = "print_creditapproval.php?locationcode=$res45locationcode&&patientcode=$res45patientcode&&visitcode=$res45visitcode&&billnumber=$billnumber";
		}
		elseif(  $fromtb== 'billing_ip') {
		   
		    $url = "print_ipfinalinvoice1.php?locationcode=$res45locationcode&&patientcode=$res45patientcode&&visitcode=$res45visitcode&&billnumber=$billnumber";
		}
		elseif( $fromtb== 'billing_paylater') {
				$url = "print_paylater_detailed.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
		}
		elseif( $fromtb== 'billing_consultation') {
			  
			    	$url = "print_consultationbill_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
		}
          elseif($fromtb== 'refund_consultation') {
                $url = "print_consultationrefund_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
         }
		else
		{
			//$needle   = "CB";
		}
          
    if($res45patientcode=='advance'){

      $res45billamount=$amtwithouttax;
    ?>
      
                <div class="bodytext31"><?php echo $billnumber; ?></div>
              <?php }else{
                ?>
                <div class="bodytext31"><a target="_blank" href="<?=$url;?>"><?php echo $billnumber; ?></a></div>

                <?php
              }

              ?>

              </td>
                
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $billtype; ?></div></td>

              <?php  if($transtable != 'adhoc_creditnote' || $transtable != 'adhoc_debitnote' || $transtable != 'billing_ipprivatedoctor_refund')
                  { ?>
                 <td class="bodytext31" valign="center"  align="right"> <div class="bodytext31"><?php  echo number_format($res45billamount,2,'.',','); ?></div></td>
              <?php } ?>

                 <td class="bodytext31" valign="center"  align="right"> <div class="bodytext31"><?php  echo $res45doctorperecentage; ?></div></td>
           
           <?php 
           if($transtable == 'master_transactiondoctor')
           { ?>
                <td class="bodytext31" valign="center"  align="right"> <div align="right"> <?php echo number_format($amtwithouttax,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">  <?php echo number_format($taxamount,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php //echo number_format($res45transactionamount,2,'.',',');?></div></td>
          <?php  } ?>
          

		<?php 
 if($transtable == 'adhoc_creditnote'  || $transtable == 'billing_ipprivatedoctor_refund')
 { ?>
    <td class="bodytext31" valign="center"  align="right"> <div align="right"> <?php echo number_format($res45transactionamount,2,'.',','); ?></div></td>
    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"> <?php //echo number_format($taxamount,2,'.',','); ?></div></td>
    <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php //echo number_format($res45transactionamount,2,'.',',');?></div></td>
<?php  } ?>	  
<?php 
 if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
 { ?>
    <td class="bodytext31" valign="center"  align="right"> <?php //echo number_format($res45amount,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"> <?php //echo number_format($res45amount,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"> <div align="right"> <?php echo number_format($res45transactionamount,2,'.',','); ?></div></td>
<?php  } ?>
             
				  <td class="bodytext31" valign="center"  align="right"> <div align="center"><?php echo $days_between;?></div></td>
          <td class="bodytext31" valign="center"  align="left"> <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
  </tr>
	
 
		<?php 	}

			?>

			   <?php // OB

         $openingbalance =0;
         $totalat =0;

        

          $query234 = "SELECT mainset.* from ((select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate <= '$ADate2'  and docno <> '' group by docno,doccoa order by recorddate,docno) union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate <= '$ADate2' order by transactiondate,auto_number)


           union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage, sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate <= '$ADate2'  group by accountcode,ref_no  order by consultationdate) 
           union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage, sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate <='$ADate2'  group by accountcode,ref_no  order by consultationdate) 

           -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate <= '$ADate2' order by transactiondate,auto_number)

          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,'visittype' as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate <= '$ADate2' group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";

      $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num234=mysqli_num_rows($exec234);
      while($res234 = mysqli_fetch_array($exec234))
      {
        $res45doctorperecentage = "";
        $res45transactiondate = $res234['transdate'];
        //$n_billdate = $res234
        $billnumber = $res234['documentno'];

        $billtype = $res234['billtype'];
        $res45visitcode = $res234['visitcode'];

        $query124 = "select * from master_visitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($exec124) == 0)
        {
        $query124 = "select * from master_ipvisitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        $res124 = mysqli_fetch_array($exec124);
        $billtype = $res124['billtype'];

        $res45patientname = $res234['patientname'];
        $res45patientcode = $res234['patientcode'];
        
        $res45accountname = $res234['accountname'];
        $res45vistype = $res234['visittype'];

        $transtable = $res234['transtable'];

        $description = "";
        $res45billamount = $res234['original_amt'];

        $refno = $res234['refno'];

        $res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'billing_ipprivatedoctor_refund')
        {

              $res45transactionamount = $res234['sharingamount'];

              if($res45vistype == "OP")
              {

              $res45doctorperecentage = $res234['percentage'];

              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {

              $res45doctorperecentage = $res234['pvtdr_percentage'];

              }
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
      
         }
        
         if($transtable == 'master_transactiondoctor')
        {
           $res45transactionamount = $res234['transactionamount'];

          $taxamount = $res234['taxamount'];

          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";


            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage,recorddate from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
            $res45vistype = $res124['visittype'];
			$res45transactiondate = $res124['recorddate'];
             if($res45vistype == "OP")
              {

              $res45doctorperecentage = $res234['percentage'];

              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {

              $res45doctorperecentage = $res234['pvtdr_percentage'];

              }
              
            
        }

        if($res45transactiondate==''){
           $res45transactiondate = $res234['transdate'];
        }

         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";

        
       }

        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        $res45locationcode = $res234['locationcode'];
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

      

       $t1 = strtotime($ADate2);

       

      $t2 = strtotime($res45transactiondate);


     

      $days_between = ceil(abs($t1 - $t2) / 86400);

     
  
       $snocount = $snocount + 1;

     
      $res2transactionamount =  $res45transactionamount;

      

      $debit_total = 0;

     
      

      if($days_between < 30)

      {

      if($snocount == 1)

      {



      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $openingbalance + $res2transactionamount;
     
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $openingbalance - $res2transactionamount;
           
        }
      //$totalamount30 = $openingbalance + $res2transactionamount;
     

      }

      else

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $totalamount30 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $totalamount30 - $res2transactionamount;
        }

     //$totalamount30 = $totalamount30 + $res2transactionamount;

     

      }

      }

      else if(($days_between >=30) && ($days_between <=60))

      {

      if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $openingbalance - $res2transactionamount;
        }

      //$totalamount60 = $openingbalance + $res2transactionamount;


      }

      else

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $totalamount60 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $totalamount60 - $res2transactionamount;
        }
     // $totalamount60 = $totalamount60 + $res2transactionamount;

      }

      }

      else if(($days_between >60) && ($days_between <=90))

      {

      if($snocount == 1)

      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $openingbalance - $res2transactionamount;
        }

      //$totalamount90 = $openingbalance + $res2transactionamount;

      }

      else

      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $totalamount90 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $totalamount90 - $res2transactionamount;
        }

     // $totalamount90 = $totalamount90 + $res2transactionamount;

      }

      }

      else if(($days_between >90) && ($days_between <=120))

      {

      if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $openingbalance - $res2transactionamount;
        }

      //$totalamount120 = $openingbalance + $res2transactionamount;

      }

      else

      {

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $totalamount120 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $totalamount120 - $res2transactionamount;
        }


     // $totalamount120 = $totalamount120 + $res2transactionamount;

      }

      }

      else if(($days_between >120) && ($days_between <=180))

      {

        if($snocount == 1)

      {

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $openingbalance - $res2transactionamount;
        }
      //$totalamount180 = $openingbalance + $res2transactionamount;

      }

      else

      {

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $totalamount180 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $totalamount180 - $res2transactionamount;
        }
      //$totalamount180 = $totalamount180 + $res2transactionamount;

      }

      }

      else

      {

          if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $openingbalance - $res2transactionamount;
        }
      //$totalamountgreater = $openingbalance + $res2transactionamount;

      }

      else

      {

      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $totalamountgreater + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $totalamountgreater - $res2transactionamount;
        }
        //$totalamountgreater = $totalamountgreater + $res2transactionamount;

      }

      }

      
           if($snocount == 1)

      {

     // $totalat = $openingbalance + $res45amount;
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $openingbalance + $res45transactionamount ;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
          $totalat = $openingbalance - $res45transactionamount;
        }
      
      


      }

      else

      {

     // $totalat = $totalat + $res45amount;
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }

        

      }

      ?>

   
    <tr>
      <td>&nbsp;</td>
    </tr>


		

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

			<tr>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

					<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

            	 </tr>

						<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

           <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total Due</strong></td>

            </tr>

			<?php 
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			//$grandtotal = $totalat;

			?>

			<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount90,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount120,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount180,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalat,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="right"> 

                 

                </td> 

				<td class="bodytext31" valign="center"  align="right"> 

                                </td> 

		    </tr>

			
		    <tr>

             

             
				  <td colspan="7" class="bodytext31" valign="center"  align="right"><a href="doctorstatement_excel.php?searchsuppliercode=<?php echo $suppliercode;?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&searchsuppliername=<?php  echo $suppliername;?>&&locationcode1=<?=$locationcode?>&&cbfrmflag1=cbfrmflag1"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

          </td>

				  <td class="bodytext31" valign="top" bgcolor="#ecf0f5" align="left"> 

                 <a target="_blank" href="print_doctorstatement.php?searchsuppliercode=<?php echo $suppliercode;?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&searchsuppliername=<?php  echo $suppliername;?>&&locationcode1=<?=$locationcode?>&&cbfrmflag1=cbfrmflag1"> <img src="images/pdfdownload.jpg" width="30" height="30"></a> 

                </td> 

            </tr>
		   

			  </table>


<?php }
?>


