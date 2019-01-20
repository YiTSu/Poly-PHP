<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:58;
    $sql = "select attention.acid,title,address,type,people,realpeople,content,time,name,username,activity.longitude,activity.lat
        from activity,attention,userinfo,joinin where attention.userid=$userid and attention.acid=joinin.acid and joinin.main=1 and userinfo.userid=joinin.userid
         and attention.acid=activity.acid";
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
        return response::json(431,"你没有关注任何活动");
    }else{
        return response::json(432,"关注活动信息获取成功",$array);
    }
?>