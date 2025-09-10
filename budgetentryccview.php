<?php
 
session_start();

error_reporting(0);

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetitme = date ("d-m-Y H:i:s");

$dateonly=date("Y-m-d");

$suppdateonly = date("Y-m-d");

$username = $_SESSION['username'];

$ipaddress = $_SERVER['REMOTE_ADDR'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$pagename = 'PURCHASE BILL ENTRY';



$titlestr = 'PURCHASE BILL';

$docno = $_SESSION['docno'];



$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

$reslocationname = $res["locationname"];

$res12locationanum = $res["auto_number"];



$query3 = "select * from master_location where locationname='$reslocationname'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$reslocationcode = $res3['locationcode'];



//include ("login1purchasedataredirect1.php");



//to redirect if there is no entry in masters category or item or customer or settings

$query91 = "select count(auto_number) as masterscount from settings_purchase where companyanum = '$companyanum'";

$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

$res91 = mysqli_fetch_array($exec91);

$res91count = $res91["masterscount"];

if ($res91count == 0)

{

	header ("location:settingspurchase1.php?svccount=firstentry");

	exit;

}





//To verify the edition and manage the count of bills.

$thismonth = date('Y-m-');

$query77 = "select * from master_edition where status = 'ACTIVE'";

$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

$res77 = mysqli_fetch_array($exec77);

$res77allowed = $res77['allowed'];





$query88 = "select count(auto_number) as cntanum from master_purchase where lastupdate like '$thismonth%'";

$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));

$res88 = mysqli_fetch_array($exec88);

$res88cntanum = $res88['cntanum'];



if (isset($_REQUEST["ycompare"])) { $ycompare = $_REQUEST["ycompare"]; } else { $ycompare = ""; }

if (isset($_REQUEST["byear"])) { $byear = $_REQUEST["byear"]; } else { $byear = date('Y'); }

if (isset($_REQUEST["btype"])) { $btype = $_REQUEST["btype"]; } else { $btype = ""; }

if (isset($_REQUEST["percent"])) { $percent = $_REQUEST["percent"]; } else { $percent = ""; }

if (isset($_REQUEST["budgetdate"])) {$budgetdate = $_REQUEST['ADate1']; } else { $budgetdate = date('Y-m-d'); }

if (isset($_REQUEST["budgetname"])) {$budgetname = $_REQUEST['budgetname']; } else { $budgetname = ''; }

if (isset($_REQUEST["docno"])) {$docno = $_REQUEST['docno']; } else { $docno = ''; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if (isset($_REQUEST["frm1submit25"])) { $frm1submit25 = $_REQUEST["frm1submit25"]; } else { $frm1submit25 = ""; }

//$frm1submit1 = $_REQUEST["frm1submit1"];

if ($frm1submit25 == 'frm1submit25')

{

	

	$docno = $_REQUEST['docno'];

	//$xlexport = $_REQUEST['xlexport'];

	$approvedby = $_REQUEST['approvedby'];

	

	$query7 = "UPDATE budget_entry_temp SET approvedby = '$approvedby',is_approved=1,approved_on='$updatedatetime' WHERE budget_no = '$docno'";

	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	$query71 = "INSERT INTO budgetentry (budgetno, budgetdate, budgetname, budgettype,budgetyear,budgetmonth,accountcode,accountname,cost_center,ledgervalue,approvedby,locationcode,username,ipaddress,updatedatetime)  SELECT budget_no, budget_date, budget_name, budget_type,budget_year,budget_month,account_code,account_name,cost_centre,ledger_value,approvedby,location_code,username,ip_address,approved_on  FROM `budget_entry_temp` WHERE budget_no = '$docno' and is_approved=1 order by auto_number";

	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));


	header("location:budgetentrycclist.php");

}





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST["st"];

if (isset($_REQUEST["et"])) { $et = $_REQUEST["et"]; } else { $et = ""; }

//$banum = $_REQUEST["banum"];



?>

<?php include ("includes/pagetitle1.php"); ?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>



<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script type="text/javascript">

var Et = "<?php echo $et; ?>";

var Doc = "<?php echo $docno; ?>";

if(Et == 'excel')

{

	window.open ("budgetentryviewxl.php?docno="+Doc+"");

}

</script>

<style type="text/css">

<!--

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

.style1 {

	font-size: 36px;

	font-weight: bold;

}

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

.style8 {COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-size: 11px;}

-->

</style>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        



<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript">

function Calc(id)

