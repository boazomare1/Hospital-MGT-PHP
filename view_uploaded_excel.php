<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$x="";
$y="";
$not_match="";
$error=0;
$limit=0;
$invoice_number_array = array();

$subtypeid_docno="";
$subtype_id_main="";

$searchaccount_get=$_GET['searchaccount'];
    $searchdocno=$_GET['searchdocno'];
    $fromdate=$_GET['fromdate'];
    $todate=$_GET['todate'];

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatedate = date('Y-m-d');

$suppliername="";

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$locdocno = $_SESSION['docno'];

$bgcolorcode = "";

$colorloopcount = "";
$sno="";
$sno1="";


$query = "select * from login_locationdetails where username='$username' and docno='$locdocno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

  

  $res12location = $res["locationname"];

  $res12locationcode = $res["locationcode"];
  $locationcode = $res["locationcode"];

  $res12locationanum = $res["auto_number"];



//This include updatation takes too long to load for hunge items database.

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-30 days')); }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
if (isset($_REQUEST["uploadid"])) { $uploadid = $_REQUEST["uploadid"]; } else { $uploadid = ''; }



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



if (isset($_REQUEST["searchbill2"])) { $searchbill2 = $_REQUEST["searchbill2"]; } else { $searchbill2 = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

$docnum = $_REQUEST['docno'];



foreach($_POST['billnum2'] as $key => $value)

    {

    $billnum2=$_POST['billnum2'][$key];
    $subtypeano_docno=$_POST['subtypeano_docno'][$key];

    

    foreach($_POST['acknow1'] as $check1)

    {

    $acknow1=$check1;

    

    if($acknow1==$billnum2)

    {
         $query991="UPDATE excel_insurance_upload set allocate='0' where bill_no='$billnum2' and docno='$docnum' and upload_id='$uploadid' ";
         $exec991=mysqli_query($GLOBALS["___mysqli_ston"], $query991);

    $query8="UPDATE master_transactionpaylater set recordstatus = 'deallocated', acc_flag = '1' where docno='$docnum' and upload_id='$uploadid' and billnumber='$billnum2' and recordstatus = 'allocated' and subtypeano='$subtypeano_docno'";
    $exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    $query991="update billing_ipprivatedoctor set billstatus='unpaid' where docno='$billnum2' ";
    $exec991=mysqli_query($GLOBALS["___mysqli_ston"], $query991);

    $query84="update master_transactionpaylater set acc_flag = '0' where billnumber='$billnum2' and recordstatus <> 'deallocated' and subtypeano='$subtypeano_docno' order by auto_number desc limit 1";
    $exec84=mysqli_query($GLOBALS["___mysqli_ston"], $query84) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    }

    }

    }

header("location:view_uploaded_excel.php?docno=$docnum&&searchaccount=$searchaccount_get&&uploadid=$uploadid&&searchdocno=$searchdocno&&fromdate=$fromdate&&todate=$todate");
// accountreceivableentrylist.php?
}



if (isset($_REQUEST["frmflag23"])) { $frmflag23 = $_REQUEST["frmflag23"]; } else { $frmflag23 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag23 == 'frmflag23')

{
    // echo 'tested';
// exit();

$docnum1 = $_REQUEST['docno1'];

$date1 = $_REQUEST['date1'];

$bankname1 = $_REQUEST['bankname1'];

$number1 = $_REQUEST['number1'];

$paymentmode = $_REQUEST['paymentmode'];

$receivableamount = $_REQUEST['receivableamount1'];

$receivableamount=str_replace(',', '', $receivableamount);



$currency = 'Uganda Shillings';

foreach($_POST['billnum'] as $key => $value)

    {

    $billnum=$_POST['billnum'][$key];

    $name=$_POST['name'][$key];

    $patientcode=$_POST['patientcode'][$key];

    $visitcode=$_POST['visitcode'][$key];

    $doctorname=$_POST['doctorname'][$key];
    $subtypeano_docno=$_POST['subtypeano_docno'][$key];


    //echo $doctorname;

    $accountname = $_REQUEST['accountname'][$key];
    $accountnameid = $_REQUEST['accountnameid'][$key];
    $accountnameano = $_REQUEST['accountnameano'][$key];
    $balamount=$_POST['balamount'][$key];
    

    $balamount=str_replace(',', '', $balamount);

    $query55 = "select * from master_accountname where auto_number='$accountnameano'";
    $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res55 = mysqli_fetch_array($exec55);
    $paytype = $res55['paymenttype'];
    $subpaytype = $res55['subtype'];

    $querytype1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$paytype'");
    $exectype1=mysqli_fetch_array($querytype1);
    $patienttype11=$exectype1['paymenttype'];

    

    $querysubtype1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subpaytype'");
    $execsubtype1=mysqli_fetch_array($querysubtype1);
    $patientsubtype11=$execsubtype1['subtype'];
    $subtypeano = $execsubtype1['auto_number'];

    //echo $balamount;

    if($balamount == 0.00)
    {
    $billstatus='paid';
    }
    else
    {
    $billstatus='unpaid';
    }

    $billnumberprefix = '';
    $billnumber = '';
    $billanum = '';
    $remarks = '';
    $bankbranch = '';
    $transactionmodule = '';

    //echo $billstatus;

    $adjamount=$_POST['adjamount'][$key];
    $adjamount=str_replace(',', '', $adjamount);

    $discount=$_POST['discount'][$key];
    $discount=str_replace(',', '', $discount);

    foreach($_POST['ack'] as $check)

    {

    $acknow=$check;

    if($acknow==$billnum)

    {
         $query991="UPDATE excel_insurance_upload set allocate='1' where bill_no='$billnum' and docno='$docnum1' and upload_id='$uploadid'";
         $exec991=mysqli_query($GLOBALS["___mysqli_ston"], $query991);

    $query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum'";
    $exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query99);

    $query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum'";
    $exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query89);

    $query991="update billing_ipprivatedoctor set billstatus='$billstatus' where docno='$billnum'";
    $exec991=mysqli_query($GLOBALS["___mysqli_ston"], $query991);

    $query992="update billing_paylaterreferal set billstatus='$billstatus' where billnumber='$billnum'";
    $exec992=mysqli_query($GLOBALS["___mysqli_ston"], $query992);

    $query892="update billing_ipservices set billstatus='$billstatus' where billnumber='$billnum'";
    $exec892=mysqli_query($GLOBALS["___mysqli_ston"], $query892);
    

    $query9912="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='finalize'  and subtypeano='$subtypeano_docno'";
    $exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);


    $query99122="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='PAYMENT' and recordstatus = 'allocated' and subtypeano='$subtypeano_docno'";
        $exec99122=mysqli_query($GLOBALS["___mysqli_ston"], $query99122);
    

    $query87 ="SELECT * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and recordstatus = 'allocated' and upload_id='$uploadid' and subtypeano='$subtypeano_docno'";
    $exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $num87 = mysqli_num_rows($exec87);
    if($num87 == 0)
    {

    if($adjamount != 0)

    {

    

    if ($paymentmode == 'CASH')

    {

    $transactiontype = 'PAYMENT';

    $transactionmode = 'CASH';

    $particulars = 'BY CASH '.$billnumberprefix.$billnumber.''; 

    

    $query9 = "insert into master_transactionpaylater (transactiondate, particulars, 

    transactionmode, transactiontype, transactionamount, discount, cashamount,

    billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

    transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,upload_id,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount) 

    values ('$updatedatetime', '$particulars', 

    '$transactionmode', '$transactiontype', '$adjamount', '$discount', '$adjamount', 

    '$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

    '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$uploadid','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount')";

    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

    }

    if ($paymentmode == 'ONLINE')

    {

    $transactiontype = 'PAYMENT';

    $transactionmode = 'ONLINE';

    $particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.''; 

  

    $query9 = "insert into master_transactionpaylater (transactiondate, particulars,

    transactionmode, transactiontype, transactionamount, discount, onlineamount,

    billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

    transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,upload_id,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount) 

    values ('$updatedatetime','$particulars', 

    '$transactionmode', '$transactiontype', '$adjamount', '$discount', '$adjamount', 

    '$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

    '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$uploadid','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount')";

    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



    }

    if ($paymentmode == 'CHEQUE')

    {

    $transactiontype = 'PAYMENT';

    $transactionmode = 'CHEQUE';

    $particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;    

  

    $query9 = "insert into master_transactionpaylater (transactiondate, particulars,

    transactionmode, transactiontype, transactionamount, discount,

    chequeamount,chequenumber, billnumber, billanum, 

    chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

    transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,upload_id,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount) 

    values ('$updatedatetime', '$particulars', 

    '$transactionmode', '$transactiontype', '$adjamount', '$discount',

    '$adjamount','$number1',  '$billnum',  '$billanum', 

    '$date1', '$bankname1', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 

    '$remarks', '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$uploadid','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount')";

    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

  

    }

    if ($paymentmode == 'WRITEOFF')

    {

    $transactiontype = 'PAYMENT';

    $transactionmode = 'WRITEOFF';

    $particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;    

    

    $query9 = "insert into master_transactionpaylater (transactiondate, particulars,  

    transactionmode, transactiontype, transactionamount, discount, writeoffamount,

    billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

    transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,upload_id,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount) 

    values ('$updatedatetime', '$particulars',

    '$transactionmode', '$transactiontype', '$adjamount', '$discount', '$adjamount', 

    '$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

    '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$uploadid','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount')";

    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



    }

    if ($paymentmode == 'By Credit Note')

    {

    $transactiontype = 'PAYMENT';

    $transactionmode = 'CREDIT NOTE';

    $particulars = 'BY CREDIT NOTE '.$billnumberprefix.$billnumber;   

  

    $query9 = "insert into master_transactionpaylater (transactiondate, particulars,  

    transactionmode, transactiontype, transactionamount, discount, writeoffamount,

    billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

    transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,upload_id,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount) 

    values ('$updatedatetime', '$particulars',

    '$transactionmode', '$transactiontype', '$adjamount', '$discount', '$adjamount', 

    '$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

    '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$uploadid','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount')";

    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



    }

    }

    }

    else

    {

    // $totalaadjamount =0;

    // $query67 = "select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and upload_id='$uploadid'  and subtypeano='$subtypeano_docno'";

    // $exec67 = mysql_query($query67) or die(mysql_error());

    // while($res67 = mysql_fetch_array($exec67))

    // {

    // $existingamt = $res67['transactionamount'];

    // $totalaadjamount = $totalaadjamount + $existingamt;

    // }

    // $restotalaadjamount = $totalaadjamount + $adjamount;
  

    // if ($paymentmode == 'CASH')

    // {

    // $query45 = "UPDATE master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',cashamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and upload_id='$uploadid' and subtypeano='$subtypeano_docno'";

    // $exec45 = mysql_query($query45) or die(mysql_error());

    // }

    

    // if ($paymentmode == 'ONLINE')

    // {

    // $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',onlineamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and upload_id='$uploadid' and subtypeano='$subtypeano_docno'";

    // $exec45 = mysql_query($query45) or die(mysql_error());

    //   }

    // if ($paymentmode == 'CHEQUE')

    // {

    // $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',chequeamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'  and upload_id='$uploadid' and subtypeano='$subtypeano_docno'";

    // $exec45 = mysql_query($query45) or die(mysql_error());

    

    // }

    // if ($paymentmode == 'WRITEOFF')

    // {

    // $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and upload_id='$uploadid' and subtypeano='$subtypeano_docno'";

    // $exec45 = mysql_query($query45) or die(mysql_error());

      

    // }

    // if ($paymentmode == 'By Credit Note')

    // {

    // $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and upload_id='$uploadid' and subtypeano='$subtypeano_docno'";

    // $exec45 = mysql_query($query45) or die(mysql_error());


    // }

    // $query9912="update master_transactionpaylater set acc_flag='0' where billnumber='$billnum' and recordstatus='allocated' and transactiontype='finalize' and subtypeano='$subtypeano_docno' ";

    // $exec9912=mysql_query($query9912);

    }

  }

  }

  }

  header("location:view_uploaded_excel.php?docno=$docnum1&&searchaccount=$searchaccount_get&&uploadid=$uploadid&&searchdocno=$searchdocno&&fromdate=$fromdate&&todate=$todate");

}



