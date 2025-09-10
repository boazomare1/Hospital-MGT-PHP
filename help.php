
<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$updatedate = date("Y-m-d");
$titlestr = 'SALES BILL';

?>




<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

<script src="js/datetimepicker_css.js"></script>
<style>
#index1{font:bold 11px Arial, Helvetica, sans-serif;}
#indextable a{color:#000;padding-left:10px;}
#indextable .leftspace{float:left;padding-left:10px;}
#index1 .indexnames{float:left;background:#ecf0f5;}
#index1 .indexnames1{float:left;background:#ecf0f5;padding-left:10px;color:#367DC9}
#index1 .dots{float:right}
#index1 .indexnumbers{float:right;background:#ecf0f5}
.pages{font:12px Arial, Helvetica, sans-serif;}
#indextable .gotoindex{float:right;font-weight:bold;position:fixed;bottom:00px;left:970px;}
.gotoindex a{text-decoration:underline;color:#F0F;}
</style>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="refund_paynow.php">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->

    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top">
</td></tr></table>
<table width="970" style="margin-left:10px" id="indextable">
				 <tr >
                <td colspan="10"  class="bodytext32"><div class="gotoindex"><a href="#page1" title="Go To Top"><img src="pagesimg/gototop.png" width="70"></a></div></td>
                 
               
			 </tr>
                <tr bgcolor="#011E6A" id="page1">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32"><strong> &nbsp;Help </strong></td>
                 
               
			 </tr>
             <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
                <div class="leftspace">&nbsp;</div><a id="index1" href="#page2">
                	<div class="indexnames">OUT-PATIENT PROCESSES</div><div class="indexnumbers">1</div>
                </a>
                </td>
			 </tr>
             <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
              <div class="leftspace">&nbsp;</div> <a id="index1" href="#page2">
                	<div class="indexnames1">Patient Registration</div><div class="indexnumbers">1</div>
                </a>
                </td>
			 </tr>
             <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
              <div class="leftspace">&nbsp;</div><a id="index1" href="#page2">
                	<div class="indexnames1">OP Visit Creation</div><div class="indexnumbers">1</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
              <div class="leftspace">&nbsp;</div> <a id="index1" href="#page4">
                	<div class="indexnames">Consultation Billing</div><div class="indexnumbers">3</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page5">
                	<div class="indexnames">Triage process Procedure</div><div class="indexnumbers">4</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page5">
                	<div class="indexnames">Consultation process</div><div class="indexnumbers">5</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page7">
                	<div class="indexnames1">Raising of OP requests</div><div class="indexnumbers">7</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page7">
                	<div class="indexnames1">Prescription Request</div><div class="indexnumbers">7</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page8">
                	<div class="indexnames1">Lab Request</div><div class="indexnumbers">8</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page9">
                	<div class="indexnames1">Radiology Request</div><div class="indexnumbers">9</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page9">
                	<div class="indexnames1">Service Request</div><div class="indexnumbers">9</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page9">
                	<div class="indexnames">Approval Process for Corporate Clients (pay-later patients)</div><div class="indexnumbers">9</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page10">
                	<div class="indexnames">Amendment of OP Requests</div><div class="indexnumbers">10</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page10">
                	<div class="indexnames1">Amending pharmacy request</div><div class="indexnumbers">10</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page12">
                	<div class="indexnames1">Amending Lab Request</div><div class="indexnumbers">12</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page13">
                	<div class="indexnames1">Amending Radiology Request</div><div class="indexnumbers">13</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page14">
                	<div class="indexnames1">Amending Service Request</div><div class="indexnumbers">14</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page15">
                	<div class="indexnames">PAYNOW PATIENTS BILLING (receiving of lab bill, radiology bill, pharmacy bill etc)</div><div class="indexnumbers">15</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page15">
                	<div class="indexnames">OP MEDICINE ISSUE PROCEDURE</div><div class="indexnumbers">15</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page17">
                	<div class="indexnames">Process of collecting lab samples for OP and entering results</div><div class="indexnumbers">17</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page19">
                	<div class="indexnames1">Publishing of OP Lab Results</div><div class="indexnumbers">19</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page20">
                	<div class="indexnames">CONSULTATION OF THE PATIENT AFTER LAB RESULTS HAVE BEEN PUBLISHED</div><div class="indexnumbers">20</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page21">
                	<div class="indexnames">BILLING OF WALKIN PATIENTS</div><div class="indexnumbers">21</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page21">
                	<div class="indexnames1">Raising of OTC prescription request</div><div class="indexnumbers">21</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page22">
                	<div class="indexnames">Billing of walk-ins Lab, Service and Radiology</div><div class="indexnumbers">22</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page23">
                	<div class="indexnames">OP/WALKINS EXECUTION OF SERVICES/RADIOLOGY/LAB REQUESTS</div><div class="indexnumbers">23</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page23">
                	<div class="indexnames1">Processing of OP/Walk-in service request</div><div class="indexnumbers">23</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page24">
                	<div class="indexnames1">Process of OP/Walk-ins Radiology Result entry</div><div class="indexnumbers">24</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page26">
                	<div class="indexnames">PROCESSES OF CASH BILLS REFUNDS IN THE SYSTEM</div><div class="indexnumbers">26</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page26">
                	<div class="indexnames1">CONSULTATION BILL REFUND</div><div class="indexnumbers">26</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page29">
                	<div class="indexnames1">LAB BILLS REFUND PROCESSES (Both OP and walk-in)</div><div class="indexnumbers">29</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page30">
                	<div class="indexnames1">RADIOLOGY BILLS REFUND PROCESSES</div><div class="indexnumbers">30</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page31">
                	<div class="indexnames1">SERVICE BILLS REFUND PROCESSES</div><div class="indexnumbers">31</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page32">
                	<div class="indexnames1">PHARMACY BILLS REFUND PROCESS</div><div class="indexnumbers">32</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page33">
                	<div class="indexnames">PROCESS OF APPROVING CASH REFUNDS</div><div class="indexnumbers">33</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page35">
                	<div class="indexnames">PAYLATER PATIENTS CONSOLIDATION/PREPARATION OF INVOICES PROCESS</div><div class="indexnumbers">35</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page35">
                	<div class="indexnames1">Process of Invoice consolidation</div><div class="indexnumbers">35</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page36">
                	<div class="indexnames">PAYLATER REFUND PROCESS</div><div class="indexnumbers">36</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page36">
                	<div class="indexnames1">Credit Note Process</div><div class="indexnumbers">36</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page38">
                	<div class="indexnames">INPATIENT PROCESSES</div><div class="indexnumbers">38</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page38">
                	<div class="indexnames1">Direct IP visit Creation Process</div><div class="indexnumbers">38</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page38">
                	<div class="indexnames1">Creation of IP visit from patient registration form</div><div class="indexnumbers">38</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page40">
                	<div class="indexnames1">Creation of IP visit from IP Visit entry form</div><div class="indexnumbers">40</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page41">
                	<div class="indexnames1">Creation of IP visit from OP visit Form (Conversion of patient from OP to IP)</div><div class="indexnumbers">41</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page43">
                	<div class="indexnames1">Process of Receiving IP Deposits</div><div class="indexnumbers">43</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page44">
                	<div class="indexnames">IP ADMISSION/BED ALLOCATION PROCESS</div><div class="indexnumbers">44</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page45">
                	<div class="indexnames1">PROCESS OF TRANSFERING PATIENT FROM ONE WARD/BED TO ANOTHER</div><div class="indexnumbers">45</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page46">
                	<div class="indexnames">PROCESS OF BILLING/RAISING OF IP REQUESTS</div><div class="indexnumbers">46</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page46">
                	<div class="indexnames1">Rising of lab/radiology/service Requests</div><div class="indexnumbers">46</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page50">
                	<div class="indexnames1">IP MEDICINE ISSUE</div><div class="indexnumbers">50</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page53">
                	<div class="indexnames1">IP OT (Operation Theatre) Billing</div><div class="indexnumbers">53</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page54">
                	<div class="indexnames1">BILLING OF IP PRIVATE DOCTOR</div><div class="indexnumbers">54</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page55">
                	<div class="indexnames">AMENDMENT OF IP REQUESTS</div><div class="indexnumbers">55</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page55">
                	<div class="indexnames1">Amending IP Lab Request</div><div class="indexnumbers">55</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page56">
                	<div class="indexnames1">Amending IP Radiology Request</div><div class="indexnumbers">56</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page57">
                	<div class="indexnames1">Amending IP service Request</div><div class="indexnumbers">57</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page58">
                	<div class="indexnames">IP MEDICINE RETURN PROCESS</div><div class="indexnumbers">58</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page60">
                	<div class="indexnames1">Process of IP sample collection Result Entry</div><div class="indexnumbers">60</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page63">
                	<div class="indexnames1">Process of IP Radiology Results Entry</div><div class="indexnumbers">63</div>
               </a>
                </td>
			 </tr>
              <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32">
             <div class="leftspace">&nbsp;</div>  <a id="index1" href="#page65">
                	<div class="indexnames1">Processing of IP Service</div><div class="indexnumbers">65</div>
               </a>
                </td>
			 </tr>
            
             <?php for($i=2; $i<=66; $i++)
			 {$p=$i-1;
				 echo " <tr bgcolor='#011E6A' id='page".$p."'>
                <td colspan='10' bgcolor='#ecf0f5' class='bodytext32'>
                <img src='pagesimg/MED360 USER MANUAL-Rufus - Copy-".$i.".png' width='970'>
				<div align='center'>".$p."</div>
                </td>
			 </tr>";
				 }?>
            
             </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>