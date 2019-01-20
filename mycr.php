<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:43;
    $sql = "select activity.acid,title,address,type,people,content,time,username,name,realpeople,date,tribe_id,activity.longitude,activity.lat
        from activity,userinfo,joinin where joinin.acid=activity.acid and  userinfo.userid=activity.userid and userinfo.userid=".$userid." and joinin.userid=".$userid." and joinin.main=1";
    $array = array();
    
    try {//链接数据库
        $connect = DB::getinstance()->connect();
    }catch (Exception $e){
        return response::json(402,"数据库连接失败");
    }
    $result = mysqli_query($connect, $sql);//查询数据库数据
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
        $array[] = $r;
    }
    
    
    if($array){
        return response::json(435,"我创建的活动获取成功",$array);
    }else{
        return response::json(436,"我创建的活动获取失败",$array);
    }
    
?>