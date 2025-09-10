<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
//echo 'menu_id'.$menu_id;
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
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
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["patientlocation"])) { $patientlocation = $_REQUEST["patientlocation"]; } else { $patientlocation = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	
		$patientname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtype'];
		$accountname = $_REQUEST['accountname'];
		$locationcode = $_REQUEST['locationcode'];
		$locationname = $_REQUEST['locationname'];
		$accountname = $_REQUEST['accountname'];
		
		
		
		$paynowbillprefix = 'TP-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["docno"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
		$testcode ='TP-'.'1';
		}
		else
		{
		$billnumber = $res2["docno"];
		$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
		$billnumbercode = intval($billnumbercode);
		$billnumbercode = $billnumbercode + 1;
		$maxanum = $billnumbercode;
		$testcode = 'TP-' .$maxanum;
		}
		
		
		$paynowbillprefix = 'IPMP-';
		$paynowbillprefix11=strlen($paynowbillprefix);
		$query21 = "select * from ipmedicine_prescription where recordstatus = '' order by auto_number desc limit 0, 1";
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res21 = mysqli_fetch_array($exec21);
		$billnumber1 = $res21["docno"];
		$billdigit1=strlen($billnumber1);
		if ($billnumber1 == '')
		{
		$iptestcode ='IPMP-'.'1';
		}
		else
		{
		$billnumber1 = $res21["docno"];
		$billnumbercode1 = substr($billnumber1,$paynowbillprefix11, $billdigit1);
		$billnumbercode1 = intval($billnumbercode1);
		$billnumbercode1 = $billnumbercode1 + 1;
		$maxanum1 = $billnumbercode1;
		$iptestcode = 'IPMP-' .$maxanum1;
		}

		
		$serial_mainnumber_pharma = $_REQUEST['serial_mainnumber_pharma'];
		for($j=1;$j<=$serial_mainnumber_pharma;$j++)
		{
		if(isset($_REQUEST['item_approve'.$j]))
		{	
			$disc_id = $_REQUEST['disc_id'.$j];
				
			$query="select * from addpkgitems where id='$disc_id' and recordstatus =''";
			$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query);
			$res=mysqli_fetch_array($exec);	
			$medicinename = $res['itemname'];	
			$medicinename = addslashes($medicinename);
			$medicinecode = $res['itemcode'];	
			$medicinecode = trim($medicinecode);
			$quantity = $res['quantity'];
			$rates = $res['rate'];
			$amounts = $res['amount'];
			$dose = $res['dose'];
			$dosemeasure = $res['dosemeasure'];
			$frequency = $res['frequency'];
			$dosemeasure = $res['dosemeasure'];
			$route = $res['route'];
			$days = $res['days'];
			$store = $res['store'];
			$id = $res['id'];
			$pharmfree = 'Yes';
			$expirydate = '';
			$dischargemedicine='No';
			
			if($medicinename!=''){
			
			$query1="select package_id from package_processing where visitcode='$visitcode' order by id desc";
			$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1);
			$res1=mysqli_fetch_array($exec1);	
			$package_id = $res1['package_id'];	
				
			$query55="update addpkgitems set recordstatus='completed' where id='$disc_id'";
			$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			
			
			$intqry = "insert into package_processing ( `package_id`, `package_item_type`, `patientcode`, `patientname`, `visitcode`, `itemcode`, `itemname`, `quantity`, `rate`,  `amount`, `recordstatus`, `locationname`, `locationcode`, `username`, `ipaddress`, `createdon`, `updated_on`,`dose`,`dosemeasure`,`frequency`,`days`,`add_pkg_trackid`) VALUES ('$package_id','MI','$patientcode','$patientname','$visitcode','$medicinecode','$medicinename','$quantity','$rates','$amounts','','$locationname','$locationcode','$username','$ipaddress','$updatedatetime','$updatedatetime','$dose','$dosemeasure','$frequency','$days','$id')";
			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $intqry) or die ("Error in intqry".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
			
			//$insqry = "insert into package_execution(processing_id,qty,username,ipaddress) values ('$rowid','$quantity','$username','$ipaddress') ";
			//mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query86 ="insert into ipmedicine_prescription(itemname,itemcode,quantity,prescribed_quantity,rateperunit,totalrate,batchnumber,companyanum,patientcode,visitcode,patientname,username,ipaddress,date,account,docno,billtype,expirydate,freestatus,dischargemedicine,medicineissue,locationcode,locationname,package_process_id,frequency,dose,days,route,dosemeasure,store)values('$medicinename','$medicinecode','$quantity','$quantity','$rates','$amounts','','$companyanum','$patientcode','$visitcode','$patientname','$username','$ipaddress','$dateonly','$accountname','$iptestcode','$billtype','$expirydate','$pharmfree','$dischargemedicine','pending','".$locationcode."','".$locationname."','$rowid','$frequency','$dose','$days','$route','$dosemeasure','$store')"; 				
			$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}

		for($i=1;$i<=$serial_mainnumber_pharma;$i++)
		{
		if(isset($_REQUEST['item_reject'.$i]))
		{
		$rej_remarks = $_REQUEST['rej_remarks'.$i];
		$disc_id = $_REQUEST['disc_id'.$i];				
		
		$query55="update addpkgitems set reject_remarks='$rej_remarks',reject_by='$username',recordstatus='deleted' where id='$disc_id'";
		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));										
		}
		}
		
		//lab insertion
		$serial_mainnumber_lab = $_REQUEST['serial_mainnumber_lab'];
		for($j=1;$j<=$serial_mainnumber_lab;$j++)
		{
		if(isset($_REQUEST['item_approve_lab'.$j]))
		{	
			$disc_id_lab = $_REQUEST['disc_id_lab'.$j];
			
			
			$query="select * from addpkgitems where id='$disc_id_lab' and recordstatus =''";
			$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query);
			$res=mysqli_fetch_array($exec);	
			$labname = $res['itemname'];	
			$labname = addslashes($labname);
			$labcode = $res['itemcode'];	
			$labcode = trim($labcode);
			$rate = $res['rate'];
			$amount = $res['amount'];	
			$quantity = $res['quantity'];	
			$id = $res['id'];
			
			
			if($labname!=''){
				
			$query1="select package_id from package_processing where visitcode='$visitcode' order by id desc";
			$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1);
			$res1=mysqli_fetch_array($exec1);	
			$package_id = $res1['package_id'];	
			
			$query55="update addpkgitems set recordstatus='completed' where id='$disc_id_lab'";
			$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
			
			$intqry = "insert into package_processing ( `package_id`, `package_item_type`, `patientcode`, `patientname`, `visitcode`, `itemcode`, `itemname`, `quantity`, `rate`,  `amount`, `recordstatus`, `locationname`, `locationcode`, `username`, `ipaddress`, `createdon`, `updated_on`,`add_pkg_trackid`) VALUES ('$package_id','LI','$patientcode','$patientname','$visitcode','$labcode','$labname','1','$rate','$amount','completed','$locationname','$locationcode','$username','$ipaddress','$updatedatetime','$updatedatetime','$id')";
			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $intqry) or die ("Error in intqry".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
			
			$insqry = "insert into package_execution(processing_id,username,ipaddress,qty) values ('$rowid','$username','$ipaddress','$quantity') ";
			mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert insqry".mysqli_error($GLOBALS["___mysqli_ston"]));

			$labfree='Yes';
			
			$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsultation_lab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,username,package_process_id)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$rate','$currentdate','paid','pending','pending','norefund','$testcode','$accountname','$billtype','$timeonly','$labfree','$locationcode','$username','$rowid')")  or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			}
		
		}
		}
		
		for($i=1;$i<=$serial_mainnumber_lab;$i++)
		{
		if(isset($_REQUEST['item_reject_lab'.$i]))
		{
		$rej_remarks_lab = $_REQUEST['rej_remarks_lab'.$i];
		$disc_id_lab = $_REQUEST['disc_id_lab'.$i];				
		
		$query55="update addpkgitems set reject_remarks='$rej_remarks_lab',reject_by='$username',recordstatus='deleted' where id='$disc_id_lab'";
		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));										
		}
		}
		
		//rad insertion
		$serial_mainnumber_rad = $_REQUEST['serial_mainnumber_rad'];
		for($j=1;$j<=$serial_mainnumber_rad;$j++)
		{
			if(isset($_REQUEST['item_approve_rad'.$j]))
			{
			$disc_id_rad = $_REQUEST['disc_id_rad'.$j];
			
			$query="select * from addpkgitems where id='$disc_id_rad' and recordstatus =''";
			$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query);
			$res=mysqli_fetch_array($exec);	
			$radname = $res['itemname'];	
			$radname = addslashes($radname);
			$radcode = $res['itemcode'];	
			$radcode = trim($radcode);
			$rate = $res['rate'];
			$amount = $res['amount'];	
			$quantity = $res['quantity'];	
			$id = $res['id'];
			
			if($radname != '')
			{
				
			$query1="select package_id from package_processing where visitcode='$visitcode' order by id desc";
			$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1);
			$res1=mysqli_fetch_array($exec1);	
			$package_id = $res1['package_id'];	
			
			$query55="update addpkgitems set recordstatus='completed' where id='$disc_id_rad'";
			$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		
				
			$intqry = "insert into package_processing ( `package_id`, `package_item_type`, `patientcode`, `patientname`, `visitcode`, `itemcode`, `itemname`, `quantity`, `rate`,  `amount`, `recordstatus`, `locationname`, `locationcode`, `username`, `ipaddress`, `createdon`, `updated_on`,`add_pkg_trackid`) VALUES ('$package_id','RI','$patientcode','$patientname','$visitcode','$radcode','$radname','1','$rate','$amount','completed','$locationname','$locationcode','$username','$ipaddress','$updatedatetime','$updatedatetime','$id')";
			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $intqry) or die ("Error in intqry".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
			
			$insqry = "insert into package_execution(processing_id,username,ipaddress,qty) values ('$rowid','$username','$ipaddress','$quantity') ";
			mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert insqry".mysqli_error($GLOBALS["___mysqli_ston"]));

			$radiologyfree = 'Yes';

			$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsultation_radiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,consultationdate,resultentry,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,username,package_process_id)values('$patientcode','$patientname','$visitcode','$radcode','$radname','$rate','$currentdate','pending','$testcode','$accountname','$billtype','$timeonly','$radiologyfree','$locationcode','$username','$rowid')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));


			
			}
			}
			
		}
		
		for($i=1;$i<=$serial_mainnumber_rad;$i++)
		{
		if(isset($_REQUEST['item_reject_rad'.$i]))
		{
		$rej_remarks_rad = $_REQUEST['rej_remarks_rad'.$i];
		$disc_id_rad = $_REQUEST['disc_id_rad'.$i];				
		
		$query55="update addpkgitems set reject_remarks='$rej_remarks_rad',reject_by='$username',recordstatus='deleted' where id='$disc_id_rad'";
		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));										
		}
		}
		
		
		//service insertion
		$serial_mainnumber_ser = $_REQUEST['serial_mainnumber_ser'];
		for($j=1;$j<=$serial_mainnumber_ser;$j++)
		{
			if(isset($_REQUEST['item_approve_ser'.$j]))
			{
				$disc_id_ser = $_REQUEST['disc_id_ser'.$j];
				
			 	$query="select * from addpkgitems where id='$disc_id_ser' and recordstatus =''";
				$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query);
				$res=mysqli_fetch_array($exec);	
				$servicename = $res['itemname'];	
				$servicename = addslashes($servicename);
				$servicecode = $res['itemcode'];	
				$servicecode = trim($servicecode);
				$itemrate = $res['rate'];
				$seramt = $res['amount'];	
				$serviceissqty = $res['quantity'];	
				$id = $res['id'];

				if($servicename!='')
				{
					
					
				$query1="select package_id from package_processing where visitcode='$visitcode' order by id desc";
				$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1);
				$res1=mysqli_fetch_array($exec1);	
				$package_id = $res1['package_id'];	
				
				$query2="select package_id from master_services where itemcode='$servicecode' ";
				$exec2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
				$res2=mysqli_fetch_array($exec2);	
				$ledgercode = $res2['ledgerid'];	
				$ledgername = $res2['ledgername'];	
				
				
				
				$query55="update addpkgitems set recordstatus='completed' where id='$disc_id_ser'";
				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
				
				
				
				$intqry = "insert into package_processing ( `package_id`, `package_item_type`, `patientcode`, `patientname`, `visitcode`, `itemcode`, `itemname`, `quantity`, `rate`,  `amount`, `recordstatus`, `locationname`, `locationcode`, `username`, `ipaddress`, `createdon`, `updated_on`,`add_pkg_trackid`) VALUES ('$package_id','SI','$patientcode','$patientname','$visitcode','$servicecode','$servicename','1','$itemrate','$seramt','completed','$locationname','$locationcode','$username','$ipaddress','$updatedatetime','$updatedatetime','$id')";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $intqry) or die ("Error in intqry".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
				
				$insqry = "insert into package_execution(processing_id,qty,username,ipaddress) values ('$rowid','$serviceissqty','$username','$ipaddress') ";
				mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			
				$servicesfree = 'Yes';
				
				$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,serviceqty,amount,incomeledgercode,incomeledgername,username,doctorcode,doctorname,package_process_id)values('$patientcode','$patientname','$visitcode','$servicecode','$servicename','$itemrate','$currentdate','paid','pending','$testcode','$accountname','$billtype','$timeonly','$servicesfree','$locationcode','".$serviceissqty."','".$seramt."','$ledgercode','$ledgername','$username','','','$rowid')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				mysqli_query($GLOBALS["___mysqli_ston"], "insert into iptest_procedures(docno,patientname,patientcode,visitcode,account,recorddate,ipaddress,recordtime,username,billtype,locationcode,doctorcode,doctorname,package_process_id)values('$testcode','$patientname','$patientcode','$visitcode','$accountname','$currentdate','$ipaddress','$timeonly','$username','$billtype','$locationcode','','','$rowid')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
			}
		}
		
		for($i=1;$i<=$serial_mainnumber_ser;$i++)
		{
		if(isset($_REQUEST['item_reject_ser'.$i]))
		{
		$rej_remarks_ser = $_REQUEST['rej_remarks_ser'.$i];
		$disc_id_ser = $_REQUEST['disc_id_ser'.$i];				
		
		$query55="update addpkgitems set reject_remarks='$rej_remarks_ser',reject_by='$username',recordstatus='deleted' where id='$disc_id_ser'";
		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));										
		}
		}
		
		
	
	  header("location:approveaddpkgitems.php");
	  exit;
       
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
?>
<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];
$res111subtype = $execlab1['subtype'];	
$billtype = $execlab1['billtype'];
 $paymenttypenew = $execlab1['paymenttype'];
