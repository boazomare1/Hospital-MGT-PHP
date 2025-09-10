<html>

<?php 

session_start();
$sno=0;
include ("db/db_connect.php"); ?>

<?php

$timeonly = date('H:i:s');

$updatedatetime = date('Y-m-d H:i:s');

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	$res12locationanum = $res["auto_number"];

$docno = $_SESSION['docno'];

//get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}

		

		

		//location get end here

$query1111 = "select * from master_employee where username = '$username'";

    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res1111 = mysqli_fetch_array($exec1111))

	{

	$locationnumber = $res1111["location"];

	$query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";

    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res1112 = mysqli_fetch_array($exec1112))

	{

		 $locationname = $res1112["locationname"];		  

		 $locationcode = $res1112["locationcode"];

	}

	}

if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}

if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}

if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}

if(isset($_POST['doctor'])){$searchdoctor = $_POST['doctor'];}else{$searchdoctor="";}

if(isset($_POST['ADate1'])){ $fromdate = $_POST['ADate1']; }else{$fromdate=$transactiondatefrom;}

if(isset($_GET['fromdate'])){
		$fromdate = $_GET['fromdate'];
	}
	if(isset($_GET['todate'])){
		$todate = $_GET['todate'];
	}

if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

?>

<style>

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

</style>

<script src="js/datetimepicker_css.js"></script>

<script>

function ajaxlocationfunction(val)

