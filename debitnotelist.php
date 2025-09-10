<?php

session_start();

ob_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');


$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



$docno = $_SESSION['docno'];

 //get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}

		//location get end here

//This include updatation takes too long to load for hunge items database.

?>

<script>

//This include updatation takes too long to load for hunge items database.

<?php

if (isset($_REQUEST["billno"])) { 

	$billno = $_REQUEST["billno"];

	$visitcode = $_REQUEST["visitcode"];

	$patientcode = $_REQUEST["patientcode"];

	?>

		 window.open('print_debitnote.php?billno=<?php echo $billno;?>&&visitcode=<?php echo $visitcode;?>&&patientcode=<?php echo $patientcode;?>');

		

		<?php

} 

?>

</script>



<?php 



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







if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{

    $itemname=$_REQUEST['itemname'];

	$itemcode=$_REQUEST['itemcode'];

$adjustmentdate=date('Y-m-d');

	foreach($_POST['batch'] as $key => $value)

		{

		$batchnumber=$_POST['batch'][$key];

		$addstock=$_POST['addstock'][$key];

		$minusstock=$_POST['minusstock'][$key];

		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";

	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res40 = mysqli_fetch_array($exec40);

	$itemmrp = $res40['rateperunit'];

	

	$itemsubtotal = $itemmrp * $addstock;

	

		if($addstock != '')

		{

		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 

	transactionparticular, billautonumber, billnumber, quantity, remarks, 

	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)

	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 

	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 

	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}

		else

		{

		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 

	transactionparticular, billautonumber, billnumber, quantity, remarks, 

	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)

	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 

	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 

	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		}

	header("location:stockadjustment.php");

	exit;

	

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit Note List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>



<script language="javascript">





function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here





function cbsuppliername1()

{

	document.cbform1.submit();

}



function funcOnLoadBodyFunctionCall()

{ 

	//alert ("Inside Body On Load Fucntion.");

	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.

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

function validchecking()

{

var customer = document.getElementById("customer").value;

var account = document.getElementById("accountname").value;

if(account =='')

{

if(customer == '')

{

alert("Please Select a Patient");

document.getElementById("customer").focus();

return false;

}

}

}



function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/datetimepicker_css.js"></script>

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#accountname').autocomplete({

		

	

	source:"ajaxaccount.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			$("#accountid").val(accountid);

			

			},

    

	});

		

});



$(document).ready(function(e) {

   

		$('#customer').autocomplete({

		

	

	source:"ajaxdebit.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var patientcode=ui.item.patientcode;

			$("#customercode").val(patientcode);

			

			},

    

	});

		

});



// debit//

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

</style>

</head>







