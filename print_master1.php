<?php
session_start();
//error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
$docno = $_SESSION["docno"];


$patientcode2=$_REQUEST['patientcode'];
 $query156="select priliminarysis from master_consultationlist where patientcode='$patientcode2'";
$exe156=mysqli_query($GLOBALS["___mysqli_ston"], $query156)or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
$res156=mysqli_fetch_array($exe156);
$priliminary2=$res156["priliminarysis"];

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}

?>
<script>
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
break;
}
}
if (hasChecked == false)
{
alert("Please acknowledge a lab item  or click back button on the browser to exit lab result Print");
return false;
}
return true;
}
</script>
<script>
function funcLabShowView(para)
{	
var idname=para;
alert(idname);
 if (document.getElementById(idname) != null) 
	{
	if(document.getElementById(idname).style.display == 'none')
	{
	document.getElementById(idname).style.display = 'none';
	}
	else
	{
	document.getElementById(idname).style.display = ''
	}
	}			
}
/*function funcLabShowView(param)
{
var idname1=param;

  if (document.getElementById(idname) != null) 
     {
	 document.getElementById(idname).style.display = 'none';
	}
	if (document.getElementById(idname) != null) 
	  {
	  document.getElementById(idname).style.display = '';
	 }
}*/
/*function funcPrint()
{
var varCustomercode = document.getElementById('customercode').value;
var varVisitcode = document.getElementById('visitcode').value;
var varDocnum = document.getElementById('docnumber').value;
window.open("print_labresultentry.php?patientcode=" + varCustomercode + "&&visitcode="+ varVisitcode + "&&docnumber=" + varDocnum);
}
*/
function validcheck1()
{

if(confirm("Do You Want To Print The Record?")==false){return false;}	
}
</script>
<script>
function funcOnLoadBodyFunctionCall()
{
funcLabHideView();
	}

function funcrefrange()
{
alert(document.getElementById("rangeref").innerHTML);
}
function validcheck()
{
var varUserChoice; 
	varUserChoice = confirm('Have you entered all the results ? Once acknowledged, patient will exit from View Samples. Please Confirm.'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		document.getElementById("ack").checked = false;
	}
	
}

