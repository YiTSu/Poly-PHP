<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:58;
    $sql = "select B.acid,title,address,type,people,realpeople,username,content,time,A.userid,date,name,tribe_id,activity.longitude,activity.lat 
        from activity,joinin as A,joinin as B,userinfo where 
    A.userid=$userid and A.acid=activity.acid and A.acid=B.acid and B.main=1 and userinfo.userid=B.userid";
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
        return response::json(418,"你没有参加任何活动");
    }else{
        return response::json(419,"活动获取成功",$array);
    }
?>