<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$currenttime = date("H:i:s");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$externallabsuppliername = $_REQUEST['suppliername'];
$externallabsuppliercode = $_REQUEST['suppliercode'];
$pono = $_REQUEST['pono'];

foreach($_POST['sampleid'] as $key => $value)
{
$sampleid = $_POST['sampleid'][$key];
$visitcode = $_POST['visitcode'][$key];
$patientcode = $_POST['patientcode'][$key];
$patientname = $_POST['patientname'][$key];
$itemname = $_POST['itemname'][$key];
$itemcode = $_POST['itemcode'][$key];
$rate = $_POST['rate'][$key];

		foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $sampleid)
		{
		$query35 = "insert into generatedpo_externallab(date,docno,sampleid,patientcode,visitcode,patientname,suppliercode,suppliername,itemname,itemcode,rate,username,ipaddress)values('$currentdate','$pono','$sampleid','$patientcode','$visitcode','$patientname','$externallabsuppliercode','$externallabsuppliername','$itemname','$itemcode','$rate','$username','$ipaddress')";
		$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
}
header("location:externallabpo.php?docno=$pono");

}

		function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>

<?php
if(isset($_REQUEST['docno']))
{
$pono = $_REQUEST['docno'];

$query71 = "select * from externallab_po where docno='$pono'";
$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res71 = mysqli_fetch_array($exec71);
$sampleid = $res71['sampleid'];

$query55 = "select * from samplecollection_lab where sampleid='$sampleid'";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$suppliername = $res55['externallabname'];
$suppliercode = $res55['externallabcode'];

$query661 = "select * from master_accountname where id='$suppliercode'";
$exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res661 = mysqli_fetch_array($exec661);
$addressnamenew = $res661['contact'];

$query66 = "select * from master_supplier where suppliercode='$suppliercode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$addressname = $res66['address1'];
$address = $addressname;
$addressname1 = $res66['address2'];
if($addressname1 != '')
{
$address = $address.','.$addressname1;
}
$area = $res66['area'];
if($area != '')
{
$address = $address.','.$area;
}
$city = $res66['city'];
if($city !='')
{
$address = $address.','.$city;
}
$state = $res66['state'];
if($state !='')
{
$address = $address.','.$state;
}
$country = $res66['country'];
if($country !='')
{
$address = $address.','.$country;
}
$telephone2 = $res66['mobilenumber'];
$tele=$telephone2;
$telephone = $res66['phonenumber1'];
if($telephone != '')
{
$tele=$tele.','.$telephone;
}
$telephone1 = $res66['phonenumber2'];
if($telephone1 != '')
{
$tele=$tele.','.$telephone1;
}

$email = $res66['emailid1'];
$email1 = $res66['emailid2'];
if($email1 != '')
{
$email = $email.','.$email1;
}
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
}
-->
</style>
</head>

<body>
<form method="post" name="form1" action="externallabpogenerate.php">

<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
          
			  <tr>
			    <td width="53" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PO No</strong></td>
                <td colspan="2" align="left" valign="top" class="bodytext3"><?php echo $pono; ?>
				<input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly"/>                  </td>
                 <td align="left" valign="top" class="bodytext3"><strong>Date</strong></td>
			    <td align="left" valign="top" class="bodytext3"><?php echo $currentdate; ?>
			      <input type="hidden" name="date" id="date" value="<?php echo $currentdate; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly="readonly"/></td>
			    
			  </tr>
				<tr>
			    <td width="53" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td colspan="2" align="left" valign="top" class="bodytext3"><?php echo $suppliername; ?> & <?php echo $suppliercode; ?>
				<input type="hidden" name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>  
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">                </td>
                 <td width="92" align="left" valign="top" class="bodytext3"><strong>Telephone</strong></td>
			    <td width="133" align="left" valign="top" class="bodytext3"><?php echo $tele; ?>
			      <input type="hidden" name="telephone" id="telephone" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/></td>
				</tr>
				<tr>
			   <td width="53" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
                <td colspan="2" align="left" valign="top" class="bodytext3"><?php echo $addressnamenew; ?>
				<input type="hidden" name="address" value="<?php echo $addressnamenew; ?>"></td>
				   <td width="92" align="left" valign="top" class="bodytext3"><strong>Email</strong></td>
			      <td width="133" align="left" valign="top" class="bodytext3"><?php echo $email; ?>
			        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/></td>
				</tr>
				<tr>
				  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				</tr>
            <tr>
		      <td width="53" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Select</strong></div></td>
		      <td width="65" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
				<td width="63" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td colspan="2" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
              <td width="62" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg No</strong></td>
              <td width="57" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="71" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
				 <td width="41" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
				 <td width="137" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name</strong></div></td>
				 <td width="38" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
             </tr>
				<?php
				
$sno=0;
$colorloopcount = 0;
$totalamount = 0;
$query711 = "select * from externallab_po where docno='$pono'";
$exec711 = mysqli_query($GLOBALS["___mysqli_ston"], $query711) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res711 = mysqli_fetch_array($exec711))
{
$sampleid1 = $res711['sampleid'];

$query7 = "select * from samplecollection_lab where sampleid='$sampleid1' order by recorddate desc";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num7 = mysqli_num_rows($exec7);
							
while($res7 = mysqli_fetch_array($exec7))
{
$patientname6 = $res7['patientname'];
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sampleid = $res7['sampleid'];

$query751 = "select * from master_customer where customercode = '$regno'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$dob = $res751['dateofbirth'];
$age = calculate_age($dob);
$gender = $res751['gender'];


$query68="select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$externallab = $res68['externallab'];
$rate = $res68['externalrate'];

if($externallab == 'on')
{
$totalamount = $totalamount + $rate;
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
              <td align="left" valign="center"  
                class="bodytext31"><input type="checkbox" name="select[]" id="select" value="<?php echo $sampleid; ?>"></td>
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
              <td colspan="2" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
             				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $age; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $test; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="right"><?php echo $rate; ?></div></td>
				<input type="hidden" name="sampleid[]" id="sampleid" value="<?php echo $sampleid; ?>"> 
				<input type="hidden" name="patientname[]" id="patientname" value="<?php echo $patientname6; ?>">
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $regno; ?>">
				<input type="hidden" name="itemcode[]" id="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="itemname[]" id="itemname" value="<?php echo $test; ?>">
				<input type="hidden" name="rate[]" id="rate" value="<?php echo $rate; ?>">
				</tr>
				<?php
				}
				}
				}
				?>
				<tr>
				 <td colspan="11" align="right" valign="center" class="bodytext31"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
				</tr>
          </tbody>
        </table></td>
      </tr>
				    
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left"><strong>User Name</strong>
	    <?php echo $username; ?></td>
	    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left"><strong>Time</strong>
	    <?php echo $currenttime; ?></td>
	    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	    <input type="submit" name="submit" value="Save"></td>
	  </tr>
    </table>
</table>
</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

