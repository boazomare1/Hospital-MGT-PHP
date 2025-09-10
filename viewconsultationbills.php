<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



$res2patientname = '';

$searchcustomername = '';

$patientfirstname = '';

$visitcode = '';

$cbvisitcode = '';

$customername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$customername = '';

$paymenttype = '';

$billstatus = '';

$res2loopcount = '';

$custid = '';

$visitcode1='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';



$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');





 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }



//$getcanum = $_GET['canum'];

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if ($getcanum != '')

{

	$query4 = "select customername from master_customer where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbcustomername = $res4['customername'];

	$customername = $res4['customername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$cbcustomername = $_REQUEST['cbcustomername'];

	$patientfirstname = $cbcustomername;

	$cbvisitcode = $_REQUEST['cbvisitcode'];

	$visitcode = $cbvisitcode;

	$visitcode1 = 10;

	

	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

	//$cbbillnumber = $_REQUEST['cbbillnumber'];

	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

	//$cbbillstatus = $_REQUEST['cbbillstatus'];

	

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

	

	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }

	//$paymenttype = $_REQUEST['paymenttype'];

	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }

	//$billstatus = $_REQUEST['billstatus'];

	if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

	if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }				

$suppliername = '';

					if($searchsupplieranum !='')

					{

					$qryact = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number = $searchsupplieranum");

					$resact = mysqli_fetch_assoc($qryact);

					$suppliername = $resact['accountname'];

					}

					if($suppliername == '' && strtoupper($searchsuppliername)=='CASH')

					{

					$suppliername = 'CASH COLLECTIONS';

					}

}

?>

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Consultation Bills - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/viewconsultationbills-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />



</head>

					

//ajax to get location which is selected ends here





function cbcustomername1()

{

	document.cbform1.submit();

}



</script>



<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	//var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}





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

</script>

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#searchsuppliername').autocomplete({

		

	

	source:"ajaxaccount_search.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			var accountanum=ui.item.anum;

			$("#searchsuppliercode").val(accountid);

			$("#searchsupplieranum").val(accountanum);

			

			},

    

	});

		

});

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<script>

function loadprintpage1(billnumber)

 {

 var printbillnumber=billnumber;



var popWin; 

popWin = window.open("print_consultationbill_dmp4inch1.php?billautonumber="+printbillnumber+"","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

 }

</script>



<script src="js/datetimepicker_css.js"></script>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">View Consultation Bills</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Consultations</span>
        <span>→</span>
        <span>View Bills</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">

<table width="1901" border="0" cellspacing="0" cellpadding="2">

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

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1134">

		

		

              <form name="cbform1" method="post" action="viewconsultationbills.php">

		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Bills Report </strong></td>

              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

						if ($location!='')

						{

						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

						

						

                  

                  </td> 

            </tr>

			<tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="" size="50" autocomplete="off">

			  <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="" size="20" />

			   <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" value="" size="50" autocomplete="off">

              </span></td>

           </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient </td>

              <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off"></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5">                               </td>

              </tr>

            <tr>

              <td width="15%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit Code </td>

              <td colspan="3"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input value="" name="cbvisitcode" type="text" id="cbvisitcode"  onKeyDown="return disableEnterKey()" size="50" ></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5">			  </td>

              </tr>

           <tr>

             <td  align="left" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>

             <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>

              <td width="10%"  align="left" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

              <td width="37%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                <input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

			  </span></td>

              <td colspan="3" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

			  <tr>

             <td  align="left" valign="center" 

			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">

                    <?php

						

						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$loccode=array();

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						

						?>

						

                        <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>

						<?php

						} 

						?>

                      </select>

					 

              </span></td>

			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

			 

			 </td>

			 </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

              <td width="3%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

			 

              <td width="14%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_consultationbillsreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $cbcustomername; ?>&&visitcode=<?php echo $cbvisitcode; ?>&&locationcode=<?php echo $locationcode1; ?>&&account=<?php echo $suppliername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>

              

			</tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1800" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="12" bgcolor="#ecf0f5" class="bodytext31">

                <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$cbcustomername = $_REQUEST['cbcustomername'];

					$patientfirstname =  $cbcustomername;

					

					$customername = $_REQUEST['cbcustomername'];

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }				

					if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }				

$suppliername = '';

					if($searchsupplieranum !='')

					{

					$qryact = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number = $searchsupplieranum");

					$resact = mysqli_fetch_assoc($qryact);

					$suppliername = $resact['accountname'];

					}

					if($suppliername == '' && strtoupper($searchsuppliername)=='CASH')

					{

					$suppliername = 'CASH COLLECTIONS';

					}

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

					$locationcode1=$_REQUEST['location'];

				}

				?> 		      </td>

              </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

				<td width="2%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Print</strong></td>

              <td width="12%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient </strong></td>

              <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Reg No. </strong></td>

              <td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Visit Code </strong></td>

				<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>

				<td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Account </strong></td>

              <td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department </strong></div></td>

            	<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Type</strong></div></td>

				<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Fees</strong></div></td>

				<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Copay Amount</strong></div></td>

				<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Copay%</strong></div></td>

				<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Mode</strong></div></td>

				</tr>

			<?php

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			if ( $visitcode1 == 10)

			{

			$query2 = "select patientcode,visitcode,billingdatetime,patientfirstname,patientmiddlename,patientlastname,accountname,department,consultingdoctor,consultationtype,consultationfees,totalamount,copaypercentageamount,transactionmode,billnumber from master_billing where  patientfullname like '%$patientfirstname%' and visitcode like '%$visitcode%'and billingdatetime between '$transactiondatefrom' and '$transactiondateto'  and accountname like '%$suppliername%' and  locationcode='$locationcode1'  order by billnumber desc";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2patientcode = $res2['patientcode'];

			$res2visitcode = $res2['visitcode'];

			$res2billingdatetime = $res2['billingdatetime'];

			$res2patientfirstname = $res2['patientfirstname'];

			$res2patientmiddlename = $res2['patientmiddlename'];

			$res2patientlastname = $res2['patientlastname'];

			$res2accountname = $res2['accountname'];

			$res2department = $res2['department'];

			$res2consultingdoctor = $res2['consultingdoctor'];

			$res2consultationtype = $res2['consultationtype'];

			$res2consultationfees = $res2['consultationfees'];

			$res2copayfixedamount = $res2['totalamount'];

			$res2copaypercentageamount = $res2['copaypercentageamount'];

			$res2patientpaymentmode = $res2['transactionmode'];

			$res2billnumber = $res2['billnumber'];

		    $res2patientname = $res2patientfirstname.' '.$res2patientmiddlename.' '.$res2patientlastname;

			

			$query4 = "select consultationtype from master_consultationtype where auto_number = '$res2consultationtype'";

		    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res4 = mysqli_fetch_array($exec4);

		    $res4consultationtype = $res4['consultationtype'];

			

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

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <a href="javascript:loadprintpage1('<?php echo $res2billnumber; ?>')" class="bodytext3"><span class="bodytext3">Print</span></a></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientname;//echo substr($res2transactiondate, 0, 10); ?></div></td>

				

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2billingdatetime; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2accountname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2department; ?></div></td>

            	<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2consultationtype; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo number_format($res2consultationfees,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2copayfixedamount; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2copaypercentageamount; ?></div></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $res2patientpaymentmode; ?></td>

              </tr>

			<?php

			}

			}

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

                bgcolor="">&nbsp;</td>

				<?php 

				  ?>

              <?php  ?>

              </tr>

          </tbody>

        </table></td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

    </div>

    <!-- Modern JavaScript -->
    <script src="js/viewconsultationbills-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



