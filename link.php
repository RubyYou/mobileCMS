<?php
require './kern/LeeFramework.php';

$modul=$_GET[m];
$msg="Message";

$updir="./";
lee::get_ini();
lee::modul_load($msg);      //把信息转化为变量
lee::modul_load($modul);