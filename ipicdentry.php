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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";


$locationcode = $_REQUEST['locationcode'];	

$query1 = "select * from master_location where locationcode='$locationcode' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
					
			}
	

	

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       

		$patientfullname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accountname = $_REQUEST['accname'];
		$ward1 = $_REQUEST['wardanum'];
		$bed1 = $_REQUEST['bedanum'];
		$age = $_REQUEST['age'];
		$locationcode1=$_REQUEST['locationno'];
		$consultationid = $_REQUEST['docno'];
		foreach($_POST['dis'] as $key=>$value)
		{
	    $pairs111 = $_POST['dis'][$key];
		$pairvar111 = $pairs111;
		$pairs112 = $_POST['code'][$key];
		$pairvar112 = $pairs112;
		$pairs113 = $_POST['dis1'][$key];
		$pairs114 = $_POST['code1'][$key];
		
		if($pairvar111 != "")
		{
		
		$icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,age,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accountname','$updatedate','$updatetime','$pairs111','$pairs112','$pairs113','$pairs114','$age','$locationcode1')";
		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		}
			
		
		header("location:inpatientactivity.php");
		exit;

}



?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPICD-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from consultation_icd where consultationid like '%IPICD%' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["consultationid"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["consultationid"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	
	
	if (isset($_REQUEST["primarydiag"])) {
		$primarydiag = $_REQUEST['primarydiag'];
		$query3 = "update consultation_icd set primarydiag = '',primaryicdcode='' where consultationid = '$delanum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}
	if (isset($_REQUEST["secondarydiag"])) {
		$secondarydiag = $_REQUEST['secondarydiag'];
		$query3 = "update consultation_icd set secondarydiag = '',secicdcode='' where consultationid = '$delanum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
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
-->
</style>

<script>


function validcheck()
{
if(document.getElementById("notes").value == '')
{
alert("Please Enter Notes");
document.getElementById("notes").focus();
return false;
}
}
function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	//To handle ajax dropdown list.
}
function btnDeleteClick13(delID13)
{
	//alert ("Inside btnDeleteClick.");
	//var newtotal;
	//alert(delID4);
	var varDeleteID13= delID13;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet13; 
	fRet13 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet13 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child13 = document.getElementById('idTR'+varDeleteID13);  
	//alert (child3);//tr name
    var parent13 = document.getElementById('insertrow13'); // tbody name.
	document.getElementById ('insertrow13').removeChild(child13);
	
	var child13= document.getElementById('idTRaddtxt'+varDeleteID13);  //tr name
    var parent13 = document.getElementById('insertrow13'); // tbody name.
	
	if (child13 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow13').removeChild(child13);
	}

	
}
function btnDeleteClick14(delID14)
{
	//alert ("Inside btnDeleteClick.");
	//var newtotal;
	//alert(delID4);
	var varDeleteID14= delID14;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet14; 
	fRet14 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet14 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child14 = document.getElementById('idTR'+varDeleteID14);  
	//alert (child3);//tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	document.getElementById ('insertrow14').removeChild(child14);
	
	var child14= document.getElementById('idTRaddtxt'+varDeleteID14);  //tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	
	if (child14 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow14').removeChild(child14);
	}

	
}
</script>

<?php include ("js/dropdownlistipicd1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewipicdcode1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newipicd1.js"></script>

<?php include ("js/dropdownlistipicd2.php"); ?>
<script type="text/javascript" src="js/autosuggestnewipicdcode2.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newipicd2.js"></script>

<script type="text/javascript" src="js/insertnewitemipicd13.js"></script>
<script type="text/javascript" src="js/insertnewitemipicd14.js"></script>
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

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="form1" method="post" action="ipicdentry.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td width="12%" align="center" valign="center" class="bodytext31"><strong> Doc No</strong></td>
			   <td width="13%" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="8%"  align="center" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="13%"  align="center" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                    <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>               </td>
					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Time</strong></td>
                      <td colspan="2" align="left" valign="center" class="bodytext31"> <input type="text" name="time" id="time" value="<?php echo $updatetime; ?>" size="10" readonly></td>
            
			 	<td width="10%" align="center" valign="center" class="bodytext31"><strong>Location</strong></td>
				<td width="30%" colspan="4" align="left"  valign="center"  ><span class="bodytext31"><?php echo $locationname; ?>
                       </span></td>
				<td width="10%" align="center" valign="center" class="bodytext31"><input type="hidden" name="locationno" id="locationno" value="<?php echo $locationcode; ?>" />
				 </td>	   
			 </tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus=''";
		   $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res63 = mysqli_fetch_array($exec63);
		   $num63 = mysqli_num_rows($exec63);
		   if($num63 > 0)
		   {
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   }
		   
		   $query65 = "select * from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus=''";
		   $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res65 = mysqli_fetch_array($exec65);
		    $num65 = mysqli_num_rows($exec65);
		   if($num65 > 0)
		   {
		   $ward = $res65['ward'];
		   $bed = $res65['bed'];
		   }
		   
		   $query71 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res71 = mysqli_fetch_array($exec71);
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
		   }
		
		$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
						  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res7811 = mysqli_fetch_array($exec7811);
						  $wardname1 = $res7811['ward'];
						  
						  $query50 = "select * from master_bed where auto_number='$bed'";
		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res50 = mysqli_fetch_array($exec50);
						  $bedname = $res50['bed'];
	

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
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 <input type="hidden" name="age" id="age" value="<?php echo $age; ?>">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		<td>&nbsp;</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
					 <td>&nbsp;</td>
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow13">					 </div></tr>
					  <tr>
					  <td>&nbsp;</td>
					  <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">
					  <input type="hidden" name="diseas" id="diseas" value="">
					  <td class="bodytext3">Primary</td>
				   <td width="425"> <input name="dis[]" id="dis" type="text" size="69" autocomplete="off"></td>
				      <td width="99"><input name="code[]" type="text" id="code" readonly size="8">
					  <input name="autonum" type="hidden" id="autonum" readonly size="8">
					  <input name="searchdisease1hiddentextbox" type= "hidden" id = "searchdisease1hiddentextbox" >
					  <input name="chapter[]" type="hidden" id="chapter" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem13()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
				      </table>						</td>
		        </tr>
				<tr id="disease1">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="769" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
					 <td width="80">&nbsp;</td>
                       <td width="429" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td width="74" class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow14">					 </div></tr>
					  <tr>
					  <td>&nbsp;</td>
					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">
					  <input type="hidden" name="diseas1" id="diseas1" value="">
					  <td class="bodytext3">Secondary</td>
				   <td width="429"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>
				      <td width="98"><input name="code1[]" type="text" id="code1" readonly size="8">
					  <input name="autonum1" type="hidden" id="autonum1" readonly size="8">
					  <input name="searchdisease1hiddentextbox1" type= "hidden" id = "searchdisease1hiddentextbox1" >
					  <input name="chapter1[]" type="hidden" id="chapter1" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
				      </tr>
				      </table>						</td>
		        </tr>
	    <tr>
        <td>&nbsp;</td>
	</tr>
	  <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="6%" align="center" valign="center" class="bodytext311"><strong></strong></td>
		<td width="23%" align="right" valign="bottom" class="bodytext311">
		<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Previous ICD</strong></td>
                        
                      </tr>
                      <?php
		
						$query14 = "select * from  consultation_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'  order by auto_number desc ";
						$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res14 = mysqli_fetch_array($exec14))
						{
						$primarydiag = $res14['primarydiag'];
						$primaryicdcode = $res14['primaryicdcode'];
						$secondarydiag = $res14['secondarydiag'];
						$secicdcode = $res14['secicdcode'];	
						$consultationid = $res14['consultationid'];
						if($primaryicdcode != '')
						{
						?>
						<tr bgcolor="#CBDBFA"> 
						<td></td>
						<td  class="bodytext3">Primary </td>
						<td  class="bodytext3">Primary Code</td>
						</tr>
						<tr bgcolor="#ecf0f5"> 
						<td>
						<a href="ipicdentry.php?st=del&&anum=<?php echo $consultationid; ?>&&primarydiag=<?php echo $primarydiag; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" onClick="return funcDeletebed('<?php echo $bed ?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>
						</td>
						<td  class="bodytext3"><?php echo $primarydiag; ?></td>
						<td  class="bodytext3"><?php echo $primaryicdcode; ?></td>
						</tr>
						<?php }
						if($secicdcode != '')
						{
						?>
						<tr bgcolor="#CBDBFA"> 
						<td>
						</td>
						<td  class="bodytext3">Secondary </td>
						<td  class="bodytext3">Secondary Code</td>
						</tr>
						<tr bgcolor="#ecf0f5"> 
						<td>
						<a href="ipicdentry.php?st=del&&anum=<?php echo $consultationid; ?>&&secondarydiag=<?php echo $secondarydiag; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" onClick="return funcDeletebed('<?php echo $bed ?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>
						</td>
						<td  class="bodytext3"><?php echo $secondarydiag; ?></td>
						<td  class="bodytext3"><?php echo $secicdcode; ?></td>
						</tr>
						<?php					
						}
						}
					?>
                    </tbody>
                  </table>
		</td>
		<td width="29%" align="left" valign="center" class="bodytext311"></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td width="37%" align="center" valign="center" class="bodytext311">         <input type="hidden" name="frmflag1" value="frmflag1" />
        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A"/></td>
                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

