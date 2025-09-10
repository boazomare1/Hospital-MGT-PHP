<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



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

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>

</head>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script language="javascript">
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

function check_status(id,status,user)
{
      data = "id="+id+"&status="+status+"&user="+user;		
	  $.ajax({		
	  type : "get",		
	  url : "update_storefreeze.php",		
	  data : data,		
	  cache : false,
	  timeout:30000,
	  success : function (data){		
	   var jsondata = data.trim();		

	   if(jsondata =='disabled')
	   {
          $("#link-"+id).html("<font color='red'>Yes</font>");
		  $("#link-"+id).attr("onclick","return check_status('"+id+"','1','"+user+"');");
	   }else if(jsondata =='enabled')
	   {
          $("#link-"+id).html("<font color='green'>No</font>");
		  $("#link-"+id).attr("onclick","return check_status('"+id+"','0','"+user+"');");
	   }
	   document.getElementById("imgloader").style.display = "none";
	   return false;

	  },
	  error: function(x, t, m) {
         alert("Unable to connect.");	
		 document.getElementById("imgloader").style.display = "none";
		 return false;
      }
	  
	  });
}


function viewhistory(store)

{

	window.open("popup_freezehistory.php?store="+store,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	return false;

}
</script>

<body>

<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>
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

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td><form name="form1" id="form1" method="post" action="" >


                <table width="700" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Store List </strong></td>

                      </tr>

                      <tr>
					    <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3" width="10%"><strong>Sno</strong></td>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3" width="10%"><strong>Store Code</strong></td>

                        <td width="40%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Store Name</strong></td>
                        <td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Freeze</strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>History</strong></td>

                      </tr>

                      <?php

	    $query1 = "select * from master_store where recordstatus <> 'deleted' order by location";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$storecode = $res1['storecode'];

		$store = $res1["store"];

		$auto_number = $res1["auto_number"];
		$is_freeze = $res1["is_freeze"];

		if($is_freeze==1)
			$str="<font color='red'>Yes</font>";
		else
			$str="<font color='green'>No</font>";

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

		  

		?>

                      <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $storecode; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $store; ?> </td>

                        <td align="left" valign="top"  class="bodytext3">

						<a href="javascript:return false;" onclick="return check_status('<?php echo $auto_number ; ?>','<?php echo $is_freeze;?>','<?php echo $username;?>');" style="text-decoration:none" id="link-<?php echo $auto_number ; ?>"><?php echo $str;?></a>

						</td>

						<td align="left" valign="top"  class="bodytext3"><a href='javascript:return false;' onClick="javascript:viewhistory('<?php echo $auto_number ; ?>');" value="Map" accesskey="m">View</a></td>

                      </tr>

                      <?php

		}

		?>

                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>

               

              </form>

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



