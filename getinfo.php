<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:47;
    $sql = "select addr,sex,name,realname,hobby,phone,signature,username from userinfo where userid=$userid";
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $result = mysqli_query($conn, $sql);
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
        $array[] = $r;
    }
    if(!$result){
        return response::json(439,"资料获取失败");
    }else{
        return response::json(440,"资料获取成功",$array);
    }
?>