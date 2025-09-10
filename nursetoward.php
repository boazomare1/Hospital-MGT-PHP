<?php

session_start();

$pagename = '';

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION['username'])) header ("location:index.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$sessionusername = $_SESSION['username'];

$errmsg = '';

$bgcolorcode = '';

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }

if (isset($_REQUEST["searchemployeecode"])) {  $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if (isset($_REQUEST["frmflag11"])) { $frmflag11 = $_REQUEST["frmflag11"]; } else { $frmflag11 = ""; }



//$frmflag1 = $_REQUEST['frmflag1'];



$docno = $_SESSION['docno'];

$query = "select * from master_location where  status <> 'deleted' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

	 $employeeid=isset($_REQUEST['eid'])?$_REQUEST['eid']:'';

	 $query1 = "select username from master_employee where  status = 'Active' AND employeecode = '".$employeeid."'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

	

	  $employeename  = $res1["username"];

//get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		 $locationcode=$location;

		}

		//location get end here

		$loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$employeeidget=isset($_REQUEST['employeeidget'])?$_REQUEST['employeeidget']:'';

	$employeenameget=isset($_REQUEST['employeenameget'])?$_REQUEST['employeenameget']:'';

	$employeeid=$employeeidget;

	$employeename=$employeenameget;

	

	

	

	$query5 = "select * from master_employee WHERE employeecode = '".$employeeid."'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res5 = mysqli_fetch_array($exec5);

	$empusername = $res5['username'];

	

	$emplocation = $_REQUEST['emplocation'];

 	$query51 = "select * from master_location WHERE locationcode = '".$emplocation."'";

	$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res51 = mysqli_fetch_array($exec51);

 	$loccode = $res51['locationcode'];

	$locname = $res51['locationname'];

	

	$storearray = $_REQUEST['store'];

	$storecode = $_REQUEST['storecode'];
	
    $query4 = "DELETE FROM nurse_ward WHERE employeecode = '".$employeeid."' and locationcode='$loccode'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	foreach ($storearray as $store)

	{	

		if($store == $storecode) { $default = 'default'; }

		else { $default = ''; }

	 	$query23 = "INSERT INTO `nurse_ward`(`employeecode`, `username`, `locationanum`, `locationname`, `locationcode`, `wardcode`, `lastupdate`, `lastupdateipaddress`, `lastupdateusername`, `defaultward`) 

		VALUES ('$employeeid','$empusername','$emplocation','$locname','$loccode','$store','$updatedatetime','$ipaddress','$sessionusername','$default')";

		$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

	}

	header("Location:nursetoward.php");

}



$query34 = "select * from nurse_ward where employeecode = '$searchemployeecode' group by locationanum";

$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));

$res34 = mysqli_fetch_array($exec34);

$locationanum = $res34['locationcode'];

$locationname = $res34['locationname'];

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

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<!--<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>

<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());

	var oTextbox = new AutoSuggestControl(document.getElementById("empid"), new StateSuggestions());

  

}

</script>-->

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

  <script> 

$(function() {

	

$('#searchsuppliername').autocomplete({

		

	source:'ajaxemployeenewsearch.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var code = ui.item.id;

			var employeecode = ui.item.employeecode;

			var employeename = ui.item.employeename;

			$('#searchemployeecode').val(employeecode);

			$('#searchsuppliername').val(employeename);

			

			},

    });

});

</script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script language="javascript">



function process1backkeypress1() 

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}







</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function from1submit1()

{



	if (document.form1.employeename.value == "")

	{

		alert ("Employee Name Cannot Be Empty.");

		document.form1.employeename.focus();

		return false;

	}

	if (document.form1.username.value == "")

	{

		alert ("User Name Cannot Be Empty.");

		document.form1.username.focus();

		return false;

	}

	if (document.form1.username.value != "")

	{	

		var data = document.form1.username.value;

		//alert(data);

		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*

		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 

		for (var i = 0; i < data.length; i++) 

		{

			if (iChars.indexOf(data.charAt(i)) != -1) 

			{

				//alert ("Your Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");

				alert ("Your User Name Has Blank White Spaces Or Special Characters. These Are Not Allowed.");

				return false;

			}

		}

	}

	if (document.form1.password.value == "")

	{

		alert ("Password Cannot Be Empty.");

		document.form1.password.focus();

		return false;

	}

}



function funcEmployeeSelect1(frm)

{

	if (document.selectemployee.searchemployeecode.value == "")

	{

		alert ("Please Select Employee Code To Edit.");

		document.selectemployee.selectemployeecode.focus();

		return false;

	}

	var eid=document.selectemployee.searchemployeecode.value;

	selectemployee.method="post";

	selectemployee.action="nursetoward.php?eid="+eid;

	selectemployee.submit();

}





function funclocationChange1()

