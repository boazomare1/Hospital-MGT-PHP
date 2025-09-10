<?php
session_start();
error_reporting(0);
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
$titlestr = 'SALES BILL';



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientname=$_REQUEST['customername'];
$billnumber=$_REQUEST['billnumber'];
$dateonly = date("Y-m-d");
$billnumbercode = $_REQUEST['docnumber'];

$billtype = $_REQUEST['billtype'];
$accountname = $_REQUEST['accountname'];


foreach($_POST['radiology'] as $key => $value)
		{
			
		$u1=0;
		if($_POST['urgent'][$key])
		{$u1=1;}
		
		$radiologyname=$_POST['radiology'][$key];
		$itemcode=$_POST['code'][$key];
		$radno =$_POST['radno'][$key];
		 $comments=$_POST['comments'][$key]; 
		if(isset($_POST['ack']))
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow == $radno)
		{
		$status='completed';
		$status2='norefund';
		break;
		}
		else
		{
		$status='pending';
		}
	}
		foreach($_POST['ref'] as $check1)
	{
	$refund=$check1;
	if($refund == $radno)
	{
	$status1='refund';
	$status2='refund';
	$status='completed';
	break;
	}
	else
	{
	$status1='norefund';
	}
	}
	

		
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($radiologyname != "")
   {
   
   
  

//image part start
if($_FILES['image']['name'][$key]){
   //  echo "hii";
	 // $errors= array();
      $file_name = $_FILES['image']['name'][$key];
     /* $file_size =$_FILES['image']['size'][$key];
      $file_tmp =$_FILES['image']['tmp_name'][$key];
      $file_type=$_FILES['image']['type'][$key];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'][$key])));
      $filename="extradio";*/
   //   $expensions= array("jpg");
      
     
      
   
     /*    
		 
		 $query612 = "select * from consultation_radiology  where billnumber='$billnumber' and radiologyitemname='$radiologyname' and auto_number='$radno'"; 
$exec612 = mysql_query($query612) or die(mysql_error());
$res612 = mysql_fetch_array($exec612);
$anum = $res612['auto_number'];

move_uploaded_file($file_tmp,"temp/".$filename.$anum.".".$file_ext);

$file ="temp/".$filename.$anum.".".$file_ext;


   include ("ftplogin.php"); 
           
    ftp_pasv($connection, true);

  $source = $file;
  
    $dest = "/".$filename.$anum.".".$file_ext;
    //$x = substr($dest,-4);
    // echo $x;</p>

   $upload = ftp_put($connection, $dest, $source, FTP_BINARY);
    if (!$upload) { die('upload failed!'); }
	 else {
	    ftp_close($connection); //
		 unlink($file);*/
		 $query123="update consultation_radiology set  imgaquistatus='$status',imagefilename='$file_name' where billnumber='$billnumber' and radiologyitemname='$radiologyname' and auto_number='$radno'"; 
		//   mysql_query("update consultation_radiology set  imgaquistatus='$status',imagefilename='$filename$anum"."$file_ext' where billnumber='$billnumber' and radiologyitemname='$radiologyname' and auto_number='$radno'");

mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      //   echo "Success";
	header("location:imageaquisition.php");
       exit();
		 
		 
		 
     
   }   //image part


  }

}

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
function disableafterclick (varserialnumber3)
 {
var varserialnumber3 = varserialnumber3;
document.getElementById("Class"+varserialnumber3+"").disabled = true;
}



function acknowledgevalid()
{

var chks = document.getElementsByClassName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}


var chks1 = document.getElementsByClassName('ref[]');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;

//alert(document.getElementById('comments'+(j+1)).value);
if(document.getElementById('comments'+(j+1)).value=="")
{
	alert("Please enter remarks");
	document.getElementById('comments'+(j+1)).focus();
	return false;
}

}
}



if (hasChecked == false && hasChecked1 == false)
{
alert("Please either acknowledge/refund a sample  or click back button on the browser to exit sample collection");
return false;
}
return true;
}

function makeDisable1(varserialnumber3)
 {
 var varserialnumber3 = varserialnumber3;
 
 if(document.getElementById("Class"+varserialnumber3+"").checked == true)
{
var x = document.getElementById("Class"+varserialnumber3+"");
x.disabled=true
}


}
	