{ 

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

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

</script>

<body>

<table>

  <tr>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1145"><form name="cbform1" method="post" action="publishedlistiframe_intriagelist_popup.php">

          <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <!-- <tr>

                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient's Lab/Radiology Result List</strong></td>

                 <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php


						if ($location!='')

						{

						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

						

						

                  

                  </td>


              </tr> -->

              <!-- <tr>

                <td width="88" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"> -->

                  <!-- <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;"> -->

                  <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						?>

						<!-- <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option> -->

						<?php

						}

						?>

                  <!-- </select> -->

                <!-- </span></td> -->

              <!-- </tr> -->

              <!-- <tr>

                <td width="88" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>

                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                  <input name="patient" type="text" id="patient" value="" size="52" autocomplete="off">

                </span></td>

              </tr> -->

              <!-- <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Reg No</td>

                <td width="136" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                  <input name="patientcode" type="text" id="patient" value="" size="20" autocomplete="off">

                </span></td>

                <td width="58" align="left" valign="middle"  bgcolor="#FFFFFF"><span class="bodytext3">Visit No</span></td>

                <td width="286" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                  <input name="visitcode" type="text" id="visitcode" value="" size="19" autocomplete="off">

                </span></td>

              </tr> -->

             <!--  <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor</td>

                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input name="doctor" type="text" id="doctor" value="" size="20" autocomplete="off"></td>

              </tr> -->

			  <tr>

          <td width="88" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="150" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $fromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="58" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="286" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $todate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>
		  <td   align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                        <input  style="padding: 6px;" type="submit" value="Search" name="Submit" />

                        <!-- <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /> --></td>

                         <td    align="right" valign="top"  bgcolor="#FFFFFF" ><button onclick="window.close();" style="background-color: red; padding: 6px; " >Close</button> </td>

                        <?php if(isset($_GET['fromdate'])!=1){ ?>
                        <?php //if (strpos($_SERVER['REQUEST_URI'], "publishedlistiframe_intriagelist.php") != true){ ?>
                        <?php //if ($_SERVER['REQUEST_URI'] == 'publishedlistiframe_intriagelist.php'){ ?>


                        <!-- <td  width="136"  align="left" valign="top"  bgcolor="#FFFFFF" onclick="window.open('publishedlistiframe_intriagelist.php?ss=1&&fromdate=<?=$fromdate;?>&&todate=<?=$todate;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=800,directories=no,location=no');"><button>Full Screen</button> </td> -->
                    <?php } ?>

          </tr>

            <!--   <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                

              </tr> -->

            </tbody>

          </table>

        </form></td>

      </tr>

      <tr>

        <td><table width="98%" height="80" border="0" 

            align="left" cellpadding="2" cellspacing="0" 

            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >

          <tbody>

            <tr>

              <td class="bodytext31">&nbsp;</td>

            </tr>

            <tr>
            	<td width="2%"  align="left" valign="center" 

			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> 
			</strong></div></td>

              <td width="49%"  align="left" valign="center" 

			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient</strong></div></td>

              <td width="32%"  align="left" valign="center" 

			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>

              <td width="18%"  align="left" valign="center" 

			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor </strong></div></td>

            </tr>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <script type="text/javascript">
// 			$(".res").on("click","p",function(e) {
//     e.preventDefault();
//     $(this).closest("tr").nextUntil(".open").toggleClass("open");
// });

// 			$("#press").click(function(){
//   $(".res").show();
// });

// $("#show").click(function(){
//   $("p").show();
// });
		</script>
<!-- 		<script>
$(document).ready(function(){
  $("#press").click(function(){
    $(".res").toggleClass();
  });
});
</script> -->
<script>
function HideFunction(id) {
	var i =  id;
	// var i =  document.getElementById("sno");
	// for(i=1;i<=j;i++){
		  var x = document.getElementById("res"+i);
		  if (x.style.display === "none") {
		    x.style.display = "block";
		  } else {
		    x.style.display = "none";
		  }
		// }
}
</script>
<style type="text/css">
	.hidethe{
		display: none;
	}
</style>


            <?php

			

			$colorloopcount = '';

			$sno = '';

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

						

		

		$query11 = "select Distinct recorddate as recdate from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit = '' and recorddate between '$fromdate' and '$todate' and locationcode='$locationcode' group by patientvisitcode,recorddate order by auto_number desc";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		

		while($res11 = mysqli_fetch_array($exec11))

		{

		$res11recorddate=$res11['recdate'];

		

		if( $res11recorddate != '')

		{

		?>

           <?php 

			 $query121 = "select distinct recorddate as rdate from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit = '' and recorddate = '$res11recorddate' and locationcode='$locationcode'  group by patientvisitcode,recorddate order by auto_number desc";

			$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res121 = mysqli_fetch_array($exec121))

			{

		     $res121recorddate = $res121['rdate'];

			 if($res121recorddate != '')

			  {

			?>

			<tr bgcolor="#ecf0f5">

            <td colspan="14"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res11recorddate;?></strong></td>

            </tr>

		<?php } } ?>

		

            <?php

		}	

					

		$query1 = "select * from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit = '' and recorddate = '$res11recorddate'  group by patientvisitcode,recorddate and locationcode='$locationcode' order by auto_number desc";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		

		$res1patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$visitcode=$res1['patientvisitcode'];

		$accountname = $res1['accountname'];

		$requestedbyname = $res1['username'];

		

		

		$query43 = "select * from master_visitentry where visitcode='$visitcode' and locationcode='$locationcode'";

		$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res43 = mysqli_fetch_array($exec43);

		$opdate = $res43['consultationdate'];

		$dept = $res43['departmentname'];

		$patientname = $res43['patientfirstname'];

		$age = $res43['age'];

		$gender = $res43['gender'];


				

			$query21 = "select * from master_consultationlist where visitcode='$visitcode' and locationcode='$locationcode' order by auto_number";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num21 = mysqli_num_rows($exec21);

			

			$res21 = mysqli_fetch_array($exec21);

			$consultationdatetime = $res21['consultationdate'];

			$consultationdatetime2 = strtotime($consultationdatetime);

		    $consultationdatetime1 = strtotime($consultationdatetime . ' + 1 day');

			$updatedatetime1 = strtotime($updatedatetime);

			

						

			$consultationdate1 = date('Y-m-d', $consultationdatetime2);

			

						
			$sno+=1;
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

            <tr onclick="HideFunction(<?=$sno;?>)" style="cursor: pointer; size: unset; size: 30px;" <?php echo $colorcode; ?>>
            	<td  class="bodytext31" valign="center"  align="left"><?=$sno;?></td>

              <td class="bodytext31" valign="center"  align="left"><div align="left"> <strong style="size: unset; size: 20px;"><?php echo $res1patientname; ?> (<?php echo $patientcode; ?>,<?php echo $visitcode; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong> </div></td>

              <td class="bodytext31" valign="center"  align="left"><p ><?php echo $dept; ?></p></td>

              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $requestedbyname;?></div></td>


            </tr>
            
           
            
           
            <tr >
            	<td></td>
            	<td></td>
            	 <td  class="hidethe" id="res<?=$sno;?>" class="bodytext31" valign="center"  align="center"><iframe id="preconsultation" src="preconsultationresultsview_iframe.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&date=<?php echo $consultationdatetime; ?>&&name=<?php echo $res1patientname;?>" width="500" height="140" scrolling="" frameborder="0"> </iframe></td>
            	 <td></td>
            </tr>
            <input type="hidden" value="<?=$sno;?>" id="sno" name="sno">

            <?php
			}  

		 }	  
		?>
            <tr>

              <td colspan="4" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            </tr>

          </tbody>

        </table></td>

      </tr>

    </table></td>

  </tr>

</table>

</body>

</html>