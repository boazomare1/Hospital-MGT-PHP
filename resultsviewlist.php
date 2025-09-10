<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$mrdno = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-5 month'));
$transactiondateto = date('Y-m-d');
$sno = '';

//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
	
$querynw1 = "select * from resultentry_lab where patientcode = '$searchpatientcode' and patientvisitcode ='$searchvisitcode' and patientname ='$searchpatient' and recorddate between '$fromdate' and '$todate' and docnumber = '$docnumber' group by docnumber order by auto_number desc";

			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
	}


if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["patientcode"]))
{
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
}
else
{
$patientname = '';
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">
function process1()
{
	
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	//funcVisitEntryPatientCodeValidation1();
	//return false;


	/*if (document.form1.patientcode.value == "")
	{
		alert ("Please Search & Select Patient To Proceed.");
		document.form1.visittype.focus();
		return false;
	}
	if (document.form1.patientfirstname.value == "")
	{
		alert ("Please Enter Patient First Name.");
		document.form1.patientfirstname.focus();
		return false;
	}
	if(document.getElementById("billtype").value = "PAY LATER")
	{
	  if(document.getElementById("accountname").value == "")
	   {
	    alert("Account Name Cannot be Empty");
		document.form1.accountname.focus();
		return false;
	   }
	}
	
	if(document.getElementById("billtype").value = "PAY LATER")
	 {
	  if(document.getElementById("planname").value == "")
	   {
	    alert("Plan Name Cannot be Empty");
		document.form1.planname.focus();
		return false;
		}
	}
	
	*/
/*	if (document.form1.visittype.value == "")
	{
		alert ("Please Select Visit Type.");
		document.form1.visittype.focus();
		return false;
	}*/
	//alert(document.getElementById("recordstatus").value);
	if(document.getElementById("recordstatus").value == 'DELETED')
	{
	alert("Account has been suspended.Please Contact Accounts.");
		document.getElementById("accountnamename").focus();
			return false;
	}
	
	if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value !="CASH")
	{
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/*<!-- if(VarVisitCount > VarVisitLimit)
		 {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		}-->
			*/
	if (document.form1.availablelimit.value == 0)
	  {
		alert ("Available Limit Cannot be Empty.");
		document.form1.availablelimit.focus();
		return false;
	  }		
  }
	
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department.");
		document.form1.department.focus();
		return false;
	}
	
	if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Consulting Doctor.");
		document.form1.consultingdoctor.focus();
		return false;
	}	
	
	if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		return false;
	}
	
	
	if (document.getElementById("accountexpirydate").value != "")
	{
		<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
		$currentdate = date("Y/m/d",$date);
		?>
		var currentdate = "<?php echo $currentdate; ?>";
		var expirydate = document.getElementById("accountexpirydate").value; 
		var currentdate = Date.parse(currentdate);
		var expirydate = Date.parse(expirydate);
		
		if( expirydate < currentdate)
		{
			alert("Please Select Correct Account Expiry date");
			//document.getElementById("accountexpirydate").focus();
			return false;
		}
	}
	
    if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value != "CASH")
	   {
		 /*if (document.getElementById("planfixedamount").value == 0)
		  {
			alert ("For Consultation Visit Entry, Plan Fixed Amount Cannot Be Zero. Please Refer Your Plan Details.");
			return false;
		 }*/
		
		/*if (parseFloat(document.getElementById("visitlimit").value) < parseFloat(document.getElementById("consultationfees").value))
		 {
			alert ("Consultation Fees Crossed Visit Limit Amount Level. Cannot Proceed.");
			return false;
		 }*/
		//return false;
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/* if(VarVisitCount > VarVisitLimit)
		  {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		 }
		*/
		
		var VarOverallLimit = document.getElementById("overalllimit").value;
		var Varavaliablelimit = document.getElementById("availablelimit").value;
		
		if(Varavaliablelimit == 0)
		{
			alert("You Cannot Proceed Because No Available Balance");
			document.getElementById("department").focus();
			return false;
		}	
	}

