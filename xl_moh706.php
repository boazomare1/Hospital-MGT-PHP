<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="MOH 706 Report.xls"');
header('Cache-Control: max-age=80');

session_start();
include("includes/loginverify.php");
include("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$snocount = "";
$colorloopcount = "";

$snocount = "";
$colorloopcount = "";

if (isset($_REQUEST["locationcode"])) {
    $locationcode1 = $_REQUEST["locationcode"];
} else {
    $locationcode1 = "";
}
if (isset($_REQUEST["ADate1"])) {
    $ADate1 = $_REQUEST["ADate1"];
    $paymentreceiveddateto = $ADate1;
} else {
    $ADate1 = "";
}
if (isset($_REQUEST["ADate2"])) {
    $ADate2 = $_REQUEST["ADate2"];
    $paymentreceiveddateto = $ADate2;
} else {
    $ADate2 = "";
}
if (isset($_REQUEST["cbfrmflag2"])) {
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"];
} else {
    $cbfrmflag2 = "";
}
if (isset($_REQUEST["frmflag2"])) {
    $frmflag2 = $_REQUEST["frmflag2"];
} else {
    $frmflag2 = "";
}
if (isset($_REQUEST["range"])) {
    $range = $_REQUEST["range"];
} else {
    $range = "";
}
if (isset($_REQUEST["ageinp"])) {
    $ageinp = $_REQUEST["ageinp"];
} else {
    $ageinp = "";
}
if (isset($_REQUEST["dmy"])) {
    $dmy = $_REQUEST["dmy"];
} else {
    $dmy = "";
}


function generateLabSpecifics($resultValue, $itemName, $referenceName, $ADate1, $ADate2)
{

    $resultValueClause = "$resultValue";
    $itemNameClause = "$itemName";
    $referenceNameClause = "$referenceName";
    $queryLab = "select count(patientcode) as count7 from resultentry_lab where  $resultValueClause $itemNameClause $referenceNameClause and recorddate between '$ADate1' and '$ADate2' ";

    $execLab = mysqli_query($GLOBALS["___mysqli_ston"], $queryLab) or die("Error in QueryLab" . mysql_error($GLOBALS["___mysqli_ston"]));

    while ($resLab = mysqli_fetch_array($execLab)) {
        echo $resLab["count7"];

        return $resLab["count7"];
    }
}


?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0"
       cellpadding="4"
       width="800" align="left" border="1">
    <tbody>

    <tr>
        <td align="center" valign="center" bgcolor="#CCCCCC" class="bodytext31" colspan="4">
            <strong>LABORATORY TESTS DATA SUMMARY REPORT FORM.</strong>
        </td>
    </tr>
    <tr bgcolor="#011E6A">
        <td bgcolor="#CCCCCC" colspan="4" valign="center" align="center" bgcolor="#ffffff"
            class="bodytext3"><strong>MOH 706</strong></td>

    </tr>


    <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1);

    if ($showcolor == 0) {
        $colorcode = 'bgcolor="#CBDBFA"';
    } else {
        $colorcode = 'bgcolor="#D3EEB7"';
    }

    $queryLabCategories = "SELECT * FROM master_categorylab";
    $execLabCategories = mysqli_query($GLOBALS["___mysqli_ston"], $queryLabCategories) or die("Error in Query Category Lab" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res20 = mysqli_fetch_array($execLabCategories)) {
        $categoryname = $res20['categoryname'];

        $snocount = $snocount + 1;
        $colorloopcount = $colorloopcount + 1;
        $showcolor = ($colorloopcount & 1);

        if ($showcolor == 0) {
            $colorcode = 'bgcolor="#CBDBFA"';
        } else {
            $colorcode = 'bgcolor="#D3EEB7"';
        }
        ?>
        <tr>
            <td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
                <strong>
                    <?php echo $categoryname; ?>
                </strong></td>
        </tr>
        <tr>
            <td width="20%" align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
                <strong>Details</strong>
            </td>
            <td width="3%" align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
                <strong>Total Exam</strong>
            </td>
            <td width="6%" align="center" colspan="2" valign="center" <?php echo $colorcode; ?>
                class="bodytext31">
                <strong>Number Positive</strong>
            </td>

        </tr>
        <tr>
        <?php
        $queryItemName = "SELECT DISTINCT itemname FROM master_labreference where categoryname = '$categoryname' ";
        $execItemName = mysqli_query($GLOBALS["___mysqli_ston"], $queryItemName) or die("Error in Query Lab reference" . mysqli_error($GLOBALS["___mysqli_ston"]));

        while ($resItemName = mysqli_fetch_array($execItemName)) {
            $itemname = $resItemName['itemname'];
            ?>
            <tr>
                <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
                    <?php echo $itemname ?>
                </td>
                <td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
                    <?php
                    $itemName = "itemname like '%$itemname%' and ";
                    //                                    $referenceName = "referencename like '%$categoryname%'";
                    $referenceName = "referencename <> ''";
                    $resultValue = "";

                    generateLabSpecifics($itemName, $resultValue, $referenceName, $ADate1, $ADate2);

                    ?>
                </td>
                <td align="center" colspan="2" valign="center" <?php echo $colorcode; ?>
                    class="bodytext31">
                    <?php
                    $resultValue = "resultvalue LIKE '%positive%' and";
                    $itemName = "itemname like '%$itemname%' and ";
                    $referenceName = "referencename <> ''";
                    generateLabSpecifics($resultValue, $itemName, $referenceName, $ADate1, $ADate2);
                    ?>
                </td>

            </tr>
            <?php
        }

        ?>
        </tr>
        <?php
    }
    ?>


    </tbody>
</table>