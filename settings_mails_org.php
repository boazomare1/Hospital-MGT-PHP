<?php
$smtp_host ='smtp.office365.com';
$smtp_port ='587';
$smtp_secure='tls';
$smtp_user='noreply@premierhospital.org';
$smtp_psw='#@Premier#2019#';


// mis reports start  /////////////////////////////////////////////////////////////////////////////

$mis_from = "noreply@premierhospital.org";
$mis_path='misreport/';  // attachement files folder

//$mis_to = "sm@kenique.biz";
$mis_to = "sharmamalladi@gmail.com";

//$mis_to = "mis@hospital.org";

$mis_cc = "";
$mis_subject = 'MIS Reports as on';
$mis_message='Dear All,<br>&nbsp;Please Find Attached MIS Reports.<br><br>';
$mis_footer='<br><div align="center"><img src="logofiles/1.jpg" style="height: 191px; width: 466px"></div><br>This is System Generated Email by MEDBOT.';




?>