$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];
$res111paymenttype = $execlab1['paymenttype'];
$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$query765 = "select * from master_consultation where patientvisitcode='$visitcode'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num765 = mysqli_num_rows($exec765);
?>

<script language="javascript">

function validcheck(){
	

var serial_mainnumber = $('#serial_mainnumber_pharma').val();
	//alert(serial_mainnumber);			
		for(var i =1; i<=serial_mainnumber; i++) {		
				if ($("#item_reject"+i).prop("checked") ==true && document.getElementById("rej_remarks"+i).value==''){
				alert("Please Enter Remarks");
				return false;	
				
			}		
		}


var serial_mainnumber_lab = $('#serial_mainnumber_lab').val();
	//alert(serial_mainnumber);			
		for(var i =1; i<=serial_mainnumber_lab; i++) {		
				if ($("#item_reject_lab"+i).prop("checked") ==true && document.getElementById("rej_remarks_lab"+i).value==''){
				alert("Please Enter Remarks");
				return false;	
								
			}		
		}

var serial_mainnumber_rad = $('#serial_mainnumber_rad').val();
	//alert(serial_mainnumber);			
		for(var i =1; i<=serial_mainnumber_rad; i++) {		
				if ($("#item_reject_rad"+i).prop("checked") ==true && document.getElementById("rej_remarks_rad"+i).value==''){
				alert("Please Enter Remarks");
				return false;	
							
			}		
		}
		
var serial_mainnumber_ser = $('#serial_mainnumber_ser').val();
			
		for(var i =1; i<=serial_mainnumber_ser; i++) {			
				if ($("#item_reject_ser"+i).prop("checked") ==true && document.getElementById("rej_remarks_ser"+i).value==''){
				alert("Please Enter Remarks");
				return false;	
						
			}		
		}




	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Cancelled");
		return false;
	}
	return true;
