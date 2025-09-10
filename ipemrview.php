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

$currentdate = date("Y-m-d");

$updatedate=date("Y-m-d");



$transactiondatefrom = date('Y-m-d', strtotime('-6 day'));

$transactiondateto = date('Y-m-d');



$titlestr = 'SALES BILL';

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

	$paynowbillprefix = 'VS-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from ip_vitalio order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='VS-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'VS-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}



	    $billdate=$_REQUEST['billdate'];

	

	    $paymentmode = $_REQUEST['billtype'];

		$patientfullname = $_REQUEST['customername'];

		$patientcode = $_REQUEST['patientcode'];

		$visitcode = $_REQUEST['visitcode'];

		$billtype = $_REQUEST['billtypes'];

		

		$account = $_REQUEST['account'];

		$vitalipdate =  $_REQUEST['vitalipdate'];

		$vitaliptime =  $_REQUEST['vitaliptime'];

		$iodate = $_REQUEST['iodate'];

		$iotime = $_REQUEST['iotime'];

		$systolic = $_REQUEST['bpsystolic'];

		$diastolic = $_REQUEST['bpdiastolic'];

		$respiration = $_REQUEST['respiration'];

		$pulse = $_REQUEST['pulse'];

		$celsius = $_REQUEST['celsius'];

		$fahrenheit = $_REQUEST['fahrenheit'];

		$iv = $_REQUEST['ivquantity'];

		$fluids = $_REQUEST['fluidsquantity'];

		$vomitus = $_REQUEST['vomitusquantity'];

		$urine = $_REQUEST['urinequantity'];

		$secretion = $_REQUEST['secretionquantity'];

		

	

			

	  	

		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ip_vitalio(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,systolic,diastolic,pulse,resp,tempc,tempf,iv,fluids,vomitus,urine,secretion,vitalipdate,vitaliptime,iodate,iotime)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$systolic','$diastolic','$pulse','$respiration','$celsius','$fahrenheit','$iv','$fluids','$vomitus','$urine','$secretion','$vitalipdate','$vitaliptime','$iodate','$iotime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

		header("location:inpatientactivity.php");

		exit;



}





//to redirect if there is no entry in masters category or item or customer or settings







//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.

if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }

if(isset($_REQUEST['delete']))

{

$radiologyname=$_REQUEST['delete'];

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");

}

//$defaulttax = $_REQUEST["defaulttax"];

if ($defaulttax == '')

{

	$_SESSION["defaulttax"] = '';

}

else

{

	$_SESSION["defaulttax"] = $defaulttax;

}

if(isset($_REQUEST["patientcode"]))

{

$patientcode=$_REQUEST["patientcode"];

$visitcode=$_REQUEST["visitcode"];

$docnumber=$_REQUEST["docnumber"];

}





if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }

//$patientcode = 'MSS00000009';

if ($errorcode == 'errorcode1failed')

{

	$errmsg = 'NHIF is already processed.';	

}



//This include updatation takes too long to load for hunge items database.





//To populate the autocompetelist_services1.js





//To verify the edition and manage the count of bills.

$thismonth = date('Y-m-');

$query77 = "select * from master_edition where status = 'ACTIVE'";

$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

$res77 = mysqli_fetch_array($exec77);

$res77allowed = $res77["allowed"];









/*

$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";

$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());

$res99 = mysql_fetch_array($exec99);

$res99cntanum = $res99["cntanum"];

$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.

if ($totalbillandquote > $res77allowed)

{

	//header ("location:usagelimit1.php"); // redirecting.

	//exit;

}

*/



//To Edit Bill

if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }

//$delbillst = $_REQUEST["delbillst"];

if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }

//$delbillautonumber = $_REQUEST["delbillautonumber"];

if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }

//$delbillnumber = $_REQUEST["delbillnumber"];



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

//$frm1submit1 = $_REQUEST["frm1submit1"];









if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST["st"];

if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }

//$banum = $_REQUEST["banum"];

if ($st == '1')

{

	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";

	$bgcolorcode = 'success';

}

if ($st == '2')

{

	$errmsg = "Failed. New Bill Cannot Be Completed.";

	$bgcolorcode = 'failed';

}

if ($st == '1' && $banum != '')

{

	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';

}



if ($delbillst == "" && $delbillnumber == "")

{

	$res41customername = "";

	$res41customercode = "";

	$res41tinnumber = "";

	$res41cstnumber = "";

	$res41address1 = "";

	$res41deliveryaddress = "";

	$res41area = "";

	$res41city = "";

	$res41pincode = "";

	$res41billdate = "";

	$billnumberprefix = "";

	$billnumberpostfix = "";

}



?>



<?php

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode'");

$execlab=mysqli_fetch_array($Querylab);

$patientname = $execlab['patientname'];

$bedno = $execlab['bed'];

$accountname = $execlab['accountname'];

$patienttype=$execlab['maintype'];



$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";

$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res66 = mysqli_fetch_array($exec66);

$ipdate = $res66['consultationdate'];

$nhifrebate = $res66['nhifrebate'];
$locationcodevisit=$res66['locationcode'];


$datediff = abs(strtotime($currentdate) - strtotime($ipdate));



$years5 = floor($datediff / (365*60*60*24));

$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));

$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));

if($days5 == '0')

{

$days5 = 1;

}

$nhifrebateamount = $nhifrebate * $days5;



?>



<?php



$query2 = "select * from ip_vitalio order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='VS-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'VS-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}?>





<style type="text/css">

.bodytext313 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

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

.bal1

{

border-style:none;

background:none;

text-align:center;

font-weight:bold;

}

.bal

{

border-style:none;

background:none;

text-align:right;

font-size: 30px;

	font-weight: bold;

	FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

</style>



<!-- <script src="js/datetimepicker_css.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script> -->

  <style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 10px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */


}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #fff;
  float: right;
  font-size: 20px;
  font-weight: bold;
  border:2px solid aqua ;
  background-color: aqua;
  border-style: solid;
  border-radius: 8px;
  padding: 0px 3px 0px 3px;
  margin-right: 20px;

  /*display:block;
  box-sizing:border-box;
  width:20px;
  height:20px;
  border-width:3px;
  border-style: solid;
  border-color:red;
  border-radius:100%;
  background: -webkit-linear-gradient(-45deg, transparent 0%, transparent 46%, white 46%,  white 56%,transparent 56%, transparent 100%), -webkit-linear-gradient(45deg, transparent 0%, transparent 46%, white 46%,  white 56%,transparent 56%, transparent 100%);
  background-color:red;
  box-shadow:0px 0px 5px 2px rgba(0,0,0,0.5);
  transition: all 0.3s ease;*/

}

.close:hover {
  color: red;
  text-decoration: none;
  cursor: pointer;
}


</style>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body>

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

 <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top">&nbsp;</td>




    <td width="97%" valign="top">



<!-- //////////////////////for basi details //////////////////////////////// -->
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>

			<tr>
				<td colspan="14" width="10%" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"> 
				<a target="_blank" href="print_ipemrcasesheet.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>" > <img src="images/pdfdownload.jpg" width="30" height="30"></a>     
				</td>
          	</tr>

		  <tr>
			     <td colspan="7" align="left" bgcolor="" class="bodytext31"><strong>Visit Details</strong></td>
			  </tr>
             
            <tr>
              <td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Date </strong></div></td>

				<td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No. </strong></div></td>
				<td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No.  </strong></div></td>
              <td width="100"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
				<td width="25"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Gender</strong></div></td>
				<td width="100"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age</strong></div></td>
                <td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				<td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Subtype</strong></div></td>
				<td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Created By</strong></div></td>
               
              </tr>
          
        <?php
        function format_interval_dob(DateInterval $interval) {
			$result = "";
			if ($interval->y) { $result .= $interval->format("%y Years "); }
			if ($interval->m) { $result .= $interval->format("%m Months "); }
			if ($interval->d) { $result .= $interval->format("%d Days "); }

			return $result;
		}
		
		$query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		//$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['consultationdate'];
		$accountname=$res1['accountfullname'];
		$username=$res1['username'];
		$patientsubtype =$res1['subtype'];
		$gender =$res1['gender'];
		$billtype = $res1['billtype'];
	    $menusub=$res1['subtype'];
		
		$query44 = "select * from master_customer WHERE customercode = '$patientcode' ";
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num44 = mysqli_num_rows($exec44);
		$res44 = mysqli_fetch_array($exec44);		
		$patientname = $res44['customerfullname'];
		$dateofbirth=$res44['dateofbirth'];
		if($dateofbirth>'0000-00-00'){
		  $today = new DateTime($consultationdate);
		  $diff = $today->diff(new DateTime($dateofbirth));
		  $patientage = format_interval_dob($diff);
		}else{
		  $patientage = '<font color="red">DOB Not Found.</font>';
		}

		$querysub = "select * from master_subtype where auto_number='$patientsubtype'";
        $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], $querysub);
        $execsubtype=mysqli_fetch_array($querysubtype);
        $patientsubtype1=$execsubtype['subtype'];

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
          <tr <?php echo $colorcode; ?>>
			   
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientage; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">
			    <div align="center">			      <?php echo $accountname; ?>			      </div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center">			      <?php echo $patientsubtype1; ?>			      </div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $username; ?></div></td>
              </tr>
		   <?php 
		   } 
		  
		   ?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan='9'>&nbsp;</td>
			
      
			</tr>
			
          </tbody>
        </table>
