<?php

$titlestr = '';

include ("includes/pagetitle1.php");

date_default_timezone_set('Asia/Kolkata');
$timestamp =  date("H-m-d h:i:s", time());
//print_r($timestamp);
?>



<script type="text/javascript">

function date_time(id)

{

        date = new Date;

        year = date.getFullYear();

        month = date.getMonth();

        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

        d = date.getDate();

        day = date.getDay();

        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

        h = date.getHours();

        if(h<10)

        {

                h = "0"+h;

        }

        m = date.getMinutes();

        if(m<10)

        {

                m = "0"+m;

        }

        s = date.getSeconds();

        if(s<10)

        {

                s = "0"+s;

        }

        result = ''+days[day]+', '+months[month]+' '+d+', '+year+' '+h+':'+m+':'+s;

        document.getElementById(id).innerHTML = result;

        setTimeout('date_time("'+id+'");','1000');

        return true;

}



function funccheck()

{



	

var varUserChoice; 

	varUserChoice = confirm('DO YOU LIKE TO END YOUR SHIFT?CLICK YES TO SHIFT OUT OR CLICK CANCEL'); 

	//alert(fRet); 

	if (varUserChoice == false)

	{

		

		return false;

	}

	var cash;

  /*var cash = prompt("Physical Cash");

 cash =  cash.replace(/^\s+|\s+$/g, '' );

  

  if (cash == '' || varUserChoice == false) {

    return false;



  }*/

do{

    input = prompt("Enter Physical Cash");

}while(input == null || input == "" );

	



	var username = document.getElementById("username").value;

	var locdocno = document.getElementById("locdocno").value;

	var cashobj = new XMLHttpRequest();	

	var vars = "physicalcash="+input+"&&username="+username+"&&locdocno="+locdocno;



	var url = "ajax/ajaxstoreshiftoutcash.php?"+vars; 

	cashobj.open("POST", url, true);	

	cashobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	

	cashobj.onreadystatechange = function() 

	{

		if(cashobj.readyState == 4 && cashobj.status == 200) 

		{

			//console.log(cashobj.responseText);



			var return_data = cashobj.responseText;



			var splitreturn_data = return_data.split('||');

			var statusflag = splitreturn_data[0];

			var statusflag2 = splitreturn_data[1];



			if(statusflag.trim() == 1)

			{
				//alert(statusflag);
				// window.location='shiftout_pdf.php?username='+username;
				// window.location.href ='shiftout_pdf.php?username='+username;
				window.open('shiftout_pdf.php?username='+username);
				window.location.href ='logout1.php';
			}
			else if(statusflag.trim() == 2)

			{

				alert('Shift already update with cash of '+statusflag2+', So please login again and update balance cash.');

			}
			else

			{

				alert('Failed to update the cash');

			}

			

			

		}

	}

	

	cashobj.send(vars);

	

}

function lockscreen()

{

	document.getElementById('imgloader').style.display='block';

	

	document.body.style.overflow='hidden';

	

}



function enablescreen()

{

	document.getElementById('imgloader').style.display='none';

	document.body.style.overflow='auto';

	

	

}



function stopRKey(evt) {



  var evt = (evt) ? evt : ((event) ? event : null); 

  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 

 

  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 

}





document.onkeydown = function(e)

{

	

	if (e.target.nodeName.toUpperCase() != 'INPUT' && e.target.nodeName.toUpperCase() != 'TEXTAREA')

		return (e.keyCode != 8);

		

	if (e.target.nodeName.toUpperCase() != 'INPUT')

		return (e.keyCode != 13);

}



document.onkeypress = stopRKey; 



function loginoutfunction()

