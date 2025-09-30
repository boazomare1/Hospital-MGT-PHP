<?php

error_reporting(0);
session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



//This include updatation takes too long to load for hunge items database.





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



if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["assetanum"])) { $assetanum = $_REQUEST["assetanum"]; } else { $assetanum = ""; }

if($st == 'error')

{

	$errmsg = "Asset ID already exists";

}

if($st == 'success')

{

?>



<?php

}

?>

<style type="text/css">

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

<?php include ("js/dropdownlistipbilling.php"); ?>

<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>

<script>	

<?php 

if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }

if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }

?>

	var ipbillnumberr;

	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";

	var ippatientcoder;

	var ippatientcoder = "<?php echo $ippatientcodes; ?>";

	//alert(refundbillnumber);

	if(ipbillnumberr != "") 

	{

		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

	}				

</script>

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

	funcPopupOnLoad1();

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





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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



<script>

function funcPopupOnLoad1()

{

<?php  

if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }

if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }

?>

var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";

var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";

var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";

//alert(billnumbers);

	if(patientcodes != "") 

	{

		window.open("print_ipfinalinvoice1.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

	}

}

</script>

 

<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall()">

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

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="assetregister.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Assets List </strong></td>

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

          				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>

				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">

                  <select name="location" id="location"  onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">

                  <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						?>

						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>

						<?php

						}

						?>

                  </select>

                  </td>

				  </tr>



           <tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Asset Search </td>

				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="searchitem" id="searchitem" value="<?php echo $searchitem; ?>" size="60" autocomplete="off">

				  <input name="customercode" id="customercode" value="" type="hidden">

				<input type="hidden" name="recordstatus" id="recordstatus">

				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
				</tr>
				 <!-- ///////////////////  -->
				  <?php 
				   if (isset($_REQUEST["search_month"])) { $searchmonth = $_REQUEST["search_month"]; } else { $searchmonth = ""; }
				   if (isset($_REQUEST["search_year"])) { $year_p = $_REQUEST["search_year"]; } else { $year_p = ""; }

				   if($searchmonth==''){
						   $year_p=date('Y');
						   $month_p=date('m');
						   $searchmonth=$month_p;
						}

				 	$year_present=date('Y');
				   	$year_past=$year_p-5;
				   	$year_fut=$year_present+5;
				   	$years = range($year_past, strftime($year_fut, time())); 

				   ?>
				 <tr>
				
					<td width="131" class="bodytext31" valign="center"  align="left">As on </td>
                      <td width="136" align="left" valign="center"  class="bodytext31">
                        <select name="search_month">
                          <option <?php if($searchmonth == '01') { ?> selected = 'selected' <?php } ?> value="01">January</option>
                          <option <?php if($searchmonth == '02') { ?> selected = 'selected' <?php } ?> value="02">February</option>
                          <option <?php if($searchmonth == '03') { ?> selected = 'selected' <?php } ?> value="03">March</option>
                          <option <?php if($searchmonth == '04') { ?> selected = 'selected' <?php } ?> value="04">April</option>
                          <option <?php if($searchmonth == '05') { ?> selected = 'selected' <?php } ?> value="05">May</option>
                          <option <?php if($searchmonth == '06') { ?> selected = 'selected' <?php } ?> value="06">June</option>
                          <option <?php if($searchmonth == '07') { ?> selected = 'selected' <?php } ?> value="07">July</option>
                          <option <?php if($searchmonth == '08') { ?> selected = 'selected' <?php } ?> value="08">August</option>
                          <option <?php if($searchmonth == '09') { ?> selected = 'selected' <?php } ?> value="09">September</option>
                          <option <?php if($searchmonth == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                          <option <?php if($searchmonth == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                          <option <?php if($searchmonth == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                        </select>

					 <select name="search_year">
                          <option value="">Select Year</option>
                          <?php foreach($years as $year1) : ?>
                              <option <?php if($year_p == $year1){ ?> selected = 'selected' <?php } ?> value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>				
					</td>
				  </tr>
				  <!-- ///////////////////  -->

				

             <tr>
             	<td colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5"> </td>
              <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input   type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>

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

      

	  <form name="form11" id="form11" method="post" action="">	

	  <tr>

        <td>

	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

$searchpatient = '';	


$search_month = $_REQUEST['search_month'];
$search_year = $_REQUEST['search_year'];

$date_range_first=$search_year.'-'.$search_month.'-01';

$d = new DateTime($date_range_first); 
$date_range=$d->format( 'Y-m-t' );	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 

            align="left" border="0">

          <tbody>

             
  <tr>

              <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

			
                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
                 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Department </strong></div></td>

              <td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Asset ID</strong></div></td>

				    <td width="15%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Asset Name</strong></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Acquisition Date</strong></div></td>

                	 <td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Life</strong></div></td>

                <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Yearly Dep. % </strong></div></td>

                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dep. Start</strong></div></td>

				 <td width="9%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Purchase Cost </strong></div></td>

				<td width="9%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Salvage</strong></div></td>

                  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acc. Depreciation  </strong></div></td>
                <td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Net Book Value </strong></div></td>
				
			 <td width="5%"  align="center" valign="right" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

			 </tr>

           <?php

		 	$sno = 0;
		   $depration_done_date = date('Y-m-d');
           $query34 = "select * from assets_register where itemname like '%$searchitem%' and entrydate<='$date_range'";
           //echo $query34;

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $number = mysqli_num_rows($exec34);
		   while($res34 = mysqli_fetch_array($exec34))

		   {

		  // $sno = $sno + 1;

		   $itemname = $res34['itemname'];

		   $itemcode = $res34['itemcode'];

		   $totalamount = $res34['totalamount'];

		   $entrydate = $res34['entrydate'];

		   $suppliercode = $res34['suppliercode'];

		   $suppliername = $res34['suppliername'];

		   $anum = $res34['auto_number'];

		   $asset_id = $res34['asset_id'];

			$asset_category = $res34['asset_category'];

			$asset_class = $res34['asset_class'];

			$asset_department = $res34['asset_department'];

			$asset_unit = $res34['asset_unit'];

			$asset_period = $res34['asset_period'];

			$startyear = $res34['startyear'];

			$accdepreciationvalue = $res34['accdepreciation'];

			$dep_percent = $res34['dep_percent'];

			$depreciationledgercode = $res34['depreciationledgercode'];

			$salvage = $res34['salvage'];

			$depreciationyearly = (($totalamount - $salvage)/ $asset_period);

			$depreciationmonth = ($depreciationyearly / 12);

			//$depreciation = $totalamount * ($dep_percent / 100);

			//$accdepreciation = $depreciation * $asset_period;

			//$depreciationmonth = $depreciation / 12;

			$depreciationmonth = number_format($depreciationmonth,2);

			 // $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and entrydate<='$depration_done_date'";
			 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and entrydate<='$date_range'";
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];
						
			$netbookvalue = $totalamount - $accdepreciation;

			$dep_yearly_per = (1/$asset_period) * 100;

			
			
			
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
			// Check if the asset is disposed
			$qry_disposed = "select auto_number from assets_disposal where asset_id ='$asset_id'";
			$execdisp = mysqli_query($GLOBALS["___mysqli_ston"], $qry_disposed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		    $disposed_num = mysqli_num_rows($execdisp);
		   if($disposed_num == 0){

		   	 $sno = $sno + 1;
			?>

			

          <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			 
			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_class; ?></div></td>

			    	<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_department; ?></div></td>


              <td class="bodytext31" valign="center"  align="left"><div align="center">

			  <input type="hidden" name="assetanum<?php echo $sno; ?>" id="assetanum<?php echo $sno; ?>" value="<?php echo $anum; ?>">

			  <input type="hidden" name="assetid<?php echo $sno; ?>" id="assetid<?php echo $sno; ?>" value="<?php echo $asset_id; ?>">

			  <?php echo $asset_id; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $itemname; ?></div></td>

			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $entrydate; ?></div></td>

			       <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_period; ?></div></td>

			     <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo number_format($dep_yearly_per,2); ?></div></td>

			     <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $startyear; ?></div></td>

				  <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($totalamount,2); ?></div></td>

					 

				  <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($salvage,2); ?></div></td>

					 
				

			

			    <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($accdepreciation,2); ?></div></td>

			     <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($netbookvalue,2); ?></div></td>

			    

			   


				
				<td class="bodytext31" valign="center"  align="left">

			    <select name="invoice" id="invoice" onChange="window.open(this.options[this.selectedIndex].value,'_blank')">

				<option value="">Select</option>

                <?php if($asset_id == ''){ ?>

				<option value="asset_recording.php?assetanum=<?php echo $anum; ?>">Recording</option>

                <?php } else { ?>

                <option value="asset_recording_1.php?assetanum=<?php echo $anum; ?>">Recording</option>

                <?php } ?>

				<option value="asset_transfer.php?assetanum=<?php echo $anum; ?>">Transfer</option>

				<option value="asset_disposal.php?assetanum=<?php echo $anum; ?>">Disposal</option>

				<option value="asset_impairment.php?assetanum=<?php echo $anum; ?>">Impairment</option>

				<option value="asset_revaluation.php?assetanum=<?php echo $anum; ?>">Revaluation</option>

				</select>

				</td>
					
				</tr>

		  <?php
		  	 }
		  }

           ?>

            <tr>

              <td colspan="14" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

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

<?php include ("includes/footer1.php"); ?>

</body>

</html>