var patientcode = document.getElementById("patientcode").value;
var popWin; 
popWin = window.open("print_opvisit_label.php?patientcode="+patientcode,"_blank")

}


/*
function funcVisitLimt()
{
<?php
	$query11 = "select * from master_customer where status = 'ACTIVE'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11customername = $res11["customername"];
	$res11visitlimit = $res11['visitlimit'];
	$res11patientfirstname=$res11patientfirstname['patientfirstname'];
		?>
		if(document.getElementById("customername").value == "<?php echo $res11customername; ?>")
		{
			document.getElementById("visitlimit").value = <?php echo $res11visitlimit; ?>;
			document.getElementById("patientfirstname").value = <?php echo $res11patientfirstname; ?>;
			document.getElementById("customername").value = <?php echo $res11customername; ?>;
	
			return false;
		}
	<?php
	}
	?>
}
*/

function funcDepartmentChange()
{



	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultingdoctor").options.length=null; 
		var combo = document.getElementById('consultingdoctor'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Doctor Name", ""); 
		<?php
		$query10 = "select * from master_doctor where department = '$res11departmentanum' order by doctorname";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10doctoranum = $res10['auto_number'];
		$res10doctorcode = $res10["doctorcode"];
		$res10doctorname = $res10["doctorname"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctoranum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11departmentanum' order by consultationtype";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10consultationtypeanum = $res10['auto_number'];
		$res10consultationtype = $res10["consultationtype"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtypeanum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
 

}
function funcConsultationTypeChange()
{
//alert("hi");
document.getElementById("consultationfees").value = '';
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11consultationanum = $res11["auto_number"];
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
	var varconsultationanum =  "<?php echo $res11consultationanum; ?>";
	//alert(varconsultationanum);
	var varconsultationtype = document.getElementById("consultationtype").value;
	//alert(varconsultationtype);
		if(parseInt(varconsultationtype) == parseInt(varconsultationanum))
		{
		    //alert('hi');
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
			document.getElementById("consultationfees").focus();
		}
	<?php
	}
	?>
}


function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}


function funcaccountexpiry()
{
    <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
	}
}

</script>

<?php include ("js/dropdownlist1newscripting1.php"); ?>
<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
-->
</style>
<body onLoad="return funcOnLoadBodyFunctionCall()">
</script>

<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?></td></tr>
	
 
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top"><table width="80%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">


      	  <form name="form1" id="form1" method="post" action="emrresultsviewlist.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
    
        <tr>
          <td width="860">
		  
		  <table width="800" height="128" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td height="21" colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Electronic Medical Records </strong></td>
              </tr>
              <tr>
                <td width="13%" height="32" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search </td>
                <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext32">
                  <input name="customer" id="customer" size="60" autocomplete="off" value="<?php echo $patientname; ?>"/>
                  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden" />
                  <input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
                  <input name="nationalid" id="nationalid" value = "" type = "hidden" />
                  <input name="accountnames" id="accountnames" value="" type="hidden" />
                  <input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden" />
                  <input type="hidden" name="recordstatus" id="recordstatus" />
                  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;" />
                </span></td>
              </tr>
              <tr>
                <td height="32" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext3"><strong> Date From </strong></td>
                <td width="15%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext3"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                <td width="10%" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext3"><strong> Date To </strong></span></td>
                <td width="62%" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext3">
                  <input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
              </tr>
              <tr>
                <td height="32" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
                <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext3"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
                    <input  type="submit" value="Search" name="Submit" />
                    <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
              </tr>
            </tbody>
        
	</form>		

