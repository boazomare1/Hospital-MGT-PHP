<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username=$sessionusername;
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
	
	$query4 = "DELETE FROM master_employeelocation WHERE employeecode = '".$employeeid."'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	for($i=1; $i<=$loccountloop; $i++)
	{
	 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
	 $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';
	 
		 if($loccodeget!='')
		 {
			 
		$query1 = "select locationname,locationcode from master_location where status <> 'deleted' AND auto_number = '".$loccodeget."'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		
		$locationcode = $res1["locationcode"];
		$locationname = $res1["locationname"];
						
		$stocountloop=isset($_REQUEST['storecount'.$i])?$_REQUEST['storecount'.$i]:'';
		$nullstore=0;
		for($j=1; $j<=$stocountloop; $j++)
			{
			$stocodeget=isset($_REQUEST['scheck'.$i.$j])?$_REQUEST['scheck'.$i.$j]:'';
			if($stocodeget!='')
			{
				$nullstore=$nullstore+1;
				$defaultstorecode=isset($_REQUEST['defaultstore'.$i])?$_REQUEST['defaultstore'.$i]:'';
				if($defaultstorecode == $stocodeget)
				{
					$defaultstore = 'default';
				}
				else
				{
					$defaultstore = '';
				}
						$query2 = "INSERT INTO master_employeelocation SET employeecode = '".$employeeid."',username = '".$employeename."',locationanum = '".$loccodeget."',locationname = '".$locationname."',locationcode = '".$locationcode."',lastupdate = '".date('Y-m-d h:i:s')."',lastupdateipaddress = '".$_SERVER['REMOTE_ADDR']."',lastupdateusername = '".$username."',storecode = '".$stocodeget."',defaultstore='$defaultstore'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
			// $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';
			}
			if($nullstore==0)
			{
						$query2 = "INSERT INTO master_employeelocation SET employeecode = '".$employeeid."',username = '".$employeename."',locationanum = '".$loccodeget."',locationname = '".$locationname."',locationcode = '".$locationcode."',lastupdate = '".date('Y-m-d h:i:s')."',lastupdateipaddress = '".$_SERVER['REMOTE_ADDR']."',lastupdateusername = '".$username."'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
		//$itemcode = $_REQUEST["itemcode"];
		 }
	}
	header("Location:employeeclose.php");
}




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
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
	var oTextbox = new AutoSuggestControl(document.getElementById("empid"), new StateSuggestions());
  
}
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
	selectemployee.action="addemployeelocationandstore.php?eid="+eid;
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
function showfunction(show)
{
	//alert(show);
	if(document.getElementById('show'+show).style.display=='none')
	{
	document.getElementById('show'+show).style.display='block';
	}
	else
	{
	document.getElementById('show'+show).style.display='none';
	}
	
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

    <table style="width:100%;float:left;"><tr><td width="100%">&nbsp;</td></tr></table>
   
    <table>
    <tr>
              <td><form name="form1" id="form1" method="post" action="addemployeelocationandstore.php" onSubmit="return addward1process1()">
                 
                  
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Add Location and Stores</strong></td>
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3" align="right"><strong>&nbsp; </strong>&nbsp;<?php //echo $employeename;?></td>
                      </tr>
					  <tr>
                        <td colspan="3" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
              
              
               </tr>
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
						<tr >
                        <th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" colspan="3"><strong><input name="lcheck<?php echo $incr;?>" type="checkbox" value="<?php echo $res1locationautonum;?>" onChange="showfunction(<?php echo $incr?>)"  <?php $query22 = "select * from master_employeelocation where employeecode = '".$employeeid."'";
						$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res22 = mysqli_fetch_array($exec22))
						{
						
						 $equallocationanum = $res22["locationanum"]; if($res1locationautonum==$equallocationanum){echo "checked";break;}}?>><?php echo  $res1location;?></strong></th>
              
              </tr>
            <tr  bgcolor="#FFFFFF" class="bodytext3"><td colspan="2"><table width="60%" id="show<?php echo $incr;?>"  bgcolor="#ecf0f5" class="bodytext3"
            
            style="display:none;display:<?php $query22 = "select locationanum from master_employeelocation where employeecode = '".$employeeid."'";
						$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res22 = mysqli_fetch_array($exec22))
						{
						
						 $equallocationanum = $res22["locationanum"]; if($res1locationautonum==$equallocationanum){echo "block";break;}}?>" border="0">
              			<!--<tr bgcolor="#ecf0f5">
						<td width="5" align="left" class="bodytext3"><strong>Select</strong></td>
						<td width="5" align="left" class="bodytext3"><strong>Defalut</strong></td>
						<td width="50"align="left" class="bodytext3"><strong>Store</strong> </td>
						</tr>-->
             			 <?php
						
						$query11 = "select store,auto_number,location,storecode from master_store where recordstatus <> 'deleted' AND	location = '".$res1locationautonum."'  order by store";
						$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						$incr1=0;
						while ($res11 = mysqli_fetch_array($exec11))
						{
						$res1store = $res11["store"];
						$res1storecode = $res11['storecode'];
						$res1storeanum = $res11["auto_number"];
						$res1locationanum = $res11['location'];
						$incr1=$incr1+1;
						?>
						<tr >
                        <?php $lno = '0'; ?>
              <td align="left" ><input type="checkbox" name="scheck<?php echo $incr.$incr1;?>" value="<?php echo $res1storeanum;?>" <?php $query22 = "select storecode,defaultstore from master_employeelocation where employeecode = '".$employeeid."'";
						$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res22 = mysqli_fetch_array($exec22))
						{
						$lno = $lno +1;
						 $equalstorecode = $res22["storecode"]; if($res1storeanum==$equalstorecode){echo "checked";} }?>>
						 
						 <input type="radio" name="defaultstore<?php echo $incr; ?>" value="<?php echo $res1storeanum; ?>" <?php echo $query25 = "select storecode,defaultstore from master_employeelocation where employeecode = '".$employeeid."' and storecode = '$res1storeanum'";
						$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res25 = mysqli_fetch_array($exec25);
						
						
						$defaultstore = $res25['defaultstore'];
					   if($defaultstore=='default'){echo "checked";} ?> >
             			<strong><?php echo $res1store;?></strong></td>
						
						</tr>
                        
						<?php }?>
						</table>
						</td></tr>
                         <input type="hidden" name="storecount<?php echo $incr;?>" value="<?php echo $incr1;?>">
						<?php
						}
						?>
                  <input type="hidden" name="locationcount" value="<?php echo $incr;?>">
              		<input type="hidden" name="employeeidget" value="<?php echo $employeeid;?>">
                    <input type="hidden" name="employeenameget" value="<?php echo $employeename;?>">
              
                     
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
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

