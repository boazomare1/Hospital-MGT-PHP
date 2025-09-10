<?php
session_start();
		//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
		if (!isset($_SESSION["username"])) header ("location:index.php");
		include ("db/db_connect.php");
		
		$ipaddress = $_SERVER["REMOTE_ADDR"];
		$username = $_SESSION['username'];
		$updatedatetime = date('Y-m-d H:i:s');
		$billdatetime = date('Y-m-d H:i:s');
		$errmsg = "";
		$bgcolorcode = "";
		$pagename = "";
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if ($frmflag1 == 'frmflag1')
		{
			$patientcode = $_REQUEST["patientcode"];
			$visitcode = $_REQUEST["visitcode"];
			$patientfirstname = $_REQUEST["patientfirstname"];
			$patientlastname = $_REQUEST["patientlastname"];
		    $query2 = "select * from master_billing where billnumber = '$billnumber'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_num_rows($exec2);
			if ($res2 == 0)
			{
				$query1 = "insert into master_billing (patientcode, visitcode, patientfirstname, patientlastname, billnumber,
				consultationtype, billingdatetime, consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,paymentmode,planexpirydate,visitlimit,overalllimit,billtype,billamount,billentryby,consultationremarks, 
				ipaddress, username, recordstatus) 
				values('$patientcode','$visitcode','$patientfirstname','$patientlastname','$billnumber',
				'$consultationtype', '$billingdatetime', '$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$paymentmode','$planexpirydate','$visitlimit','$overalllimit','$billtype','$billamount', '$billentryby','$consultationremarks',  
				'$ipaddress', '$username', '$recordstatus')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				$patientcode = '';
				$visitcode = '';
				$patientfirstname = '';
				$patientlastname = '';
				$consultationtype = '';
				$billingdatetime = '';
				$consultingdoctor = '';
				$accountname = '';
				$accountexpirydate = '';
				$paymenttype = '';
				$subtype = '';
				$planname = '';
				$planexpirydate = '';
				$visitlimit = '';
				$overalllimit = '';
				$paymenttype = '';
				$paymentmode = '';
				$billtype = '';
				$billamount = '';
				$billentryby = '';
				$consultationremarks = '';
				$visittype = '';	
				$consultationremarks = '';
				header("location:billing_op2.php?billnumber=$billnumber&&st=success");
				//header ("location:addcompany1.php?st=success&&cpynum=1");
				exit;
			}
			else
			{
				header("location:billing_op1.php?patientcode=$patientcode&&st=failed");
			}
		
		}
		else
		{
			$patientcode = '';
			$visitcode = '';
			$patientfirstname = '';
			$patientlastname = '';
			$billnumber = '';
			$consultationtype = '';
			$billingdatetime = '';
			$consultingdoctor = '';
			$accountname = '';
			$accountexpirydate = '';
			$paymenttype = '';
			$subtype = '';
			$planname = '';
			$planexpirydate = '';
			$visitlimit = '';
			$overalllimit = '';
			$paymenttype = '';
			$paymentmode = '';
			$billtype = '';
			$billamount = '';
			$billentryby = '';
			$consultationremarks = '';
			$visittype = '';
			
		}
		
		if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
		if ($st == 'success')
		{
				$errmsg = "Success. New Visit Updated.";
				if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
				if ($cpynum == 1) //for first company.
				{
					$errmsg = "Success. New Visit Updated.";
				}
		}
		else if ($st == 'failed')
		{
				$errmsg = "Failed. Visit Code Already Exists.";
		}
		
		if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
		$query2 = "select * from master_visitentry where visitcode = '$visitcode'";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$visitcode = $res2["visitcode"];
		$patientcode = $res2['patientcode'];
		$patientfirstname = $res2["patientfirstname"];
		$consultingdoctor = $res2['consultingdoctor'];
		$accountname = $res2['accountname'];
		$accountexpirydate = $res2['accountexpirydate'];
		$paymenttype = $res2['paymenttype'];
		$subtype = $res2['subtype'];
		$planname = $res2['planname'];
		$planexpirydate = $res2['planexpirydate'];
		$visitlimit = $res2['visitlimit'];
		$overalllimit = $res2['overalllimit'];
		$department = $res2['department'];
		$consultationdate = $res2["consultationdate"];
		$consultationtime  = $res2["consultationtime"];
		$consultationfees  = $res2["consultationfees"];
		$billamount = $consultationfees;
		$billentryby = strtoupper($username);
		$consultationremarks = $res2["consultationremarks"];
		$referredby = $res2["referredby"];
		$paymenttype = $res2["paymenttype"];
		$complaint = $res2["complaint"];
		$billamount = $res2["billamount"];
		$billtype = $res2["billtype"];
		$visittype = $res2['visittype'];
		$consultationtype = $res2['consultationtype'];
		
		
		$query2 = "select max(billnumber) as maxbillnumber from master_billing";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		//$res2billnumber = $res2["billnumber"];
		$res2billnumber = $res2["maxbillnumber"];
		if ($res2billnumber == '')
		{
			//$billnumber = 'SBL00000001';
			$billnumber = '1';
		}
		else
		{
			$billnumber = $res2["maxbillnumber"];
			
			$billnumber = $billnumber + 1;
		 
		}
			$query2 = "select * from master_billing where recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$patientfirsname = $res2["patientfirsname"];
			$patientcode = $res2['patientcode'];
			$consultationremarks = $res2["consultationremarks"];
			$billamount = $res2["billamount"];
		?>
		
		
		
	
<style type="text/css">
<!--
table.sample {	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
-->
</style>
<table width="500" border="1">
  <tr>
    <td height="86" colspan="2"><p align="left">Patient Code:<?php echo $patientcode;?> </p>
      <p align="justify">Bill Number: &nbsp;
        <?php echo $billnumber;?> </p></td>
    <td height="86">Patient Name:<?php echo $patientfirstname;?> </td>
  </tr>
  <tr>
    <td width="50" height="23">SNO</td>
    <td width="191">Consultation Remarks </td>
    <td width="237">Consultation Fees </td>
  </tr>
  
  <tr>
    <td height="372" rowspan="2">&nbsp;</td>
    <td rowspan="2"><p><?php echo $consultationremarks;?></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp; </p>
    <p align="right">Bill Entry By:<?php echo $billentryby;?> Total </p></td>
    <td><p><?php echo $billamount;?></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
   <td>&nbsp;<strong><?php echo $billamount;?></strong></td>
  </tr>
</table>
