<?php
$file=$_REQUEST['path']; //file location 
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
header('Content-Length: ' . filesize($file));
readfile($file);
?>