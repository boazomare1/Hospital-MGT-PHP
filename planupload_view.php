<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
     $locationname  = $res["locationname"];
      $locationcode123 = $res["locationcode"];
      $locationcode = $res["locationcode"];
     $res12locationanum = $res["auto_number"];


///////////////////// update //////// update ////////
if(isset($_POST['submit_but'])){

  if(isset($_POST['planname'])!=''){

    foreach($_POST['accountid'] as $key => $value)
    {


        $maintypeanum = $_POST['maintypeanum'][$key];
        $subtypeanum = $_POST['subtypeanum'][$key];
        $accountid = $_POST['accountid'][$key];
        $planname = $_POST['planname'][$key];
        $planstatus = $_POST['planstatus'][$key];
        $copayamount = $_POST['copayamount'][$key];
        $copaypercentage = $_POST['copaypercentage'][$key];
        $forall = $_POST['forall'][$key];
        $limit_status = $_POST['limit_status'][$key];
        $smartap = $_POST['smartap'][$key];
        $overalllimitop = $_POST['overalllimitop'][$key];
        $opvisitlimit = $_POST['opvisitlimit'][$key];
        $overalllimitip = $_POST['overalllimitip'][$key];
        $ipvisitlimit = $_POST['ipvisitlimit'][$key];
        $departmentlimit = $_POST['departmentlimit'][$key];
        $pharmacylimit = $_POST['pharmacylimit'][$key];
        $lablimit = $_POST['lablimit'][$key];
        $radiologylimit = $_POST['radiologylimit'][$key];
        $serviceslimit = $_POST['serviceslimit'][$key];
        // $planapplicable = $_POST['planapplicable'][$key];
          $expirydate = $_POST['expirydate'][$key];

          $plancondition='';
          $planapplicable='';
                                    $recordstatus='ACTIVE';
                                    $exclusions='';


   
            $planname1=trim($planname);

        $query1 = "INSERT into master_planname (maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,

        overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit,limit_status, locationname, locationcode) 

        values ('$maintypeanum', '$subtypeanum', '$accountid', '$planname1', '$planstatus', '', '$copayamount',  '$copaypercentage', 

        '$overalllimitop','$overalllimitip', '$opvisitlimit','$ipvisitlimit', '$smartap', '$recordstatus','$ipaddress', '$updatedatetime', '$username', '".$updatedate."', '$expirydate','$exclusions','".$forall."','$planapplicable','$departmentlimit','$pharmacylimit','$lablimit','$radiologylimit','$serviceslimit','$limit_status', '$locationname', '$locationcode')";
                    
                    $execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

     $medicinequery23="TRUNCATE TABLE `planupload_temp`";
     // master_accountname
                    $execquery23=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    // echo "<script>window.close();</script>";
                    echo "<script>window.close();window.opener.location = 'debtorsupload.php';</script>";
                    // echo "<script>window.location.href = 'debtorsupload.php'</script>";
}else{
     // echo "<script>window.close();</script>";
                    echo "<script>window.close();window.opener.location = 'debtorsupload.php';</script>";

        // echo "<script>window.location.href = 'debtorsupload.php'</script>";
}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['submit_truncate'])){
$medicinequery23="TRUNCATE TABLE `planupload_temp`";
                    $execquery23=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                     echo "<script>window.close();window.opener.location = 'debtorsupload.php';</script>";
                    // echo "<script>window.location.href = 'debtorsupload.php'</script>";
}                   
                 
//////////////////////////////////////////////////////////////// END OF update  /////////////////////