{

	var hrlogout = new XMLHttpRequest();

	var username = document.getElementById("username").value;

	var timelimit = document.getElementById("timelimit").value;

	var timeout = document.getElementById("timeout").value;	
	
	var locdocno = document.getElementById("locdocno").value;	

	var vars = "action=sessioncheck&&username="+username+"&&timelimit="+timelimit+"&&timeout="+timeout+"&&locdocno="+locdocno;

	var url = "chk_session.php?"+vars;  	

	hrlogout.open("POST", url, true);	

	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	

	hrlogout.onreadystatechange = function() 

	{

		if(hrlogout.readyState == 4 && hrlogout.status == 200) 

		{

			var return_data = hrlogout.responseText;
			return_data=return_data.trim();

			if(return_data=='1')

			{

				//alert(return_data);

				document.getElementById("mainlogindiv").style.display = "";

				document.body.style.overflow='hidden';

				window.scrollTo(0,0);

				setTimeout(loginoutfunction, 2000);

			}

			else if(return_data=='0')

			{
               
				document.getElementById("mainlogindiv").style.display = "none";

				document.body.style.overflow='auto';

				setTimeout(loginoutfunction, 2000);

			} 

			else if(return_data=='2')

			{

				window.location.href = "access.php";

			}

			else if(return_data=='3')

			{

				

				var pathori = '<?php echo basename($_SERVER['REQUEST_URI']);?>';

				var pathsp = pathori.split("?");

				var path = pathsp[0];

				//alert(path);

				if(path !='shiftwisereport2.php' && path !='shiftwisereportdetailed2.php'){

					window.location.href = "shiftwisereport2.php?anum=254";

					setTimeout(loginoutfunction, 2000);

				}

				setTimeout(loginoutfunction, 2000);

			} else if(return_data=='4'){
				
				window.location.href = "mainmenu1.php?mainmenuid=MM000";
				
			}

		}

	}

	

	hrlogout.send(vars);

}

function loginfunction()

{

	document.getElementById("alertlogmsg").innerHTML = 'Verifying User';

	var username = document.getElementById("username").value;

	var password = document.getElementById("password").value;

	var locdocno = document.getElementById("locdocno").value;

	var hrlogout = new XMLHttpRequest();	

	var vars = "action=loginuser&&username="+username+'&&password='+password+'&&locdocno='+locdocno;

	var url = "chk_session.php?"+vars; 

	hrlogout.open("POST", url, true);	

	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	

	hrlogout.onreadystatechange = function() 

	{

		if(hrlogout.readyState == 4 && hrlogout.status == 200) 

		{

			var return_data = hrlogout.responseText;

			//alert(return_data);

			var splitreturn_data = return_data.split('||');

			var splitreturn_data0 = splitreturn_data[0];

			var splitreturn_data1 = splitreturn_data[1];

			var splitreturn_data2 = splitreturn_data[2];

			if(splitreturn_data0=='1')

			{			

				document.getElementById("mainlogindiv").style.display = "none";				

				document.body.style.overflow='auto';

				document.getElementById("alertlogmsg").innerHTML = '';	

				document.getElementById("password").value='';	

				document.getElementById("timelimit").value=splitreturn_data1;	

				document.getElementById("locdocno").value=splitreturn_data2;	

				setTimeout(loginoutfunction, 2000);

			}

			else if(splitreturn_data0=='0')

			{

				document.getElementById("alertlogmsg").innerHTML = 'Login Failed. Please Try Again With Proper User Id and Password.';

				document.getElementById("password").value='';

				document.body.style.overflow='hidden';

			}

		}

	}

	

	hrlogout.send(vars);

}



function logoutfunction()

{

	

	var username = document.getElementById("username").value;

	var password = document.getElementById("password").value;

	var locdocno = document.getElementById("locdocno").value;

	var hrlogout = new XMLHttpRequest();	

	var vars = "action=logoutuser&&username="+username+'&&password='+password+'&&locdocno='+locdocno;

	var url = "chk_session.php?"+vars; 

	hrlogout.open("POST", url, true);	

	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	

	hrlogout.onreadystatechange = function() 

	{

		if(hrlogout.readyState == 4 && hrlogout.status == 200) 

		{

			var return_data = hrlogout.responseText;

			//alert(return_data);

			if(return_data=='logoutuser')

			{			

				window.location.href = "logout1.php";

			}			

		}

	}

	

	hrlogout.send(vars);

	

}

setTimeout(loginoutfunction, 2000);



function updateStore(store){

	var username=document.getElementById("username").value;
    var locationcode=document.getElementById("locationcode").value;
	
	
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
	 //document.getElementById("store").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("GET","getDataStore.php?store="+ store+"&username="+ username+"&locationcode="+locationcode,true);
	xmlhttp.send();
	


}

