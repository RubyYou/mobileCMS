<?php
lee::class_load(class_load::lib_dir, "md5",$updir);
lee::lib_load("usr",$updir);
$usr	 =$_POST['usr'];
$psw	 =$_POST['psw'];
$rpsw	 =$_POST['rpsw'];
$language   =$_POST['language'];
if(empty($usr) || empty($psw) || empty($language)){
    die($reg_MustFull);
}
if($language!=(1 || 2)){
    die($reg_Language);
}
if($psw!=$rpsw){
    die($reg_PswNoSame);
}

//先录入数据库
$npsw=md($usr,$psw);
$result = usr::register($usr, $npsw);
if(!is_numeric($result)){
    die($reg_false);
}

class regin extends usr_rel {
    static function register($userid,$other=null,$other_val=null){
        self::create($userid);
        if(isset($other)){
            self::change_admin($userid,$other,$other_val);
        }
        self::change_admin($userid,"usr_email",$usr);
        return 1;
    }
}
$userid=$result;
$result=regin::register($userid,"language",$language);
echo json_encode($userid);