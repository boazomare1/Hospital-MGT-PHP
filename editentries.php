<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$entrydate = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$dummy = '';
$cr_amount="";
$sessiondocno = $_SESSION['docno'];

$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];

if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }
if($frmflag1 == 'frmflag1')
{
$entryid = $_REQUEST['entryid'];	
$query2 = "select * from master_journalentries where docno ='$entryid'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);
if($res2>0){

$entrydate = $_REQUEST['entrydate'];
$entrydate = date('Y-m-d',strtotime($entrydate));
$narration = $_REQUEST['narration'];
$locationcode = $_REQUEST['location'];

$query66 = "select locationname from master_location where locationcode = '$locationcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$locationname = $res66['locationname'];
///////////////////
$total_debitamount=0;
$total_creditamount=0;
for($i=1;$i<=50;$i++)
{
	if(isset($_REQUEST['serialnumberentries'.$i]))
	{
		$serialnumberentries = $_REQUEST['serialnumberentries'.$i];
		
		if($serialnumberentries != '')
		{
			$entrytype = $_REQUEST['entrytype'.$i];
			$ledger = $_REQUEST['ledger'.$i];
			$ledgerno = $_REQUEST['ledgerno'.$i];
			$amount = $_REQUEST['amount'.$i];
			$amount = str_replace(',','',$amount);
			
			if($entrytype == 'Cr')
			{
				$creditamount = $amount;
				$debitamount = '0.00';
			}
			else
			{
				$debitamount = $amount;
				$creditamount = '0.00';
			}
			
			if($ledgerno!=''){
				$total_debitamount +=$debitamount;
				$total_creditamount +=$creditamount;
			}
		}
	}
}
if($total_debitamount == $total_creditamount)
{
	//save the data into db
for($i=1;$i<=50;$i++)
{
	if(isset($_REQUEST['serialnumberentries'.$i]))
	{
		$serialnumberentries = $_REQUEST['serialnumberentries'.$i];
		
		if($serialnumberentries != '')
		{
			$entrytype = $_REQUEST['entrytype'.$i];
			$ledger = $_REQUEST['ledger'.$i];
			$ledgerno = $_REQUEST['ledgerno'.$i];
			$amount = $_REQUEST['amount'.$i];
			$amount = str_replace(',','',$amount);
			$billwise = $_REQUEST['billwise'.$i];
			$remark = $_REQUEST['remark'.$i];
			$journal_id = $_REQUEST['journal_id'.$i];
			$tb_id = $_REQUEST['tb_id'.$i];
			if($entrytype == 'Cr')
			{
				$creditamount = $amount;
				$debitamount = '0.00';
			}
			else
			{
				$debitamount = $amount;
				$creditamount = '0.00';
			}
			
			if(isset($_REQUEST['costcenter'.$i]))
			{
			$costcenter = $_REQUEST['costcenter'.$i];
			}else{
			$costcenter = "";	
			}
			if($ledgerno!=''){
				
				$query7 = "update master_journalentries set entrydate='$entrydate',selecttype='$entrytype',ledgerid='$ledgerno',ledgername='$ledger',cost_center='$costcenter',transactionamount='$amount',creditamount='$creditamount',debitamount='$debitamount',username='$username',updatedatetime='$updatedatetime',locationcode='$locationcode',locationname='$locationname',narration='$narration',remarks='$remark' where docno='$entryid' and auto_number='$journal_id'";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
			}
		}
	}
}
	if (isset($_SESSION['items'])) {
	   unset($_SESSION['items']);
    }
	
}
else
{
	
	if (isset($_SESSION['items'])) {
	   unset($_SESSION['items']);
    }
// do not save the data into db
for($i=1;$i<=50;$i++)
{
	if(isset($_REQUEST['serialnumberentries'.$i]))
	{
		$serialnumberentries = $_REQUEST['serialnumberentries'.$i];
		
		if($serialnumberentries != '')
		{
			$entrytype = $_REQUEST['entrytype'.$i];
			$ledger = $_REQUEST['ledger'.$i];
			$ledgerno = $_REQUEST['ledgerno'.$i];
			$amount = $_REQUEST['amount'.$i];
			$amount = str_replace(',','',$amount);
			$billwise = $_REQUEST['billwise'.$i];
			$remark = $_REQUEST['remark'.$i];
			if($entrytype == 'Cr')
			{
				$creditamount = $amount;
				$debitamount = '0.00';
			}
			else
			{
				$debitamount = $amount;
				$creditamount = '0.00';
			}
			$costcenter = "";
			if(isset($_REQUEST['costcenter'.$i]))
			{
				$costcenter = $_REQUEST['costcenter'.$i];
			}
			if($ledgerno!=''){
				$_SESSION['items'][$i] = array('entrytype' => $entrytype, 'ledger' => $ledger, 'ledgerno' => $ledgerno, 'amount' => $amount, 'billwise' => $billwise, 'remark' => $remark,'costcenter' => $costcenter);
			}
		}
	}
}
	header("location:entries.php");
}
header("location:editentries.php");
exit;
}
//////////////////
//exit;
?>
<script>
		window.open("journalprint.php?billnumber=<?php echo $docno; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		window.open("entries.php?st=success","_self")
	</script>
<?php
}
?>
<?php
$entryid='';
$entrydate_jour='';
$locationcode_jour='';
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1'){ 
$entryid = $_POST['entryid'];

$query1 = "select * from master_journalentries where docno='$entryid' group by docno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$entrydate_jour = $res1["entrydate"];
	$locationcode_jour = $res1["locationcode"];
	
}


}


