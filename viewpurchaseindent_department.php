<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno1 = $_SESSION['docno'];
$username = $_SESSION['username'];
$source='departmentapproval';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Purchase Indent - Department</title>
<!-- Modern CSS -->
<link href="css/viewpurchaseindent_department-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/viewpurchaseindent_department-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
function cbcustomername1()
{
	document.cbform1.submit();
}
</script>
<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
}
function disableEnterKey(varPassed)
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
</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<?php
if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='Purchase Indent';}
if(isset($_REQUEST['searchdpt'])){$searchdpt = $_REQUEST['searchdpt'];}else{$searchdpt='';}
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
if(isset($_POST['docno'])){$docno = $_POST['docno'];}else{$docno='';}
	$query1 = "select * from purchase_indent where initial_approval='' and indent_approval!='' and is_edited<>'1' and (date between '$fromdate' and '$todate')  and docno like '%$docno%' group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resnw3 = mysqli_num_rows($exec1);
	
	$query2 = "select * from purchase_indent where initial_approval='reject' and indent_approval!=''  and (date between '$fromdate' and '$todate') and docno like '%$docno%' group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resnw2 = mysqli_num_rows($exec2);
	 
?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" ><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" ><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" ><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="viewpurchaseindent_department.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr bgcolor="#011E6A">
              <td colspan="3"  class="bodytext3"><strong>Budget Purchase Indents Approval </strong></td>
              <td colspan="1" align="right"  class="bodytext3" id="ajaxlocation"><strong>  </strong>
             
            
                 
                  </td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docno" type="text" id="docno" value="" autocomplete="off">
              </span></td>
             
              
              </tr>
              
              
              
              
			  <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Status</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <select name="searchstatus" id="searchstatus">
			  <?php if($searchstatus != '') { ?>
			  <option value="<?php echo $searchstatus; ?>"><?php echo $searchstatus; ?></option>
			  <?php } ?>
              <option value="Purchase Indent">Purchase Indent</option>
			  <option value="All">All</option>             
			  <option value="Discarded">Discarded</option>
			  </select>
              </span></td>
			  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Department</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <select name="searchdpt" id="searchdpt">
			  <option value="">All Departments</option>
			   <?php
			  $query5 = "select * from master_payrolldepartment where recordstatus <> 'deleted' group by department order by department";
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res5 = mysqli_fetch_array($exec5))
			  {
			  $departmentanum = $res5['auto_number'];
			  $departmentname = $res5['department'];
			  ?>
			  <option value="<?php echo $departmentname; ?>" <?php if($searchdpt == $departmentname) {echo 'selected';}?>><?php echo $departmentname; ?></option>
			  <?php
			  }
			  ?>
			  </select>
              </span></td>
              </tr>
                   <tr>
          <td width="100" align="left" valign="center"  
 class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"   class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="263" align="left" valign="center"  ><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
					
				
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>    
    <td valign="top" width="99%"><table width="61%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
          <tr>
              <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                </td>
              </tr>
              <?php
			  if($searchdpt == '')
			  {
			  $searchdpt = '%%';
			  }
			   if($searchstatus=='Purchase Indent'||$searchstatus=='All'){?>
            <tr>
              <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong>Budget Purchase Indents Approval </strong></div><div align="right" style="width:20%; float:left;"><strong><<<?php echo $resnw3;?>>></strong>
                </div></td>
              </tr>
			  <?php
		$dptqry = "select distinct departmentname from master_employee where username in (select username from purchase_indent where initial_approval = '' and indent_approval!='') and departmentname like '$searchdpt'";
	$dptexec = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry);
	while ($resdpt = mysqli_fetch_assoc($dptexec))
	{
	$dpt = $resdpt['departmentname'];
	if(strtoupper($dpt) == 'OPERATIONS' )
	{
		$dptqry1 = "select distinct departmentunit from master_employee as a join master_employeeinfo as b on (a.employeecode = b.employeecode) where a.username in (select username from purchase_indent where initial_approval = '' and indent_approval!='') and a.departmentname = '$dpt'";
	$dptexec1 = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry1);
	while ($resdpt1 = mysqli_fetch_assoc($dptexec1))
	{
	$dpt1 = $resdpt1['departmentunit'];
			  ?>
			<tr>  <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong><?php if($dpt1!='')
				{
				echo $dpt.' - '.$dpt1;
				}
				else
				{
				echo $dpt.' - '.'OTHERS';
				}?></strong></div></td>
              </tr>
			 
            <tr>
              <td width="6%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
                
                <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Location</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Priority</strong></div></td>
                 <td width="17%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
	$query1 = "select * from purchase_indent where initial_approval='' and indent_approval!=''  and (date between '$fromdate' and '$todate') and docno like '%$docno%' and username in (select a.username from master_employee as a join master_employeeinfo as b on (a.employeecode = b.employeecode) where a.departmentname like '$dpt' and b.departmentunit like '$dpt1') group by docno";
		
		
		// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['username'];
			$status = $res1['status'];
			$docno1 = $res1['docno'];
			$remarks = $res1['remarks'];
			$priority = $res1['priority'];
			$approvalstatus = $res1['initial_approval'];
			
			$locationname = $res1['locationname'];
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
				$colorcode = '';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo date('d/m/Y',strtotime($date));?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $user.'-'.$dpt;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno1; ?></div></td>
                
                 <td class="bodytext31" valign="center"  align="left">
                            
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                            
			    <div align="left"><?php echo $status; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $remarks."<br>-By ".$user; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong style="font-size:14px;"><?php echo $priority; ?></strong></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapproval.php?docno=<?php echo $docno1; ?>&&source=<?php echo $source; ?>&&menuid=<?php echo $menu_id; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW Rejected';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			}   
			}
	
	}
	else
	{	
			  ?>
			<tr>  <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong><?php if($dpt!='')
				{
				echo $dpt;
				}
				else
				{
				echo 'OTHER DEPARTMENTS';
				}?></strong></div></td>
              </tr>
			 
            <tr>
              <td width="6%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
                
                 <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Location</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Priority</strong></div></td>
                 <td width="17%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
	$query1 = "select * from purchase_indent where initial_approval='' and indent_approval!=''  and (date between '$fromdate' and '$todate') and docno like '%$docno%' and username in (select username from master_employee where departmentname like '$dpt') and is_deleted!='1' and is_edited<>'1' group by docno";
		
		
		// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['username'];
			$status = $res1['status'];
			$docno1 = $res1['docno'];
			$remarks = $res1['remarks'];
			$priority = $res1['priority'];
			$approvalstatus = $res1['initial_approval'];
			
			$locationname = $res1['locationname'];
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
				$colorcode = '';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo date('d/m/Y',strtotime($date)); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $user.'-'.$dpt;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno1; ?></div></td>
                
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $locationname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $status; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $remarks."<br>-By ".$user; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong style="font-size:14px;"><?php echo $priority; ?></strong></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapproval.php?docno=<?php echo $docno1; ?>&&source=<?php echo $source; ?>&&menuid=<?php echo $menu_id; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW Rejected';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			}   
			
	}
	}
			/*?>
			<tr>  <td colspan="7"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong><?php echo 'OTHER DEPARTMENTS';?></strong></div></td>
              </tr>
			 
            <tr>
              <td width="6%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                 <td width="17%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
		$query1 = "select * from purchase_indent where approvalstatus=''  and (date between '$fromdate' and '$todate') and docno like '%$docno%' and username in (select username from master_employee where departmentname like '') and is_deleted!='1' group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['username'];
			$status = $res1['status'];
			$docno = $res1['docno'];
			$remarks = $res1['remarks'];
			$approvalstatus = $res1['approvalstatus'];
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
				$colorcode = '';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $user.'-'.$dpt;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $status; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $remarks."<br>-By ".$user; ?></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapproval.php?docno=<?php echo $docno; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW Rejected';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			} */  
			
			}
			if($searchstatus=='Discarded' || $searchstatus=='All'){?>
			
            <tr>
              <td colspan="8" class="bodytext31">&nbsp;
               </td>
              </tr>
            
            <tr>
              <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong>Discared Purchase Indents</strong></div><div align="right" style="width:20%; float:left;"><strong><<<?php echo $resnw2;?>>></strong>
                </div></td>
              </tr>
			  <?php
		 $dptqry = "select distinct departmentname from master_employee where username in (select fausername from purchase_indent where initial_approval = 'reject' ) and departmentname like '$searchdpt'";
	$dptexec = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry);
	while ($resdpt = mysqli_fetch_assoc($dptexec))
	{
	$dpt = $resdpt['departmentname'];
	if(strtoupper($dpt) == 'OPERATIONS' )
	{
		$dptqry1 = "select distinct departmentunit from master_employee as a join master_employeeinfo as b on (a.employeecode = b.employeecode) where a.username in (select fausername from purchase_indent where initial_approval = 'reject') and a.departmentname = '$dpt'";
	$dptexec1 = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry1);
	while ($resdpt1 = mysqli_fetch_assoc($dptexec1))
	{
	$dpt1 = $resdpt1['departmentunit'];
			  ?>
			<tr>  <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong><?php if($dpt1!='')
				{
				echo $dpt.' - '.$dpt1;
				}
				else
				{
				echo $dpt.' - '.'OTHERS';
				}?></strong></div></td>
              </tr>
            <tr>
              <td width="6%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Priority</strong></div></td>
                 <td width="17%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from purchase_indent where initial_approval='reject'   and (date between '$fromdate' and '$todate') and docno like '%$docno%' and fausername in (select a.username from master_employee as a join master_employeeinfo as b on (a.employeecode = b.employeecode) where a.departmentname like '$dpt' and b.departmentunit like '$dpt1') group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['fausername'];
			$status = $res1['status'];
			$docno1 = $res1['docno'];
			$remarks = $res1['remarks'];
			$priority = $res1['priority'];
			$approvalstatus = $res1['initial_approval'];
			
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
				$colorcode = '';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $user;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $status; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $remarks."<br>-By ".$user; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong style="font-size:14px;"><?php echo $priority; ?></strong></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapproval.php?docno=<?php echo $docno1; ?>&&source=<?php echo $source; ?>&&menuid=<?php echo $menu_id; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW Rejected';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			}  
		}	
	
	}
	else
	{
			  ?>
			<tr>  <td colspan="8"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong><?php if($dpt!='')
				{
				echo $dpt;
				}
				else
				{
				echo 'OTHER DEPARTMENTS';
				}?></strong></div></td>
              </tr>
            <tr>
              <td width="6%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Priority</strong></div></td>
                 <td width="17%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from purchase_indent where initial_approval='reject'  and (date between '$fromdate' and '$todate') and docno like '%$docno%' and fausername in (select username from master_employee where departmentname like '$dpt') group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['fausername'];
			$status = $res1['status'];
			$docno1 = $res1['docno'];
			$remarks = $res1['remarks'];
			$priority = $res1['priority'];
			$approvalstatus = $res1['initial_approval'];
			
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
				$colorcode = '';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $user;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $status; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $remarks."<br>-By ".$user; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong style="font-size:14px;"><?php echo $priority; ?></strong></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapproval.php?docno=<?php echo $docno1; ?>&&source=<?php echo $source; ?>&&menuid=<?php echo $menu_id; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW Rejected';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			}  
			
	}
	}
			/*?>
			<tr>  <td colspan="7"  class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong><?php echo 'OTHER DEPARTMENTS';?></strong></div></td>
              </tr>
            <tr>
              <td width="6%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="11%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                 <td width="17%" align="left" valign="center" 
 class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
	$query1 = "select * from purchase_indent where approvalstatus='rejected1' and (date between '$fromdate' and '$todate') and docno like '%$docno%' AND fausername in (select username from master_employee where departmentname like '') group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['fausername'];
			$status = $res1['status'];
			$docno = $res1['docno'];
			$remarks = $res1['remarks'];
			$approvalstatus = $res1['approvalstatus'];
			
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
				$colorcode = '';
			}
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $user;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $status; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $remarks."<br>-By ".$user; ?></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapproval.php?docno=<?php echo $docno; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW Rejected';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			}  
			*/
			}
			?>
		
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
>&nbsp;</td>
             </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
    </td>
    </tr>
  </table>
<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>
</body>
</html>