<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:43;
    $acid = isset($_GET['acid'])?$_GET['acid']:385;
    $sql = "delete from attention where userid=".$userid." and acid=".$acid;
    
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $result = mysqli_query($conn, $sql);
    
    if(!$result){
        return response::json(427,"取消关注活动失败");
    }else{
        return response::json(428,"取消关注活动成功");
    }
?>