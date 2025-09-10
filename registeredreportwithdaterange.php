<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

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
//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
include ("autocompletebuild_users.php");

?><style>                     th {            background-color: #ffffff;            position: sticky;            top: 0;            z-index: 1;        }.bodytext31:hover { font-size:14px; }    </style>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_users.js"></script>
<script type="text/javascript" src="js/autosuggestusers1.js"></script>
<script type="text/javascript">

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        
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
function se()
{
	if(document.getElementById("range").value=="")
	{
	alert ("Please select the Age Range");
	return false;
	}
	if(document.getElementById('age').value=="")
	{
	alert ("Please enter the Age");
	return false;
	}
}

</script>

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
		
		
              <form name="cbform1" method="post" action="registeredreportwithdaterange.php">
		<table width="658" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Registration Report</strong></td>
              </tr>
              
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> User </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">

              </span>
                    </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Gender</td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                      <select name="gender">
                      <option value="">All</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      </select>
                      </td>
                  </tr>	
		   
           
					<tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Range </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <select name="range" id="range">
              <option value="">Range</option>
              <option value="equal">=</option>
              <option value="greater">></option>
			  <option value="lesser"><</option>
			  <option value="greaterequal">>=</option>
			  <option value="lesserequal"><=</option>
              </select>                      </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Age </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="age" id="age" size="10" />
                     </span></td>
					</tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	
                  
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
              <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag2" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
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
	   <?php if($cbfrmflag2 == 'cbfrmflag1'){?>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" 
            align="left" border="0">
          <tbody>
          
          <?php
		  
				
		 // $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  //$numcount=mysql_num_rows($exec7);

		  ?>
            <tr>
              <th width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></th>
              <th width="4%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sal</strong></th>
				
              <th width="4%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>First Name</strong></div></th>
              <th width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Middle Name</strong></div></th>
              <th width="5%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Last Name</strong></div></th>
   				  <th width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></th>
				<th width="40%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></th>
   				  <th width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Date</strong></div></th>
   				  <th width="2%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></th>
   				  <th width="4%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></th>
                
   				  <th width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>DOB</strong></div></th>
   				  <th width="5%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Marital Status</strong></div></th>
   				  <th width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Residence</strong></div></th>
                
   				  <th width="6%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mobile</strong></div></th>
   				  <th width="13%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Next Of Kin Name</strong></th>
   				  <th width="10%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Kin.Mobile</strong></div></th>
                
   				  <th width="11%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registered By</strong></div></th>
            </tr>
			
			<?php
			
		      
		
		  		 // $query4 = "select * from master_customer where username like '$cbcustomername' and registrationdate between '$ADate1' and '$ADate2'"; 
		  //$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  //$numcount=mysql_num_rows($exec4);
		  			$cbcustomername=$_REQUEST['cbcustomername'];
			$cbcustomername=trim($cbcustomername);
		  			$searchgender=$_REQUEST['gender'];
		  			 $range=$_REQUEST['range'];
		  			$age=$_REQUEST['age'];
					$searchage=intval($age);
		if($searchgender!='')
		{
				if($range=='equal')
				{
		  		    $query7 = "select * from master_customer where username like '%$cbcustomername%' and age ='$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greater')
				{ 
		  		   $query7 = "select * from master_customer where username like '%$cbcustomername%' and age > '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesser')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age < '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greaterequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age >= '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesserequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age <= '$searchage' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				else
				{
				$query7 = "select * from master_customer where username like '%$cbcustomername%' and gender like '$searchgender' and registrationdate between '$ADate1' and '$ADate2'";
				}
		}
		else
		{
				if($range=='equal')
				{
		  		    $query7 = "select * from master_customer where username like '%$cbcustomername%' and age ='$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greater')
				{ 
		  		   $query7 = "select * from master_customer where username like '%$cbcustomername%' and age > '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesser')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age < '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='greaterequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age >= '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				elseif($range=='lesserequal')
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and age <= '$searchage' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
				else
				{
		  		  $query7 = "select * from master_customer where username like '%$cbcustomername%' and gender like '%$searchgender%' and registrationdate between '$ADate1' and '$ADate2'"; 
				}
		}

				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$customerfullname= $res4['customerfullname'];

				$customername= $res4['customername'];
				$salutation= $res4['salutation'];
				$customermiddlename= $res4['customermiddlename'];
				$customerlastname= $res4['customerlastname'];
				$patientcode= $res4['customercode'];
				$registeredby= $res4['username'];
				$registrationdate= $res4['registrationdate'];
				$age= $res4['age'];
				$gender= $res4['gender'];
				$mobilenumber= $res4['mobilenumber'];
				$kinname= $res4['kinname'];
				$kincontactnumber= $res4['kincontactnumber'];
				$gender= $res4['gender'];
				$dateofbirth= $res4['dateofbirth'];
				$maritalstatus= $res4['maritalstatus'];
				$residence= $res4['area'];
				$accountnum = $res4['accountname'];
				
				$qryacc = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number=$accountnum");
				$resacc = mysqli_fetch_assoc($qryacc);
				$accountname = $resacc['accountname'];
				$snocount=$snocount+1;
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $salutation; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customername; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customermiddlename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customerlastname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $age; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $dateofbirth; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $maritalstatus; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $residence; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $mobilenumber; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $kinname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $kincontactnumber; ?></div></td>
                
				<td class="bodytext31" valign="center"  align="right" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $registeredby; ?></div></td>
				</tr>
			<?php
			}
			?>
			
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td colspan="14" class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><span class="bodytext31"><a download="download" href="print_registrationreport.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&age=<?php echo $searchage; ?>&&searchgender=<?php echo $searchgender; ?>&&range=<?php echo $range; ?>&&cbcustomername=<?php echo $cbcustomername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></span></td>
                
				
				 
			  
			</tr>
          </tbody>
        </table></td><?php }?>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