function coasearch(varCallFrom,itemcode,reference)
{
	var varCallFrom = varCallFrom;
	var itemcode = itemcode;
	var reference = reference;
	window.open("labreference.php?callfrom="+varCallFrom+"&&itemcode="+itemcode+"&&reference="+reference,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$fromdate = $_REQUEST["fromdate"];
$todate = $_REQUEST["todate"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec65)==0)
{
$query65= "select * from master_visitentry where visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec78)==0)
{
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];

$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec612)==0)
{
$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res612 = mysqli_fetch_array($exec612);
$orderedby = $res612['username'];
$docnumber = $res612['sampleid'];
 //get locationcode and locationname
//$locationcode = $res612['locationcode'];
// $locationname = $res612['locationname'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];

$query24 = "select * from master_employee where username = '$orderedby'";
$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res24 = mysqli_fetch_array($exec24);
$orderedbyname = $res24['employeename'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'LRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from resultentry_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='LRE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'LRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

if($Patientname == '')
{
$query34 = "select * from consultation_lab";
$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res34 = mysqli_fetch_array($exec34);
$externalbillno = $res34['billnumber'];

 $query66="select * from billing_external where billno='$externalbillno'";
				$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res66=mysqli_fetch_array($exec66);
				$patientage=$res66['age'];
				$patientgender=$res66['gender'];
			    $Patientname = $res66['patientname'];
	 if($patientcode == 'walkin')
				  {
				  $patientcode = 'DIRECT';
				  
				  }
				  if($visitcode == 'walkinvis')
				  {
				  $visitcode = 'DIRECT';
				  
				  }
}
$subTRcolorloopcount = 1;
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="print_labresultsfull_new1.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck1()">
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
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="0%">&nbsp;</td>
    <td width="88%" valign="top">
	<table width="1058" border="0" cellspacing="0" cellpadding="0">
   
      <tr>
        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#ecf0f5">
			 
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
	  <td width="22%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="26%" bgcolor="#ecf0f5" class="bodytext3">
               <?php echo $dateonly1; ?>
                  <input type="hidden" name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />			</td>
				<td width="11%" align="left" valign="middle"  class="bodytext3"><strong>Doc No</strong></td>
                <td width="21%" align="left" class="bodytext3" valign="middle" >
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>                  </td>
              </tr>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" align="left" valign="middle" class="bodytext3">
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" valign="top" class="bodytext3">
<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
<a href="emr2.php?patientcode=<?php echo $patientcode?>&&visitcode=<?php echo $visitcode?>"><?php echo $patientcode; ?></a>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    <td align="left" valign="top" class="bodytext3"><strong>Ordered By </strong></td>
			    <td align="left" valign="top" class="bodytext3"><?php echo $orderedbyname; ?></td>
				<input type="hidden" name="doctorname" id="doctorname" value="<?php echo $orderedbyname; ?>">
			  </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="samplecollectiondocno" id="docnum" value="<?php echo $docnumber; ?>">				</td>
				<input type="hidden" name="sampleid" id="sampleid" value="<?php echo $sampleid; ?>">
				<td colspan="1" align="left" valign="top" class="bodytext3"><strong>Sample Doc No</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3"><?php echo $docnumber; ?></td>
				  </tr>
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                 <td align="left" class="bodytext3" valign="top" >&nbsp;</td>
                 <td align="left" class="bodytext3" valign="top" ><strong>Priliminay</strong></td>
                 <td align="left" class="bodytext3" valign="top" ><?php echo $priliminary2;?></td>
				  </tr>
                  <tr>
                  <td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td>
                  </tr>
            </tbody>
        </table></td>
      </tr>
	
     <tr>
	  <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>Results</strong></td>
      <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>Location : <?php echo $locationname; ?></strong></td>
      <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
       <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
       
				 
	      </tr>
				  
				   <tr>
				   		    <td width="5%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
			<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Result value</strong></div></td>
			<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Units</strong></div></td>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Reference Value</strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Acknowledge</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Page</strong></div></td>
		  </tr>
				  <?php
				  
				  if($patientcode == 'DIRECT')
				  {
				  $patientcode = 'walkin';
				  
				  }
				  if($visitcode == 'DIRECT')
				  {
				  $visitcode = 'walkinvis';
				  
				  }


  $query31="select * from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and result <> '' and date(resultdatetime) between '$fromdate' and '$todate' group by testcode";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
	   $labname1=$res31['testname'];
	   $labitemcode = $res31['testcode'];
		$sampleid= $res31['sample_id'];
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
			$sno = $sno + 1;
		?>		  
			  <tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?> onClick="return funcShowDetailView('<?php echo $sno; ?>')">
              <td class="bodytext31" valign="center"  align="center"><div align="left"><?php echo $labname1; ?>
              
              </div>
              
              </td>
			  	  
              <td class="bodytext31" valign="center"  align="center">
			  <div align="center">
			  <img src="images/plus1.gif" width="13" height="13" >			  </div>			  </td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"></div></td>
			       	  <td class="bodytext31" valign="center"  align="center">
			  <div class="bodytext31"></div></td>
			  <td class="bodytext31" valign="center"  align="center"><div align="center"><input type="checkbox" id="ack" name="ack[]" onClick="return enterpage(<?php echo $sno; ?>)" value="<?php echo $labitemcode.'_'.$sampleid; ?>"></div></td>
			   <td class="bodytext31" valign="center"  align="center"><div align="center"><input min='1' max='5' type="number" id="page<?php echo $sno; ?>" name="page[]" disabled="disabled"></div></td>
		
         </tr>
		 	<tr id="idTRSub<?php echo $sno; ?>">
			<td colspan="6"  align="left" valign="center" class="bodytext31">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1108"
            align="left" border="0">
              <tbody>
               
			   <?php 
			   $subTRsno = 0;
			   $sn = 0;
			   $subTRcolorloopcount =0;
			   $query52="select * from master_labreference where itemcode='$labitemcode' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto and status <> 'deleted'"; 
			   $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52);
			   $num1=mysqli_num_rows($exec52);
			   
			   while($res52=mysqli_fetch_array($exec52))
			   {
			   $labname2=$res52['itemname'];
			   $itemcode2=$res52['itemcode'];
				  $labunit1=$res52['itemname_abbreviation'];
				   $labreferenceunit = $res52['referenceunit'];
				   
				$labreferencename = $res52['referencename'];
				$labitemanum = $res52['auto_number'];
				 $referencecomments = $res52['referencecomments'];
				 
				
				   $labreferencerange = $res52['referencerange'];
				  
				  //echo $labreferencerange1[0]; 
				  $labreferencevalue1=$res52['referencevalue'];
				  
				  $query43 = "select * from pending_test_orders where sample_id='$sampleid' and testcode = '$itemcode2' and parametername = '$labreferencename' and date(resultdatetime) between '$fromdate' and '$todate' order by auto_number desc";
				  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res43 = mysqli_fetch_array($exec43);
				  $result = $res43['result'];
				  //$refcomments = $res43['referencecomments'];
				 
				  
				
			  $query641 = "select * from master_labreference where itemcode='$itemcode2' and referencename = '$labreferencename' and status <> 'deleted' group by referencename";
				  $exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $num641 = mysqli_num_rows($exec641);
				  if($num641 > 0)
				  {
				  
				$subTRcolorloopcount = $subTRcolorloopcount + 1;
				$subTRshowcolor = ($subTRcolorloopcount & 1); 
				if ($subTRshowcolor == 0)
				{
					//echo "if";
					$subTRcolorcode = 'bgcolor="#EFEFEF"';
				}
				else
				{
					//echo "else";
					$subTRcolorcode = 'bgcolor="#cbdbfa"';
				}
						   ?> 
						     <tr <?php echo $subTRcolorcode; ?>>
							 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="211"><div class="bodytext311"> <?php if($labreferencename == '')
				   {
				   echo $labname2;
				   }
				   else
				   {
				   echo $labreferencename;	
				   } ?>
				    <input type="hidden" name="lab[]" value="<?php echo $labname2;?>">
				   <input type="hidden" name="referencename[]" value="<?php echo $labreferencename; ?>">
				  <input type="hidden" name="code[]" value="<?php echo $itemcode2; ?>">
				  </div></td>
				  <?php
				  
				  $labreferencerange1 = $labreferencerange;
				  $labreferencerange1 = explode('-',$labreferencerange1);
				  if(!ctype_digit($labreferencerange1[0]))
				{
				$labreferencerange1length = strlen($labreferencerange1[0]);
				$labreferencerange1symbol = substr($labreferencerange1[0],0,1);
				$labreferencerange1withoutsymbol = substr($labreferencerange1[0],1,$labreferencerange1length);
				if($labreferencerange1symbol == '<')
				{
				$labreferencerange1[0] = 0;
				$labreferencerange1[1] = $labreferencerange1withoutsymbol;
				}
				if($labreferencerange1symbol == '>')
				{
				$labreferencerange1[0] = $labreferencerange1withoutsymbol;
				$labreferencerange1[1] = 1000000;
				}
				}
				  
				 $query49 = "select * from resultentry_lab where patientcode='$patientcode' and itemcode='$itemcode2' and referencename='$labreferencename' order by auto_number desc limit 0,1";
				 $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $res49 = mysqli_fetch_array($exec49);
				 $pastresult = $res49['resultvalue'];
				  ?>
                  <td  align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">
				   <input type="hidden" name="serialnumber" id="serialnumber<?php echo $sn; ?>" value="<?php echo $sn = $sn+1; ?>">
				  <input readonly="" type="text" name="result[]" id="result<?php echo $sn; ?>" onBlur="return funcrange('<?php echo $sn; ?>')" size="10" value="<?php echo $result; ?>" />
				  <!--<label onClick="javascript:coasearch('<?php echo $sn; ?>','<?php echo $itemcode2; ?>','<?php echo $labitemanum; ?>')">Click</label>-->
				 <input type="hidden" name="range111[]" id="range111<?php echo $sn; ?>" value="<?php echo $labreferencerange1[0] ; ?>">
				  <input type="hidden" name="range112[]" id="range112<?php echo $sn; ?>" value="<?php echo $labreferencerange1[1] ; ?>">
				  <input type="hidden" name="color[]" id="color<?php echo $sn; ?>" value="">
				   </div></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="191"><div > <?php if($labreferenceunit == '')
				  {
				  echo $labunit1;
				  }
				  else
				  {
				  echo $labreferenceunit;
				  } ?><input type="hidden" name="units[]" size="8" value="<?php echo $labreferenceunit; ?>"/> </div></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="73" style="color:red;"><?php echo $pastresult; ?></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="205"><div align="left" id="rangeref" onClick="return funcrefrange();"> <?php if($labreferencerange == '')
			   {
			   echo $labreferencevalue1;
			   }
			   else
			   {
			   echo $labreferencerange;
			   } ?></div><input type="hidden" name="reference[]" size="8" value="<?php echo $labreferencerange; ?>"/></td>
			    <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="205">
				<textarea name="refcomments[]" rows="3" cols="20" placeholder="Comments" style="display:none;"><?php echo $referencecomments; ?></textarea>
				<div style="background-color:#FFFFFF;"><?php echo $referencecomments; ?></div>
				</td>
              </tr>
			  <?php 
		 }
		 }
		 ?>
			  </tbody>
            </table>			</td>
			
			</tr>
			 
		 <?php
		  
		 }
		 ?>
		 
				  
				  
				  	<script language="javascript">
			//alert ("Inside JS");
			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.
			for (i=1;i<=100;i++)
			{
				if (document.getElementById("idTRSub"+i+"") != null) 
				{
					document.getElementById("idTRSub"+i+"").style.display = 'none';
				}
			}
			
			function funcShowDetailView(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber;
				//alert (varSerialNumber);
					i = varSerialNumber;
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						if(document.getElementById("idTRSub"+i+"").style.display == 'none')
						{
						document.getElementById("idTRSub"+i+"").style.display = '';
						}
						else
						{
						//alert(document.getElementById("idTRSub"+i+"").style.display );
						document.getElementById("idTRSub"+i+"").style.display = 'none';
						}
					}
			}
			
			function funcShowDetailHide(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = 'none';
					}
			}
			function enterpage(varpage)
			{
				if(document.getElementById("page"+varpage+"") != null)
				{
						document.getElementById("page"+varpage+"").disabled = !(document.getElementById("page"+varpage+"").disabled);
				}
			}
			</script>	

      <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name: 
               <input name="user" type="hidden" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"><?php echo strtoupper($_SESSION['username']); ?></td>
          </tr>
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                     <input name="Submit2223" type="submit" value="Print" onClick="return acknowledgevalid()"  accesskey="b" class="button"/>
               </td>
          </tr>
      </table>
	</td>
    <td width="12%" valign="top">
	<table>
	<tr>
	<td>&nbsp;</td>
	<td width="41">&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<!--<tr>
	<td align="left" valign="middel" width="35" bgcolor="orange"></td>
	<td class="bodytext32"><strong>Below Range</strong></td>
	</tr>
    <tr>
	<td align="left" valign="middel" width="35" bgcolor="green"></td>
	<td class="bodytext32"><strong>Normal</strong></td>
	</tr>
	<tr>
	<td align="left" valign="middel" width="35" bgcolor="red"></td>
	<td class="bodytext32"><strong>Above Range</strong></td>
	</tr>-->
	</table></td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>
