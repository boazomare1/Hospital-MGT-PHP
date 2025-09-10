<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username=$_SESSION['username'];
$updatedatetime = date('Y-m-d H:i:s');
$thistime=time('H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";


?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

</head>

<script language="javascript">

$(document).ready(function(){
	
	$('#empname').autocomplete({
		
	source:"ajaxuser_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var userid=ui.item.usercode;
			var username=ui.item.username;

			$("#empcode").val(userid);
			$("#selectedempname").val(username);
	
			},
    
	});
		
});


function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter lab Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if (document.form1.itemcode.value != "")
	{}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter Lab Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	
	
	
	
	
	/*
	if (document.form1.itemname_abbreviation.value == "")
	{
		alert ("Pleae Select Unit Name.");
		document.form1.itemname_abbreviation.focus();
		return false;
	}
	*/
	if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}


}

/*
function process1()
{
	//alert (document.form1.itemname.value);
	if (document.form1.itemname_abbreviation.value == "SR")
	{
		document.getElementById('expiryperiod').style.visibility = '';
	}
	else
	{
		document.getElementById('expiryperiod').style.visibility = 'hidden';
	}
}
*/
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your lab Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}
 
 
function process2()
{
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}

function process1backkeypress1()
{
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
		return false;
	}
	else
	{
		return true;
	}

}





function adddata(a){
	
	
	var amount=$('#amount').val();
	
	var doc=$('#doc').val();
	 var selValue = $('input[name=action]:checked').val(); 
	alert(amount);
	alert(doc);
	alert(selValue);
	var data = 'amount='+amount+'&&doc='+doc+'&&selValue='+selValue;
	$.ajax({
		type : "POST",
		url : "pettyupdate.php",
		data : data,
		cache:false,
		
		success: function(data){
			//alert(data); 
			location.reload();
		}
		
	});	
	}


</script>
<body onLoad="return process2()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
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
    <td height="34" colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="80%" valign="top" >
    <table width="97%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="80%" height="36">
        <!-- <table width="730" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1"> -->
        	<table width="860" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
        <form method="post" action="disbursedpettycash.php">
         <tr bgcolor="#011E6A">
                        <td height="27" colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Petty Cash Management-Disbursed-List </strong></td>
                </tr>
				       <tr bgcolor="#FFFFFF">
              <td align="left" valign="middle"  class="bodytext31">Request Number</td>
              <td colspan="5" align="left" valign="top"  ><span class="bodytext3">
                <input name="request" type="text" id="request" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			     <tr bgcolor="#FFFFFF">
				
				
              <td align="left" valign="middle"  class="bodytext31">User</td>
              <td colspan="5" align="left" valign="top"  ><span class="bodytext3">
                <input name="empname" type="text" id="empname" value="" size="50" autocomplete="off">
				<input name="empcode" type="hidden" id="empcode" value="" > 
			    <input name="selectedempname" type="hidden" id="selectedempname" value="" > 
              </span></td>
              </tr>
                      
                      <tr bgcolor="#FFFFFF">
                      
                        
                        <td align="left" valign="middle"  class="bodytext31">Date From</td>
                       <td width="145" align="left" valign="center"  class="bodytext311"><input name="ADate1" id="ADate1" value="<?php echo date('Y-m-d'); ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
            <td width="60" align="left" valign="middle"  class="bodytext31">Date To</td>
                       <td width="229" align="left" valign="center"  class="bodytext311"><input name="ADate2" id="ADate2" value="<?php echo date('Y-m-d'); ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>			</td>
                      <td  align="left" valign="top" >&nbsp;</td>
                        <td  align="left" valign="top"  >&nbsp;</td>
                      </tr>
                      
					 <tr bgcolor="#FFFFFF">
