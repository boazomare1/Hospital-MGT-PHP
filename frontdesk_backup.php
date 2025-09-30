<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todayfromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todaytodate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$res1location=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
//$time=strtotime($todaydate);
//$month=date("m",$time);
//$year=date("Y",$time);
if($locationcode==''){
$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"]; 
$locationcode= $res1["locationcode"];
}
  //$thismonth=$year."-".$month."___";
?>
<?php
  /*$register="select count(auto_number) as registered from master_customer where registrationdate='$todaydate'";
$regex=mysqli_query($GLOBALS["___mysqli_ston"], $register);
$totreg=mysqli_fetch_array($regex);
$registered=$totreg['registered'];*/
$newip="select count(visitcode) as activeip from master_ipvisitentry where bedallocation='completed' and consultationdate between '$todayfromdate' and '$todaytodate'";
$queryip=mysqli_query($GLOBALS["___mysqli_ston"], $newip);
$resip=mysqli_fetch_array($queryip);
$newipvi=$resip['activeip'];
 $currentip="select count(visitcode) as activeip from ip_bedallocation where recordstatus !='discharged'";
$queryactip=mysqli_query($GLOBALS["___mysqli_ston"], $currentip);
$resactip=mysqli_fetch_array($queryactip);
$activeip=$resactip['activeip'];
//lab//
 $oplab="select patientvisitcode from consultation_lab where consultationdate between '$todayfromdate' and '$todaytodate' and labsamplecoll='completed'";
$labop=mysqli_query($GLOBALS["___mysqli_ston"], $oplab);
$oplabcount=0;
$walkinlabcount=0;
while($oplabtot=mysqli_fetch_array($labop))
{
  $oplabvisitcode=$oplabtot['patientvisitcode'];
 $queryoplab="select department from master_visitentry where visitcode='$oplabvisitcode'";
$querylabex=mysqli_query($GLOBALS["___mysqli_ston"], $queryoplab);
 $reslab=mysqli_fetch_array($querylabex);
  $oplabdept=$reslab['department'];
if($oplabdept =="50")
{
	 $walkinlabcount++;
	}
else if($oplabdept !="50")
{
	 $oplabcount++;
}
}
//radiology//
$opradiology="select patientvisitcode from consultation_radiology where consultationdate  between '$todayfromdate' and '$todaytodate' and prepstatus='completed'";
$radiop=mysqli_query($GLOBALS["___mysqli_ston"], $opradiology);
$opradcount=0;
$walkinradcount=0;
while($opradtot=mysqli_fetch_array($radiop))
{
$opradvisitcode=$opradtot['patientvisitcode'];
$queryrad="select department from master_visitentry where visitcode='$opradvisitcode'";
$queryradex=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad);
$resrad=mysqli_fetch_array($queryradex);
$opraddept=$resrad['department'];
if($opraddept=='50')
{
	$walkinradcount++;
	}
else if($opraddept !='50')
{
	$opradcount++;
}
}
//services//
$opservices="select patientvisitcode from consultation_services where consultationdate  between '$todayfromdate' and '$todaytodate' and process='completed'";
$radiop=mysqli_query($GLOBALS["___mysqli_ston"], $opservices);
$opsercount=0;
$walkinsercount=0;
while($opsertot=mysqli_fetch_array($radiop))
{
$opservisitcode=$opsertot['patientvisitcode'];
$queryrser="select department from master_visitentry where visitcode='$opservisitcode'";
$queryserex=mysqli_query($GLOBALS["___mysqli_ston"], $queryrser);
$resser=mysqli_fetch_array($queryserex);
$opserdept=$resser['department'];
if($opserdept=='50')
{
	$walkinsercount++;
	}
else if($opserdept !='50')
{
	$opsercount++;
}
}
//ip lab//
  $iplab="select count(auto_number) as iplab from ipconsultation_lab where consultationdate  between '$todayfromdate' and '$todaytodate' and labsamplecoll='completed'";
 $iplabex=mysqli_query($GLOBALS["___mysqli_ston"], $iplab);
 $iplabfe=mysqli_fetch_array($iplabex);
   $iplabcount=$iplabfe['iplab'];