?>
<style type="text/css">
<!--
body {
    margin-left: 0px;
    margin-top: 0px;
    background-color: #ecf0f5;
}
.bodytext3 {    FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function validcheck()
{
    
    // alert(idsubm);
    var a = $('#upload_file').val();
    
    if ((a=="") ) 
    {
         alert('Select Excel file to Upload');
         return false;
    } 
    // if(confirm("Do you Want to Upload the File?")==false){return false;} 
}

 

function FuncPopup()
{
    window.scrollTo(0,0);
    document.getElementById("imgloader").style.display = "";
    // display.time(0,30);

}


function acknowledgevalid1()
{
  // document.getElementById("submit0").disabled=true; 
  
  var alert1;
    alert1 = confirm('Are you sure, want to Discard?');
    //alert(fRet);
    if (alert1 == true)
    {
        FuncPopup();
            document.form2.submit();
    }
    if (alert1 == false)
    {
        // alert ("Sub Type Entry Delete Not Completed.");
        return false;
    }
}


function acknowledgevalid()
{
   var alert1;
    alert1 = confirm('Are you sure! want to Save Data?');
    //alert(fRet);
    if (alert1 == true)
    {
        FuncPopup();
            document.form1.submit();
    }
    if (alert1 == false)
    {
        // alert ("Sub Type Entry Delete Not Completed.");
        return false;
    }
}


function funcDeleteSubType(varSubTypeAutoNumber)
{
 var varSubTypeAutoNumber = varSubTypeAutoNumber;
    var fRet;
    fRet = confirm('Are you sure want to delete this account name '+varSubTypeAutoNumber+'?');
    //alert(fRet);
    if (fRet == true)
    {
        alert ("Sub Type Entry Delete Completed.");
        //return false;
    }
    if (fRet == false)
    {
        alert ("Sub Type Entry Delete Not Completed.");
        return false;
    }

}


</script>

<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
<body>
<!-- ajax loader -->
<div align="center" class="imgloader" id="imgloader" style="display:none;">
    <div align="center" class="imgloader" id="imgloader1" style="display:;">
        <p style="text-align:center;"><strong>Processing <br><br> Please be Patient...</strong></p>
        <img src="images/ajaxloader.gif">
    </div>
</div>

<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <!-- <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php //include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php //include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php //nclude ("includes/menu1.php"); ?></td>
  </tr> -->
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
              <td>
                <?php
                    $query_1 = "SELECT * from planupload_temp ";
                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows=mysqli_num_rows($exec_1);
                ?>
                <form name="form1" id="form1" method="post">

                 
                <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr >
                        <td colspan="22"  bgcolor="#FFFFFF" class="bodytext3"><span style="text-align: left;">No. of Plan Names to upload :  <?=$no_of_rows;?></span></td>
                      </tr>
                       <tr bgcolor="#011E6A">
                        <td colspan="22" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name Master View </strong></td>
                      </tr>
                      <tr bgcolor="#ffaa00"> 

                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                            
                        <td width="13%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><strong>Main Type
                        </strong></span></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Sub Type </strong></td>
                        <!-- <td width="10%" align="left" valign="top"  class="bodytext3"><strong>Account ID</strong></td> -->
                        <td align="left" valign="top"  class="bodytext3"><strong>Account Name</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Plan Name</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Plan Status (OP+IP/OP/IP)</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Copay Amount</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Copay Percentage</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>All(Yes/No)</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Limit Status (Overall/Visit)</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Smart Applicable (Yes/No)</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Overall OP Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Visit OP Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Overall Ip Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Visit IP Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Department Limit (Yes/No)</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Pharmacy Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Lab Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Radiology Limit</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Services Limit</strong></td>
                        <!-- <td align="left" valign="top"  class="bodytext3"><strong>Family Plan Limits (Yes/No)</strong></td> -->
                        <td align="left" valign="top"  class="bodytext3"><strong>Validity End</strong></td>
                        <!-- <td align="left" valign="top"  class="bodytext3"><strong>Name</strong></td> -->
                       
                         
                      </tr>
                     <?php    
                     $limit_status_check=0;
        $query1 = "SELECT * from planupload_temp ";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res1 = mysqli_fetch_array($exec1))
        { 
            $y1=0;
                     $y2=0;
                     $x1=0;
                     $x2=0;

                     $a1=0;
                     $a2=0;
                     $a3=0;
                     $a4=0;
                     

        $maintypeanum = $res1['maintype'];
        $subtypeanum = $res1['subtype'];
        $accountid = $res1['accountname'];
        $planname = $res1['planname'];
        $planstatus = $res1['planstatus'];
        $copayamount = $res1['planfixedamount'];
        $copaypercentage = $res1['planpercentage'];
        $forall = $res1['forall'];
        $limit_status = $res1['limit_status'];
        $smartap = $res1['smartap'];
        $overalllimitop = $res1['overalllimitop'];
        $opvisitlimit = $res1['opvisitlimit'];
        $overalllimitip = $res1['overalllimitip'];
        $ipvisitlimit = $res1['ipvisitlimit'];
        $departmentlimit = $res1['departmentlimit'];
        $pharmacylimit = $res1['pharmacylimit'];
        $lablimit = $res1['lablimit'];
        $radiologylimit = $res1['radiologylimit'];
        $serviceslimit = $res1['serviceslimit'];
        // $planapplicable = $res1['planapplicable'];
          $expirydate = $res1['planexpirydate'];



          $query31 = "SELECT accountname, subtype from master_planname where `maintype`='$maintypeanum' and `subtype`='$subtypeanum' and `accountname`='$accountid' and `planname`='$planname' and `planfixedamount`='$copayamount' and `planpercentage`='$copaypercentage' and `overalllimitop`='$overalllimitop' and `opvisitlimit`='$opvisitlimit' and`recordstatus`='ACTIVE' and `planexpirydate`='$expirydate' and `forall`='$forall' and `planstatus`='$planstatus' and `overalllimitip`='$overalllimitip' and `ipvisitlimit`='$ipvisitlimit' and `smartap`='$smartap' and `lablimit`='$lablimit' and `radiologylimit`='$radiologylimit' and `serviceslimit`='$serviceslimit' and `pharmacylimit`='$pharmacylimit' and `departmentlimit`='$departmentlimit' and `limit_status`='$limit_status'
          ";
        $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $abc=mysqli_num_rows($exec31);
        $res31 = mysqli_fetch_array($exec31);


        ?>
         <input type="hidden" name="maintypeanum[]" value="<?=$maintypeanum?>" >
         <input type="hidden" name="subtypeanum[]" value="<?=$subtypeanum?>" >
         <input type="hidden" name="accountid[]" value="<?=$accountid?>" >
         <input type="hidden" name="planname[]" value="<?=$planname?>" >
         <input type="hidden" name="planstatus[]" value="<?=$planstatus?>" >
         <input type="hidden" name="copayamount[]" value="<?=$copayamount?>" >
         <input type="hidden" name="copaypercentage[]" value="<?=$copaypercentage?>" >
         <input type="hidden" name="forall[]" value="<?=$forall?>" >
         <input type="hidden" name="limit_status[]" value="<?=$limit_status?>" >
         <input type="hidden" name="smartap[]" value="<?=$smartap?>" >
         <input type="hidden" name="overalllimitop[]" value="<?=$overalllimitop?>" >
         <input type="hidden" name="opvisitlimit[]" value="<?=$opvisitlimit?>" >
         <input type="hidden" name="overalllimitip[]" value="<?=$overalllimitip?>" >
         <input type="hidden" name="ipvisitlimit[]" value="<?=$ipvisitlimit?>" >
         <input type="hidden" name="departmentlimit[]" value="<?=$departmentlimit?>" >
         <input type="hidden" name="pharmacylimit[]" value="<?=$pharmacylimit?>" >
         <input type="hidden" name="lablimit[]" value="<?=$lablimit?>" >
         <input type="hidden" name="radiologylimit[]" value="<?=$radiologylimit?>" >
         <input type="hidden" name="serviceslimit[]" value="<?=$serviceslimit?>" >
         <input type="hidden" name="expirydate[]" value="<?=$expirydate?>" >
         <!-- <input type="hidden" name="planapplicable[]" value="<?=$planapplicable?>" > -->
        <?php


      

        // if($planapplicable==1){
        //     $planapplicable='Yes';
        // }else{
        //     $planapplicable='No';
        // }

        if($limit_status=='Overall'){
             if(($opvisitlimit!='0')){
                $x1=1;
                $limit_status_check+=1;
                }
            if($ipvisitlimit!="0.00"){
                $x2=1;
                $limit_status_check+=1;
            }
         }
         if($limit_status=='Visit'){
            if(($overalllimitop!='0') ){
                $y1=1;
                $limit_status_check+=1;
            }
            if($overalllimitip!='0.00'){
                $y2=1;
                $limit_status_check+=1;
            }
         }

         if($departmentlimit=='yes'){
                if($pharmacylimit!='0.00'){
                            $a1=1;
                            $limit_status_check+=1;
                        }
                        if($lablimit!='0.00'){
                            $a2=1;
                            $limit_status_check+=1;
                        }
                        if($radiologylimit!='0.00'){
                            $a3=1;
                            $limit_status_check+=1;
                        }
                        if($serviceslimit!='0.00'){
                            $a4=1;
                            $limit_status_check+=1;
                        }
         }

        //  if($x==0){
        //     $colorcode_status = 'bgcolor="pink"';
        // }
        

        $query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $paymenttype = $res2['paymenttype'];

        $query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res3 = mysqli_fetch_array($exec3);
        $subtype = $res3['subtype'];

        $query4 = "select * from master_accountname where auto_number = '$accountid'";
        $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res4 = mysqli_fetch_array($exec4);
        $accountname = $res4['accountname'];

        // $query31 = "select accountname, subtype from master_accountname where accountname = '$accountname'";
        // $exec31 = mysql_query($query31) or die ("Error in Query3".mysql_error());
        // $x=mysql_num_rows($exec31);
        // $res31 = mysql_fetch_array($exec31);
        // $dublicate_subtype = $res31['subtype'];

        // $query32 = "select * from master_subtype where auto_number = '$dublicate_subtype'";
        // $exec32 = mysql_query($query32) or die ("Error in Query3".mysql_error());
        // $res32 = mysql_fetch_array($exec32);
        // $dublicate_subtype_name = $res32['subtype'];


    
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

        if($abc>0){
            $colorcode = 'bgcolor="pink"';
            $limit_status_check+=1;
        }

        // $query23 = "SELECT * from debtorsupload_temp order by auto_number desc limit 0, 1";
        //             $exec23= mysql_query($query23) or die ("Error in Query2".mysql_error());
        //             $res23 = mysql_fetch_array($exec23);
        //             $subtype12 = $res23["subtype"];
        //             $paymenttype12 = $res23["paymenttype"];

                    // if(($paymenttype12==$maintype) or ($subtype12==$subtype)){
                    //                          $view_true=1;
                    //                          }
          
        ?>
                 <tr  <?php echo $colorcode;  ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
                        <?=$colorloopcount;?>
                        </div></td>
                        <td align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $paymenttype; ?></span></td>
                        <td width="12%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $subtype; ?></span></td>
                         <td width="17%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $accountname; ?></span></td>

                      <td align="left" valign="top"  class="bodytext3"><?php echo $planname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planstatus; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $copayamount; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $copaypercentage; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $forall; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $limit_status; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $smartap; ?></td>
                        <td <?php if($y1==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $overalllimitop; ?></td>
                        <td <?php if($x1==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $opvisitlimit; ?></td>
                        <td <?php if($y2==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $overalllimitip; ?></td>
                        <td <?php if($x2==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $ipvisitlimit; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $departmentlimit; ?></td>
                        <td <?php if($a1==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $pharmacylimit; ?></td>
                        <td <?php if($a2==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $lablimit; ?></td>
                        <td <?php if($a3==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $radiologylimit; ?></td>
                        <td <?php if($a4==1){ echo'bgcolor="pink"'; }  ?> align="left" valign="top"  class="bodytext3"><?php echo $serviceslimit; ?></td>
                        <!-- <td align="left" valign="top"  class="bodytext3"><?php //echo $planapplicable; ?></td> -->
                        <td align="left" valign="top"  class="bodytext3"><?php echo $expirydate; ?></td>
                        



                        
                        
                      </tr>
                      <?php
        }
        ?>
        <tr bgcolor="#011E6A">
                        <td colspan="22" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                      </tr>
        <tr>
            <td colspan="29" width="1002"align="center" valign="top">
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                 <input name="submit_but" type="submit" id="submit0" value="Submit " onclick="return acknowledgevalid();" accesskey="b" class="button" style="border: 1px solid #001E6A; background-color: lightblue; cursor: pointer;" <?php if($limit_status_check>0){ echo "disabled"; } ?>/>
             </font>
            </td>
        </tr>
        </form>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                      <tr>
                            <form method="POST" name="form2" id="form2" >
                            <td colspan="20" width="1002"align="left" valign="top">
                                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                                <input name="submit_truncate" type="submit" id="submit1" value="Discard " onclick="return acknowledgevalid1();" accesskey="b" class="button" style="border: 1px solid #001E6A; background-color: red; cursor: pointer; margin-left: 50px;" />
                                </font>
                                </td>
                 
                                </form>
                      </tr>
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

