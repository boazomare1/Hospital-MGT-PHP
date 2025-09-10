<?php

//Simacle Billing Software - Version 7.0 - Released Jan 2012

//Simacle Billing Software - Version 8.0 - Released 21Nov2012 Wednesday

$titlestr = '';

include ("includes/pagetitle1.php");



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

	var vars = "action=sessioncheck&&username="+username+"&&timelimit="+timelimit+"&&timeout="+timeout;

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

				window.location.href = "logout1.php";

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


</script>

<style type="text/css">



.style4TM1 {font-size: 20px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000099;}



#maindivlogin,#mainlogindiv{

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

.bodytext-3 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}

</style>

<?php

$locationshortname='';

if (isset($_SESSION['docno'])) { $sessiondocno = $_SESSION['docno']; } else { $sessiondocno = ""; }

if (isset($_SESSION['username'])) { $sessionusername = $_SESSION['username']; } else { $sessionusername = ""; }

if (isset($_SESSION['timelimit'])) { $timelimit = $_SESSION['timelimit']; } else { $timelimit = ""; }

if (isset($_SESSION['timeout'])) { $timeout = $_SESSION['timeout']; } else { $timeout = ""; }

//$sessiondocno = $_SESSION['docno'];

if($sessiondocno!='')

{

$queryshortloccode = "select locationcode from login_locationdetails where username='$sessionusername' and docno='$sessiondocno' group by locationname order by locationname";

$execshortloccode = mysqli_query($GLOBALS["___mysqli_ston"], $queryshortloccode) or die ("Error in Queryshortloccode".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($resshortloccode = mysqli_fetch_array($execshortloccode))

{

$reslocationanum = $resshortloccode["locationcode"];

$queryshortlocname = "select locationname from master_location where locationcode='$reslocationanum' group by locationname order by locationname";

$execshortlocname = mysqli_query($GLOBALS["___mysqli_ston"], $queryshortlocname) or die ("Error in Queryshortlocname".mysqli_error($GLOBALS["___mysqli_ston"]));

$resshortlocname = mysqli_fetch_array($execshortlocname);

$locationshortname = $resshortlocname["locationname"];

echo '<b>'.$locationshortname.'</b>';

}

}

if($locationshortname=='')

{

	echo '<b>No Location Selected</b>';

}


$queryShift = "select * from master_employee where username = '$sessionusername' and status = 'Active'";
$shiftexc = mysqli_query($GLOBALS["___mysqli_ston"], $queryShift) or die("Error in queryShift".mysqli_error($GLOBALS["___mysqli_ston"]));
$shiftres53 = mysqli_fetch_array($shiftexc);
$shiftaccess_chk = $shiftres53["shift"];

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>

    <td colspan="4" bgcolor="#FFFFFF">

	<span class="style4TM1">

	<img src="images/presto.png" />	</span></td>

    <!--<td width="3%" bgcolor="#FFFFFF"><img src="images/user1.png" width="30" height="20"/></td>-->

    <td width="16%" bgcolor="#FFFFFF" class="style4TM1" align="right" valign="">

	<span style="position: absolute;    left: 226px;    top: 36px;"><?php if (isset($_SESSION["username"])) { echo strtoupper($_SESSION["username"]); } ?></span>

	<!--&nbsp;<a  onclick="lockscreen();" accesskey="l"><img src="images/lockscreen.png" width="40" height="30" style="cursor:pointer;" title="Lock Screen"/></a>-->

        <a  onclick="enablescreen();" accesskey="u" ></a>&nbsp;&nbsp;</td>

    
    <td width="39%" align="left" valign="" bgcolor="#FFFFFF" class="style4TM1">

	<span id="date_time"></span>

    <script type="text/javascript">date_time('date_time');</script><a href="logout1.php"><img src="images/logout.png"  align="center"width="40" height="30"/ title='Logout'></a>
	
	</td>

	
<div style="float:right; margin-bottom: 3;">
	
	<select name="userstore" id="userstore" onchange="updateStore(this.value);">

		<?php 
			$username = $_SESSION['username'];



 $query3 = "SELECT a.storecode,b.store from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and a.locationcode='$reslocationanum' and a.defaultstore='default'";
$exec3= mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res3 = mysqli_fetch_array($exec3))
{
	$store1=$res3['store'];

}

 $query2 = "SELECT a.storecode,b.store,a.defaultstore from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and a.locationcode='$reslocationanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$storesname=$res2['store'];
	$scode=$res2['storecode'];

	$defaultstore=$res2['defaultstore'];	

	if($defaultstore=='default')
		$selected='selected';
	else
		$selected='';

	echo '<option value="'.$scode.'" '.$selected.' >' .$storesname. '</option>';

}

    ?>



  
