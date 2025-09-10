<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];

$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$sno = '';

//to redirect if there is no entry in masters category or item.
$query90 = "select count(auto_number) as masterscount from master_lab";
$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
$res90 = mysqli_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1lab.php?svccount=firstentry");
}


if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$code = $_REQUEST['itemcode'];
	$itemname = $_REQUEST['itemname'];
    
	$notes = $_REQUEST['notes'];
	$categoryname = $_REQUEST['categoryname'];

	$locationcode = $_REQUEST['locationcode'];
	$querynw21 = "select * from master_location where locationcode = '$locationcode'";//
	$execnw21 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numnw21 = mysqli_num_rows($execnw21);
	$resnw21 = mysqli_fetch_array($execnw21);
	$locationname = $resnw21['locationname'];

    $query90 = "select itemcode from `master_labinterpretation` where itemcode='$code'";
	$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numnw22 = mysqli_num_rows($exec90);
	if ($numnw22>0)
	{

        $query_int = "update `master_labinterpretation`set `interpret_desc`='$notes',`updatetime`='$updatedatetime',`ipaddress`='$ipaddress',username='$username' where `itemcode`='$code'";
		$exec_int = mysqli_query($GLOBALS["___mysqli_ston"], $query_int) or die ("Error in Query_int".mysqli_error($GLOBALS["___mysqli_ston"]));
	}else{

		$query_int = "INSERT INTO `master_labinterpretation`(`itemcode`, `itemname`, `displayname`, `categoryname`, `referencename`, `interpret_desc`, 
		`interpret_range`, `status`, `ipaddress`, `updatetime`, `location`, `locationname`,`username`) VALUES ('$code', '$itemname', '$itemname','$categoryname','','$notes','','','$ipaddress', '$updatedatetime','$locationcode','$locationname','$username')";
		$exec_int = mysqli_query($GLOBALS["___mysqli_ston"], $query_int) or die ("Error in Query_int".mysqli_error($GLOBALS["___mysqli_ston"]));

	}

	$errmsg = "Success. New Lab Item Updated.";
	$bgcolorcode = 'success';
	$itemcode = '';
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description = '';
	$referencevalue = '';
	//header("location:labitem1interpret.php");
	

}
else
{
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	}
	
	//$itemcode = '';
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
		
	$query67 = "select * from master_lab where itemcode='$itemcode'";
	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res67 = mysqli_fetch_array($exec67);
	$itemname = $res67['itemname'];
	$rate1 = $res67['rateperunit'];
	$rate2 = $res67['rate2'];
	$rate3 = $res67['rate3'];
	$ipmarkup = $res67['ipmarkup'];
	$location = $res67['location'];
	$sampletype = $res67['sampletype'];
    $unit = $res67['itemname_abbreviation'];
	$category= $res67['categoryname'];
	$taxanum = $res67['taxanum'];
	$referencevalue = $res67['referencevalue'];
	$taxname= $res67['taxname'];
	$displayname = $res67['displayname'];
	$externallab = $res67['externallab'];
	$exclude = $res67['exclude'];
	$pkg1 = $res67['pkg'];
	$radiology = $res67['radiology'];
	$description = $res67['description'];

	$query68 = "select interpret_desc from master_labinterpretation where itemcode='$itemcode'";
	$exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res68 = mysqli_fetch_array($exec68);
    $interpret_desc = $res68['interpret_desc'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add lab Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }
?>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="ckeditor_4.4.3/ckeditor/ckeditor.js"></script>

<script language="javascript">

function additem1process1()
{
	
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

function AddDisplayname()
{
	var Name = document.getElementById("itemname").value;
	
	document.getElementById("displayname").value = Name;
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

function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
	
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById('insertrow').removeChild(child);
		
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);	
	}
}

