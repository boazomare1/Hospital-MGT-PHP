<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$currentdate = date("Y-m-d");



   $docno = $_SESSION['docno'];







$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	$res12locationanum = $res["auto_number"];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;

$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$searchdocno=isset($_REQUEST['searchdocno'])?$_REQUEST['searchdocno']:"";

if($location!='')

{

	$locationcode=$location;

	}





if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

	

	 foreach($_POST['docno'] as $key => $value)

		{

		//echo 'key',$key;

		//echo 'descount',count($_POST['discard']);

		$docno=$_POST['docno'][$key];

		$disno=$key+1;

		//echo 'discad',$_POST['discard'.$disno];

		//echo '>',$_REQUEST['discard'][$key],'<';

		$dison=isset($_REQUEST['discard'.$disno])?$_REQUEST['discard'.$disno]:'';

		if($dison=='on')

		{

		$status='deleted';

		$query11 = "update stock_taking set recordstatus = '$status' where billnumber = '$docno'";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$status='';

		}

		}

 

		

}



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'PO-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='PO-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	$billnumbercode = 'PO-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ECF0F5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">





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

					

//ajax to get location which is selected ends here





function cbcustomername1()

{

	document.cbform1.submit();

}



</script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

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

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function loadprintpage1(banum)

{

	var banum = banum;

	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}





</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<body>



<?php 

$query1 = "select * from stock_taking where recordstatus='' group by billnumber";

        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

					$resnw1=mysqli_num_rows($exec1);

?>

<form name="form1" id="form1" method="post" action="stockvariance.php" onKeyDown="return disableEnterKey(event)">

<table width="103%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ECF0F5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ECF0F5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ECF0F5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td >

    <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                    <tr>

					  <td colspan="2" align="left" valign="middle"  bgcolor="#cccccc" class="bodytext3"><strong>Stock Variance Search by Location<strong>

					  <span id="date_time1" class="curdatt"></span><script type="text/javascript">date_time1('date_time1');</script></td>

                       <td width="168" colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

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

				    </tr>

                     <tr>

              <td width="188" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

               

               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">

                  <?php

						$docno = $_SESSION['docno'];

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

              </span></td>

			  <td bgcolor="#ffffff">&nbsp;</td>

              </tr>

			   <tr>

          <td width="92" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Doc No </strong></td>

          <td  width="194" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

		  <input type="text" name="searchdocno" id="searchdocno" value="<?php echo $searchdocno; ?>"  size="10" />

						</td>

          <td width="97" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"></td>

          <td width="143" align="left" valign="center"  bgcolor="#ffffff"></td>

		  

          </tr> 

                  <tr>

          <td width="92" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td  width="194" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="97" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="143" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

		  

          </tr> 

			 			

				<tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

                        </td>

                    </tr>

                  </tbody>

                </table>

    </td>

    		

				<tr>

                      <td align="left" valign="middle"  class="bodytext3">&nbsp;&nbsp;</td>

                     

                    </tr>

    </table>

    </form>

    <form name="frmsales" id="frmsales" method="post" action="stockvariance.php" onKeyDown="return disableEnterKey(event)">

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

            <tr>

             

              <td colspan="8" bgcolor="#cccccc" class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="left"><strong>Stock Variance </strong><label class="number"></label></div></td>

              </tr>

             <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				 <td width="17%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>

				<td width="20%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>DOC No</strong></div></td>

              <td width="23%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Store</strong></div></td>

				 <td width="23%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>By</strong></div></td>

				<td width="26%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>

                <td align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Excel</strong></div></td>

              	

              	<td width="26%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reviewed</strong></div></td>

                    

              </tr>

			<?php

			$colorloopcount = '';

			$sno = '';

			

			$query1 = "select * from stock_taking  where recordstatus=''AND billnumber like '%$searchdocno%' AND transactiondate between '$ADate1' and '$ADate2' AND location = '".$locationcode."' group by billnumber";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			while($res1=mysqli_fetch_array($exec1))

			{

			$date=$res1['transactiondate'];

			$docno=$res1['billnumber'];

			$store = $res1['store'];
			$username = $res1['username'];

			$query11 = "select store,storecode from master_store  where storecode = '".$store."' ";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));	

			$res11=mysqli_fetch_array($exec11);

			 $store = $res11['store'];

			 $storecode = $res11['storecode'];

			

			

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

				$colorcode = 'bgcolor="#CBDBFA"';

			} 

			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $date; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $docno; ?><input type="hidden" name="docno[]" id="docno" value="<?php echo $docno; ?>" /></div></td>

		        <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31" align="center"><?php echo $store; ?></div></td>

			     <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31" align="center"><?php echo strtoupper($username); ?></div></td>

				      <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><a href="variancereporting.php?docno=<?php echo $docno; ?>">View</a></div></td>

				<td class="bodytext31" valign="center"  align="left">

               <div class="bodytext31" align="center"><a href="stockvarianceexport.php?docno=<?php echo $docno; ?>" target="_blank"> Export</a></div></td>

			 	

			

             	<td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><input type="checkbox" disabled name="discard<?php echo $sno;?>" id="discard" /></div></td>

		

                </tr>

			  <?php

			}

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

			   <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

		  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

		  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>                

		

              </tr>

          </tbody>

        </table></td>

      </tr>

	  <tr>

	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

	  </tr>

<tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr>

              <td width="54%" align="center" valign="top" >

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

             	  <input name="Submit2223" type="submit" value="Submit " accesskey="b" class="button" style="border: 1px solid #001E6A;display:none"/>

               </td>

              

            </tr>

          </tbody>

        </table></td>

      </tr>

    </table>



</form>



<?php include ("includes/footer1.php"); ?>



</body>

</html>



