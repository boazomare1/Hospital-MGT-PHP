<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username=$_SESSION['username'];
$docno = $_SESSION['docno'];
$updatedatetime = date('Y-m-d H:i:s');
$thistime=date('H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018="select auto_number from master_location where locationcode='$main_locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];


if (isset($_POST["searchflag1"])) { $searchflag1 = $_POST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$query1111 = "select locationname,locationcode from login_locationdetails where username = '$username' and docno='$docno' order by auto_number desc";
$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1111 = mysqli_fetch_array($exec1111);
$locationname = $res1111["locationname"];
$locationcode = $res1111["locationcode"];			   	
	
$query3 = "select * from bill_formats where description = 'petty_cash'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];	
	
	//$paynowbillprefix = 'PT-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pcrequest  order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["doc_no"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	//$billnumbercode ='PT-'.'1';
	$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["doc_no"];
	$maxcount=split("-",$billnumber);
		$maxcount1=$maxcount[1];
		$maxanum = $maxcount1+1;
		
		
	$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
	/*$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PT-' .$maxanum;*/
	$openingbalance = '0.00';
	
}
$docno1 = $billnumbercode;
	$docno = $_REQUEST["docno"];
	$ADate1 = $_REQUEST["ADate1"];
	$amount = $_REQUEST["amount"];
	$remarks = $_REQUEST["remarks"];
	if(($amount!="")&&($amount!='')){
	
	$query=" insert into pcrequest (doc_no,currentdate,amount,remarks,ipaddress,username,delete_status,record_time,record_date,approvedby,locationname,locationcode) values('$docno1','$ADate1','$amount','$remarks','$ipaddress','$username','','$thistime','$updatedatetime','$username','$locationname','$locationcode')";
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	
	 $errmsg = "Success. New Lab Item Updated.";
			$bgcolorcode = 'success';
	}
        
			else{
				$errmsg = "Failed.";
		$bgcolorcode = 'failed';
				}
				header("location:pcrequest.php?st=success");

}
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];

	$query3 = "update pcrequest set delete_status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}

if ($st == 'activate')
{  
	$delanum = $_REQUEST["anum"];
	$query3 = "update pcrequest set delete_status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	//exit;
}

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