<?php
	$colorloopcount=0;
	$sno=0;
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_POST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$searchpatient = $_POST['customer'];
				$searchpatientcode=$_REQUEST['patientcode'];
				$fromdate=$_POST['ADate1'];
				$todate=$_POST['ADate2'];
			?>
				<table  bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
                  <tr>
                  <td colspan="9" class="bodytext3" nowrap="nowrap">&nbsp;</td></tr>
				  <tr>
				  <td colspan="9" class="bodytext3" bgcolor="#ecf0f5" nowrap="nowrap"><div align="left"><strong>EMR Details </strong></div></td></tr>
				  <tr>
				    <td class="bodytext3" colspan="2">
					<div align="center">
					  <span class="style4">
					  <?php
					echo $searchpatient.' - '.$searchpatientcode;
					?>
					  </span>					</div>					</td>
                  </tr>
                  <tr>
                    <td width="308" bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code </strong></td>
                    <td width="476" bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
                  </tr>
				  
				 
				      <?php
  				  $query1 = "select * from master_ipvisitentry where patientcode = '$searchpatientcode' order by auto_number desc";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res1 = mysqli_fetch_array($exec1))
				  {
				  $ipvisitcode = $res1['visitcode'];
				  $ipvisitdate = $res1['consultationdate'];
				  
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
                    <td bgcolor="#ffffff" class="bodytext3"><a target="_blank" href="ipemrview.php?patientcode=<?php echo $searchpatientcode; ?>&&visitcode=<?php echo $ipvisitcode; ?>"><strong><?php echo $ipvisitcode; ?></strong></a></td>
                    <td bgcolor="#ffffff" class="bodytext3"><?php echo $ipvisitdate; ?>&nbsp;</td>
					
				  <?php } ?>
				  </tr>	
                  
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
			   
				   <tr>
				  <?php
                  $query1 = "select * from master_visitentry where patientcode = '$searchpatientcode' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res1 = mysqli_fetch_array($exec1))
				  {
				  $visitcode = $res1['visitcode'];
				  $visitdate = $res1['consultationdate'];
				  ?>
                 
                  <tr>
				  <?php 
				  if($searchpatient!= '') { ?> 
                    <td bgcolor="#ffffff" class="bodytext3"><?php echo $visitcode; ?>&nbsp;</td>
                    <td bgcolor="#ffffff" class="bodytext3"><?php echo $visitdate; ?>&nbsp;</td>
                  <?php } ?>
				  </tr>
				  	
                  <tr>
                    <td class="bodytext3"><strong>Case Sheet&nbsp;</strong></td>
                    <td class="bodytext3"><span class="style2"><a target="_blank" href="emrcasesheet.php?visitcode=<?php echo $visitcode; ?>">View</a>&nbsp;</span></td>
                  </tr>
				  <?php
                  $query2 = "select * from resultentry_lab where patientvisitcode = '$visitcode' group by itemname ";
				  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res2 = mysqli_fetch_array($exec2))
				  {
                   $labtestname = $res2['itemname'];
                  $labdocnumber = $res2['docnumber'];
				  
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
                    <td class="bodytext3"><?php echo $labtestname; ?>&nbsp;</td>
                    <td class="bodytext3"><span class="style3"><a href="labresultsview.php?patientcode=<?php echo $searchpatientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $labdocnumber; ?>" target="_blank">View</a>&nbsp;</span></td>
                  </tr>
				  <?php
				  }
				  ?>
				  <?php
				  $query2 = "select * from resultentry_radiology where patientvisitcode = '$visitcode' and patientcode = '$searchpatientcode' ";
				  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res2 = mysqli_fetch_array($exec2))
				  {
				  $radiologytestname = $res2['itemname'];
				  $radiologydocnumber = $res2['docnumber'];
				  
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
                    <td class="bodytext3"><?php echo $radiologytestname; ?>&nbsp;</td>
				<td class="bodytext3">	
				<div align="left">
			 <a href="radiologyresultsview.php?patientcode=<?php echo $searchpatientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $radiologydocnumber; ?>" target="_blank"><strong>View</strong></a></div>	</td>
                  </tr>
				  <?php
				  }
				  ?>
                  <tr>
                    <td class="bodytext3">&nbsp;</td>
                    <td class="bodytext3">&nbsp;</td>
                  </tr>
				  <?php
				  }
				  ?>
                  <tr>
                    <td class="bodytext3">&nbsp;</td>
                    <td class="bodytext3">&nbsp;</td>
                  </tr>
          </table>
				<?php
				}
				?>
              
   
<?php include ("includes/footer1.php"); ?>
</body>
</html>