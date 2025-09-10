<?php
$file='op_uploads/Intra_OP_form.pdf';
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".basename($file));   
header("Content-Type: application/download");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($file));
  
flush(); // This doesn't really matter.
  
$fp = fopen($file, "r");
while (!feof($fp)) {
    echo fread($fp, 65536);
    flush(); // This is essential for large downloads
} 
  
fclose($fp); 
?>