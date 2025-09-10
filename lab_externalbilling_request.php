<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("d/m/Y");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';
 $docno = $_SESSION['docno'];
						
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
}
						
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select consultationid as billnumber from consultation_lab where consultationid like 'EB-%' order by auto_number desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
if($res2["billnumber"]=='')
{
$res2 = mysqli_fetch_array($exec2);
}
 $billnumber = $res2["billnumber"]; 
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1'."-".date('y');
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
		//get locationcode and locationname here for insert
		$locationcodeget=$_REQUEST['locationcodeget'];
		$locationnameget=$_REQUEST['locationnameget'];
		//get locationcode ends here
		$billnumber=$billnumbercode;
		$consultationid=$billnumber;
		$billdate=$_REQUEST['billdate'];
		$referalname=$_REQUEST['referalname'];
		$billingtype = $_REQUEST['billtype'];
		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender']; 
		$visitcode=$_REQUEST['visitcode'];
		$patientcode=$_REQUEST['patientcode'];
		$accountname=$_REQUEST['accountname'];
		$timestamp=date('H:i:s');
		$totalamount=$_REQUEST['total2'];
		$approvalstatus='';
	    $approvalvalue='';
	if($billingtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	   //$status='completed';
	   $status='pending';
	   $approvalstatus='1';
	   $approvalvalue=1;
	}
			$billnumbercode='';
 $query3 = "select labrefnoprefix from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labrefnoprefix = $res3['labrefnoprefix'];
