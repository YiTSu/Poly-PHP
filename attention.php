<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:43;
    $acid = isset($_GET['acid'])?$_GET['acid']:385;
    $sql = "select * from attention where userid=".$userid." and acid=".$acid;
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $r = mysqli_query($conn, $sql);
    $array = array();
    while($re = mysqli_fetch_assoc($r)){
        $array[] = $re;
    }
    
    
    if($array==NULL){
        $sql = "INSERT INTO `attention` (`userid`, `acid`) VALUES (".$userid.",".$acid.")";
        
        try {
            $conn = DB::getinstance()->connect();
        } catch (Exception $e) {
            return response::json(402,"数据库连接失败");
        }
        $result = mysqli_query($conn, $sql);
        
        if(!$result){
            return response::json(425,"关注活动失败");
        }else{
            return response::json(426,"关注活动成功");
        }
    }else{
        return response::json(434,"你已关注该活动");
    }
?>