<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d');

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$totalamount1 = "0.00";

$balanceamount = "0.00";

$openingbalance = "0.00";

$sumtotalamount = "0.00";

$totalcredit = "0.00";

$totalcredit1 = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

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





if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

	

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

<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>

<script type="text/javascript" src="js/autosuggest4accounts.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

</script>



<script>



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



</script>



<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}



</script>



<script>

function updatebox(varSerialNumber,billamt,totalcount1)

{



var adjamount1;

var grandtotaladjamt2=0;

var varSerialNumber = varSerialNumber;

var totalcount1=totalcount1;

var billamt = billamt;

  var textbox = document.getElementById("adjamount"+varSerialNumber+"");

    textbox.value = "";

if(document.getElementById("acknow"+varSerialNumber+"").checked == true)

{

    if(document.getElementById("acknow"+varSerialNumber+"").checked) {

        textbox.value = billamt;

    }

	var balanceamt=billamt-billamt;

	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);

	var totalbillamt=document.getElementById("paymentamount").value;

	if(totalbillamt == 0.00)

{

totalbillamt=0;

}

				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);

			

		

			//alert(totalbillamt);





document.getElementById("paymentamount").value = totalbillamt.toFixed(2);

document.getElementById("totaladjamt").value=totalbillamt.toFixed(2);

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

document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);

document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);



 }  

}

function checkboxcheck(varSerialNumber5)

{



if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)

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

var totalcount=totalcount;

var grandtotaladjamt=0;



var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;

var adjamount3=parseFloat(adjamount);

if(adjamount3 > billamt1)

{

alert("Please enter correct amount");

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



document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);

document.getElementById("totaladjamt").value=grandtotaladjamt.toFixed(2);



}

function funcAccount1()

{

var accountname = document.getElementById("searchsuppliername").value ;

if(accountname == '')

{

document.getElementById("searchsupplieranum").value='';

document.getElementById("searchsuppliercode").value=''

}

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

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

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

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="2352">

		

		

              <form name="cbform1" method="post" action="ipfinalizedbills1.php">

		<table width="881" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Finalized Bills</strong></td>

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

			<td  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  Search Account

				</td>

              <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

			  <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />

			  <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" style="text-transform:uppercase" value="<?php echo $searchsupplieranum; ?>" size="20" />

				</td>

              </tr>

            

			  <tr>

                      <td width="17%"  align="left" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>

                      <td width="24%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="14%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="45%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                  </tr>

				<tr>

  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" >
            <option value="All">All</option>

          <?php
						

						$query01="select locationcode,locationname from master_location where status ='' order by locationname";

						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
	                    $loccode=array();
						while($res01=mysqli_fetch_array($exc01))

						{?>

							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		

						<?php 

						}

						?>

                      </select></span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

			  </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" onClick="return funcAccount1()" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

}	

?>

       <tr>

        <td>  

          

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

		    if ($cbfrmflag1 == 'cbfrmflag1')

			{



	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];

