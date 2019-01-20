<?php
require_once './json.php';
require_once './db.php';
require_once './cache.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:"43";
    $type = isset($_GET['type'])?$_GET['type']:1;
    $page = isset($_GET['page'])?$_GET['page']:1;//分页
    $pageSize = isset($_GET['pagesize'])?$_GET['pagesize']:10;//需要获取数据库的几条
    $longitude = isset($_GET['longitude'])?$_GET['longitude']:"1";
    $lat = isset($_GET['lat'])?$_GET['lat']:"1";
    $limit = isset($_GET['limit'])?$_GET['limit']:"1000000000000000000";
    $key = isset($_GET['key'])?$_GET['key']:"一起";
    if(!is_numeric($page)||!is_numeric($pageSize)){
        return response::json(401,'数据不合法');
    }
    try {//链接数据库
        $connect = DB::getinstance()->connect();
    }catch (Exception $e){
        return response::json(402,"数据库连接失败");
    }
    $sql = "UPDATE `userinfo` SET `longitude` = '$longitude', `lat` = '$lat' WHERE `userinfo`.`userid` = $userid";
    $result = mysqli_query($connect, $sql);
    

    $offset = ($page-1)*$pageSize;
    $sql = "select acid,title,address,type,people,content,time,username,name,realpeople,date,tribe_id,activity.longitude,activity.lat 
    from activity,userinfo  where type = $type and sqrt(  
    (  
     (($longitude-activity.longitude)*PI()*12656*cos((($lat+activity.lat)/2)*PI()/180)/180)  
     *  
     (($longitude-activity.longitude)*PI()*12656*cos ((($lat+activity.lat)/2)*PI()/180)/180)  
    )  
    +  
    (  
     (($lat-activity.lat)*PI()*12656/180)  
     *  
     (($lat-activity.lat)*PI()*12656/180)  
    )  
)<$limit and userinfo.userid=activity.userid and (title like '%$key%' or content like '$key') order by acid desc";
    $result = mysqli_query($connect, $sql);//查询数据库数据
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
        $array[] = $r;
    }
    if($array){
        return response::json(444,"搜索活动成功",$array);
    }else{
        return response::json(445,"搜索活动失败",$array);
    }
?>