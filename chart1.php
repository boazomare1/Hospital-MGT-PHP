<html>
<head>
</head>
<body>
<?php
include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/chart-data1.php', false );
?>
<?php
?>
</body>
</html>