<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');  
$transactiondateto = date('Y-m-d');

$errmsg = "";
$searchsuppliername = "";
$cbsuppliername = "";
$res21itemname='';
$res21itemcode='';
$docnumber1 = '';
$testcount = '';
$docnum=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';

//This include updatation takes too long to load for hunge items database.
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

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>
<script>
function loadprintpagepdf1(patientcodes,visitcodes,date1,date2,docno,itemcode)
{
	var varpatientcodes = patientcodes;
	var varvisitcodes = visitcodes;
	var vardate1 = date1;
	var vardate2 = date2;
	var itemcode1=itemcode;
	//alert(varpatientcodes);

		window.open("print_labmaster.php?patientcode="+varpatientcodes+"&&visitcode="+varvisitcodes+'&&docnumber='+docno+'&&ADate1='+vardate1+'&&ADate2='+vardate2+'&&itemcode='+itemcode1,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
}

function viewtests(patientcodes,visitcodes,billno,date1,date2)
{
	var varpatientcodes = patientcodes;
	var varvisitcodes = visitcodes;
	var vardate1 = date1;
	var vardate2 = date2;
	var billnumber = billno;
	//alert(billnumber);
		NewWindow=window.open('viewlabtests.php?patientcode='+varpatientcodes+'&&visitcode='+varvisitcodes+'&&ADate1='+vardate1+'&&ADate2='+vardate2+'&&billnumber='+billnumber,'Window1','width=450,height=200,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
}
</script>
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="lab_audit.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>View Edited Lab Results</strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			  <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc Number</td>
              <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>    
            <tr>
          <td width="78" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="214" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="117" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></span></td>
          </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="#">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$docnumber=$_POST['docnumber'];
	}
	else
	{
	$searchpatient = '';
	$searchpatientcode= '';
	$searchvisitcode='';
	$docnumber='';
	$fromdate=$transactiondatefrom;
	$todate=$transactiondateto;
	}
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];
		
// $querynw1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and recorddate between '$fromdate' and '$todate'  and resultstatus='completed' and publishstatus = 'completed' group by patientvisitcode order by auto_number desc";
// $querynw1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and resultstatus='completed' and publishstatus = 'completed' group by docnumber order by auto_number desc";
// 		$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
// 		$resnw1=mysql_num_rows($execnw1);

// 		 $query1 = "select * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' group by docnumber order by auto_number desc";
		
// 		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
// 		$num1=mysql_num_rows($exec1);
			
