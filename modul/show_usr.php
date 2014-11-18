<?php
lee::lib_load("usr");

$userid=$_GET[userid];
$kind=$_GET[kind];

if(!$userid){
    $userid=null;
}

class show_usr extends usr_rel {
    static function select_usr($kind = null, $userid = null) {
        $result=parent::select($kind, $userid);
//        foreach ($result as $re){
//            if("usr_msg_tap"==$re[sql_use_f::$data_columns[kind]] || "usr_msg_hide"==$re[sql_use_f::$data_columns[kind]]){
//                $id=$re[sql_use_f::$data_columns[content]];
//                //去掉重复的
//                if($msgid){
//                    if(TRUE==in_array($id, $msgid)){
//                        continue;
//                    }
//                }
//                $msgid[]=$id;
//                $rr=sql_use_f::select_one_content("id", $id, "con_content");
//                if(!$rr){
//                    $re[data_co]="已关闭的交易";
//                }
//                else{
//                    $re[data_co]=$rr;
//                }
//            }
//            $result2[]=$re;
//        }
//        $result=$result2;
        return $result;
    }
}

$limit=array(
    name	=> "usr_name",
    pic         => "usr_pic",
    language	=> "usr_language",
    local	=> "usr_local",
    gender	=> "usr_gender",
    level	=> "usr_level",
    perfation	=> "usr_perfation",
    email	=> "usr_email",
    tel         => "usr_tel",
    skype	=> "usr_skype",
    facebook	=> "usr_facebook",
    desc        => "usr_desc"
);
if (!in_array($kind,$limit)){
    
}


//$result=  show_usr::select($kind, $userid);
$result=  show_usr::select_usr($kind, $userid);
echo json_encode($result);