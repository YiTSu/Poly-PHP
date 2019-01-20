<?php
require_once './json.php';
require_once './db.php';
    $acid = isset($_GET['acid'])?$_GET['acid']:385;
    $sql = "select title,address,type,people,realpeople,content,time,date,tribe_id,longitude,lat from activity where acid=".$acid;
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
    if($array==null){
        return response::json(429,"活动信息获取失败");
    }else{
        return response::json(430,"活动信息获取成功",$array);
    }

?>