<!--                    <td  align="left" valign="top"   class="bodytext31">&nbsp;</td>
-->                     
						<td  align="left" valign="top"  >&nbsp;</td>
                        <td  align="left" valign="top"  >&nbsp;</td>
                        <td  align="left" valign="top"  >&nbsp;</td>
                        <td  align="left" valign="top"  >&nbsp;</td>
                        <td  align="left" valign="top"  >&nbsp;</td>
                        <td width="63" align="left" valign="top" ><input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="submit" name="Submit" value="Search" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      
					
        </form>
         <tr>
                 <td height="" align="left" valign="top"  class="bodytext31">&nbsp;</td>
                </tr>
        </table>
        </td>
        </tr>
        
        <?php if (isset($_REQUEST["frmflag1"])) {  $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; } 
		if ($frmflag1 == 'frmflag1')
		
		{
			if (isset($_REQUEST["empname"])) { $user = $_REQUEST["empname"]; } else { $user = ""; }
if (isset($_REQUEST["request"])) { $request= $_REQUEST["request"]; } else { $request = ""; }

		$startdate=$_REQUEST['ADate1'];
	    $enddate=$_REQUEST['ADate2'];
	    $sno=0;
	    $querry=" select  docno,entrydate,ledgerid,ledgername,transactionamount,username from master_journalentries where docno like '%$request%' and username like '%$user%' and entrydate between '$startdate' and '$enddate' and selecttype ='Dr' and disbursstatus='pending' and docno like 'PCA-%' AND `ledgerid` NOT IN (SELECT `id` FROM `master_accountname` WHERE `accountsmain`= '4') ORDER BY `master_journalentries`.`docno` DESC ";
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);
			
			?>
           <table>
            <tr>
             
            <td width="94" height="25" bgcolor="#ecf0f5" class="bodytext31"><strong>S.No.</strong></td>
            <td width="52" bgcolor="#ecf0f5" class="bodytext31"><strong>Doc.No.</strong></td>
            <td width="127" bgcolor="#ecf0f5" class="bodytext31"><strong>Entry Date</strong></td>
            <td width="144" bgcolor="#ecf0f5" class="bodytext31"><strong>LedgerID</strong></td>
             <td width="20" bgcolor="#ecf0f5" class="bodytext31"><strong>Ledger Name</strong></td>
            <td width="128" bgcolor="#ecf0f5" class="bodytext31"><strong>Transaction Amount</strong></td>
            <td width="178" bgcolor="#ecf0f5" class="bodytext31"><strong>User Name</strong></td>
             <td width="127" bgcolor="#ecf0f5" class="bodytext31"><strong>Action</strong></td>
             
           
                 
               
            </tr>
             <tr>
                 <td height="" align="left" valign="top"  class="bodytext31">&nbsp;</td>
                </tr>
            <?php  
				$colorloopcount=0;
		while($result=mysqli_fetch_array($exe)){
			$sno=$sno+1;
			$docno=$result['docno'];
			$entrydate=$result['entrydate'];
			$ledgerid=$result['ledgerid'];
			$ledgername=$result['ledgername'];
			$transactionamount=$result['transactionamount'];
			$username=$result['username'];
			$doc=explode('-',$docno);
			//print_r($doc);
			 $con=$doc[0];
		 ?>
            <?php if($con=="PCA") 
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
             
           
           <td align="left" valign="top"  class="bodytext31"><?php echo $sno; ?> </td>
             <td align="left" valign="top"   class="bodytext31"><?php echo $docno; ?> </td>
              <td align="left" valign="top"   class="bodytext31"><?php echo $entrydate; ?> </td>
              
                <td align="left" valign="top"   class="bodytext31"><?php echo $ledgerid; ?> </td>
                 <td align="left" valign="top"   class="bodytext31"><?php echo $ledgername; ?> </td>
                 <td align="left" valign="top"   class="bodytext31"><?php echo $transactionamount; ?> </td>
                 
                   <td align="left" valign="top"   class="bodytext31"><?php echo ucwords($username); ?> </td>
                  <td align="left" valign="top"   class="bodytext31"><a href="pettycashreconcile.php?doc=<?php echo $docno; ?>&&ledgercode=<?php echo $ledgerid; ?>">POSTING</a> </td> 
                 
            <?php }}?>
            
            </tr>
            </table>
            </table>
            <?php }?>
          </td>
        </tr>
           <!-- <tr>
              <td>&nbsp;</td>
            </tr>-->
      </table></td>
  </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

