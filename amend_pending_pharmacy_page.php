<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');


$docno = $_SESSION['docno'];
						

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
}


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }

if (isset($_REQUEST["patientname1"])) { $patientname1 = $_REQUEST["patientname1"]; } else { $patientname1 = ''; }

if (isset($_REQUEST["patientcode1"])) { $patientcode1 = $_REQUEST["patientcode1"]; } else { $patientcode1 = ''; }

if (isset($_REQUEST["visitcode1"])) { $visitcode1 = $_REQUEST["visitcode1"]; } else { $visitcode1 = ''; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ''; }



 $selectpending=isset($_REQUEST['selectpending'])?$_REQUEST['selectpending']:'1';

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

<script language="javascript">



function cbcustomername1()

{

	document.cbform1.submit();

}



</script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

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

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.number

{

padding-left:650px;

text-align:right;

font-weight:bold;



}

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<?php $querynw1 = "select * from master_consultationpharm where medicineissue='pending' and billing = '' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resnw1=mysqli_num_rows($execnw1);

?>

<table width="103%" border="0" cellspacing="0" cellpadding="2">

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

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		  <form name="cbform1" method="post" action="amend_pending_pharmacy_page.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Amend Pending Pharmacy</strong></td>

			</tr>
			<tr>
				 <td align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>Store</strong> </td>
				<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			    <select name="store" id="store" >

				<?php if($storecode != '') { ?>

				<option value="<?php echo $storecode; ?>"><?php echo $store; ?></option>

				<?php } ?>

				<?php 

				$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode' and defaultstore='default'";

				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res9 = mysqli_fetch_array($exec9))

				{

				$res9anum = $res9['storecode'];

				$res9default = $res9['defaultstore'];

				

				$query10 = "select * from master_store where auto_number = '$res9anum'";

				$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res10 = mysqli_fetch_array($exec10);

				$res10storecode = $res10['storecode'];
				$store = $res10['storecode'];

				$res10store = $res10['store'];

				$res10anum = $res10['auto_number'];

				?>

				<option value="<?php echo $res10storecode; ?>" selected><?php echo $res10store; ?></option>

				<?php } ?>

				</select>
			  </td>
			</tr>

			 <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patientname1" type="text" id="patientname1" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patientcode1" type="text" id="patientcode1" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="visitcode1" type="text" id="visitcode1" value="" size="50" autocomplete="off">

              </span></td>

              </tr>  

              

              <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <select name="selectpending" id="selectpending">

                <option value="1">Pending</option>

                <option value="3">Partially Approved</option>

				<option value="2">Fully Approved</option>

				</select>

              </span></td>

              </tr>  

              

              

			  <tr>

                      <td width="13%"  align="left" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31">Date From </td>

                      <td width="38%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

					  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="11%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Date To </td>

                      <td width="38%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                  </tr>

					

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

	   </tr>

      

	   <tr>

	     <td>	

		   <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

          <!--  <tr>

              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31">

			  <div align="left"><strong>Amend Pharmacy</strong><label class="number"><<<?php echo $resnw1;?>>></label></div>			  </td>

            </tr>-->

			

			 <tr>

              <td width="2%"  class="bodytext31">&nbsp;</td>

              <td colspan="15"  class="bodytext31">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

			  	}

				?>			   </td>  

            </tr>

			

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				<td width="16%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>OP Date </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>

              <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>

              <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Department </strong></div></td>

				<td width="25%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>

               <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>

             <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Print</strong></td>

              </tr>

			<?php

			$colorloopcount = '';

			$sno = '';

			//echo $selectpending;

			$query1 = "SELECT * from master_consultationpharm where medicineissue='pending' and patientcode like '%$patientcode1%' and store='$store' and patientvisitcode like '%$visitcode1%' and patientname like '%$patientname1%' and recorddate between '$ADate1' and '$ADate2' and  billing = '' ";



			if($selectpending=='3')
			{
			$query1 .= " and amendstatus='3' ";
			}
			else if($selectpending=='1')
			{
			$query1 .= " and amendstatus='1' ";
			}

			else if($selectpending=='2')
			{
			$query1 .= " and amendstatus='2' ";
			}

			$query1 .= " group by patientvisitcode order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $query1;
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
		  	$consultationdate=$res1['recorddate'];
			$medicinecode = $res1['medicinecode'];			

			$query281 = "select sum(quantity) as qty from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode = '$medicinecode'";

			$exec281 = mysqli_query($GLOBALS["___mysqli_ston"], $query281) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res281 = mysqli_fetch_array($exec281);

			$pres_qty = $res281['qty'];


			$query21 = "select * from master_visitentry where visitcode='$visitcode'";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res21 = mysqli_fetch_array($exec21);

			$patientaccountname=$res21['accountfullname'];

			$patientname = $res21['patientfullname'];

			$billtype = $res21['billtype'];

			$planpercentage=$res21['planpercentage'];

			$planname = $res21['planname'];

			$departmentname = $res21['departmentname'];

	

			$query222 = "select forall from master_planname where auto_number = '$planname'";

		    $exec222=mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222=mysqli_fetch_array($exec222);

			$forall=$res222['forall'];

			

			if($billtype == 'PAY NOW')

			{

				$phartable = "billing_paynowpharmacy";

			}

			else

			{

				if(($planpercentage > 0.00 && $forall != ''))

				{

					$phartable = "billing_paynowpharmacy";

				}

				else

				{

					$phartable = "billing_paylaterpharmacy";

				}

			}

			

			$query28 = "select sum(quantity) as qty from $phartable where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode = '$medicinecode'";

			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res28 = mysqli_fetch_array($exec28);

			$issue_qty = $res28['qty'];

			$bal_qty = $pres_qty - $issue_qty;

			if($bal_qty > 0)

			{

			

			$query2 = "select * from master_visitentry where visitcode='$visitcode' and overallpayment=''";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num2 = mysqli_num_rows($exec2);

	        if($num2==0 && $billtype == 'PAY LATER')
	        {
	          continue;  
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

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>

			

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $departmentname; ?></div></td>

               <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $patientaccountname; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="left"><a href="amendpharmacy_page.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&selectpending=<?php echo $selectpending; ?>&&menuid=<?php echo $menu_id; ?>
"><strong>Amend</strong></a>			  </td>

                

              <td class="bodytext31" valign="center"  align="left"><a href="print_amendpharmacy_page.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode ?>&&menuid=<?php echo $menu_id; ?>" target="new" ><strong>Print</strong></a>			  </td>

              </tr>

			<?php

			  }

			  }    

			

			?>

          </tbody>

        </table></td>

      </tr>

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



