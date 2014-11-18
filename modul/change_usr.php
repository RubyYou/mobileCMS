<?php
lee::lib_load("usr",$updir);

$id     =$_GET['id'];
$value  =$_GET['value'];

//对于可以修改的用户信息进行限定
$limit=array(
    name	=> "usr_name",
    pic         => "usr_pic",
    language	=> "usr_language",
    local	=> "usr_local",
    gender	=> "usr_gender",
    age 	=> "usr_age",
    level	=> "usr_level",
    perfation	=> "usr_perfation",
    email	=> "usr_email",
    tel         => "usr_tel",
    skype	=> "usr_skype",
    facebook	=> "usr_facebook",
    desc        => "usr_desc"
);

if("mypic"==$value){
    $myid   =data_use::get_usr('userid');
    $pic    =data_use::register_static_get('topic_'.$myid);
    data_use::register_static_set('topic_'.$myid, null);
    data_use::register_static_delete('topic_'.$myid);
    $value=$pic;
}

if(!$id){
    $id=null;
}
if(!$value){
    $value=null;
}

$kind=sql_use_f::select_kind($id);
switch ($kind) {
    case $limit[name]:
        
        break;
    case $limit[gender]:
        if (0!=$value || 1!=$value || 2!=$value){
            die($cu_gendrerror);
        }
        break;
    case $limit[age]:
        if ($value<=10 || $value>=60){
            die($cu_ageerror);
        }
        break;
    case $limit[language]:
        if ("Chinese"!=$value || "Deutsch"!=$value || "Englisch"!=$value){
            die($cu_languageerror);
        }
        break;
    case $limit[email]:


        break;
    default:
        break;
}


//echo $id.$value;;
$result= usr_rel::change($id, $value, $limit);
echo 1;