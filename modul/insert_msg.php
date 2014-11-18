<?php

$msg   =$_POST['msg'];
$to    =$_POST['to'];
class con extends content {
    static function insert_msg($msg,$to){
        $kind_toauthor="content_toauther";
//        寻找是否有对此人发过信息，若有则加到后面
        $where=  sql_use_f::$data_columns[kind]."=".$kind_toauthor." and ".sql_use_f::$data_columns[content]."=".$to." and ".sql_use_f::$data_columns[author]."=".data_use::get_usr('userid');
        $id=sql_use_f::select_one(sql_use_f::$data_id, $where);
//        若没有则添加节点
        if (!isset($id)){
            $id=self::insert($to, $kind_toauthor);
        }
        $kind="content_msg";
        $result=self::insert($msg, $kind, $id);
        return $result;
    }
}


$result=con::insert_msg($msg,$to);
echo json_encode($result);