<!-- //////////////////////for basi details //////////////////////////////// -->

<!-- ///////////////////////// for bed details ///////////////////////////// -->
<?php
	$colorloopcount=0;
	$sno=0;
	
	$patientcode = $_REQUEST['patientcode'];
	$visitcode = $_REQUEST['visitcode'];

	

	$query32 = "select bedtemplate,labtemplate,radtemplate,sertemplate from master_subtype where auto_number = '".$menusub."'";
	$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$mastervalue = mysqli_fetch_array($exec32);
	$bedtemplate=$mastervalue['bedtemplate'];

	$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
	$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$numtt32 = mysqli_num_rows($exectt32);
	$exectt=mysqli_fetch_array($exectt32);
	$bedtable=$exectt['referencetable'];
	if($bedtable=='')
	{
		$bedtable='master_bed';
	}
	

    $query39 = "SELECT * FROM `ip_bedallocation` where patientcode = '$patientcode' and visitcode = '$visitcode' ";
	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res39 = mysqli_fetch_array($exec39);
    $res39visitcode = $res39['visitcode'];
    $res39patientname = $res39['patientname'];
?>

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
		      <tr>
			     <td colspan="7" align="left" bgcolor="" class="bodytext31"><strong>&nbsp;</strong></td>
			  </tr>
               <tr>
			     <td colspan="7" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong>Bed History</strong></td>
			  </tr>
            <tr>
              <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>
			  <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ward</strong></div></td>
			  <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Bed</strong></div></td>
			  <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Status</strong></div></td>
			<td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Remarks</strong></div></td>

			  <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
			  <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>User</strong></div></td>
			 <!--  <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Action IP</strong></div></td> -->

            </tr>

			<?php
		  
		 
           $query34 = "select * from ip_bedallocation where patientcode = '$patientcode' and visitcode = '$visitcode'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
               $bed = $res34['bed'];
			   $ward = $res34['ward'];
			   $allocated = $res34['recorddate'];
			   $allocatedusername = $res34['username'];
			   $allocatedip = $res34['ipaddress'];

			   $query51 = "select bed from `$bedtable` where auto_number='$bed'";
			   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res51 = mysqli_fetch_array($exec51);
			   $bedname = $res51['bed'];
			  

			  $query781 = "select ward from master_ward where auto_number='$ward'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res781 = mysqli_fetch_array($exec781);
			  $wardname = $res781['ward'];

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
            <tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo $wardname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center">Allocated</div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center"></div></td>

			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo date("d/m/Y", strtotime($allocated)); ?></div></td>

			<td  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $allocatedusername; ?></div></td>
			<!-- <td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo  $allocatedip; ?></div></td> -->

		</tr>
			<?php

		   }
		   ?>

		   <?php
		  
		 
           $query34 = "select * from ip_bedtransfer where patientcode = '$patientcode' and visitcode = '$visitcode' order by auto_number";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
               $bed = $res34['bed'];
			   $ward = $res34['ward'];
			   $allocated = $res34['recorddate'];
			   $allocatedusername = $res34['username'];
			   $allocatedip = $res34['ipaddress'];

			   $query51 = "select bed from `$bedtable` where auto_number='$bed'";
			   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res51 = mysqli_fetch_array($exec51);
			   $bedname = $res51['bed'];
			  

			  $query781 = "select ward from master_ward where auto_number='$ward'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res781 = mysqli_fetch_array($exec781);
			  $wardname = $res781['ward'];

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
            <tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo $wardname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center">Transferred</div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center"></div></td>

			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo date("d/m/Y", strtotime($allocated)); ?></div></td>

			<td  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $allocatedusername; ?></div></td>
			<!-- <td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo  $allocatedip; ?></div></td> -->

		  </tr>
			<?php

		   }
		   ?>

		   <?php
		  
		 
           $query34 = "select * from discharge_revoked where patientcode = '$patientcode' and visitcode = '$visitcode' order by auto_number";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
               $bed = $res34['bed'];
			   $allocated = $res34['updated_date'];
			   $allocatedusername = $res34['username'];
			   $allocatedip = $res34['ipaddress'];
			   $remarks = $res34['remarks'];

			   $query51 = "select bed,ward from `$bedtable` where auto_number='$bed'";
			   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res51 = mysqli_fetch_array($exec51);
			   $bedname = $res51['bed'];
			   $ward = $res51['ward'];
			  

			  $query781 = "select ward from master_ward where auto_number='$ward'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res781 = mysqli_fetch_array($exec781);
			  $wardname = $res781['ward'];

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
            <tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo $wardname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedname; ?></div></td>
			
			<td class="bodytext31" valign="center"  align="left">
			<div align="center">Discharge Revoked</div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo stripslashes($remarks); ?></div></td>

			<td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo date("d/m/Y", strtotime($allocated)); ?></div></td>

			<td  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $allocatedusername; ?></div></td>
			<!-- <td class="bodytext31" valign="center"  align="left">
			<div align="center"><?php echo  $allocatedip; ?></div></td> -->

		  </tr>
			<?php

		   }
		   ?>


			<tr>
			     <td colspan="7" align="left" bgcolor="" class="bodytext31"><strong></strong></td>
			 </tr>



        </table>
<!-- ///////////////////////// for bed details ///////////////////////////// -->


<table width="100%" border="0" align="left" cellpadding="2" cellspacing="2">

	<tr>

		<td colspan="11" class="bodytext32"><strong>&nbsp;</strong></td>

	</tr>

	

	<!-- <tr>

		<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>

		

		<td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>

		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

		<strong>Patientcode</strong></td>

		<td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bed No. </strong></td>

		<td width="33%" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1">Account</span></td>

		</tr>       

	

	<tr>

		<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientname; ?></td>

		

		<td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?></td>

		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?></td>

		<td align="left" valign="top" class="bodytext3"><?php echo $bedno; ?></td>

		<td colspan="2" align="left" valign="top" class="bodytext3"><?php echo $accountname; ?></td>

		</tr> -->

	<tr>

		<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

		<td align="left" valign="middle" class="bodytext3">&nbsp;</td>

		<td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>			

		<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

		</tr>

	<!-- //////////////////////////////////////////////////////////////////////////////////// -->
	<tr>

	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

	  	<table width="433">

        <tr>

	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>VITALS </strong></td> 

     </tr>


				  <?php  //discharge_icd
      $query22=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_iptriage where patientcode='$patientcode' and visitcode='$visitcode' ");

		$exec22=mysqli_fetch_array($query22);

		$foodallergy = $exec22['foodallergy'];

		$drugallergy = $exec22['drugallergy'];

		$foodallergy = $exec22['foodallergy'];

		$emergencycontact = $exec22['emergencycontact'];

		$privatedoctor = $exec22['privatedoctor'];

		$weight = $exec22['weight'];

		$height = $exec22['height'];

		$bmi = $exec22['bmi'];

		$doctornotes = $exec22['notes'];

	    $ipconsultationdate = $exec22['consultationdate'];
						?>

						<!-- <tr bgcolor="#CBDBFA"> 
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  Drug Allergy   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $drugallergy; ?></td>

							<td colspan="1" align="left" valign="middle"  class="bodytext313">Height</td>

							<td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $height; ?></td>

						 </tr>

						 <tr bgcolor="#ecf0f5"> 
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">Food Allergy	 </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $foodallergy; ?></td>

							<td colspan="1" align="left" valign="middle"  class="bodytext313">Weight</td>

							<td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $weight; ?></td>



						 </tr>

						 <tr bgcolor="#CBDBFA"> 
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">&nbsp;	 </span></td>

							<td  align="left" valign="middle"  class="bodytext3">&nbsp;</td>

							<td colspan="1" align="left" valign="middle"  class="bodytext313">BMI</td>

							<td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $bmi; ?></td>

						 </tr> -->

						 <tr bgcolor="#CBDBFA"> 
							<td width="2%" colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td width="45%" align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Drug Allergy  </b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $drugallergy; ?></td>

						 </tr>

						 <tr width="50%" bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b>Food Allergy</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $foodallergy; ?></td>

						 </tr>

						 <tr bgcolor="#CBDBFA"> 
							<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Height</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $height; ?></td>

						 </tr>

						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b>Weight</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $weight; ?></td>

						 </tr>

						 <tr bgcolor="#CBDBFA"> 
							<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>BMI</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo $bmi; ?></td>

						 </tr>



 
						<tr>
						 
						 <td colspan="4" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
					</tr>
      </table>
  </td>