{



	

	<?php 

	$query12 = "select * from master_location where status = ''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12locationanum = $res12["auto_number"];

	$res12location = $res12["locationname"];

	?>

	if(document.getElementById("location").value=="<?php echo $res12locationanum; ?>")

	{

		document.getElementById("store").options.length=null; 

		var combo = document.getElementById('store'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 

		<?php

		$query10 = "select * from master_store where location = '$res12locationanum' and recordstatus = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10storeanum = $res10["auto_number"];

		$res10store = $res10["store"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10storeanum;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>	

}



function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.department.value == "")

	{

		alert ("Pleae Enter Department Name.");

		document.form1.department.focus();

		return false;

	}

}





    
  function approvecheck(){
	  
	 
	  
	  var combo = document.getElementById('totalcount').value;
	  
	

	if(document.getElementById('approve').checked==true)

{

	for (i=1;i<=combo;i++){	

	if(document.getElementById('store'+i))

	{

		if(document.getElementById('store'+i).checked==false)

		{

   		 	document.getElementById('store'+i).checked = true; 
 

}

	}
	
	}
	
}

  }



function FuncBranch(values)

{		

	<?php
$sno='0';
	$query4 = "select * from master_location where status <> 'deleted'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res4 = mysqli_fetch_array($exec4))

	{
   
	$anum = $res4['locationcode'];

	?>

		if(values == "<?php echo $anum; ?>")

		{

		//document.getElementById("branch").options.length=null; 

		for(var j = document.getElementById("foo").rows.length; j > 0;j--)

		 {

		  document.getElementById("foo").deleteRow(j -1);

		 } 

		<?php 

		$loopcount=0;

		?>

		//combo.options[<?php echo $loopcount;?>] = new Option ("Select Branch", ""); 

		<?php

		 $query10 = "select * from master_ward where locationcode = '$anum' and recordstatus <> 'deleted' order by ward";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{
		 $sno=$sno+1;
		$loopcount = $loopcount+1;

		$storeanum = $res10["auto_number"];

		$store = $res10["ward"];

		$storecode = $res10["auto_number"];

		?>

		var z = "<?php echo $loopcount; ?>";

		var tr = document.createElement ('TR');

		//alert(tr);

		tr.id = "idTR"+z+"";

		//alert(tr.id);

		var td2 = document.createElement ('td');

		td2.id = "tr"+z+"";

		

		td2.valign = "top";

		td2.style.backgroundColor = "#FFFFFF";

		td2.style.border = "0px solid #001E6A";

		tr.appendChild (td2);

		

		var td1 = document.createElement ('td');

		td1.id = "tr"+z+"";

		td1.colSpan = "2";

		td1.valign = "top";

		td1.style.backgroundColor = "#FFFFFF";

		td1.style.border = "0px solid #001E6A";

		

		var text1 = document.createElement ('input');

		text1.id = "store"+z+"";

		text1.name = "store[]";

		//alert(text11.name);

		text1.type = "checkbox";

		text1.align = "left";

		text1.size = "20";

		text1.value = "<?php echo $storeanum; ?>";

		//text1.readOnly = "readonly";

		text1.style.backgroundColor = "#FFFFFF";

		text1.style.border = "0px solid #001E6A";

		text1.style.textAlign = "left";	

		td1.appendChild (text1);

		

		var text2 = document.createElement ('input');

		text2.id = "storecode";

		text2.name = "storecode";

		//alert(text22.name);

		text2.type = "radio";

		text2.align = "left";

		text2.size = "20";

		text2.value = "<?php echo $storeanum; ?>";

		//text2.readOnly = "readonly";

		text2.style.backgroundColor = "#FFFFFF";

		text2.style.border = "0px solid #001E6A";

		text2.style.textAlign = "left";	

		td1.appendChild (text2);

		

		var text3 = document.createElement ('input');

		text3.id = "storename"+z+"";

		text3.name = "storename"+z+"";

		//alert(text33.name);

		text3.type = "text";

		text3.align = "left";

		text3.size = "30";

		text3.value = "<?php echo $store; ?>";

		text3.readOnly = "readonly";

		text3.style.backgroundColor = "#FFFFFF";

		text3.style.border = "0px solid #001E6A";

		text3.style.textAlign = "left";	

		td1.appendChild (text3);

		

		tr.appendChild (td1);

		

		document.getElementById('foo').appendChild(tr);
		document.getElementById('totalcount').value="<?php echo $sno; ?>";

		<?php 

		}

		?>

		}

	<?php

	}

	?>

}



</script>

<script src="js/datetimepicker_css.js"></script>

<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5">

	<?php 

	

		include ("includes/menu1.php"); 

	

	//	include ("includes/menu2.php"); 

	

	?>	</td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td valign="top">&nbsp;</td>

    <td valign="top">

	

	

	<form name="selectemployee" id="selectempoyee"   >

	<table width="900" height="29" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody>

	<?php if ($errmsg != '') { ?>

	<tr>

	  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

	  <td colspan="2" align="left" valign="middle" 

	  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>

	  </tr>

	<?php } ?>

	<tr>

	<td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

	<td width="21%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Select Employee To Edit </strong></td>

	<td width="60%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

<!--	<select name="selectemployeecode" id="selectemployeecode">

	<option value="">Select Employee To Edit</option>

	<?php

	$query21 = "select * from master_employee where status = 'Active' order by employeename";

	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res21 = mysqli_fetch_array($exec21))

	{

	$res21employeecode = $res21['employeecode'];

	$res21employeename = $res21['employeename'];

	?>

	<option value="<?php echo $res21employeecode; ?>"><?php echo $res21employeecode.' - '.$res21employeename; ?></option>

	<?php

	}

	?>

	</select>-->

	<input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

	<input name="searchdescription" id="searchdescription" type="hidden" value="">

	<input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">

	<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">

	<input type="button" name="Submit" value="Submit" onClick="funcEmployeeSelect1(selectemployee)">	

     <input type="hidden" name="frmflag11" value="frmflag11" />

    </td>

	</tr>

	</tbody>

	</table>  

	</form>

	

    <?php if($frmflag11=='frmflag11') { ?>

    <table>

    <tr>

              <td><form name="form1" id="form1" method="post" action="nursetoward.php" onSubmit="return addward1process1()">

                 

                  

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;">

                    <tbody>

					<tr>

					<td colspan="3" align="left" class="bodytext3">&nbsp;</td>

					</tr>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Add Location and Ward</strong></td>

                        <td width="63%" colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Employee :</strong>&nbsp;<?php echo $employeename;?></td>

                      </tr>

					  <tr>

                        <td colspan="3" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                    

                         <tr>

						 <td align="left" class="bodytext3"><strong>Select Location </strong>

                        <td colspan="2" align="left" valign="middle">

						<select name="emplocation" id="emplocation" onChange="FuncBranch(this.value)">

						<?php if($locationanum != '') { ?>

						<option value="<?php echo $locationanum; ?>"><?php echo $locationname; ?></option>

						<?php } ?>

						<option value="">Select Location</option>

						 <?php

						$query1 = "select locationname,locationcode,auto_number from master_location where status <> 'deleted' order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$incr=0;

						while ($res1 = mysqli_fetch_array($exec1))

						{

						 $res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						 $res1locationautonum = $res1["auto_number"];

						$incr=$incr+1;

						?>

						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>

						<?php

						}

						?>

						</select>

						</td>

						</tr>

						<tr>
						 
						 <td align="left" class="bodytext3"><strong>Check All</strong>&nbsp;<input type="checkbox" value="1"  name="approve" id="approve" onClick="approvecheck();">  </td>

						<td colspan="2" align="left" class="bodytext3"><strong>Ward</strong></td>
						

						</tr>

						<tbody id="foo">

						<?php

						$sno = 0;

						$query35 = "select * from master_ward where locationcode = '$locationanum'";

						$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($res35 = mysqli_fetch_array($exec35))

						{

						$store = $res35['ward'];

						$sanum = $res35['auto_number'];

						$sno = $sno + 1;

						

						$query34 = "select * from nurse_ward where employeecode = '$searchemployeecode' and wardcode = '$sanum'";

						$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res34 = mysqli_fetch_array($exec34);

						$storecode = $res34['wardcode'];

						$default = $res34['defaultward'];

						?>

						<tr bgcolor="#FFFFFF">

						<td>&nbsp;</td>

						<td colspan="2" align="left" class="bodytext3"><input type="checkbox" name="store[]" id="store<?php echo $sno; ?>" value="<?php echo $sanum; ?>" <?php if($storecode == $sanum) { echo "Checked"; } ?>>

						<input type="radio" name="storecode" id="storecode<?php echo $sno; ?>" value="<?php echo $sanum; ?>" <?php if($default == 'default') { echo "Checked"; } ?>>

						<input type="text" size="30" readonly name="storename<?php echo $sno; ?>" id="storename<?php echo $sno; ?>" value="<?php echo $store; ?>" style="border:none;">

						</td>

						</tr>

						<?php

						}

						?>

						</tbody>

                  <input type="hidden" name="locationcount" value="<?php echo $incr;?>">

              		<input type="hidden" name="employeeidget" value="<?php echo $employeeid;?>">

                    <input type="hidden" name="employeenameget" value="<?php echo $employeename;?>">
					
					 <input type="hidden" name="totalcount" id="totalcount"  value="<?php echo $sno;?>">

              

                     

                      <tr>

                        <td width="18%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                             <input type="hidden" name="frmflag11" value="" />

                        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

                 

                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    

                  </table>

                

              </form>

                </td>

            </tr>

            </table>

            <?php }?>

	

	

  <tr>

    <td>&nbsp;</td>

    <td valign="top">&nbsp;</td>

    <td valign="top">  

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top">&nbsp;</td>

    </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



