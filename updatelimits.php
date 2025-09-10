<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");//echo $menu_id;include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
ini_set('max_execution_time', 12000000); //120 seconds
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["cbfrmflag3"])) { $cbfrmflag3 = $_REQUEST["cbfrmflag3"]; } else { $cbfrmflag3 = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}


if($cbfrmflag2== 'cbfrmflag2')
{
	$startdate=$_REQUEST['startdate'];
	$enddate=$_REQUEST['enddate'];
	$opoveralllimit=$_REQUEST['opoveralllimit'];
	$ipoveralllimit=$_REQUEST['ipoveralllimit'];
	$patientcode=$_REQUEST['patientcode'];
	$check=$_REQUEST['checkpatient'];
	
	if($check !='')
	{
		$query="update master_customer set planvaliditystart='$startdate' , planexpirydate='$enddate',planvalidityend='$enddate', overalllimit='$opoveralllimit', ipoveralllimit='$ipoveralllimit' where customercode='$patientcode' " ; 
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));	
	header('location:updatelimits.php?st=1'); exit;	
	}
	
	header('location:updatelimits.php?st=2'); exit;
}


if($cbfrmflag3== 'cbfrmflag3')
{
	/*$startdate=$_REQUEST['startdatesc'];
	$enddate=$_REQUEST['enddatesc'];
	$opoveralllimit=$_REQUEST['opoveralllimitsc'];
	$ipoveralllimit=$_REQUEST['ipoveralllimitsc'];
	$accountcode=$_REQUEST['accountcode'];
	$plancode=$_REQUEST['plancode'];
	print_r($check=$_POST['checkscheme']);*/
	
	foreach($_POST['checkscheme'] as $key=>$value)
	{ 
	
		 $_POST['checkscheme'] [$key];
		$startdate= $_POST['startdatesc'][$key];
		$enddate= $_POST['enddatesc'][$key];
		$opoveralllimit= $_POST['opoveralllimitsc'][$key];
		$ipoveralllimit= $_POST['ipoveralllimitsc'][$key];
	 	$accountcode= $_POST['accountcode'][$key];
		$plancode= $_POST['plancode'][$key];
		
		
		 $query="update master_customer set planvaliditystart='$startdate' , planexpirydate='$enddate',planvalidityend='$enddate', overalllimit='$opoveralllimit', ipoveralllimit='$ipoveralllimit' where accountname='$accountcode' and planname='$plancode' " ;  
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	$query1="update master_planname set planstartdate='$startdate' , planexpirydate='$enddate', overalllimitop='$opoveralllimit', overalllimitip='$ipoveralllimit' where accountname='$accountcode' and auto_number='$plancode' " ;  
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	
	header('location:updatelimits.php?st=1'); exit;	
	
	
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1')
{
	$errmsg = "Success. Limit Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed.  Entry Not Completed.";
}

function calculate_age($birthday)
			{
				$today = new DateTime();
				$diff = $today->diff(new DateTime($birthday));
			
				if ($diff->y)
				{
					return $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
					return $diff->m . ' Months';
				}
				else
				{
					return $diff->d . ' Days';
				}
			}
?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ 
zoom:.7 !important;
 }
</style>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script>

 function  checksubmit()
 {
	 var check = document.getElementById("checkpatient").checked;
	 
	 if(check==false)
	 {
		 alert('Please tick the checkbox');
		 return false;
	 }
 }
</script>

<script type="text/javascript">
$(document).ready(function() {
		 
		 
$('#scheme').autocomplete({
 	
	source:'ajaxdata.php?process=scheme', 
	
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			
			
			var accountauto = ui.item.accountauto;
			
			$('#accountauto').val(accountauto);
			
			},
    });
	
	$('#patient').autocomplete({
 	
	source:'ajaxcustomernewserach.php', 
	
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var patient = ui.item.customerfullname;
			var patientcode = ui.item.customercode;
			document.getElementById('patientcode').value=patientcode;
			
			},
    });
	
	
	$('#checkpatient').click(function() {
        if ($(this).is(':checked')) {
            
			$('#ipoveralllimit').attr("readonly", false);
			$('#opoveralllimit').attr("readonly", false);
			$('#startdate').attr("readonly", false);
			$('#enddate').attr("readonly", false);
			
        }
		if (!$(this).is(':checked')) {
            
			$('#ipoveralllimit').attr("readonly", true);
			$('#opoveralllimit').attr("readonly", true);
			$('#startdate').attr("readonly", true);
			$('#enddate').attr("readonly", true);
        }
    });
	
	//var checksc = $('#checkscheme').val();
	$('.checkscheme').click(function() {
		
		 var checksc = $(this).val();
        if ($(this).is(':checked')) {
            
			$('#ipoveralllimitsc'+checksc).attr("readonly", false);
			$('#opoveralllimitsc'+checksc).attr("readonly", false);
			$('#startdatesc'+checksc).attr("readonly", false);
			$('#enddatesc'+checksc).attr("readonly", false);
			
        }
		if (!$(this).is(':checked')) {
            
			$('#ipoveralllimitsc'+checksc).attr("readonly", true);
			$('#opoveralllimitsc'+checksc).attr("readonly", true);
			$('#startdatesc'+checksc).attr("readonly", true);
			$('#enddatesc'+checksc).attr("readonly", true);
        }
    });

});
function process()
	{
		
		$('#scheme1').hide();
	}
