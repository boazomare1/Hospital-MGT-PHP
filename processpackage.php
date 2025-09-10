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
$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly = date("H:i:s");
$titlestr = 'SALES BILL';
$var112=0;


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   

//get locationcode and locationname for inserting
$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$docnumber=$_REQUEST['docnumber'];
$dateonly = date("Y-m-d");
$account = $_REQUEST['account'];

$query231 = "select locationcode,locationname from master_employeelocation where username='$username'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$locationcodeget = $res231['locationcode'];
$locationnameget = $res231['locationname'];

$query231 = "select storecode from master_employeelocation where username='$username' and defaultstore = 'default'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7storeanum1 = $res231['storecode'];

//$res7storeanum1 = $res231['store'];

$query751 = "select store from master_store where auto_number='$res7storeanum1'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
 $storecodeget = $res751['store'];
  $storenameget = $res751['store'];
//print_r($_POST['select']);
//print_r($_POST['service']);
// echo $avqty = $_REQUEST['avqty1']; 


 echo $serialnum=$_REQUEST['serialnum'].'<br>'; 
$mmm=0;

$query01="";

foreach ($_POST['keysno'] as $key => $value)
{
	
 $slctkey = $_POST['keysno'][$key];
	 
	
	if($_POST['select'][$slctkey] != '')
	{
		 $fifocode = $_POST['fifocode'][$key];
		 $pharmacycode = $_POST['pharmacycode'][$key];
		 $storecode = $_POST['storecode'][$key];
		 $pharmacyquantityenter1 = $_POST['pharmacyquantityenter'][$key]; 
		 $pharmacyquantity = $_POST['pharmacyquantity'][$key];
		 $locationcodeget;
		if($mmm==0)
		{
			$query01="select itemcode,batch_quantity from transaction_stock where (batch_stockstatus='1' and itemcode='$pharmacycode' and locationcode='$locationcodeget' and fifo_code='$fifocode' and storecode ='$storecode' and batch_quantity>='$pharmacyquantity')";
			$ses=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
			 $num=mysqli_num_rows($ses);
			
		}
		else
		{
			$query01.=" union all select itemcode,batch_quantity from transaction_stock where (batch_stockstatus='1' and itemcode='$pharmacycode' and locationcode='$locationcodeget' and fifo_code='$fifocode' and storecode ='$storecode' and batch_quantity>='$pharmacyquantity')";
			$ses=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

		}
			
	}

$mmm+=1;

}
 $query01; 

$exec01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
 $num01=mysqli_num_rows($exec01);
 
if($num01!=$serialnum)
{
	header('location:packageissue.php?st=matchfailed');
}