{		

	var Total1 = "0.00";

	var idsplit = id.split('|');

	var Year = document.getElementById('byear').value;

	var Anum = idsplit[1];

	document.getElementById('PA|'+Anum).disabled = true;

	document.getElementById('PA|'+Anum).value = "0.00";

	var IYear = parseFloat(Year);

	//alert(Anum+'---'+IYear);

	if(document.getElementById(id)!=null)

	{	

		var Percent = document.getElementById(id).value;

		if(Percent == '') { Percent = "0.00"; }

		var LAmount = document.getElementById('L|'+IYear+'|'+Anum).value;

		LAmount=LAmount.replace(/,/g,'');

		var Calcamt = parseFloat(LAmount) * (parseFloat(Percent) / 100);

		var Final = parseFloat(LAmount) + parseFloat(Calcamt);

		Final = parseFloat(Final).toFixed(2);

		Finaltot = parseFloat(Final).toFixed(2);

		Final = Final.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		document.getElementById('LV|'+Anum).value = Final;

	}

	for(var i=0;i<=1000;i++)

	{

		if(document.getElementById('LV|'+i)!=null)

		{

			var Total2 = document.getElementById('LV|'+i).value;

			Total2=Total2.replace(/,/g,'');

			Total1=Total1.replace(/,/g,'');

			var Total1 = parseFloat(Total1) + parseFloat(Total2);

			Total1 = parseFloat(Total1).toFixed(2);

			Total1 = Total1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			if(document.getElementById('total')!=null)

			{

			document.getElementById('total').value = Total1;

			}

		}

	}	

}



function Calc1(id)

{		

	var Total1 = "0.00";

	var idsplit = id.split('|');

	var Year = document.getElementById('byear').value;

	var Anum = idsplit[1];

	document.getElementById('P|'+Anum).disabled = true;

	document.getElementById('P|'+Anum).value = "0.00";

	var IYear = parseFloat(Year);

	//alert(Anum+'---'+IYear);

	if(document.getElementById(id)!=null)

	{	

		var Percent = document.getElementById(id).value;

		if(Percent == '') { Percent = "0.00"; }

		var LAmount = document.getElementById('L|'+IYear+'|'+Anum).value;

		LAmount=LAmount.replace(/,/g,'');

		var Calcamt = (parseFloat(Percent));

		var Final = parseFloat(Calcamt);

		Final = parseFloat(Final).toFixed(2);

		Finaltot = parseFloat(Final).toFixed(2);

		Final = Final.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		document.getElementById('LV|'+Anum).value = Final;

	}

	for(var i=0;i<=1000;i++)

	{

		if(document.getElementById('LV|'+i)!=null)

		{

			var Total2 = document.getElementById('LV|'+i).value;

			Total2=Total2.replace(/,/g,'');

			Total1=Total1.replace(/,/g,'');

			var Total1 = parseFloat(Total1) + parseFloat(Total2);

			Total1 = parseFloat(Total1).toFixed(2);

			Total1 = Total1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			if(document.getElementById('total')!=null)

			{

			document.getElementById('total').value = Total1;

			}

		}

	}	

}



function Check(id)

{

	var chk = document.getElementById(id).checked;

	if(chk == true)

	{

		document.getElementById('P|'+id).disabled = false;

		document.getElementById('PA|'+id).disabled = false;

	}

	else

	{

		document.getElementById('P|'+id).disabled = true;

		document.getElementById('PA|'+id).disabled = true;

	}

}

</script>

<body>

