<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_customer2.js"></script>
<script type="text/javascript" src="js/autosuggestcustomer.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="POST">
              <!-- <form name="cbform1" method="POST" action="refundreferrallist.php"> -->
		<table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Internal Referral List</strong></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="hidden" id="searchsuppliername" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>

           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
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
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="pname" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="pcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="pvcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="fromdate" id="ADate1" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="todate" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="12" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Referral List</strong>
              
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
            <td class="bodytext31" valign="center"  align="left" 
            bgcolor="#ffffff"><strong>No.</strong></td>
            <td width="8%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
            <td width="17%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
            <td width="10%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
            <td width="8%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><strong> Visit Code </strong></td>
            <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><strong> Gender </strong></td>
            <td width="5%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
            <!-- <td width="13%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department From</strong></div></td>
            <td width="12%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department To</strong></div></td>
            <td width="13%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Referred By </strong></div></td> -->
            <td width="17%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Subtype</strong></div></td>
            <td width="17%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
            <td width="13%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
            </tr>
			
			<?php
			

if (isset($_POST['submit']))
{
					   $pname=$_POST['pname'];   
					   $pcode=$_POST['pcode'];   
					   $pvcode=$_POST['pvcode'];   
					   $fromdate=$_POST['fromdate'];   
					   $todate=$_POST['todate'];   


		  $query2 = "SELECT * from consultation_departmentreferal where paymentstatus='completed'  and status='' ";
		  if($pname!=""){ $query2 .= " and patientname like '%$pname%'  "; }
		  if($pcode!=""){ $query2 .= " and patientcode='$pcode'  "; }
		  if($pvcode!=""){ $query2 .= " and patientvisitcode='$pvcode' "; }
		  if($pvcode!=""){ $query2 .= " and patientvisitcode='$pvcode' "; }
		  if($fromdate!=""){ $query2 .= " and consultationdate between '$fromdate' and '$todate' "; }
		  $query2 .= " group by patientvisitcode ";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $nums = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2patientname = $res2['patientname'];
		  $res2patientcode= $res2['patientcode'];
		  $res2visitcode = $res2['patientvisitcode'];
		  $res2referalname = $res2['referalname'];
		  $res2username = $res2['username'];
		  $res2consultationdate = $res2['consultationdate'];
		
		  $query3 = "select * from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
		  // if(isset($pname)){ $query3 .= " and patientcode=''  "; }
		  // if(isset($pcode)){ $query3 .= " and patientname=''  "; }
		  // if(isset($pvcode)){ $query3 .= " and patientvisitcode='' "; }
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3= mysqli_fetch_array($exec3);
		  
		  $res3gender = $res3['gender'];
		  $res3age = $res3['age'];
		  $res3departmentname = $res3['departmentname'];
		  $query18 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and status='' and patientcode='$res2patientcode' and consultation='completed' order by auto_number limit 0,1";
		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num18 = mysqli_num_rows($exec18);
		  $res18 = mysqli_fetch_array($exec18);
		  if($num18!=0)
		  {
		    $res3departmentname = $res18['referalname'];
		  }
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			   <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2consultationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3gender; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3age; ?></div></td>
				<!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3departmentname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $res2referalname; ?></div></td> -->

			  <td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$res2visitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php 			  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_accountnam = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_accountnam1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_accountnam) or die ("Error in fetch_accountnam".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_accountnam11 = mysqli_fetch_array($fetch_accountnam1);
					echo $fetch_accountnam11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$res2visitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_aut_accountname2 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_aut_accountname22 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_aut_accountname2) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_aut_accountname221 = mysqli_fetch_array($fetch_aut_accountname22);
								echo $fetch_aut_accountname221['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>

			  <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2username; ?></div></td>
			 <td  align="left" valign="center" class="bodytext31"><div align="left"><a href="refundreferral.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>">Refund</a></div></td>
			 
           </tr>
			<?php
			}
			 $query2 = "select * from consultation_referal where paymentstatus='completed' and status='' ";

			  if($pname!=""){ $query2 .= " and patientname like '%$pname%'  "; }
		  if($pcode!=""){ $query2 .= " and patientcode='$pcode'  "; }
		  if($pvcode!=""){ $query2 .= " and patientvisitcode='$pvcode' "; }
		  if($fromdate!=""){ $query2 .= " and consultationdate between '$fromdate' and '$todate' "; }

		  $query2 .= "  group by patientvisitcode ";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $nums = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2patientname = $res2['patientname'];
		  $res2patientcode= $res2['patientcode'];
		  $res2visitcode = $res2['patientvisitcode'];
		  $res2referalname = $res2['referalname'];
		  $res2username = '';
		  $res2consultationdate = $res2['consultationdate'];
		
		  $query3 = "select * from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3= mysqli_fetch_array($exec3);
		  
		  $res3gender = $res3['gender'];
		  $res3age = $res3['age'];
		  $res3departmentname = $res3['departmentname'];
		  $query18 = "select * from consultation_referal where patientvisitcode='$res2visitcode' and status='' and patientcode='$res2patientcode' order by auto_number limit 0,1";
		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num18 = mysqli_num_rows($exec18);
		  $res18 = mysqli_fetch_array($exec18);
		  if($num18!=0)
		  {
		    $res3departmentname = $res18['referalname'];
		  }
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			   <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2consultationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3gender; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3age; ?></div></td>
				<!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3departmentname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $res2referalname; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2username; ?></div></td> -->

			  <td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$res2visitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php 			  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_accountnam = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_accountnam1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_accountnam) or die ("Error in fetch_accountnam".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_accountnam11 = mysqli_fetch_array($fetch_accountnam1);
					echo $fetch_accountnam11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$res2visitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_aut_accountname2 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_aut_accountname22 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_aut_accountname2) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_aut_accountname221 = mysqli_fetch_array($fetch_aut_accountname22);
								echo $fetch_aut_accountname221['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>

			 <td  align="left" valign="center" class="bodytext31"><div align="left"><a href="refundreferral.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>">Refund</a></div></td>
			 
           </tr>
			<?php
			}
			?>
			
			<!-- <?php
			 $query40 = "select * from master_visitentry where paymentstatus='completed' and consultationrefund='torefund' ";

			  if($pname!=""){ $query40 .= " and patientfullname like '%$pname%'  "; }
		  if($pcode!=""){ $query40 .= " and patientcode='$pcode'  "; }
		  if($pvcode!=""){ $query40 .= " and visitcode='$pvcode' "; }
		  if($fromdate!=""){ $query40 .= " and consultationdate between '$fromdate' and '$todate' "; }

		  $query40 .= " and doctorfeesstatus <> 'refund' and doctorfeesrefund = '0.00' and consultingdoctor <> 'OP DOCTOR' and recordstatus='' group by visitcode ";


		  $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $nums = mysqli_num_rows($exec40);
		  while ($res40 = mysqli_fetch_array($exec40))
		  {
     	  $res40patientname = $res40['patientfullname'];
		  $res40patientcode= $res40['patientcode'];
		  $res40visitcode = $res40['visitcode'];
		  $res40referalname = $res40['consultingdoctor'];
		  $res40referalcode = $res40['consultingdoctorcode'];
		  $res40username = '';
		  $res40consultationdate = $res40['consultationdate'];
		  $res3gender = $res40['gender'];
		  $res3age = $res40['age'];
		  $res3departmentname = $res40['departmentname'];
		
		 
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			   <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res40consultationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res40patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res40patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res40visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3gender; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3age; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3departmentname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $res40referalname; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res40username; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$res40visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$res40visitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php 			  
			  $query11 = "SELECT * from master_visitentry where visitcode='$res40visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_accountnam = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_accountnam1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_accountnam) or die ("Error in fetch_accountnam".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_accountnam11 = mysqli_fetch_array($fetch_accountnam1);
					echo $fetch_accountnam11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$res40visitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_aut_accountname2 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_aut_accountname22 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_aut_accountname2) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_aut_accountname221 = mysqli_fetch_array($fetch_aut_accountname22);
								echo $fetch_aut_accountname221['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>


			 <td  align="left" valign="center" class="bodytext31"><div align="left"><a href="refundconsultreferral.php?patientcode=<?php echo $res40patientcode; ?>&&visitcode=<?php echo $res40visitcode; ?>">Refund</a></div></td>
			 
           </tr>
			<?php
			}
			?> -->
           
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
        <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
        <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
				</tr>
          </tbody>
     <?php } 
     ?>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