<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	  <!-- <td colspan="4" align="left" valign="middle" class="bodytext3"> -->

	  	<table width="433">

        <tr>

	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>Discharge Details </strong></td> 

     </tr>


				  <?php  //discharge_icd

				  $query_ds = "select * from  ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'  order by auto_number desc ";
						$exec_ds = mysqli_query($GLOBALS["___mysqli_ston"], $query_ds) or die ("Error in Query_ds".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numds=mysqli_num_rows($exec_ds);
						while ($res_ds = mysqli_fetch_array($exec_ds))
						{
								$discharge_status = $res_ds['patientdischargestatus'];
								$dis_recordtime = $res_ds['recordtime'];
								$dis_recorddate = $res_ds['recorddate'];
								$dis_username = $res_ds['username'];
							}


						?>
 
						<tr bgcolor="#CBDBFA"> 
							<td width="2%"  colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td  width="50%" align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Discharge Date</b>   </span></td>

							<td  width="45%"  align="left" valign="middle"  class="bodytext3"><?php echo $dis_recorddate.'&nbsp;&nbsp;'.$dis_recordtime; ?></td>

						 </tr>

						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b>Discharge BY</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo strtoupper($dis_username); ?></td>

						 </tr>

						 <!-- <tr bgcolor="#CBDBFA"> 
							<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Approved By</b>   </span></td>
							<td  align="left" valign="middle"  class="bodytext3"><?php echo ''; ?></td>
						 </tr> -->

						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b>Discharge  Summary</b>   </span></td>

							
							<td width="45%"  align="left" valign="middle"  class="bodytext3"><a href='print_dischargesummary.php?locationcode=<?php echo $locationcodevisit;?>&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>' target='_blank'>View </a>  </td>

							<!-- <td  align="left" valign="middle"  class="bodytext3"><a target="_blank" href="ipemrdischargesummary.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">View</a></td> -->

						 </tr>

						  <?php
	  					
							if($numds>0){ 
					?> 

						 <tr bgcolor="#CBDBFA"> 
							<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Discharge Status</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><?php echo strtoupper($discharge_status);  ?></td>

						 </tr>

						 <?php  } ?>


 
						<tr>
						 
						 <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
					</tr>
				 
		 

      </table>
              	
              </td>

  </tr>
	<!-- //////////////////////////////////////////////////////////////////////////////////// -->
	<!-- //////////////////////////////////////////////////////////////////////////////////// -->
	<!-- //////////////////////////////////////////////////////////////////////////////////// -->

	 
	<tr>

	  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

  </tr>

	<tr>

	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><table width="433">

        <tr>

	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>VITALS INPUT </strong></td> 

     </tr>

				  

				   <tr>

		    <td width="69" class="bodytext3" valign="center"  align="center" 

                bgcolor="#ffffff"><strong>Date</strong></td>

			<td width="65"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>

			<td width="58"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext3"><strong>Systolic</strong></td>

			<td width="62"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext3"><strong>Diastolic</strong></td>

			<td width="56"  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext3"><strong>Pulse</strong></td>

			<td width="56"  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>Resp</strong></td>

	 </tr>

				  

       <?php

	   

	  $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);

	  $num=mysqli_num_rows($exec31);

	  while($res31=mysqli_fetch_array($exec31))

	  { 

       $recorddate=$res31['recorddate'];

	   $recorddate=date("d/m/Y", strtotime($recorddate));

	   $recordtime=$res31['recordtime'];

	 

	   $systolic=$res31['systolic'];

	   $stolic_array[] =$systolic;

	   $highstolic=rsort($stolic_array);

	   $highstolic[0];

	  

	   $diastolic=$res31['diastolic'];

	   $diastolic_array[]=$diastolic;

	   $diasort[]=sort($diastolic_array);

	   $diasort[6];

	   //echo end($diastolic_array);

	   $lastIndex = key($diastolic_array);  

	   $last[] = $diastolic_array[$lastIndex];

	 

	   $resp=$res31['resp'];

	   $pulse=$res31['pulse'];

	   $tempc=$res31['tempc'];

	   $tempf=$res31['tempf'];

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

          <tr <?php echo $colorcode; ?>>

		 

		  <td height="25" width="69" class="bodytext3" valign="center"  align="center" 

               ><?php echo $recorddate; ?></td>

		   <td width="65" class="bodytext3" valign="center"  align="center" 

               ><?php echo $recordtime; ?></td>

		  <td width="58" class="bodytext3" valign="center"  align="center" 

               ><?php echo $systolic; ?></td>

		  <td width="62" class="bodytext3" valign="center"  align="center"><?php echo $diastolic; ?>

	      <td width="56" class="bodytext3" valign="center"  align="center" 

               ><?php echo $resp; ?></td>

		  <td width="56" class="bodytext3" valign="center"  align="center" 

               ><?php echo $pulse; ?></td>    

	    </tr>

		  <?php

		 }

		 ?>

        <tr>

          <td>&nbsp;</td>

        </tr>

      </table></td>

	  <td colspan="4" align="left" valign="middle" class="bodytext3"><table width="433">

        <tr>

          <td colspan="10" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>INPUT / OUTPUT </strong></td>

        </tr>

        <tr>

          <td class="bodytext3" valign="center"  align="center" 

                bgcolor="#ffffff"><strong>Date</strong></td>

          <td  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>

                    <td  align="center" valign="center" 

                bgcolor="#ffffff" class="bodytext3"><strong>Vomitus</strong></td>

          <td  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>Urine</strong></td>

          <td  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>Diarrhea</strong></td>

          <td  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>N/Gast</strong></td>

          <td  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>Drains</strong></td>

          <td  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>Infused</strong></td>  

          <td  align="center" valign="center" 

				bgcolor="#ffffff" class="bodytext3"><strong>Others</strong></td>           

          </tr>

        <?php

	   

	  $query32="select * from fluidbalance where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

	  $exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);

	  $num=mysqli_num_rows($exec32);

	  while($res32=mysqli_fetch_array($exec32))

	  { 

       $fluids=$res32['fluids'];

	   $recorddate=date("d/m/Y", strtotime($res32['recorddate']));

	   $recordtime=$res32['recordtime'];

	   $vomitus=$res32['vomitus'];

	   $urine=$res32['urine'];

	   $drains=$res32['drains'];

       $diarrhea=$res32['diarrhea'];

	   $ngast=$res32['ngast'];

	   $bottle=$res32['bottle'];

	   $amount=$res32['amount'];

	   $infused=$res32['infused'];

	   $others=$res32['others'];





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

        <tr <?php echo $colorcode; ?>>

          <td height="10" class="bodytext3" valign="center"  align="center" 

               ><?php echo $recorddate; ?></td>

          <td class="bodytext3" valign="center"  align="center" 

               ><?php echo $recordtime; ?></td>

                   <td class="bodytext3" valign="center"  align="center" 

               ><?php echo $vomitus; ?></td>

          <td class="bodytext3" valign="center"  align="center" 

               ><?php echo $urine; ?></td>

          <td  align="center" valign="center" 

				class="bodytext3"><?php echo $diarrhea; ?></td>

           <td class="bodytext3" valign="center"  align="center" 

               ><?php echo $ngast; ?></td>

          <td  align="center" valign="center" 

				class="bodytext3"><?php echo $drains; ?></td> 

           <td  align="center" valign="center" 

				class="bodytext3"><?php echo $infused; ?></td>    

           <td  align="center" valign="center" 

				class="bodytext3"><?php echo $others; ?></td>                 

        </tr>

        <?php

		 }

		 ?>

        <tr>

          <td>&nbsp;</td>

        </tr>

              </table></td>

  </tr>
  <!-- ///////////////////////// -->

  <tr>

	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

	  	<table width="433">

        <tr>

	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>ICD </strong></td> 

     </tr>


				  <?php  //discharge_icd
      $query14 = "select * from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'  order by auto_number desc ";

						$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res14 = mysqli_fetch_array($exec14))

						{

						$primarydiag = $res14['primarydiag'];

						$primaryicdcode = $res14['primaryicdcode'];

						$secondarydiag = $res14['secondarydiag'];

						$secicdcode = $res14['secicdcode'];	

						$consultationid = $res14['consultationid'];

						if($primaryicdcode != '')

						{

						?>

						<tr bgcolor="#CBDBFA"> 

						 

						<td colspan="1" align="left" bgcolor="#CBDBFA" class="bodytext31"><strong> &nbsp;</strong></td>

						<td  class="bodytext3">Primary </td>

						<td  class="bodytext3">Primary Code</td>

						 

						</tr>

						<tr bgcolor="#ecf0f5"> 

						
           					 

           		 <td colspan="1" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>

						<td  class="bodytext3"><?php echo $primarydiag; ?></td>

						<td  class="bodytext3"><?php echo $primaryicdcode; ?></td>
						 

						</tr>

						<?php }

						if($secicdcode != '')

						{

						?>

						<tr bgcolor="#CBDBFA"> 

						 
						 
						<td colspan="1" align="left" bgcolor="#CBDBFA" class="bodytext31"><strong> &nbsp;</strong></td>

						<td  class="bodytext3">Secondary </td>

						<td  class="bodytext3">Secondary Code</td>
						 

						</tr>

						<tr bgcolor="#ecf0f5"> 


           		 <td colspan="1" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>


						<td  class="bodytext3"><?php echo $secondarydiag; ?></td>

						<td  class="bodytext3"><?php echo $secicdcode; ?></td>
						 

						</tr>

						

						<?php					

						}
						?>
						<tr>
						 
						 <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
					</tr>
					 

						
					<?php } ?>
					 
		 
        <tr>

          <td>&nbsp;</td>

        </tr>

      </table>
  </td>

	  <td colspan="4" align="left" valign="middle" class="bodytext3">

	  	<table width="433">

        <tr>

	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>Durgs, Tests & Procedures</strong></td> 

     </tr>

				  <?php  //discharge_icd
       
						?>

						<tr bgcolor="#CBDBFA"> 
							<td width="2%" colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td width="50%"  align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Drugs</b>   </span></td>

							<td width="45%"  align="left" valign="middle"  class="bodytext3"><b  id="myBtn" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>


						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b >Laboratory</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><b  id="labbtn" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>

						 </tr>

						 <tr bgcolor="#CBDBFA"> 
							<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Radiology</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><b  id="radbtn" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>

						 </tr>

						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b >Services & Procedures </b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><b  id="Services" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>

						 </tr>

						<tr>
						 
						 <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
					</tr>
				 
		 

      </table>
              	
              </td>

  </tr>
  <!-- ///////////////////////// -->

  <tr>

	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
 

	  	<table width="433">

        <tr>

	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>Notes</strong></td> 

     </tr>

				  <?php  //discharge_icd
       
						?>

						<tr bgcolor="#CBDBFA"> 
							<td width="2%" colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td width="50%"  align="left" valign="middle"  class="bodytext3"><span class="bodytext32">  <b>Nursing cardex</b>   </span></td>


							<td width="45%"  align="left" valign="middle"  class="bodytext3"><b  id="nursingbtn" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>


						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b >Doctor Notes</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><b  id="docotorbtn" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>

						 </tr>

						 <tr bgcolor="#ecf0f5"> 
						 	<td colspan="1" align="left" valign="middle"  class="bodytext313">&nbsp;</td>
							<td align="left" valign="middle"  class="bodytext3"><span class="bodytext32"><b >Theatre Notes</b>   </span></td>

							<td  align="left" valign="middle"  class="bodytext3"><b  id="theatrebtn" style="color: blue;text-decoration: underline; cursor: pointer;">View</b>  </td>

						 </tr>


 
						<tr>
						 
						 <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
					</tr>
				 
		 

      </table>
              	
              </td>
	  <td colspan="4" align="left" valign="middle" class="bodytext3">

  		</td>
  </tr>
  <!-- ///////////////////////// -->
  <!-- ///////////////////////// -->
  <!-- ///////////////////////// -->

			<tr>
			  	<td colspan="2"  align="left" bgcolor="" class="bodytext31">
			  		<!-- <a href="javascript:window.open('ip_emr_medicine_history.php?patientcode=<?=$patientcode;?>&&visitcode=<?=$visitcode;?>', 'MedicineHistory', 'width=1400,height=650');"><b>IP Drug History</b></a> </td> -->
			  		<!-- <h3  id="myBtn" style="color: blue;text-decoration: underline; cursor: pointer;"><b>IP Drug History</b></h3> -->
			  		 </td>

			  		<td colspan="3"  align="left" bgcolor="" class="bodytext31">
			  			<!-- <h3  id="Services" style="color: blue;text-decoration: underline; cursor: pointer;"><b>Services & Procedures </b></h3> -->
			  			<!-- <a data-toggle="modal" href="ip_emr_services.php?patientcode=<?=$patientcode;?>&&visitcode=<?=$visitcode;?>&&drugs'" data-target="#modal">Click me</a> -->
			  		<!-- </td> -->

			  			<!-- Trigger/Open The Modal -->