function processReplacement($one, $two)
{
return $one . strtoupper($two);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Journal Entries - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/editentries-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link href="css/autocomplete.css" rel="stylesheet">
    <script src="js/datetimepicker_css_fin.js"></script>
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Edit Journal Entries</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entries.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>New Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entriesreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Entries Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entries_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Upload Entries</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container" id="alertContainer"></div>
            
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-edit"></i> Edit Journal Entries</h2>
                    <p>Modify existing journal entries in the system</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-outline" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
            
            <div class="form-container">
                <div class="form-header">
                    <h3><i class="fas fa-file-invoice"></i> Journal Entry Details</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="editentries.php" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="entryid">Entry ID</label>
                            <input type="text" name="entryid" id="entryid" value="<?php echo $entryid; ?>" class="form-control" style="text-transform:uppercase;">
                        </div>
                        <div class="form-group">
                            <label for="entrydate">Entry Date</label>
                            <div class="input-group">
                                <input type="text" name="entrydate" id="entrydate" value="<?php echo $entrydate_jour;?>" class="form-control" readonly="readonly">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer" class="calendar-icon"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-control" style="pointer-events: none;">
                                <option value="">--Select Location--</option>
                                <?php
                                $query01="select locationcode,locationname from master_location where status='' group by locationcode";
                                $exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                                while($res01=mysqli_fetch_array($exc01))
                                {?>
                                <option value="<?= $res01['locationcode'] ?>" <?php if($locationcode_jour==$res01['locationcode']){ echo 'selected';} ?>> <?= $res01['locationname'] ?></option>		
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <input id="vamount" name="vamount" type="hidden" value="">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>
            
            <?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?>
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Ledger</th>
                            <th id="costcentertd"><span id='showhide' style="display:none">Cost Center</span></th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <th>&nbsp;</th>
                            <th>Cr.Amt</th>
                            <th>Dr.Amt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno=0;
                        $crtotalamount=0.00;
                        $drtotalamount=0.00;
                        $query1 = "select * from master_journalentries where docno='$entryid' order by auto_number asc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res1 = mysqli_fetch_array($exec1))
                        {
                        $crledgeramt=0.00;
                        $drledgeramt=0.00;
                        $auto_number_jour = $res1["auto_number"];
                        $selecttype_jour = $res1["selecttype"];
                        $ledgername_jour = $res1["ledgername"];
                        $ledgerid_jour = $res1["ledgerid"];
                        $transactionamountjour = $res1["transactionamount"];
                        $remarks_jour = $res1["remarks"];
                        $narration_jour = $res1["narration"];
                        $sno+=1;
                        if($selecttype_jour=='Cr'){
                        $crledgeramt=$res1["creditamount"];
                        $crtotalamount+=$res1["creditamount"];
                        }else{
                        $drledgeramt=$res1["debitamount"];	
                        $drtotalamount+=$res1["debitamount"];	
                        }
                        
                            $tbcostcenter="select cost_center_code,auto_number from tb where ledger_id='$ledgerid_jour' and doc_number='$entryid'";
                            $exectb = mysqli_query($GLOBALS["___mysqli_ston"], $tbcostcenter);
                            $restb= mysqli_fetch_array($exectb);
                            $costcenteridd=$restb["cost_center_code"];
                            $auto_number_tb=$restb["auto_number"];
                        
                        
                        
                            $hasdata =0;
                            $html="";
                            if(trim($ledgerid_jour !="" ))
                            {
                                
                                
                                $html="";
                                $cc_style = "'display:block'";
                                $query11 = "select accountsmain from master_accountname where id = '$ledgerid_jour'";
                                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res11 = mysqli_fetch_array($exec11);
                                $accountsmain = $res11['accountsmain'];
                                
                                $query11 = "select auto_number from master_accountsmain where auto_number = '$accountsmain'";
                                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res11 = mysqli_fetch_array($exec11);
                                $ledgergroupid = $res11['auto_number'];
                                if($ledgergroupid!="")
                                {
                                        $key=$sno;
                                        $query10 = "select auto_number,name from `master_costcenter` where group_id = '$ledgergroupid'";
                                        $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $num_rows = mysqli_num_rows($exec10);
                                        if($num_rows > 0)
                                        {
                                        $i =0;
                                        while ($res10 = mysqli_fetch_array($exec10))
                                        {
                                        $auto_number = $res10["auto_number"];
                                        $name = ucfirst(strtolower($res10["name"]));
                                        $name=preg_replace("/(^|[^a-zA-Z])([a-z])/e","processReplacement('$1', '$2')", $name);
                                        if(!$i)
                                        {
                                        $html .= '<select name="costcenter'.$key.'" id="costcenter'.$key.'"><option value="">Select Cost Center</option>';
                                        }
                                        $sel = "";
                                        
                                        if($costcenteridd== $auto_number)
                                        {
                                        $sel = "selected";
                                        }
                                        $html .= '<option value="'.$auto_number.'" '.$sel.'>'.$name.'</option>';
                                        $i++;	
                                        $hasdata++;
                                        }
                                        }
                                        
                                        if($hasdata)
                                        {
                                        $html .= "</select>";
                                        }
                                        
                                }
                            }
                            
                        ?>
                        <tr>
                            <td>
                                <input id="serialnumberentries<?php echo $sno; ?>" name="serialnumberentries<?php echo $sno; ?>" type="hidden" value="<?php echo $sno; ?>" readonly="">
                                <input id="journal_id<?php echo $sno; ?>" name="journal_id<?php echo $sno; ?>" type="hidden" value="<?php echo $auto_number_jour; ?>" readonly="">
                                <input id="tb_id<?php echo $sno; ?>" name="tb_id<?php echo $sno; ?>" type="hidden" value="<?php echo $auto_number_tb; ?>" readonly="">
                                
                                <select name="entrytype<?php echo $sno; ?>" id="entrytype<?php echo $sno; ?>" onChange="return FillAmt('1')" class="form-control" style="pointer-events: none;">
                                    <option value="Cr" <?php if($selecttype_jour=='Cr'){ echo 'selected'; } ?>>Cr</option>
                                    <option value="Dr" <?php if($selecttype_jour=='Dr'){ echo 'selected'; } ?>>Dr</option>
                                </select>
                            </td>
                            <td>
                                <input id="ledger<?php echo $sno; ?>" class="form-control" name="ledger<?php echo $sno; ?>" type="text" onClick="clicklocation();" value="<?php echo $ledgername_jour; ?>" readonly>
                                <input id="ledgerno<?php echo $sno; ?>" class="form-control" name="ledgerno<?php echo $sno; ?>" type="hidden" value="<?php echo $ledgerid_jour; ?>">
                                <input id="billwise<?php echo $sno; ?>" class="form-control" name="billwise<?php echo $sno; ?>" type="hidden">
                            </td>
                            <td id="costcenter_tdcontent<?php echo $sno; ?>">
                                <?= $html;?>	
                            </td>
                            <td>
                                <input class="form-control" id="amount<?php echo $sno; ?>" name="amount<?php echo $sno; ?>" type="text" onBlur="addcommas(this.id)" onKeyDown="return numbervaild(event)" onKeyUp="return FillAmt('1')" onFocus="return Dis('1')" value="<?php echo number_format($transactionamountjour,2,'.',',');?>" style="text-align:right; pointer-events: none;" readonly>
                            </td>
                            <td>
                                <textarea class="form-control" id="remark<?php echo $sno; ?>" name="remark<?php echo $sno; ?>" rows="2" cols="15"><?php echo $remarks_jour; ?></textarea>
                            </td>
                            <td>
                                <select id="selectact<?php echo $sno; ?>" name="selectact<?php echo $sno; ?>" class="form-control" style="display:none;">
                                    <option value="1">New Ref</option>
                                    <option value="2">Agst Ref</option>
                                    <option value="3">On Account</option>
                                </select>
                            </td>
                            <td>
                                <input id="cramount<?php echo $sno; ?>" name="cramount<?php echo $sno; ?>" type="text" readonly="readonly" value="<?php echo number_format($crledgeramt,2,'.',','); ?>" class="form-control" style="text-align:right; border:none; background-color:transparent;">
                            </td>
                            <td>
                                <input id="dramount<?php echo $sno; ?>" name="dramount<?php echo $sno; ?>" type="text" readonly="readonly" value="<?php echo number_format($drledgeramt,2,'.',','); ?>" class="form-control" style="text-align:right; border:none; background-color:transparent;">
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <tr class="total-row">
                            <td colspan="6" class="text-right"><strong>Total:</strong></td>
                            <td>
                                <input id="totalcr" name="totalcr" type="text" readonly="readonly" value="<?php echo number_format($crtotalamount,2,'.',',');?>" class="form-control" style="text-align:right; background-color: transparent; border:none; color:#FF0000; font-weight: bold;">
                            </td>
                            <td>
                                <input id="totaldr" name="totaldr" type="text" readonly="readonly" value="<?php echo number_format($drtotalamount,2,'.',','); ?>" class="form-control" style="text-align:right; background-color: transparent; border:none; color:#FF0000; font-weight: bold;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="form-container">
                <div class="form-row">
                    <div class="form-group">
                        <label for="narration">Narration</label>
                        <textarea name="narration" id="narration" rows="3" cols="30" class="form-control"><?php echo $narration_jour; ?></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="serialnumber" id="serialnumber" value="<?php echo $sno;?>" />
                    <input type="hidden" name="serialnumberref" id="serialnumberref" value="<?php echo $sno;?>" />
                    <input type="hidden" name="subrefserial" id="subrefserial" value="<?php echo $sno;?>" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <button type="submit" name="Submit" class="btn btn-primary" onClick="return entries()">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>
    
    <script src="js/editentries-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>