if($location=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$location'";
}	

	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="2360" 

            align="left" border="0">

          <tbody>

             <tr>

			 <td colspan="27" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>IP Final Bills</strong></td>

			 </tr>

			  <tr>

				    <td width="5" class="bodytext31" valign="center"  align="left" 

					bgcolor="#ffffff"><div align="center"><strong>S.No. </strong></div></td>

  				    <td width="156" class="bodytext31" valign="center"  align="left" 

					bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>

  				    <td width="87" class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="center"><strong>Reg No. </strong></div></td>
  				    <td width="87" class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="center"><strong>Insurance</strong></div></td>

  				    <td width="224"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><strong>Scheme Name</strong></td>

					<td width="74"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Memberno</strong></div></td>

  				    <td width="65"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP&nbsp;No</strong></div></td>

					<td width="64"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>

					<td width="64"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date</strong></div></td>

  				    <td width="58"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adm Fee </strong></div></td>

                    <td width="74"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP&nbsp;Package</strong></div></td>

  				    <td width="63"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bed</strong></div></td>

  				    <td width="61"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Nursing</strong></div></td>

  				    <td width="40"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>RMO</strong></div></td>

  				    <td width="63"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

  				    <td width="60"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rad</strong></div></td>

  				    <td width="59"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharma</strong></div></td>

  				    <td width="62"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>

                    <!--VENU-- REMOVE OT-->

  				  <!--  <td width="23"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">OT</div></td>-->

                    <!--ENDS-->

  				    <td width="73"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>

                    <td width="65"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>

				    <td width="56"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pvt Dr.</strong></div></td>

                    <!--VENU -- REMOVE DEPOSIT-->

				   <!-- <td width="77"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Deposit</div></td>

                    -->

                    <!--VENU -- REMOVE DISCOUNT-->

					<!--<td width="61"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Discount</div></td>-->

                    <!--VENU -- REMOVE IP REFUND-->

                    <!--<td width="86"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">IP&nbsp;Refund</div></td>-->

                    <!--VENU -- RMEOVE NHIF-->

                    <!--<td width="57"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">NHIF</div></td>-->

                    <!--ENDS-->

					<td width="68"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Misc&nbsp;Billing</strong></div></td>

					<td width="59"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Others</strong></div></td>

					<td width="59"  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rebate</strong></div></td>

					<td width="59"  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discounts</strong></div></td>

					<td width="60"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>

					

					<td width="69"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Username</strong></div></td>

					

              </tr>					

        <?php

		$admissionamount=0.00;

		$ipdiscountamount = 0.00;

		$totaladmissionamount = 0.00;

		$totallabamount = 0.00;

		$totalpharmacyamount = 0.00;

		$totalradiologyamount = 0.00;

		$totalservicesamount = 0.00;

		//$totalotamount = 0.00;

		$totalambulanceamount = 0.00;

		$totalprivatedoctoramount = 0.00;

		$totalipbedcharges = 0.00;

		$totalipnursingcharges = 0.00;

		$totaliprmocharges = 0.00;

		$totalipdiscountamount = 0.00;

		$totalipmiscamount = 0.00;

		$totaltransactionamount = 0.00;

		$colorcode = '';

		$transactionamount = 0.00;

		$totalhospitalrevenue = '0.00';

		$totalpackagecharge=0.00;

		$totalhomecareamount=0.00;

		$totalotamount=0.00;

		$totaliprefundamount=0.00;

		$totalnhifamount =0.00;

		$iprebateamount = 0.00;

		$rebateamount = 0.00;

		$totaliprebateamount = 0.00;

		

		//VARIABLES FOR -- CREDITNOTE--

		

		

		$bedchgsdiscount=0;

		$labchgsdiscount=0;

		$nursechgsdiscount=0;

		$pharmachgsdiscount=0;

		$radchgsdiscount = 0;

		$rmochgsdiscount = 0;

		$servchgsdiscount = 0;

		

		$totbedchgdisc=0;

		$totlabchgdisc=0;

		$totnursechgdisc=0;

		$totpharmachgdisc=0;

		$totradchgdisc=0;

		$totrmochgdisc=0;

		$totservchgdisc=0;

		

		$brfbedchgsdiscount = 0;

		$brflabchgsdiscount = 0;

		$brfnursechgsdiscount = 0;

		$brfpharmachgsdiscount=0;

		$brfradchgsdiscount=0;

		$brfrmochgsdiscount = 0;

		$brfservchgsdiscount  = 0;

		

		$totbrfbeddisc=0;

		$totbrflabdisc=0;

		$totbrfnursedisc=0;

		$totbrfpharmadisc=0;

		$totbrfraddisc=0;

		$totbrfrmodisc=0;

		$totbrfservdisc=0;

		

		$totcreditnotebedchgs = 0;

		$totcreditnotelabchgs = 0; 

		$totcreditnotenursechgs = 0;

		$totcreditnotepharmachgs = 0; 

		$totcreditnoteradchgs = 0;

		$totcreditnotermochgs = 0;

		$totcreditnoteservchgs = 0;

		$totalbrfotherdisc = 0;

		

		$rowtotfinal = 0;

		

		if($searchsuppliercode == '')

		{

		$searchsuppliercode = '%%';

		}

		

		//QUERY TO GET PATIENT DETAILS TO PASS

	   $query1 = "select  patientname,patientcode,visitcode,billno,billdate from billing_ip where patientbilltype <> '' and $pass_location and billdate between '$fromdate' and '$todate' and accountcode like '$searchsuppliercode' and $pass_location group by visitcode  order by auto_number DESC ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$visitcode=$res1['visitcode'];

		$billno =$res1['billno'];