// $queryn21 = "select * from consultation_lab where patientcode like 'walkin' and patientvisitcode like 'walkinvis' and resultentry='completed' and consultationdate between '$fromdate' and '$todate'  group by billnumber order by auto_number desc";
// 		$execn21 = mysql_query($queryn21) or die ("Error in Query21".mysql_error());
// 		$numn21=mysql_num_rows($execn21);
		// $resnw1 = $numn21 + $resnw1;
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1065" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="3%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>

								 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Date </strong></div></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Doc No </strong></div></td>
				 
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Sample ID</strong></td>

				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Test</strong></td>

                 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Sample By</strong></td>
				  <!--<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style2"><div align="center">Count</div></td>
				  <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>-->
            </tr>
           

           <?php
		   
    	// $query1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and date(recorddate) between '$fromdate' and '$todate' and sampleid like '%$docnum%' and  publishstatus = 'completed' group by patientvisitcode order by auto_number desc";

        if($searchvisitcode==''){   
    	$query1 = "select * from audit_resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' group by docnumber,itemcode,patientvisitcode order by datetime desc";
    	}else{
    			$query1 = "select * from audit_resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'  and docnumber like '%$docnumber%'   group by docnumber,itemcode,patientvisitcode order by datetime desc";
    	}
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		if($num1>0)
		{
			?>
            <!-- <tr><td colspan="10" class="bodytext31" bgcolor="#ecf0f5"><strong>OP</strong></td></tr> -->
		<?php
		while($res1 = mysqli_fetch_array($exec1))
		{
		$itemname='';
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$res1billnumber='';//$res1['billnumber'];
		$visitcode=$res1['patientvisitcode'];
		$consultationdate=$res1['recorddate'];
	    $docnumber1=$res1['docnumber'];
		$itemcode = $res1['itemcode'];
		$requestedbyname  = $res1['username'];

		$itemname = $res1['itemname'];
		$sampleid = $res1['sampleid'];

		// $query_checkdup = "select * from audit_resultentry_lab where patientcode like '$patientcode' and patientvisitcode like '$visitcode' and docnumber like '$docnumber1' AND itemcode='$itemcode'";
		$query_checkdup = "SELECT * from audit_resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode LIKE '$itemcode'   and docnumber='$docnumber1' group by audit_id,itemcode,recorddate order by itemcode,recorddate DESC";
		$exec_checkdup = mysqli_query($GLOBALS["___mysqli_ston"], $query_checkdup) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_checkdup=mysqli_num_rows($exec_checkdup);
		 // echo $num_checkdup.'--';
		if($num_checkdup==1){
				continue;
		}

		// $query38="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and date(recorddate) between '$fromdate' and '$todate' and publishstatus = 'completed' group by itemcode ";
		// $query38="select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber = '$docnumber1' and resultstatus='completed' and publishstatus ='completed' group by itemcode ";
		// $exec38=mysql_query($query38) or die(mysql_error());
		// $num38=mysql_num_rows($exec38);
		if($num1 !=0)
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
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="center"><a href="lab_audit_view.php?patientcode=<?= $patientcode;?>&visitcode=<?= $visitcode;?>&fromdate=<?=$fromdate?>&todate=<?=$todate?>&docnumber=<?=$docnumber1;?>" target="_blank"><strong>View</strong></a></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">	
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $docnumber1; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $sampleid; ?></div></td>

			<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
			 
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $requestedbyname; ?></div></td>

			  <!--<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $num38; ?></div></td>
			  <td  align="left" valign="center" class="style2"><div align="center"><a href="javascript:viewtests('<?php echo $res23patientcode; ?>','<?php echo $res23patientvisitcode; ?>','<?php echo $res1billnumber; ?>','<?php echo $fromdate; ?>','<?php echo $todate; ?>')"><strong>View</strong></a></div>
			   </td>-->
			  <input type="hidden" name="docnumber[]" value="<?php echo $docnumber1; ?>"> 
             </tr>
		   <?php 
			}
			
		  }
		  }
		   ?>
		   
          

           <?php
            /*
		$sno1 = 0;
    	// $query1 = "select * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and date(recorddate) between '$fromdate' and '$todate' and sampleid like '%$docnum%' group by patientvisitcode order by auto_number desc";
    	 $query1 = "SELECT * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' group by docnumber order by auto_number desc";
		//$query1 = "select * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and resultvalue <> '' and date(recorddate) between '$fromdate' and '$todate' and sampleid like '%$docnum%' group by patientvisitcode order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		if($num1>0)
		{
			?>
			<tr><td colspan="10" class="bodytext31" bgcolor=""><strong></strong> &nbsp;</td></tr>
            <tr><td colspan="10" class="bodytext31" bgcolor="#ecf0f5"><strong>IP</strong></td></tr>
		<?php
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemname='';
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$res1billnumber='';//$res1['billnumber'];
		$visitcode=$res1['patientvisitcode'];
		$consultationdate=$res1['recorddate'];
	    $docnumber=$res1['docnumber'];
		$itemcode = $res1['itemcode'];
		$requestedbyname  = $res1['username'];

		$itemname = $res1['itemname'];
		$sampleid = $res1['sampleid'];

		// $query38="select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and date(recorddate) between '$fromdate' and '$todate' group by itemcode ";
		$query38="SELECT * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' group by itemcode ";
		$exec38=mysql_query($query38) or die(mysql_error());
		$num38=mysql_num_rows($exec38);
		if($num1 !=0)
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
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="center"><a href="lab_audit_view.php?patientcode=<?= $patientcode;?>&visitcode=<?= $visitcode;?>&fromdate=<?=$fromdate?>&todate=<?=$todate?>&&docnumber=<?=$docnumber;?>" target="_blank"><strong>Print</strong></a></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">	
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $docnumber; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $sampleid; ?></div></td>

<td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $itemname; ?></div></td>
			 
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $requestedbyname; ?></div></td>

			  <!--<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $num38; ?></div></td>
			  <td  align="left" valign="center" class="style2"><div align="center"><a href="javascript:viewtests('<?php echo $res23patientcode; ?>','<?php echo $res23patientvisitcode; ?>','<?php echo $res1billnumber; ?>','<?php echo $fromdate; ?>','<?php echo $todate; ?>')"><strong>View</strong></a></div>
			   </td>-->
			  <input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 
             </tr>
		   <?php 
			}
			
		  }
		  }
		  */
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
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
			 
			 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>

             <!--  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td> -->
             
            </tr>
          </tbody>
        </table>
		<tr>
		<td>&nbsp;</td>
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