include ("autocompletebuild_accounts1.php");



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

if(isset($_REQUEST['docno']))

{

$docno = $_REQUEST['docno'];

}

$totalamount=0;

$query5="select * from master_transactionpaylater where docno='$docno' and subtypeano<>'0'  group by docno";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$entrydate = $res5['transactiondate'];
$subtypeano_docno = $res5['subtypeano'];   
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

$accountnameano = $res5['accountnameano'];



$query11 = "select sum(fxamount) as total11 from master_transactionpaylater where docno='$docno' and upload_id='$uploadid' and recordstatus='allocated'";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

$num11 = mysqli_num_rows($exec11);

$res11 = mysqli_fetch_array($exec11);

$total11 = $res11['total11'];

$total11=str_replace(',', '', $total11);

$totalamount=str_replace(',', '', $totalamount);

$totalamount = (int) $totalamount;

$total11 = (int) $total11;

$amounttodisp=$totalamount-$total11;

?>

<style type="text/css">

<!--

body {

  margin-left: 0px;

  margin-top: 0px;

  background-color: #ecf0f5;

}

.bodytext3 {  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.cumtotal{position:fixed}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script>

function openCity(evt, cityName) {

    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    for (i = 0; i < tabcontent.length; i++) {

        tabcontent[i].style.display = "none";

    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) {

        tablinks[i].className = tablinks[i].className.replace(" active", "");

    }

    document.getElementById(cityName).style.display = "block";

    evt.currentTarget.className += " active";

  

  //alert(cityName); 

  var elements = document.getElementsByClassName("hiddenclass");

  if(cityName == "emrtabid"){

    for(var i=0; i<elements.length; i++) { 

    elements[i].style.display='none';

    }

  }else{

    for(var i=0; i<elements.length; i++) { 

    elements[i].style.display='block';

    }

  }

}

function dispnone(){

  //alert('dispnone');

   var cityName ="consultationtabid";

    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

  for (i = 0; i < tabcontent.length; i++) {

        tabcontent[i].style.display = "none";

    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) {

        tablinks[i].className = tablinks[i].className.replace(" active", "");

    }

    document.getElementById(cityName).style.display = "block";

  document.getElementById("defaultOpen").className += " active";

  

  //alert('dispnone end');

 }

 window.onload =function() {

 dispnone();

};

</script>

<script>

function updatebox1(varSerialNumber6,billamt6,totalcount6)

{



var grandtotalamt = 0;
var varSerialNumber6 = varSerialNumber6;
var totalcount6=totalcount6;
var billamt6 = billamt6;
  

  document.getElementById("amt"+varSerialNumber6+"").value='';

if(document.getElementById("acknow1"+varSerialNumber6+"").checked == true)

{

    

    var totalbillamt6=document.getElementById("totaladjamt1").value;

  if(totalbillamt6 == 0.00)

{

totalbillamt6=0;

}

        totalbillamt6=parseFloat(totalbillamt6)+parseFloat(billamt6);

      document.getElementById("amt"+varSerialNumber6+"").value=billamt6;

document.getElementById("totaladjamt1").value=totalbillamt6.toFixed(2);

}

else

{

//alert(totalcount1);

for(j=1;j<=totalcount6;j++)

{

var totalamt=document.getElementById("amt"+j+"").value;



if(totalamt == "")

{

totalamt=0;

}

grandtotalamt=grandtotalamt+parseFloat(totalamt);

}





document.getElementById("totaladjamt1").value=grandtotalamt.toFixed(2);



 }  

}



function updatebox(varSerialNumber,billamt,totalcount1)

{



var adjamount1;

var grandtotaladjamt2=0;



var varSerialNumber = varSerialNumber;

var totalcount1=document.getElementById("totalrow").value;



var billamt = billamt;

  var textbox = document.getElementById("adjamount"+varSerialNumber+"");

    textbox.value = "";

if(document.getElementById("acknowpending"+varSerialNumber+"").checked == true)

{



    if(document.getElementById("acknowpending"+varSerialNumber+"").checked) {

        textbox.value = billamt;

    }

  

  var balanceamt=billamt-billamt;

  if(balanceamt == 0.00)

  {

  balanceamt=0;

  }

  

  document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);

  

  var totalbillamt=document.getElementById("totaladjamt").value;

  

  if(totalbillamt == 0.00)

{

totalbillamt=0;

}

        totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);



document.getElementById("totaladjamt").value = totalbillamt.toFixed(2);



for(j=1;j<=totalcount1;j++)

{

var totaladjamount2=document.getElementById("adjamount"+j+"").value;



if(totaladjamount2 == "")

{

totaladjamount2=0;

}

grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);

}