$billdate =$res1['billdate'];

	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  

		 // $query112 = "select sum(amountuhx) as bedamount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Nursing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";

		 $query112 = "select sum(amountuhx) as bedamount from billing_ipbedcharges where $pass_location and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' and $pass_location

				  UNION ALL SELECT sum(fxamount) as bedamount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode' and $pass_location";


		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num112=mysqli_num_rows($exec112);
		$res112 = mysqli_fetch_array($exec112);
		 $packagecharge=$res112['bedamount'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select amountuhx,fxrate from billing_ipadmissioncharge where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' and $pass_location ";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);				
		$amount=$res2['amountuhx'];
		$fxrate=$res2['fxrate'];
		$admissionamount=$amount*$fxrate;
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		  $query3 = "select sum(labitemrate) as labitemrate from billing_iplab where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate' and $pass_location ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
	    $res3 = mysqli_fetch_array($exec3);
		$labamount=$res3['labitemrate'];
		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate' and $pass_location ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$radiologyamount=$res4['radiologyitemrate'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amount) as amount from billing_ippharmacy where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate' and $pass_location ";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['amount'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate, sum(sharingamount) from billing_ipservices where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate' and wellnessitem <> 1 and $pass_location";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['servicesitemrate']-$res6['sum(sharingamount)'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) as amount from billing_ipambulance where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  and $pass_location";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['amount'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) as amount from billing_iphomecare where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  and $pass_location";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['amount'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		// $query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		// $num8=mysql_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);

		// $privatedoctoramount=$res8['amount'];

		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		 $privatedoctoramount=0;
		$query8              = "select (transactionamount) as transactionamount, (original_amt-sharingamount) as original_amt, visittype, coa from billing_ipprivatedoctor  where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                		if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount += $res8['transactionamount'];
								else
								 $privatedoctoramount += $res8['transactionamount'];
								 //$privatedoctoramount += $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount += $res8['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			               
            		}
            		 $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

		

		 //TO GET TOTAL BED CHARGES AMOUNT

		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Nursing Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT

		// $query11 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";

		$query11 = "select sum(amount) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and (description = 'Daily Review charge' or description = 'RMO Charges' or description ='Consultant Fee') and recorddate between '$fromdate' and '$todate' ";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		/*$query13 = "select sum(rate) from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		$num13=mysql_num_rows($exec13);

		$res13 = mysql_fetch_array($exec13);

		$ipdiscountamount=$res13['sum(rate)'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		/*$query133 = "select sum(amount) from deposit_refund where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());

		$num133=mysql_num_rows($exec133);

		$res133 = mysql_fetch_array($exec133);

		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) as amount from billing_ipmiscbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['amount'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;



		$query13 = "select sum(-1*ip_discount.rate) as amount from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num13=mysqli_num_rows($exec13);

		$res13 = mysqli_fetch_array($exec13);

		$ipdiscountamount=$res13['amount'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;





		//TO GET TOTAL IP REBATE BILL AMOUNT

		$query15 = "select sum(amount) as amount from billing_ipnhif where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		$res15 = mysqli_fetch_array($exec15);

		$iprebateamount=$res15['amount'];

		$totaliprebateamount = $totaliprebateamount + $iprebateamount;

		

		

		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		 $query15 = "select memberno,accountfullname,subtype from master_ipvisitentry where  patientcode = '$patientcode' and visitcode='$visitcode' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

			$memberno=$res15['memberno'];

			$accountname=$res15['accountfullname'];
			$subtype=$res15['subtype'];

			$query_subname = "select subtype from master_subtype where  auto_number = '$subtype' ";
			$exec_subname = mysqli_query($GLOBALS["___mysqli_ston"], $query_subname) or die ("Error in Query_subname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_subname=mysqli_num_rows($exec_subname);
			$res_subname = mysqli_fetch_array($exec_subname);
			$subtype_name=$res_subname['subtype'];

		

		

		//TO GET THE USERNAME OF THE FINILAZING AUTHORIY

		$query25 = "select username from master_transactionip where  patientcode = '$patientcode' and visitcode='$visitcode'";

		$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num25=mysqli_num_rows($exec25);

		

		$res25 = mysqli_fetch_array($exec25);

		$billuser=$res25['username'];

		

		

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $transactionamount=$res12['transactionamount'];

			 $referencenumber=$res12['docno'];

			 $totaltransactionamount=$totaltransactionamount + $transactionamount;

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

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center">

			    <div align="center"><?php echo $patientname; ?></div>

			  </div></td>

			  <td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $patientcode; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $subtype_name; ?></div></td>

			  <td  align="left" valign="center" class="bodytext31"><?php echo $accountname; ?></td>

				 <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo $memberno; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $visitcode; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billno; ?></div></td>	


					<td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billdate; ?></div></td>	

            

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packagecharge,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>

                    <!--VENU -- REMOVE OT-->

				    <!--<td class="bodytext31" valign="center"  align="left">

			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->

                    <!--ENDS-->  

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>

                     

                     <!--VENU -- REMOVE DISCOUNT-->

				   <!-- <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->

				     <!--VENU -- REMOVE DISCOUNT-->

                     <!-- <td class="bodytext31" valign="center"  align="left">

                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->

                      <!--VENU REMOVE IPREFUND-->

                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->

                       <!--VENU REMOVE NHIF-->

                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->

                      <!--ENDS-->  

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($iprebateamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipdiscountamount,2,'.',','); ?></div></td>

				  <?php

				  $rowtot1 = 0;

				  $rowtot1 = $admissionamount+0+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+

				  			 $homecareamount+$privatedoctoramount+$ipmiscamount+0+$ipdiscountamount;

				  $rowtotfinal = $rowtotfinal + $rowtot1;			 

				  ?>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot1,2,'.',','); ?></strong></div></td>

				 

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo $billuser; ?></strong></div></td>

                  </tr>

                  

                

				  

                  <!--ENDS-->

                  

                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->

                  <?php

				  /*if($briefcreditpatientcount>0)

				  {

					*/ 

				?>

             

                 <?php   	

				 // }//ends if($briefcreditpatientcount>0)

				  ?>

                  <!--ENDS BRIEF DISCOUNT SHOW-->

		   <?php 

		    

		     }

			 

			$query186 = "select  patientname,patientcode,visitcode,billno,billdate from billing_ipcreditapproved where $pass_location and billdate between '$fromdate' and '$todate' and accountnameid like '$searchsuppliercode' group by visitcode order by auto_number DESC ";

		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num186=mysqli_num_rows($exec186);

		

		while($res186 = mysqli_fetch_array($exec186))

		{ 

			 

		$patientname=$res186['patientname'];

		$patientcode=$res186['patientcode'];

		$visitcode=$res186['visitcode'];

		$billno=$res186['billno'];
	
		$billdate=$res186['billdate'];

	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  

		 $query112 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

				  UNION ALL SELECT sum(fxamount) as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";


		 // $query112 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Nursing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";

		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['amount'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge; 



		//TO GET TOTAL ADMIN FEE

	     $query2 = "select amountuhx from billing_ipadmissioncharge where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		 

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2=mysqli_num_rows($exec2);

		$res2 = mysqli_fetch_array($exec2);				

		$admissionamount=$res2['amountuhx'];

	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		  $query3 = "select sum(labitemrate) as labitemrate from billing_iplab where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num3=mysqli_num_rows($exec3);

	    $res3 = mysqli_fetch_array($exec3);

		$labamount=$res3['labitemrate'];

		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num4=mysqli_num_rows($exec4);

		$res4 = mysqli_fetch_array($exec4);

		$radiologyamount=$res4['radiologyitemrate'];

	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amount) as amount from billing_ippharmacy where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['amount'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate, sum(sharingamount) from billing_ipservices where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['servicesitemrate']-$res6['sum(sharingamount)'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) as amount from billing_ipambulance where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['amount'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) as amount from billing_iphomecare where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['amount'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		// $query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		// $num8=mysql_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);

		// $privatedoctoramount=$res8['amount'];

		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		 $privatedoctoramount=0;
		$query8              = "select (transactionamount) as transactionamount, (original_amt-sharingamount) as original_amt, visittype, coa from billing_ipprivatedoctor  where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                		if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount += $res8['transactionamount'];
								else
								 $privatedoctoramount += $res8['transactionamount'];
								 //$privatedoctoramount += $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount += $res8['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			               
            		}

            		 $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

		

		 //TO GET TOTAL BED CHARGES AMOUNT

		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Nursing Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT

		$query11 = "select sum(amount) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and (description = 'Daily Review charge' or description = 'RMO Charges' or description ='Consultant Fee') and recorddate between '$fromdate' and '$todate' ";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		/*$query133 = "select sum(amount) from deposit_refund where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());

		$num133=mysql_num_rows($exec133);

		$res133 = mysql_fetch_array($exec133);

		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) as amount from billing_ipmiscbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['amount'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;



		$query13 = "select sum(-1*ip_discount.rate) as amount from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num13=mysqli_num_rows($exec13);

		$res13 = mysqli_fetch_array($exec13);

		$ipdiscountamount=$res13['amount'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;



		//TO GET TOTAL IP REBATE BILL AMOUNT

		$query15 = "select sum(1*amount) as amount from billing_ipnhif where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		$res15 = mysqli_fetch_array($exec15);

		$rebateamount=$res15['amount'];

		$totaliprebateamount = $totaliprebateamount + $rebateamount;

		

		

		//TO GET PATIEN MEMBER NUMBER

		 $query15 = "select memberno,accountfullname,subtype  from master_ipvisitentry where  patientcode = '$patientcode' and visitcode='$visitcode'";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

		$memberno=$res15['memberno'];
		$accountname=$res15['accountfullname'];

		$subtype=$res15['subtype'];

			$query_subname = "select subtype from master_subtype where  auto_number = '$subtype' ";
			$exec_subname = mysqli_query($GLOBALS["___mysqli_ston"], $query_subname) or die ("Error in Query_subname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_subname=mysqli_num_rows($exec_subname);
			$res_subname = mysqli_fetch_array($exec_subname);
			$subtype_name=$res_subname['subtype'];

		

		//TO GET THE USERNAME OF THE FINILAZING AUTHORIY

		 $query25 = "select username from ip_creditapproval where  patientcode = '$patientcode' and visitcode='$visitcode'";

		$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num25=mysqli_num_rows($exec25);

		

		$res25 = mysqli_fetch_array($exec25);

		$billuser=$res25['username'];

				

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $transactionamount=$res12['transactionamount'];

			 $referencenumber=$res12['docno'];

			 $totaltransactionamount=$totaltransactionamount + $transactionamount;

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

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center">

			    <div align="center"><?php echo $patientname; ?></div>

			  </div></td>

			  <td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $patientcode; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $subtype_name; ?></div></td>

			  <td  align="left" valign="center" class="bodytext31"><?php echo $accountname; ?></td>

				<td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo $memberno; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $visitcode; ?></div></td>	

            <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billno; ?></div></td>


			<td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billdate; ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packagecharge,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>

                    <!--VENU -- REMOVE OT-->

				    <!--<td class="bodytext31" valign="center"  align="left">

			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->

                    <!--ENDS-->  

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>

                     

                     <!--VENU -- REMOVE DISCOUNT-->

				   <!-- <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->

				     <!--VENU -- REMOVE DISCOUNT-->

                     <!-- <td class="bodytext31" valign="center"  align="left">

                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->

                      <!--VENU REMOVE IPREFUND-->

                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->

                       <!--VENU REMOVE NHIF-->

                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->

                      <!--ENDS-->  

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($rebateamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipdiscountamount,2,'.',','); ?></div></td>

				  <?php

				  $rowtot2 = 0;

				  $rowtot2 = $admissionamount+0+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+

				  			 $homecareamount+$privatedoctoramount+$ipmiscamount+$rebateamount+$ipdiscountamount;

							 

				  $rowtotfinal = $rowtotfinal + $rowtot2;			 

				  ?>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot2,2,'.',','); ?></strong></div></td>

                 

				 <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo $billuser; ?></strong></div></td>

				  </tr>

                  

                

				  

                  <!--ENDS-->

                  

                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->

                  <?php

				  /*if($briefcreditpatientcount>0)

				  {

					*/ 

				?>

             

                 <?php   	

				 // }//ends if($briefcreditpatientcount>0)

				  ?>

                  <!--ENDS BRIEF DISCOUNT SHOW-->

		   <?php 

		    

		     }

		   ?>

  <!--<tr>

<td>patient details from $query1</td>

</tr>-->



          <!--ENDS-->

           

            <tr>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right">

				

				<?php 

				

				

				//VENU--CHANGE GRAND TOTAL ACC TO REMOVED FIELDS

				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount

				+ $totalpharmacyamount + $totalservicesamount + $totalotamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount - $totaliprefundamount - $totalipdiscountamount - $totalnhifamount -$totaltransactionamount; */

				

				//VENU --CALCULATIONS FOR TOTALDISC-CREITNOTE

				$totbedchgs = $totalipbedcharges - $totbrfbeddisc;

				$totnursechgs = $totalipnursingcharges - $totbrfnursedisc;

				$totrmochgs =  $totaliprmocharges - $totbrfrmodisc;

				$totlabchgs = $totallabamount - $totbrflabdisc;

				$totradchgs = $totalradiologyamount - $totbrfraddisc;

				$totpharmchgs = $totalpharmacyamount - $totbrfpharmadisc;

				$totservchgs = $totalservicesamount - $totbrfservdisc;

				$totalbrfotherdisc = 0 - $totalbrfotherdisc;

				

				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount

				+ $totalpharmacyamount + $totalservicesamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount ; */

				

				//--VENU -- GRAND TOTAL ACC TO CREDIT NOTE CHANGES

				$grandtotal = $totaladmissionamount + $totbedchgs + $totnursechgs + $totrmochgs + $totlabchgs + $totradchgs

				+ $totpharmchgs + $totservchgs + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + 0 + $totalhomecareamount + $totalbrfotherdisc;

				

				?>

				

                  <strong>Grand Total:</strong> </div></td>

                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5" colspan="3">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totaladmissionamount,2,'.',','); ?></strong></td>

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalpackagecharge,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totbedchgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totnursechgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totrmochgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totlabchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totradchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totpharmchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totservchgs,2,'.',','); ?></strong></td>

                <!--VENU -- REMOVE total ot amount -->

              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php //echo number_format($totalotamount,2,'.',','); ?></strong></td>-->

                <!--ends-->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalhomecareamount,2,'.',','); ?></strong></td> 

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></strong></td>

                

                <!--VENU --  REMOVE DISCOUNT-->

              <!--<td align="right" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="style2">-<?php //echo number_format($totaltransactionamount,2,'.',','); ?></td>-->

                

              <!--VENU -- REMOVE DEPOSIT-->  

              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong>-<?php //echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>-->

                <!--VENU -- REMOVE IP REFUND-->

                <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong>-<?php //echo number_format($totaliprefundamount,2,'.',','); ?></strong></td>-->

                <!--VENU-- REMOVE NHIF-->

                  <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong>-<?php // echo number_format($totalnhifamount,2,'.',','); ?></strong></td>-->

                <!--ENDS-->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalipmiscamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalbrfotherdisc,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totaliprebateamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($rowtotfinal,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong></strong></td>

         		<td width="1" align="right" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="bodytext311"><strong></strong></td>

				<?php if($rowtotfinal != 0.00) 

			      {

				  ?>

              <td width="53" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_ipfinalizedbill.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $searchsuppliercode; ?>&&loc=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

            <?php } ?>

               </tr>

               

            </tbody>

        </table>

<?php

}

		   ?>

		    

			<?php $grandtotal = $sumtotalamount + $totalcredit;  ?>

     </td>

      </tr>

	  

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

