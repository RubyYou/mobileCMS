<?php
lee::lib_load( "usr",$updir);
$result =usr::logout();
echo json_encode($result);
?>