foreach ($_POST['keysno'] as $key => $value)
{
	
	 $slctkey = $_POST['keysno'][$key];
	 
	
	if($_POST['select'][$slctkey] != '')
	{
		 $auto_numberget = $_POST['auto_numberget'][$key]; 
		$pharmacyquantityenter = $_POST['pharmacyquantityenter'][$key];
		
		$pharmacyquantity = $_POST['pharmacyquantity'][$key];
		$balanceqty=$pharmacyquantity-$pharmacyquantityenter;
		$pharmacycode = $_POST['pharmacycode'][$key];
	 		$pharmacyname = $_POST['pharmacyname'][$key];
						                      
		$insertkey = $_POST['insertkey'][$key];
		
		$fifocode = $_POST['fifocode'][$key];
		$batchno = $_POST['batchno'][$key];
		$cumqty = $_POST['cumqty'][$key];
		$entrydocno = $_POST['entrydocno'][$key];
		$locationcode = $_POST['locationcode'][$key];
		$storecode = $_POST['storecode'][$key];
		$rate = $_POST['rate'][$key];
		
		$quantity=$pharmacyquantityenter;
		$itemcode=$pharmacycode;
		$fifo_code=$fifocode;
		$storecodeget=$storecode;
		
					   
			$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rescumstock2 = mysqli_fetch_array($execcumstock2);
				$cum_quantity = $rescumstock2["cum_quantity"];
				$cum_quantity = $cum_quantity-$quantity;
				if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}
				//echo $cum_quantity.','.$itemcode.'<br>';
				if($cum_quantity>='0')
				{
					$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget' and fifo_code='$fifo_code' and storecode ='$storecodeget'";
					$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resbatstock2 = mysqli_fetch_array($execbatstock2);
					$bat_quantity = $resbatstock2["batch_quantity"];
					$bat_quantity = $bat_quantity-$quantity;
					//echo $bat_quantity.','.$itemcode.'<br>';
					if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
					if($bat_quantity>='0')
					{
						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget' and storecode='$storecodeget' and fifo_code='$fifo_code'";
						$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget'";
						$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					
						$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
						batchnumber, batch_quantity, 
						transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice)
						values ('$fifo_code','process_package','$itemcode', '$pharmacyname', '$dateonly','0', 'Package', 
						'$batchno', '$balanceqty', '$quantity', 
						'$cum_quantity', '$entrydocno', 'companyanum','$cum_stockstatus','$batch_stockstatus', '$locationcodeget','$locationnameget','$storecode', '$storenameget', '$username', '$ipaddress','$dateonly1','$timeonly','$updatedatetime','$patientcode','$visitcode','$patientname','$rate','$amountget')";
						
					$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$amount=$quantity*$rate;
						$query32 = "insert into pharmacysales_details(fifo_code,itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,instructions,categoryname,route,locationname,locationcode)values('$fifo_code','$pharmacyname','$itemcode','$quantity','$rate','$amount','$batchno','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly1','$account','$docnumber','$timeonly','$locationnameget','$storecode','','','','$locationnameget','$locationcodeget')"; 
					$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						
						
					}
					else
					{
						 header("location:packageissue.php?batqty=error");
						exit;	
					}
				}
				else
				{
					 header("location:packageissue.php?cumqty=error");
					exit;
				}
					
}
	
	}
 
 header("location:packageissue.php");
 exit();
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<script src="jquery/jquery-1.11.3.min.js"></script>
<script>


	
	function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;

  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
  return false;
 }
}
function sumtheservice(val,keys)
{
	//alert(val);alert(keys);
	var totalqty = document.getElementById("serquantity"+keys).value;
	var aqty = document.getElementById("avqtyy"+keys).value;
	
	var rqty = document.getElementById("rfqty"+keys).value;
	
	//alert(rqty);
	if(parseFloat(rqty)>parseFloat(totalqty))
	{
		alert("Return quantity Greater than Totalqunatity");
		document.getElementById("rfqty"+keys).value=0;
		document.getElementById("avqtyy"+keys).value=totalqty;
		return false;
		}
		var actqty = parseFloat(totalqty)-parseFloat(val);
		document.getElementById("avqtyy"+keys).value = actqty;
	}
function validcheck()
{

	
	var sno;
	var v2=1;
	var v1=document.getElementById("var112code").value;
	while(v2<=v1)
	{
		//alert(v1+','+v2);
		sno=document.getElementById("keysno"+v2).value;
		if(document.getElementById("select"+sno).checked==true)
		{

	var id1="pharmacyquantityenter"+v2;
	var id2="pharmacyquantity"+v2;
	var varqty=parseFloat(document.getElementById(id1).value);
	var varavlqty=parseFloat(document.getElementById(id2).value);
	
		if((varqty>varavlqty))
		{
		alert("Enter value below the available quantity");
		document.getElementById(id1).value=0;
		document.getElementById(id1).focus();
		return false;
		}
		
		}
		v2++;
	}
	
//alert();
if(confirm("Do You Want To Save The Record?")==false){return false;}	

}

function acknowledgevalid(value)
{

var val=value;

if(document.getElementById("select"+val+"").checked == false)
{
alert("Please Select The Check Box..!");
return false;
}


var pharmacycodeget = document.getElementsByClassName('pharmacycodeget'); 
 
 for(var j=0;j<pharmacycodeget.length;j++)
 {
		var classname=pharmacycodeget[j].value;		
var coinsurerlevis1 = document.getElementsByClassName(classname); 
var cc=0;

var consta= document.getElementById(classname).value;

 for(var i=0;i<coinsurerlevis1.length;i++)
 {
  if(coinsurerlevis1[i].value=='')
  {
   cc=0;
  }
  else
  {
   cc=parseFloat(cc)+parseFloat(coinsurerlevis1[i].value);
  }
 }
 
 if(cc>consta)
 {
 	alert("Please Enter the Quantity Less Than or Equal to Oredered Quantity");
	return false;
 }
 
 }

}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
document.getElementById("ref"+varserialnumber+"").disabled = false;
}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{

document.getElementById("ack"+varserialnumber1+"").disabled = true;
}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
}
}