//alert(grandtotaladjamt);

grandtotaladjamt2=grandtotaladjamt2.toFixed(2);

grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("totaladjamt").value=grandtotaladjamt2;



if((parseFloat(document.getElementById("receivableamount").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))

{

  document.getElementById("cumtotal").style.color="red";

  }

  else

  {document.getElementById("cumtotal").style.color="black";}

document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;

return false;



}

else

{



//alert(totalcount1);

for(j=1;j<=totalcount1;j++)

{

var totaladjamount2=document.getElementById("adjamount"+j+"").value;



if(totaladjamount2 == "")

{

totaladjamount2=0;

}

grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);

}

//alert(grandtotaladjamt);



document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

if((parseFloat(document.getElementById("receivableamount").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))

{

  document.getElementById("cumtotal").style.color="red";

  }

  else

  {document.getElementById("cumtotal").style.color="black";}

document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;

return false;

 }  

}



function totalamountcheck(totalcount7,grandtotalamt1)

{

var totalcount7=totalcount7;

// var grandtotalamt1=grandtotalamt1;
var checkamount=grandtotalamt1;

//alert(totalcount7);



document.getElementById("submit1").disabled=true;

var receivableamount = document.getElementById("receivableamount").value;



// var checkamount= document.getElementById("totaladjamt").value;

checkamount = checkamount.replace(/,/g,'');

receivableamount = receivableamount.replace(/,/g,'');

if(checkamount == 0.00)

{

alert("Adjustable amount cannot be Zero");

document.getElementById("submit1").disabled=false;

return false;

}

//alert(receivableamount);

if((parseFloat(checkamount)) > (parseFloat(receivableamount)))

{

alert("Allocated amount is greater than Receivable amount");

document.getElementById("submit1").disabled=false;

return false;

}

var checkamount2 = parseInt(checkamount) + parseInt(grandtotalamt1);

var checkamount1= document.getElementById("receivableamount").value;

if(parseInt(checkamount) > parseInt(checkamount1))
{
alert("Allocated amount is greater than Receivable amount");
document.getElementById("submit1").disabled=false;
return false;
}

if(parseInt(checkamount) < parseInt(checkamount1))
{
alert("Allocated amount is Lesser than the Receivable amount");
document.getElementById("submit1").disabled=false;
return false;
}
FuncPopup1();
document.form2.submit();
return true;
}



function checkboxcheck(varSerialNumber5)

{



if(document.getElementById("acknowpending"+varSerialNumber5+"").checked == false)

{

alert("Please click on the Select check box");

return false;

}

return true;

}

function balancecalc(varSerialNumber1,billamt1,totalcount)

{

var varSerialNumber1 = varSerialNumber1;

var billamt1 = billamt1;

var totalcount=document.getElementById("totalrow").value;

var grandtotaladjamt=0;



var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;

var adjamount3=parseFloat(adjamount);

if(adjamount3 > billamt1)

{

alert("Please enter correct amount");

document.getElementById("totaladjamt").value = '0.00';

document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';

document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;

document.getElementById("adjamount"+varSerialNumber1+"").focus();

return false;

}

var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);



document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);

for(i=1;i<=totalcount;i++)

{

var totaladjamount=document.getElementById("adjamount"+i+"").value;

if(totaladjamount == "")

{

totaladjamount=0;

}

grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);



}



grandtotaladjamt=grandtotaladjamt.toFixed(2);

grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("totaladjamt").value=grandtotaladjamt;



}

function balancecalc(varSerialNumber1,billamt1,totalcount)

{

var varSerialNumber1 = varSerialNumber1;

var billamt1 = billamt1;

var totalcount=document.getElementById("totalrow").value;

var grandtotaladjamt=0;



var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;

var adjamount3=parseFloat(adjamount);

if(adjamount3 > billamt1)

{

alert("Please enter correct amount");

document.getElementById("totaladjamt").value = '0.00';

document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';

document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;

document.getElementById("adjamount"+varSerialNumber1+"").focus();

return false;

}

var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);

balanceamount=balanceamount.toFixed(2);

balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;

for(i=1;i<=totalcount;i++)

{

var totaladjamount=document.getElementById("adjamount"+i+"").value;

if(totaladjamount == "")

{

totaladjamount=0;

}

grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);



}



grandtotaladjamt=grandtotaladjamt.toFixed(2);

grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("totaladjamt").value=grandtotaladjamt;

//alert(document.getElementById("totaladjamt").value);

//alert(document.getElementById("receivableamount").value);

if((parseFloat(document.getElementById("receivableamount").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))

{

  document.getElementById("cumtotal").style.color="red";

  }

  else

  {document.getElementById("cumtotal").style.color="black";}

document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;



}



</script>

<script type="text/javascript">





function disableEnterKey(varPassed)

{

  //alert ("Back Key Press");

  if (event.keyCode==8) 

  {

    event.keyCode=0; 

    return event.keyCode 

    return false;

  }

  

  var key;

  if(window.event)

  {

    key = window.event.keyCode;     //IE

  }

  else

  {

    key = e.which;     //firefox

  }



  if(key == 13) // if enter key press

  {

    //alert ("Enter Key Press2");

    return false;

  }

  else

  {

    return true;

  }

}





function process1backkeypress1()

{

  //alert ("Back Key Press");

  if (event.keyCode==8) 

  {

    event.keyCode=0; 

    return event.keyCode 

    return false;

  }

}



function disableEnterKey()

{

  //alert ("Back Key Press");

  if (event.keyCode==8) 

  {

    event.keyCode=0; 

    return event.keyCode 

    return false;

  }

  

  var key;

  if(window.event)

  {

    key = window.event.keyCode;     //IE

  }

  else

  {

    key = e.which;     //firefox

  }

  

  if(key == 13) // if enter key press

  {

    return false;

  }

  else

  {

    return true;

  }



}



function paymententry1process2()

{

  if (document.getElementById("cbfrmflag1").value == "")

  {

    alert ("Search Bill Number Cannot Be Empty.");

    document.getElementById("cbfrmflag1").focus();

    document.getElementById("cbfrmflag1").value = "";

    return false;

  }

}





function funcPrintReceipt1()