$( document ).ready(function() {
$("#amount").keyup(function(){
var values = $('#amount').val();
var number1=values.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",");

//alert(number1);
$('#amount1').html(number1);
//document.getElementById('amount1').html(values); 
});
  
});
function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.amount.value == "")
	{	
		alert ("Please Enter Amount.");
		document.form1.amount.focus();
		return false;
	}
		if (document.form1.remarks.value == "")
	{	
		alert ("Please Enter Remark.");
		document.form1.remarks.focus();
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
	var suss=document.getElementById('submi').value;
	if(suss){
	//window.location.reload();
	}
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
function reenter()
{
	$(':input[type="submit"]').prop('readonly', true);
	window.location.reload();
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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
         <?php if(isset($_REQUEST['st'])) { $st = $_REQUEST['st']; } else { $st = ""; } 
					  if($st == 'success') { ?>
					  <tr>
                        <td colspan="4" bgcolor="#00FF33" align="left" valign="middle" class="bodytext3"><div align="left" style="font-size:12px"><center><strong><?php echo "Request is Saved"; ?></center></strong></div></td>
                      </tr>
					  <?php } ?>
            <tr>
              <td><form name="form1" id="form1" method="post" action="pcrequest.php" onSubmit="return additem1process1()">
                  <table  width="860" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody >
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext31"><strong>Petty Cash Request-Add New </strong></td>
                      </tr>
					
                      
                      
                      <tr bgcolor="#FFFFFF">
                      <?php 
						
						/*$arr=explode('-',$doc);
						$first=$arr[1];
						$as=array($arr[0],$arr[1]+1);
						$ar=implode('-',$as);*/
$query3 = "select * from bill_formats where description = 'petty_cash'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
//$paynowbillprefix = 'PT-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pcrequest  order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["doc_no"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	//$billnumbercode ='PT-'.'1';
	$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["doc_no"];
	
	$maxcount=split("-",$billnumber);
		$maxcount1=$maxcount[1];
		$maxanum = $maxcount1+1;
		
		
	$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
	/*$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PT-' .$maxanum;*/
	$openingbalance = '0.00';
	
}
$docno1 = $billnumbercode;

						
							?>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"> <div align="left">Request No</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="docno"  id="docno" value="<?php echo $docno1 ; ?>" readonly onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20" maxlength="100" />
                         </td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31">Date</td>
                       <td width="137" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo date('Y-m-d'); ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','','','','','','future')" style="cursor:pointer"/>			</td>
                      </tr>
                      <tr bgcolor="#00FF33">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><div align="left">Amount</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"  ><input name="amount" type="test" id="amount" style="border: 1px solid #001E6A"  size="20" value="" ></td>
                         <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><div align="left">User Name</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"  ><input name="user" type="test" id="user" style="border: 1px solid #001E6A"  size="20" value="<?php echo $username;  ?>" readonly ></td>
                     
                      </tr> 
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><div align="left">Remarks</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"  >
                        <textarea id="remarks" name="remarks"></textarea>
                        </td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><div align="left"></div></td>
                        <td align="left" valign="top" style="    font-size: 36px;
    font-weight: bold;" bgcolor="#FFFFFF"  >
                       <span id="amount1"> 
					   
					   </span>
                        </td>
                     
						
                      </tr>
					  
					
				
				 
					<tr>
                        <td width="21%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                        <td width="37%" colspan="3"  valign="top"  bgcolor="#FFFFFF" align="right"><input type="hidden" name="frmflag" value="addnew" />
                          <input type="hidden" name="frmflag1" value="frmflag1" />
						  <?php
							 $querry="SELECT docno,entrydate,ledgerid,ledgername,transactionamount,username from master_journalentries where username like '%$username%' and disbursstatus='pending' and docno like 'PCA-%' ORDER BY `docno` desc ";
							// $exe=mysql_query($querry);
							$exec = mysqli_query($GLOBALS["___mysqli_ston"], $querry) or die ("Error in Querry".mysqli_error($GLOBALS["___mysqli_ston"]));
							 $exenumrows = mysqli_num_rows($exec);
							if($exenumrows ==0){
						  ?>
							 <input type="submit" name="Submit" id="submi" value="Save" style="border: 1px solid #001E6A" onClick="return reenter()" /></td>
						  <?php
							}else{
								echo '<p style="color:red;"> <strong > Please complete pending allocation. </strong> </p>';
							}
						  ?>
                        <!-- <td width="14%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td> -->
                        <!-- <td width="28%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td> -->
                      </tr>
                    </tbody>
                  </table>
				  </form>
				  
				  <form>
                <table width="860" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
					   <tr bgcolor="#011E6A">
							<td colspan="8" bgcolor="#ecf0f5"   align="right">
								
							</td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31"><strong>Petty Cash Request - Existing List - Latest 100 Petty cash items </strong></span></td>
						<td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
						<?php //error_reporting(0);
						if($searchflag1 != 'searchflag1'){
							$tbl_name="pcrequest";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from pcrequest where delete_status <> 'deleted' group by doc_no order by auto_number desc";
							$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res111 = mysqli_fetch_array($exec111);
							$total_pages = mysqli_num_rows($exec111);
												
							/*$query = "SELECT * FROM $tbl_name";
							$total_pages = mysql_fetch_array(mysql_query($query));
							echo $numrow = mysql_num_rows($total_pages);*/
							
							/* Setup vars for query. */
							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)
							$limit = 50; 								//how many items to show per page
							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
							if($page) 
								$start = ($page - 1) * $limit; 			//first item to display on this page
							else
								$start = 0;								//if no page var is given, set start to 0
							
							/* Setup page vars for display. */
							if ($page == 0) $page = 1;					//if no page var is given, default to 1.
							$prev = $page - 1;							//previous page is page - 1
							$next = $page + 1;							//next page is page + 1
							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;						//last page minus 1
							
							/* 
								Now we apply our rules and draw the pagination object. 
								We're actually saving the code to a variable in case we want to draw it more than once.
							*/
							$pagination = "";
							if($lastpage >= 1)
							{	
								$pagination .= "<div class=\"pagination\">";
								//previous button
								if ($page > 1) 
									$pagination.= "<a href=\"$targetpage?page=$prev\" style='color:#3b3b3c;'>previous</a>";
								else
									$pagination.= "<span class=\"disabled\">previous</span>";	
								
								//pages	
								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
								{	
									for ($counter = 1; $counter <= $lastpage; $counter++)
									{
										if ($counter == $page)
											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
										else
											$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
									}
								}
								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
								{
									//close to beginning; only hide later pages
									if($page < 1 + ($adjacents * 2))		
									{
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						?>
						</span></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="8" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>
                        </tr>
                      <tr bgcolor="#011E6A">
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong>Delete</strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext31"><strong>Date</strong></td>
                        <td width="10%" bgcolor="#ecf0f5" class="bodytext31"><strong>Request No.</strong></td>
						<td width="10%" align="right" bgcolor="#ecf0f5" class="bodytext31"><strong>Amount</strong></td>
                          <td width="24%" align="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Remarks</strong></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext31"><strong>Request by</strong></td>
                        
                      </tr>
                      <?php  
					  $query7=" select * from pcrequest where delete_status <>'deleted' and (approved_status<>1 and approved_status<>2 and approved_status<>3 and approved_status<>4 and approved_status<>6) and username = '$username'  order by auto_number desc ";
						$exe1=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
						$sno=0;
						while($data=mysqli_fetch_array($exe1))
						{
							$sno=$sno+1;
						$auto_number=$data['auto_number'];	
						$doc=$data['doc_no'];
						$currentdate=$data['currentdate'];
						$amount=$data['amount'];
						$remarks=$data['remarks'];	
					  $username1=$data['username']; 
					   ?>
                       <tr>
                       
                       <td align="left" valign="top" bgcolor="FFFFFF"   class="bodytext31"><div align="center"><a href="pcrequest.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
					
						<td align="left" valign="top" bgcolor="FFFFFF"   class="bodytext31"><?php echo $currentdate; ?> </td>
                        <td align="left" valign="top" bgcolor="FFFFFF"   class="bodytext31"><?php echo $doc; ?> </td>
						<td align="right" valign="top"bgcolor="FFFFFF"   class="bodytext31"><?php echo number_format($amount,2,'.',','); ?> </td> 
						<td align="center" valign="top"bgcolor="FFFFFF"   class="bodytext31"><?php echo $remarks; ?> </td>
						<td align="left" valign="top"bgcolor="FFFFFF"   class="bodytext31"><?php echo ucwords($username1); ?> </td>
                       
                       </tr>
                       
                       
                       
                       
                     <?php } ?>
                    </tbody>
                  </table>
				  </form>
				  <br>
				  
 				  <form>
                <table width="860" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="17" bgcolor="#ecf0f5" class="bodytext31"><strong>Petty Cash Management - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="17" bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext32">
                          <input name="search2" type="text" id="search2" size="40">
                          <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
                          <input type="submit" name="Submit22" value="Search" style="border: 1px solid #001E6A" />
                        </span></td>
                        </tr>
                      <tr bgcolor="#011E6A">
						<td width="6%" bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong>Activate</strong></div></td>
						<td width="10%" bgcolor="#ecf0f5" class="bodytext31"><strong>Date </strong></td>
						<td width="10%" bgcolor="#ecf0f5" class="bodytext31"><strong>Request No.</strong></td>
						<td width="10%" align="right" bgcolor="#ecf0f5" class="bodytext31"><strong>Amount</strong></td>
                          <td width="24%" align="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Remarks</strong></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext31"><strong>Request by</strong></td>
                       
					 
                      </tr>
                      <?php  
					  $query7=" select * from pcrequest where delete_status ='deleted' and username = '$username' order by doc_no desc ";
						$exe1=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
						$sno=0;
						while($data=mysqli_fetch_array($exe1))
						{
							$sno=$sno+1;
						$auto_number=$data['auto_number'];	
						$doc=$data['doc_no'];
						$currentdate=$data['currentdate'];
						$amount=$data['amount'];
						$remarks=$data['remarks'];	
					  $username=$data['username']; 
					   ?>
                       <tr>
                       <td align="left" valign="top"  bgcolor="FFFFFF" class="bodytext31">
                        <a href="pcrequest.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                        <div align="center" class="bodytext31">Activate</div>
                        </a></td>
                       <td align="left" valign="top" bgcolor="FFFFFF"  class="bodytext31"><?php echo $currentdate; ?> </td>
                       <td align="left" valign="top" bgcolor="FFFFFF"  class="bodytext31"><?php echo $doc; ?> </td>
						<td align="right" valign="top" bgcolor="FFFFFF"  class="bodytext31"><?php echo number_format($amount,2,'.',','); ?> </td> 
						<td align="center" valign="top" bgcolor="FFFFFF"  class="bodytext31"><?php echo $remarks; ?> </td>
						<td align="left" valign="top" bgcolor="FFFFFF"  class="bodytext31"><?php echo ucwords($username); ?> </td>
                        </tr>
                     <?php } ?>
                      <tr>
                        <td colspan="11" align="middle" >&nbsp;</td>
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