</head>
<body onLoad="return funcOnLoadBodyFunctionCall()">
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
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
        <span>Debit Note List</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="daybookreport.php" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>Day Book Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dailykpi_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Daily KPI Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="daytodayflash.php" class="nav-link">
                            <i class="fas fa-bolt"></i>
                            <span>Day to Day Flash</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="debitnotelist.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Debit Note List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="debtorsreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Debtors Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Debit Note List</h2>
                    <p>Manage and view all debit notes with comprehensive filtering and search capabilities.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="debitnotelist.php" onSubmit="return validchecking()">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Debit Note List </strong></td>

               <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">

                  <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

              </span></td>

              </tr>

           <tr>

				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search </td>

				  <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF">

				  <input name="customer" id="customer" style="border: 1px solid #001E6A;" size="60" autocomplete="off">

				  <input name="customercode" id="customercode" value="" type="hidden">

				<input type="hidden" name="recordstatus" id="recordstatus">

				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>

				

             

              

            </tr>

             <tr style="display:none">

				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account Search </td>

				  <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF">

				 <input type="text" name="accountname" id="accountname" value="" size="60" style="border: 1px solid #001E6A;">

                 <input type="hidden" name="accountid" id="accountid" style="border: 1px solid #001E6A;" size="60" autocomplete="off"/></td>

            </tr>

            <tr>

            <td colspan="1" bgcolor="#FFFFFF">&nbsp;</td>

            <td colspan="3"  align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

            </td>

            </tr>

			    

             </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

	  <form name="form1" id="form1" method="post" action="debitnotelist.php">	

	  <tr>

        <td>

	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchpatient = $_POST['customer'];

	$accountnm=$_REQUEST['accountname'];

	$acctid=$_REQUEST['accountid'];

	

	

		

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 

            align="left" border="0">

          <tbody>

             

            <tr>

              <td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

					 <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Bill No</strong></div></td>

			

					 <td width="20%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>

				 <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>

				  <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Visit Date</strong></div></td>

				 <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Visit Code</strong></div></td>

				

				 <td width="16%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>

			

					 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>

			

              </tr>

           <?php

		  if($accountnm !="")

		  {

			  header("location:debitbill.php?accountid=$acctid");

		  }

		  else

		  {

		  if($searchpatient != '')

		  { 

            $query34 = "select * from master_ipvisitentry where locationcode = '".$locationcode."' AND patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%' or finalbillno like '%$searchpatient%'";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $patientname = $res34['patientfullname'];

		   $patientcode = $res34['patientcode'];

		   $visitcode = $res34['visitcode'];

		   $date = $res34['consultationdate'];

		   $accountname = $res34['accountfullname'];

		    $paymentstatus=$res34['paymentstatus'];

		   

		   $query33 = "select * from billing_ip where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$num33 = mysqli_num_rows($exec33);

	if($num33 != 0)

	{

	$res33 = mysqli_fetch_array($exec33);

	$billno = $res33['billno'];

	}

	else

	{

	$query39 = "select * from billing_ipcreditapproved where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res39= mysqli_fetch_array($exec39);

	$billno = $res39['billno'];

	}

		if($paymentstatus == 'completed')

		{

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

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientname; ?></div></td>

				

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>

						  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><a href="adhocdebitnote.php?billno=<?=$billno;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>

			

			

			

              </tr>

		  <?php

		  }

		  }		   

          

		  }else

		  {

		 $query34 = "select * from master_ipvisitentry where locationcode = '".$locationcode."' AND paymentstatus = 'completed'";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num34 = mysqli_num_rows($exec34);

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $patientname = $res34['patientfullname'];

		   $patientcode = $res34['patientcode'];

		   $visitcode = $res34['visitcode'];

		   $date = $res34['consultationdate'];

		   $accountname = $res34['accountfullname'];

		   

		   $query33 = "select * from billing_ip where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$num33 = mysqli_num_rows($exec33);

	if($num33 != 0)

	{

	$res33 = mysqli_fetch_array($exec33);

	$billno = $res33['billno'];

	}

	else

	{

	$query39= "select * from billing_ipcreditapproved where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res39 = mysqli_fetch_array($exec39);

	$billno = $res39['billno'];

	}

		

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

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientname; ?></div></td>

				

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>

					  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><a href="adhocdebitnote.php?billno=<?=$billno;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>

			

			

			

              </tr>

		  <?php

		 

		  }

		  }

		  

		  if($searchpatient != '')

		  { 

           $query34 = "select * from master_visitentry where locationcode = '".$locationcode."' AND patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $patientname = $res34['patientfullname'];

		   $patientcode = $res34['patientcode'];

		   $visitcode = $res34['visitcode'];

		   $date = $res34['consultationdate'];

		   $accountname = $res34['accountfullname'];

		   $paymentstatus=$res34['paymentstatus'];

		   

		   $query33 = "select * from billing_paylater where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$num33 = mysqli_num_rows($exec33);

	if($num33 != 0)

	{

	$res33 = mysqli_fetch_array($exec33);

	$billno = $res33['billno'];

	}

	else

	{

	$query39 = "select * from billing_paynow where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res39= mysqli_fetch_array($exec39);

	$billno = $res39['billno'];

	}

		if(($paymentstatus == 'completed') && ($num33 != 0))

		{

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

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientname; ?></div></td>

				

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>

						  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><a href="adhocdebitnote.php?billno=<?=$billno;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>

			

			

			

              </tr>

		  <?php

		  }

		  }		   

        

		  }else

		  {

		 $query34 = "select * from master_visitentry where locationcode = '".$locationcode."' AND paymentstatus = 'completed'";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num34 = mysqli_num_rows($exec34);

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $patientname = $res34['patientfullname'];

		   $patientcode = $res34['patientcode'];

		   $visitcode = $res34['visitcode'];

		   $date = $res34['consultationdate'];

		   $accountname = $res34['accountfullname'];

		   

		   $query33 = "select * from billing_paylater where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$num33 = mysqli_num_rows($exec33);

	if($num33 != 0)

	{

	$res33 = mysqli_fetch_array($exec33);

	$billno = $res33['billno'];

	}

	else

	{

	$query39= "select * from billing_paynow where patientcode='$patientcode' and visitcode='$visitcode'";

	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res39 = mysqli_fetch_array($exec39);

	$billno = $res39['billno'];

	}
	if($num33 != 0){

		

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

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientname; ?></div></td>

				

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>

					  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><a href="adhocdebitnote.php?billno=<?=$billno;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>

			

			

			

              </tr>

		  <?php
		} // num>0
		 

		  }

		  }

		  

		  }

           ?>

            <tr>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

            		   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            	   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

      

			</tr>

			

          </tbody>

        </table>

<?php

}





?>	

		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	  </form>

    </table>

  </table>

            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/debitnotelist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



