<?php
lee::lib_load("plugIn/img");
if(!data_use::get_usr('userid')){
    die('请登录后再上传图片！');
}
$type=$_GET['type'];
$pic='mypic';
$result=img_mak::show_upload_topic($pic);
$myid=data_use::get_usr('userid');
$pic_name=$result[pic_name][0];
data_use::register_static_set('topic_'.$myid, $pic_name);
if(1==$type){
    echo 1;
    return;
}
echo json_encode($result);