<!-- <button>Open Modal</button> -->
<!-- The Modal -->
<div id="myModal" class="modal" bgcolor="#ffffff">

  <!-- Modal content -->
  <!-- <div  bgcolor="#ffffff"> -->
   
    	<?php
	  $totalamount=0;
	  $colorloopcount=0;
	  $sno=0;
	

	$query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		// $patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['consultationdate'];
		$accountname=$res1['accountfullname'];
		$username=$res1['username'];
		$patientsubtype =$res1['subtype'];
		$gender =$res1['gender'];
		$billtype = $res1['billtype'];
	    $menusub=$res1['subtype'];
	}
	
	   $query39 = "select * from ipmedicine_prescription where patientcode = '$patientcode' and visitcode = '$visitcode' ";
	   $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	   $res39 = mysqli_fetch_array($exec39);
	   $res39visitcode = $res39['visitcode'];
	   $patientname = $res39['patientname'];
		?>
		<table class="modal-content" id="AutoNumber3" bgcolor="#ffffff" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 
              border="0">
          <tbody>
		      <tr>
		      	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			     <td colspan="8" align="left" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center;"> Drug History</h2></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='drug_close'>&times;</span></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			      
			  </tr>
               <tr>
               	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			     <td colspan="9" align="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $patientname;  ?>/<?php echo $patientcode; ?>/<?php echo $res39visitcode; ?></strong></td>
			     <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  </tr>
            <tr>
            	<td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
              <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>S.No.</strong></div></td>
				 
				 <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Ref No</strong></div></td>
				  <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Medicine</strong></div></td>
				 <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Quantity</strong></div></td>
				   <!--  <td  align="left" valign="left" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
	                <td  align="left" valign="left" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td> -->
				       <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Requested Date</strong></div></td>
	                 <td  align="left" valign="left" 
                 bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Requested By</strong></div></td>
                   <!--  <td  align="left" valign="left" 
                 bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Requested IP </strong></div></td> -->
                 <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Issued Qty</strong></div></td>
				 <td class="bodytext31" valign="left"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Issued Date</strong></div></td>
	                 <td  align="left" valign="left" 
                 bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issued By</strong></div></td>
                   <!--  <td width="16%"  align="left" valign="left" 
                 bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issued IP </strong></div></td> -->
                 <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

              </tr>
           <?php
		  
		 
           $query34 = "select * from ipmedicine_prescription where patientcode = '$patientcode' and visitcode = '$visitcode'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $itemname = $res34['itemname'];
		   $itemcode = $res34['itemcode'];
		   $docno = $res34['docno'];
		   $quantity = $res34['prescribed_quantity'];
		   $res34date = $res34['date'];
		   $rateperunit = $res34['rateperunit'];
		   $totalrate = $res34['totalrate'];
		   $freestatus = $res34['freestatus'];
		   $username = $res34['username'];
		   $ipaddress = $res34['ipaddress'];
		   $issuedocno = $res34['issuedocno'];
		   $dischargemedicine = $res34['dischargemedicine'];

		   $query35 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' and (docno='$docno' or docno='$issuedocno') and itemcode='$itemcode'";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res35 = mysqli_fetch_array($exec35);
           $issuedqty = $res35['quantity'];
		   $issueduser = $res35['username'];
		   $issuedipaddress = $res35['ipaddress'];
		   $issueddate = $res35['date'];

		   $totalamount = $totalamount + $totalrate;
		   

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

			if($dischargemedicine=='yes'){
					$colorcode='bgcolor="#ffc34d"';
			}
			?>
			
          <tr <?php echo $colorcode; ?>>

          	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			<td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo $docno; ?></div></td>
			<td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $itemname; ?></div></td>
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo intval($quantity); ?></div></td>
			<!-- <td class="bodytext31" valign="left"  align="left">
			<div align="right"><?php echo number_format($rateperunit,2,'.',','); ?></div></td>

			<td  align="left" valign="left" class="bodytext31"><div align="right"><?php echo number_format($totalrate,2,'.',','); ?></div></td> -->
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo  date("d/m/Y", strtotime($res34date)); ?></div></td>
			<td class="bodytext31" valign="left" align="left"><div align="left"><?php echo strtoupper($username);?></div></td>
			<!-- <td class="bodytext31"  valign="left" align="left"><div align="left"><?php echo $ipaddress;?></div></td> -->
            <td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo intval($issuedqty); ?></div></td>
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php if($issueddate!='') echo  date("d/m/Y", strtotime($issueddate)); ?></div></td>
			<td class="bodytext31" valign="left" align="left"><div align="left"><?php echo strtoupper($issueduser);?></div></td>
			<!-- <td class="bodytext31"  valign="left" align="left"><div align="left"><?php echo $issuedipaddress;?></div></td> -->
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

		</tr>
			<?php } ?>

			<!-- <tr>
				 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
              		<td class="bodytext31" valign="left" bordercolor="#f3f3f3" align="left" 
                colspan="9"><strong>Direct Issue</strong></td>
                 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
				
			</tr>

        <?php
			
			 $query34 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' and (docno not in (select docno from ipmedicine_prescription where patientcode = '$patientcode' and visitcode = '$visitcode' ) and docno not in (select issuedocno from ipmedicine_prescription where patientcode = '$patientcode' and visitcode = '$visitcode' ))";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $itemname = $res34['itemname'];
		   $itemcode = $res34['itemcode'];
		   $docno = $res34['docno'];
		   $quantity = $res34['quantity'];
		   $res34date = '';
		   $rateperunit = $res34['rateperunit'];
		   $totalrate = $res34['totalrate'];
		   //$freestatus = $res34['freestatus'];
		   $username = '';
		   $ipaddress = '';
		   $issuedocno = '';

           $issuedqty = $res34['quantity'];
		   $issueduser = $res34['username'];
		   $issuedipaddress = $res34['ipaddress'];
		   $issueddate = $res34['date'];

		   $totalamount = $totalamount + $totalrate;
		   

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
			
          <tr <?php echo $colorcode; ?>>

          	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			<td class="bodytext31" valign="left"  align="left"><div align="left"><?php // echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo $docno; ?></div></td>
			<td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $itemname; ?></div></td>
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo intval($quantity); ?></div></td>
			  <td class="bodytext31" valign="left"  align="left">
			<div align="right"><?php // echo number_format($rateperunit,2,'.',','); ?></div></td>

			<td  align="left" valign="left" class="bodytext31"><div align="right"><?php // echo number_format($totalrate,2,'.',','); ?></div></td>  
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"></div></td>
			<td class="bodytext31" valign="left" align="left"><div align="left"><?php echo strtoupper($username);?></div></td>
			 <td class="bodytext31"  valign="left" align="left"><div align="left"><?php echo $ipaddress;?></div></td>  
            <td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php echo intval($issuedqty); ?></div></td>
			<td class="bodytext31" valign="left"  align="left">
			<div align="left"><?php if($issueddate!='') echo  date("d/m/Y", strtotime($issueddate)); ?></div></td>
			<td class="bodytext31" valign="left" align="left"><div align="left"><?php echo strtoupper($issueduser);?></div></td>
			  <td class="bodytext31"  valign="left" align="left"><div align="left"><?php // echo $issuedipaddress;?></div></td>  

			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

		</tr>
			<?php } ?>	 -->

			<style type="text/css">
	.box{
	width:8px;
	height:8px;
	color:transparent;
}
 
