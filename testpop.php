<html><head></head>
<body style="margin:0px;padding: 0px;" onLoad="pop()">
<!--<embed src="open-flash-chart.swf?data=vitalinput_line.php?patientcode=dd34" quality="high"
 bgcolor="#FFFFFF" name="open-flash-chart" allowscriptaccess="always" type="application/x-shockwave-flash"
 align="middle" height="50%" width="50%" id="graph">-->
</body>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script>
function pop()
{
  NewWindow=window.open('testlinechart.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>','newWin','width=400,height=300,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
  NewWindow.focus();
}
</script>