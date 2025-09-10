<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$rateperunit = "0";
$purchaseprice = "0";
$checkboxnumber = '';

if (isset($_POST["searchflag1"])) { $searchflag1 = $_POST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_POST["search1"])) { $search1 = $_POST["search1"]; } else { $search1 = ""; }
if (isset($_POST["search2"])) { $search2 = $_POST["search2"]; } else { $search2 = ""; }
if (isset($_POST["search3"])) { $search3 = $_POST["search3"]; } else { $search3 = ""; }
if (isset($_POST["location"])) { $location = $_POST["location"]; } else { $location = ""; }
if (isset($_POST["store"])) { $store = $_POST["store"]; } else { $store = ""; }

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
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
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearchsupplier.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function funcSelectStore()
{
}

function form1valid()
{
	if(document.getElementById("location").value == "")
	{
		alert('Select Location');
		document.getElementById("location").focus();
		return false;
	}
	if(document.getElementById("store").value == "")
	{
		alert('Select Store');
		document.getElementById("store").focus();
		return false;
	}
}

function form2Valid()
{
	if(document.getElementById("locationcode").value == "")
	{
		alert('Select Location');
		document.getElementById("locationcode").focus();
		return false;
	}
	/*if(document.getElementById("paynowcashcoa").value == "")
	{
		alert('Select Supplier');
		document.getElementById("paynowcashcoa").focus();
		return false;
	}*/
}
</script>

<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<script type="text/javascript">
$(document).ready(function(e) {
	$('#search2').autocomplete({
		
	source:'searchsuppliernew.php',
	minLength:1,
	delay: 0,
	html: true, 
	select: function(event,ui){
				var suppliercode=ui.item.suppliercode;
				$('#search3').val(suppliercode);
			}
    });
});


function clearcode(){
	document.getElementById('search3').value='';
}

function storefunction(loc)
{
	var username=document.getElementById("username").value;
	
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("store").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
xmlhttp.send();

}