.color123{
	background: #ffc34d;
}
 
</style>
			 
            <tr>
            	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
              <td class="bodytext311" valign="right" bordercolor="#f3f3f3" align="right" 
                bgcolor="#ecf0f5" colspan="9"><span class="box color123">aa</span>&nbsp;&nbsp;Discharged Medicines.</td>
                 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			</tr>
			 <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff" colspan="12">&nbsp;</td>
			</tr>
			 <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff" colspan="12">&nbsp;</td>
			</tr>
			<tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff" colspan="12">&nbsp;</td>
			</tr>
			
          </tbody>
        </table>	
  </div>

<!-- </div> -->

<div id="serviceModal" class="modal" bgcolor="#ffffff">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" align="center" border="0">

          <tbody style="width: 80%; margin: auto; padding-left: 300px;" >
           	<tr >
           		 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center;">Services & Procedures</h2></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='close_service'>&times;</span></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp; </strong></td>

			  </tr>

            <tr>

              <td width="5%" class="bodytext31" valign="left"  align="left" bgcolor="#ffffff"><div align="left"><strong>&nbsp;</strong></div></td>
              <td   class="bodytext31" valign="left"  align="left" bgcolor="#ccccc"><div align="left"><strong>No.</strong></div></td>
				
				  <td   class="bodytext31" valign="left"  align="left" 

                bgcolor="#ccccc"><div align="left"><strong>Date</strong></div></td>

				<td width="10%"  align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Ref No.</strong></div></td>

				<td    align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Services</strong></div></td>

				<!-- <td width="13%"  align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Rate  </strong></div></td>

				<td width="13%"  align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Amount </strong></div></td> -->

				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Requested By</strong></div></td>
				<!-- <td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Processed By</strong></div></td> -->

				  <td width="5%" class="bodytext31" valign="left"  align="left" bgcolor="#ffffff"><div align="left"><strong>&nbsp;</strong></div></td>


                  </tr>

				  		<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

	{

	$status='completed';

	}

			$query17 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and process='pending' and wellnessitem <> '1'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res17 = mysqli_fetch_array($exec17))

			{


				$paharmitemname=$res17['servicesitemname'];
				$autonumber=$res17['auto_number'];
				$consultationdate=$res17['consultationdate'];
				$pharmitemcode=$res17['servicesitemcode'];
			$pharmitemrate=$res17['servicesitemrate'];
			$freestatus=$res17['freestatus'];
			$username=$res17['username'];
			$docno12345=$res17['iptestdocno'];

		

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

			$totalamount=$totalamount+$pharmitemrate;

			$totalamount=number_format($totalamount,2);

		

			?>

			  <tr <?php echo $colorcode; ?>>
			  	<td   class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>

			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			 
			 
			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $consultationdate; ?> </div></td>
			 
			  <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $docno12345; ?> </div></td>

			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $paharmitemname; ?></div></td>

			    <!-- <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $pharmitemrate; ?></div></td> -->
				 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo strtoupper($username); ?></div></td>
				 <!-- <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo strtoupper($username); ?></div></td> -->

				  
					<td width="5%" class="bodytext31" valign="left"  align="left" bgcolor="#ffffff"><div align="left"><strong>&nbsp;</strong></div></td>


				</tr>

			<?php } ?>

			<tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ffffff" colspan="1">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ecf0f5" colspan="5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ffffff" colspan="1">&nbsp;</td>
			</tr>
			 <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff" colspan="7">&nbsp;</td>
			</tr>
			<tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff" colspan="7">&nbsp;</td>
			</tr>
           

          </tbody>

        </table>	
</div>


</td>

<!-- /////////////////// -->

			   
      <!-- ///////////////// -->
      <tr>
			  	<td colspan="2"  align="left" bgcolor="" class="bodytext31">
			  			
			  		 </td>

			  		<td colspan="3"  align="left" bgcolor="" class="bodytext31">
			  			<!-- <h3  id="radbtn" style="color: blue;text-decoration: underline; cursor: pointer;"><b>Radiology</b></h3> -->
			  <!-- ///////////////////////////////// for doc notes ////////////////// -->
			  

<div id="labModal" class="modal" bgcolor="#ffffff">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" align="center" border="0">

          <tbody  >
          		<tr >
           		 <td colspan="8" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
           		</tr>
           	<tr >
           		 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="6" align="center" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center; ">Lab Tests</h2></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='close_lab'>&times;</span></strong></td>
			  </tr>


            <tr>
            	 <td  width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

              <td   class="bodytext31" valign="left"  align="left" 

                bgcolor="#ccccc"><div align="left"><strong>No.</strong></div></td>

				<td   align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Ref No. </strong></div></td>

				<td  align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Lab</strong></div></td>

				<!-- <td    align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Rate  </strong></div></td>

				<td    align="left" valign="left" 

                bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Amount </strong></div></td> -->

				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Requested By </strong></div></td>
				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Results By </strong></div></td>
				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Print </strong></div></td>
                 <td  width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>


                  </tr>

				  		<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

	{

	$status='completed';

	}

			$query17 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and resultentry='completed'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

				$paharmitemname=$res17['labitemname'];

				$autonumber = $res17['auto_number'];

				

				$pharmitemcode=$res17['labitemcode'];

			$pharmitemrate=$res17['labitemrate'];

			$freestatus=$res17['freestatus'];
			$username=$res17['username'];
			$iptestdocno=$res17['iptestdocno'];
			$iptestdocno=$res17['iptestdocno'];
			$sampleid=$res17['sampleid'];
			$labitemcode=$res17['labitemcode'];

		

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

				$query33="select * from  ipresultentry_lab where patientvisitcode = '$visitcode' AND sampleid='$sampleid' group by itemname  " ;
				$exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33);
				$num=mysqli_num_rows($exec33);
				while($res33=mysqli_fetch_array($exec33))
				{ 

				$itemname='';
				//$itemname=$res33['itemname'];
				$labdocnumber=$res33['docnumber'];
				$itemname=$res33['itemname'];
				$itemdate=$res33['recorddate'];
				$username_processed=$res33['username'];

				
				}

			$totalamount=$totalamount+$pharmitemrate;

			$totalamount=number_format($totalamount,2);

			?>

			  <tr <?php echo $colorcode; ?>>
			  	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>

			    <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $iptestdocno ; ?>


			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $paharmitemname; ?></div></td>

			   <!--  <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $pharmitemrate; ?></div></td>

				<td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $pharmitemrate; ?></div></td> -->
				<td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo strtoupper($username) ; ?></div></td>
				<td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo strtoupper($username_processed) ; ?></div></td>
				<td class="bodytext31" valign="left"  align="left"><div align="left"><a href="emr_lab_print.php?patientcode=<?=$patientcode;?>&&visitcode=<?=$visitcode;?>&&docnumber=<?=$labdocnumber;?>&&labcode=<?=$labitemcode;?>&&sampleid=<?=$sampleid;?>" target="_blank">Print</a></div></td>
				 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
				


				</tr>

			<?php } ?>

			  <tr>
			  	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

              <td colspan="6" class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

             </tr>

             <tr>
			  	 <td  colspan="8" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

             </tr>
             <tr>
			  	 <td  colspan="8" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

             </tr>

           

             </tbody>