document.getElementById("saveitems").disabled=true;
}

function statuscheck(row){
	 var row=row;
	var tot=document.getElementById("grandtotal").value;
	tot=(tot==''|| tot==null)?0:parseFloat(tot.replace(/,/g,''));
	if ($("#item_approve"+row).is(':checked') == true && $("#item_reject"+row).is(':checked') == true) {
       alert("Select Either Approve or Reject");
	   $("#item_approve"+row).attr("checked",false); 
	   $("#item_reject"+row).attr("checked",false); 
	   document.getElementById("rej_remarks"+row).style.display = "none";
	   var pharmaamt=document.getElementById("item_pharmaamount"+row).value;
		grdtot=parseInt(tot)-parseInt(pharmaamt);
		grdtot = parseFloat(grdtot).toFixed(2);
		grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");			
		document.getElementById("grandtotal").value=grdtot;
    } 
	else{
		
	if($("#item_reject"+row).is(':checked') == true){
	document.getElementById("rej_remarks"+row).style.display = "";
	}
	
	if($("#item_reject"+row).is(':checked') == false){
	document.getElementById("rej_remarks"+row).style.display = "none";
	
	}
	
	if($("#item_approve"+row).is(':checked') == true){
	var pharmaamt=document.getElementById("item_pharmaamount"+row).value;
	grdtot=parseInt(tot)+parseInt(pharmaamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	if($("#item_approve"+row).is(':checked') == false){
	var pharmaamt=document.getElementById("item_pharmaamount"+row).value;
	grdtot=parseInt(tot)-parseInt(pharmaamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	
	}
}
function statuscheck_lab(row){
	var row=row;
	var tot=document.getElementById("grandtotal").value;
	tot=(tot==''|| tot==null)?0:parseFloat(tot.replace(/,/g,''));
	if(tot==''){tot=0;}
	if ($("#item_approve_lab"+row).is(':checked') == true && $("#item_reject_lab"+row).is(':checked') == true) {
       alert("Select Either Approve or Reject");
	   $("#item_approve_lab"+row).attr("checked",false); 
	   $("#item_reject_lab"+row).attr("checked",false); 
	   document.getElementById("rej_remarks_lab"+row).style.display = "none";
	   var labamt=document.getElementById("item_labamount"+row).value;
		grdtot=parseInt(tot)-parseInt(labamt);
		grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("grandtotal").value=grdtot;
	   
    } 
	else{
		
	if($("#item_reject_lab"+row).is(':checked') == true){
	document.getElementById("rej_remarks_lab"+row).style.display = "";
	}
	
	if($("#item_reject_lab"+row).is(':checked') == false){
	document.getElementById("rej_remarks_lab"+row).style.display = "none";
	}
	
	if($("#item_approve_lab"+row).is(':checked') == true){
	var labamt=document.getElementById("item_labamount"+row).value;
	grdtot=parseInt(tot)+parseInt(labamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	if($("#item_approve_lab"+row).is(':checked') == false){
	var labamt=document.getElementById("item_labamount"+row).value;
	grdtot=parseInt(tot)-parseInt(labamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	
	}
}
function statuscheck_rad(row){
	 var row=row;
	var tot=document.getElementById("grandtotal").value;
	tot=(tot==''|| tot==null)?0:parseFloat(tot.replace(/,/g,''));
	if(tot==''){tot=0;}
	if ($("#item_approve_rad"+row).is(':checked') == true && $("#item_reject_rad"+row).is(':checked') == true) {
       alert("Select Either Approve or Reject");
	   $("#item_approve_rad"+row).attr("checked",false); 
	   $("#item_reject_rad"+row).attr("checked",false); 
	   document.getElementById("rej_remarks_rad"+row).style.display = "none";
	   var radamt=document.getElementById("item_radamount"+row).value;
	grdtot=parseInt(tot)-parseInt(radamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
    } 
	else{
		
	if($("#item_reject_rad"+row).is(':checked') == true){
	document.getElementById("rej_remarks_rad"+row).style.display = "";
	}
	
	if($("#item_reject_rad"+row).is(':checked') == false){
	document.getElementById("rej_remarks_rad"+row).style.display = "none";
	
	}
	if($("#item_approve_rad"+row).is(':checked') == true){
	var radamt=document.getElementById("item_radamount"+row).value;
	grdtot=parseInt(tot)+parseInt(radamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	if($("#item_approve_rad"+row).is(':checked') == false){
	var radamt=document.getElementById("item_radamount"+row).value;
	grdtot=parseInt(tot)-parseInt(radamt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	
	}
}
function statuscheck_ser(row){
	 var row=row;
	var tot=document.getElementById("grandtotal").value;
	tot=(tot==''|| tot==null)?0:parseFloat(tot.replace(/,/g,''));
	if(tot==''){tot=0;}
	if ($("#item_approve_ser"+row).is(':checked') == true && $("#item_reject_ser"+row).is(':checked') == true) {
       alert("Select Either Approve or Reject");
	   $("#item_approve_ser"+row).attr("checked",false); 
	   $("#item_reject_ser"+row).attr("checked",false); 
	   document.getElementById("rej_remarks_ser"+row).style.display = "none";
	   var seramt=document.getElementById("item_seramount"+row).value;
	grdtot=parseInt(tot)-parseInt(seramt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
    } 
	else{
		
	if($("#item_reject_ser"+row).is(':checked') == true){
	document.getElementById("rej_remarks_ser"+row).style.display = "";
	}
	
	if($("#item_reject_ser"+row).is(':checked') == false){
	document.getElementById("rej_remarks_ser"+row).style.display = "none";
	}
	
	if($("#item_approve_ser"+row).is(':checked') == true){
	document.getElementById("rej_remarks_ser"+row).style.display = "none";
	var seramt=document.getElementById("item_seramount"+row).value;
	grdtot=parseInt(tot)+parseInt(seramt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	
	if($("#item_approve_ser"+row).is(':checked') == false){
	//document.getElementById("rej_remarks_ser"+row).style.display = "none";
	var seramt=document.getElementById("item_seramount"+row).value;
	grdtot=parseInt(tot)-parseInt(seramt);
	grdtot = parseFloat(grdtot).toFixed(2);
	grdtot = grdtot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtotal").value=grdtot;
	}
	
	}
}


//Print() is at bottom of this page.
</script>
<script language="javascript">

function formatMoney(number, places, thousand, decimal) {
	number = number || 0;
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}
function numbervaild(key)
{
	var keycode = (key.which) ? key.which : key.keyCode;
	 if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
	{
		return false;
	}
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
.bal1{
	border-style:none;
background:none;
text-align:right;
font-size: 16px;
	font-weight: bold;
	FONT-FAMILY: Tahoma	
	
}
</style>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
 <link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script src="js/pkgitems_history.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="ippackageadditionalitemsapproval.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td width="99%" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#cbdbfa" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
			<tr>
			<td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
			<td width="33%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientname; ?>
			<input type="hidden" name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18">
			<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
			<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<strong>Reg No</strong></td>
			<td width="34%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?>
			<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18">
			<input type="hidden" name="paymenttypenew" id="paymenttypenew" value="<?php echo $paymenttypenew;?>">
			</td>
			</tr>       
			<tr>
			<td align="left" valign="middle" class="bodytext3"><strong>Visit Code</strong></td>
			<td class="bodytext3"><?php echo $visitcode; ?><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>	
			<td align="left" valign="middle" class="bodytext3"><strong>Account</strong></td>
			<td class="bodytext3"><?php echo $patientaccount1; ?><input type="hidden" name="accountname" id="accountname" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>								</td>
			</tr>
			<tr>
			<td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age </strong></td>
			<td align="left" valign="top" class="bodytext3"><?php echo $patientage; ?>
			<input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />
			<input type="hidden" name="age" id="age" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A" size="18" />	</td>			
			<td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
			<td align="left" valign="top" class="bodytext3"><?php echo $patientgender; ?>
			<input type="hidden" name="gender" id="gender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
			<input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >   
			<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>"> 
			<input type="hidden" name="consultation" id="consultation" value="<?php echo $num765; ?>"></td>	
			<input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">
			<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname;?>">
			<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $res111subtype;?>">
			</tr>
			<tr>
			<td colspan='3' align='left'></td>
			
			</tr>
				  
            <tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			</tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="105%" align="left" border="0">
          <tbody id="foo">
          
			<tr>
				<td colspan="9" align="left" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><strong>Prescription</strong> </td>
				<td colspan="4" align="middle" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><strong><a href="#" class="viewitemhistory" patientcode="<?php echo $patientcode;?>" id="<?php echo $visitcode; ?>" viewname='Medicine'> View Package Medicine History</a></strong> </td>
			</tr>
			
			<tr>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Medicine Code</strong></div></td>
				<td width="20%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Medicine Name</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Dose</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Dose.Measure</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Freq</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Quantity</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Route</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Approve &nbsp; Reject</strong></div></td>
				<td width="13%"  align="left" valign="center" bgcolor="" class="bodytext31"><div align="right"><strong></strong></div></td>
			</tr>
			<?php 
			$msno=0;
			$mtot=0;
			$lsno=0;
			$ltot=0;
			$rsno=0;
			$rtot=0;
			$ssno=0;
			$stot=0;
			$serial_mainnumber_pharma=0;
			$serial_mainnumber_lab=0;
			$serial_mainnumber_rad=0;
			$serial_mainnumber_ser=0;
			
			$query82 = "select * from addpkgitems  where locationcode='$patientlocation' and recordstatus = '' and  patientcode='$patientcode' and visitcode='$visitcode' and package_item_type='MI'";
			$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num82 = mysqli_num_rows($exec82);
			while($res82 = mysqli_fetch_array($exec82))
			{
			$patientname = $res82['patientname'];
			$auto_number = $res82['id'];
			$patientcode = $res82['patientcode'];
			$visitcode = $res82['visitcode'];
			$date = date('d/m/Y', strtotime($res82['createdon']));
		 	$package_item_id = $res82['package_item_type'];
			$itemcode = $res82['itemcode'];
			$itemname = $res82['itemname'];
			$quantity = $res82['quantity'];
			$rate = $res82['rate'];
			$dose = $res82['dose'];
			$dosemeasure = $res82['dosemeasure'];
			$frequency = $res82['frequency'];
			$days = $res82['days'];
			$amount = $res82['amount'];
			$instructions = $res82['instructions'];
			$route = $res82['route'];
			$mtot+=$amount;
			
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
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serial_mainnumber_pharma=$msno = $msno + 1; ?>
			<input type="hidden" name="disc_id<?php echo $msno;?>" value="<?php echo $auto_number; ?>"> 
			</div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dose; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dosemeasure; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $frequency; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $route; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $instructions; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div>
			<input type="hidden" name="item_pharmaamount<?php echo $msno;?>" id="item_pharmaamount<?php echo $msno;?>" value="<?php echo $amount; ?>" />
			</td>
			<td class="bodytext31" valign="center"  align="center"><div class="bodytext31" align="center"><input style="zoom:1.5;" type="checkbox"  name="item_approve<?php echo $msno;?>" id="item_approve<?php echo $msno;?>" value="<?php echo $auto_number; ?>"    onclick="return statuscheck('<?php echo $msno;?>')"> &nbsp; 
			<input style="zoom:1.5;" type="checkbox"  name="item_reject<?php echo $msno;?>" id="item_reject<?php echo $msno;?>" value="<?php echo $auto_number; ?>"  class="select" onclick="return statuscheck('<?php echo $msno;?>')"></div>
			</td>
			<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div align="center" ><textarea  id="rej_remarks<?php echo $msno;?>" name="rej_remarks<?php echo $msno;?>" rows="2" cols="14" placeholder="Comments" style="display:none"></textarea></div></td>	</td>
			</tr>
			<?php }  ?>
			<tr>
				<td colspan="12" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><span  class="bodytext32"><input name="text" type="text" id="total" size="7" value="<?php echo number_format($mtot,2,'.','');?>" style="text-align: right;" readonly> </span></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="5" align="left" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><span class="bodytext32"><strong>Lab </strong></span></td>
				<td colspan="2" align="left" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><span class="bodytext32"><strong><a href="#" class="viewitemhistory" patientcode="<?php echo $patientcode;?>" id="<?php echo $visitcode; ?>" viewname='Lab'>View Package Lab History</a></strong></span></td>
				
				
				 
			</tr>
			<tr>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Lab Code</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Lab Name</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Quantity</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Approve &nbsp; Reject</strong></div></td>
				<td width="13%"  align="left" valign="center" bgcolor="" class="bodytext31"><div align="right"><strong></strong></div></td>
			</tr>
			<?php 
			$querylab = "select * from addpkgitems  where locationcode='$patientlocation' and recordstatus = '' and  patientcode='$patientcode' and visitcode='$visitcode' and package_item_type='LI'";
			$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $querylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numlab = mysqli_num_rows($execlab);
			while($reslab = mysqli_fetch_array($execlab))
			{
			$ltot+=$reslab['amount'];
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
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serial_mainnumber_lab=$lsno = $lsno + 1; ?></div>
			<input type="hidden" name="disc_id_lab<?php echo $lsno;?>" value="<?php echo $reslab['id']; ?>"> 
			</td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reslab['itemcode']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reslab['itemname']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reslab['quantity']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reslab['rate']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($reslab['amount'],2,'.',','); ?></div>
			<input type="hidden" name="item_labamount<?php echo $lsno;?>" id="item_labamount<?php echo $lsno;?>" value="<?php echo $reslab['amount']; ?>" />
			</td>
			<td class="bodytext31" valign="center"  align="center"><div class="bodytext31" align="center"><input style="zoom:1.5;" type="checkbox"  name="item_approve_lab<?php echo $lsno;?>" id="item_approve_lab<?php echo $lsno;?>" value="<?php echo $reslab['id']; ?>"    onclick="return statuscheck_lab('<?php echo $lsno;?>')"> &nbsp; 
			<input style="zoom:1.5;" type="checkbox"  name="item_reject_lab<?php echo $lsno;?>" id="item_reject_lab<?php echo $lsno;?>" value="<?php echo $reslab['id']; ?>"  class="select" onclick="return statuscheck_lab('<?php echo $lsno;?>')"></div>
			</td>
			<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div align="center" ><textarea  id="rej_remarks_lab<?php echo $lsno;?>" name="rej_remarks_lab<?php echo $lsno;?>" rows="2" cols="14" placeholder="Comments" style="display:none"></textarea></div></td>	</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input style="text-align: right;" type="text" id="total1" readonly value="<?php echo number_format($ltot,2,'.',',');?>" size="7"></td>
			</tr> 
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="4" align="left" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><span class="bodytext32"><span class="bodytext32"><strong>Radiology </strong></span></span></td>
				<td colspan="3" align="right" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><span class="bodytext32"><strong><a href="#" class="viewitemhistory" patientcode="<?php echo $patientcode;?>" id="<?php echo $visitcode; ?>" viewname='Radiology'>View Package Radiology History</a></strong></span></td>
			</tr>	
			<tr>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Rad Code</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Rad Name</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Quantity</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Approve &nbsp; Reject</strong></div></td>
				<td width="13%"  align="left" valign="center" bgcolor="" class="bodytext31"><div align="right"><strong></strong></div></td>
			</tr>
			<?php 
			$queryrad = "select * from addpkgitems  where locationcode='$patientlocation' and recordstatus ='' and  patientcode='$patientcode' and visitcode='$visitcode' and package_item_type='RI'";
			$execrad = mysqli_query($GLOBALS["___mysqli_ston"], $queryrad) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrad = mysqli_num_rows($execrad);
			while($resrad = mysqli_fetch_array($execrad))
			{
			$rtot+=$resrad['amount'];
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
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serial_mainnumber_rad=$rsno = $rsno + 1; ?></div>
			<input type="hidden" name="disc_id_rad<?php echo $rsno;?>" value="<?php echo $resrad['id']; ?>"> 
			</td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resrad['itemcode']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resrad['itemname']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resrad['quantity']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resrad['rate']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($resrad['amount'],2,'.',','); ?></div>
			<input type="hidden" name="item_radamount<?php echo $rsno;?>" id="item_radamount<?php echo $rsno;?>" value="<?php echo $resrad['amount']; ?>" />
			</td>
			<td class="bodytext31" valign="center"  align="center"><div class="bodytext31" align="center"><input type="checkbox" style="zoom:1.5;"  name="item_approve_rad<?php echo $rsno;?>" id="item_approve_rad<?php echo $rsno;?>" value="<?php echo $resrad['id']; ?>"  onclick="return statuscheck_rad('<?php echo $rsno;?>')"> &nbsp; 
			<input type="checkbox" style="zoom:1.5;" name="item_reject_rad<?php echo $rsno;?>" id="item_reject_rad<?php echo $rsno;?>" value="<?php echo $resrad['id']; ?>"  class="select" onclick="return statuscheck_rad('<?php echo $rsno;?>')"></div>
			</td>
			<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div align="center" ><textarea  id="rej_remarks_rad<?php echo $rsno;?>" name="rej_remarks_rad<?php echo $rsno;?>" rows="2" cols="14" placeholder="Comments" style="display:none" ></textarea></div></td>	</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" style="text-align: right;" id="total2" readonly value="<?php echo number_format($rtot,2,'.',',');?>" size="7"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="4" align="left" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><span class="bodytext32"><strong>Services </strong></span></td>
				<td colspan="3" align="Right" valign="middle"  bgcolor="#cbdbfa" class="bodytext3"><span class="bodytext32"><strong><a href="#" class="viewitemhistory" patientcode="<?php echo $patientcode;?>" id="<?php echo $visitcode; ?>" viewname='Service'>View Package Service History</a></strong></span></td>
		    </tr>
			<tr>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Ser Code</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Ser Name</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Quantity</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Approve &nbsp; Reject</strong></div></td>
				<td width="13%"  align="left" valign="center" bgcolor="" class="bodytext31"><div align="right"><strong></strong></div></td>
			</tr>
			<?php 
			$queryser = "select * from addpkgitems  where locationcode='$patientlocation' and recordstatus= '' and  patientcode='$patientcode' and visitcode='$visitcode' and package_item_type='SI'";
			$execser = mysqli_query($GLOBALS["___mysqli_ston"], $queryser) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numser = mysqli_num_rows($execser);
			while($resser= mysqli_fetch_array($execser))
			{
			$stot+=$resser['amount'];
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
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serial_mainnumber_ser=$ssno = $ssno + 1; ?></div>
			<input type="hidden" name="disc_id_ser<?php echo $ssno;?>" value="<?php echo $resser['id']; ?>"> 
			</td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resser['itemcode']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resser['itemname']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resser['quantity']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resser['rate']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($resser['amount'],2,'.',','); ?></div>
			<input type="hidden" name="item_seramount<?php echo $ssno;?>" id="item_seramount<?php echo $ssno;?>" value="<?php echo $resser['amount']; ?>" />
			</td>
			<td class="bodytext31" valign="center"  align="center"><div class="bodytext31" align="center"><input type="checkbox" style="zoom:1.5;"  name="item_approve_ser<?php echo $ssno;?>" id="item_approve_ser<?php echo $ssno;?>" value="<?php echo $resser['id']; ?>"  onclick="return statuscheck_ser('<?php echo $ssno;?>')"> &nbsp; 
			<input type="checkbox" style="zoom:1.5;"  name="item_reject_ser<?php echo $ssno;?>" id="item_reject_ser<?php echo $ssno;?>" value="<?php echo $resser['id']; ?>"  class="select" onclick="return statuscheck_ser('<?php echo $ssno;?>')"></div>
			</td>
			<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div align="center" ><textarea  id="rej_remarks_ser<?php echo $ssno;?>" name="rej_remarks_ser<?php echo $ssno;?>" rows="2" cols="14" placeholder="Comments" style="display:none"></textarea></div></td>	</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" style="text-align: right;" id="total2" readonly value="<?php echo number_format($stot,2,'.',',');?>" size="7"></td>
			</tr>
				   
			<tr>
			<td>&nbsp;</td>
			</tr>

			<tr>
			<td colspan="4" class="bodytext31" valign="center"  align="right" ></td>
			<td colspan="2" class="bodytext31" valign="center"  align="right" style="font-size:16px"><strong>Grand Total</strong></td>
			<td colspan="" class="bodytext31" valign="center"  align="right" style="font-size:16px"><strong><input type='text' id="grandtotal" name="grandtotal" class="bal1" size="6" readonly></strong></td>
			<td colspan="4" class="bodytext31" valign="center"  align="right" >
			<input type="hidden" id="serial_mainnumber_pharma" name="serial_mainnumber_pharma" value="<?php echo $serial_mainnumber_pharma;?>" />
			<input type="hidden" id="serial_mainnumber_lab" name="serial_mainnumber_lab" value="<?php echo $serial_mainnumber_lab;?>" />
			<input type="hidden" id="serial_mainnumber_rad" name="serial_mainnumber_rad" value="<?php echo $serial_mainnumber_rad;?>" />
			<input type="hidden" id="serial_mainnumber_ser" name="serial_mainnumber_ser" value="<?php echo $serial_mainnumber_ser;?>" />
			<input type="hidden" name="frm1submit1" value="frm1submit1" />
			<input style="padding: 10px 30px;" name="Submit222" type="submit" id="saveitems" value="Save" accesskey="s" class="button"/>
			
			</td>
			
			</tr>

				   
          </tbody>
        </table>	
		</td>
		</tr>
		<tr>
			<td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
	
		
	
    </table>
</td>
</tr>
</table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
<div id="items_dialog" title="Package Items History" width="500px" height="300px"> </div>
</body>
</html>