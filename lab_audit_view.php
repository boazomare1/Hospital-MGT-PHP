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


function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y Years "); }
    if ($interval->m) { $result .= $interval->format("%m Months "); }
    if ($interval->d) { $result .= $interval->format("%d Days "); }

    return $result;
}

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
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; padding: 5px; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; padding: 5px; FONT-FAMILY: Tahoma
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
$docnumber_get=$_REQUEST['docnumber'];
if(isset($_REQUEST['itemcode'])){ $itemcode = $_REQUEST['itemcode']; } else { $itemcode = ''; }

 

?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$type = 'OP';

if(mysqli_num_rows($exec65)==0)
{
$query65= "select * from master_ipvisitentry where visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$type = 'IP';
}

$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

if($type == 'IP'){

$query43 = "select * from ipresultentry_lab where patientvisitcode='$visitcode' and docnumber='$docnumber_get' ";
}else{
$query43 = "select * from resultentry_lab where patientvisitcode='$visitcode' and docnumber='$docnumber_get' ";
}
$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res43 = mysqli_fetch_array($exec43);
 $sampleDocNumber = $res43['sampleid'];
 $equipmentcode = $res43['equipmentcode'];
 $equipmentname = $res43['equipmentname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];
$dateofbirth=$res69['dateofbirth'];

// $transactiondateto = date('Y-m-d');


$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec78)==0)
{
$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];