</table>
</div>

<div id="radModal" class="modal" bgcolor="#ffffff">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" align="center" border="0">

          <tbody >
          		<tr>
           		 <td colspan="7" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
           		</tr>
           	<tr>
           		 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center;">Radiology Tests</h2></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='close_rad'>&times;</span></strong></td>
			  </tr>


            <tr>
            	 <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

              <td class="bodytext31" valign="left"  align="left" 

                bgcolor="#ecf0f5"><div align="left"><strong>No.</strong></div></td>

				<td  align="left" valign="left" 

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Ref No. </strong></div></td>

				<td  align="left" valign="left" 

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Radiology</strong></div></td>

				<!-- <td  align="left" valign="left" 

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Rate  </strong></div></td>

				<td  align="left" valign="left" 

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Amount </strong></div></td> -->

				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Requested By </strong></div></td>
				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Results By </strong></div></td>
				<td    align="left" valign="left" bgcolor="#ccccc" class="bodytext31"><div align="left"><strong>Print </strong></div></td>
                 <td  width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

				

              

                  </tr>

				  		<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

	{

	$status='completed';

	}

			$query17 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res17 = mysqli_fetch_array($exec17))

			{

				$paharmitemname=$res17['radiologyitemname'];
				$autonumber=$res17['auto_number'];

				

				$pharmitemcode=$res17['radiologyitemcode'];

			$pharmitemrate=$res17['radiologyitemrate'];

			$freestatus=$res17['freestatus'];
			$username=$res17['username'];
			$radref=$res17['iptestdocno'];
			$labdocnumber = $res17['docnumber'];

		

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

			$query2 = "select * from ipresultentry_radiology where patientvisitcode = '$visitcode' and itemcode='$pharmitemcode' and docnumber='$labdocnumber' group by itemname ";
				  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res2 = mysqli_fetch_array($exec2))
				  {
				  $labtestname = $res2['itemname'];
				  $labdocnumber = $res2['docnumber'];
				  $pusername = $res2['username'];
				}

			$totalamount=$totalamount+$pharmitemrate;

			$totalamount=number_format($totalamount,2);

			?>

			  <tr <?php echo $colorcode; ?>>

			  	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>

			    <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $radref; ?> </div></td>

			 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $paharmitemname; ?></div></td>

			   <!--  <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo $pharmitemrate; ?></div></td> -->

				   
				  <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo strtoupper($username) ; ?></div></td>
				  <td class="bodytext31" valign="left"  align="left"><div align="left"><?php echo strtoupper($pusername) ; ?></div></td>
				 

				 <td class="bodytext31" valign="left"  align="left"><div align="left"><a href="printradiologyresultsip.php?patientcode=<?=$patientcode;?>&&visitcode=<?=$visitcode;?>&&docnumber=<?=$labdocnumber;?>&&labcode=<?=$labitemcode;?>&&sampleid=<?=$sampleid;?>" target="_blank">Print</a></div></td>

				 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
				

				</tr>

			<?php } ?>

			  <tr>
			  	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

              <td colspan="6" class="bodytext31" valign="left"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

				 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

             </tr>

              <tr>
			  	 <td  colspan="8" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

             </tr>
             <tr>
			  	 <td  colspan="8" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

             </tr>

           

          </tbody>

        </table>	
</div>

<!-- ///////////////// -->
</td>
			  	 
			  </tr>
			  <!-- <tr>
			  	<td colspan="3"  align="center" bgcolor="" class="bodytext31">&nbsp;</td>
			  </tr>	 -->
      <!-- ///////////////// -->
      <!-- ///////////////// -->
       <tr>
			  	<td colspan="2"  align="left" bgcolor="" class="bodytext31">
			  			<!-- <h3  id="nursingbtn" style="color: blue;text-decoration: underline; cursor: pointer;"><b>Nursing cardex</b></h3> -->
			  		 </td>

			  		<td colspan="2"  align="left" bgcolor="" class="bodytext31">
			  			<!-- <h3  id="docotorbtn" style="color: blue;text-decoration: underline; cursor: pointer;"><b>Doctor Notes</b></h3> -->
			  		 <!-- </td> -->

			  <!-- ///////////////////////////////// for doc notes ////////////////// -->
		
	  

<div id="nursingModal" class="modal" bgcolor="#ffffff">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" align="center" border="0">

          <tbody  >
           	<tr >
           		 <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="3" align="left" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center;">Nursing cardex</h2></strong></td>
			      <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='close_nursing'>&times;</span></strong></td>
			  </tr>
			  <?php

		

	    $query14 = "select * from ip_progressnotes where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = '' order by auto_number desc ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numdsnc=mysqli_num_rows($exec14);
		while ($res14 = mysqli_fetch_array($exec14))

		{

		$date = $res14["recorddate"];

		$previousnotes = $res14["notes"];

		$res14username = $res14["username"];

		$res14recordtime = $res14["recordtime"];

		

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

        <tr <?php echo $colorcode; ?>>

        	 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        <td width="11%" align="left" valign="bottom"  class="bodytext3">

				   <?php echo $date; ?>                        </td>

                        <td width="8%" align="left" valign="bottom"  class="bodytext3"><?php echo $res14recordtime; ?></td>

				        <td align="left" valign="bottom"  class="bodytext3"><?php echo $previousnotes; ?> - <?php echo strtoupper($res14username); ?></td>

				         <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                      </tr>

                      <?php

		}
		
		if($numdsnc>0){
		?>

		<tr>
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>

		
		
	<?php }else{  ?>
			<tr>
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  <td colspan="3" align="center" bgcolor="#ffffff" class="bodytext31"><strong>There is No Nursing cardex!</strong></td>
			   <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
	<?php } ?>

	<tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		<tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>

			   </tbody>

        </table>	
</div>
 <!-- ///////////////////////////////// for doc notes ////////////////// -->
			  

<div id="docModal" class="modal" bgcolor="#ffffff">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" align="center" border="0">

          <tbody style="width: 80%; margin: auto; padding-left: 300px;" >
           	<tr >
           		 <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="3" align="center" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center;">Doctor Notes</h2></strong></td>
			      <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='close_doc'>&times;</span></strong></td>

			  </tr>


				  <?php
      $query14 = "select * from ip_doctornotes where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = '' order by auto_number desc ";
		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numdsdn=mysqli_num_rows($exec14);
		while ($res14 = mysqli_fetch_array($exec14))
		{
		$date = $res14["recorddate"];
		$previousnotes = $res14["notes"];
		$res14username = $res14["username"];
		$res14recordtime = $res14["recordtime"];
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
        <tr <?php echo $colorcode; ?>>
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3"><?php echo $res14recordtime; ?></td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $previousnotes; ?> - <?php echo strtoupper($res14username); ?></td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>
                      <?php
		}
		if($numdsdn>0){
		?>

		<tr>
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		
		
	<?php }else{  ?>
			<tr>
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  <td colspan="3" align="center" bgcolor="#ffffff" class="bodytext31"><strong>There is No Doctor Notes!</strong></td>
			   <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
	<?php } ?>

	<tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		<tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		<!-- <tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr> -->

    </tbody>
</table>
</div>


