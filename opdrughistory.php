<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$snocount = "";
$colorloopcount="";
$searchsuppliername = "";
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_patientstatus.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["searchsuppliername"])) {$searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) {$searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) {$searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

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

.ui-menu .ui-menu-item{ zoom:1 !important; }
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>-->

<link href="autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<script type="text/javascript">
$(function() {
	//AUTO COMPLETE SEARCH FOR SUPPLIER NAME
$('#searchsuppliername').autocomplete({
		
	source:'ajaxpatientnewserach.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var supplier = this.id;
			var code = ui.item.id;
			var visitcode = ui.item.visit_id;
			var suppliername = supplier.split('suppliername');
			var suppliercode = suppliername[1];
			
			$('#searchsuppliercode').val(code);
			$('#searchvisitcode').val(visitcode);
			
			},
    });
});
</script>   

<script type="text/javascript">
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


/*window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}*/
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />     
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

<body>
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="opdrughistory.php">
		<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Drug History</strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
				
                <tr bgcolor="#011E6A">
                
               
                 <td colspan="8" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | ID/Digitika Card | Registration No   (*Use "|" symbol to skip sequence)</strong>
             
            
              </td></tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliercode" id="searchsuppliercode" value="" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  
              </span></td>
           </tr>
		   
						<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where   username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			  <input type="submit" value="Search" name="Submit" />
			  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <!-- <tr>
        <td>&nbsp;</td>
      </tr> -->
       <tr>
        <td>


        	
    		<?php
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			 
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					 $patientcode=$searchsuppliercode;
					?>
 
             <!-- <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="90%" align="center" border="0" style="margin: auto;">
 -->
             	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>

          <tbody  >
          	   <tr>
                <td align="center" colspan="9" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" > &nbsp; </td>
               </tr>  
           	<!-- <tr >
           		 
			   <td colspan="9" align="center" bgcolor="#ecf0f5" class="bodytext31"><strong><h2 style="color:blue;font-weight:bold;font-size:medium; text-decoration: underline;">Issued Drugs</h2></strong></td>
			       </td>

			  </tr> -->
            
             <!--   <tr>
                <td align="center" colspan="9" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium">&nbsp;</td>
               </tr>    --> 

              <?php
                $query601="SELECT * from master_consultationpharm where patientcode = '$patientcode' GROUP BY patientvisitcode order by auto_number desc";
                $exec601=mysqli_query($GLOBALS["___mysqli_ston"], $query601);
                $num601=mysqli_num_rows($exec601);
                while($res601=mysqli_fetch_array($exec601))
                {
                   $visitcode=$res601['patientvisitcode'];
                  // group by patientvisitcode
 
    $query1 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num1=mysqli_num_rows($exec1);
    
    while($res1 = mysqli_fetch_array($exec1))
    {
    //$patientname=$res1['patientfullname'];
    // $patientcode=$res1['patientcode'];
    // $visitcode=$res1['visitcode'];
    $consultationdate=$res1['consultationdate'];
    $accountname=$res1['accountfullname'];
    $username=$res1['username'];
    $patientsubtype =$res1['subtype'];
    $gender =$res1['gender'];
    $billtype = $res1['billtype'];
      $menusub=$res1['subtype'];
    }
    // if($num1==0){
    //         $query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
    //         $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
    //         $num1=mysql_num_rows($exec1);

    //         while($res1 = mysql_fetch_array($exec1))
    //         {
    //         //$patientname=$res1['patientfullname'];
    //         // $patientcode=$res1['patientcode'];
    //         // $visitcode=$res1['visitcode'];
    //         $consultationdate=$res1['consultationdate'];
    //         $accountname=$res1['accountfullname'];
    //         $username=$res1['username'];
    //         $patientsubtype =$res1['subtype'];
    //         $gender =$res1['gender'];
    //         $billtype = $res1['billtype'];
    //         $menusub=$res1['subtype'];
    //         }
    // }
    
    $query44 = "select * from master_customer WHERE customercode = '$patientcode' ";
    $exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num44 = mysqli_num_rows($exec44);
    $res44 = mysqli_fetch_array($exec44);    
    $patientname = $res44['customerfullname'];
    $dateofbirth=$res44['dateofbirth'];
    
    $querysub = "select * from master_subtype where auto_number='$patientsubtype'";
        $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], $querysub);
        $execsubtype=mysqli_fetch_array($querysubtype);
        $patientsubtype1=$execsubtype['subtype'];

      // $colorloopcount = $colorloopcount + 1;
      // $showcolor = ($colorloopcount & 1); 
      // if ($showcolor == 0)
      // {
      //   //echo "if";
      //   $colorcode = 'bgcolor="#CBDBFA"';
      // }
      // else
      // {
      //   //echo "else";
      //   $colorcode = 'bgcolor="#ecf0f5"';
      // }

        $query_salescheck = "select username from pharmacysales_details where visitcode='$visitcode' order by auto_number desc";
      $exec_salescheck=mysqli_query($GLOBALS["___mysqli_ston"], $query_salescheck);
      $num_salescheck=mysqli_num_rows($exec_salescheck);
      if($num_salescheck>0){
      ?>

       <tr>
                <td align="left" valign="middle"  bgcolor="#fffff" class="style1">Visit Date&nbsp;&nbsp;:&nbsp;&nbsp;<?=$consultationdate;?></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#fffff" class="style1">Visit No.&nbsp;&nbsp;:&nbsp;&nbsp;<?=$visitcode;?></td>
                <td align="right" colspan="4" valign="middle"  bgcolor="#fffff" class="style1">Visit Created By&nbsp;&nbsp;:&nbsp;&nbsp;<?=strtoupper($username);?></td>
                <!-- <td align="left" valign="middle"  bgcolor="#fffff" class="style1">&nbsp;</td> -->
              </tr>
          
    
         <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Units</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose.Measure</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
        <?php
        $colorloopcount=0;
        $query60="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
      $exec60=mysqli_query($GLOBALS["___mysqli_ston"], $query60);
      $num60=mysqli_num_rows($exec60);
      while($res60=mysqli_fetch_array($exec60))
       {
      $medicinecode1 = $res60['medicinecode'];
      $medicinename = $res60['medicinename'];
      $dose = $res60['dose'];
      $frequencyauto_number = $res60['frequencyauto_number'];
      $frequencycode = $res60['frequencycode'];
      $days = $res60['days'];
      $route = $res60['route'];
      $quantity = $res60['quantity'];
      $instructions = $res60['instructions'];
      // $res6username = $res60['username'];
      $dosemeasure = $res60['dosemeasure'];
      
      $query440 = "select username from pharmacysales_details where itemcode = '$medicinecode1' and visitcode='$visitcode' order by auto_number desc";
      $exec440=mysqli_query($GLOBALS["___mysqli_ston"], $query440);
      $num440=mysqli_num_rows($exec440);
      $res440=mysqli_fetch_array($exec440);
      $res44username = $res440['username'];
      $queryusername="select employeename from master_employee where username='$res44username'";
      $execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
      $resuser=mysqli_fetch_array($execuser);
      $employeename = $resuser['employeename'];
      if($num440!=0)
      {

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
      <tr <?php echo $colorcode;  ?> >
                <td align="left" colspan="2" valign="middle"  bgcolor="" class="bodytext3"><?php echo $medicinename.' - <strong>'.strtoupper($res44username).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $dosemeasure; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php }

          }
          ?>

          <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan='9'>&nbsp;</td>
      </tr>
      <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan='9'>&nbsp;</td>
      </tr>

      <!-- <?php
       // }else{ ?>
              <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" 
                bgcolor="#ecf0f5" colspan='8' style="color: red; font-size: 16px;">No Drugs Issued!</td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan='1'>&nbsp;</td>
      </tr>
      <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan='9'>&nbsp;</td>
      </tr> -->
       
       <?php   }
    }


       ?>

        <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan='9'>&nbsp;</td>
      </tr>
       

    
          </tbody>
        </table>
    <?php  } ?>
    </td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