function multilocation_change(change_lct){
	
	var multi_lct_change=change_lct;
	var username=document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var locdocno = document.getElementById("locdocno").value;
	
	var hrlogout = new XMLHttpRequest();
	var vars = "lct="+ multi_lct_change+"&username="+ username+"&password="+ password+"&locdocno="+ locdocno;
	var url = "update_multi_bylocation.php?"+vars; 
	hrlogout.open("GET", url, true);	
	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
	hrlogout.onreadystatechange = function() 
	{
		if(hrlogout.readyState == 4 && hrlogout.status == 200) 
		{
			
			var return_data = hrlogout.responseText;
			
			setTimeout(loginoutfunction, 0);
			//var splitreturn_data = return_data.split('||');
			//var splitreturn_data0 = splitreturn_data[0];
			//var splitreturn_data1 = splitreturn_data[1];
			//var splitreturn_data2 = splitreturn_data[2];
			//var splitreturn_data3 = splitreturn_data[3];
			//var splitreturn_data4 = splitreturn_data[4];
				//document.getElementById("locdocno").value=splitreturn_data0;
				//document.getElementById("username").value=splitreturn_data1;
				//document.getElementById("timelimit").value=splitreturn_data2;
				//document.getElementById("timeout").value=splitreturn_data3;	

				//setTimeout(loginoutfunction, 2000);
		}
	}
	hrlogout.send();
	alert("Location Changed Sucessfully");
	window.location.href = "mainmenu1.php?mainmenuid=MM000";
}


</script>

<style type="text/css">



.style4TM1 {font-size: 20px; font-family: Verdana, Arial, Helvetica, sans-serif; color:#ecf0f5;}



#maindivlogin,#mainlogindiv{

position: absolute;

top: 0px;

left: 0px;

width:100%;

height:100%;

background:rgba(54, 25, 25, .5);

}

#lctdivlogin{

position: absolute;

top: 0px;

left: 0px;

width:100%;

height:100%;

background:rgba(54, 25, 25, .5);

}

#alertloader,#imgloader{

position: absolute;

top: 0px;

left: 0px;

width:100%;

height:100%;

background:rgba(54, 25, 25, .5);

}

.bodytext-3 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #ecf0f5; 
}

.menu-bars {
		width: 25px;
		cursor: pointer;
	}

	.bar {
		width: 100%;
		height: 4px;
		background: #ffffff;
		margin: 4px 0px;
		border-radius: 5px;
	}

</style>
<style>
/* Simple Global Sidebar */
.global-sidebar {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    background: #2c5aa0;
    overflow-x: hidden;
    transition: 0.3s;
    padding-top: 20px;
}

.global-sidebar.open {
    width: 250px;
}

.global-sidebar-content {
    padding: 20px;
    color: white;
}

.global-sidebar-header {
    text-align: center;
    padding: 20px 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
    margin-bottom: 20px;
}

.global-sidebar-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 5px;
}

.global-sidebar-subtitle {
    font-size: 14px;
    opacity: 0.8;
}

.global-sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.global-sidebar-nav li {
    margin-bottom: 5px;
}

.global-sidebar-nav a {
    display: block;
    padding: 12px 15px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s;
}

.global-sidebar-nav a:hover {
    background: rgba(255,255,255,0.1);
}

.global-sidebar-nav .nav-icon {
    margin-right: 10px;
    font-size: 16px;
}

.global-sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    display: none;
}

.global-sidebar-overlay.open {
    display: block;
}

/* Menu bars */
.menu-bars {
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
    transition: background 0.3s;
}

.menu-bars:hover {
    background: rgba(255,255,255,0.1);
}

.menu-bars .bar {
    width: 25px;
    height: 3px;
    background: white;
    margin: 5px 0;
    transition: 0.3s;
}

@media (max-width: 768px) {
    .global-sidebar.open {
        width: 100%;
    }
}
</style>
<!-- Simple Global Sidebar -->
<div id="globalSidebar" class="global-sidebar">
    <div class="global-sidebar-content">
        <div class="global-sidebar-header">
            <div class="global-sidebar-title">Poplar Hospital</div>
            <div class="global-sidebar-subtitle">Management System</div>
        </div>
        
        <nav class="global-sidebar-nav">
            <li><a href="mainmenu1.php"><span class="nav-icon">🏠</span>Dashboard</a></li>
            <li><a href="addpatient1.php"><span class="nav-icon">👤</span>Add Patient</a></li>
            <li><a href="activeinpatientlist.php"><span class="nav-icon">🏥</span>Inpatient List</a></li>
            <li><a href="addconsultation1.php"><span class="nav-icon">👨‍⚕️</span>Consultation</a></li>
            <li><a href="labitem1master.php"><span class="nav-icon">🧪</span>Lab Items</a></li>
            <li><a href="addradiologytemplate.php"><span class="nav-icon">📷</span>Radiology</a></li>
            <li><a href="accountstatement.php"><span class="nav-icon">📊</span>Account Statement</a></li>
            <li><a href="accountreceivableentry.php"><span class="nav-icon">💰</span>Receivables</a></li>
            <li><a href="accountexpense.php"><span class="nav-icon">💸</span>Expenses</a></li>
            <li><a href="accountincome.php"><span class="nav-icon">💵</span>Income</a></li>
            <li><a href="addemployee1.php"><span class="nav-icon">👥</span>Employees</a></li>
            <li><a href="adddoctor1.php"><span class="nav-icon">👨‍⚕️</span>Doctors</a></li>
            <li><a href="addnurse1.php"><span class="nav-icon">👩‍⚕️</span>Nurses</a></li>
            <li><a href="adddepartment1.php"><span class="nav-icon">🏢</span>Departments</a></li>
            <li><a href="backupsoftware1.php"><span class="nav-icon">💾</span>Software Backup</a></li>
            <li><a href="backupdatabase1.php"><span class="nav-icon">🗄️</span>Database Backup</a></li>
            <li><a href="absentmaster1.php"><span class="nav-icon">📅</span>Absent Master</a></li>
            <li><a href="menupage1.php"><span class="nav-icon">📋</span>Menu Page</a></li>
            <li><a href="logout.php"><span class="nav-icon">🚪</span>Logout</a></li>
        </nav>
    </div>