function funcOnLoadBodyFunctionCall()
{
var varbilltype = document.getElementById("billtype").value;
if(varbilltype == 'PAY LATER')
{
/*for(i=1;i<=100;i++)
{
document.getElementById("ref"+i+"").disabled = true;
}*/
}
}

</script>
<script>
	$(document).ready(function()
	{
		
		$(".checkdiv").hide();
		
		$('input[type="checkbox"]').change(function() {
		var idname=this.value;
       
        $('#'+idname).slideToggle( "slow"); });
		
	});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function Qty(v1)
{
	var id1="pharmacyquantityenter"+v1;
	var id2="pharmacyquantity"+v1;
	var varqty=parseFloat(document.getElementById(id1).value);
	var varavlqty=parseFloat(document.getElementById(id2).value);
	
	if((varqty>varavlqty))
	{
		alert("Enter value below the available quantity");
		document.getElementById(id1).value=0;
		document.getElementById(id1).focus();
		return false;
	}
	return true;

}

function Qty1(v2)
{
	var id1="pharmacyquantityenter"+v2;
	var varqty=document.getElementById(id1).value;
	
	if(varqty=='')
	{
		alert("Enter the quantity");
		document.getElementById(id1).value=0;
		document.getElementById(id1).focus();
		return false;
	}
	return true;
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
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>

<?php
$query65= "select patientfullname,age,gender,locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];
$patientage=$res65['age'];
$patientgender=$res65['gender'];
$locationcodeget=$res65['locationcode'];
 
$query33 = "select locationname from master_location where locationcode='".$locationcodeget."'";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res33 = mysqli_fetch_array($exec33);
 $locationnameget = $res33['locationname'];

$query69="select accountname from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];




$query70="select accountname from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'PS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select docnumber from process_service where patientcode <> 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PS-'.'1';
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
	
	
	$billnumbercode = 'PS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="processpackage.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="25%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="28%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td width="18%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>
                  </td>
               
              </tr>
			 
		
			  <tr>

			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="25%" align="left" valign="middle" class="bodytext3">
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
              <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store </strong></td>

	<?php
               $query231 = "select employeecode from master_employee where username='$username'";
        $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $res231 = mysqli_fetch_array($exec231);
        $searchemployeecode = $res231['employeecode'];
      
      $query34 = "select storecode,defaultstore from master_employeelocation where employeecode = '$searchemployeecode' and locationcode='$locationcodeget' and defaultstore='default' ";
      $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res34 = mysqli_fetch_array($exec34);
      $storecode = $res34['storecode'];
      $default = $res34['defaultstore'];
       
      $query35 = "select store,storecode,auto_number from master_store where auto_number = '$storecode'";
      $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res35 = mysqli_fetch_array($exec35);
      
      $store = $res35['store'];
      $storec = $res35['storecode'];
      $sanum = $res35['auto_number'];
      // if($default == 'default')
	   {?>
        <td width="25%" align="left" valign="middle" class="bodytext3"><?php echo $store; ?></td>
       <?php
        } 
                        //}
      ?>
             
                <?php  /* $query35 = "select * from master_store where locationcode = '$locationcodeget'";
						$exec35 = mysql_query($query35) or die ("Error in Query35".mysql_error());
						while($res35 = mysql_fetch_array($exec35))
						{
						$store = $res35['store'];
						$storec = $res35['storecode'];
						$sanum = $res35['auto_number'];
						 
						
						  $query231 = "select * from master_employee where username='$username'";
						  $exec231 = mysql_query($query231) or die(mysql_error());
						  $res231 = mysql_fetch_array($exec231);
						  $searchemployeecode = $res231['employeecode'];
						
						 $query34 = "select * from master_employeelocation where employeecode = '$searchemployeecode' and storecode = '$sanum'";
						$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
						$res34 = mysql_fetch_array($exec34);
						 $default = $res34['defaultstore'];
						 if($default == 'default') {?>
						  <td width="25%" align="left" valign="middle" class="bodytext3"><?php echo $storec; ?></td>
						 <?php } 
                        }*/
						?>
                        
               
                 
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3" >
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?></td>
                
               
            
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3" ><?php echo $locationnameget;?></td>
                <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget;?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget;?>">
						  </tr>
			   
			   
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
             <td width="14%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
              <td width="31%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Quantity</strong></div></td>

					<td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
					<td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
                 
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;			
			$query61 = "select billtype,auto_number,package from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' and package <> '0' and (billtype='PAY NOW' or (billtype='PAY LATER' ))";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
while($res61 = mysqli_fetch_array($exec61))
{
	//$serviceqty =$res61["serviceqty"];
	/*for($i=0; $i<$serviceqty; $i++)
	{ */
//$servicename =$res61["servicesitemname"];
$billtype = $res61["billtype"];
$refno = $res61['auto_number'];

$package=$res61['package'];

$query68="select auto_number,packagename from master_ippackage where auto_number='$package'";

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$itemcode=$res68['auto_number'];
$servicename=$res68['packagename'];
$sno = $sno + 1;
?>
  <tr id="idTRMain<?php echo $sno; ?>">
  		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="select[<?php echo $sno;  ?>]"  id="select<?php echo $sno;  ?>"  value="check<?php echo $sno;  ?>"  > </div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicename;?></div></td>
		<input type="hidden" name="service[]" value="<?php echo $servicename;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="refno[]" value="<?php echo $refno; ?>">
		<input type="hidden" name="sno[]" value="<?php echo $sno; ?>">
		<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">
        <input type="hidden" name="serquantity<?php echo $sno; ?>" id="serquantity<?php echo $sno; ?>" value="<?php echo $serviceqty; ?>">
		  <td class="bodytext31" valign="center"  align="center"><?php echo '';?>
			 		  </td>

		   <td class="bodytext31" valign="center"  align="center">
           <input type="hidden" name="avqtyy<?php echo $sno;?>" id="avqtyy<?php echo $sno;?>" readonly value="<?php echo $serviceqty;?>" size="5" style="border:none;background: none;">
       </td>
		<td class="bodytext31" valign="center"  align="center">
        <input type="hidden" name="rfqty<?php echo $sno;?>" id="rfqty<?php echo $sno;?>"  value="" size="5" onKeyDown="return numbervaild(event)" onKeyUp="sumtheservice(this.value,<?php echo $sno;?>)">
       </td>
				</tr>
				
                
				<tr >
			<td colspan="7"  align="left" valign="center" class="bodytext31">
            <div class="checkdiv" id="check<?php echo $sno; ?>">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%"
            align="left" border="0">
            
              <tbody>
              
              <tr>
              <td width="129"></td>
                           <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center"><strong> Itemname </strong></td>
                            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="132"><strong> Qty</strong></td>
                            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="174"><strong> Avl Qty</strong></td>
                   <td width="215"></td>        
                           </tr> 
               
			   <?php 
			 /*  $subTRsno = 0;
			   $sn = 0;
			   mysql_set_charset('utf8');
			   $query52="select * from master_packageslinking where packagecode='$itemcode' and recordstatus=''";
			   $exec52=mysql_query($query52);
			   $num=mysql_num_rows($exec52);
			   while($res52=mysql_fetch_array($exec52))
			   {
			   $pharmacyname=$res52['itemname'];
		       $pharmacyname = htmlentities($pharmacyname); 

			   $pharmacycode=$res52['itemcode'];
			   $pharmacyquantity = $res52['quantity'];
			    /* $query52="select * from master_lab where itemname='$labname2'";
				  $exec52=mysql_query($query52);
				  $res52=mysql_fetch_array($exec52);
				  }*/
				  
				
				
						   ?>
                           
			<!--			     <tr >
					<td></td>
                    		 <input type="hidden" value="<?php //echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="296"><div class="bodytext311"> <?php echo $pharmacyname; ?></div></td>
				   <input type="hidden" name="pharmacyname[]" value="<?php echo $pharmacyname;?>">
				  <input type="hidden" name="pharmacycode[]" value="<?php echo $pharmacycode; ?>">
				  
				
                  <td width="132" align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">
				   <input type="text" name="pharmacyquantityenter[]" id="pharmacyquantityenter"  value="<?php echo $pharmacyquantity; ?>" size="10" onKeyPress="return isNumber(event)" >
				 
				   </div></td>
                   <td width="174" align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">
				   <input type="text" name="pharmacyquantity[]" id="pharmacyquantity"  size="10" readonly>
				 
				   </div></td>
                  
                  <td></td>    
              </tr>-->
			
         
         <?php
		 
		 $i=0;
$loopcontrol='';
$subTRsno=0;

 //echo "select * from master_packageslinking where packagecode='$itemcode' and recordstatus=''"; 
 $query35=mysqli_query($GLOBALS["___mysqli_ston"], "select itemcode,itemname,quantity from master_packageslinking where packagecode='$itemcode' and recordstatus=''");

while($exec35=mysqli_fetch_array($query35))
{

 $pharmacycode=$exec35['itemcode'];
 $pharmacyname=$exec35['itemname'];
 $pharmacyname = htmlentities($pharmacyname); 
 $pharmacycode=$exec35['itemcode'];
 $pharmacyquantity = $exec35['quantity'];
 $loopsub=0;
  $loop=0;
 $query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storec."' AND locationcode='".$locationcodeget."' AND itemcode = '$pharmacycode' and batch_quantity > 0 and transactionfunction = 1 group by fifo_code order by auto_number";
//echo $query57;
$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
$num57=mysqli_num_rows($res57);
//echo $num57;
while($exec57 = mysqli_fetch_array($res57))
{

//echo $fifo_code1 = $exec57["fifo_code"];
 $fifo_code1 = $exec57["fifo_code"];
$batchname1 = $exec57['batchnumber'];

 
  $queryinner = "select batchnumber,batch_quantity,description,auto_number,fifo_code,cum_quantity,entrydocno,locationcode,storecode,rate from transaction_stock where storecode='".$storec."' AND locationcode='".$locationcodeget."' AND itemcode = '$pharmacycode' and  fifo_code = '".$fifo_code1."' and batchnumber = '".$batchname1."' order by auto_number desc limit 0,1";
//echo $query57;
$resinner=mysqli_query($GLOBALS["___mysqli_ston"], $queryinner);
$numinner=mysqli_num_rows($resinner);
//echo $num57;
while($execinner = mysqli_fetch_array($resinner))
{
	
//echo	$fifo_code = $execinner["fifo_code"],',';
 $batchname = $execinner['batchnumber'];
  
  $batch_quantity = $execinner["batch_quantity"];
  if($batch_quantity <= 0 )
	   { $num57=$num57-1; }
       if($batch_quantity > 0 )
	   {              
//echo $batchname;
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
			$description = $execinner["description"];

$currentstock = $execinner["batch_quantity"];

$auto_numberget= $execinner["auto_number"];

$fifo_code = $execinner["fifo_code"];
$batchnumber = $execinner["batchnumber"];
$cum_quantity = $execinner["cum_quantity"];
$entrydocno = $execinner["entrydocno"];
$locationcode = $execinner["locationcode"];
$storecode = $execinner["storecode"];
$rate = $execinner["rate"];

$companyanum = $_SESSION[""];

  $loop=$currentstock-$pharmacyquantity;

if($loopsub==1)
{
	  $loop=$loop+$currentstock;
	}
	
	$var112+=1;
	
 ?>
	  	
            			     <tr >
					<td></td>
                    		 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="296"><div class="bodytext311"> <?php echo $pharmacyname; ?></div></td>
				   <input type="hidden" name="pharmacyname[]" value="<?php echo $pharmacyname;?>">
				  <input type="hidden" class="pharmacycodeget" name="pharmacycode[]" value="<?php echo $pharmacycode; ?>">
				  
                     <input type="hidden" id="<?php echo $pharmacycode?>"  value="<?php echo $pharmacyquantity; ?>" size="10"  > 
				
                  <td width="132" align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">
				   <input type="text" name="pharmacyquantityenter[]" id="pharmacyquantityenter<?= $var112 ?>"  value="<?php echo $pharmacyquantity; ?>" size="10" onKeyPress="return isNumber(event)" onKeyUp="return Qty(<?= $var112 ?>)" class="<?php echo $pharmacycode?>" onChange="return Qty1(<?= $var112 ?>)">
				 
				   </div></td>
                   <td width="174" align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">
				   <input type="text" name="pharmacyquantity[]" id="pharmacyquantity<?= $var112 ?>"  value="<?= $currentstock;?>" size="10" readonly>
                    
                 
                    
                   
                    <input type="hidden" name="auto_numberget[]"  value="<?= $auto_numberget;?>" size="10" readonly>
                    
                     <input type="hidden" name="keysno[]" id="keysno<?= $var112 ?>"  value="<?= $sno;?>" size="10" readonly>
                     
                      <input type="hidden" name="fifocode[]"  value="<?= $fifo_code;?>" size="10" readonly>
                      <input type="hidden" name="batchno[]"  value="<?= $batchnumber;?>" size="10" readonly>
                      <input type="hidden" name="cumqty[]"  value="<?= $cum_quantity;?>" size="10" readonly>
                      <input type="hidden" name="entrydocno[]"  value="<?= $entrydocno;?>" size="10" readonly>
                      <input type="hidden" name="locationcode[]"  value="<?= $locationcode;?>" size="10" readonly>
                      <input type="hidden" name="storecode[]"  value="<?= $storecode;?>" size="10" readonly>
                      <input type="hidden" name="rate[]"  value="<?= $rate;?>" size="10" readonly>
                      <input type="hidden" name="pharmacyquantityhidden[]"  value="<?php echo $pharmacyquantity;?>" size="10" readonly>
                      
                    
				 
				   </div></td>
                  
                  <td></td>    
              </tr>
              
            
            
            <!--  <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1medicinename1;?></div></td>
			 <input type="hidden" name="medicine[]" value="<?php echo $res1medicinename;?>" />
			 <input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>" />
             <input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1dose;?></div></td>
					    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1frequency;?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1days;?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res3quantity;?></div></td>
			 <input type="hidden" name="quantity[]" value="<?php echo $res1quantity;?>" />
			 

			 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batchname;?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $currentstock;?></div></td>
					 <input type="hidden" name="batch[]" value="<?php echo $batchname;?>" />
				<input type="hidden" name="rate[]" value="<?php echo $res1rate;?>" />
				<input type="hidden" name="pending1[]" value="<?php echo $pending; ?>">
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $issuequantity;?></div></td>
				 <input type="hidden" name="amount[]" value="<?php echo$res1amount;?>" />
				 <input type="hidden" name="issue[]" value="<?php echo $issuequantity;?>">
				 			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1route;?></div></td>
			 <input type="hidden" name="route[]" value="<?php echo $res1route;?>" />
			  <input type="hidden" name="days[]" value="<?php echo $res1days;?>" />
			   <input type="hidden" name="dose[]" value="<?php echo $res1dose;?>" />
			    <input type="hidden" name="frequency[]" value="<?php echo $res1frequency;?>" />
		
			 	 <td class="bodytext31" valign="center"  align="left"> <input type="text" name="instructions[]" value="<?php echo $instructions ;?>" size="25" align="absmiddle"></div></td>
                 <input type="hidden" name="currentstock" value="<?php echo $currentstock;?>">
				 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pending; ?></div></td>
				 <td class="bodytext31" valign="center"  align="center">
                 <input type="hidden" name="pending" value="<?php echo $pending; ?>"></td>
				  	</tr>-->
			<?php 
			/*if($totalstock >= $res1quantity)
			{
			$loopcontrol = 'stop';
			}
		*/
			//}
}
}
$batch_quantity;
if($batch_quantity > 0 )
{
			if($loop>=0){
	$loopsub=0;
	?>
	<!-- <input type="text" name="insertkey[]"  value="<?= 1;?>" size="10" readonly>-->
	<?php
	break;
	}
	/*else if($num57==1)
	{
		?><input type="text" name="insertkey[]"  value="<?= 1;?>" size="10" readonly><?php
		}
		else 
	{
		?><input type="text" name="insertkey[]"  value="<?= 0;?>" size="10" readonly><?php
		}*/
		
		
$loopsub=1;
}
			}
}
		 ?>
         	
			</tbody>
            </table>	  
		</div>		</td>
			
			 </tr>
           
			<?php 
		
			}
		?>
        <input type="hidden" name="serialnum" value="<?php echo $subTRsno; ?>">
         <input type="hidden" id="var112code" value="<?= $var112 ?>">	
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
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = 'none';
					}
				}

				if (document.getElementById("idTRSub"+varSerialNumber+"") != null) 
				{
					document.getElementById("idTRSub"+varSerialNumber+"").style.display = '';
				}
			}
			
			function funcShowDetailHide(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = 'none';
					}
				}
			}
			</script>
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
                bgcolor="#ecf0f5">&nbsp;</td>
              
               </tr>
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save" onClick="return acknowledgevalid(<?php echo $sno;  ?>)" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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