<?php

class usr {
    
//  注册
    static function register($usr,$psw){
        if(empty($usr) || empty($psw)){
            return false;
        }
        $c  =  sql_use_u::select_usr($usr);
        if(isset($c)){
            return false;
        }
        $result =sql_use_u::insert($usr, $psw);
        return $result;
    }
    
//  登录
    static function login($usr,$psw){
        if(empty($usr) || empty($psw)){
            return false;
        }
        
        if(isset(data_use::get_usr('userid'))){
            return false;
        }
        
        $result =sql_use_u::select_up($usr, $psw);
        if ($result) {
                $id=$result;
                $out=self::out_tkid($id);
                data_use::register_static_set('access_'.$out, true);
                data_use::register_static_set('userid_'.$out, $id);
                data_use::register_static_set('username_'.$out, $usr);
                return $out;
        }
        else 
        return false;
    }
    
    
    static function logout(){
        $out=data_use::register_get('tkid');
        data_use::register_static_delete('access_'.$out);
        data_use::register_static_delete('userid_'.$out);
        data_use::register_static_delete('username_'.$out);
        return 1;
    }
    
    static function delet($id=NULL){
        if(!$id){
            $id=data_use::get_usr('userid');
        }
        $result =sql_use_u::delet($id);
        return $result;
    }
            
    //usr::checklogin()	验证是否登录
    static function checklogin($tkid){
        if (true!=(data_use::register_static_get('access_'.$tkid)))
        return false;
        elseif ($tkid!=self::out_tkid(data_use::register_static_get('userid_'.$tkid)))
        return false;
        else
        return 1;
    }
    
    static function out_tkid($value){
        $token='tklogin';
        return data_use::encryption($token, $value,$_SERVER['HTTP_USER_AGENT']);
        //都没写注释了，说明这个东西跟安全有关，所以不懂的别动了！
    }
}



class usr_rel {
    static protected $kind_user    = array(
                        usr_name,
                        usr_pic,     //头像
                        
                        usr_ip,
                        usr_local,    //地点
                        usr_language,
                        
                        usr_gender,     //性别
                        usr_age,         //年龄
                        usr_level,      //语言程度
                        usr_perfation,  //专业
                        usr_tel,        //电话
                        usr_email,      //email
                        usr_skype,      //skype
                        usr_facebook,   //fb
                        usr_desc,   //描述
                        
                        usr_msg,        //消息数量
                        usr_msg_tap,     //消息id
                        usr_msg_hide     //过期消息id
                        );
    
    
    //建立用户其他数据
    static function create($userid){
        $create_user    = array(
                        usr_name	=> "User_".$userid,
                        usr_ip          => $_SERVER["REMOTE_ADDR"],
                        usr_local       => 0,    //地点
                        usr_pic         => 0,    //pic
                        usr_language    => 0,    //语言
                        usr_gender	=> 0,    //性别
                        usr_age         => 0,    //年龄
                        usr_level	=> 0,    //语言程度
                        usr_perfation	=> 0,    //专业
                        usr_email	=> 0,    //email
                        usr_tel         => 0,    //电话
                        usr_skype	=> 0,    //skype
                        usr_facebook	=> 0,    //fb
                        usr_desc	=> 0,    //描述
                        usr_msg         => 0     //消息数量
                        );
        
        foreach ($create_user as $k=>$v){
            sql_use_f::insert($v, $userid, $k, $userid);
        }
        return 1;
    }
    
    //用户数据补充数据
    static function add($userid,$col,$val){
        $col="usr_".$col;
        $result =sql_use_f::insert($val, $userid, $col, $userid);
        return $result;
    }


//    查询用户列表，kind可以为数组,如果为空则遍历所有用户信息  userid为空的时候找自己的资料
    static function select($kind=null, $userid=null, $page=null, $pagesize=null){
        if(!$userid){
            $userid= data_use::get_usr('userid');
            sql_use_f::update_one_ku($userid, "usr_ip", $_SERVER["REMOTE_ADDR"]);
        }
        if(!$kind){
            $kind=self::$kind_user;
            
        }
        if(!$pagesize){
            $pagesize=20;
        }
        if(!$page){
            $page=0;
        }
        $where=  sql_use_f::$data_columns[upid]."=".$userid;
        $result= sql_use_f::select_page($kind,$page,$pagesize,null,$where);
        
        return $result;
    }
    
//    修改用户列表，kind和value都可以是数组，要对应改。禁止修改别人的用户信息！！
    static function change($id,$value,$limit){
        if(is_array($limit)){
            $limit=data_use::join($limit, "','");
        }
        $where=  sql_use_f::$data_columns[kind]." in ('".$limit."')";
        $result=  sql_use_f::select_one(null, $where);
        if(empty($result)){
            return false;
        }
        sql_use_f::update_one_id($id, $value);
        return 1;
    }
//    删除自己的用户列表~会删掉所有那啥发的信息
    static function delete(){
        $userid=data_use::get_usr('userid');
        sql_use_f::delete($userid, 1);
    }
    
    
    
    //    修改用户列表，kind和value都可以是数组，要对应
    static function change_admin($upid,$kind,$value){
        return sql_use_f::update_one_ku($upid, $kind, $value, $upid);
    }
//    删除用户列表
    static function delete_admin($userid){
        sql_use_f::delete($userid, 1);
    }
}