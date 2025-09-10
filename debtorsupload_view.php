<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
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

  if(isset($_POST['accountname'])!=''){

    foreach($_POST['accountname'] as $key => $value)
    {
        $accountname=$_POST['accountname'][$key];
        $paymenttype=$_POST['paymenttype'][$key];
        $subtype=$_POST['subtype'][$key];
        $expirydate=$_POST['expirydate'][$key];
        $accountsmain=$_POST['accountsmain'][$key];
        $accountssub=$_POST['accountssub'][$key];
        $currency=$_POST['currency'][$key];


        
        //////////// FOR ID GENERATE ///////////////////

// $query8 = "select * from master_accountssub where auto_number = '$accountssub' and recordstatus <> 'deleted'";
//         $exec8 = mysql_query($query8) or die(mysql_error());
//         $res8 = mysql_fetch_array($exec8);
//         $accanum = $res8['id'];
//         $accountssubname = $res8['accountssub'];


            $query82 = "select * from master_accountssub where auto_number = '$accountssub'";
$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die ("Error in Query82".mysqli_error($GLOBALS["___mysqli_ston"]));
$res82 = mysqli_fetch_array($exec82);
$accanum = $res82['id'];
$shortname = $res82['shortname'];

$accanumexplode = explode('-',$accanum);
$accanum1 = $accanumexplode[0];
$accanum2 = $accanumexplode[1];


if(isset($accanumexplode[2]))
  $accanum3 = $accanumexplode[2];
else
  $accanum3 ='01';

$accinc = intval($accanum3);
$accinc = $accinc + 1;



//$query2 = "select * from master_accountname where locationcode = '$location' and accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";

$query2 = "select * from master_accountname where accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);



$res2id = $res2['id'];



if($res2id == '')

{

    $searchresult = $accanum1.'-'.$accanum2.'-'.$accinc;

}

else

{

    $res2id = $res2['id'];

    $res2idexplode = explode('-',$res2id);

    $res2id1 = $res2idexplode[0];

    $res2id2 = $res2idexplode[1];

    $res2id3 = $res2idexplode[2];

    

    $incanum = intval($res2id3);

    $incanum = $incanum + 1;

    

    $searchresult = $res2id1.'-'.$res2id2.'-'.$incanum;

    

    l1:

      $select_query="select * from master_accountname where id = '$searchresult' limit 0,1";

      $result = mysqli_query($GLOBALS["___mysqli_ston"], $select_query);

      while($row = mysqli_fetch_array($result))

      {

        $res2id = $row['id'];

        $res2idexplode = explode('-',$res2id);

        $res2id1 = $res2idexplode[0];

        $res2id2 = $res2idexplode[1];

        $res2id3 = $res2idexplode[3];

        

        $incanum = intval($res2id3);

        $incanum = $incanum + 1;

        

        $searchresult = $res2id1.'-'.$res2id2.'-'.$incanum;

        

        goto l1;

     }

}
      //////////// FOR ID GENERATE ///////////////////
            $accountname1=trim($accountname);

         $medicinequery2="INSERT INTO `master_accountname`( `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `misreport`, `iscapitation`,`is_receivable`,`phone`) 
                    VALUES ('$accountname1','$searchresult','','$paymenttype','$subtype','$accountsmain','$accountssub','','','$currency','1','ACTIVE','$expirydate','$locationname','$locationcode','$ipaddress','$updatedatetime','','$username','','','','')";

                    $execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    }

     $medicinequery23="TRUNCATE TABLE `debtorsupload_temp`";
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
$medicinequery23="TRUNCATE TABLE `debtorsupload_temp`";
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
                    $query_1 = "SELECT * from debtorsupload_temp ";
                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows=mysqli_num_rows($exec_1);
                ?>
                <form name="form1" id="form1" method="post">

                 
                <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr >
                        <td colspan="12"  bgcolor="#FFFFFF" class="bodytext3"><span style="text-align: left;">No. of Accounts to upload :  <?=$no_of_rows;?></span></td>
                      </tr>
                       <tr bgcolor="#011E6A">
                        <td colspan="12" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>Debtors List View </strong></td>
                      </tr>
                      <tr bgcolor="#ffaa00">
                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                        <td width="3%" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="8%" align="left" valign="top"  class="bodytext3"><strong>Accounts Main</strong></td>
                        <td width="5%" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="10%" align="left" valign="top"  class="bodytext3"><strong>Accounts Sub</strong></td>
                        <!-- <td width="10%" align="left" valign="top"  class="bodytext3"><strong>ID</strong></td> -->
                         <td align="left" valign="top"  class="bodytext3"><strong>Account Name </strong></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><strong>Main Type </strong></span></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Sub Type </strong></td>
                        <td width="10%" align="left" valign="top"  class="bodytext3"><strong>Validity</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Currency</strong></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Remarks</strong></td>
                        <td width="9%" align="left" valign="top"  class="bodytext3"><strong></strong></td>
                      </tr>
                     <?php    
                     $y=0;
        $query1 = "SELECT * from debtorsupload_temp ";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res1 = mysqli_fetch_array($exec1))
        {
        $accountname = $res1['accountname'];

        $paymenttypeanum = $res1['paymenttype'];
        $subtypeanum = $res1['subtype'];
        $expirydate = $res1['expirydate'];
        $accountsmain = $res1['accountsmain'];
        $accountssub = $res1['accountssub'];
        $currency = $res1['currency'];
        $expirydate = $res1['expirydate'];


         $query6 = "select * from master_accountsmain where auto_number = '$accountsmain' and recordstatus <> 'deleted'";
        $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $res6 = mysqli_fetch_array($exec6);
        $maincode = $res6['id'];
        $accountsmainname = $res6['accountsmain'];

        
        $query8 = "select * from master_accountssub where auto_number = '$accountssub' and recordstatus <> 'deleted'";
        $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $res8 = mysqli_fetch_array($exec8);
        $subcode = $res8['id'];
        $accountssubname = $res8['accountssub'];

        $query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $paymenttype = $res2['paymenttype'];

        $query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res3 = mysqli_fetch_array($exec3);
        $subtype = $res3['subtype'];

        $query31 = "select accountname, subtype from master_accountname where accountname = '$accountname'";
        $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $x=mysqli_num_rows($exec31);
        $res31 = mysqli_fetch_array($exec31);
        $dublicate_subtype = $res31['subtype'];

        $query32 = "select * from master_subtype where auto_number = '$dublicate_subtype'";
        $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res32 = mysqli_fetch_array($exec32);
        $dublicate_subtype_name = $res32['subtype'];


    
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

        if($x>0){
            $colorcode = 'bgcolor="pink"';
            $y+=1;
        }

        $query23 = "SELECT * from debtorsupload_temp order by auto_number desc limit 0, 1";
                    $exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res23 = mysqli_fetch_array($exec23);
                    $subtype12 = $res23["subtype"];
                    $paymenttype12 = $res23["paymenttype"];

                    // if(($paymenttype12==$maintype) or ($subtype12==$subtype)){
                    //                          $view_true=1;
                    //                          }
          
        ?>

        <input type="hidden" name="accountname[]" value="<?=$accountname?>" >
        <input type="hidden" name="paymenttype[]" value="<?=$paymenttypeanum?>" >
        <input type="hidden" name="subtype[]" value="<?=$subtypeanum?>" >
        <input type="hidden" name="expirydate[]" value="<?=$expirydate?>" >
        <input type="hidden" name="accountsmain[]" value="<?=$accountsmain?>" >
        <input type="hidden" name="accountssub[]" value="<?=$accountssub?>" >
        <input type="hidden" name="currency[]" value="<?=$currency?>" >
        
                      <tr  <?php echo $colorcode;  ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
                        <?=$colorloopcount;?>
                        </div></td>
                        
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maincode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountsmainname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subcode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountssubname; ?></td>
                        <!-- <td align="left" valign="top"  class="bodytext3"><?php echo $id; ?></td> -->
                         <td width="17%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $accountname; ?></span></td>
                        <td align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $paymenttype; ?></span></td>
                        <td width="12%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $subtype; ?></span></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $expirydate; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $currency; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php if($x>0){ echo 'Name Exists'; } ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php if($x>0){ echo $dublicate_subtype_name; } ?></td>
                        
                      </tr>
                      <?php
        }
        ?>
        <tr bgcolor="#011E6A">
                        <td colspan="12" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                      </tr>
        <tr>
            <td colspan="29" width="1002"align="center" valign="top">
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                 <input name="submit_but" type="submit" id="submit0" value="Submit " onclick="return acknowledgevalid();" accesskey="b" class="button" style="border: 1px solid #001E6A; background-color: lightblue; cursor: pointer;" <?php if($y>0){ echo "disabled"; } ?>/>
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