<div id="theatreModal" class="modal" bgcolor="#ffffff">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" align="center" border="0">

          <tbody style="width: 80%; margin: auto; padding-left: 300px;" >
           	<tr >
           		 <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="3" align="center" bgcolor="#ffffff" class="bodytext31"><strong><h2 style="text-align: center;">Theatre Notes</h2></strong></td>
			      <td width="5%" colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong><span class="close" id='close_theatre'>&times;</span></strong></td>

			  </tr>


				  <?php
       $query14 = "select * from master_theatre_booking where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number  ";
		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numdsdn=mysqli_num_rows($exec14);
		while ($res14 = mysqli_fetch_array($exec14))
		{
		$date = date("Y-m-d",strtotime($res14["surgerydatetime"]));
		$anaesthetisit_note = $res14["anaesthetisit_note"];
		$intra_anaesthetist_notes = $res14["intra_anaesthetist_notes"];
		$post_anaesthetist_notes = $res14["post_anaesthetist_notes"];
		$doctor_note = $res14["doctor_note"];
		$intra_doctor_notes = $res14["intra_doctor_notes"];
		$post_doctor_notes = $res14["post_doctor_notes"];
		
		$res14username = $res14["username"];
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
        <tr bgcolor="#CBDBFA">
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3">Anaestheisit</td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $anaesthetisit_note; ?>; </td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>
		
		 <tr bgcolor="#ecf0f5">
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3">Intra Anaestheisit</td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $intra_anaesthetist_notes; ?>; </td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>


		 <tr bgcolor="#CBDBFA">
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3">Post Anaestheisit</td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $post_anaesthetist_notes; ?>; </td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>


		 <tr bgcolor="#ecf0f5">
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3">Doctor</td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $doctor_note; ?>;</td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>

		 <tr bgcolor="#CBDBFA">
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3">Intra Doctor</td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $intra_doctor_notes; ?>; </td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>

		 <tr bgcolor="#ecf0f5">
        	<td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
                          <div align="center" class="bodytext3"><?php echo $date; ?></div>
                        </td>
						 <td width="14%" align="left" valign="bottom"  class="bodytext3">Post Doctor</td>
                        <td align="left" valign="bottom"  class="bodytext3"><?php echo $post_doctor_notes; ?>; </td>

                        <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>

                        </tr>
                      <?php
		}
		if($numdsdn>0){
		?>

		<tr>
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  <td colspan="3" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong> &nbsp;</strong></td>
			   <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		
		
	<?php }else{  ?>
			<tr>
			 <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
			  <td colspan="3" align="center" bgcolor="#ffffff" class="bodytext31"><strong>There is No Doctor Notes!</strong></td>
			   <td colspan="1" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
	<?php } ?>

	<tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		<tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr>
		<!-- <tr>
						   <td colspan="5" align="left" bgcolor="#ffffff" class="bodytext31"><strong> &nbsp;</strong></td>
		</tr> -->

    </tbody>
</table>
</div>

<!-- ////////////// DISCHARGE SUMMARY /////////////////////// -->
<!-- ////////////// DISCHARGE SUMMARY /////////////////////// -->
<?php

$query22 = "select * from master_customer where customercode = '$patientcode'";

$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

$res22 = mysqli_fetch_array($exec22);

$address1 = $res22['address1'];

$address2 = $res22['address2'];

$area = $res22['area'];

$city = $res22['city'];

$state = $res22['state'];

$pincode = $res22['pincode'];



$query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode='$visitcode'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$patientname = $res1["patientfullname"];

$patientcode = $res1["patientcode"];

$patientage = $res1["age"];

$patientgender = $res1["gender"];



$query2 = "select * from dischargesummary where patientcode = '$patientcode' and patientvisitcode='$visitcode'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$consultantofficer = $res2["consultantofficer"];

$summarynumber = $res2["summarynumber"];

$summarydate = $res2["summarydate"];

$surgerydate = $res2["surgerydate"];

$res2dischargedate = $res2["dischargedate"];

$res2dischargetime = $res2["dischargetime"];

$res2drugallergies = $res2["drugallergies"];

$res2finaldiagnosis = $res2["finaldiagnosis"];

$res2chiefcomplaints= $res2["chiefcomplaints"];

$res2patienthistory= $res2["patienthistory"];

$res2temperature= $res2["temperature"];

$res2pulse= $res2["pulse"];

$res2bloodpressure= $res2["bloodpressure"];

$res2clinicalexamination= $res2["clinicalexamination"];

$res2investigationdetails= $res2["investigationdetails"];

$res2treatmentgiven= $res2["treatmentgiven"];

$res2conditionatdischarge= $res2["conditionatdischarge"];

$res2diet= $res2["diet"];

$res2physicalactivity= $res2["physicalactivity"];

$res2medicalofficer= $res2["medicalofficer"];

$res2medication= $res2["medication"];

$res2medication= $res2["medication"];

$res2followup= $res2["followup"];

$res2consultationreferral= $res2["consultationreferral"];



$query34 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode='$visitcode'";

$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res34 = mysqli_fetch_array($exec34);

$ward = $res34['ward'];

$bed = $res34['bed'];



           $query51 = "select * from master_bed where auto_number='$bed'";

		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res51 = mysqli_fetch_array($exec51);

		   $bedname = $res51['bed'];

		

		   $query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";

		   $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res7811 = mysqli_fetch_array($exec7811);

		   $wardname = $res7811['ward'];

		   

$query35 = "select * from ip_bedallocation where patientcode = '$patientcode' and visitcode='$visitcode'";

$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res35 = mysqli_fetch_array($exec35);

$dateofadmission = $res35["recorddate"];

$admissiontime = $res35["recordtime"];

$dischargedate = $res34['recorddate'];

$dischargetime = $res34['recordtime'];


?>
<div id="dischargeModal" class="modal" bgcolor="#ecf0f5">
<table  class="modal-content" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bgcolor="#ccccc" cellspacing="0" cellpadding="2" width="100%" align="center" border="0" style="background-color: #ecf0f5">

           
			   

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

         	  <table width="1000" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#ccccc" id="AutoNumber3" style="border-collapse: collapse">

   	
   				<tr>

                <td colspan="7" bgcolor="#ffffff" class="bodytext3"><div align="center"><strong> &nbsp; </strong></div></td>

                </tr>

                <tr>

                <td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><b>Discharge Summary  </b></div></td>
                   <td colspan="1" align="left" bgcolor="#ecf0f5" class="bodytext31"><strong><span class="close" id='close_discharge'>&times;</span></strong></td>

                </tr>





			    <tr bgcolor="#ecf0f5">

			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext3">Patient</span></td>

			      <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $patientname; ?></td>

			      <td  align="left" valign="middle" class="bodytext3"><span class="bodytext3">Patient Code </span></td>

			      <td align="left" valign="middle" class="bodytext3"><?php echo $patientcode; ?></td>

			      <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Doc No.</strong></td>

			      <td  align="left" valign="middle" class="bodytext3"><?php echo $summarynumber; ?></td>

		      </tr>

		        <tr bgcolor="#ecf0f5">

		          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext3">Address 1 </span></td>

		          <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $address1; ?></td>

		          <td align="left" valign="middle"><span class="bodytext3">Visit Code</span></td>

		          <td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?></td>

		          <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Date </strong></td>

		          <td align="left" valign="middle" class="bodytext3"><?php echo $summarydate; ?></td>

	            </tr>

		         <tr bgcolor="#ecf0f5">

		          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left"><span class="bodytext3">Address 2 </span></div></td>

		          <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $address1; ?></td>

		          <td align="left" valign="middle"><span class="bodytext3">Area &amp; City </span></td>

		          <td align="left" valign="middle" class="bodytext3"><?php echo $area.' & '.$city; ?></td>

		          <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Age &amp; Gender </strong></td>

		          <td align="left" valign="middle" class="bodytext3"><?php echo $patientage.' & '.$patientgender; ?></td>

	            </tr>

		         <tr bgcolor="#ecf0f5">

                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Admission Date</strong></td>

                <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $dateofadmission; ?></td>

                <td align="left" valign="middle"><div align="left"><span class="bodytext3"><strong>Admission Time </strong></span></div></td>

                <td align="left" valign="middle" class="bodytext3"><?php echo $admissiontime; ?></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Ward &amp; Bed </strong></td>

                <td align="left" valign="middle" class="bodytext3"><?php echo $ward.' & '.$bed; ?></td>

			  </tr>



			   <tr bgcolor="#ecf0f5">

			    <td align="left" valign="middle" ><span class="bodytext3"><strong>Discharge Date </strong></span></td>

			    <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $res2dischargedate; ?></td>

			    <td align="left" valign="middle" ><span class="bodytext3"><strong>Discharge Time </strong></span></td>

			    <td align="left" valign="middle" class="bodytext3"><?php echo $res2dischargetime; ?></td>

			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Surgery Date </strong></td>

			    <td align="left" valign="middle" class="bodytext3"><?php echo $surgerydate; ?></td>

			  </tr>

        </table>

				

         <tr>

        <td>

	    <table width="1000" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

            </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Drug Allergies </strong></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2drugallergies; ?></td>

            </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Final Diagnosis </strong></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2finaldiagnosis; ?></td>

            </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Chief Complaints </strong></span></td>

            <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2chiefcomplaints; ?></td>

            </tr>

            

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext311"><strong>Patient History </strong></span></td>

             <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2patienthistory; ?></td>

            </tr>

			 <tr>

                <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

            </tr>

			

            <tr>

              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Clinical Examiniation </strong></td>

              </tr>

          

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Clinical Examiniation </strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2clinicalexamination; ?></td>

            </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Temparature</strong></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2temperature; ?></td>

              </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Pulse</strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2pulse; ?></td>

              </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>B.P.</strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2bloodpressure; ?></td>

              </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Investigation Details </strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2investigationdetails; ?></td>

            </tr>

            

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Consultation Referral </strong></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res2consultationreferral; ?></td>

            </tr>

            

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Treatment Given </strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res2treatmentgiven; ?> </td>

            </tr>

            

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Condition At Discharge </strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><?php echo $res2conditionatdischarge; ?></span></td>

            </tr>

            <tr>

              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

            

            <tr>

              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge Advice </strong></td>

			</tr>

			<tr>  

              <td width="143" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

			  <td width="143" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Diet</strong></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2diet; ?></td>

              </tr>

            

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Physical Activity </strong></span></td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"> <?php echo $res2physicalactivity; ?></td>

              </tr>

            <tr>

              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

            </tr>

            <tr>

              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Medication </strong></span></td>

			</tr>

			<tr>  

             <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2medication; ?></td>

            </tr>

            <tr>

              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

            <tr>

              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Follow Up </strong></td>

			  </tr>

			  <tr>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res2followup; ?></td>

            </tr>

            <tr>

              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

            <tr>

              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Medical Officer </strong></td>

			  </tr>

			  <tr>

              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2medicalofficer; ?></td>

            </tr>

            <tr>

              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

            <tr bgcolor="#ecf0f5">  

              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5c" class="bodytext31"><strong>Consultant</strong></td>

			 </tr>

			 <tr bgcolor="#ecf0f5">  

               <td colspan="10"  align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $consultantofficer; ?></td>

            </tr>

            <tr bgcolor="#ecf0f5">  

              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

        </table>		</td>

      </tr>

      <tr>

        <td class="bodytext31" valign="middle">

		<strong><div align="left">&nbsp;</div>

		</strong></td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

  </table>