function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{
document.getElementById("Class"+varserialnumber+"").style.visibility = 'visible';

document.getElementById("ref"+varserialnumber+"").disabled = true;
document.getElementById("urgent"+varserialnumber+"").disabled = false;

}
else
{
document.getElementById("Class"+varserialnumber+"").style.visibility = 'hidden';
document.getElementById("ref"+varserialnumber+"").disabled = false;
document.getElementById("urgent"+varserialnumber+"").disabled = true;
if(document.getElementById("urgent"+varserialnumber+"").checked==true)
{
	document.getElementById("urgent"+varserialnumber+"").checked=false;
	}

}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{
document.getElementById("ack"+varserialnumber1+"").checked = false;
document.getElementById("ack"+varserialnumber1+"").disabled = true;
document.getElementById("urgent"+varserialnumber1+"").disabled = true;
document.getElementById("comments"+varserialnumber1+"").style.display='block';

if(document.getElementById("urgent"+varserialnumber1+"").checked==true)
{document.getElementById("urgent"+varserialnumber1+"").checked=false;}

}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
document.getElementById("urgent"+varserialnumber1+"").disabled = false;
	document.getElementById("comments"+varserialnumber1+"").style.display = 'none';

}
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
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
select { visibility:hidden; }
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
</style>

<script src="js/datetimepicker_css.js"></script>
<script src="jquery/jquery-1.11.3.min.js"></script>

<?php
$billnumber = $_REQUEST["billnumber"];
$query55="select * from consultation_radiology where billnumber='$billnumber'";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$patientname=$res55['patientname'];

$locationname=$res55['locationname'];
 $locationcode=$res55['locationcode'];
 $billtype=$res55['billtype'];
 $accountname=$res55['accountname'];
 

$query66="select * from billing_external where billno='$billnumber'";
$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66=mysqli_fetch_array($exec66);
$age=$res66['age'];
$gender=$res66['gender'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'ERRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from resultentry_radiology where patientcode = 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumbers = $res2["docnumber"];
$billdigit=strlen($billnumbers);
if ($billnumbers == '')
{
	$billnumbercode ='ERRE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumbers = $res2["docnumber"];
	$billnumbercode = substr($billnumbers,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ERRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="externalradiologyimgentry.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
             <tr bgcolor="#ecf0f5">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
	  <td width="30%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" type="hidden" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="42%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
                <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Location </strong></td>
				
                 
                
                <td width="42%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $locationname;?>
                <input type="hidden">
                </td>
              </tr>
			 
		
			 
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $age; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $gender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $gender; ?>
				     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="billnumber" id="billnumber" type="hidden" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $billnumber; ?>
				
				</td>
			
              	  </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Doc Number</strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?>
				<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;	</td>
			
              	  </tr>
			   
			   
				  <tr>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
            <td width="15%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
				
					<td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Upload Image</strong></div></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;			
			$query61 = "select * from consultation_radiology where billnumber='$billnumber' and resultentry='pending' and prepstatus='completed'  and imgaquistatus='pending' ";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
while($res61 = mysqli_fetch_array($exec61))
{
$radiologyname =$res61["radiologyitemname"];
$radautono = $res61['auto_number'];
$query68="select * from master_radiology where itemname='$radiologyname'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$itemcode=$res68['itemcode'];
$sno = $sno + 1;
?>
  <tr>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radiologyname;?></div></td>
		<input type="hidden" name="radiology[<?php echo $sno; ?>]" value="<?php echo $radiologyname;?>">
		<input type="hidden" name="code[<?php echo $sno; ?>]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="radno[<?php echo $sno; ?>]" value="<?php echo $radautono; ?>">
		   <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" class="ack[]" name="ack[<?php echo $sno; ?>]" value="<?php echo $radautono; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
		
				
			  <td class="bodytext31" valign="center"  align="left"><div align="center" class="checkcomment">
			  <input type="file" name="image[<?php echo $sno; ?>]" id="image<?php echo $sno; ?>"  >
			 </div></td>
              
		  
              
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
				  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
           
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" />
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>