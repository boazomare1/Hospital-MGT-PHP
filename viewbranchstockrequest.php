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
$docno = $_SESSION['docno'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
if(isset($_POST['ADate1'])){$transactiondatefrom = $_POST['ADate1'];}else{$transactiondatefrom=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$transactiondateto = $_POST['ADate2'];}else{$transactiondateto=$transactiondateto;}
if(isset($_POST['searchstorecode'])){$searchstorecode = $_POST['searchstorecode'];}else{$searchstorecode='';}
$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1location = $res1["locationname"];
			$res7locationanum = $res1["locationcode"];
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
padding-left:650px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
$(function(){
$('a.prevent').each(function() {
        var href= $(this).attr('href');
        $(this).attr('href','javascript:void(0);');
        $(this).attr('jshref',href);
    });
    $('a.prevent').bind('click', function(e) 
    {
        e.stopImmediatePropagation();           
        e.preventDefault();
        e.stopPropagation();
        var href= $(this).attr('jshref');
        if ( !e.metaKey && e.ctrlKey )
            e.metaKey = e.ctrlKey;
        if(!e.metaKey)
        {
            location.href= href;
        }
        return false;
		})
		
		$("a.prevent").on("contextmenu",function(){
			if(event.button==2)
   {
    
       return false;
	    }
    });
});
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
 $querynw1 = "select auto_number from master_branchstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' and to_location='$res7locationanum' group by docno order by auto_number desc";
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
		 
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
              <form name="cbform1" method="post" action="viewbranchstockrequest.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr>
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Store </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31" colspan="3">
          <select name="searchstorecode" id="searchstorecode" >
          	<?php
			  $query2 = "SELECT storecode,defaultstore from master_employeelocation WHERE username='$username' and defaultstore='default' and locationcode='$res7locationanum'"; 
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$storecode = '';
				while ($res2 = mysqli_fetch_array($exec2))
				{
					$storecodeanum = $res2['storecode'];
					$defaultstore = $res2['defaultstore'];
					$query751 = "select store, storecode from master_store where auto_number='$storecodeanum' ";
					$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res751 = mysqli_fetch_array($exec751);
					$res2store = $res751['store'];
					$storecode = $res751['storecode'];
					if($storecode!=""){
					?>
					<option value="<?php echo $storecode; ?>" <?php if($defaultstore=='default'){ echo 'selected';}?>><?php echo $res2store; ?></option>
				<?php
					}
				}
            ?>
            
          </select>
          			</td>
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="60%" 
            align="left" border="0">
          <tbody>
            <tr>
             
              <td colspan="8" cellpadding="1" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
               <strong> Requests</strong><label class="number">  <<<?php echo $resnw1;?>>>  </label> </td>
              </tr>
            <tr>
              <td width="" class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Date</strong></div></td>
              <td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doc No.</strong></div></td>
              <td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> From Location</strong></div></td>
              <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From Store</strong></div></td>
              <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
              <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			$colorloopcount = '';
			$sno = '';
			if($searchstorecode!='')
			{
			$query1 = "select from_location,fromstore,updatedatetime,docno,tostore,typetransfer,username,remarks from master_branchstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' and to_location='$res7locationanum' group by docno order by auto_number desc";
			}
			else
			{
			$query1 = "select from_location,fromstore,updatedatetime,docno,tostore,typetransfer,username,remarks from master_branchstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' and to_location='$res7locationanum' group by docno order by auto_number desc";
								
			}
			
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$from = $res1['fromstore'];
			$fromlocation = $res1['from_location'];
			$date = $res1['updatedatetime'];
			$docno = $res1['docno'];
			$to = $res1['tostore'];
			$typetransfer = $res1['typetransfer'];
			$requser = $res1['username'];
			$remarks = $res1['remarks'];
			
			$query4 = "select store from master_store WHERE storecode = '".$from."'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$storename = $res4["store"];
			$query_location = "SELECT locationname from master_location WHERE locationcode = '".$fromlocation."'";
			$exec_location = mysqli_query($GLOBALS["___mysqli_ston"], $query_location) or die ("Error in Query_location".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_location = mysqli_fetch_array($exec_location);
			$from_location_name = $res_location["locationname"];
			
			$query3 = "select auto_number from master_store WHERE storecode = '".$to."'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$storeanum = $res3["auto_number"];
			
			$query2 = "select storecode from master_employeelocation WHERE storecode = '".$storeanum."' and username='$username'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$num2 = mysqli_num_rows($exec2);
			$store = $res2["storecode"];
			
			
			
			$timestamp = strtotime($date);
			$child1 = date('j/n/Y', $timestamp); // d.m.YYYY
			$child2 = date('H:i', $timestamp); // HH:ss
			if($typetransfer=='1')
			{
				$num2=1;
			}
			if($num2>0)
			{
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $child1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $docno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $from_location_name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $storename.' - '.$requser; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $remarks; ?></td>
              <td class="bodytext31" valign="center" align="left"><div align="left"><a class=""  href="branchstocktransfer_view.php?docno=<?php echo $docno; ?>"><strong>View</strong></a></div></td>
            </tr>
			<?php
			}    
			}
			?>
		
            <tr>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
                 </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>