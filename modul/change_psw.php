<?php
lee::lib_load("usr",$updir);
$usr=$_GET['u'];
$token=$_GET['p'];
$check=$_GET['check'];
if(data_use::register_static_get('getp_'.$usr)==$check){
    $userid= sql_use_u::select_usr($usr);
    $result= sql_use_u::change($userid,$token);
    echo "成功修改密码！请重新点击我们的域名进入页面！";
    data_use::register_static_delete('getp_'.$usr);
}
else {
    echo "您的密文不对！请重新发送邮件！";
}