$labrefnoprefix1=strlen($labrefnoprefix);
$query2 = "select refno from consultation_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$labrefnonumber = $res2["refno"];
$billdigit=strlen($labrefnonumber);
if ($labrefnonumber == '')
{
	$labrefcode =$labrefnoprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$labrefnonumber = $res2["refno"];
	$labrefcode = substr($labrefnonumber,$labrefnoprefix1, $billdigit);
	$labrefcode = intval($labrefcode);
	$labrefcode = $labrefcode + 1;
	$maxanum = $labrefcode;
	$labrefcode = $labrefnoprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
		
if(isset($_POST['dis']) && count($_POST['dis'])>1){
		foreach($_POST['dis'] as $key=>$value)
		{
	    $pairs111 = $_POST['dis'][$key];
		$pairvar111 = $pairs111;
		$pairs112 = $_POST['code'][$key];
		$pairvar112 = $pairs112;
		$pairs113 = $_POST['dis1'][$key];
		$pairs114 = $_POST['code1'][$key];
		
		$icdquery = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_icd where disease = '$pairvar111'"); 
		$execicd = mysqli_fetch_array($icdquery);
		$diseasecode = $execicd['icdcode'];
		
		if($pairvar111 != "")
		{
		
		$icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accountname','$currentdate','$timestamp','$pairs111','$pairs112','$pairs113','$pairs114','$locationnameget','$locationcodeget')";
		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		}
		}
		}
		else{
			    $pairs111='Examination and observation for other reasons';
		        $pairs112='Z04';
              $icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accountname','$currentdate','$timestamp','$pairs111','$pairs112','','','$locationnameget','$locationcodeget')";
		     $execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		foreach($_POST['lab'] as $key=>$value)
		{ 
				    //echo '<br>'.$k;
		 count($_POST['lab']); 
		$labname=$_POST['lab'][$key];
		//$labquery=mysql_query("select itemcode from master_lab where itemname='$labname' and status <> 'deleted'");
		//$execlab=mysql_fetch_array($labquery);
		//$labcode=$execlab['itemcode'];
		$labcode=trim($_POST['labitemcode'][$key]);
		
		$labrate=$_POST['rate5'][$key];
		
			if($labcode!="")
			{
	
		  $query001="insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,billnumber,refno,labsamplecoll,resultentry,labrefund,urgentstatus,consultationtime,username,locationname,locationcode,approvalstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$billingtype','$accountname','$currentdate','$status','$consultationid','$labrefcode','pending','pending','norefund','$urgentstatus','$timestamp','$username','$locationnameget','$locationcodeget','$approvalstatus')"; 
			 $labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
			}
        		
		}
		
			//	mysql_query("insert into billing_external_request(billno,patientname,patientcode,visitcode,totalamount,billdate,age,gender,username,locationname,locationcode,bankrefno,banktrnno,billtime)values('$consultationid','$patientfullname','$patientcode','$visitcode','$totalamount','$currentdate','$age','$gender','$username','".$locationnameget."','".$locationcodeget."','$billnumbercode','','".date('H:i:s')."')") or die(mysql_error());	
		if($totalamount>'0'){/*		
	
			$query0a1="select prefix,county_code,sub_county_code from master_location where locationcode='$locationcode'";
			$exec0a1=mysql_query($query0a1) or die("querya01 ".mysql_error());
			$res0a1=mysql_fetch_array($exec0a1);
	
			$apicounty_code=$res0a1['county_code'];
			$apisub_county_code=$res0a1['sub_county_code'];
			
			$refprefix=($res0a1['prefix']!='')?$res0a1['prefix']:'--'; 
			$refprefix='01'.$refprefix;
			$refmiddle=date('ymd');
			$paynowbillprefix = strtoupper($refprefix);
			$paynowbillprefix1=strlen($paynowbillprefix);
			
			/*$query12 = "select bankrefno from bank_refrencenumber order by auto_number desc limit 0, 1";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$billnumber = $res12["bankrefno"];
			
			$substringbilldate=substr($billnumber,4,6);
			
			$substringbillno=substr($billnumber,10);
			
			if($billnumber==''){
				$newbillno=$refprefix.$refmiddle.'1';
			}
			else if($substringbilldate!=$refmiddle)
			{
				$newbillno=$refprefix.$refmiddle.'1';
			}
			else if($substringbilldate==$refmiddle){
				$substringbillno+=1;
				$newbillno=$refprefix.$refmiddle.$substringbillno;
			}
			
			 $billnumbercode=$newbillno;  
	*/
	
			$opdate=date('Y-m-d');
			$entrytime=date("H:i:s");
			$enteredfrom="billing_paynow";
			$testage=$age;
			$banktotal=$totalamount; 
			$paymenttypename="CASH";
			$subtypename="CASH";
					
				
			if($billingtype=="PAY NOW")
				{
					$bankbilltype=1;
				}
				$tranamount=$banktotal;
									
	/*		 $query1222 = "select bankrefno from bank_refrencenumber  where visitcode='$visitcode' and patientcode='$patientcode' and patientname='$patientfullname' and billnumber='' ";
			$exec1222 = mysql_query($query1222) or die ("Error in Query1222".mysql_error());
			$num=mysql_num_rows($exec1222);
			$res1222 = mysql_fetch_array($exec1222);*/
			/*
				$query2 = "INSERT INTO bank_refrencenumber SET patientname='$patientfullname',patientcode='$patientcode',visitcode='$visitcode',opdate='$opdate',paymenttype='$paymenttypename',subtype='$subtypename',accountname='$accountname',planname='$plannamename',bankrefno='$billnumbercode',entrytime='$entrytime',locationname='$locationname',locationcode='$locationcode',ipaddress='$ipaddress',username='$username',enteredfrom='$enteredfrom',idref='$consultationid',transactionamount='$tranamount',visit_type='4',bill_type='$bankbilltype',lab_amount='$tranamount'";
					
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());*/
				
			/*	if(is_connected()){
								
					$apibill_no = $billnumbercode;
					$apibill_amount = $tranamount;
					$apibill_name = 'EXTERNAL LAB';
					$apibill_date = $opdate;
					$apibill_notification_no = '12345678';
					$apibill_location = $locationname;
					$apipatient_id = $patientcode;
					$apivisit_number = $visitcode;
					
					//include('apipublish.php');		
					
					}*/
			
		}
		header("location:lab_externalbilling_request.php");
        exit;
    
       }
//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
//This include updatation takes too long to load for hunge items database.
//To populate the autocompetelist_services1.js
//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];
/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/
//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}
if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}
?>
<?php
function is_connected()
{
    $connected = @fsockopen("www.google.com", 80); 
                                        //website, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;
}
?>
<?php
$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select consultationid as billnumber from consultation_lab where consultationid like 'EB-%' order by auto_number desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
if($res2["billnumber"]=='')
{
$res2 = mysqli_fetch_array($exec2);
}
 $billnumber = $res2["billnumber"]; 
 $billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1'."-".date('y');
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php
include ("autocompletebuild_lab1.php");
?>
<script language="javascript">
<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>
function funcOnLoadBodyFunctionCall()
{
	 //To handle ajax dropdown list.
	 
	 	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	
	funcPopupPrintFunctionCall();
	
	funcCustomerDropDownSearch1();
		
		funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	
/*	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	*/
}
function funcLabShowView()
{
 
  if (document.getElementById("labid") != null) 
     {
	 document.getElementById("labid").style.display = 'none';
	}
	if (document.getElementById("labid") != null) 
	  {
	  document.getElementById("labid").style.display = '';
	 }
	 
	return true;
	 return true;
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}		
	 
}
function funcRadShowView()
{
if (document.getElementById("customercode").value == '') 
     {
	 alert("Please Select Patient");
	 document.getElementById("customer").focus();
	 return false;
	 }
 
  if (document.getElementById("radid") != null) 
     {
	 document.getElementById("radid").style.display = 'none';
	}
	if (document.getElementById("radid") != null) 
	  {
	  document.getElementById("radid").style.display = '';
	 }
	 return true;
	 return true;
}
	
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
}
function funcPopupPrintFunctionCall()
{
	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1print = mysqli_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/
}
//Print() is at bottom of this page.
</script>
<script type="text/javascript">
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
function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}
function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}
</script>
<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearchexternal.js"></script>
<script type="text/javascript" src="js/insertnewitem222.js?v=2"></script>
<script type="text/javascript" src="js/insertnewitem13.js"></script>
<script type="text/javascript" src="js/insertnewitem14.js"></script>
<?php include ("js/dropdownlist1icd.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd.js"></script>
<?php include ("js/dropdownlist1icd1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch12_new.js"></script>
<script language="javascript">
var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
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
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}
function btnDeleteClick1(delID1,vrate1)
{
var vrate1 = vrate1;
	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	newtotal3=newtotal3.toFixed(2);
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;
	
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount31=document.getElementById('total3').value;
	}
	
	
		 newgrandtotal3=parseInt(newtotal3)+parseInt(totalamount21)+parseInt(totalamount31);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=newgrandtotal3.toFixed(2);
	
}
function btnDeleteClick5(delID5,radrate)
{
var radrate=radrate;
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	//alert(delID5);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
	//alert(child2);
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert(parent2);
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	
	
	
    var newgrandtotal2=parseInt(totalamount21)+parseInt(newtotal2)+parseInt(totalamount31);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal2.toFixed(2);
	
	
	
}
function btnDeleteClick3(delID3,vrate3)
{
var vrate3=vrate3;
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child3 = document.getElementById('idTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	
	
	var newgrandtotal1=parseInt(totalamount21)+parseInt(totalamount31)+parseInt(newtotal1);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	
}
</script>
<script>
function btnDeleteClick4(delID)
{
//var pharmamount=pharmamount;
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 	
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert('amounttot['+varDeleteID+']');
		var curamount = document.getElementById('amounttot['+varDeleteID+']').value; // currency amount
		
		document.getElementById("cashgivenbycustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(curamount).toFixed(2);
	   // document.getElementById("cashamount").value=document.getElementById("cashgivenbycustomer").value;
		//alert()
		//funcbillamountcalc1();
		var totalamount = document.getElementById("totalamount").value ;
		
	//	alert(curamount);
		
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		//amounttot[2]
		//var curamount = document.getElementById('amounttot'+varDeleteID); // currency amount
		//alert(curamount);
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('amounttot').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-varDeleteID;
	
	newtotal4 = newtotal4.toFixed(2);
	
	document.getElementById('amounttot').value=0.00;
	
	document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	funcPaymentInfoCalculation1();
}
</script>
<script>
function FuncPopup()
{
	window.scrollTo(0,0);
	document.body.style.overflow='auto';
	document.getElementById("imgloader").style.display = "";
	//return false;
}
function validcheck()
{
if (document.getElementById("customercode").value == '') 
     {
	 alert("Please Select Patient");
	 document.getElementById("customer").focus();
	 return false;
	 }	
if (document.getElementById("total1").value == '' || parseFloat(document.getElementById("total1").value)<=0) 
     {
	 alert("Please Select Lab");
	// document.getElementById("customer").focus();
	 return false;
	 }	
/* var var2=document.getElementById("billtype").value;
if(var2=="PAY LATER")
{ */
	if(document.getElementById("insertrow13").childNodes.length < 2)
	{
	 alert("Please Enter the primary disease");
	 document.getElementById("dis").focus();
	  return false;
	}
 
//}
	document.getElementById("Submit222").disabled=true;
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		document.getElementById("Submit222").disabled=false;
		return false;
	}
	else
	{
		FuncPopup();
		document.form1.submit();		
		
	}
}
function collapsethis(getid){
if (document.getElementById("customercode").value == '') 
     {
	 alert("Please Select Patient");
	 document.getElementById("customer").focus();
	 return false;
	 }	
	
$("#"+getid).toggle();
}
</script>
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
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 30px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<script src="jquery/jquery-1.11.3.min.js"></script>
<script src="js/datetimepicker_css.js"></script>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
</head>
<script>
function printConsultationBill()
 {
  if (document.getElementById("nettamount").value != "0.00")
	{
var popWin; 
popWin = window.open("print_external_bill.php?billnumber=<?php echo $billnumbercode; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
    }
 }
</script>
<script>
function functioncurrencyfx(val)
{	
	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	
	var ledgername=myarr[2];
	var ledgercode=myarr[3];
	//alert(currate);
	//alert(currency);
	document.getElementById("fxamount").value=  currate;
	
	document.getElementById("ledgername").value=  ledgername;
	document.getElementById("ledgercode").value=  ledgercode;
	
	document.getElementById("amounttot").value='';
	document.getElementById("currencyamt").value='';
	
	
}
function funcamountcalc()
{
if(document.getElementById("currencyamt").value != '')
{
var currency = document.getElementById("currencyamt").value;
var rate = document.getElementById("fxamount").value;
var amount = currency * rate;
document.getElementById("amounttot").value = amount.toFixed(2);
}
}
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
	}
}
</script>
<script>
$(function() {
/*$('#customer').keyup(function(){
pid=$('#customer').val();
$.ajax({
		type: "POST",
		url: "ajaxexternalcustomernewsearch_lab.php",
		data:{'term':pid},
		success:function(data){
		alert(data);
		}
		});
});	*/
$('#customer').autocomplete({
		
	source:'ajaxexternalcustomernewsearch_lab.php', 
	//alert(source);
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			var patientfirstname = ui.item.patientfirstname;
			var patientmiddlename = ui.item.patientmiddlename;
			var patientlastname = ui.item.patientlastname;
			var age = ui.item.age;
			var gender = ui.item.gender;
			var billtype = ui.item.billtype;
			var visitcode = ui.item.visitcode;						
			var planfixedamount = ui.item.planfixedamount;
			var planpercentageamount = ui.item.planpercentageamount;
			var paymenttype = ui.item.paymenttype;
			var subtype = ui.item.subtype;						
			$('#customername').val(patientfirstname);
			$('#customermiddlename').val(patientmiddlename);
			$('#customerlastname').val(patientlastname);
			$('#customercode').val(customercode);
			$('#accountname').val(accountname);
			$('#patientcode').val(customercode);
			$('#age').val(age);
			$('#gender').val(gender);			
			$('#billtype').val(billtype);
			$('#visitcode').val(visitcode);	
			$('#planfixedamount').val(planfixedamount);
			$('#planpercentageamount').val(planpercentageamount);			
			$('#paymenttype').val(paymenttype);
			$('#subtype').val(subtype);
			$('#scheme').val(ui.item.scheme_name);
			
			}
    });
});
</script>
<style>
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
 
 
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<div align="center" class="imgloader" id="imgloader" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Saving <br><br> Please Wait...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>
<form name="form1" id="frmsales" method="post" action="lab_externalbilling_request.php" onSubmit="return validcheck()"   >
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
        <td><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="3" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
	          <td width="19%" align="left" colspan="3" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <strong>Location : </strong> <?php  echo $locationname; ?></td>
                <td width="24%" colspan="1" bgcolor="#ecf0f5" class="bodytext32"><strong>&nbsp;</strong>
           <input type="hidden" name="opdate" id="opdate" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="ipaddress" id="ipaddress" value="<?php echo $ipaddress; ?>">
                <input type="hidden" name="entrytime" id="entrytime" value="<?php echo $timeonly; ?>">   
            
                <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname;?>">
                <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">
                </td>
                
			 </tr>
             <tr bgcolor="#ecf0f5">
             <td colspan="8" bgcolor="#ecf0f5"></td>
             </tr>
             <tr bgcolor="#011E6A">
                
               
                 <td colspan="8" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name| Registration No   (*Use "|" symbol to skip sequence)</strong>
 
              </tr>
  
              <tr>
                <td colspan="11" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
               
              </tr>
              
                <tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input type="hidden" name="photoavailable" id="photoavailable" size="10" autocomplete="off" value="<?php echo $photoavailable; ?>">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				 <input name="customercode" id="customercode" value="" type="hidden">
				  <input name="billtype" id="billtype" value = "" type = "hidden">
				  <input name="planfixedamount" id="planfixedamount" value="" type="hidden">
				  <input name="planpercentageamount" id="planpercentageamount" value="" type="hidden">
				  <input name="paymenttype" id="paymenttype" value="" type="hidden">
				  <input name="subtype" id="subtype" value="" type="hidden">
				
				</td>
				</tr>
		
            <tr>
                        
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong> </td>
              <td width="23%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong> </td>
              
            </tr>
                        
        	<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> &nbsp;First Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> &nbsp;Middle Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> &nbsp;Last Name   </span></td>
				  </tr>
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customername" id="customername" value="" style="text-transform:uppercase;" size="18" readonly>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>"size="45"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="" style="text-transform:uppercase;" size="18" readonly></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customerlastname" id="customerlastname" value="" style="text-transform:uppercase;" size="18" readonly></td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age </strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="age" id="age" value="" size="18"  readonly/>	</td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="gender" id="gender" value="" size="18"  readonly/>
               </td>	
                </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Bill Date</strong></td>
				<td><input type="text" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Bill No</strong></td>
				<td><input type="text" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" size="18" rsize="20" readonly/></td>
				  </tr>
                  
        <tr>
              
        
        <td align="left" valign="middle" class="bodytext3"><strong>Patient Code</strong></td>
        
        <td><input type="text" name="patientcode" id="patientcode" value="" size="18" rsize="20" readonly/></td>
        
         <td align="left" valign="middle" class="bodytext3"><strong>Visit Code</strong></td>
        
        <td><input type="text" name="visitcode" id="visitcode" value="" size="18" rsize="20" readonly/></td>	
        
        
        </tr>
        
                   
        <tr>
        
       
         <td align="left" valign="middle" class="bodytext3"><strong>Account Name</strong></td>
        
        <td colspan="3"><input type="text" name="scheme" id="scheme"  value="" size="50" rsize="30" readonly/></td>
        
        <td align="left" valign="middle" class="bodytext3"></td>
        
        <td></td>	
             
        </tr>
        
         <tr>
        
               
        <td align="left" valign="middle" class="bodytext3"><strong>Provider</strong></td>
        
        <td colspan="3"> <input type="text" name="accountname" id="accountname"  value="" size="50" rsize="20" readonly/></td>	
        
        <td align="left" valign="middle" class="bodytext3"></td>
        
        <td></td>	
        
        </tr>
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" 
            align="left" border="0">
          <tbody id="foo">
       
				  
				   <tr >
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Lab <img src="images/plus1.gif" width="13" height="13"> </strong></span></td>
			      </tr>
				  
				  <tr id="labid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber1" id="serialnumber17" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="laba11" id="lab" type="text" size="69" autocomplete="off" >
					  <input name="hiddenlab" id="hiddenlab" type="hidden" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate51" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem2()" class="button">
                       </label></td>
					   </tr>
					    </table>	  </td> 
				  </tr>
				  
				  		  <tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <!--
					 <tr>
                     <td class="bodytext3">Priliminary Diseases</td>
				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>
                   </tr> -->
                     
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow13">					 </div></tr>
                     					  <tr>
					  <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">
					  <input type="hidden" name="diseas" id="diseas" value="">
					  <td class="bodytext3">Primary</td>
				   <td width="423"> <input name="dis[]" id="dis" type="text" size="69" autocomplete="off"></td>
				      <td width="101"><input name="code[]" type="text" id="code" readonly size="8">
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
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow14">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">
					  <input type="hidden" name="diseas1" id="diseas1" value="">
					  <td class="bodytext3">Secondary </td>
				   <td width="423"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>
				      <td width="101"><input name="code1[]" type="text" id="code1" readonly size="8">
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
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" name="total2" id="total1" readonly size="7">  <input type="hidden" id="total2" readonly size="7"><input type="hidden" id="total3" readonly size="7"><input type="hidden" id="total4" readonly size="7"></td>
				  </td>
				  </tr> 
		         
          </tbody>
        </table>		</td>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		
        
                      <tr>
                
                <td colspan="14" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
				  <input name="Submit2223" id="Submit222" type="submit" onClick=" return Checkbankref()"  value="Save Bill(ALT+S)" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
	
    </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
<script>
$(document).ready(function(e) {
	//alert();
	$('#customer').focus();
   // $("#radid").toggle();
});
</script>
</body>
</html>