</div>

<div id="globalSidebarOverlay" class="global-sidebar-overlay"></div>

<script>
// Simple Global Sidebar Functions
function openGlobalNav() {
    const sidebar = document.getElementById("globalSidebar");
    const overlay = document.getElementById("globalSidebarOverlay");
    
    if (sidebar && overlay) {
        sidebar.classList.add("open");
        overlay.classList.add("open");
    }
}

function closeGlobalNav() {
    const sidebar = document.getElementById("globalSidebar");
    const overlay = document.getElementById("globalSidebarOverlay");
    
    if (sidebar && overlay) {
        sidebar.classList.remove("open");
        overlay.classList.remove("open");
    }
}

// Close sidebar when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById("globalSidebarOverlay");
    if (overlay) {
        overlay.addEventListener('click', closeGlobalNav);
    }
    
    // Escape key closes sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGlobalNav();
        }
    });
});

// Replace the old openNav function
function openNav() {
    openGlobalNav();
}
</script>
<?php

$locationshortname='';

if (isset($_SESSION['docno'])) { $sessiondocno = $_SESSION['docno']; } else { $sessiondocno = ""; }
//echo $sessiondocno;
if (isset($_SESSION['username'])) { $sessionusername = $_SESSION['username']; } else { $sessionusername = ""; }

if (isset($_SESSION['timelimit'])) { $timelimit = $_SESSION['timelimit']; } else { $timelimit = ""; }

if (isset($_SESSION['timeout'])) { $timeout = $_SESSION['timeout']; } else { $timeout = ""; }

//$sessiondocno = $_SESSION['docno'];

?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
<input type="hidden" id="locdocno" name="locdocno" value="<?php echo $sessiondocno; ?>" />

       

        <input type="hidden" id="timelimit" name="timelimit" value="<?php echo $timelimit; ?>" />

        <input type="hidden" id="timeout" name="timeout" value="<?php echo $timeout; ?>" />
<td width="15%" bgcolor=""> 
<?php
$mutlct = "select locationcode from login_locationdetails where username='$sessionusername' and docno='$sessiondocno'  group by locationname order by locationname";
$execmutlct = mysqli_query($GLOBALS["___mysqli_ston"], $mutlct) or die ("Error in mutlct".mysqli_error($GLOBALS["___mysqli_ston"]));
$nummutlct = mysqli_num_rows($execmutlct);
if($nummutlct>'0')
{
?>
<select name="sess_user_locationcode" id="sess_user_locationcode" onchange="multilocation_change(this.value)">
<?php
$query01="select locationcode,locationname,locationanum from master_employeelocation where username='$username'  group by locationcode order by locationanum asc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
while($res01=mysqli_fetch_array($exc01))
{
$locationshortname=	$res01['locationname'];
$locationlocationanum=	$res01['locationanum'];
$queryshortloccode = "select locationcode from login_locationdetails where username='$sessionusername' and docno='$sessiondocno' group by locationname order by locationname";
$execshortloccode = mysqli_query($GLOBALS["___mysqli_ston"], $queryshortloccode) or die ("Error in Queryshortloccode".mysqli_error($GLOBALS["___mysqli_ston"]));
$resshortloccode = mysqli_fetch_array($execshortloccode);
$reslocationanum = $resshortloccode["locationcode"];	
	
?>
<option value="<?= $res01['locationcode'] ?>" <?php if($reslocationanum==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] . ' (' .$locationlocationanum.')'; ?></option>		
<?php 
} 
?>
</select>
<?php
} else { ?>
<select name="sess_user_locationcode" id="sess_user_locationcode" onchange="multilocation_change(this.value)">

 <option value="">No Location Selected </option>

</select>
<?php } ?>
 </td>

 <input type="hidden" id="locationcode" name="locationcode" value="<?php echo $reslocationanum; ?>" />