{

  //window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

  window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function FuncPopup()

{

  window.scrollTo(0,0);

  document.getElementById("imgloader").style.display = "";

}

function FuncPopup1()
{
  window.scrollTo(0,0);
  document.getElementById("imgloader_ac").style.display = "";
}

function acknowledgevalid()

{

  document.getElementById("submit0").disabled=true; 

  FuncPopup();

  document.cbform1.submit();

}



function SearchAlloc()

{

  var searchbill2 = document.getElementById("searchbill2").value;

  if(searchbill2==''){

    alert("Enter Billno ");

    document.getElementById("searchbill2").focus();

    return false;

  }

  else{

    var docno = $('#docnumbers').val();

    window.location.href = "?docno="+docno+"&&searchbill2="+searchbill2;

  }

}


function showDups($array)
{
  $array_temp = array();

   foreach($array as $val)
   {
     if (!in_array($val, $array_temp))
     {
       $array_temp[] = $val;
     }
     else
     {
       echo 'duplicate = ' . $val . '<br />';
     }
   }
}



</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

  $("#searchbillno").click(function (e) {

    

    if (true) {

      var Date1 = $('#ADate1').val();

  var Date2 = $('#ADate2').val();

  var date1 = new Date(Date1);

  var date2 = new Date(Date2);

  var timeDiff = Math.abs(date2.getTime() - date1.getTime());

  var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

  if(diffDays > 30)

  {

    alert("Select date range within 30 Days");

    $('#ADate1').val('<?= $ADate1; ?>');

    $('#ADate2').val('<?= $ADate2; ?>');

    return false;

  }

    var sbillno = '';

    $('#rowinsert').empty();

    $('#totalrow').val('1');

    var accountnameano = $('#searchaccountnameano').val();

    var docno = $('#docnumbers').val();

    var totalrow = $('#totalrow').val();

    var ADate1 = $('#ADate1').val();

    var ADate2 = $('#ADate2').val();

    var Databuild = "accountnameano="+accountnameano+"&&billno="+sbillno+"&&docno="+docno+"&&totalrow="+totalrow+"&&ADate1="+ADate1+"&&ADate2="+ADate2;

    $.ajax({

      url: "searchallocbillno.php",

      type: "GET",

      data: Databuild,

      success: function(data){

        if(data != '')

        { 

          $('#rowinsert').append(data);

          var rowCount = $('#rowinsert tr').length;

          $('#totalrow').val(parseFloat(rowCount));

        }

      }

    });

    }

  });

  

  $("#searchbill2").keydown(function (e) {

    if (e.keyCode == 13) {

    var sbillno = this.value;

    var accountnameano = $('#searchaccountnameano').val();

    var docno = $('#docnumbers').val();

    var totalrow = $('#totalrow1').val();

    $('#rowinsert1').empty();

    var Databuild = "accountnameano="+accountnameano+"&&billno="+sbillno+"&&docno="+docno+"&&totalrow="+totalrow;

    $.ajax({

      url: "searchdeallocbillno.php",

      type: "GET",

      data: Databuild,

      success: function(data){

        if(data != '')

        { 

          $('#rowinsert1').append(data);

          var rowCount = $('#rowinsert1 tr').length;

          $('#totalrow1').val(parseFloat(rowCount));

          //$('#searchbill2').val('');

        }

      }

    });

    }

  });

  

  var totaladj = 0;

  

  $('#checkall').click(function(){

    var chk = $('#checkall').prop('checked');

    var chkcount = $('.chkalloc').length;

     if (chk==true) {

        $('.chkalloc').prop('checked',true);

        for(var i=1; i<=chkcount; i++)

        {

        $('#adjamount'+i).val($('#billamount'+i).val()); 

        totaladj = parseFloat(totaladj) + parseFloat($('#billamount'+i).val());

        $('#balamount'+i).val('0.00');

        }

        totaladj=totaladj.toFixed(2);

        totaladj = totaladj.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

        $('#totaladjamt').val(totaladj);

       } else {

          $('.chkalloc').prop('checked', false);

        for(var i=1; i<=chkcount; i++)

        {

        $('#adjamount'+i).val('0.00');

        $('#balamount'+i).val('0.00'); 

        $('#totaladjamt').val('0.00');

        }

       } 

  });

});



function DateValid1()

{

  var Date1 = $('#ADate1').val();

  var Date2 = $('#ADate2').val();

  var date1 = new Date(Date1);

  var date2 = new Date(Date2);

  var timeDiff = Math.abs(date2.getTime() - date1.getTime());

  var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

  if(diffDays > 30)

  {

    alert("Select date range within 30 Days");

    $('#ADate1').val('<?= $ADate1; ?>');

    $('#ADate2').val('<?= $ADate2; ?>');

    return false;

  }

}

</script>

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

