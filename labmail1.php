<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");
require("phpmailer/class.phpmailer.php");
$updatedatetime = date("Y-m-d H:i:s");
 $todate = date ("d-m-Y H:i:s"); 
$server=$_SERVER['SERVER_NAME'];
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];	
$sno = '';
$message='';


if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }
/*if (isset($_REQUEST["ADate1"])) { echo $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }*/
if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; } 
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; } 
if (isset($_REQUEST["billdate"])) { $billdate = $_REQUEST["billdate"]; } else { $billdate = ""; } 
?>
<script type="text/javascript">
function checkEmail() {

    var email = document.getElementById('tomail').value;
	var email1=email.split(',');
	for(var i=0; i<email1.length;i++)
	{
		//alert(email1[i]);
//var x = document.forms["myForm"]["email"].value;
    var atpos = email1[i].indexOf("@");
    var dotpos = email1[i].lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email1[i].length) {
		
        alert("Not a valid e-mail address");
        return false;
	}
	}
}

function viewmail(patientcode,visitcode,billdate,itemcode)
{
	var mail=document.getElementById('tomail').value;
	if(mail!='')
	{
	var varpatientcode = patientcode;
	var varvisitcode = visitcode;
	var billdate = billdate;
	var itemcode = itemcode;
	
	
	//alert(billnumber);
NewWindow=
window.open('labmail.php?patientcode='+varpatientcode+'&&visitcode='+varvisitcode+'&&billdate='+billdate+'&&itemcode='+itemcode+'&&mailid='+mail,'Window1','width=450,height=200,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
}
else
alert("Please Enter Mail ID");
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<body>

<table width="600" cellspacing="2"  cellpadding="2" align="left">
<tr>
<td width="48">To</td><td width="161"><input type="email" name="tomail" id="tomail"  size="35"/></td>
<td width="369"  align="left" valign="center" class="style2"><div align="left"><a href="javascript:viewmail('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $billdate; ?>','<?php echo $itemcode; ?>')"><button onClick=" return checkEmail()"> Send</button></a></div>
</tr>
<tr>
<td>&nbsp;</td>
 
			   </td>
</tr>
</table>

</body>
<?php

$mail = new PHPMailer();

// Set up SMTP  
$mail->IsSMTP();                // Sets up a SMTP connection  
$mail->SMTPAuth = true;         // Connection with the SMTP does require authorization    
$mail->SMTPSecure = "ssl";      // Connect using a TLS connection  
$mail->Host = "smtp.gmail.com";  //Gmail SMTP server address
$mail->Port = 465;  //Gmail SMTP port
$mail->Encoding = '7bit';
$mail->SMTPDebug  = 2;

// Authentication  
$mail->Username   = "karunasivaguru23@gmail.com"; // Your full Gmail address
$mail->Password   = "kalpana23"; // Your Gmail password

$imglink='https://www.google.co.in/search?q=nakasero+image&tbm=isch&imgil=yCold-if1uXSJM%253A%253BKda-9QVPda7mwM%253Bhttp%25253A%25252F%25252Fwww.livinginkampala.com%25252Farea-guides%25252Fliving-in-nakasero%25252F&source=iu&pf=m&fir=yCold-if1uXSJM%253A%252CKda-9QVPda7mwM%252C_&biw=1600&bih=799&usg=__k1KGCtk1vKyLlYsj2boUVJnk2ds%3D&ved=0ahUKEwiK0sG94O7JAhUBA44KHZxyB2oQyjcILw&ei=FOJ4Vor4CoGGuASc5Z3QBg#tbm=isch&q=nakasero+mission+hospital&imgrc=eKuVldDVzMnwIM%3A';

 $query341 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultentry = 'completed' ";
$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res341 = mysqli_fetch_array($exec341))
{
$labitemcode34 = $res341['labitemcode'];


	 $query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode = '$labitemcode34' ";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res612 = mysqli_fetch_array($exec612);
$orderedby = $res612['username'];
$Patientname=$res612['patientname'];
$accountname=$res612['accountname'];
if($accountname =='')
{
	$accountname='SELF';
}
$accountcode='';
$doctor='';
$locationname=$res612['locationname'];
$docnumber=$res612['resultdoc'];
$samplecollectedon=$res612['consultationdate'];
//$dob = $res612['dateofbirth'];
$billdatetime = $res612['sampledatetime'];
$sampleid = $res612['sampleid'];
$res38publisheddatetime = $res612['publishdatetime'];

$query613 = "select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' ";
$exec613 = mysqli_query($GLOBALS["___mysqli_ston"], $query613) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res613 = mysqli_fetch_array($exec613);
$docno = $res613['docnumber'];

$reviewedby=$res613['doctorname'];


$query123 = "select * from samplecollection_lab where patientcode = '$patientcode' and sampleid = '$sampleid' ";
$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res123 = mysqli_fetch_array($exec123);
$res123recordtime=$res123['recordtime'];
$res123recorddate=$res123['recorddate'];
 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$faxnumber1 = $res2["faxnumber1"];
$cstnumber1 = $res2["cstnumber"];

$location= $locationname;

$query8="select * from master_employee where username = '$username' ";
$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
$num8=mysqli_num_rows($exec8);
$res8=mysqli_fetch_array($exec8);
$res8jobdescription=$res8['jobdescription'];

if($patientcode != 'walkin')
{
$query5 = "select * from master_customer where customercode = '$patientcode'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$area12 = $res5['area'];
$fileno5 = '';
$patientage=$res5['age'];
$patientgender=$res5['gender'];
$dob = $res5['dateofbirth'];
}
else
{
$query77 = "select * from consultation_lab where resultdoc = '$docnumber'";
$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res77=mysqli_fetch_array($exec77);
$billnumber=$res77['billnumber'];
$locationcode=$res78['locationcode'];

$query771 = "select * from billing_external where billno = '$billnumber'";
$exec771=mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res771=mysqli_fetch_array($exec771);
$patientage=$res771['age'];
$patientgender=$res771['gender'];
$dob = '0000-00-00';
}

if($dob != '0000-00-00')
{
	$today = new DateTime();
    $diff = $today->diff(new DateTime($dob));
	$diff1 = $diff->format('%y||%m||%d');
	$dayssplit = explode('||',$diff1);
	$year = $dayssplit[0];
	if($year > 1){ $yearname = 'Years'; } else { $yearname = 'Year'; }
	$month = $dayssplit[1];
	if($month > 1){ $monthname = 'Months'; } else { $monthname = 'Month'; }
	$day = $dayssplit[2];
	if($day > 1){ $dayname = 'Days'; } else { $dayname = 'Day'; }
	if($year == 0 && $month != 0)
	{
		$dob1 = $month.' '.$monthname.' '.$day.' '.$dayname;
	}
	else if($year == 0 && $month == 0)
	{
		$dob1 = $day.' '.$dayname;
	}	
	else if($year != 0 && $month != 0)
	{
		$dob1 = $year.' '.$yearname.' '.$month.' '.$monthname;
	}
	else
	{
		$dob1 = $year.' '.$yearname;
	}
}
else
{
$dob1 = $patientage;
}	

	
	$message  = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>Lab  </td></tr>";
	$message .= "</table>";
	
	$message.='<table cellspacing="0" cellpadding="1" border="0">';
	$message.='<tr><td width="150" valign="top" rowspan="6">';
				$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
				$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3showlogo = mysqli_fetch_array($exec3showlogo);
				$showlogo = $res3showlogo['showlogo'];
				if ($showlogo == 'SHOW LOGO')
				{
	  
	 $message.='<img src='.$imglink.' width="65" height="65" />';
	 
	   			 }
	 $message.='</td>'; 
	 $message.='<td width="430" align="center" class="bodytext21" style="font-size:16px">';
	 
				 $strlen3 = strlen($address1);
				  $totalcharacterlength3 = 35;
				  $totalblankspace3 = 35 - $strlen3;
				  $splitblankspace3 = $totalblankspace3 / 2;
				  for($i=1;$i<=$splitblankspace3;$i++)
				  {
				   $address1 = ' '.$address1.' ';
				  }
	  
	 $message.="<strong> $companyname </strong></td>";
	 $message.='<td width="150" valign="top" rowspan="6" align="right">';
	 
	  $query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
	  $exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $res3showlogo = mysqli_fetch_array($exec3showlogo);
	  $showlogo = $res3showlogo['showlogo'];
	  if ($showlogo == 'SHOW LOGO')
	  {
	  
	$message.='<img src='.$imglink.' width="65" height="65" />';
	  
	  }
	 $message.='</td></tr>'; 
	
	$message.='<tr><td width="430" align="center" class="printbodytext22" style="font-size:15px"><strong>ISO 15189 ACCREDITED</strong></td></tr>';
	
	
			 $address2 = $area.''.$pincode.' '.$city;
			 $strlen3 = strlen($address2);
			 $totalcharacterlength3 = 35;
			 $totalblankspace3 = 35 - $strlen3;
			 $splitblankspace3 = $totalblankspace3 / 2;
			 for($i=1;$i<=$splitblankspace3;$i++)
			 {
			  $address2 = ' '.$address2.' ';
			 }
	
			 $address3 = "Tel: ".$phonenumber1.' '.$phonenumber2;
			 $strlen3 = strlen($address3);
			 $totalcharacterlength3 = 35;
			 $totalblankspace3 = 35 - $strlen3;
			 $splitblankspace3 = $totalblankspace3 / 2;
			 for($i=1;$i<=$splitblankspace3;$i++)
			 {
			 $address3 = ' '.$address3.' ';
			 }
	$message.="<tr><td width='430' align='center' class='bodytext23' style='font-size:13px'>".$address2.''.$address3."</td></tr>";
   
  	$message.='<tr><td width="430" align="center" class="bodytext24" style="font-size:13px">';
	 
	 $address5 = "Fax: ".$faxnumber1;
	 $strlen3 = strlen($address5);
	 $totalcharacterlength3 = 35;
	 $totalblankspace3 = 35 - $strlen3;
	 $splitblankspace3 = $totalblankspace3 / 2;
	 for($i=1;$i<=$splitblankspace3;$i++)
	 {
	  $address5 = ' '.$address5;
	 }
	 
	 $address4 = " E-Mail: ".$emailid1;
	 $strlen3 = strlen($address4);
	 $totalcharacterlength3 = 35;
	 $totalblankspace3 = 35 - $strlen3;
	 $splitblankspace3 = $totalblankspace3 / 2;
	 for($i=1;$i<=$splitblankspace3;$i++)
	 {
	  $address4 = ' '.$address4.' ';
	 }
	$message.=  $address5.','.$address4. '</td> </tr>';
  
  $message.=  '<tr><td width="430" align="center">&nbsp;</td></tr>';
  $message.=  '<tr><td width="430" align="center" style="font-size:12px;"><strong> '.$location.'&nbsp;</strong></td></tr>';
  $message.= '<tr><td colspan="3" align="center" class="bodytext26"><strong>&nbsp;</strong></td> </tr>';
  $message.=  '</table>';
  
  
$message.= '<table cellspacing="4" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
   <tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Patient</strong></td>
	<td width="230" align="left" valign="top" class="bodytext27"> '. $Patientname .
	'&nbsp;
	';
	if($patientcode !="") {
		  "('.$patientcode.')" ; 
		  }
$message.= '</td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Lab No</strong> </td>
	<td width="165" align="left" valign="top" class="bodytext27">
	'. $docnumber.'</td>
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Collected On</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27">'. date("Y-M-d g:i:A",strtotime($samplecollectedon)) .'</td>
   </tr><tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Age</strong></td>
	<td width="230" align="left" valign="top" class="bodytext27"> '.$dob1.'</td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Doctor</strong></td>
	<td width="165" align="left" valign="top" class="bodytext27">'.$doctor.'</td>
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Sample Rcvd </strong></td>
	<td width="130" align="left" valign="top" class="bodytext27">'.date("Y-M-d g:i:A",strtotime($billdatetime)).'</td>
	</tr>
	<tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
	<td width="230" align="left" valign="top" class="bodytext27">'. substr($patientgender, 0, 1).'</td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Account</strong></td>
	 
	              
	<td width="165" align="left" valign="top" class="bodytext27">'.$accountname.' </td>';
	
	
$message.='	
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Reported On</strong></td>
<td width="130" align="left" valign="top" class="bodytext27">'.date("Y-M-d",strtotime($res123recorddate))."".date("g:i:A",strtotime($res123recordtime)).'</td>
  </tr>';

$message.='<tr>';
	 if($accountcode != "") { 
	 $message.='
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
	<td width="230" align="left" valign="top" class="bodytext27">'. $accountcode.'</td>';
	} else {
	$message.='<td width="50" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>';
	} 	  
	$message.='<td width="50" align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
	<td width="165" align="left" valign="top" class="bodytext27">'.$area12.'</td>	
	<td width="80" align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27">'.$fileno5.'</td>	
   </tr>	';
   
   $message.='<tr>
   <td width="50" align="left" valign="top" class="bodytext27">&nbsp;
        </td>
        <td width="50" align="left" valign="top" class="bodytext27">&nbsp;
        </td>
        <td width="50" align="left" valign="top" class="bodytext27">&nbsp;
        </td>
        <td width="50" align="left" valign="top" class="bodytext27">&nbsp;
        </td>
   		<td width="50" align="left" valign="top" class="bodytext27"><strong>
        	Reviewed By</strong>
        </td>
        <td>
		'.$reviewedby.'
        </td>
   </tr>  </table>';
   
   $message.='<table border="0" cellspacing="0" cellpadding="2">
	<tr>
	 <td colspan="6" align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31"><strong>Pending Tests :</strong></td>
	</tr>';
	
	$labpending = "";
	$query68 = "select * from consultation_lab where patientcode = '$patientcode' and patientcode <> 'walkin' and patientvisitcode = '$visitcode' and resultentry <> 'completed' ";
	$exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res68 = mysqli_fetch_array($exec68))
	{
	$labitemnamepending = $res68["labitemname"];
	if($labpending == "") {
	$labpending = $labitemnamepending; 
	} else { 
	$labpending = $labpending.",  ".$labitemnamepending;
	}
	}
	
	
   $message.='<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31"><strong>'.$labpending.'</strong></td>
	</tr>
	<tr>
	 <td colspan="6" align="center" valign="top" style="font-size:16px; text-decoration:underline;"><strong>Laboratory Report</strong> </td>
	</tr>
	<tr>';
	
	$message.='<tr>
	 <td width="178" align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="91"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="51"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="55"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="170" align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="171" align="left" valign="top" class="bodytext27">&nbsp;</td>
	</tr>';
	
	$message.='<tr>
	 <td width="178" align="left" valign="top" class="bodytext27"><strong>TESTS</strong></td>
	 <td width="91"  align="left" valign="top" class="bodytext27"><strong>RESULTS</strong></td>
	 <td width="51"  align="left" valign="top" class="bodytext27"><strong>UNIT</strong></td>
	 <td width="55"  align="left" valign="top" class="bodytext27"><strong>CRITICAL</strong></td>
	 <td width="170" align="left" valign="top" class="bodytext27"><strong>REFERANCE RANGE</strong></td>
	 <td width="171" align="left" valign="top" class="bodytext27"><strong>COMMENTS</strong></td>
	</tr>';
	
	$pagecount="";
	$itemnumbers=0;
	$referencenumbers=0;
	
	$query616 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode = '$labitemcode34'";
	$exec616 = mysqli_query($GLOBALS["___mysqli_ston"], $query616) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res616 = mysqli_fetch_array($exec616))
	{
	$res616itemcode = $res616["labitemcode"];
	$res616itemname = $res616["labitemname"];
	
	
	$message.='<tr>
		<td colspan="6" align="left" valign="top" class="bodytext31"><strong>'.$res616itemname.'</strong></td>
	</tr>
	<tr>
		<td colspan="6" align="left" valign="top" class="bodytext31"><strong>&nbsp;</strong></td>
	</tr>
	';
	 	$query34="select * from master_labreference where itemcode = '$res616itemcode' and status <> 'deleted' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto ";
	 $exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	 $num34=mysqli_num_rows($exec34);
	while($res34=mysqli_fetch_array($exec34))
	{
	$subheader = $res34["subheader"];
	
	$message.='<tr>
		<td colspan="6" align="left" valign="top" class="bodytext31"><strong>'. $subheader.'</strong></td>
	</tr>';
	
	$query38="select * from master_labreference where itemcode = '$res616itemcode' and subheader = '$subheader' and status <> 'deleted' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto order by reforder ";
	$exec38=mysqli_query($GLOBALS["___mysqli_ston"], $query38);
	$num38=mysqli_num_rows($exec38);
	while($res38=mysqli_fetch_array($exec38))
	{
	$referencename1=$res38["referencename"];
	
	$query32="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and referencename = '$referencename1' and itemcode = '$res616itemcode'  order by auto_number ";
	$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	$num32=mysqli_num_rows($exec32);
	$res32=mysqli_fetch_array($exec32);
	$resultvalue=$res32["resultvalue"];
	//$resultvalue = str_replace('<','&lt;',$resultvalue);
	//$resultvalue = str_replace('>','&gt;',$resultvalue);
	
	//$sampletype = $res32["sampletype"];
	$referencename=$res32["referencename"];
	$referencerange=$res32["referencerange"];
	$referenceunit=$res32["referenceunit"];
	//$referenceunit="";
	//$referenceunit = str_replace("\n","",$referenceunit);
	//$referenceunit = str_replace(">","&gt;",$referenceunit);
	$res12referencename = $res32["referencename"];
	$color = $res32["color"];
	if($color == "red") { $crit = "H"; }
	else if($color == "orange") { $crit = "L"; }
	else if($color == "green") { $crit = "N"; }
	else { $crit = ""; }
	$refcomments = $res32["referencecomments"];
	$referencenumbers = $referencenumbers + 1;
	
   
   $message.='<tr>
	 <td width="173" align="left" valign="top" class="bodytext31">'. $res12referencename .'</td>
	 <td width="91" align="left" valign="top" class="bodytext31">'.$resultvalue.'</td>
	 <td width="51" align="left" valign="top" class="bodytext31">'.$referenceunit.'</td>
	 <td width="55" align="center" valign="top" class="bodytext31"><strong>'.$crit.'</strong></td>
	 <td width="170" align="left" valign="top" class="bodytext31">'.$referencerange.'</td>
	 <td width="171" align="left" valign="top" class="bodytext31">'.$refcomments.'</td>
	</tr>';
	
	  } 
	$res38comment = "";
		 }
	}
	
	
	$message.='	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
