<title>
<?php 
if (isset($_REQUEST["titlestr"])) { $titlestr = $_REQUEST["titlestr"]; } else { $titlestr = ""; }
if ($titlestr == '')
{
	echo 'MedBot';
}
else
{
	echo $titlestr.'MedBot';
}
?>
</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">