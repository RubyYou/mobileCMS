<?php
$mail = new SaeMail();
lee::lib_load("md5",$updir);
$usr=$_POST['usr'];
$psw=$_POST['psw'];
$rpsw=$_POST['psw'];
if($psw!=$rpsw){
    die($reg_PswNoSame);
}
$token=md($usr, $psw);
function randomkeys($length)
{
 $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
 for($i=0;$i<$length;$i++)
 {
   $key .= $pattern{mt_rand(0,35)};    //生成php随机数
 }
 return $key;
}
$rand=randomkeys(20);
 
$msg="您好！请点击这里http://mobilcms.sinaapp.com/link.php?m=change_psw&check=".$rand."&u=".$usr."&p=".$token."完成修改密码，本次密码修改来自IP".$_SERVER["REMOTE_ADDR"]."，若不是本人请举报！感谢您对mobilecms的支持！";
data_use::register_static_set('getp_'.$usr,$rand);
$ret = $mail->quickSend( $usr , '你好！我是mobilcms客服' , $msg, 'dqtalk@163.com' , 'talktalk2013' );
 
    //发送失败时输出错误码和错误信息
    if ($ret === false)
        var_dump($mail->errno(), $mail->errmsg());
    else
        echo 1;
?>