</table> ';


$message.='<table border="0" cellspacing="0" cellpadding="2">
   <tr>
     <td width="247">REVIEWED :&nbsp;&nbsp;------------------------------</td>
     <td width="242">SIGNATURE:&nbsp;&nbsp;------------------------------</td>
     <td width="240">DATE:&nbsp;&nbsp;------------------------------</td>
   </tr>';
   
   $message.=' <tr>
     <td width="247"><strong>Quality Manager/Laboratory Director</strong></td>
     <td width="242"><strong>LAB TECHNOLOGIST</strong> </td>
     <td width="240">Printed By: '.strtoupper($res8jobdescription).'</td>
   </tr>
   <tr>
     <td width="247">Reviewed By:&nbsp;'.strtoupper($res8jobdescription).'</td>
     <td width="242">Acknowledged By:&nbsp;'.strtoupper($res8jobdescription).'</td>
    <td width="240">Printed On:'.date("Y-M-d g:i:A",strtotime($updatedatetime)).'</td>
   </tr>';
   
   $message.=' <tr>
     <td width="247">&nbsp;</td>
     <td width="242">&nbsp; </td>
     <td width="240">&nbsp;</td>
   </tr>
</table>';

$message.='<table border="0" cellspacing="0" cellpadding="2" id="footer">
  <tr>
    <td width="745" align="center" valign="top" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td width="745" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
  </tr>
</table>

';

}

/*
	echo $bamailfrom.','.$bamailcc.','.$piemailfrom.','.$username;
	$mail->AddAddress($mailid);
	$mail->AddCC('');
	$mail->SetFrom('karunasivaguru23@gmail.com',$username);
	$mail->Subject = " Indent From ";
	$mail->IsHTML(true);
	$mail->Body = "Purchase Indent".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;	   
	}
	else
	{
	   echo "Letter sent";	   
	}*/
?>
<tr align="center">
<td align="center"><?php 
echo $message; ?>
</td>
</tr>