$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode'  order by auto_number desc";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec612)==0)
{
$query612 = "select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc ";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res612 = mysqli_fetch_array($exec612);
$orderedby = $res612['username'];
// echo $docnumber = $res612['sampleid'];


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


if($type == 'IP')
		 $query79="SELECT recorddate from ipsamplecollection_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and sampleid='$sampleDocNumber'";
		else
		  $query79="SELECT recorddate from samplecollection_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and sampleid='$sampleDocNumber'";
		 // and itemcode='$itemcode' 
		$exec79=mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res79=mysqli_fetch_array($exec79);
		 $date2_recorddate=$res79['recorddate'];

		$date1=strtotime($dateofbirth);
		$date2=strtotime($date2_recorddate);
		$datediff = $date2 - $date1;
		 $birth_days = round($datediff / (60 * 60 * 24));

		 if($dateofbirth>'0000-00-00'){
			$today = new DateTime($date2_recorddate);
			$diff = $today->diff(new DateTime($dateofbirth));
			$patientage1 = format_interval($diff);
			}else{
			  $patientage1 = '<font color="red">DOB Not Found.</font>';
			}
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

// $billnumber = $res2["docnumber"];
$billnumbercode=$docnumber_get;
// $billdigit=strlen($billnumber);
// if ($billnumber == '')
// {
// 	$billnumbercode ='LRE-'.'1';
// 	$openingbalance = '0.00';
// }
// else
// {
// 	$billnumber = $res2["docnumber"];
// 	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
// 	//echo $billnumbercode;
// 	$billnumbercode = intval($billnumbercode);
// 	$billnumbercode = $billnumbercode + 1;

// 	$maxanum = $billnumbercode;
	
	
// 	$billnumbercode = 'LRE-' .$maxanum;
// 	$openingbalance = '0.00';
// 	//echo $companycode;
// }

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
<body >
<form name="frm" id="frmsales" method="post" action="#" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck1()">
<table width="101%" border="0" cellspacing="0" cellpadding="2" >
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
    <td width="0%">&nbsp;</td>
    <td  width="88%" valign="top">
	<table width="1058" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; ">
   <!-- style="border-collapse: collapse; margin: auto;"> -->
      <tr>
        <td colspan="144"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse; ">
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
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage1; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="samplecollectiondocno" id="docnum" value="<?php echo $docnumber; ?>">				</td>
				<input type="hidden" name="sampleid" id="sampleid" value="<?php echo $sampleid; ?>">
				<td colspan="1" align="left" valign="top" class="bodytext3"><strong>Sample Doc No</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3"><?php echo $sampleDocNumber; ?></td>
				  </tr>
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                 <td align="left" class="bodytext3" valign="top" >&nbsp;</td>
                 <td align="left" class="bodytext3" valign="top" ><strong>Priliminay</strong></td>
                 <td align="left" class="bodytext3" valign="top" ><?php echo $priliminary2;?></td>

                 <td align="left" class="bodytext3" valign="top" ><strong>Equipment</strong></td>
                 <td align="left" class="bodytext3" valign="top" ><?php echo $equipmentname;?></td>
                 
				  </tr>
                  <tr>
                  <td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td>
                  </tr>
            </tbody>
        </table></td>
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

				   $number_word=array('eth','First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth','Eleventh','Twelveth','Thirteenth','Fourteenth','Fifteenth','Sixteenth','Seventeenth','Eighteenth','Nineteenth','Twentieth');

				  $query_rowss = "SELECT * from audit_resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode LIKE '%$itemcode%'   and docnumber='$docnumber_get' group by audit_id,itemcode,recorddate order by itemcode,recorddate DESC";
					$exec_rowss = mysqli_query($GLOBALS["___mysqli_ston"], $query_rowss) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  				$res_rowss=mysqli_fetch_array($exec_rowss);
	  				$num_edits=mysqli_num_rows($exec_rowss);
			   		$labname1=$res_rowss['itemname'];
			   		?>

			   		<tr>
						<!-- <td  style="padding: 5px;" colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>Results</strong></td> -->

						<td  style="padding: 5px;" colspan="<?php echo ($num_edits*3)+1;?>" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>Test Name : <?php echo $labname1; ?></strong></td>
						<input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
						<input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
						</tr>

						<tr>
				   		    <td rowspan="2"  width="5%" class="bodytext366" valign="center"  align="left" bgcolor="#ffffff"><div align="left"><strong>Reference</strong></div></td>
				   		    <?php
				   		    $num_edits;
				   		    for($i=1;$i<=$num_edits;$i++){ //
									$showcolor_new = ($i & 1); 
									if ($showcolor_new == 0){ $colorcode_new = 'bgcolor="#7FFFD4"'; }
									else {  $colorcode_new = 'bgcolor="#F0F8FF"'; }

									if($i<=20){
										$ii=$number_word[$i];
									}else{
										$ii=$i;
									}

									if($i==1){
										$ii='Original';
									}


									// $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
										// echo $f->format($i);
													
				   		    ?>
				   		    <td colspan="3" width="5%" class="bodytext366" valign="center"  align="center" <?=$colorcode_new;?>><div align="center"><strong><?php echo $ii;?></strong></div></td>
				   			<?php }  ?>

			   		   	<tr>
				   		    <!-- <td width="5%" class="bodytext366" valign="center"  align="left" bgcolor="#ffffff"><div align="left"><strong></strong></div></td> -->
				   		    <?php
				   		    $num_edits;//FAEBD7
				   		    for($i=1;$i<=$num_edits;$i++){
				   		    	$showcolor_new = ($i & 1); #
									if ($showcolor_new == 0){ $colorcode_new = 'bgcolor="#8FBC8F"'; }
									else {  $colorcode_new = 'bgcolor="#DEB887"'; }
				   		    ?>

				   		    <td width="5%" class="bodytext366" valign="center"  align="center" <?=$colorcode_new;?>><div align="center"><strong>Date</strong></div></td>
				   		    <td width="5%" class="bodytext366" valign="center"  align="center" <?=$colorcode_new;?>><div align="center"><strong>value</strong></div></td>
				   		    <td width="5%" class="bodytext366" valign="center"  align="center" <?=$colorcode_new;?>><div align="center"><strong>User</strong></div></td>
				   			<?php } ?>
		  				</tr>

			   		<?php

				$query31 = "SELECT * from audit_resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode LIKE '%$itemcode%'   and docnumber='$docnumber_get' group by referencename  order by itemcode,recorddate DESC";
				 
				//echo "query31 ".$query31;
				$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  
	  while($res31=mysqli_fetch_array($exec31))
	  { 
	   $labname1=$res31['itemname'];
	   $recorddate = $res31['recorddate'];
	   $recorddate = date('Y-m-d',strtotime($recorddate));
	   $labitemcode = $res31['itemcode'];
		$docnumber= $res31['docnumber'];
		$sampleid= $res31['sampleid'];
		$username= $res31['username'];
		$referencename= $res31['referencename'];
		$resultvalue= $res31['resultvalue'];
        
				   
				$subTRcolorloopcount = $subTRcolorloopcount + 1;
				$subTRshowcolor = ($subTRcolorloopcount & 1); 
				if ($subTRshowcolor == 0)
				{
					//echo "if";
					$subTRcolorcode = 'bgcolor="#CBDBFA"';
					// $subTRcolorcode = 'bgcolor="#EFEFEF"';
				}
				else
				{
					//echo "else";
					$subTRcolorcode = 'bgcolor="#ecf0f5"';
					// $subTRcolorcode = 'bgcolor="#cbdbfa"';
				}
						   ?> 
						     <tr <?php echo $subTRcolorcode; ?>>
							 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="211"><div class="bodytext311">  
				   <?php echo $referencename ?>
				  </div></td>
				  	<?php 
				  	$num_edits;
				  		    	$query1_new = "SELECT * from audit_resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode LIKE '%$itemcode%'   and docnumber='$docnumber_get' and referencename='$referencename' group by audit_id,referencename  order by itemcode,recorddate DESC";
								$exec1_new = mysqli_query($GLOBALS["___mysqli_ston"], $query1_new) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
								while($res1_new=mysqli_fetch_array($exec1_new))
								{ 
									 $audit_id= $res1_new['audit_id'];
									 

				   		    // for($i=1;$i<=$num_edits;$i++){
				   		    	$query_final = "SELECT * from audit_resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode LIKE '%$itemcode%'   and docnumber='$docnumber_get' and referencename='$referencename' and audit_id='$audit_id' group by referencename ";
								$exec_final = mysqli_query($GLOBALS["___mysqli_ston"], $query_final) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
								// $res_final=mysql_fetch_array($exec_final);
								while($res_final=mysqli_fetch_array($exec_final)){
									$username= $res_final['username'];
									$resultvalue= $res_final['resultvalue'];
							        $recorddate = $res_final['datetime'];
							    }

							    $showcolor_new = ($i & 1); 
									if ($showcolor_new == 0){ $colorcode_new = 'bgcolor="#7FFFD4"'; }
									else {  $colorcode_new = 'bgcolor="#F0F8FF"'; }
							    
				  	?>
                  <td  align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center"> <?php echo  $recorddate; ?>  </td>
                  <td  align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center"> <?php echo $resultvalue; ?>  </td>
                  <td  align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center"> <?php echo $username; ?>  </td>
                  <?php  // } 
              			}  ?>
 
              </tr>
		 <?php
		 }
		 ?>
		  <tr>
		  	<td colspan="1" class="bodytext365" bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
		  	<td colspan="<?=$num_edits*3;?>" class="bodytext365" bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
		  </tr>
				  
			 
      <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name: 
               <input name="user" type="hidden" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"><?php echo strtoupper($_SESSION['username']); ?></td>
          </tr>
			   <!-- <tr> 
              <td colspan="7" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                     <input name="Submit2223" type="submit" value="Print" onClick="return acknowledgevalid()"  accesskey="b" class="button"/>
               </td>
          </tr> -->
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