//ip radiology//
$iprad="select count(auto_number) as iprad from ipconsultation_radiology where consultationdate  between '$todayfromdate' and '$todaytodate' and prepstatus='completed'";
$ipradex=mysqli_query($GLOBALS["___mysqli_ston"], $iprad);
$ipradfe=mysqli_fetch_array($ipradex);
$ipradcount=$ipradfe['iprad'];
//ip services//
$ipser="select count(auto_number) as ipser from ipconsultation_services where consultationdate  between '$todayfromdate' and '$todaytodate' and process='completed'";
$ipserex=mysqli_query($GLOBALS["___mysqli_ston"], $ipser);
$ipserfe=mysqli_fetch_array($ipserex);
$ipsercount=$ipserfe['ipser'];
/*
$opwaiver="select sum(labfxamount) as walab,sum(radiologyfxamount) as warad,sum(servicesfxamount) as waser,sum(pharmacyfxamount) as waot from billing_patientweivers where entrydate like '$thismonth'";
$opwaex=mysqli_query($GLOBALS["___mysqli_ston"], $opwaiver);
$opwares=mysqli_fetch_array($opwaex);
$oplabamt=$opwares['walab'];
$opwardamt=$opwares['warad'];
$opwaseramt=$opwares['waser'];
$opwaotamt=$opwares['waot'];
$totalopwaiver=$oplabamt+$opwardamt+$opwaseramt+$opwaotamt;*/
//ip waivers//
  /* $ipwaiver="select sum(rate) as ipwaiver from ip_discount where consultationdate like '$thismonth'";
$ipwaex=mysqli_query($GLOBALS["___mysqli_ston"], $ipwaiver);
$ipwares=mysqli_fetch_array($ipwaex);
$iptotwai=$ipwares['ipwaiver'];*/
//op pending cash//
//  $queryoppending="select sum(transactionamount) as pendingamt from master_transactionpaynow where visitcode not like '%IPV%' and transactiondate='$todaydate'";
//$oppendingex=mysql_query($queryoppending) or die("my error".mysql_error());
//$oppendingamt=mysql_fetch_array($oppendingex);
//$oppenamt=$oppendingamt['pendingamt'];
//walkin and patient//
/*
 $querytotal="select customercode from master_customer where registrationdate='$todaydate'";
$hospitalpatient=0;
$walkin=0;
$totex=mysqli_query($GLOBALS["___mysqli_ston"], $querytotal);
while($regpatient=mysqli_fetch_array($totex))
{
 $registeredpatient=$regpatient['customercode'];
$querymaster="select department from master_visitentry where patientcode='$registeredpatient' and consultationdate='$todaydate'";
$masterex=mysqli_query($GLOBALS["___mysqli_ston"], $querymaster);
$numberofrow=mysqli_num_rows($masterex);
$registeredlist=mysqli_fetch_array($masterex);
$registereddept=$registeredlist['department'];
//if($numberofrow>0)
{
	if($registereddept ==50)
	{
		$walkin++;
	}
	else 
	{
		
		$hospitalpatient++;
	}
}
}
*/
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
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/datetimepicker_css.js"></script>
<script src="datetimepicker1_css.js"></script>
<style>
.hideClass
{display:none;}
</style>
<script language="javascript">
function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
}
function fundatesearch()
{
	alert();
	var fromdate = $("#ADate1").val();
	var todate = $("#ADate2").val();
	var sortfiled='';
	var sortfunc='';
	
	var dataString = 'fromdate='+fromdate+'&&todate='+todate;
	
	$.ajax({
		type: "POST",
		url: "opipcashbillsajax.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		alert(html);
			//$("#insertplan").empty();
			//$("#insertplan").append(html);
			//$("#hiddenplansearch").val('Searched');
			
		}
	});
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99" colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
   <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
     
		<?php
		$query341 = "select * from master_employee where username = '$username' ";
		$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res341 = mysqli_fetch_array($exec341);
		$rowcount341 = mysqli_num_rows($exec341);
		if($rowcount341 > 0)
		{
		?>
	<tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top">
		<form action="frontdesk.php" method="post">
	    <table width="60%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
			
			
			<?php
			 
			$totalcashamt=0;
			$querycashsales="select sum(totalamount) as amount from billing_paynow where billdate  between '$todayfromdate' and '$todaytodate'";	
			$cashsalesex = mysqli_query($GLOBALS["___mysqli_ston"], $querycashsales) or die ("Error in querycashsales".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cashres = mysqli_fetch_array($cashsalesex);
			$cashamount = $cashres["amount"]; 
			$querycashsalesop="select sum(consultation) as amount from billing_consultation where billdate  between '$todayfromdate' and '$todaytodate'";	
			$cashsalesexip = mysqli_query($GLOBALS["___mysqli_ston"], $querycashsalesop) or die ("Error in querycashsalesop".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cashresip = mysqli_fetch_array($cashsalesexip);
			$cashamountop = $cashresip["amount"]; 
			$newcasham=$cashamount+$cashamountop;
			$querycashsalesip="select sum(totalamountuhx) as amount from billing_ip where billdate  between '$todayfromdate' and '$todaytodate' and patientbilltype='PAY NOW'";	
			$cashsalesipex = mysqli_query($GLOBALS["___mysqli_ston"], $querycashsalesip) or die ("Error in querycashsalesip".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cashresip = mysqli_fetch_array($cashsalesipex);
			$cashamountip = $cashresip["amount"]; 
			$querysumip="select sum(transactionamount) as newamount from master_transactionipdeposit where transactiondate  between '$todayfromdate' and '$todaytodate'";
			$cashsumipex = mysqli_query($GLOBALS["___mysqli_ston"], $querysumip) or die ("Error in querysumip".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cashsumip = mysqli_fetch_array($cashsumipex);
			$depositcashamount = $cashsumip["newamount"]; 
			$newcashamount=$cashamountip+$depositcashamount;
			//$querysumip="select sum(transactionamount) as newamount from pos_payment where billdate='$todaydate' and visit_type <> 2";
			//$cashsumipex = mysql_query($querysumip) or die ("Error in querysumip".mysql_error());
			//$cashsumip = mysql_fetch_array($cashsumipex);
			//$newcasham = $cashsumip["newamount"]; 
			//$querysumip="select sum(transactionamount) as newamount  from pos_payment where billdate='$todaydate' and visit_type = 2";
			//$cashsumipex = mysql_query($querysumip) or die ("Error in querysumip".mysql_error());
			//$cashsumip = mysql_fetch_array($cashsumipex);
			//$newcashamount = $cashsumip["newamount"]+$depositcashamount; 
			$totalcashamt=$newcasham+$newcashamount;	
			$drresult = array();
			$j = 0;
			$crresult = array();
			$querycr1 = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate  between '$todayfromdate' and '$todaytodate' and wellnessitem <> 1 and locationcode='$locationcode'
			UNION ALL SELECT SUM(`cashamount`) as income FROM `billing_paynowreferal` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE billdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$j = $j+1;
			//print_r($resdr1);
			$crresult[$j] = $rescr1['income'];
			//$paylater = $result[$i];
			}	
			//echo "total ".array_sum($crresult)." and ".array_sum($drresult);
			 $totalopcash = array_sum($crresult) - array_sum($drresult);
			 /*$creditsales="select visitcode,fxamount,billnumber from master_transactionpaylater where transactiondate  between '$todayfromdate' and '$todaytodate' and transactiontype='finalize' ";
			$creditsalesex = mysqli_query($GLOBALS["___mysqli_ston"], $creditsales) or die ("Error in creditsales".mysqli_error($GLOBALS["___mysqli_ston"]));
			$transactionamount=0;
			$transactionamount1=0;
			$credittotal=0;
			while($creditres = mysqli_fetch_array($creditsalesex))
			{
			$visitcode = $creditres["visitcode"];
			$transamt = $creditres["fxamount"];
			$transbill = $creditres["billnumber"];
			$subbill=explode('-',$visitcode);
			$subvisit=$subbill[0];
			 
			//$subvisit=substr($visitcode,-1);
			if($subvisit!="OPV")
			{
			$transactionamount+=$transamt;
			}
			else
			{
			$transactionamount1+=$transamt;
			}
			}*/
			$creditsales="select sum(paylateramt) as paylatertotal, sum(ipcreditamount) as ipcredittotal from(
			select sum(totalamount) as paylateramt,'0' as ipcreditamount from billing_paylater where billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL 	select '0' as paylateramt,sum(totalamount) as ipcreditamount from billing_ip where billdate  between '$todayfromdate' and '$todaytodate'	and locationcode='$locationcode'
			UNION ALL 	select '0' as paylateramt,sum(totalamount) as ipcreditamount from billing_ipcreditapproved where billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode')  u  	";
			$creditsalesex = mysqli_query($GLOBALS["___mysqli_ston"], $creditsales) or die ("Error in creditsales".mysqli_error($GLOBALS["___mysqli_ston"]));
			$creditres = mysqli_fetch_array($creditsalesex);
			$transactionamount1 = $creditres["paylatertotal"];
			$transactionamount = $creditres["ipcredittotal"];
			//$transactionamount1=$transamt;
			//$transactionamount+=$transamt;
			$credittotal=$transactionamount+$transactionamount1;
			?>
			
			
		
			
			<tr bgcolor="#ffffff">
				<td width="" align="left" valign="middle"   bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong> </td>
				<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext3">
				<select name="locationcode" id="locationcode">
				<?php
				$query01="select locationcode,locationname from master_employeelocation where username='$username'  group by locationcode";
				$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
				while($res01=mysqli_fetch_array($exc01))
				{?>
				<option value="<?= $res01['locationcode'] ?>" <?php if($locationcode==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
				<?php 
				}
				?>
				</select>
				</td>
				<td colspan="4" align="left" valign="middle"   bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong> </td>
			</tr>
			
			<tr bgcolor="#ffffff">
			<td width="" class="bodytext31"><strong>From Date: </strong></td>
			<td width="" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $todayfromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />&nbsp;<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>			
			<td width="" class="bodytext31"><strong>To Date: </strong></td>
			<td width="" class="bodytext31"><input name="ADate2" id="ADate2" value="<?php echo $todaytodate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />&nbsp;<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></td>
			<td width="" class="bodytext31"><input type="submit" value="Search" /></td>
			 <td  bgcolor="" class="bodytext31" valign="center"  align="right"><a href="xl_frontdesk.php?todaytodate=<?php echo $todaytodate;?>&&todayfromdate=<?php echo $todayfromdate; ?>&&locationcode=<?php echo $locationcode; ?>"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a> </td>
			</tr>
			<tr bgcolor="#ffffff" ><td colspan="6">&nbsp;</td></tr>
			</tbody>
			</table>
         </form>  
		 </td>
		 </tr>
            </table>
<tr><td>&nbsp;</td></tr>
<table width="90%" border="0" style="margin-left:30;">
  <tr>
    
     <?php

		//$query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where transactiondate = '$todaydate' "; 

		$transactiondatefrom = $todayfromdate;
		$transactiondateto = $todaytodate;
		//$paymenttype = $_REQUEST['paymenttype'];

		//	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';
		$snocount = 0;
		$colorloopcount =0;
		//   echo "hii".$locationcode1;
		  $query23 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res23 = mysqli_fetch_array($exec23);
		  
     	  $res2cashamount1 = $res23['cashamount1'];
		  $res2onlineamount1 = $res23['onlineamount1'];
		  $res2creditamount1 = $res23['creditamount1'];
		  $res2chequeamount1 = $res23['chequeamount1'];
		  $res2cardamount1 = $res23['cardamount1'];
		  
		  // echo  "hi".$res23['creditamount1'];
	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where  billingdatetime between '$transactiondatefrom' and '$transactiondateto' "; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  
     	  $res4cashamount1 = $res4['cashamount1'];
		  $res4onlineamount1 = $res4['onlineamount1'];
		  $res4creditamount1 = $res4['creditamount1'];
		  $res4chequeamount1 = $res4['chequeamount1'];
		  $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode'"; 
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where recorddate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res54 = mysqli_fetch_array($exec54))
{
		
			  $res54cashamount1 = $res54['cashamount1'];
		  $res54onlineamount1 = $res54['onlineamount1'];
		  $res54creditamount1 = $res54['creditamount1'];
		  $res54chequeamount1 = $res54['chequeamount1'];
		  $res54cardamount1 = $res54['cardamount1'];
			
			
			}  //refund adv
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto' "; 
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];
		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode'"; 
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where  transactiondate between '$transactiondatefrom' and '$transactiondateto' and locationcode='$locationcode' "; 
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];
		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode'"; 
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
			$query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  
     	   $res11cashamount1 = $res11['cashamount1'];
		  $res11onlineamount1 = $res11['onlineamount1'];
		  $res11creditamount1 = $res11['creditamount1'];
		  $res11chequeamount1 = $res11['chequeamount1'];
		  $res11cardamount1 = $res11['cardamount1'];

		   $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
		  
		  $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;
		  
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
		  
		  $snocount = $snocount + 1;
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
			<td width="" valign="top">
			<table width="80%" border="0" style="font-size:medium;">
			
			<tr bgcolor="#ccc">
			<td  colspan="6" align="left"  style="color:blue"><strong>Collection Summary</strong></td>
			</tr>
			 <tr>
              
              <td width="" align="left" valign="left"  class="bodytext31"  bgcolor="#ffffff" ><strong>Cash</strong></td>
				<td width="" align="left" valign="left" class="bodytext31"  bgcolor="#ffffff" ><strong>Card</strong></td>
				<td width="" align="left" valign="left" class="bodytext31"  bgcolor="#ffffff" ><strong>Cheque</strong></td>
				<td width="" align="left" valign="left" class="bodytext31"   bgcolor="#ffffff" ><strong>Online</strong></td>
				<td width="" align="left" valign="left" class="bodytext31"   bgcolor="#ffffff" ><strong>Mobile Money</strong></td>
				<td width="" align="left" valign="left" class="bodytext31"   bgcolor="#ffffff" ><strong>Total</strong></td>
               
            </tr>
			<tr <?php echo $colorcode; ?>>
			<td  valign="center"  align="right"><div ><?php echo number_format($cashamount1,2,'.',','); ?>  </td>
			<td  valign="center"  align="right"><div ><?php echo number_format($cardamount1,2,'.',','); ?>  </td>
			<td  valign="center"  align="right"><?php echo number_format($chequeamount1,2,'.',','); ?></td>
			<td  valign="center"  align="right"><div align="right"><?php echo number_format($onlineamount1,2,'.',','); ?></td>
			<td  valign="center"  align="right"><div align="right"><?php echo number_format($creditamount1,2,'.',','); ?></td>
			<td  valign="center"  align="right"><div align="right"><?php echo number_format($total,2,'.',','); ?></td>



			</tr>
	
    </table>
	</td>
    <td width=""><table width="247" border="0" style="font-size:medium;">
      <tr bgcolor="#ccc">
        <td colspan="2"  style="color: blue;"><strong>Cash Bills</strong></td>
      </tr>
      <tr bgcolor="#cbdbfa">
        <td width="131">OP Cash Bills</td>
        <td width="106" align="right"><?php echo number_format($totalopcash,2);?></td>
      </tr>
      <tr >
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr >
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td><td width=""><table width="250" border="0" style="font-size:medium;">
      <tr bgcolor="#ccc">
        <td colspan="2"  style="color: blue;"><strong>Current Credit Sales</strong></td>
       
      </tr>
      <tr bgcolor="#CBDBFA">
        <td width="122">OP Credit Bills</td>
        <td width="112" align="right"><?php echo number_format($transactionamount1,2); ?></td>
      </tr>
      <tr  bgcolor="#ecf0f5">
        <td>IP Credit Bills</td>
        <td align="right"><?php echo number_format($transactionamount,2); ?> </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Total</td>
        <td align="right"><?php echo number_format($credittotal,2); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  
	<?php
		$registeredpatient=0;
		$hospitalpatient=0;
		$walkin=0;
		$querytotal="select count(customercode) as customercode from master_customer where registrationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
		$totex=mysqli_query($GLOBALS["___mysqli_ston"], $querytotal);
		$regpatient=mysqli_fetch_array($totex);
		$registeredpatient=$regpatient['customercode'];
		$querymaster="select visitcode from master_visitentry where consultationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
		$masterex=mysqli_query($GLOBALS["___mysqli_ston"], $querymaster);
		$numberofrow=mysqli_num_rows($masterex);
		$querymasterip="select visitcode from master_ipvisitentry where consultationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
		$masterexip=mysqli_query($GLOBALS["___mysqli_ston"], $querymasterip);
		$numberofrowip=mysqli_num_rows($masterexip);
	?>
  <tr>
    <td colspan="5">
	<table width="310" height="124" border="0" style="font-size:medium;">
      <tr bgcolor="#ccc">
        <td colspan="3"  style="color: blue;"><strong>Current Statistics:</strong></td>
      </tr>
	  <tr bgcolor="#fff">
        <td>&nbsp;</td>
        <td width="192">New Registrations</td>
        <td  width="56" align="right"><?php echo $registeredpatient; ?></td>
      </tr>
      <tr bgcolor="#cbdbfa">
        <td>&nbsp;</td>
        <td>OP VIsits</td>
        <td align="right"><?php echo $numberofrow; ?></td>
      </tr>
      <tr bgcolor="#fff">
        <td>&nbsp;</td>
        <td>IP Visits</td>
        <td align="right"><?php echo $numberofrowip; ?></td>
      </tr>
	  
    </table>
	</td>
	</tr>
 <tr><td>&nbsp;</td>
       </tr>
  <tr>
    <td colspan="3"><table width="1350" cellspacing="0" cellpadding="4px" border="0" style="font-size:medium;">
      <tr bgcolor="#CCC">
	  <td colspan="20" style="color: blue;"><strong>OP Departmental Statisctics</strong></td>
      </tr>
	  <tr bgcolor="#FFF">
	  <td >Deaprtment</td>
	  <td >New Visits</td>
	  <td >Revisits</td>
	  <td >Total Visits</td>
	  <td >Triaged Patients</td>
	  <td >Consulted Patients</td>
	  <td >Lab Requests</td>
	  <td >Lab Samples</td>
	  <td >Lab Refunds</td>
	  <td >Radiology Requests</td>
	  <td >Radiology Processed</td>
	  <td >Radiology Refunds</td>
	  <td >Service Requests</td>
	  <td >Service Processed</td>
	  <td >Service Refunds</td>
	  <td >Medicine Requests</td>
	  <td >Medicine Issued</td>
	  <td >Medicine Returns</td>
	  <td width="100">Realized Revenue</td>
	  <td width="100">Unrealized Revenue</td>
      </tr>
	  <?php
		$snocount = 0;
		$colorloopcount = 0;
		$totalvisit =0;
		$totalvisit1 =0;
		$totaltriage = 0;
		$totalconsult = 0;
		$totallab = 0;
		$totallabsample = 0;
		$totallabrefund = 0;
		$totalrad = 0;
		$totalradsample = 0;
		$totalradrefund = 0;
		$totalser = 0;
		$totalsersample = 0;
		$totalserrefund = 0;
		$totalmed = 0;
		$totalmedissue = 0;
		$totalmedreturn = 0;
		$totalrevenue=0;
		$totalunrealized=0;
		//$locationcode = 'LTC-1';
		$qrydpt = "select auto_number,department from master_department where recordstatus <> 'deleted'";
		$execdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qrydpt) or die("Error in qrydpt ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdpt=mysqli_fetch_array($execdpt))
		{
		$dpt = $resdpt['auto_number'];
		$dptname =  $resdpt['department'];
		$newwalkin="select patientcode,visitcount from master_visitentry where consultationdate between '$todayfromdate' and '$todaytodate' and department ='$dpt'  and locationcode='$locationcode'";
		$walkex=mysqli_query($GLOBALS["___mysqli_ston"], $newwalkin);
		$walkpatient=0;
		$walkpatient1=0;
		$dptrevenue =0;
		$dptunrealized =0;
		while($totwalk=mysqli_fetch_array($walkex))
		{
			$newwalkcode=$totwalk['patientcode'];
			$visitcount=$totwalk['visitcount'];
			$querywalk="select count(patientcode) as totalwalk from master_visitentry where patientcode='$newwalkcode'";
			$querywalkex=mysqli_query($GLOBALS["___mysqli_ston"], $querywalk);
			$reswalkt=mysqli_fetch_array($querywalkex);
			$walkcount=$reswalkt['totalwalk'];
			if($walkcount>1 && $visitcount!=1)
			{
				$walkpatient+=1;
			}
			else 
			{
				$walkpatient1+=1;
			}
			}
			$qrytriage = "select count(auto_number) as triage from master_triage where department like '$dptname' and date(consultationdate) between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrytriageex=mysqli_query($GLOBALS["___mysqli_ston"], $qrytriage);
			$restriage=mysqli_fetch_array($qrytriageex);
			$triage = $restriage['triage'];
			$totaltriage += $triage;
			$qryconsult = "select count(DISTINCT patientvisitcode) as consult from master_consultation where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and recorddate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qryconsultex=mysqli_query($GLOBALS["___mysqli_ston"], $qryconsult) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
			$resconsult=mysqli_fetch_array($qryconsultex);
			$consult = $resconsult['consult'];
			$totalconsult += $consult;
			$qrylab = "select count(auto_number) as todaylab from consultation_lab where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrylabex=mysqli_query($GLOBALS["___mysqli_ston"], $qrylab);
			$reslab=mysqli_fetch_array($qrylabex);
			$todaylab = $reslab['todaylab'];
			$totallab += $todaylab;
			$qrylabsample = "select count(auto_number) as labsample from consultation_lab where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and labsamplecoll like 'completed' and labrefund <> 'refund' and locationcode='$locationcode'";
			$qrylabsampleex=mysqli_query($GLOBALS["___mysqli_ston"], $qrylabsample);
			$reslabsample=mysqli_fetch_array($qrylabsampleex);
			$labsample = $reslabsample['labsample'];
			$totallabsample += $labsample;
			$qrylabrefund = "select count(auto_number) as labrefund from consultation_lab where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and labrefund like 'refund' and locationcode='$locationcode'";
			$qrylabrefundex=mysqli_query($GLOBALS["___mysqli_ston"], $qrylabrefund);
			$reslabrefund=mysqli_fetch_array($qrylabrefundex);
			$labrefund = $reslabrefund['labrefund'];
			$totallabrefund += $labrefund;
			$qryrad = "select count(auto_number) as todayrad from consultation_radiology where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qryradex=mysqli_query($GLOBALS["___mysqli_ston"], $qryrad) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resrad=mysqli_fetch_array($qryradex);
			$todayrad = $resrad['todayrad'];
			$totalrad += $todayrad;
			$qryradsample = "select count(auto_number) as radsample from consultation_radiology where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and prepstatus like 'completed' and radiologyrefund <> 'refund' and locationcode='$locationcode'";
			$qryradsampleex=mysqli_query($GLOBALS["___mysqli_ston"], $qryradsample);
			$resradsample=mysqli_fetch_array($qryradsampleex);
			$radsample = $resradsample['radsample'];
			$totalradsample += $radsample;
			$qryradrefund = "select count(auto_number) as radrefund from consultation_radiology where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and radiologyrefund like 'refund' and locationcode='$locationcode'";
			$qryradrefundex=mysqli_query($GLOBALS["___mysqli_ston"], $qryradrefund);
			$resradrefund=mysqli_fetch_array($qryradrefundex);
			$radrefund = $resradrefund['radrefund'];
			$totalradrefund += $radrefund;
			$qryser = "select count(auto_number) as todayser from consultation_services where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and wellnessitem <> 1 and locationcode='$locationcode' ";
			$qryserex=mysqli_query($GLOBALS["___mysqli_ston"], $qryser) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resrad=mysqli_fetch_array($qryserex);
			$todayser = $resrad['todayser'];
			$totalser += $todayser;
			$qrysersample = "select count(auto_number) as sersample from consultation_services where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and process like 'completed' and servicerefund <> 'refund' and wellnessitem <> 1 and locationcode='$locationcode'";
			$qrysersampleex=mysqli_query($GLOBALS["___mysqli_ston"], $qrysersample);
			$ressersample=mysqli_fetch_array($qrysersampleex);
			$sersample = $ressersample['sersample'];
			$totalsersample += $sersample;
			$qryserrefund = "select count(auto_number) as serrefund from consultation_services where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and servicerefund like 'refund' and wellnessitem <> 1 and locationcode='$locationcode'";
			$qryserrefundex=mysqli_query($GLOBALS["___mysqli_ston"], $qryserrefund);
			$resserrefund=mysqli_fetch_array($qryserrefundex);
			$serrefund = $resserrefund['serrefund'];
			$totalserrefund += $serrefund;
			$qrymed = "select count(auto_number) as todaymed from master_consultationpharm where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and recorddate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrymedex=mysqli_query($GLOBALS["___mysqli_ston"], $qrymed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmed=mysqli_fetch_array($qrymedex);
			$todaymed = $resmed['todaymed'];
			$totalmed += $todaymed;
			$qrymedissue = "select count(auto_number) as medissue from master_consultationpharm where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and recorddate between '$todayfromdate' and '$todaytodate' and medicineissue like 'completed' and locationcode='$locationcode'";
			$qrymedissueex=mysqli_query($GLOBALS["___mysqli_ston"], $qrymedissue);
			$resmedissue=mysqli_fetch_array($qrymedissueex);
			$medissue = $resmedissue['medissue'];
			$totalmedissue += $medissue;
			$qrymedreturn = "select count(auto_number) as medreturn from pharmacysalesreturn_details where visitcode in (select visitcode from master_visitentry where department ='$dpt') and entrydate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrymedreturnex=mysqli_query($GLOBALS["___mysqli_ston"], $qrymedreturn);
			$resmedreturn=mysqli_fetch_array($qrymedreturnex);
			$medreturn = $resmedreturn['medreturn'];
			$totalmedreturn += $medreturn;
			//revenue
			$query1 = "select sum(consultation) as billamount1 from billing_consultation where  locationcode='$locationcode' and  billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			$query1 = "select sum(fxamount) as billamount1 from billing_paylaterconsultation where locationcode='$locationcode' and  billdate between '$todayfromdate' and '$todaytodate' and visitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];
			
			// this query for pharmacy
		    $query8 = "select sum(fxamount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt')";
		 	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
		    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			  
			//this query for laboratry
			$query2 = "select sum(fxamount) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
			
			//this query for radiology
			$query4 = "select sum(fxamount) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate; 
			
			//this query for service
			$query6 = "select sum(fxamount) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt' and wellnessitem <> 1) and locationcode='$locationcode'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(fxamount) as servicesitemrate2 from billing_paynowservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt' and wellnessitem <> 1) and locationcode='$locationcode'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate2'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate3 from billing_externalservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate3'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1']; 
			
			//this query for refund consultation
			
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation = $res12['consultation1'];
			
			//this query for refund pharmacy
			
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];
			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];
			$totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate;
			
			//this query for refund laboratory
			
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];
			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate;
			
			//this query for refund radiology
			
			$query22 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paylaterradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];
			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate;
			
			//this query for refund service
			
			$query24 = "select sum(amount)as servicesitemrate1 from refund_paylaterservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];
			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate;
			
			//this query for refund referal
			
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;
							  
			  //ENDS
			  //for cash total
			  $cashtotal1=$res1consultationamount+$res9pharmacyitemrate+$res3labitemrate+$res5radiologyitemrate+$res7servicesitemrate+$res11referalitemrate;
			  
			  //for credit total
			  $credittotal1=$res2consultationamount+$res8pharmacyitemrate+$res2labitemrate+$res4radiologyitemrate+$res6servicesitemrate+$res10referalitemrate;
			  //for external total
			 
			  //for refund total
			  $refundtotal1=$res12refundconsultation+$totalrefundpharmacy+$totalrefundlab+$totalrefundradio+$totalrefundservice+$totalrefundreferal;
			  $dptrevenue=$cashtotal1+$credittotal1-$refundtotal1;
			$totalrevenue +=$dptrevenue;
			//revenue end
			
			//unrealized
			$totalpharmacysalesreturn =0;
			$overaltotalrefund =0;
			$query2 = "select patientcode,visitcode,patientfullname,consultationdate,accountfullname,subtype,planname,planpercentage from master_visitentry where billtype='PAY LATER' and overallpayment='' and consultationdate between '$todayfromdate' and '$todaytodate' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) AND department like '$dpt' and locationcode='$locationcode' order by accountfullname desc ";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2un".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientfullname = $res2['patientfullname'];
		  $res2registrationdate = $res2['consultationdate'];
		  $res2accountname = $res2['accountfullname'];
		  $subtype = $res2['subtype'];
		  $plannumber = $res2['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$planpercentage=$res2['planpercentage'];
			//$copay=($consultationfee/100)*$planpercentage;
			
		  
		  $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select subtype,planname  from master_customer where customercode='$res2patientcode'");
			$execlab=mysqli_fetch_array($Querylab);
			$patientsubtype=$execlab['subtype'];
			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
			$execsubtype=mysqli_fetch_array($querysubtype);
			$patientsubtype1=$execsubtype['subtype'];
			$patientsubtypeano=$execsubtype['auto_number'];
			$patientplan=$execlab['planname'];
			$currency=$execsubtype['currency'];
			$fxrate=$execsubtype['fxrate'];
			if($currency=='')
			{
				$currency='UGX';
			}
			$labtemplate = $execsubtype['labtemplate'];
			if($labtemplate == '') { $labtemplate = 'master_lab'; }
			$radtemplate = $execsubtype['radtemplate'];
			if($radtemplate == '') { $radtemplate = 'master_radiology'; }
			$sertemplate = $execsubtype['sertemplate'];
			if($sertemplate == '') { $sertemplate = 'master_services'; }
		  
		  $res3labitemrate = 0;
		  $query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res3 = mysqli_fetch_array($exec3))
		  {
		  		$labcode = $res3['labitemcode']; 
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'] * $fxrate;
				if(($planpercentage!=0.00)&&($planforall=='yes'))
			  	{ 
					$labrate = $labrate - ($labrate/100)*$planpercentage;
				}
				$res3labitemrate = $res3labitemrate + $labrate;
		  }
		  
		  $res4servicesitemrate = 0;
		  $query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate' and wellnessitem <> 1";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
		  {
		  	 $sercode=$res4['servicesitemcode'];
			 $serqty=$res4['serviceqty'];
			 $serrefqty=$res4['refundquantity'];
			
			 $serqty = $serqty-$serrefqty;
			
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'] * $fxrate;
			$serrate = $serrate * $serqty;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$serrate = $serrate - ($serrate/100)*$planpercentage;
			}
			$res4servicesitemrate = $res4servicesitemrate + $serrate;
		  }
		  
		  $res5radiologyitemrate = 0;
		  $query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		  	$radcode=$res5['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'] * $fxrate;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$radrate = $radrate - ($radrate/100)*$planpercentage;
			}
			$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
		  }
		  
		  $query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate' ";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  $res6referalrate = $res6['referalrate1'];
		  if ($res6referalrate =='')
		  {
		  $res6referalrate = '0.00';
		  }
		  else 
		  {
		    $res6referalrate = $res6['referalrate1'] * $fxrate;
		  }
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  { 
		  $res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
		  }
		  
		  $query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  $res7consultationfees = $res7['consultationfees1'] * $fxrate;
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  { 
		  $copay=($res7consultationfees/100)*$planpercentage;
		  }
		  else
		  {
		  $copay = 0;
		  }
		  $res7consultationfees = $res7consultationfees - $copay;
		  
		  $query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  $res8copayfixedamount = $res8['copayfixedamount1'];
		  $res8copayfixedamount = 0;
		  
		  $consultation = $res7consultationfees - $res8copayfixedamount;
		  
		  $query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$todayfromdate' and '$todaytodate' ";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $res9pharmacyrate = $res9['totalamount1'];
		  
		  if ($res9pharmacyrate == '')
		  {
		  $res9pharmacyrate = '0.00';
		  }
		  else 
		  {
		  $res9pharmacyrate = $res9['totalamount1'];
		  }
		  
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
		  }
		  
			$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$todayfromdate' and '$todaytodate'";// and ipdocno = '$refno'";//group by itemcode";
			$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numpharmacysalereturn=mysqli_num_rows($exec321);
		  $totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
		  //echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
		    $res321 = mysqli_fetch_array($exec321);
		  $res9pharmacyreturnrate = $res321['totalamount2'];
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
		  }
		  $res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate = '$todaydate'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $dptunrealized = $dptunrealized + $totalamount;
		 }
			$totalunrealized += $dptunrealized;
			//unrealized end
			
			$snocount = $snocount + 1;
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
	  <tr <?=$colorcode?>>
	  <td ><?=$resdpt['department'];?></td>
	  <td align="right" style="padding-right:8px"><?=$walkpatient1;?></td>
	  <td align="right" style="padding-right:8px"><?=$walkpatient;?></td>
	  <td align="right" style="padding-right:8px"><?=$walkpatient1+$walkpatient;?></td>
	  <td align="right" style="padding-right:8px"><?=$triage;?></td>
	  <td align="right" style="padding-right:8px"><?=$consult;?></td>
	  <td align="right" style="padding-right:8px"><?=$todaylab;?></td>
	  <td align="right" style="padding-right:8px"><?=$labsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$labrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$todayrad;?></td>
	  <td align="right" style="padding-right:8px"><?=$radsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$radrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$todayser;?></td>
	  <td align="right" style="padding-right:8px"><?=$sersample;?></td>
	  <td align="right" style="padding-right:8px"><?=$serrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$todaymed;?></td>
	  <td align="right" style="padding-right:8px"><?=$medissue;?></td>
	  <td align="right" style="padding-right:8px"><?=$medreturn;?></td>
	  <td align="right" style="padding-right:8px"><?= number_format($dptrevenue,'2','.',',');?></td>
	  <td align="right" style="padding-right:8px"><?= number_format($dptunrealized,'2','.',',');?></td>
      </tr>
	  <?php
	  $totalvisit +=$walkpatient; 
	  $totalvisit1 +=$walkpatient1; 
	  }
	  ?>
	  <tr bgcolor='#ccc'>
	  <td ><strong>Total :</strong></td>
	  <td align="right" style="padding-right:8px"><?=$totalvisit;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalvisit1;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalvisit1+$totalvisit;?></td>
	  <td align="right" style="padding-right:8px"><?=$totaltriage;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalconsult;?></td>
	  <td align="right" style="padding-right:8px"><?=$totallab;?></td>
	  <td align="right" style="padding-right:8px"><?=$totallabsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$totallabrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalrad;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalradsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalradrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalser;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalsersample;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalserrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalmed;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalmedissue;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalmedreturn;?></td>
	  <td align="right" style="padding-right:8px"><?=number_format($totalrevenue,'2','.',',');?></td>
	  <td align="right" style="padding-right:8px"><?=number_format($totalunrealized,'2','.',',');?></td>
      </tr>
	  <tr >
	  <td colspan="20">&nbsp;</td>
      </tr>
	   
      
    </table></td>
  
     
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>



<?php
}
?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>