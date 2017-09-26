<?php
$file = base64_decode($_GET ['url']);
$save_as_name = basename($file);
$files= str_replace(' ','',$file); 
header('Content-Description: File Transfer');
header("Content-type:application/pdf");
header('Content-Disposition:attachment; filename="'.$save_as_name.'"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
readfile("$files");
exit; 

?>