function changefunction()
	{
		var search2=document.getElementById('search').value;
		if( search2=='patient')
		{
		$('#patient1').show();
		$('#scheme1').hide();	
		}
		else
		{
			$('#patient1').hide();
			$('#scheme1').show();
		}
	}
	
	

</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>



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
.pagination{ float:right; }
</style>
</head>


<body onLoad="return process()">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="updatelimits.php" >
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Update Limits</strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Type</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <Select name="search" id="search" onChange="return changefunction()">
                <option value="patient">Patient</option>
                <option value="scheme">Scheme</option>
                </Select>
              </span></td>
              </tr>
			    <tr id="scheme1">
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Scheme Search</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="scheme" type="text" id="scheme" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
              
			    <tr id="patient1">
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
                <input name="patientcode" type="hidden" id="patientcode" value="" size="50" autocomplete="off">
                <input name="accountauto" type="hidden" id="accountauto" value="" size="50" autocomplete="off">
               
              </span></td>
              </tr>
			    		
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
     
      <tr>
        <td  ><?php echo $errmsg; ?></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td >&nbsp;</td>
      </tr>
	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
	$st='';
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page']))
{
	  $_process=$_REQUEST['search'];
	  	
	 if($_process =="patient")
	 {
		 ?>
         
         
         
         
              
         <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1074" 
            align="left" border="0">
            
          <tbody>
           <form name="cbform2" method="post" action="updatelimits.php">
            <tr>
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
               
                <div align="left"><strong>Patient Search</strong><label class="number"></label>
                </div></td>
              </tr>
			  
					
            
            <tr>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Full Name </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg.No</strong></div></td>
				
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Scheme </strong></div></td>
				  <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Plan Name </strong></div></td>
                <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Plan Start Date</strong></div></td>
              <td width="20%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Plan End Date</strong></div></td>
                <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> OP Overall Limit</strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>IP Overall Limit</strong></td>
                 <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Check</strong></td>
              </tr>
         
         
       
         <?php
		 $sno='';
		
		 $patient=$_REQUEST['patient'];
		 $patientcode=$_REQUEST['patientcode'];
	 	 $query01="select * from master_customer where customercode='$patientcode'  ";
		 $exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
		 while($res01=mysqli_fetch_array($exe01))
		 {
		 	$patientname=$res01['customerfullname'];
			$customercode=$res01['customercode'];
			$accountcode=$res01['accountname'];
			$plancode=$res01['planname'];
			$startdate=$res01['planvaliditystart'];
			$enddate=$res01['planexpirydate'];
			$opoveralllimit=trim($res01['overalllimit']);
			$ipoveralllimit=trim($res01['ipoveralllimit']);
			
		 	
		 	 $query1="select * from master_accountname where auto_number='$accountcode'  ";
		 	 $exe1=mysqli_query($GLOBALS["___mysqli_ston"], $query1);
			 $res1=mysqli_fetch_array($exe1);
			 $accountname=$res1['accountname'];
			 
			 $query12="select * from master_planname where auto_number='$plancode'  ";
		 	 $exe12=mysqli_query($GLOBALS["___mysqli_ston"], $query12);
			 $res12=mysqli_fetch_array($exe12);
			 $planname=$res12['planname'];
			
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
         
         <form name="update" method="post" action="updatelimits.php" >
                   <tr  <?php echo $colorcode; ?>>
              <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="center"><strong><?php echo $sno = $sno + 1;  ?> </strong></div></td>
				 <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><?php echo $patientname; ?></td>
				
				<td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php echo $patientcode; ?><input type="hidden" name="patientcode" id="patientcode" value="<?php  echo $customercode; ?>" ></div></td>
              <td width="30%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"> <?php echo $accountname; ?></div></td>
				  <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php echo $planname; ?> </div></td>
               <td width="263" align="left" valign="center"  ><span class="bodytext31">
            <input name="startdate" id="startdate" value="<?php echo $startdate; ?>" readonly='readonly'  size="10"  onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('startdate')" style="cursor:pointer"/>
		  </span></td>
                <td width="263" align="left" valign="center"  class="bodytext31"><input name="enddate" id="enddate" value="<?php echo $enddate; ?>"  size="10"   onKeyDown="return disableEnterKey()" readonly='readonly'  />
			<img src="images2/cal.gif"  onClick="javascript:NewCssCal('enddate')" style="cursor:pointer"/></td>
                 
                <td width="17%"  align="left" valign="center" 
                 class="bodytext31">
                 
                  <input type="text" name="opoveralllimit" id="opoveralllimit" value="<?php echo $opoveralllimit;  ?> " size="10"></td>
              <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><input type="text" name="ipoveralllimit" id="ipoveralllimit" value="<?php  echo $ipoveralllimit; ?>" size="10"></td>
                <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><input type="checkbox" name="checkpatient" id="checkpatient"   ></td>
              </tr>
               <tr>
        <td>&nbsp;</td>
      </tr>
              <tr>
                      <td align="left" valign="middle"  class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top" >
					  	<input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
                          <input  type="submit" value="Submit" name="Submit" onClick="return checksubmit();" />
                          <input name="resetbutton" type="reset" id="resetbutton"    value="Reset" /></td>
                    </tr>
                   
                    </form>
              </tbody>
              </table>
         <?php
		 
		 }
	 }
	
	
	
	if($_process == "scheme")
	{
		?>
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1074" 
            align="left" border="0">
            
          <tbody>
           <form name="cbform3" method="post" action="updatelimits.php">
            <tr>
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                 
                <div align="left"><strong>Scheme Search</strong><label class="number"></label>
                </div></td>
              </tr>
			  
					
            
            <tr>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Scheme </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Plan Name</strong></div></td>
				
           				  
                <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Plan Start Date</strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Plan End Date</strong></td>
                <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> OP Overall Limit</strong></div></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>IP Overall Limit</strong></td>
                <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> No Of Patients </strong></div></td>
                 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Check</strong></td>
              </tr>
        <?php
		 $sno='';
		
		 //$patient=$_REQUEST['patient'];
		 $accountauto=$_REQUEST['accountauto'];
	  	   $query2="select ma.accountname,mp.planname,mp.overalllimitop,mp.overalllimitip,mp.planstartdate,mp.planexpirydate,mp.auto_number  from master_accountname as ma left join master_planname as mp ON ma.auto_number=mp.accountname where ma.auto_number='$accountauto'   "; 
		 $exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
		 while($res2=mysqli_fetch_array($exe2))
		 {
		 	
			$accountname=$res2['accountname'];
			
			$startdate=$res2['planstartdate'];
			$enddate=$res2['planexpirydate'];
			$opoveralllimit=trim($res2['overalllimitop']);
			$ipoveralllimit=trim($res2['overalllimitip']);
			$planname=$res2['planname'];
			$plancode=$res2['auto_number'];
		 				 
			 $query12="select COUNT(auto_number) as plancount from master_customer where planname='$plancode'  ";
		 	 $exe12=mysqli_query($GLOBALS["___mysqli_ston"], $query12);
			 $res12=mysqli_fetch_array($exe12);
			 $patientcount=$res12['plancount'];
			
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
         
       
                   <tr  <?php echo $colorcode; ?>>
              <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="center"><strong><?php echo $sno = $sno + 1;  ?> </strong></div></td>
				 <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><?php echo $accountname; ?></td>
				
				<td width="10%"  align="left" valign="center" 
                 class="bodytext31"> <?php echo $planname; ?></td>
                
             
               <td width="263" align="left" valign="center"  ><span class="bodytext31">
            <input name="startdatesc[<?php echo $sno; ?>]" id="startdatesc<?php echo $sno; ?>" value="<?php echo $startdate; ?>" readonly='readonly'  size="10"  onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('startdatesc<?php echo $sno; ?>')" style="cursor:pointer"/>
		  </span></td>
                <td width="263" align="left" valign="center"  class="bodytext31"><input name="enddatesc[<?php echo $sno; ?>]" id="enddatesc<?php echo $sno; ?>" value="<?php echo $enddate; ?>"  size="10"   onKeyDown="return disableEnterKey()" readonly='readonly'  />
			<img src="images2/cal.gif"  onClick="javascript:NewCssCal('enddatesc<?php echo $sno; ?>')" style="cursor:pointer"/></td>
                 
                <td width="17%"  align="center" valign="center" 
                 class="bodytext31">
                 
                 <input type="hidden" name="accountcode[<?php echo $sno; ?>]" id="accountcode<?php echo $sno; ?>" value="<?php echo $accountauto;  ?> " readonly size="10">
                 <input type="hidden" name="plancode[<?php echo $sno; ?>]" id="plancode<?php echo $sno; ?>" value="<?php echo $plancode;  ?> " readonly size="10">
                  <input type="text" name="opoveralllimitsc[<?php echo $sno; ?>]" id="opoveralllimitsc<?php echo $sno; ?>" value="<?php echo $opoveralllimit;  ?> " readonly size="10"></td>
              <td width="17%"  align="center" valign="center" 
                 class="bodytext31"><input type="text" name="ipoveralllimitsc[<?php echo $sno; ?>]" id="ipoveralllimitsc<?php echo $sno; ?>" value="<?php  echo $ipoveralllimit; ?>" readonly size="10"></td>
                  <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><strong><?php echo $patientcount; ?></strong></div></td>
                <td width="17%"  align="left" valign="center" 
                 class="bodytext31">
                
                 <input type="checkbox" name="checkscheme[<?php echo $sno; ?>]" value="<?php echo $sno; ?>" id="checkscheme" class="checkscheme"   ></td>
              </tr>
              
      
      <?php
	  
		 }
		 ?>
              <tr>
                      <td align="left" valign="middle"  class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top" >
					  	<input type="hidden" name="cbfrmflag3" value="cbfrmflag3">
                          <input  type="submit" value="Submit" name="Submit" onClick="return checkschemenew();" />
                          <input name="resetbutton" type="reset" id="resetbutton"    value="Reset" /></td>
                    </tr>
                   
                    </form>
              </tbody>
              </table>
        
		 
	
    	
         
         <?php
	 }
}
?>
		
		
		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
  <?php
  

  ?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

