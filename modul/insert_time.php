<?php

$time   =$_POST['time'];
$kind   ="content_time";
if((1!=$time) || (10!=$time)){
    echo json_encode(0);
    exit();
}
$result=content::insert($time, $kind);
echo json_encode($result);