<?php
$queryShift = "select * from master_employee where username = '$sessionusername' and status = 'Active'";
$shiftexc = mysqli_query($GLOBALS["___mysqli_ston"], $queryShift) or die("Error in queryShift".mysqli_error($GLOBALS["___mysqli_ston"]));
$shiftres53 = mysqli_fetch_array($shiftexc);
$shiftaccess_chk = $shiftres53["shift"];
$user_name = $shiftres53["username"];
 $password = base64_decode($shiftres53["password"]);
 $pagename_1=basename($_SERVER['REQUEST_URI']);
$query_sub = "select * from master_menusub where submenulink='$pagename_1'";
$exec_sub = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res_sub = mysqli_fetch_array($exec_sub);
 $submenuid_1 = $res_sub['submenuid'];
 $menumainid_1 = $res_sub['mainmenuid'];
 $submenutext = $res_sub['submenutext'];
 $submenulink = $res_sub['submenulink'];
 
 $query_main = "select * from master_menumain where mainmenuid='$menumainid_1'";
$exec_main = mysqli_query($GLOBALS["___mysqli_ston"], $query_main) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res_main = mysqli_fetch_array($exec_main);
 $mainmenutext = $res_main['mainmenutext'];
 $mainmenulink = $res_main['mainmenulink'];
 if($submenuid_1!=""){
?>
<td>
<a href="<?php echo $mainmenulink; ?>"><span style="color:blue"><b><?php echo $mainmenutext; ?></b></span></a>  &nbsp;>&nbsp;<span style="color:green"><?php echo $submenutext; ?></span>
</td>
 <?php } else{ ?>
 
 <td width="15%"> &nbsp;&nbsp;&nbsp;</td>
 <?php } ?>
 <td><div style="float:left; margin-bottom:3;margin-left:85;font-size:21px">
 <span id="date_time"></span>
 
 </div></td>
 
 
<td align="right">
<select name="userstore" id="userstore" onchange="updateStore(this.value);">
<?php 
$username = $_SESSION['username'];
 $query3 = "SELECT a.storecode,b.store from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and b.recordstatus='' and a.locationcode='$reslocationanum' and a.defaultstore='default'";
$exec3= mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res3 = mysqli_fetch_array($exec3))
{
	$store1=$res3['store'];
}
 $query2 = "SELECT a.storecode,b.store,a.defaultstore from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and b.recordstatus='' and a.locationcode='$reslocationanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$store_code="";
while ($res2 = mysqli_fetch_array($exec2))
{
	$storesname=$res2['store'];
	$scode=$res2['storecode'];
	$defaultstore=$res2['defaultstore'];	
$store_code=$res2['store_code'];
	if($defaultstore=='default')
		$selected='selected';
	else
		$selected='';
	echo '<option value="'.$scode.'" '.$selected.' >' .$storesname. '</option>';
}
    ?>
  
</select>
 </td>
 </tr>
 
 </table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="3%" bgcolor="#3c8dbc">
	<div class="menu-bars" onclick="openNav()">
			<div class="bar fbar"></div>
			<div class="bar sbar"></div>
			<div class="bar tbar"></div>
		</div>
		
	</td>

    <td colspan="4" bgcolor="#3c8dbc">
<a href="mainmenu1.php?mainmenuid=MM000">
	<span style="font-size:29px">
<i class="fa fa-home iconbutton"></i></span>
	</a>
	</td>
    <!--<td width="3%" bgcolor="#FFFFFF"><img src="images/user1.png" width="30" height="20"/></td>-->

    <td width="26%" bgcolor="#3c8dbc" align="left" valign="">

	<span style="position: absolute;"><?php if (isset($_SESSION["username"])) { echo strtoupper($_SESSION["username"]); } ?></span>

	<!--&nbsp;<a  onclick="lockscreen();" accesskey="l"><img src="images/lockscreen.png" width="40" height="30" style="cursor:pointer;" title="Lock Screen"/></a>-->

        <a  onclick="enablescreen();" accesskey="u" ></a>&nbsp;&nbsp;</td>

    
    <td width="32%" align="left" valign="" bgcolor="#3c8dbc" class="style4TM1">

	<!--<span id="date_time"></span>-->

    <script type="text/javascript">date_time('date_time');</script><a href="access.php"><img src="images/logout.png"  align="center"width="40" height="30"/ title='Logout'></a>
	
	</td>

	