$(document).ready(function(){
	$('#iadd').click(function(){
		var callfm = $('#callfm').val();
		var idesc = $('#idesc').val();
		var irange = $('#irange').val();
		if(idesc==''){alert('Enter Desc'); return false; }
		if(irange==''){alert('Enter Range'); return false; }
		var icount = $('#icount').val();
		var itable = '<tr id="'+callfm+'ITR'+icount+'">';
		itable = itable+'<td><input type="text" name="'+callfm+'idesc'+icount+'" id="'+callfm+'idesc'+icount+'" value="'+idesc+'"></td>';
		itable = itable+'<td><textarea name="'+callfm+'irange'+icount+'" id="'+callfm+'irange'+icount+'">'+irange+'</textarea></td>';
		itable = itable+'<td><input type="button" name="'+callfm+'idel'+icount+'" id="'+callfm+'idel'+icount+'" value="Del" onclick="return iDel(this.id)"></td>';
		itable = itable+'</tr>';
		$('#interpret').append(itable);
		var idesc = $('#idesc').val('');
		var irange = $('#irange').val('');
		$('#icount').val(parseFloat($('#icount').val())+parseFloat(1));
		$('#idesc').focus();
	})
	
	$('#iupdate').click(function(){
		var callfm = $('#callfm').val();
		var icount = $('#icount').val();
		$('#add_interpret'+callfm).empty();
		var intetable = '';
		for(var i=1;i<=icount;i++){
			if($('#'+callfm+'idesc'+i)!=null && $('#'+callfm+'idesc'+i).val() != undefined)
			{
				var idesc = $('#'+callfm+'idesc'+i).val();
				var irange = $('#'+callfm+'irange'+i).val();
				var intetable = intetable+'<tr id="'+callfm+'ITR'+i+'">';
				intetable = intetable+'<td><input type="hidden" name="'+callfm+'idesc'+i+'" id="'+callfm+'idesc'+i+'" value="'+idesc+'"></td>';
				intetable = intetable+'<td><input type="hidden" name="'+callfm+'irange'+i+'" id="'+callfm+'irange'+i+'" value="'+irange+'"></td>';
				intetable = intetable+'</tr>';
			}
		}
		$('#add_interpret'+callfm).append(intetable);
		$('#interpret').empty();
		$('#iclose').trigger('click');
	})
});

function iDel(id){
	var idsplit = id.split('idel');
	var Ask = confirm("Are you Sure to Delete ?");
	if(Ask == false)
	{
		return false;
	}   
	
	if($('#'+idsplit[0]+'idesc'+idsplit[1]).val() != undefined)
	{
		$('#'+idsplit[0]+'ITR'+idsplit[1]).remove();  
	}
}

function CallFrom(idf){
	if(idf=='add'){
		var id = $('#serialnumber').val();
	}else{
		var id = idf;
	}
	
	$('#callfm').val(id);
	var callfm = $('#callfm').val();
	var icount = $('#icount').val();
	var intetable = '';
	$('#interpret').empty();
	for(var i=1;i<=icount;i++){
		if($('#'+callfm+'idesc'+i)!=null && $('#'+callfm+'idesc'+i).val() != undefined)
		{
			var idesc = $('#'+callfm+'idesc'+i).val();
			var irange = $('#'+callfm+'irange'+i).val();
			var intetable = intetable+'<tr id="'+callfm+'ITR'+i+'">';
			intetable = intetable+'<td><input type="text" name="'+callfm+'idesc'+i+'" id="'+callfm+'idesc'+i+'" value="'+idesc+'"></td>';
			intetable = intetable+'<td><textarea name="'+callfm+'irange'+i+'" id="'+callfm+'irange'+i+'">'+irange+'</textarea></td>';
			intetable = intetable+'<td><input type="button" name="'+callfm+'idel'+i+'" id="'+callfm+'idel'+i+'" value="Del" onclick="return iDel(this.id)"></td>';
			intetable = intetable+'</tr>';
		}
	}
	$('#interpret').append(intetable);	
}

function validcheck()