<!-- ////////////// DISCHARGE SUMMARY /////////////////////// -->
<!-- ////////////// DISCHARGE SUMMARY /////////////////////// -->
 

<!-- ///////////////// -->
</td>
			  	 
			  </tr>
			  <tr>
			  	<td colspan="3"  align="center" bgcolor="" class="bodytext31">&nbsp;</td>
			  </tr>	
      <!-- ///////////////// -->

      <!-- ///////////////// -->
      <!-- ///////////////// -->

	<!-- <tr>

		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><table width="433">

         <tr>

	  <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>LAB TESTS </strong></td> 

     </tr>  

	

				  <?php

      $query33="select * from  ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname " ;
	  $exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33);
	  $num=mysqli_num_rows($exec33);
	  while($res33=mysqli_fetch_array($exec33))
	  { 


		$itemname='';

		//$itemname=$res33['itemname'];

		$labdocnumber=$res33['docnumber'];

		$itemname=$res33['itemname'];

         

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

          <tr <?php echo $colorcode; ?>>

		 

		  <td height="10" width="12%" class="bodytext3" valign="center"  align="center" 

               ><?php echo $itemname; ?></td>

		   <td width="10%" class="bodytext3" valign="center"  align="center" 

               ><a href="iplabresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $labdocnumber; ?>" target="_blank"><strong>View</strong></a></td>

		</tr>

		   <?php

		

		 

		 }

		 ?>

        </table></td>

       	

	    <td colspan="4" align="left" valign="middle" class="bodytext3"><table width="434">

          <tr>

	  <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				 <strong>RADIOLOGY TESTS </strong></td> 

     </tr>

				  <?php

  				  $query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode='$visitcode' order by auto_number desc";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				  while ($res1 = mysqli_fetch_array($exec1))

				  {

				  $visitcode = $res1['visitcode'];

				  $visitdate = $res1['registrationdate'];

				  ?>

                  <tr>

				  <?php 

				  if($searchpatient!= '') { ?> 

                    <td width="264" bgcolor="#ffffff" class="bodytext3"><?php echo $visitcode; ?>&nbsp;</td>

                    <td width="158" bgcolor="#ffffff" class="bodytext3"><?php echo $visitdate; ?>&nbsp;</td>

                  <?php } ?>

				  </tr>

				  <?php

				  $query2 = "select * from ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname ";

				  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

				  while ($res2 = mysqli_fetch_array($exec2))

				  {

				  $labtestname = $res2['itemname'];

				  $labdocnumber = $res2['docnumber'];

				  

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

				  

			<?php }  }?>	  

</table>	

      </table>

  <tr>

    <td>&nbsp;</td>

    <td valign="top">&nbsp;</td>

    <td valign="top">  

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top">&nbsp;</td>

    <td width="97%" valign="top"><table width="433"> -->

    <!--   <tr>

        <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">Nursing cardex </td>

      </tr> -->

	 

    <!--   <?php

      $query34="select * from  ip_progressnotes where visitcode = '$visitcode' order by recorddate desc" ;

	  $exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);

	  $num=mysqli_num_rows($exec34);

	  while($res34=mysqli_fetch_array($exec34))

	  { 

		$notes=$res34['notes'];

		$recorddate=$res34['recorddate'];

		

		

		

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

      <tr <?php echo $colorcode; ?>>

	     <td width="94"  align="center" valign="center"  class="bodytext3" 

               ><?php echo  date("d/m/Y", strtotime($recorddate)); ?></td>

        <td width="327"  align="center" valign="center"  class="bodytext3" 

               ><div align="left"><?php echo $notes; ?></div></td>

	  </tr>

	  

	   <?php

		 } 

		 ?> -->

	  

	<!--   <?php 

	      $query35="select * from  ip_doctornotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;

	  $exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35);

	  $num=mysqli_num_rows($exec35);

	  while($res35=mysqli_fetch_array($exec35))

	  { 

		$ipdoctornotes=$res35['notes'];

		$iprecorddate=$res35['recorddate'];

		

		

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

	     <tr <?php echo $colorcode; ?>>	

         <td class="bodytext3" valign="center"  align="center"><?php echo  date("d/m/Y", strtotime($iprecorddate)); ?>

         <td  class="bodytext3" valign="center"  align="center" 

               ><div align="left"><?php echo $ipdoctornotes; ?></div></td>

      </tr>

      <?php } ?>
 -->
		 

		

    </table>	  

	</table>

<?php include ("includes/footer1.php"); ?>

</body>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");
var span = document.getElementById("drug_close");

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


// services
var services = document.getElementById("serviceModal");
var serviceBtn = document.getElementById("Services");
var span2 = document.getElementById("close_service");
// var span = document.getElementsByClassName("close")[0];
serviceBtn.onclick = function() {
  services.style.display = "block";
}

span2.onclick = function() {
  services.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == services) {
    services.style.display = "none";
  }
}


/// doc notes
var doc = document.getElementById("docModal");
var docBtn = document.getElementById("docotorbtn");
var close_doc = document.getElementById("close_doc");
// var span = document.getElementsByClassName("close")[0];
docBtn.onclick = function() {
  doc.style.display = "block";
}

close_doc.onclick = function() {
  doc.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == doc) {
    doc.style.display = "none";
  }
}



/// theatre notes
var theatre = document.getElementById("theatreModal");
var theatreBtn = document.getElementById("theatrebtn");
var close_theatre = document.getElementById("close_theatre");
// var span = document.getElementsByClassName("close")[0];
theatreBtn.onclick = function() {
  theatre.style.display = "block";
}

close_theatre.onclick = function() {
  theatre.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == theatre) {
    theatre.style.display = "none";
  }
}


// ///ICD
// var icd = document.getElementById("icdModal");
// var icdBtn = document.getElementById("icdbtn");
// var close_icd = document.getElementById("close_icd");
// // var span = document.getElementsByClassName("close")[0];
// icdBtn.onclick = function() {
//   icd.style.display = "block";
// }

// close_icd.onclick = function() {
//   icd.style.display = "none";
// }

// window.onclick = function(event) {
//   if (event.target == icd) {
//     icd.style.display = "none";
//   }
// }

/// LAB
var lab = document.getElementById("labModal");
var labBtn = document.getElementById("labbtn");
var close_lab = document.getElementById("close_lab");
labBtn.onclick = function() {
  lab.style.display = "block";
}

close_lab.onclick = function() {
  lab.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == lab) {
    lab.style.display = "none";
  }
}


// rad
var rad = document.getElementById("radModal");
var radbtn = document.getElementById("radbtn");
var close_rad = document.getElementById("close_rad");
radbtn.onclick = function() {
  rad.style.display = "block";
}

close_rad.onclick = function() {
  rad.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == rad) {
    rad.style.display = "none";
  }
}
// nursingbtn
var nursing = document.getElementById("nursingModal");
var nursingbtn = document.getElementById("nursingbtn");
var close_nursing = document.getElementById("close_nursing");
nursingbtn.onclick = function() {
  nursing.style.display = "block";
}

close_nursing.onclick = function() {
  nursing.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == nursing) {
    nursing.style.display = "none";
  }
}




// nursingbtn
var dischargeModal = document.getElementById("dischargeModal");
var dischargebtn = document.getElementById("dischargebtn");
var close_dischargeModal = document.getElementById("close_discharge");
dischargebtn.onclick = function() {
  dischargeModal.style.display = "block";
}

close_dischargeModal.onclick = function() {
  dischargeModal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == dischargeModal) {
    dischargeModal.style.display = "none";
  }
}
</script>
</html>