<div style="float:right; margin-bottom: 3;">
	
	
<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
</div>
	<?php 
	if($shiftaccess_chk =="YES")
	{
		$querys52 = "select auto_number from shift_tracking where username = '$sessionusername' order by auto_number desc";
		$execs52 = mysqli_query($GLOBALS["___mysqli_ston"], $querys52) or die("Error in Querys52".mysqli_error($GLOBALS["___mysqli_ston"]));
		$ress52 = mysqli_fetch_array($execs52);	
		$shiftouttimes = $ress52["auto_number"];	
   ?>
	<td width="8%" bgcolor="#3c8dbc"  align="left"><span class="bodytext-3">Shift #: <?php echo $shiftouttimes;?></span></td>

	<td width="6%" bgcolor="#3c8dbc"  align="left"><a href="javascript:return false;"><img src="images/shiftout.png" width="40" height="30" onclick="return funccheck()" title='Shift Out'/></a></td>
	<?php } else { ?>

	<td width="8%" bgcolor="#3c8dbc"  align="left"><span class="bodytext-3"></span></td>

	<td width="6%" bgcolor="#3c8dbc"  align="left"></td>

	<?php } 
	
	$reslocationanum;
	$store_code;
	$name2=$user_name;
	$pass=$password;
	//$url='http://localhost/evofin/login?username='.$name2.'&&password='.$pass.'&&location_code='.$reslocationanum.'&&store_code='.$store_code.'';
	
	?>

    <td width="8%" align="left" bgcolor="#3c8dbc" class="style4TM1"><a href="passwordchange.php"><img src="images/pwdkey.png" width="40" height="30" title='Change Password'/></a>
	<!--<a  href="<?php echo $url ?>"><img src="images/accounts.gif" width="40" height="30" title='Accounts'/></a> 
	</td>-->
	<td width="8%" align="left" bgcolor="#3c8dbc" class="style4TM1"><img src="images/medbot.png" width="150" height="50"/></a></td>

      </tr>

</table>

<div align="center" class="imgloader" id="imgloader" style="display:none;">

<img src="images/unlock.jpg" width="40" height="30" onclick="enablescreen();" style='position: absolute;  left: 400px;  top: 32px;cursor:pointer;'  title="Open Screen"/>

</div>



<div align="center" class="lctdivlogin" id="lctdivlogin" style="display:none">
	<div align="center" style="position: absolute;top: 80px;left: 434px;background: #FFF;width: 34%;height: 18%;border-radius: 30px;">

        <div id='loginimages' style="font-size:16px;" class="bodytext3" style=" position:absolute;left:52px;" >
		</br>
		</br>
		<strong> More Actions Doesn't Work, Location Changed Please Reload The Page.</strong>
		</div>
		
	</div>

</div>
<div align="center" class="mainlogindiv" id="mainlogindiv" style="display:none">

	<div align="center" style="position: absolute;top: 50px;left: 513px;background: #FFF;width: 27%;height: 27%;border-radius: 30px;">

        <div id='loginimages' class="bodytext3" style=" position:absolute;left:85px;" >

            <img src="images/Lock-64.png" width="40" height="40"/> Idle Time Out 

            <br />

            <b id="alertlogmsg" style="margin-left:-60px; background-color:#3c8dbc;"></b>

        </div>

        <div id="usernamediv" style=" position:absolute; top:80px; left:58px;" class="bodytext3">

        User Name <input type="text" id="username" name="username" value="<?php echo trim($sessionusername);?>" readonly="readonly"/></div>

        <div id="passworddiv" style="position:absolute; top:110px; left:58px;" class="bodytext3">

        Password &nbsp;&nbsp;<input type="password" id="password" name="password" value="" />

        

        </div>    

        <div id="loginoutbutton" style="position: absolute;top: 140px;left: 132px;">

            <input type="button" name='login' id="login" class='login' value="Login" onclick="loginfunction();"/>

            <input type="button" name='logout' id="logout" class='logout' value="Logout" onclick="logoutfunction();"/>

        </div>

    </div>

</div>