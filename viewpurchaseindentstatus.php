<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docnumber=isset($_REQUEST['docno'])?$_REQUEST['docno']:'';
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
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
if(isset($_POST['docno'])){$docnoo = $_POST['docno'];}else{$docnoo='';}
if(isset($_POST['searchstatus'])){$searchstatus = $_POST['searchstatus'];}else{$searchstatus='';}


$query1 = "select * from purchase_indent where approvalstatus='rejected' and username='$username' and (date between '$fromdate' and '$todate') and docno like '%$docnoo%'   group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw3 = mysqli_num_rows($exec1);
				?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="viewpurchaseindentstatus.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Indents </strong></td>
              <td colspan="1" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong>  </strong>
             
            
                 
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
               <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <select name="searchstatus" id="searchstatus">
              <option value="All">All</option> 
			  <option value="Purchase Indent">Purchase Indent</option>			              
			  <option value="Discarded">Discarded</option>
			  </select>
              </span></td>
              </tr>
			  
                   <tr>
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
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
    
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    
    <td valign="top"><table width="61%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
          <?php /*?>  <tr>
              <td colspan="7" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                 <div align="left" style="width:70%; float:left"><strong>Purchase Indents</strong></div><div align="right" style="width:20%; float:left;"><strong><<<?php echo $resnw3;?>>></strong>
                </div></td>
              </tr>
            <tr>
              <td width="6%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="11%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="13%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="11%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="32%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                 <td width="17%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select date,username,status,docno,remarks,approvalstatus,pogeneration,bausername,fausername,ceousername from purchase_indent where  username='$username' and (date between '$fromdate' and '$todate') and docno like '%$docno%' group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['username'];
			$status = $res1['status'];
			$docno = $res1['docno'];
			$remarks = $res1['remarks'];
			$approvalstatus = $res1['approvalstatus'];
			$ceousername = $res1['ceousername'];
			$fausername = $res1['fausername'];
			$bausername = $res1['bausername'];
			$pogeneration = $res1['pogeneration'];
			
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
			
			
			
			if($bausername=='' && $fausername=='' && $ceousername=='')
			{
				$status='Budget Holder Approval Pending';
			}
			elseif($fausername=='' && $ceousername=='' && $bausername!='' )
			{
				$status='Finance Approval Pending';
			}
			elseif($ceousername=='' && $bausername!='' && $fausername!='' )
			{
				$status='C.E.O Approval Pending';
			}
			elseif($pogeneration=='' &&$ceousername!='' && $bausername!='' && $fausername!='' )
			{
				$status='Generate PO Pending';
			}
			
			
			if($pogeneration!='completed')
			{
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
			    <div align="left"><?php echo $remarks; ?></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="purchaseindentapprovaluser.php?docno=<?php echo $docno; ?>"><strong> <?php if($approvalstatus=='')
				{
                 echo 'VIEW';
				}
				else
				{
					echo 'VIEW ';
				}
				?></strong></a></div></td>
              </tr>
			<?php
			}  }  
			?>
		<?php */?>
        
         <?php if($searchstatus=='Purchase Indent'||$searchstatus=='All'){?>
            <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong>Purchase Indents </strong></div><div align="right" style="width:20%; float:left;"><strong></strong>
                </div></td>
              </tr>
            <tr>
              <td width="12%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="16%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="17%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="15%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="24%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="16%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                <td width="16%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>View</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
 		 	$query1 = "select date,username,status,docno,remarks,approvalstatus,pogeneration,bausername,fausername,ceousername,suppliercode from purchase_indent where  date between '$fromdate' and '$todate' and docno like '%$docnoo%' and  (approvalstatus = '' OR approvalstatus='1' OR approvalstatus='partially' OR approvalstatus='approved') and username = '$username' group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow=mysqli_num_rows($exec1);
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$date = $res1['date'];
			$user = $res1['username'];
			$status = $res1['status'];
			$docno = $res1['docno'];
			$remarks = $res1['remarks'];
			$approvalstatus = $res1['approvalstatus'];
			$ceousername = $res1['ceousername'];
			$fausername = $res1['fausername'];
			$bausername = $res1['bausername'];
			$pogeneration = $res1['pogeneration'];
			$suppliercode = $res1['suppliercode'];
			
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
			
			
			
			if($bausername=='' && $fausername=='' && $ceousername=='')
			{
				$status='Budget Holder Approval Pending';
			}
			elseif($fausername=='' && $ceousername=='' && $bausername!='' )
			{
				$status='Finance Approval Pending';
			}
			elseif($ceousername=='' && $bausername!='' && $fausername!='' )
			{
				$status='C.E.O Approval Pending';
			}
			elseif($pogeneration=='' &&$ceousername!='' && $bausername!='' && $fausername!='' )
			{
				$status='Generate PO Pending';
			}
			else if($pogeneration=='completed' &&$ceousername!='' && $bausername!='' && $fausername!=''){

				$po_username='';
				$querya1=mysqli_query($GLOBALS["___mysqli_ston"], "select username from manual_lpo where purchaseindentdocno='$docno'");
				if($resa1=mysqli_fetch_array($querya1))
					$po_username=$resa1['username'];

				$querya1=mysqli_query($GLOBALS["___mysqli_ston"], "select username from purchaseorder_details where purchaseindentdocno='$docno'");
				if($resa1=mysqli_fetch_array($querya1))
					$po_username=$resa1['username'];
	
				if($po_username!='')
					$status='Generate PO Completed by '.$po_username;
				else
					$status='Generate PO Completed';
			}
			
			//if($pogeneration!='completed')
			{
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
			    <div align="left"><?php echo $remarks; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><a href="viewindent.php?billnumber=<?= $docno; ?>&&suppliercode=<?= $suppliercode; ?>"><?php echo 'View'; ?></a></div></td>
              </tr>
			<?php
			} 
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
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                
             </tr>
            <?php
			}
			if($searchstatus=='Discarded'||$searchstatus=='All'){?>
			
            <tr>
              <td colspan="8" class="bodytext31">&nbsp;
               </td>
              </tr>
            
            <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left" style="width:70%; float:left"><strong>Discared Purchase Indents</strong></div><div align="right" style="width:20%; float:left;">
                </div></td>
              </tr>
            <tr>
              <td width="12%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="16%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="17%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From </strong></div></td>
				 <td width="15%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="24%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
                <td width="16%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
                 <td width="16%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>View</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			 $query11 = "select date,username,status,docno,remarks,approvalstatus,pogeneration,bausername,fausername,ceousername,suppliercode from purchase_indent where approvalstatus like '%reject%'   and   username='$username' and ((date between '$fromdate' and '$todate') OR (docno like '%$docnoo%')) group by docno";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res11 = mysqli_fetch_array($exec11))
			{
			$date = $res11['date'];
			$user = $res11['username'];
			$status = $res11['status'];
			$docno = $res11['docno'];
			$remarks = $res11['remarks'];
			$approvalstatus = $res11['approvalstatus'];
			$ceousername = $res11['ceousername'];
			$fausername = $res11['fausername'];
			$bausername = $res11['bausername'];
			$pogeneration = $res11['pogeneration'];
			$suppliercode = $res11['suppliercode'];
			
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
			
			
			
			if($bausername=='' && $fausername=='' && $ceousername=='')
			{
				$status='Budget Holder Approval Pending';
			}
			elseif($fausername=='' && $ceousername=='' && $bausername!='' )
			{
				$status='Budget Holder Rejected';
			}
			elseif($ceousername=='' && $bausername!='' && $fausername!='' )
			{
				$status='Finance Approval Rejected';
			}
			elseif($pogeneration=='' &&$ceousername!='' && $bausername!='' && $fausername!='' )
			{
				$status='CEO Approval Rejected';
			}
			
			if($pogeneration!='completed')
			{
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
			    <div align="left"><?php echo $remarks; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><a href="viewindent1.php?billnumber=<?= $docno; ?>&&suppliercode=<?= $suppliercode; ?>"><?php echo 'View'; ?></a></div></td>
              </tr>
			<?php
			}  
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
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                
             </tr>
             <?php
			 
			 }
			?>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