{

if(confirm("Do You Want To Save The Record?")==false){
	return false;
}	
return true;

}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 ,.bodytext12,.bodytext11{	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<style type="text/css">
<!--
.bodytext13,.bodytext21 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.pagination{float:right;}
-->
</style>
<?php /*?><?php include ("includes/header.php"); ?><?php */?>
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
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:22px 41px">
        <tr>
          <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
              <form name="form1" id="form1" method="post" action="edititem1interpret.php?itemcode=<?php echo $itemcode; ?>" >
                <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr >
                      <td colspan="4"  bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Item Master - Edit </strong></td>
                    </tr>
                    <?php if ($st==1)
					  {?>
                    <tr>
                      <td colspan="4" align="left" valign="middle" class="bodytext13" bgcolor="#AAFF00"><font size="2">Sorry Special Characters Are Not Allowed</font></td>
                    </tr>
                    <?php }?>
                    <tr>
                      <td colspan="4" align="left" valign="middle" class="bodytext13"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }else if ($bgcolorcode == 'fail') { echo '#AAFF00'; } ?>"><div align="left"><?php echo $errmsg; ?>&nbsp;</div></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Select Category Name </div></td>
                      <td align="left" valign="top" class="bodytext13">
                      <input id="categoryname" name="categoryname" value="<?php echo $category; ?>" readonly >
                       </td>
                      <td align="left" valign="top"   class="bodytext13">&nbsp;</td>
                      <td align="left" valign="top" class="bodytext13">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">New Lab Item Code </div></td>
                      <td align="left" valign="top"  ><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" size="20" maxlength="100" />
                        <span class="bodytext13">( Example : PRD1234567890 ) </span></td>
                      <td align="left" valign="top"   class="bodytext13">&nbsp;</td>
                      <td align="left" valign="top" class="bodytext13">&nbsp;</td>
                     </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Add New Lab Item Name </div></td>
                      <td align="left" valign="top"><input name="itemname" type="text" id="itemname" onChange="return spl()" readonly onKeyUp="return AddDisplayname()" value="<?php echo $itemname; ?>" size="45"></td>
                      <td align="left" valign="top"   class="bodytext13">&nbsp;</td>
                      <td align="left" valign="top" class="bodytext13">&nbsp;</td>
                    </tr>
                    
                    <tr>
                      <td align="left" class="bodytext12">&nbsp;</td>
                      <td colspan="3" align="left" class="bodytext12">&nbsp;</td>
                    </tr>
                  <input type="hidden" name="rate2" id="rate2" value="<?php echo $rate2; ?>" size="20" />
                  <input type="hidden" name="rate3" id="rate3" value="<?php echo $rate3; ?>" size="20" />
                  <input type="hidden" name="purchaseprice" id="purchaseprice" value="<?php echo $purchaseprice; ?>" size="20" />
                  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $location; ?>">
                  <tr>
                    <td width="20%" align="left" valign="middle"   class="bodytext12"><strong>Add Interpretation</strong></td>
                  </tr>
                   <tr>
                    <td colspan='3' align="left" valign="top"   class="bodytext13">
				    <textarea name="notes" id="editor1" ><?php echo $interpret_desc;?> </textarea>
					<script>
								CKEDITOR.replace( 'editor1',
								null,
								''
								);
					</script>	 
				    </td>
                  </tr>

                  
                  
                  <tr>
                    <td width="20%" align="left" valign="top"   class="bodytext13">&nbsp;</td>
                    <td width="47%" align="left" valign="top" class="bodytext13">&nbsp;</td>
                    <td width="11%" align="left" valign="top" class="bodytext13">&nbsp;</td>
                    <td width="22%" align="left" valign="top" class="bodytext13" ><input type="hidden" name="frmflag" value="addnew" />
                      <input type="hidden" name="frmflag1" value="frmflag1" />
                      <input type="submit" name="Submit" value="Save Lab Item" onclick='return validcheck();'/></td>
                  </tr>
                </form></table>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