</select>

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
	<td width="8%" bgcolor="#FFFFFF"  align="left"><span class="bodytext-3">Shift #: <?php echo $shiftouttimes;?></span></td>

	<td width="6%" bgcolor="#FFFFFF"  align="left"><a href="javascript:return false;"><img src="images/shiftout.png" width="40" height="30" onclick="return funccheck()" title='Shift Out'/></a></td>
	<?php } else { ?>

	<td width="8%" bgcolor="#FFFFFF"  align="left"><span class="bodytext-3"></span></td>

	<td width="6%" bgcolor="#FFFFFF"  align="left"></td>

	<?php } ?>

    <td width="8%" align="left" bgcolor="#FFFFFF" class="style4TM1"><a href="passwordchange.php"><img src="images/pwdkey.png" width="40" height="30" title='Change Password'/></a></td>
	<td width="8%" align="left" bgcolor="#FFFFFF" class="style4TM1"><img src="images/hospital.png" width="150" height="50"/></a></td>

    <td width="17%" bgcolor="#FFFFFF" class="style4TM1" align="center"></td>

  </tr>

</table>

<div align="center" class="imgloader" id="imgloader" style="display:none;">

<img src="images/unlock.jpg" width="40" height="30" onclick="enablescreen();" style='position: absolute;  left: 400px;  top: 32px;cursor:pointer;'  title="Open Screen"/>

</div>



<div align="center" class="mainlogindiv" id="mainlogindiv" style="display:none">

	<div align="center" style="position: absolute;top: 50px;left: 513px;background: #FFF;width: 27%;height: 27%;border-radius: 30px;">

        <div id='loginimages' class="bodytext3" style=" position:absolute;left:85px;" >

            <img src="images/Lock-64.png" width="40" height="40"/> Idle Time Out 

            <br />

            <b id="alertlogmsg" style="margin-left:-60px; background-color:#F90;"></b>

        </div>

        <div id="usernamediv" style=" position:absolute; top:80px; left:58px;" class="bodytext3">

        User Name <input type="text" id="username" name="username" value="<?php echo trim($sessionusername);?>" readonly="readonly"/></div>

        <div id="passworddiv" style="position:absolute; top:110px; left:58px;" class="bodytext3">

        Password &nbsp;&nbsp;<input type="password" id="password" name="password" value="" />

        <input type="hidden" id="locdocno" name="locdocno" value="<?php echo $sessiondocno; ?>" />

        <input type="hidden" id="locationcode" name="locationcode" value="<?php echo $reslocationanum; ?>" />

        <input type="hidden" id="timelimit" name="timelimit" value="<?php echo $timelimit; ?>" />

        <input type="hidden" id="timeout" name="timeout" value="<?php echo $timeout; ?>" />

        </div>    

        <div id="loginoutbutton" style="position: absolute;top: 140px;left: 132px;">

            <input type="button" name='login' id="login" class='login' value="Login" onclick="loginfunction();"/>

            <input type="button" name='logout' id="logout" class='logout' value="Logout" onclick="logoutfunction();"/>

        </div>

    </div>

</div>