<form name="budget" id="budget" method="post" action="budgetentryview.php">

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

    <td colspan="9" bgcolor="#ecf0f5">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="1214" border="0" cellspacing="0" cellpadding="0">

      <tr>

       <td width="96%"><table width="78%" border="0" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

		  <tr bgcolor="#011E6A">

		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="5" align="left"><strong>Cost Center Budget Entries - Initiated</strong></td>

		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="5" align="right"><strong><?php echo $reslocationname; ?></strong></td>

		  </tr>

		  <tr>

		  <td colspan="10" align="left" class="bodytext3">&nbsp; </td>

		  </tr>

		  <?php

		   $query6 = "select * from budget_entry_temp where budget_no = '$docno' limit 0,1";

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res6 = mysqli_fetch_array($exec6))

		  {

		  $budgetno = $res6['budget_no'];

		  $budgetdate = $res6['budget_date'];

		  $budgetname = $res6['budget_name'];

		  $budgetyear = $res6['budget_year'];

		  $budgetby = "";

		  $uploaded_by = $res6['username'];
		  
		  $sno = $sno + 1;

		 
		
		  }

		  ?>

		   <tr>

		  <td width="7%" align="left" class="bodytext3"><strong>Doc No</strong></td>

		  <td width="9%" align="left" class="bodytext3"><?php echo $budgetno; ?></td>

		 

		  <td width="11%" align="left" class="bodytext3"><strong>Budget Name </strong></td>

		  <td width="19%" align="left" class="bodytext3"><?php echo $budgetname; ?></td>

		 

		

		  

		  <td width="11%" align="left" class="bodytext3"><strong>Budget Year </strong></td>

		  <td width="20%" align="left" class="bodytext3"><?php echo $budgetyear; ?>

		  <input type="hidden" name="byear" id="byear" value="<?php echo $budgetyear; ?>" /></td>

		  <td width="11%" align="left" class="bodytext3"><strong>Uploaded By </strong></td>
		  <td width="20%" align="left" class="bodytext3"><?php echo $uploaded_by; ?>


		  </tr>

		  <tr>

		  <td colspan="10" align="left">&nbsp;</td>

		  </tr>

          </tbody>

        </table></td>

		</tr>

		</table>

	</td>

		</tr>

		</form>

		<form name="form1" id="form1" method="post" action="budgetentryccview.php">

		<tr>

        <td width="1%">&nbsp;</td><td width="100%"><table width="100%" border="1" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

		

		  <tr >

		    <td width="1%" align="left" class="bodytext3" ><strong>S.No</strong></td>

			

			<td width="6%" align="left" class="bodytext3" ><strong>Ledger Code</strong></td>

			<td width="12%" align="left" class="bodytext3" ><strong>Ledger Name</strong></td>


			<td width="9%" align="center" class="bodytext3" ><strong>Cost Center</strong></td>

			<td width="5%" align="left" class="bodytext3" ><strong>CC Code</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Jan</strong></td>

            <td width="5%" align="center" class="bodytext3" ><strong>Feb</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Mar</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Apr</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>May</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Jun</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Jul</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Aug</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Sep</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Oct</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Nov</strong></td>

			<td width="5%" align="center" class="bodytext3" ><strong>Dec</strong></td>

			<input type="hidden" name="subtotal" id="subtotal" value="0.00">

			<input type="hidden" name="docno" value="<?php echo $docno; ?>" />

			</tr>

		  <?php

		    $ledger_inc = 0;

		    $err_cnt = 0;
		    $snocount = "";

			$total1 = "0.00";

			$total2 = "0.00";

			$query1 = "select * from budget_entry_temp where budget_no = '$docno' and is_deleted='0' group by account_code,cost_centre,sequence_number order by auto_number";

			//$query1 = "select *,count(account_code) as ledgercnt from budget_entry_temp where budget_no = '$docno' and is_deleted='0' group by account_code  ";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1))

			{  

			$ledger_inc = $ledger_inc + 1;


			  $anum = $res1['auto_number'];

			  $budgetno = $res1['budget_no'];

			  $accountcode = $res1['account_code'];

			  $ledger_arr[$ledger_inc] = $accountcode;

			  $accountname = $res1['account_name'];

			  $ledgervalue = $res1['ledger_value'];

			  $cost_center_id = $res1['cost_centre'];
		

			   $locationcode = $res1['location_code'];

			   $error_flag = $res1['error_flag'];

			   $error_message = trim($res1['error_message']);



			   $ledger_sequence_no =  $res1['sequence_number'];

			  // echo $accountcode.'#'.$cost_center_id.'#'.$ledger_sequence_no.'#'.$error_message.'<br>';
			   $query111 = "select accountsmain from master_accountname where id='$accountcode'";
				$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res111 = mysqli_fetch_array($exec111);
							
				$accountsmain = $res111["accountsmain"];

				$cost_center_name = "";
				/*if($accountsmain == 4 )
				{
					 
					// get cost center name from cost center id
				   $query11 = "select name from `master_costcenter` where auto_number = '$cost_center_id'";
				   
				   $exec11 = mysql_query($query11) or die ("error in query11".mysql_error());
				   $res11 = mysql_fetch_array($exec11);
				   $cost_center_name = $res11["name"];
				  
				}
				else
				{
					$cost_center_name = "";
					
				}*/

				if($cost_center_id!="")
				{
					// get cost center name from cost center id
				   $query11 = "select name from `master_costcenter` where auto_number = '$cost_center_id'";
				   
				   $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				   $res11 = mysqli_fetch_array($exec11);
				   $cost_center_name = $res11["name"];
				}
		   

		   $budgetvalue_allmonths = array();
		   $query_allmonths = "select * from budget_entry_temp where budget_no = '$docno' and account_code='$accountcode' and cost_centre='$cost_center_id' and sequence_number='$ledger_sequence_no' and is_deleted='0' order by budget_month ";

		  
		   $exec_allmonths = mysqli_query($GLOBALS["___mysqli_ston"], $query_allmonths) or die ("error in budget".mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($res_allmonths=mysqli_fetch_array($exec_allmonths))
		  {

		  	if($res_allmonths['budget_month'] >0)
		  	{
		  		$budgetvalue_allmonths[$res_allmonths['budget_month']] = $res_allmonths['ledger_value'];

		  		$totals_allmonths[$ledger_inc][$res_allmonths['budget_month']] = $totals_allmonths[$ledger_inc][$res_allmonths['budget_month']] + $res_allmonths['ledger_value'];
		  	}
		  	

		  }
		   /*if($ledger_sequence_no > 1)
		   {
		   	    $ledger_inc = $ledger_inc +1;
		   }*/
		   
		  
		
		   

			  $snocount = $snocount + 1;

			  

			  $total1 = $total1 + $ledgervalue;

			  $total2 = $total2 + $projection;

	

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($snocount & 1); 

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
			$ccmessage = "";
			$ledgermessage="";
			if($error_flag)
			{
				$err_cnt = $err_cnt +1;
				$colorcode = 'bgcolor="#ff6347"';
				
				if($error_message=='Invalid CC Code')
				{
					
					$ccmessage = "Invalid Code";
					
				}
			    elseif($error_message=="Cost Center is not mapped to Ledger")
			    {
			    	 $ccmessage = $error_message;
			    }
			    elseif($error_message=="Invalid Ledger Code")
			    {
			    	$ledgermessage = "Invalid Code";	
			    }
				elseif($error_message=="Empty Ledger Code")
				{
					$ledgermessage = "Empty Code";
				}
				elseif($error_message=="Duplicate Ledger Code")
				{
					$ledgermessage = "Duplicate Code";
					
				}
				elseif($error_message=="Empty CC Code Entered")
				{
					$ccmessage = "Empty Code";
					
				}

			}
			
			//echo '<br>'.$ccmessage.'<br>';
			 ?>

			  <tr <?php echo $colorcode; ?>>

			  <td align="left" class="bodytext3"><strong><?php echo $snocount; ?></strong></td>

			 	
			  <td align="left" class="bodytext3"><strong><?php echo $accountcode; if($ledgermessage!="") echo '<br>'.$ledgermessage; ?></strong></td>

			  <td align="left" class="bodytext3"><strong><?php echo $accountname; ?></strong></td>

			  <td align="left" class="bodytext3"><strong><?php echo $cost_center_name; ?></strong></td>

			<td align="left" class="bodytext3"><strong><?php echo $cost_center_id; if($ccmessage!="") echo '<br>'.$ccmessage;?></strong></td>

			<?php 
			
			foreach ($budgetvalue_allmonths as $month => $budgetvalue) { ?>
				
				<td  class="bodytext3" align="right"><strong><?php echo number_format($budgetvalue,2,'.',','); ?></strong></td>
			<?php }
			 ?>
			

			</tr>

			<?php

		    }	

		   

foreach ($totals_allmonths as $key => $subarr) {
	
	foreach ($subarr as $mon => $budgetval) {
		
		$final_totals[$mon] = $final_totals[$mon] + $budgetval;
	}
}

			?>	

			<tr bgcolor="#ecf0f5">

			  <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>

			  <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>

			   <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			   <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			  <td align="left" class="bodytext3"><strong>TOTAL</strong></td>

			 
			
				<?php foreach ($final_totals as $monthnum => $totalval) { ?>
					

					<td  align="center" class="bodytext3" ><strong><?php echo number_format($totalval,2,'.',','); ?></strong></td>
				<?php } ?>
			

			</tr>

			 <tr>

			<td colspan="10" align="left" class="bodytext3">

			<input type="hidden" name="approvedby" id="approvedby" value="<?php echo $username; ?>">

			

			<input type="hidden" name="frm1submit25" id="frm1submit25" value="frm1submit25">

			</td>

			<td colspan="7" align="right" class="bodytext3">

			
		<?php if(!$err_cnt) {?>
			<input type="submit" name="submit23" value="APPROVE AND SAVE" style="border:solid 1px #000066;">&nbsp;&nbsp;&nbsp;
		<?php } ?>
			</td>

			</tr>

			

		  </tbody>

		  </table>

		</form>



<?php include ("includes/footer1.php"); ?>



</body>

</html>