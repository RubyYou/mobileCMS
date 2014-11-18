<?php
lee::class_load( class_load::lib_dir, "md5", $updir);
lee::lib_load("usr",$updir);

$usr=$_POST['usr'];
$psw=$_POST['psw'];
if(empty($usr) || empty($psw)){
    die($login_null);
}
$result=sql_use_u::select_usr($usr);
if(empty($result)){
    die($login_nousr);
}
$npsw=md($usr,$psw);
$result=  usr::login($usr, $npsw);
echo json_encode($result);
?>