.imgloader { background-color:#FFFFFF; }
.imgloader_ac { background-color:#FFFFFF; }

#imgloader1 {

    position: absolute;

    top: 158px;

    left: 487px;

    width: 28%;

    height: 24%;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<div align="center" class="imgloader" id="imgloader" style="display:none;">

<div align="center" class="imgloader" id="imgloader1" style="display:;">

<p style="text-align:center;"><strong>Deallocate in Progress <br><br> Please be patience...</strong></p>

<img src="images/ajaxloader.gif">

</div>

</div>

<div align="center" class="imgloader_ac" id="imgloader_ac" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Allocate in Progress <br><br> Please be patience...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

 <!--  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php //include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php ///include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php // ("includes/menu1.php"); ?></td>

  </tr> -->

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table border="0" cellspacing="0" cellpadding="0">

  

  

  

      <tr>

        <td width="709">

        

             

      <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4" width="60%" align="center" border="0">

          <tbody>

      <tr>

  <td class="bodytext31" valign="center"  align="left" width="12%"><strong>DOC No </strong></td>
  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="docnumbers" id="docnumbers" value="<?php echo $docno; ?>" size="6" class="bal"><?php echo $docno; ?></td>

  <?php if(isset($_GET['uploadid'])){ $uploadid=$_GET['uploadid']; } ?>
    <td class="bodytext31" valign="center"  align="left" width="12%"><strong>Upload ID</strong></td>
    <td class="bodytext31" valign="center"  align="left">
        <input type="hidden" name="uploadid" id="uploadid" value="<?php echo $uploadid; ?>" size="6" class="bal">
        <?php echo $uploadid; ?>
    </td>

  <td class="bodytext31" valign="center"  align="left"><strong>Account Name</strong></td>

  <td class="bodytext31" valign="center"  align="left" colspan="4"><?php echo $suppliername; ?></td>

  </tr>

  <tr>

  <td class="bodytext31" valign="center"  align="left" width="12%"><strong>Entry Date</strong></td>

  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="entrydate" value="<?php echo $entrydate; ?>" size="6" class="bal"><?php echo $entrydate; ?></td>

  <td class="bodytext31" valign="center"  align="left" width="14%"><strong>Amount</strong></td>

  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="receivableamount" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal"><?php echo number_format($receivableamount,2,'.',','); ?></td>

  <td class="bodytext31" valign="center"  align="left" width="14%"><strong>Payment Mode</strong></td>

  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal"><?php echo $paymentmode; ?></td>



  </tr>

  <tr>

  <td class="bodytext31" valign="center"  align="left" width="12%"><strong>Number</strong></td>

  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="number" value="<?php echo $number; ?>" size="6" class="bal"><?php echo $number; ?></td>

  <td class="bodytext31" valign="center"  align="left" width="14%"><strong>Date</strong></td>

  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="date" value="<?php echo $date; ?>" size="6" class="bal"><?php echo $date; ?></td>

  <td class="bodytext31" valign="center"  align="left" width="14%"><strong>Bank Name</strong></td>

  <td class="bodytext31" valign="center"  align="left"><input type="hidden" name="bankname" value="<?php echo $bankname; ?>" size="6" class="bal"><?php echo $bankname; ?></td>

    </tr>

   </tbody>

        </table>

        <tr>

  <td colspan="4" align="left" valign="top">&nbsp;</td>

  </tr>

  <tr>

  

  </tr>

             

         

      </td>

</tr>

    

    <tr>

       <td id="consultationtabid" class="tabcontent" colspan="10" >&nbsp;

    <form action="" method="post" name="form2">

    <table style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 

            align="left" border="0">

          <tbody>
         
            <tr>

              <td colspan="22" bgcolor="#ecf0f5" class="bodytext311"><strong>Pending Invoices</strong></td>

        <input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal">

          <input type="hidden" name="docno1" value="<?php echo $docno; ?>">

        <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">

        <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">

        <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">

        <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">

        <input type="hidden" name="receivableamount1" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal">

      

             
            </tr>

            

            <tr bgcolor="#011E6A">
                         <td width="3%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

                        <td width="3%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>ID</strong></div></td>

                <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
                 <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
                  <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>

                   

               <td width="%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No</strong></div></td> 

                <td width="%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Subtype</strong></div></td>

                <td width="%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Account Name</strong></div></td>

              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td>

              <td width="" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Invoice No</strong></div></td>

              <td width="" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoice Amount</strong></div></td>

                <td width="" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td>

                <td width="" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Denied</strong></div></td>

                <td width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Net Paid  Amount</strong></div></td>

                <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User Name</strong></div></td>  

                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoiced Amount</strong></div></td>

                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Allocated Amount</strong></div></td>

                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pending Amount</strong></div></td>  

                <td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Allocation Amount</strong></div></td>

                <td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Remarks</strong></div></td>

            </tr>

           <?php
            if(isset($_GET['uploadid'])){ $uploadid=$_GET['uploadid']; } 

                $invoice_amount1 = 0;
                $discount1 = 0;
                $denied1 = 0;
                $amount1 = 0;
        $allocation_amount1 = 0;

               $total_amount_f_total="0";
      $allocated_amount_total="0";
      $pending_allocated_total="0";

      $patientcode="";
        $patientname="";
        $visitcode="";
        $total_amount_f="";
        $suppliername="";
        $allocated_amount="";
// pending
            if(isset($_GET['docno'])){
         $not_find="";
            $docno_get=$_GET['docno'];
             $query = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno_get' and upload_id='$uploadid' and status='1' and location='$locationcode' and allocate='0'";
            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num2 = mysqli_num_rows($exec);
            while($res = mysqli_fetch_array($exec)){


                $docno = $res['docno'];
                $upload_id = $res['upload_id'];
                $subtype = $res['subtype'];
                $upload_date = $res['upload_date'];
                $bill_no = $res['bill_no'];
                $invoice_amount = $res['invoice_amount'];
                $discount = number_format($res['discount'],2,'.',',');
                $denied = number_format($res['denied'],2,'.',',');
                $amount = number_format($res['amount'],2,'.',',');
                $amount_withoutcomma = $res['amount'];
                $discount_only=$res['discount'];
        $allocation_amount = $res['amount']+$res['discount'];
                 
                $invoice_amount1 += $res['invoice_amount'];
                $discount1 += $res['discount'];
                $denied1 += $res['denied'];
                $amount1 += $res['amount'];
        $allocation_amount1 += $allocation_amount;
                $username = ucwords($res['username']);

        

      $query1 = "SELECT patientcode, patientname, visitcode, totalamount, accountname, subtype, accountnameid, accountnameano  FROM `billing_paylater` where billno='$bill_no' ";
      $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
       $x=mysqli_num_rows($exec1);
       // if($x>0){
      $res1 = mysqli_fetch_array($exec1);
       $patientcode=$res1['patientcode'];
        $patientname=$res1['patientname'];
        $visitcode=$res1['visitcode'];
        $total_amount_f=$res1['totalamount'];
         $suppliername=$res1['accountname'];
        $accountid_match=$res1['accountnameid'];

        $accountnameid_bill=$res1['accountnameid'];
        $accountnameano_bill=$res1['accountnameano'];

        $subtype_billno=$res1['subtype'];


        // }
          
           $query2_ipfinal = " SELECT patientcode, patientname, visitcode, totalamountuhx, accountname, subtype, accountnameid, accountnameano FROM `master_transactionip` where `billnumber`='$bill_no' and transactionamount<>'0.00' ";
          $exec2_ipfinal = mysqli_query($GLOBALS["___mysqli_ston"], $query2_ipfinal) or die ("Error in Query2_ipfinal".mysqli_error($GLOBALS["___mysqli_ston"]));
           $y=mysqli_num_rows($exec2_ipfinal);
          while($res2_ipfinal = mysqli_fetch_array($exec2_ipfinal)){
           $patientcode=$res2_ipfinal['patientcode'];
            $patientname=$res2_ipfinal['patientname'];
            $visitcode=$res2_ipfinal['visitcode'];
            $total_amount_f=$res2_ipfinal['totalamountuhx'];
            $suppliername=$res2_ipfinal['accountname'];
            $accountid_match=$res2_ipfinal['accountnameid'];
            $subtype_billno=$res2_ipfinal['subtype'];

            $accountnameid_bill=$res2_ipfinal['accountnameid'];
            $accountnameano_bill=$res2_ipfinal['accountnameano'];
         }

         ////////////////// checking the subtypes //////////////////
            $query_accountid_match = " SELECT accountcode, subtypeano FROM `master_transactionpaylater` where docno='$docno_get' group by docno ";
                // and upload_id='$uploadid' 
                $exec_accountid_match = mysqli_query($GLOBALS["___mysqli_ston"], $query_accountid_match) or die ("Error in Query_accountid_match".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_accountid_match = mysqli_fetch_array($exec_accountid_match);
                $accountid_match=$res_accountid_match['accountcode'];
                $subtypeid_docno=$res_accountid_match['subtypeano'];

                // $query_subtype_find = "SELECT subtype FROM `master_accountname` where `id`='$accountid_match'";
                // $exec_subtype_find = mysql_query($query_subtype_find) or die ("Error in Query_subtype_find".mysql_error());
                // $res_subtype_find = mysql_fetch_array($exec_subtype_find);
                // $subtype_find=$res_subtype_find['subtype'];


                $query_subtype_fetch = "SELECT auto_number FROM `master_subtype` where `subtype`='$subtype_billno'";
                $exec_subtype_fetch = mysqli_query($GLOBALS["___mysqli_ston"], $query_subtype_fetch) or die ("Error in Query_subtype_fetch".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_subtype_fetch = mysqli_fetch_array($exec_subtype_fetch);
                $subtype_id_main=$res_subtype_fetch['auto_number'];
         ////////////////// checking the subtypes //////////////////


         if(($x=="0" and $y=="0") or ($subtypeid_docno!=$subtype_id_main)){
             $query1 = "SELECT patientcode, patientname, visitcode, transactionamount, accountname, subtype, accountcode,subtypeano, accountnameano,accountnameid FROM `master_transactionpaylater` where billnumber='$bill_no' and subtypeano='$subtypeano_docno' and transactionamount<>'0.00'";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $x=mysqli_num_rows($exec1);
                    if($x>0){
                    $res1 = mysqli_fetch_array($exec1);
                    $patientcode=$res1['patientcode'];
                    $patientname=$res1['patientname'];
                    $visitcode=$res1['visitcode'];
                    $total_amount_f=$res1['transactionamount'];
                    $suppliername=$res1['accountname'];
                    $accountid_match=$res1['accountcode'];
                    $subtype_billno=$res1['subtype'];
                    $subtype_anum_billno=$res1['subtypeano'];
                    // $accountnameano=$res1['accountnameano'];

                    $accountnameid_bill=$res1['accountnameid'];
                    $accountnameano_bill=$res1['accountnameano'];
                }
         }

          $query_allocated_amount = "SELECT sum(fxamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and billnumber='$bill_no' and subtypeano='$subtypeano_docno'";
          // docno='$docno' and
         // $query_allocated_amount = "SELECT * FROM `excel_insurance_upload` WHERE bill_no='$bill_no' and status='1' and location='$locationcode'";
      $exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
        $allocated_amount=$res_allocated_amount['amount']+$res_allocated_amount['discount'];
      }

      $pending_allocated=$total_amount_f-$allocated_amount;

      $total_amount_f_total += $total_amount_f;
      $allocated_amount_total += $allocated_amount;
      $pending_allocated_total += $pending_allocated ;
       
       
        $colorloopcount = $colorloopcount + 1;
        $sno = $sno+1;
        $showcolor = ($colorloopcount & 1); 
        if ($showcolor == 0)
        {
            $colorcode = 'bgcolor="#CBDBFA"';
        }

        else
        {
            $colorcode = 'bgcolor="#ecf0f5"';
        }
    $not_find='bgcolor="pink"';
    $not_match=$total_amount_f-$invoice_amount;

      $query214 = "select id, auto_number, accountname, subtype from master_accountname where accountname = '$subtype' and recordstatus <> 'deleted'";
     // $query214 = "select id, auto_number, accountname from master_accountname where accountname = '$suppliername' and recordstatus <> 'deleted'";
              $exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die ("Error in Query214".mysqli_error($GLOBALS["___mysqli_ston"]));
              while ($res214 = mysqli_fetch_array($exec214))
              {
                    $accountnameid4 = $res214['id'];
                  $accountnameano4 = $res214['auto_number'];
                  $subtypeid=$res214['subtype'];
                  // $suppliername = $res214['accountname'];
              }


               ////////////////// checking the subtypes for above conditions solved //////////////////
            $query_accountid_match = " SELECT accountcode, subtypeano FROM `master_transactionpaylater` where docno='$docno_get' group by docno ";
                // and upload_id='$uploadid' 
                $exec_accountid_match = mysqli_query($GLOBALS["___mysqli_ston"], $query_accountid_match) or die ("Error in Query_accountid_match".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_accountid_match = mysqli_fetch_array($exec_accountid_match);
                $accountid_match=$res_accountid_match['accountcode'];
                $subtypeid_docno=$res_accountid_match['subtypeano'];

                // $query_subtype_find = "SELECT subtype FROM `master_accountname` where `id`='$accountid_match'";
                // $exec_subtype_find = mysql_query($query_subtype_find) or die ("Error in Query_subtype_find".mysql_error());
                // $res_subtype_find = mysql_fetch_array($exec_subtype_find);
                // $subtype_find=$res_subtype_find['subtype'];


                $query_subtype_fetch = "SELECT auto_number FROM `master_subtype` where `subtype`='$subtype_billno'";
                $exec_subtype_fetch = mysqli_query($GLOBALS["___mysqli_ston"], $query_subtype_fetch) or die ("Error in Query_subtype_fetch".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_subtype_fetch = mysqli_fetch_array($exec_subtype_fetch);
                $subtype_id_main=$res_subtype_fetch['auto_number'];
         ////////////////// checking the subtypes //////////////////
		 
		 
		 $query90 = "select customerfullname, memberno from master_customer where customercode = '$patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];

                

    $doctorname='';
      
        if (!in_array($bill_no, $invoice_number_array))
        {
            $invoice_number_array[] = $bill_no; 
            // echo $string=implode(",",$invoice_number_array);
             $array_found=0;
        }else{
            $array_found = '1';
        }
         
        if(($x=="0" and $y=="0")  or($array_found=='1') or ($not_match!=0) or (round($allocation_amount, 2) > round($pending_allocated, 2))  or  ($subtypeid_docno!=$subtype_id_main)  ) { 
            $error += 1; 
            }else{ $error += 0;  } 
        ?>
        
        <tr  <?php  if(($x=="0" and $y=="0")  or($array_found=='1')  or ($not_match!=0) or (round($allocation_amount, 2) > round($pending_allocated, 2))  or  ($subtypeid_docno!=$subtype_id_main)) { echo $not_find; }else{ echo $colorcode; } ?>>
        <!-- <tr  <?php  //if(($x=="0" and $y=="0") or ($not_match!=0) or ($accountid_match!=$accountnameid4)) { echo $not_find; }else{ echo $colorcode; } ?>> -->

            <input type="hidden" name="patientcode[]" id="patientcode<?php echo $sno; ?>" value="<?php echo $patientcode; ?>">

              <input type="hidden" name="visitcode[]" id="visitcode<?php echo $sno; ?>" value="<?php echo $visitcode; ?>">

              <input type="hidden" name="accountname[]" id="accountname<?php echo $sno; ?>" value="<?php echo $suppliername; ?>">
              <input type="hidden" name="subtypeano_docno[]" id="subtypeano_docno<?php echo $sno; ?>" value="<?php echo $subtypeano_docno; ?>">

              <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">

              <input type="hidden" name="docno1" value="<?php echo $docno_get; ?>">

              <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">

              <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">
              <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">
              <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">
              <input type="hidden" name="accountnameano[]" id="accountnameano<?php echo $sno; ?>" value="<?php echo $accountnameano_bill; ?>">
              <input type="hidden" name="accountnameid[]" id="accountnameid<?php echo $sno; ?>" value="<?php echo $accountnameid_bill; ?>">

              <input type="hidden" name="receivableamount1" id="receivableamount<?php echo $sno; ?>" value="<?php echo $receivableamount; ?>" size="6" class="bal">

              <input type="hidden" name="billnum[]" value="<?php echo $bill_no; ?>">
              <input type="hidden" name="name[]" value="<?php echo $patientname; ?>">
              <input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php echo $invoice_amount; ?>">
              
              <input type="hidden" name="adjamount[]" id="adjamount<?php echo $sno; ?>" value="<?php echo $amount; ?>">

               <?php // $a_bal = $pending_allocated-$amount_withoutcomma; ?>
                <?php $a_bal = $pending_allocated-$allocation_amount; ?>
              <input type="hidden" class="bal" name="balamount[]"  value="<?=$a_bal;?>" size="7" >

              <input type="hidden" class="dis" name="discount[]"  value="<?=$discount_only;?>" size="7" >

             

                            <!-- `docno`, `subtype`, `upload_date`, `status`, `subtype_code`, `visit_code`, `patient_name`, `bill_no`, `invoice_amount`, `discount`, `denied`, `amount`, `username`, `ipaddress`, `lastupdate`, `location` -->
                          <td class="bodytext31" valign="center"  align="left">
                             
                            <!-- or ($pending_allocated<0)  -->
                             <input type="checkbox" <?php if(($x=="0" and $y=="0")  or($array_found=='1')  or (round($allocation_amount, 2) > round($pending_allocated, 2)) or  $not_match!=0 or  ($subtypeid_docno!=$subtype_id_main)) { echo "disabled=''"; }else{ echo 'checked=""';  } ?> name="ack[]" class="chkalloc" id="acknowpending<?php echo $sno; ?>" value="<?php echo $bill_no; ?>" ></td>

                          </td>

                        <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php  echo  $docno; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $upload_id; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $visitcode; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $mrdno; ?></div></td> 
                <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $subtype_billno; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $suppliername?></div></td>


               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $upload_date; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $bill_no; ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($invoice_amount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $discount; ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $denied; ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $amount; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $username; ?></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($total_amount_f,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($allocated_amount,2,'.',',');?></div></td>
                
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($pending_allocated,2,'.',',');?></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($allocation_amount,2,'.',','); ?></div></td>

                <?php //if(($x=="0" and $y=="0") or $not_match!=0 or  ($subtypeid_docno!=$subtype_id_main)) { echo "disabled=''"; }else{ echo 'checked=""';  } ?>

                <td class="bodytext31" valign="left"  align="left"><div class="bodytext31"><?php
                     if($x=="0" and $y=="0"){
                        echo "Bill Not Found";
                     }
                     elseif($subtypeid_docno!=$subtype_id_main){ echo "Subtype Mismatch"; }
                     elseif($not_match!=0){ echo "Inv.Amt Mismatch"; }
                     // elseif($allocation_amount>$pending_allocated){ echo "Amount Exceeded"; }
                     elseif(round($allocation_amount, 2) > round($pending_allocated, 2)){ echo "Amount Exceeded"; }
                     if($array_found=='1'){ echo "<br>Duplicate Inv.No"; }

                ?></div></td>

                      </tr>
                        <?php

        }
    }

        ?>
<input type="hidden" name="totalrow" id="totalrow" value="<?php echo $sno; ?>">
            
<tr style="background-color: #FF9900;" >
                <td colspan="11" class="bodytext31" valign="center"  align="center"></td>
                <td class="bodytext31" valign="center"  align="left" ><strong><?="Total";?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($invoice_amount1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($discount1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($denied1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong <?php if($amount1!=$receivableamount){ echo " style='color:red;'";}?>><?=number_format($amount1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ></td>
        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($total_amount_f_total,2,'.',',');?></strong></td>
        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($allocated_amount_total,2,'.',',');?></strong></td>
        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($pending_allocated_total,2,'.',',');?></strong></td>

        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($allocation_amount1,2,'.',',');?></strong></td>
        <td></td>
          </tr>
          
    <tr>

    <td>&nbsp;    </td>

    </tr>

    <tr>
        <style type="text/css">
            /*.blinking{
    animation:blinkingText 1.2s infinite;
}
@keyframes blinkingText{
    0%{     color: red;    }
    49%{    color: transparent; }
    100%{   color: red;    }
}*/
        </style>
        <?php
         $query_alloc = "SELECT sum(amount) as alloc_amounrt_final FROM `excel_insurance_upload` WHERE docno='$docno_get' and upload_id='$uploadid' and status='1' and location='$locationcode' and allocate='1'";
                $exec_alloc = mysqli_query($GLOBALS["___mysqli_ston"], $query_alloc) or die ("Error in query_alloc".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res_alloc = mysqli_fetch_array($exec_alloc);
                     $value_of_alloc = $res_alloc['alloc_amounrt_final'];
                     $final_additionvalue=$amount1+$value_of_alloc;

                     // if(round($amount1, 2) > round($receivableamount, 2)){
                        // echo round($amount1, 2);
                        // echo round($receivableamount, 2);
                         // $limit=1;
                     // }
        ?>
        <td colspan="19" align="right" style="color: red;" > </td>
            
    <td colspan="1" align="right" valign="top"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="frmflag23" value="frmflag23">
                       <input name="Submit" type="submit"  value="Allocate" class="button" id="submit1" onClick="return totalamountchec('<?php echo $num2; ?>','<?php echo $final_additionvalue; ?>'); "style="border: 1px solid #001E6A"    <?php if(($error!=0) || (round($amount1, 2) > round($receivableamount, 2)) ) { echo "disabled=''"; } ?> />
                      <!-- <input name="Submit" type="submit"  value="Allocate" class="button" id="submit1" onClick="return totalamountchec('<?php echo $num2; ?>','<?php echo $final_additionvalue; ?>'); "style="border: 1px solid #001E6A"   /> -->
                      <!-- <input name="Submit" type="submit"  value="Allocate" class="button" id="submit1" onClick="return totalamountchec('<?php echo $num2; ?>','<?php echo $final_additionvalue; ?>'); "style="border: 1px solid #001E6A"    <?php if(($x=="0" and $y=="0") or $not_match!=0 or  ($subtypeid_docno!=$subtype_id_main) or ($allocation_amount1>$pending_allocated_total) or ($final_additionvalue>$receivableamount) ) { echo "disabled=''"; } ?> /> -->

       </font></td>

    </tr>
   </form>

     </tbody>

      </table>

  </td>
   
  </tr>
  <!-- <hr> -->
  <tr><td colspan="18"><hr></td></tr>

  <tr>
      <!-- <form action="view_uploaded_excel.php" method="post" name="form2"> -->
         <form name="cbform1" method="post" action="">

    <table style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 

            align="left" border="0">

          <tbody>
         
            <tr>

              <td colspan="21" bgcolor="#ecf0f5" class="bodytext311"><strong>Allocated Invoices</strong></td>

        <input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal">

          <input type="hidden" name="docno1" value="<?php echo $docno; ?>">

        <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">

        <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">

        <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">

        <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">

        <input type="hidden" name="receivableamount1" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal">

      

              

            </tr>

            

            <tr bgcolor="#011E6A">
                         <td width="3%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

                        <td width="3%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>ID</strong></div></td>

                <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
                 <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
                  <td width="" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>

               <td width="%" align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No</strong></div></td> 

                <td width="%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Subtype</strong></div></td>

              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Account Name</strong></div></td>

              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td>

              <td width="" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Invoice No</strong></div></td>

              <td width="" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoice Amount</strong></div></td>

                <td width="" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td>

                <td width="" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Denied</strong></div></td>

                <td width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Net Paid  Amount</strong></div></td>

                <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User Name</strong></div></td>  

                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoiced Amount</strong></div></td>

                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Allocated Amount </strong></div></td>

                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Past Allocated Amount</strong></div></td>


                 <td width="" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pending Amount</strong></div></td>  

                <!-- <td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Allocation Amount</strong></div></td> -->

            </tr>

           <?php
                $invoice_amount1 = 0;
                $discount1 = 0;
                $denied1 = 0;
                $amount1 = 0;
        $allocation_amount1 = 0;

              $total_amount_f_total="0";
      $allocated_amount_total="0";
      $allocated_amount_total_old="0";
      $pending_allocated_total="0";


      $patientcode="";
        $patientname="";
        $visitcode="";
        $total_amount_f="";
        $suppliername="";
        $allocated_amount="";

            if(isset($_GET['docno'])){
         $not_find="";
            $docno_get=$_GET['docno'];
             $query = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno_get' and upload_id='$uploadid' and status='1' and location='$locationcode' and allocate='1'";
            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num2 = mysqli_num_rows($exec);
            while($res = mysqli_fetch_array($exec)){


                $docno = $res['docno'];
                $upload_id = $res['upload_id'];
                $subtype = $res['subtype'];
                $upload_date = $res['upload_date'];
                $bill_no = $res['bill_no'];
                $invoice_amount = $res['invoice_amount'];
                $discount = number_format($res['discount'],2,'.',',');
                $denied = number_format($res['denied'],2,'.',',');
                $amount = number_format($res['amount'],2,'.',',');
        $allocation_amount = $res['amount']+$res['discount'];
                 
                $invoice_amount1 += $res['invoice_amount'];
                $discount1 += $res['discount'];
                $denied1 += $res['denied'];
                $amount1 += $res['amount'];
        $allocation_amount1 += $allocation_amount;
                $username = ucwords($res['username']);

        

      $query1 = "SELECT patientcode, patientname, visitcode, totalamount, accountname, subtype  FROM `billing_paylater` where billno='$bill_no' ";
      $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
       $x=mysqli_num_rows($exec1);
       // if($x>0){
      $res1 = mysqli_fetch_array($exec1);
       $patientcode=$res1['patientcode'];
        $patientname=$res1['patientname'];
        $visitcode=$res1['visitcode'];
        $total_amount_f=$res1['totalamount'];
        $suppliername=$res1['accountname'];
        $subtype_billno=$res1['subtype'];

        // }
          
           $query2_ipfinal = " SELECT patientcode, patientname, visitcode, totalamountuhx, accountname, subtype FROM `master_transactionip` where `billnumber`='$bill_no'";
          $exec2_ipfinal = mysqli_query($GLOBALS["___mysqli_ston"], $query2_ipfinal) or die ("Error in Query2_ipfinal".mysqli_error($GLOBALS["___mysqli_ston"]));
           $y=mysqli_num_rows($exec2_ipfinal);
          while($res2_ipfinal = mysqli_fetch_array($exec2_ipfinal)){
           $patientcode=$res2_ipfinal['patientcode'];
            $patientname=$res2_ipfinal['patientname'];
            $visitcode=$res2_ipfinal['visitcode'];
            $total_amount_f=$res2_ipfinal['totalamountuhx'];
            $suppliername=$res2_ipfinal['accountname'];
            $subtype_billno=$res1['subtype'];
         }

          $query_allocated_amount = "SELECT sum(fxamount) as amount, sum(discount) as discount from master_transactionpaylater where docno='$docno' and upload_id='$uploadid'  and recordstatus='allocated' and billnumber='$bill_no'";
         // $query_allocated_amount = "SELECT * FROM `excel_insurance_upload` WHERE bill_no='$bill_no' and status='1' and location='$locationcode'";
      $exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
        $allocated_amount=$res_allocated_amount['amount']+$res_allocated_amount['discount'];
      }

      $query_allocated_amount_old = "SELECT sum(fxamount) as amount, sum(discount) as discount from master_transactionpaylater where recordstatus='allocated'   and upload_id!='$uploadid' and billnumber='$bill_no'";
      // and docno!='$docno'
      $exec_allocated_amount_old = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount_old) or die ("Error in Query_allocated_amount_old".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res_allocated_amount_old = mysqli_fetch_array($exec_allocated_amount_old)){
        $allocated_amount_old=$res_allocated_amount_old['amount']+$res_allocated_amount_old['discount'];
      }

      $pending_allocated=$total_amount_f-$allocated_amount-$allocated_amount_old;
      // $pending_allocated_old=$total_amount_f-$allocated_amount_old;

      $total_amount_f_total += $total_amount_f;
      $allocated_amount_total += $allocated_amount;
      $allocated_amount_total_old += $allocated_amount_old;
      $pending_allocated_total += $pending_allocated ;
       
       
        $colorloopcount = $colorloopcount + 1;
        $sno1 = $sno1+1;
        $showcolor = ($colorloopcount & 1); 
        if ($showcolor == 0)
        {
            $colorcode = 'bgcolor="#CBDBFA"';
        }

        else
        {
            $colorcode = 'bgcolor="#ecf0f5"';
        }
    $not_find='bgcolor="pink"';
    $not_match=$total_amount_f-$invoice_amount;

    $query214 = "select id, auto_number, accountname from master_accountname where subtype = '$subtype' and recordstatus <> 'deleted'";
              $exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die ("Error in Query214".mysqli_error($GLOBALS["___mysqli_ston"]));
              while ($res214 = mysqli_fetch_array($exec214))
              {
                  $accountnameid4 = $res214['id'];
                  $accountnameano4 = $res214['auto_number'];
                  // $suppliername = $res214['accountname'];
              }
			  $query90 = "select customerfullname, memberno from master_customer where customercode = '$patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];

    $doctorname='';
        ?>
        <tr  <?php if(($x=="0" and $y=="0") or $not_match!=0) { echo $not_find; }else{ echo $colorcode; } ?>>

          <!--   <input type="hidden" name="patientcode[]" id="patientcode<?php echo $sno; ?>" value="<?php echo $patientcode; ?>">

              <input type="hidden" name="visitcode[]" id="visitcode<?php echo $sno; ?>" value="<?php echo $visitcode; ?>">

              <input type="hidden" name="accountname[]" id="accountname<?php echo $sno; ?>" value="<?php echo $suppliername; ?>">

              <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">

              <input type="hidden" name="docno1" value="<?php echo $docno_get; ?>">

              <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">

              <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">
              <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">
              <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">
              <input type="hidden" name="accountnameano[]" id="accountnameano<?php echo $sno; ?>" value="<?php echo $accountnameano; ?>">
              <input type="hidden" name="accountnameid[]" id="accountnameid<?php echo $sno; ?>" value="<?php echo $accountnameid4; ?>">

              <input type="hidden" name="receivableamount1" id="receivableamount<?php echo $sno; ?>" value="<?php echo $receivableamount; ?>" size="6" class="bal">

              <input type="hidden" name="billnum[]" value="<?php echo $bill_no; ?>">
              <input type="hidden" name="name[]" value="<?php echo $patientname; ?>">
              <input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php echo $invoice_amount; ?>">
              
              <input type="hidden" name="adjamount[]" id="adjamount<?php echo $sno; ?>" value="<?php echo $amount; ?>">

              <input type="hidden" class="bal" name="balamount[]"  value="<?=$pending_allocated-$amount;?>" size="7" > -->

              <input type="hidden" name="amt" id="amt<?php echo $sno1; ?>">
              <input type="hidden" name="billnum2[]" value="<?php echo $bill_no; ?>">

              <input type="hidden" name="subtypeano_docno[]" id="subtypeano_docno<?php echo $sno; ?>" value="<?php echo $subtypeano_docno; ?>">

              

             

                            <!-- `docno`, `subtype`, `upload_date`, `status`, `subtype_code`, `visit_code`, `patient_name`, `bill_no`, `invoice_amount`, `discount`, `denied`, `amount`, `username`, `ipaddress`, `lastupdate`, `location` -->
                         
                          <td><div align="center"><input type="checkbox" name="acknow1[]" checked="" id="acknow1<?php echo $sno1; ?>"  value="<?php echo $bill_no; ?>" onClick="updatebox1('<?php echo $sno1; ?>','<?php echo $allocation_amount; ?>','<?php echo $num2; ?>')"></div></td>
                           
                        <td class="bodytext31" valign="center"  align="left"><?php echo $sno1; ?></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $docno; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $upload_id; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $visitcode; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $mrdno; ?></div></td> 

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $subtype_billno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $suppliername?></div></td>
               

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $upload_date; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $bill_no; ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($invoice_amount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $discount; ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $denied; ?></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $amount; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $username; ?></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($total_amount_f,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($allocated_amount,2,'.',',');?></div></td>

                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($allocated_amount_old,2,'.',',');?></div></td>

                 <!-- <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php //echo number_format($allocation_amount,2,'.',','); ?></div></td> -->
                
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($pending_allocated,2,'.',',');?></div></td>


                      </tr>
                        <?php

        }
    }

        ?>
<input type="hidden" name="totalrow" id="totalrow" value="<?php echo $sno1; ?>">
            
<tr style="background-color: #FF9900;" >
                <td colspan="11" class="bodytext31" valign="center"  align="center"></td>
                <td class="bodytext31" valign="center"  align="left" ><strong><?="Total";?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($invoice_amount1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($discount1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($denied1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($amount1,2,'.',',');?></strong></td>
                <td class="bodytext31" valign="center"  align="right" ></td>
        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($total_amount_f_total,2,'.',',');?></strong></td>

        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($allocated_amount_total,2,'.',',');?></strong></td>
         <!-- <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($allocation_amount1,2,'.',',');?></strong></td> -->
         <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($allocated_amount_total_old,2,'.',',');?></strong></td>
        <td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($pending_allocated_total,2,'.',',');?></strong></td>
        

        



       
          </tr>
          

    <!-- <tr> -->

   <tr>

              <?php 

              $colorloopcount = 0;

              $totamount = 0;

              $query27 = "select sum(fxamount) as amount from master_transactionpaylater where docno='$docno' and recordstatus='allocated'";
              $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
              $num22 = mysqli_num_rows($exec27);
              $res27 = mysqli_fetch_array($exec27);
              $amount = $res27['amount'];
              $totamount = $totamount + $amount;
              ?>
              <td colspan="15"></td>
            <td  class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">

            <input type="hidden" name="totalrow1" id="totalrow1" value="0">
            <input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>">

            <!-- <strong>Total</strong>          -->
             </td>

            <td class="bodytext311" valign="right" bordercolor="#f3f3f3" align="right"><input type="hidden" name="totaladjamt1" id="totaladjamt1" size="7" readonly="" style="text-align: right;"></td>

            </tr>

    <!-- </tr> -->

    <tr>

    <td colspan="29" width="1002"align="right" valign="top"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                     
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="Submit2223" type="submit" id="submit0" value="Deallocate " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A" <?php if($num2==0){ echo "disabled"; } ?>/>               </td>

       </font></td>

    </tr>
    

   </form>
<?php
if(isset($_POST['change_status'])){
    $searchaccount_get=$_GET['searchaccount'];
    $searchdocno=$_GET['searchdocno'];
    $fromdate=$_GET['fromdate'];
    $todate=$_GET['todate'];
$query2 = "UPDATE `excel_insurance_upload` SET `status`='0' WHERE `docno`='$docno_get' and upload_id='$uploadid' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<script>
window.opener.location.replace('accountreceivableentrylist.php?searchaccount=$searchaccount_get&&searchdocno=$searchdocno&&fromdate=$fromdate&&todate=$todate');
window.close();</script>";
// header('Location: accountreceivableentrylist.php?docno=$docno_get&&searchaccount=$searchaccount_get&&fromdate=$fromdate&&todate=$todate');

}
?>
<!-- header('Location: accountreceivableentrylist.php?docno=<?=$docno_get;?>&&searchaccount=<?=$searchaccount_get;?>&&fromdate=<?=$fromdate;?>&&todate=<?=$todate;?>'); -->
   <?php if($num2==0){ ?>
    <form method="POST">
        <tr>
        <td colspan="29" align="center">
            <input type="hidden" name="docno_remove" value="<?=$docno_get?>">
            <button type="submit" name="change_status" style="background-color: red; color: white; cursor: pointer;" onclick="return confirm('Are you sure you want to Cancel the Uploaded Excel?');">Cancel Uploaded Excel</button>
            </td>
        </tr>
        </form>
    <?php } ?>
    <!-- <?php if($num2==0){ ?>
     <tr>
        <form method="POST">
        <td colspan="29" align="center">
            <button type="submit" name="rediret" style="background-color: red; color: white; cursor: pointer;" onclick="return confirm('Are you sure you want to Go Back?');">Close</button>
            </td>
        
        </form>
    </tr>
    <?php } ?> -->

     </tbody>

      </table>

  </tr>
 

  </table>

  

<?php include ("includes/footer1.php"); ?>

</body>

</html>



