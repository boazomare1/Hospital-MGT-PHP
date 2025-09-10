<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["mainmenuid"])) { $mainmenid = $_REQUEST["mainmenuid"]; } else { $mainmenid = ""; }
$sessionusername = $_SESSION["username"];

$query1 = "select * from master_menumain where mainmenuid = '$mainmenid' and status <> 'deleted'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$mainmenutext = $res1['mainmenutext'];

$query2sm = "select * from master_menusub where mainmenuid = '$mainmenid' and status <> 'deleted' order by submenuorder";
$exec2sm = mysqli_query($GLOBALS["___mysqli_ston"], $query2sm) or die ("Error in Query2sm".mysqli_error($GLOBALS["___mysqli_ston"]));

$savedbillnumber = isset($_REQUEST["savedbillnumber"]) ? $_REQUEST["savedbillnumber"] : "";
$locationcode = isset($_REQUEST["locationcode"]) ? $_REQUEST["locationcode"] : "";
?>

<!DOCTYPE html>
<html>
<head>
<title>MILLENNIUM HOSPITAL SOFTWARE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/style.css">
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
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
              <tr>
                <td>
                  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tr>
                      <td colspan="2" class="bodytext3" align="left" bgcolor="#ecf0f5">
                        <strong><?php echo $mainmenutext; ?></strong>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="bodytext3" align="left">
                        <table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <?php
                          while ($res2sm = mysqli_fetch_array($exec2sm)) {
                            $submenuid = $res2sm["submenuid"];
                            $submenutext = $res2sm["submenutext"];
                            $submenulink = $res2sm["submenulink"];
                            
                            $query10 = "select count(*) as count from master_employeerights where username = '$sessionusername' and submenuid = '$submenuid'";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res10 = mysqli_fetch_array($exec10);
                            $rowcount10 = $res10["count"];
                            
                            if ($rowcount10 > 0) {
                          ?>
                          <tr>
                            <td width="50%" class="bodytext3" align="left">
                              <a href="<?php echo $submenulink; ?>" class="bodytext3">
                                <?php echo $submenutext; ?>
                              </a>
                            </td>
                            <td width="50%" class="bodytext3" align="left">
                              <a href="<?php echo $submenulink; ?>" class="bodytext3">
                                <input name="button" type="button" class="submenubutton" id="submenubutton" value="<?php echo $submenutext; ?>">
                              </a>
                            </td>
                          </tr>
                          <?php
                            }
                          }
                          ?>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?php include ("includes/footer1.php"); ?>

<script>
function funcPopupExternal() {
  <?php if ($savedbillnumber): ?>
  var savedbillnumberr = "<?php echo $savedbillnumber; ?>";
  var location = "<?php echo $locationcode; ?>";
  
  if (savedbillnumberr != "") {
    var popup = window.open(
      "print_external_bill.php?billnumber=" + savedbillnumberr + "&&locationcode=" + location,
      "OriginalWindowA14",
      'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'
    );
    
    if (popup) {
      popup.focus();
    }
  }
  <?php endif; ?>
}

function funcPopupOnLoader() {
  funcPopupExternal();
}

window.onload = funcPopupOnLoader;
</script>
</body>
</html>



