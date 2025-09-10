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



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

    $prodcuttypeanum = $_REQUEST['prodcuttypeanum'];

  $producttype = $_REQUEST["producttype"];

  //$salutation = strtoupper($salutation);

  $producttype = trim($producttype);

  $length=strlen($producttype);

  //echo $length;

  if ($length<=100)

  {

    $producttype=strtolower($producttype);
    $producttype=ucwords($producttype);

  $query2 = "select id from drug_instructions where name = '$producttype' and  id <> '$prodcuttypeanum'";

  //echo $query2;

  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

  $res2 = mysqli_num_rows($exec2);

  //echo '#'.$res2.'#';

  if ($res2 == 0)

  {

    //echo 'yes';

    

      $query1 = "update drug_instructions set name = '$producttype', updated_on = '$updatedatetime' where id = '$prodcuttypeanum'";

    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

    $errmsg = "Success. Drug Instruction Type Updated.";

    //$bgcolorcode = 'success';

    header ("location:edit_drug_instructions.php?bgcolorcode=success&&st=edit&&anum=$prodcuttypeanum");

  }

  else

  {

    //echo 'no';

    $errmsg = "Failed. Drug Instruction Already Exists.";

    //$bgcolorcode = 'failed';

    header ("location:edit_drug_instructions.php?bgcolorcode=failed&&st=edit&&anum=$prodcuttypeanum");

  }

  }

  else

  {

    $errmsg = "Failed. Only 100 Characters Are Allowed.";

    //$bgcolorcode = 'failed';

    header ("location:edit_drug_instructions.php?bgcolorcode=failed&&st=edit&&anum=$prodcuttypeanum");

  }



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($st == 'edit' && $anum != '')

{



    $query1 = "select id,name from drug_instructions where id = '$anum'";

  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

  $res1 = mysqli_fetch_array($exec1);

    $res1autonumber = $res1['id'];

    $res1prodcuttype = $res1['name'];



}





if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

    $errmsg = "Success. Drug Instruction Updated.";

    header("Refresh: 5; url=drug_instructions.php");

}

if ($bgcolorcode == 'failed')

{

    $errmsg = "Failed. Drug Instruction Already Exists.";

}





?>

<style type="text/css">

<!--

body {

  margin-left: 0px;

  margin-top: 0px;

  background-color: #ecf0f5;

}

.bodytext3 {  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>



<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function addproducttype1process1()

{

  var producttype = document.form1.producttype.value;



  producttype = producttype.replace(/^\s+|\s+$/g, '' );

  if(producttype == "")

  {

    alert ("Please Enter Drug Instruction.");

    document.form1.producttype.focus();

    return false;

  }

  

}

</script>

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

    <td width="2%" valign="top">

      &nbsp;</td>

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td><form name="form1" id="form1" method="post" action="edit_drug_instructions.php" onSubmit="return addproducttype1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Drug Instruction Master - Edit </strong></td>

                      </tr>

            <tr>

                        <td colspan="2" align="left" valign="middle"   

            bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Edit Drug Instruction</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

            <input name="producttype" id="producttype" value="<?php echo $res1prodcuttype ?>" style="border: 1px solid #001E6A;" size="40" /></td>

                      </tr>

                     

                      <tr>

                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">

            <input type="hidden" name="frmflag" value="addnew" />

                       <input type="hidden" name="frmflag1" value="frmflag1" />

             <input type="hidden" name="prodcuttypeanum" id="prodcuttypeanum" value="<?php echo $res1autonumber; ?>">

                        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

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