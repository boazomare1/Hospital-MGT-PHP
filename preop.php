<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$errmsg = "";
$locationname ="";


if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == "frmflag1")
{
	$patientname = $_REQUEST["patientname"];
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$operationname = $_REQUEST["operationname"];
	$age = $_REQUEST["age"];
	$gender = $_REQUEST["gender"];
	$ward = $_REQUEST["ward"];
	$docno = $_REQUEST['docno'];
	//$locationname = $_REQUEST["locationname"];
	$locationcode = $_REQUEST["locationcode"];
	$opconsentward = isset($_REQUEST["opconsentward"])? 1 : 0;
	$opconsenttheatre = isset($_REQUEST["opconsenttheatre"])? 1 : 0;
	$spconsentward = isset($_REQUEST["spconsentward"])? 1 : 0;
	$spconsentnot = isset($_REQUEST["spconsentnot"])? 1 : 0;
	$spconsenttheatre = isset($_REQUEST["spconsenttheatre"])? 1 : 0;
	$spconsenttheatrenot = isset($_REQUEST["spconsenttheatrenot"])? 1 : 0;
	$filenotesward = isset($_REQUEST["filenotesward"])? 1 : 0;
	$filenotestheatre = $_REQUEST["filenotestheatre"];
	$tpbpchartward = isset($_REQUEST["tpbpchartward"])? 1 : 0;
	$tpbpcharttheatre = $_REQUEST["tpbpcharttheatre"];
	$treatmentsheetward = isset($_REQUEST["treatmentsheetward"])? 1 : 0;
	$treatmentsheettheatre = $_REQUEST["treatmentsheettheatre"];
	$allergiesward = isset($_REQUEST["allergiesward"])? 1 : 0;
	$allergiestheatre = $_REQUEST["allergiestheatre"];
	$xrayward = isset($_REQUEST["xrayward"])? 1 : 0;
	$xraywardnot = isset($_REQUEST["xraywardnot"])? 1 : 0;
	$xraytheatre = $_REQUEST["xraytheatre"];
	$haemoglobinward = $_REQUEST["haemoglobinward"];
	$haemoglobinwardnot = isset($_REQUEST["haemoglobinwardnot"])? 1 : 0;
	$haemoglobintheatre = $_REQUEST["haemoglobintheatre"];
	$bloodsugarward = $_REQUEST["bloodsugarward"];
	$bloodsugarwardnot = isset($_REQUEST["bloodsugarwardnot"])? 1 : 0;
	$bloodsugartheatre = $_REQUEST["bloodsugartheatre"];
	$ucrossmatchward = $_REQUEST["ucrossmatchward"];
	$ucrossmatchwardnot = isset($_REQUEST["ucrossmatchwardnot"])? 1 : 0;
	$ucrossmatchtheatre = $_REQUEST["ucrossmatchtheatre"];
	$ucrossmatchtheatrenot = isset($_REQUEST["ucrossmatchtheatrenot"])? 1 : 0;
	$idbandward = isset($_REQUEST["idbandward"])? 1 : 0;
	$idbandtheatre = isset($_REQUEST["idbandtheatre"])? 1 : 0;
	$gownward = isset($_REQUEST["gownward"])? 1 : 0;
	$gowntheatre = $_REQUEST["gowntheatre"];	
	$underclothward = isset($_REQUEST["underclothward"])? 1 : 0;
	$underclothnot = isset($_REQUEST["underclothnot"])? 1 : 0;
	$undercloththeatre = $_REQUEST["undercloththeatre"];
	$dentureward = isset($_REQUEST["dentureward"])? 1 : 0;
	$denturenot = isset($_REQUEST["denturenot"])? 1 : 0;
	$denturetheatre = $_REQUEST["denturetheatre"];
	$wighairward = isset($_REQUEST["wighairward"])? 1 : 0;
	$wighairwardnot = isset($_REQUEST["wighairwardnot"])? 1 : 0;
	$wighairtheatre = $_REQUEST["wighairtheatre"];
	$lensward = isset($_REQUEST["lensward"])? 1 : 0;
	$lenswardnot = isset($_REQUEST["lenswardnot"])? 1 : 0;
	$lenstheatre = $_REQUEST["lenstheatre"];
	$jewelward = isset($_REQUEST["jewelward"])? 1 : 0;
	$jewelwardnot = isset($_REQUEST["jewelwardnot"])? 1 : 0;
	$jeweltheatre = $_REQUEST["jeweltheatre"];
	$makeupnailward = isset($_REQUEST["makeupnailward"])? 1 : 0;
	$makeupnailwardnot = isset($_REQUEST["makeupnailwardnot"])? 1 : 0;
	$makeupnailtheatre = $_REQUEST["makeupnailtheatre"];
	$shavingward = isset($_REQUEST["shavingward"])? 1 : 0;
	$shavingwardnot = isset($_REQUEST["shavingwardnot"])? 1 : 0;
	$shavingtheatre = $_REQUEST["shavingtheatre"];
	$skinward = isset($_REQUEST["skinward"])? 1 : 0;
	$skinwardnot = isset($_REQUEST["skinwardnot"])? 1 : 0;
	$skintheatre = $_REQUEST["skintheatre"];
	$intradipward = isset($_REQUEST["intradipward"])? 1 : 0;
	$intradipwardnot = isset($_REQUEST["intradipwardnot"])? 1 : 0;
	$intradiptheatre = $_REQUEST["intradiptheatre"];
	$nasotubeward = isset($_REQUEST["nasotubeward"])? 1 : 0;
	$nasotubewardnot = isset($_REQUEST["nasotubewardnot"])? 1 : 0;
	$nasotubewardtheatre = $_REQUEST["nasotubewardtheatre"];
	$catheterward = isset($_REQUEST["catheterward"])? 1 : 0;
	$catheterwardnot = isset($_REQUEST["catheterwardnot"])? 1 : 0;
	$cathetertheatre = $_REQUEST["cathetertheatre"];	
	$lastvoidward = $_REQUEST["lastvoidward"];
	$lastvoidtheatre = $_REQUEST["lastvoidtheatre"];
	$temp = $_REQUEST["temp"];
	$c = $_REQUEST["c"];
	$p = $_REQUEST["p"];
	$r = $_REQUEST["r"];
	$bp = $_REQUEST["bp"];
	$dipstickward = $_REQUEST["dipstickward"];
	$lastfeedward = $_REQUEST["lastfeedward"];
	$premedward = $_REQUEST["premedward"];
	$timeward = $_REQUEST["timeward"];
	$hivwardpos = isset($_REQUEST["hivwardpos"])? 1 : 0;
	$hivwardneg = isset($_REQUEST["hivwardneg"])? 1 : 0;
	$hivwardnot = isset($_REQUEST["hivwardnot"])? 1 : 0;
	$anaesthetist = $_REQUEST["anaesthetist"];
	$reviewnotes = $_REQUEST["reviewnotes"];
	
	$query7 = "select * from preop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums7 = mysqli_num_rows($exec7);
	
	if($nums7 == '0')
	{
		if($patientname!='')
		{
			$query5 = "insert into preop(docno,patientcode,visitcode,patientname,recorddate,operation,ward,opconsentward,opconsenttheatre,spconsentward,spconsentnot,spconsenttheatre,spconsenttheatrenot,
			filenotesward,filenotestheatre,tpbpchartward,tpbpcharttheatre,treatmentsheetward,treatmentsheettheatre,allergiesward,allergiestheatre,xrayward,xraywardnot,xraytheatre,haemoglobinward,
			haemoglobinwardnot,haemoglobintheatre,bloodsugarward,bloodsugarwardnot,bloodsugartheatre,ucrossmatchward,ucrossmatchwardnot,ucrossmatchtheatre,ucrossmatchtheatrenot,idbandward,idbandtheatre,
			gownward,gowntheatre,underclothward,underclothnot,undercloththeatre,dentureward,denturenot,denturetheatre,wighairward,wighairwardnot,wighairtheatre,lensward,lenswardnot,lenstheatre,
			jewelward,jewelwardnot,jeweltheatre,makeupnailward,makeupnailwardnot,makeupnailtheatre,shavingward,shavingwardnot,shavingtheatre,skinward,skinwardnot,skintheatre,intradipward,intradipwardnot,
			intradiptheatre,nasotubeward,nasotubewardnot,nasotubewardtheatre,catheterward,catheterwardnot,cathetertheatre,lastvoidward,lastvoidtheatre,temp,c,p,r,bp,dipstickward,lastfeedward,premedward,
			hivwardpos,hivwardneg,hivwardnot,timeward,anaesthetist,reviewnotes,username,locationname,locationcode) 
			values('$docno','$patientcode','$visitcode','$patientname','$transactiondatefrom','$operationname','$ward','$opconsentward','$opconsenttheatre','$spconsentward','$spconsentnot','$spconsenttheatre',
			'$spconsenttheatrenot','$filenotesward','$filenotestheatre','$tpbpchartward','$tpbpcharttheatre','$treatmentsheetward','$treatmentsheettheatre','$allergiesward','$allergiestheatre',
			'$xrayward','$xraywardnot','$xraytheatre','$haemoglobinward','$haemoglobinwardnot','$haemoglobintheatre','$bloodsugarward','$bloodsugarwardnot','$bloodsugartheatre','$ucrossmatchward','$ucrossmatchwardnot',
			'$ucrossmatchtheatre','$ucrossmatchtheatrenot','$idbandward','$idbandtheatre','$gownward','$gowntheatre','$underclothward','$underclothnot','$undercloththeatre','$dentureward',
			'$denturenot','$denturetheatre','$wighairward','$wighairwardnot','$wighairtheatre','$lensward','$lenswardnot','$lenstheatre','$jewelward','$jewelwardnot','$jeweltheatre','$makeupnailward',
			'$makeupnailwardnot','$makeupnailtheatre','$shavingward','$shavingwardnot','$shavingtheatre','$skinward','$skinwardnot','$skintheatre','$intradipward','$intradipwardnot','$intradiptheatre',
			'$nasotubeward','$nasotubewardnot','$nasotubewardtheatre','$catheterward','$catheterwardnot','$cathetertheatre','$lastvoidward','$lastvoidtheatre','$temp','$c','$p','$r','$bp','$dipstickward',
			'$lastfeedward','$premedward','$hivwardpos','$hivwardneg','$hivwardnot','$timeward','$anaesthetist','$reviewnotes','$username','$locationname','$locationcode')";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			header("location:otpatients.php");
		}
	}
	else
	{
		if($patientname!='')
		{
			$query8 = "update preop set opconsentward='$opconsentward',opconsenttheatre='$opconsenttheatre',spconsentward='$spconsentward',spconsentnot='$spconsentnot',spconsenttheatre='$spconsenttheatre',
			spconsenttheatrenot='$spconsenttheatrenot',filenotesward='$filenotesward',filenotestheatre='$filenotestheatre',tpbpchartward='$tpbpchartward',tpbpcharttheatre='$tpbpcharttheatre',treatmentsheetward='$treatmentsheetward',
			treatmentsheettheatre='$treatmentsheettheatre',allergiesward='$allergiesward',allergiestheatre='$allergiestheatre',xrayward='$xrayward',xraywardnot='$xraywardnot',xraytheatre='$xraytheatre',haemoglobinward='$haemoglobinward',
			haemoglobinwardnot='$haemoglobinwardnot',haemoglobintheatre='$haemoglobintheatre',bloodsugarward='$bloodsugarward',bloodsugarwardnot='$bloodsugarwardnot',bloodsugartheatre='$bloodsugartheatre',ucrossmatchward='$ucrossmatchward',
			ucrossmatchwardnot='$ucrossmatchwardnot',ucrossmatchtheatre='$ucrossmatchtheatre',ucrossmatchtheatrenot='$ucrossmatchtheatrenot',idbandward='$idbandward',idbandtheatre='$idbandtheatre',gownward='$gownward',
			gowntheatre='$gowntheatre',underclothward='$underclothward',underclothnot='$underclothnot',undercloththeatre='$undercloththeatre',dentureward='$dentureward',denturenot='$denturenot',denturetheatre='$denturetheatre',
			wighairward='$wighairward',wighairwardnot='$wighairwardnot',wighairtheatre='$wighairtheatre',lensward='$lensward',lenswardnot='$lenswardnot',lenstheatre='$lenstheatre',jewelward='$jewelward',jewelwardnot='$jewelwardnot',jeweltheatre='$jeweltheatre',
			makeupnailward='$makeupnailward',makeupnailwardnot='$makeupnailwardnot',makeupnailtheatre='$makeupnailtheatre',shavingward='$shavingward',shavingwardnot='$shavingwardnot',shavingtheatre='$shavingtheatre',skinward='$skinward',
			skinwardnot='$skinwardnot',skintheatre='$skintheatre',intradipward='$intradipward',intradipwardnot='$intradipwardnot',intradiptheatre='$intradiptheatre',nasotubeward='$nasotubeward',nasotubewardnot='$nasotubewardnot',
			nasotubewardtheatre='$nasotubewardtheatre',catheterward='$catheterward',catheterwardnot='$catheterwardnot',cathetertheatre='$cathetertheatre',lastvoidward='$lastvoidward',lastvoidtheatre='$lastvoidtheatre',temp='$temp',c='$c',p='$p',r='$r',bp='$bp',
			dipstickward='$dipstickward',lastfeedward='$lastfeedward',premedward='$premedward',hivwardpos='$hivwardpos',hivwardneg='$hivwardneg',hivwardnot='$hivwardnot',timeward='$timeward',anaesthetist='$anaesthetist',
			reviewnotes='$reviewnotes',username='$username',locationname='$locationname',locationcode='$locationcode' where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			header("location:otpatients.php");
		}
	}
	
	
}
if($visitcode!='' && $patientcode!='')
{
	$query1 = "select * from ip_otrequest where patientvisitcode='$visitcode' and patientcode='$patientcode' and docno = '$docno'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1 = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$patientname = $res1['patientname'];
	$patientcode = $res1['patientcode'];
	$visitcode = $res1['patientvisitcode'];
	$accoutname = $res1['accountname'];
	$operation = $res1['surgeryname'];
	$docno = $res1['docno'];
	//$locationname = $res1['locationname'];
	$locationcode = $res1['locationcode'];
	$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$ward=$res2['ward'];
	$query3 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$wardname = $res3['ward'];
	$query4 = "select * from master_customer where customercode='$patientcode'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$age=$res4['age'];
	$gender=$res4['gender'];
	
	$query6 = "select * from preop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums6 = mysqli_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysqli_fetch_array($exec6);
		$opconsentward = $res6["opconsentward"];
		$opconsenttheatre = $res6["opconsenttheatre"];
		$spconsentward = $res6["spconsentward"];
		$spconsentnot = $res6["spconsentnot"];
		$spconsenttheatre = $res6["spconsenttheatre"];
		$spconsenttheatrenot = $res6["spconsenttheatrenot"];
		$filenotesward = $res6["filenotesward"];
		$filenotestheatre = $res6["filenotestheatre"];
		$tpbpchartward = $res6["tpbpchartward"];
		$tpbpcharttheatre = $res6["tpbpcharttheatre"];
		$treatmentsheetward = $res6["treatmentsheetward"];
		$treatmentsheettheatre = $res6["treatmentsheettheatre"];
		$allergiesward = $res6["allergiesward"];
		$allergiestheatre = $res6["allergiestheatre"];
		$xrayward = $res6["xrayward"];
		$xraywardnot = $res6["xraywardnot"];
		$xraytheatre = $res6["xraytheatre"];
		$haemoglobinward = $res6["haemoglobinward"];
		$haemoglobinwardnot = $res6["haemoglobinwardnot"];
		$haemoglobintheatre = $res6["haemoglobintheatre"];
		$bloodsugarward = $res6["bloodsugarward"];
		$bloodsugarwardnot = $res6["bloodsugarwardnot"];
		$bloodsugartheatre = $res6["bloodsugartheatre"];
		$ucrossmatchward = $res6["ucrossmatchward"];
		$ucrossmatchwardnot = $res6["ucrossmatchwardnot"];
		$ucrossmatchtheatre = $res6["ucrossmatchtheatre"];
		$ucrossmatchtheatrenot = $res6["ucrossmatchtheatrenot"];
		$idbandward = $res6["idbandward"];
		$idbandtheatre = $res6["idbandtheatre"];
		$gownward = $res6["gownward"];
		$gowntheatre = $res6["gowntheatre"];	
		$underclothward = $res6["underclothward"];
		$underclothnot = $res6["underclothnot"];
		$undercloththeatre = $res6["undercloththeatre"];
		$dentureward = $res6["dentureward"];
		$denturenot = $res6["denturenot"];
		$denturetheatre = $res6["denturetheatre"];
		$wighairward = $res6["wighairward"];
		$wighairwardnot = $res6["wighairwardnot"];
		$wighairtheatre = $res6["wighairtheatre"];
		$lensward = $res6["lensward"];
		$lenswardnot = $res6["lenswardnot"];
		$lenstheatre = $res6["lenstheatre"];
		$jewelward = $res6["jewelward"];
		$jewelwardnot = $res6["jewelwardnot"];
		$jeweltheatre = $res6["jeweltheatre"];
		$makeupnailward = $res6["makeupnailward"];
		$makeupnailwardnot = $res6["makeupnailwardnot"];
		$makeupnailtheatre = $res6["makeupnailtheatre"];
		$shavingward = $res6["shavingward"];
		$shavingwardnot = $res6["shavingwardnot"];
		$shavingtheatre = $res6["shavingtheatre"];
		$skinward = $res6["skinward"];
		$skinwardnot = $res6["skinwardnot"];
		$skintheatre = $res6["skintheatre"];
		$intradipward = $res6["intradipward"];
		$intradipwardnot = $res6["intradipwardnot"];
		$intradiptheatre = $res6["intradiptheatre"];
		$nasotubeward = $res6["nasotubeward"];
		$nasotubewardnot = $res6["nasotubewardnot"];
		$nasotubewardtheatre = $res6["nasotubewardtheatre"];
		$catheterward = $res6["catheterward"];
		$catheterwardnot = $res6["catheterwardnot"];
		$cathetertheatre = $res6["cathetertheatre"];	
		$lastvoidward = $res6["lastvoidward"];
		$lastvoidtheatre = $res6["lastvoidtheatre"];
		$temp = $res6["temp"];
		$c = $res6["c"];
		$p = $res6["p"];
		$r = $res6["r"];
		$bp = $res6["bp"];
		$dipstickward = $res6["dipstickward"];
		$lastfeedward = $res6["lastfeedward"];
		$premedward = $res6["premedward"];
		$timeward = $res6["timeward"];
		$hivwardpos = $res6["hivwardpos"];
		$hivwardneg = $res6["hivwardneg"];
		$hivwardnot = $res6["hivwardnot"];
		$anaesthetist = $res6["anaesthetist"];
		$reviewnotes = $res6["reviewnotes"];
	}
	else
	{
		$opconsentward = '';
		$opconsenttheatre = '';
		$spconsentward = '';
		$spconsentnot = '';
		$spconsenttheatre = '';
		$spconsenttheatrenot = '';
		$filenotesward = '';
		$filenotestheatre = '';
		$tpbpchartward = '';
		$tpbpcharttheatre = '';
		$treatmentsheetward = '';
		$treatmentsheettheatre = '';
		$allergiesward = '';
		$allergiestheatre = '';
		$xrayward = '';
		$xraywardnot = '';
		$xraytheatre = '';
		$haemoglobinward = '';
		$haemoglobinwardnot = '';
		$haemoglobintheatre = '';
		$bloodsugarward = '';
		$bloodsugarwardnot = '';
		$bloodsugartheatre = '';
		$ucrossmatchward = '';
		$ucrossmatchwardnot = '';
		$ucrossmatchtheatre = '';
		$ucrossmatchtheatrenot = '';
		$idbandward = '';
		$idbandtheatre = '';
		$gownward = '';
		$gowntheatre = '';	
		$underclothward = '';
		$underclothnot = '';
		$undercloththeatre = '';
		$dentureward = '';
		$denturenot = '';
		$denturetheatre = '';
		$wighairward = '';
		$wighairwardnot = '';
		$wighairtheatre = '';
		$lensward = '';
		$lenswardnot = '';
		$lenstheatre = '';
		$jewelward = '';
		$jewelwardnot = '';
		$jeweltheatre = '';
		$makeupnailward = '';
		$makeupnailwardnot = '';
		$makeupnailtheatre = '';
		$shavingward = '';
		$shavingwardnot = '';
		$shavingtheatre = '';
		$skinward = '';
		$skinwardnot = '';
		$skintheatre = '';
		$intradipward = '';
		$intradipwardnot = '';
		$intradiptheatre = '';
		$nasotubeward = '';
		$nasotubewardnot = '';
		$nasotubewardtheatre = '';
		$catheterward = '';
		$catheterwardnot = '';
		$cathetertheatre = '';	
		$lastvoidward = '';
		$lastvoidtheatre = '';
		$temp = '';
		$c = '';
		$p = '';
		$r = '';
		$bp = '';
		$dipstickward = '';
		$lastfeedward = '';
		$premedward = '';
		$timeward = '';
		$hivwardpos = '';
		$hivwardneg = '';
		$hivwardnot = '';
		$anaesthetist = '';
		$reviewnotes = '';
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

function from1submit1()
{
	if (document.form1.companyname.value == "")
	{
		alert ("Hospital Name Cannot Be Empty.");
		document.form1.companyname.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		//alert ("City Cannot Be Empty.");
		//document.form1.city.focus();
		//return false;
	}
	else if (document.form1.state.value == "")
	{
		//alert ("State Cannot Be Empty.");
		//document.form1.state.focus();
		//return false;
	}
	else if (document.form1.patientcodeprefix.value == "") 
	{
		alert ("Please Enter Patient Code Prefix.");
		document.form1.patientcodeprefix.focus();
		return false;
	}
	else if (document.form1.visitcodeprefix.value == "") 
	{
		alert ("Please Enter Visit Number Prefix.");
		document.form1.visitcodeprefix.focus();
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
}

</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="61%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#ecf0f5">
          <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" />
          <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
          <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5"><?php echo $patientname; ?></td>
          <td bgcolor="#ecf0f5" class="bodytext3"><strong>Date </strong></td>
          <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
          <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
          <td width="11%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="21%" align="left" valign="middle" class="bodytext3"><?php echo $wardname; ?></td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Code</strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code </strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?></td>
          <td align="left" valign="top" class="bodytext3"><strong>Operation</strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $operation; ?></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $age; ?> & <?php echo $gender; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Ref. Dr. </strong></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3"><strong>Doc no</strong></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3"><?php echo $docno; ?></td>
        </tr>
		<tr>
		  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Location </strong></td>
          <?php
		  $query131 = "select * from master_location where locationcode = '$locationcode'";
          $exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res131 = mysqli_fetch_array($exec131);
          $locationname = $res131['locationname'];
			?>
		  <td align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?></td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
        </tr>
      </tbody>
    </table>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top">


      <form name="form1" id="form1" method="post" action="preop.php?anum=<?php echo $companyanum; ?>" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="848" height="282" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>Pre-Operative Check </strong>
                <input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname;?>">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode;?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode;?>">
				<input type="hidden" name="operationname" id="operationname" value="<?php echo $operation;?>">
				<input type="hidden" name="age" id="age" value="<?php echo $age;?>">
				<input type="hidden" name="gender" id="gender" value="<?php echo $gender;?>">
				<input type="hidden" name="ward" id="ward" value="<?php echo $wardname;?>">
				<input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>">
				<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname;?>">
				<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode;?>">
				</td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="14" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              
              
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PRE-OPERATIVE CHECK </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>CHECK THE APPROPRIATE RESPONSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>FORMS, CHARTS, E.T.C. PRESENT </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>WARD NURSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>THEATRE NURSE </strong></td>
				  </tr>
				<tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Operation Consent </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="opconsentward" id="opconsentward" onClick="return funcpackcheck();" <?php if($opconsentward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="opconsenttheatre" id="opconsenttheatre" <?php if($opconsenttheatre == '1') echo 'checked'; ?> onClick="return funcpackcheck();" value="1"></td>
                </tr>
				  <tr>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Parent/Guardian spouse's consent </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="spconsentward" id="spconsentward" onClick="return funcpackcheck();" <?php if($spconsentward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="spconsentnot" id="spconsentnot" onClick="return funcpackcheck();" <?php if($spconsentnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="spconsenttheatre" id="spconsenttheatre" onClick="return funcpackcheck();" <?php if($spconsenttheatre == '1') echo 'checked'; ?> value="1"></td>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="spconsenttheatrenot" id="spconsenttheatrenot" onClick="return funcpackcheck();" <?php if($spconsenttheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
				  </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">File with complete notes </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="filenotesward" id="filenotesward" onClick="return funcpackcheck();" <?php if($filenotesward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="filenotestheatre" id="filenotestheatre" value="<?php echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
             
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TPR and BPChart </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="tpbpchartward" id="tpbpchartward" onClick="return funcpackcheck();" <?php if($tpbpchartward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="tpbpcharttheatre" id="tpbpcharttheatre" value="<?php echo $tpbpcharttheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
               <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Treatment Sheet </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="treatmentsheetward" id="treatmentsheetward" onClick="return funcpackcheck();" <?php if($treatmentsheetward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="treatmentsheettheatre" id="treatmentsheettheatre" value="<?php echo $treatmentsheettheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Allergies Noted </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="allergiesward" id="allergiesward" onClick="return funcpackcheck();" <?php if($allergiesward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="allergiestheatre" id="allergiestheatre" value="<?php echo $allergiestheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">X-Rays</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="xrayward" id="xrayward" onClick="return funcpackcheck();" <?php if($xrayward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="xraywardnot" id="xraywardnot" onClick="return funcpackcheck();" <?php if($xraywardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="xraytheatre" id="xraytheatre" value="<?php echo $xraytheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Haemoglobin Results </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="haemoglobinward" id="haemoglobinward" value="<?php echo $haemoglobinward; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="haemoglobinwardnot" id="haemoglobinwardnot" onClick="return funcpackcheck();" <?php if($haemoglobinwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="haemoglobintheatre" id="haemoglobintheatre" value="<?php echo $haemoglobintheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Blood Sugar Results </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="bloodsugarward" id="bloodsugarward" value="<?php echo $bloodsugarward; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input type="checkbox" name="bloodsugarwardnot" id="bloodsugarwardnot" <?php if($bloodsugarwardnot == '1') echo 'checked'; ?> onClick="return funcpackcheck();" value="1">
</span><span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="bloodsugartheatre" id="bloodsugartheatre" value="<?php echo $bloodsugartheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">No. of Units Cross-Matched</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="ucrossmatchward" id="ucrossmatchward" value="<?php echo $ucrossmatchward; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="ucrossmatchwardnot" id="ucrossmatchwardnot" onClick="return funcpackcheck();" <?php if($ucrossmatchwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="ucrossmatchtheatre" id="ucrossmatchtheatre" value="<?php echo $ucrossmatchtheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="ucrossmatchtheatrenot" id="ucrossmatchtheatrenot" onClick="return funcpackcheck();" <?php if($ucrossmatchtheatrenot == '1') echo 'checked'; ?> value="1">
                  N/R</td>
              </tr>
              
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PATIENT PREPARATION COMPLETED </strong></td>
			     </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Identification band </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="idbandward" id="idbandward" onClick="return funcpackcheck();" <?php if($idbandward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="idbandtheatre" id="idbandtheatre" onClick="return funcpackcheck();" <?php if($idbandtheatre == '1') echo 'checked'; ?> value="1"></td>
                </tr>
				
				   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Theatre Gown </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="gownward" id="gownward" onClick="return funcpackcheck();" <?php if($gownward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="gowntheatre" id="gowntheatre" value="<?php echo $gowntheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Personal Items Removed or Absent </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
				 <tr>
                <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td width="22%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Underclothes</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="underclothward" id="underclothward" onClick="return funcpackcheck();" <?php if($underclothward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="underclothnot" id="underclothnot" onClick="return funcpackcheck();" <?php if($underclothnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="undercloththeatre" id="undercloththeatre" value="<?php echo $undercloththeatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Dentures</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="dentureward" id="dentureward" onClick="return funcpackcheck();" <?php if($dentureward == '1') echo 'checked'; ?> value="1"></td>
				
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="denturenot" id="denturenot" onClick="return funcpackcheck();" <?php if($denturenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="denturetheatre" id="denturetheatre" value="<?php echo $denturetheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Wig and Hairpins </td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="wighairward" id="wighairward" onClick="return funcpackcheck();" <?php if($wighairward == '1') echo 'checked'; ?> value="1"></td>
				    <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="wighairwardnot" id="wighairwardnot" onClick="return funcpackcheck();" <?php if($wighairwardnot == '1') echo 'checked'; ?> value="1">
                            <span class="bodytext3">N/R </span></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="wighairtheatre" id="wighairtheatre" value="<?php echo $wighairtheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
             </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Contact Lenses</td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="lensward" id="lensward" onClick="return funcpackcheck();" <?php if($lensward == '1') echo 'checked'; ?> value="1"></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="lenswardnot" id="lenswardnot" onClick="return funcpackcheck();" <?php if($lenswardnot == '1') echo 'checked'; ?> value="1">
					      <span class="bodytext3">N/R</span></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="lenstheatre" id="lenstheatre" value="<?php echo $lenstheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
             </tr>
				
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Jewellery</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="jewelward" id="jewelward" onClick="return funcpackcheck();" <?php if($jewelward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="jewelwardnot" id="jewelwardnot" onClick="return funcpackcheck();" <?php if($jewelwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="jeweltheatre" id="jeweltheatre" value="<?php echo $jeweltheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Make Up and Nail Varnish </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="makeupnailward" id="makeupnailward" onClick="return funcpackcheck();" <?php if($makeupnailward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="makeupnailwardnot" id="makeupnailwardnot" onClick="return funcpackcheck();" <?php if($makeupnailwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="makeupnailtheatre" id="makeupnailtheatre" value="<?php echo $makeupnailtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
              
              <tr>
                <td colspan="2" align="middle"  bgcolor="#ecf0f5"><div align="left"><span class="bodytext3">Shaving</span></div></td>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5">
				  <div align="left">
				    <input type="checkbox" name="shavingward" id="shavingward" onClick="return funcpackcheck();" <?php if($shavingward == '1') echo 'checked'; ?> value="1">
				  </div></td>
                <td colspan="2" align="middle"  bgcolor="#ecf0f5"><div align="left">
                  <input type="checkbox" name="shavingwardnot" id="shavingwardnot" onClick="return funcpackcheck();" <?php if($shavingwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></div></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="shavingtheatre" id="shavingtheatre" value="<?php echo $shavingtheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
               </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Skin Preparation </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="skinward" id="skinward" onClick="return funcpackcheck();" <?php if($skinward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="skinwardnot" id="skinwardnot" onClick="return funcpackcheck();" <?php if($skinwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="skintheatre" id="skintheatre" value="<?php echo $skintheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Intravenous Drip In Place </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="intradipward" id="intradipward" onClick="return funcpackcheck();" <?php if($intradipward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="intradipwardnot" id="intradipwardnot" onClick="return funcpackcheck();" <?php if($intradipwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="intradiptheatre" id="intradiptheatre" value="<?php echo $intradiptheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Naso-Gastric Tube In Place </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nasotubeward" id="nasotubeward" onClick="return funcpackcheck();" <?php if($nasotubeward == '1') echo 'checked'; ?> value="1"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nasotubewardnot" id="nasotubewardnot" onClick="return funcpackcheck();" <?php if($nasotubewardnot == '1') echo 'checked'; ?> value="1">
			       <span class="bodytext3">N/R</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="nasotubewardtheatre" id="nasotubewardtheatre" value="<?php echo $nasotubewardtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Catheter In Place </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="catheterward" id="catheterward" onClick="return funcpackcheck();" <?php if($catheterward == '1') echo 'checked'; ?> value="1"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="catheterwardnot" id="catheterwardnot" onClick="return funcpackcheck();" <?php if($catheterwardnot == '1') echo 'checked'; ?> value="1">
			       <span class="bodytext3">N/R </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="cathetertheatre" id="cathetertheatre" value="<?php echo $cathetertheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time of Last Void </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="lastvoidward" id="lastvoidward" value="<?php echo $lastvoidward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="lastvoidtheatre" id="lastvoidtheatre" value="<?php echo $lastvoidtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Vital Signs </td>
			     <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5"><spanp class="bodytext3">
			       <span class="bodytext3">Temp</span></span></td>
			     <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="temp" id="temp" value="<?php echo $temp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">C
                     
			     </span></td>
			     <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="c" id="c" value="<?php echo $c; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"> R                 </span></td>
			     <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="r" id="r" value="<?php echo $r; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">BP                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="bp" id="bp" value="<?php echo $bp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"> P                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="p" id="p" value="<?php echo $p; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Dipstick Urinalysis Result </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="dipstickward" id="dipstickward" value="<?php echo $dipstickward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time Of Last Feed </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="lastfeedward" id="lastfeedward" value="<?php echo $lastfeedward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time Pre-Medication Given </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input name="premedward" id="premedward" value="<?php echo $premedward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">TIME:
			       <input name="timeward" id="timeward" value="<?php echo $timeward; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><p><strong>INFECTION PRECAUTIONS</strong></p></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">HIV TEST</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input type="checkbox" name="hivwardpos" id="hivwardpos" onClick="return funcpackcheck();" <?php if($hivwardpos == '1') echo 'checked'; ?> value="1">
			     +ve</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="hivwardneg" id="hivwardneg" onClick="return funcpackcheck();" <?php if($hivwardneg == '1') echo 'checked'; ?> value="1">
			       <span class="bodytext3">-ve</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input type="checkbox" name="hivwardnot" id="hivwardnot" onClick="return funcpackcheck();" <?php if($hivwardnot == '1') echo 'checked'; ?> value="1">
			       Not Done </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">ANAESTHETIST </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">REVIEW NOTES </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="anaesthetist" id="anaesthetist" value="<?php echo $anaesthetist; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="reviewnotes" id="reviewnotes" value="<?php echo $reviewnotes; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>CHECKED BY:</strong> <?php echo $username; ?> </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
              
              <tr>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
                  <input name="Submit222" type="submit"  value="Save Pre Op" class="button"/></td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

