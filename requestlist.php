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


if (isset($_REQUEST["user"])) { $user = $_REQUEST["user"]; } else { $user = ""; }
if (isset($_REQUEST["request"])) { $request= $_REQUEST["request"]; } else { $request = ""; }



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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="80%" valign="top" >
    <table width="97%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="80%">
        <table width="860" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
              <form name="form1" id="form1" method="post" action="requestlist.php" onSubmit="return additem1process1()">
                  <table width="860" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Petty Cash Management-Request-List </strong></td>
                      </tr>
					
                       <tr  bgcolor="#FFFFFF">
              <td align="left" valign="middle"  class="bodytext31">Request Number</td>
              <td colspan="5" align="left" valign="top"  ><span class="bodytext3">
                <input name="request" type="text" id="request" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr  bgcolor="#FFFFFF">
               <td align="left" valign="middle"  class="bodytext31">User</td>
              <td colspan="5" align="left" valign="top"  ><span class="bodytext3">
                <input name="empname" type="text" id="empname" value="" size="50" autocomplete="off">
				<input name="empcode" type="hidden" id="empcode" value="" > 
			    <input name="selectedempname" type="hidden" id="selectedempname" value="" > 
              </span></td>
              </tr>
                      
                       <tr  bgcolor="#FFFFFF">
                      
                        
                        <td align="left" valign="middle"  class="bodytext31">Date From</td>
                       <td width="145" align="left" valign="center"  class="bodytext311"><input name="ADate1" id="ADate1" value="<?php echo date('Y-m-d'); ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
            <td width="60" align="left" valign="middle"  class="bodytext31">Date To</td>
                       <td width="229" align="left" valign="center"  class="bodytext311"><input name="ADate2" id="ADate2" value="<?php echo date('Y-m-d'); ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>			</td>
                      <td  align="left" valign="top" >&nbsp;</td>
                        <td  align="left" valign="top"  >&nbsp;</td>
                      </tr>
                      
					<tr  bgcolor="#FFFFFF">
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
                   
                    </tbody>
                  </table>
                  
                 
				  </form>
                   <table width="860" height="44" border="0" cellpadding="0" align="center" cellspacing="0" class="tablebackgroundcolor1">
                  <?php 
				  if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
			if (isset($_REQUEST["empname"])) { $user = $_REQUEST["empname"]; } else { $user = ""; }
if (isset($_REQUEST["request"])) { $request= $_REQUEST["request"]; } else { $request = ""; }

	$startdate=$_REQUEST['ADate1'];
	$enddate=$_REQUEST['ADate2'];
	$sno=0;
	 $querry=" select  * from pcrequest where doc_no like '%$request%' and username like '%$user%' and currentdate between '$startdate' and '$enddate' and delete_status <>'deleted' and 	approved_status=5  ORDER BY `pcrequest`.`doc_no` ASC ";
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);
	
	
	
	
?>		
<tbody>
        <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Petty first Approval List </strong></td>
         </tr>
          <tr>
            <td  align="left" colspan="6" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
		<tr>
        <td width="20%" height="21" bgcolor="#ecf0f5" class="bodytext31"><strong>S.No.</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Date</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Request No</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Amount</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Request by</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Action</strong></td>
        </tr>
        <?php  
		$colorloopcount=0;
		while($result=mysqli_fetch_array($exe)){
			$sno=$sno+1;
			$date=$result['currentdate'];
			$amount=$result['approved_amt'];
			$remarks=$result['remarks'];
			$username=$result['username'];
			$doc_no=$result['doc_no'];
			
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
          
                       
          <td align="left" valign="top" class="bodytext31"><?php echo $sno; ?> </td>
          <td align="left" valign="top"   class="bodytext31"><?php echo date('d/m/Y',strtotime($date)) ; ?> </td>
          <td align="left" valign="top"  class="bodytext31"><?php echo $doc_no; ?> </td>
          <td align="left" valign="top"  class="bodytext31"><?php echo number_format($amount,2,'.',','); ?> </td>
          <td align="left" valign="top"   class="bodytext31"><?php echo ucwords($username); ?> </td>
          <td align="left" valign="top"  class="bodytext31"><a href="viewpcrequest.php?docno=<?php echo $doc_no; ?>">View</a> </td>
       
        </tr>      
				 
                
             <?php } ?>
             <tr>
            <td  align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
             
             <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Petty Reject List </strong></td>
            </tr>
            <tr>
            <td  align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
            <tr>
        <td width="20%" height="21" bgcolor="#ecf0f5" class="bodytext31"><strong>S.No.</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Date</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Doc No</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Amount</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Rejected by</strong></td>
        <td width="20%" bgcolor="#ecf0f5" class="bodytext31"><strong>Action</strong></td>
        </tr>
        <?php $querry2=" select  * from pcrequest where doc_no like '%$request%' and username like '%$user%' and  currentdate between '$startdate' and '$enddate' and delete_status <>'deleted' and 	approved_status=2 ";
	$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $querry2); 
	$sno=0;
	while($reject=mysqli_fetch_array($exe2))
	{
		$sno=$sno+1;
		$redate=$reject['currentdate'];
		$reamount=$reject['approved_amt'];
		$reremarks=$reject['remarks'];
		$reusername=$reject['first_rejected_user'];
		$redoc_no=$reject['doc_no'];
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
          
                       
          <td align="left" valign="top" class="bodytext31"><?php echo $sno; ?> </td>
          <td align="left" valign="top" class="bodytext31"><?php echo $redate; ?> </td>
          <td align="left" valign="top" class="bodytext31"><?php echo $redoc_no; ?> </td>
          <td align="left" valign="top" class="bodytext31"><?php echo $reamount; ?> </td>
          <td align="left" valign="top" class="bodytext31"><?php echo $reusername; ?> </td>
          <td align="left" valign="top" class="bodytext31"><a href="viewpcrequest.php?docno=<?php echo $redoc_no; ?>">View</a> </td>
       
        </tr>   
            
             <?php }} ?> 
             </tbody>
             </table>
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