function selectAllChk(flg, evt)
{
	var chk = $('.'+flg);
	if (evt.checked) {
      $(chk).prop('checked',true);
	} else {
	  $(chk).prop('checked', false);
	} 
}
</script>
<body >
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="1050" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
                <table width="1200" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Item Master - Existing List - Latest 100 Items </strong></span></td>
                      </tr>
						<?php
						if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
						//echo $st;
						if ($st == 'success') 
						{
						//echo "Item Mapping To Supplier Completed.";
						?>
                      <tr bgcolor="#011E6A">
                        <td colspan="15" bgcolor="#CCFF00" class="bodytext3">
						Item Mapping To Supplier Completed.&nbsp;</td>
                      </tr>
						<?php
						}
						?>
						<form name="form1" id="form1" action="additemtosupplier1.php" method="post" onSubmit="return form1valid();">
                      <tr bgcolor="#011E6A">
                        <td bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong> </td>
						<td colspan="2" bgcolor="#FFFFFF" class="bodytext3"><select name="location" id="location" onChange="storefunction(this.value)">
					  <option value="">Select Location</option>
					  <?php
					  $query7 = "select * from master_location where status <> 'deleted'";
					  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
					  while($res7 = mysqli_fetch_array($exec7))
					  {
					  $res7locationcode = $res7['locationcode'];
					  $res7locationname = $res7['locationname'];
					  ?>
					  <option value="<?php echo $res7locationcode; ?>" <?php if($location == $res7locationcode) { echo "selected"; } ?>><?php echo $res7locationname; ?></option>
					  <?php
					  }
					  ?>
					  </select></td>
					   <td colspan="12" bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong>&nbsp;&nbsp;
					  </td>
                      </tr>
					  <tr bgcolor="#011E6A">
                        <td bgcolor="#FFFFFF" class="bodytext3"><strong>Store</strong> </td>
						<td colspan="2" bgcolor="#FFFFFF" class="bodytext3">
						<select name="store" id="store">
						<option value="">Select Store</option>
						<?php if ($searchflag1 == 'searchflag1')
						{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
						$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
						$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res5 = mysqli_fetch_array($exec5))
						{
						$res5anum = $res5["storecode"];
						$res5name = $res5["store"];
						//$res5department = $res5["department"];
						?>
						<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>
						<?php }}?>
						</select>
						</td>
					   <td colspan="12" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      </tr>
					   <tr bgcolor="#011E6A">
                        <td colspan="15" bgcolor="#FFFFFF" class="bodytext3">
						Product :	<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						Supplier : <input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>" onKeyUp="clearcode()">
                        <input name="search3" type="hidden" id="search3" size="40" value="<?php echo $search3; ?>">
						<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />
						 </td>
                      </tr>
					   </form>	
                      <tr>
                      	<td bgcolor="#ccc" class="bodytext3" colspan="13">
                        <strong>Mapped Items</strong>
                        </td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Select</strong><input type="checkbox" id="mappedall" onClick="return selectAllChk('mapped', this);"></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="14%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
                        <td width="24%" bgcolor="#ecf0f5" class="bodytext3"><strong>Item</strong></td>
                        <td width="24%" bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax%</strong></td>
                        <td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Purchase</strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Selling</strong></div></td>
						<td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Min</strong></td>
						<td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Max</strong></td>
						<td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>ROL</strong></td>
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                      </tr>
                      
 		 <form name="form2" id="form2" action="additemtosupplier2.php" method="post" onSubmit="return form2Valid();">
                     <?php
	  if ($searchflag1 == 'searchflag1')
	  {
		$items_build = "''";	  
		$search1 = $_REQUEST["search1"];
		if($search3!=''){			  
	    	$query1 = "select a.* from master_medicine as a JOIN  master_itemtosupplier as b ON b.itemcode=a.itemcode where b.suppliercode='$search3' and a.itemname like '%$search1%' and a.status <> 'deleted' and b.locationcode = '$location' and b.storecode = '$store' order by a.itemname";// desc LIMIT 100";
		}
		else{
	    	//$query1 = "select a.* from master_medicine as a  where a.itemname like '%$search1%' and a.status <> 'deleted' order by auto_number";// desc LIMIT 100";
			$query1 = "select a.* from master_medicine as a JOIN  master_itemtosupplier as b ON b.itemcode=a.itemcode where a.itemname like '%$search1%' and a.status <> 'deleted' and b.locationcode = '$location' and b.storecode = '$store' order by a.itemname";
		}		
		//echo $query1;
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$unitname_abbreviation = $res1["unitname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		
		if($items_build == "''")
		{
			$items_build = "'".$itemcode."'";
		}
		else 
		{
			$items_build = $items_build.",'".$itemcode."'";	
		}
		
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		
		$query7 = "select * from master_itemtosupplier where itemcode = '$itemcode' and locationcode = '$location' and storecode = '$store' and recordstatus <> 'deleted'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$res7suppliername = $res7['suppliername'];
		$res7minimum = $res7['minimum'];
		$res7maximum = $res7['maximum'];
		$res7rol = $res7['rol'];
		  
		$checkboxnumber = $checkboxnumber + 1;
		?>
        <tr <?php echo $colorcode; ?>>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center">
						<?php echo $checkboxnumber; ?>
                          <input type="checkbox" class="mapped" value="<?php echo $itemcode; ?>" name="checkbox<?php echo $checkboxnumber; ?>" id="checkbox<?php echo $checkboxnumber; ?>">
						</div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res7suppliername; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $unitname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $purchaseprice; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3"><input type="text" name="min<?php echo $checkboxnumber; ?>" id="min<?php echo $checkboxnumber; ?>" value="<?php if($res7minimum != '0.00') { echo $res7minimum;} ?>" size="5"></td>
						<td align="left" valign="top"  class="bodytext3"><input type="text" name="max<?php echo $checkboxnumber; ?>" id="max<?php echo $checkboxnumber; ?>" value="<?php if($res7maximum != '0.00') {echo $res7maximum; } ?>" size="5"></td>
						<td align="left" valign="top"  class="bodytext3"><input type="text" name="rol<?php echo $checkboxnumber; ?>" id="rol<?php echo $checkboxnumber; ?>" value="<?php if($res7rol != '0.00') {echo $res7rol;} ?>" size="5"></td>
						<td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		}
		?>
          <tr>
            <td bgcolor="#fff" class="bodytext3" colspan="13">
            <strong>&nbsp;</strong>
            </td>
          </tr>
          <tr>
            <td bgcolor="#ccc" class="bodytext3" colspan="13">
            <strong>Unmapped Items</strong>
            </td>
          </tr>
            <tr bgcolor="#011E6A">
            <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Select</strong><input type="checkbox" id="unmappedall" onClick="return selectAllChk('unmapped', this);"></div></td>
            <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
            <td width="14%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
            <td width="24%" bgcolor="#ecf0f5" class="bodytext3"><strong>Item</strong></td>
            <td width="24%" bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
            <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>
            <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax%</strong></td>
            <td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Purchase</strong></div></td>
            <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Selling</strong></div></td>
            <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Min</strong></td>
            <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Max</strong></td>
            <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>ROL</strong></td>
            <td width="4%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
          </tr>
          
        <?php
		$query23 = "select a.* from master_medicine as a  where a.itemname like '%$search1%' and a.status <> 'deleted' and itemcode NOT IN ($items_build) order by itemname";  //desc LIMIT 10";
		$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res23 = mysqli_fetch_array($exec23))
		{
		$itemcode = $res23["itemcode"];
		$itemname = $res23["itemname"];
		$categoryname = $res23["categoryname"];
		$purchaseprice = $res23["purchaseprice"];
		$rateperunit = $res23["rateperunit"];
		$expiryperiod = $res23["expiryperiod"];
		$auto_number = $res23["auto_number"];
		$unitname_abbreviation = $res23["unitname_abbreviation"];
		$taxname = $res23["taxname"];
		$taxanum = $res23["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		
		$query8 = "select * from master_itemtosupplier where itemcode = '$itemcode' and locationcode = '$location' and storecode = '$store' and recordstatus <> 'deleted'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$res8suppliername = $res8['suppliername'];
		$res8minimum = $res8['minimum'];
		$res8maximum = $res8['maximum'];
		$res8rol = $res8['rol'];
		  
		$checkboxnumber = $checkboxnumber + 1;
		?>
        <tr <?php echo $colorcode; ?>>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center">
						<?php echo $checkboxnumber; ?>
                          <input type="checkbox" class="unmapped" value="<?php echo $itemcode; ?>" name="checkbox<?php echo $checkboxnumber; ?>" id="checkbox<?php echo $checkboxnumber; ?>">
						</div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res8suppliername; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $unitname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $purchaseprice; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3"><input type="text" name="min<?php echo $checkboxnumber; ?>" id="min<?php echo $checkboxnumber; ?>" value="<?php if($res8minimum != '0.00') { echo $res8minimum;} ?>" size="5"></td>
						<td align="left" valign="top"  class="bodytext3"><input type="text" name="max<?php echo $checkboxnumber; ?>" id="max<?php echo $checkboxnumber; ?>" value="<?php if($res8maximum != '0.00') {echo $res8maximum; } ?>" size="5"></td>
						<td align="left" valign="top"  class="bodytext3"><input type="text" name="rol<?php echo $checkboxnumber; ?>" id="rol<?php echo $checkboxnumber; ?>" value="<?php if($res8rol != '0.00') {echo $res8rol;} ?>" size="5"></td>
						<td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		}
	}
		?>
        <tr>
          <td colspan="15" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
		  <input type="text" name="suppliercoa" id="paynowcashcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('6')" value="Map" accesskey="m" style="border: 1px solid #001E6A">
						 <input type="hidden" name="paynowlabtype6" id="paynowcashtype" size="10"/>
						 <input type="hidden" name="suppliercode" id="paynowcashcode" size="10"/>
		  <span class="bodytext32">
		  <input name="frmflag1" id="frmflag1" value="frmflag1" type="hidden">
		  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $location; ?>">
		  <input type="hidden" name="storecode" id="storecode" value="<?php echo $store; ?>">
		  <input name="checkboxcount" id="checkboxcount" value="<?php echo $checkboxnumber; ?>" type="hidden">
		  <input type="submit" name="Submit22" value="Submit" style="border: 1px solid #001E6A" />
		  </span>		  </td>
          </tr>
		  </form>		   
                    </tbody>
                  </table>
				  
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
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

