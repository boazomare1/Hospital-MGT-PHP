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
if (isset($_REQUEST["docno"])) {  $docno = $_REQUEST["docno"]; } else { $docno = ""; }
  $querry=" select  * from pcrequest where doc_no='$docno'  and delete_status <>'deleted' and (approved_status<>1 and approved_status<>2 and approved_status<>3 and approved_status<>4 or approved_status=4  ) order by doc_no desc";
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);
$result=mysqli_fetch_array($exe);
$sno=1;
$doc_no=$result['doc_no'];
$currentdate=$result['currentdate'];
$amount=$result['approved_amt'];
$remarks=$result['remarks'];
$username=$result['username'];
//$doc_no=$result['doc_no'];

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
	
	
	var ramount=$('#ramount').val();
	ramount=ramount.replace(',', '',ramount);
	//alert(ramount);
	var aamount=$('#aamount').val();
	aamount=aamount.replace(',', '',aamount);
	//alert(ramount);
	var doc=$('#doc').val();
    var	currentd=$('#currentd').val();//user
    var	user=$('#user').val();
	 var selValue = $('input[name=action]:checked').val(); 
	
	var data = 'ramount='+ramount+'&&doc='+doc+'&&selValue='+selValue+'&&currentd='+currentd+'&&aamount='+aamount+'&&user='+user;
	$.ajax({
		type : "POST",
		url : "pettyupdate.php",
		data : data,
		cache:false,
		success: function(data){
			//alert(data); 
			 window.open("appprovedlist.php","_self");
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
        <td width="80%" height="84">
        <table width="901" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
                         <td width="0%" height="37" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext31">&nbsp;</td>

            <td width="5%" height="31" bgcolor="#ecf0f5" class="bodytext31"><strong>S.No.</strong></td>
            <td width="6%" bgcolor="#ecf0f5" class="bodytext31"><strong>Doc.No.</strong></td>
            <td width="6%" bgcolor="#ecf0f5" class="bodytext31"><strong>Date</strong></td>
            <td width="12%" bgcolor="#ecf0f5" class="bodytext31"><strong>Requested Amount</strong></td>
             <td width="16%" bgcolor="#ecf0f5" class="bodytext31"><strong>Approve Amount</strong></td>
            <td width="17%" bgcolor="#ecf0f5" class="bodytext31"><strong>Remarks</strong></td>
            <td width="11%" bgcolor="#ecf0f5" class="bodytext31"><strong>Requested By</strong></td>
            <td width="21%" bgcolor="#ecf0f5" class="bodytext31"><strong>Approve/Discard</strong></td>
             <td width="6%" bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
            <td width="0%" height="37" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext31">&nbsp;</td>
                 
               
            </tr>
            <tr>				    <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>

            <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
			 <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
			  <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
			   <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td> <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
			    <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
				 <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
				  <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
				   <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
				    <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
            </tr>
            
            <tr>
            <?php if($doc_no) {?>
							    <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>

           <td height="37" align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext31"><?php echo $sno; ?> </td>
             <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext31"><input type="hidden" name="doc" id="doc"value="<?php echo $doc_no; ?>"><?php echo $doc_no; ?> </td>
              <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext31"><input type="hidden" name="currentd" id="currentd" value="<?php echo $currentdate; ?> "><?php echo date('d/m/Y',strtotime($currentdate)); ?></td>
               <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext31"><input type="hidden" name="ramount" id="ramount" value="<?php echo number_format($amount); ?>"> <?php echo $amount; ?></td>
                <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext31"><input type="type" name="aamount" id="aamount" value="<?php echo number_format($amount); ?>" style="text-align:right"> </td>
                <td align="center" valign="top" bgcolor="#FFFFFF"  class="bodytext31"><?php echo $remarks; ?> </td>
                 <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext31"><input type="hidden" name="user" id="user"value="<?php echo ucwords($username); ?>"><?php echo $username; ?> </td>
                  <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext31"><input type="radio"  
                 id="action" name="action" value="3" checked >Approve
                 <input type="radio"  
                 id="action" name="action" value="4" >Discard
                  </td>
                 <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext31">
                  <input type="button" name="save" id="save" value="Yes" onClick="return adddata()">
                  </td>
				   <td height="37"  bgcolor="#FFFFFF" align="left" valign="top"  class="bodytext31">&nbsp;</td>
            <?php  }?>
            
            </tr>
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

