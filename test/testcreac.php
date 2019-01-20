<?php
header('Content-Type:text/html;charset=utf-8');
require_once 'D:/wamp/wamp64/www/Poly/json.php';
require_once 'D:/wamp/wamp64/www/Poly/db.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/TopClient.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/request/OpenimUsersAddRequest.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/request/OpenimTribeCreateRequest.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/domain/Userinfos.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/domain/OpenImUser.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:1;
    $title = isset($_GET['title'])?$_GET['title']:"1";
    $time = isset($_GET['time'])?$_GET['time']:"1";
    $people = isset($_GET['people'])?$_GET['people']:10;
    $addr = isset($_GET['addr'])?$_GET['addr']:"1";
    $content = isset($_GET['content'])?$_GET['content']:"年";
    $type = isset($_GET['type'])?$_GET['type']:1;
    $date = isset($_GET['date'])?$_GET['date']:"1";
    $unq = isset($_GET['unq'])?$_GET['unq']:"11";
    $filename = isset($_GET['filename'])?$_GET['filename']:"myfile";
    if($title==""){
        return response::json(411,"主题不能为空");
    }
    if($time==""){
        return response::json(412,"时间不能为空");
    }
    if($addr==""){
        return response::json(413,"地址不能为空");
    }
    if($content==""){
        return response::json(414,"内容不能为空");
    }
    if($people==0){
        return response::json(415,"人数不能为0");
    }
    //$title = mb_convert_encoding($title,"utf-8","gb2312");
    //$time = mb_convert_encoding($time,"utf-8","gb2312");
    //$addr = mb_convert_encoding($addr,"utf-8","gb2312");
    //$content = mb_convert_encoding($content,"utf-8","gb2312");
    //$date = mb_convert_encoding($date,"utf-8","gb2312");
    $sql = "INSERT INTO `activity` (`acid`, `title`, `address`, `type`, `people`, `content`, `time`, `userid`, `realpeople`, `date`, `unq`, `filename`, `tribe_id`) 
    VALUES (NULL, '".$title."', '".$addr."', '".$type."', '".$people."', '".$content."', '".$time."', '".$userid."', '1', '".$date."', '".$unq."', '".$filename."','')";
    
    
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $result = mysqli_query($conn, $sql);
    
    if(!$result){
        return response::json(416,"创建活动失败");
    }else{
        $sql2 = "select acid from activity where unq = ".$unq;
        $result = mysqli_query($conn, $sql2);
        $array = array();
        while($r = mysqli_fetch_assoc($result)){
            $array[] = $r;
        }
        foreach ($array as $r){         
            if(is_array($r)){
                foreach ($r as $rr){
                    $insert = "INSERT INTO `joinin` (`userid`, `acid`, `main`) VALUES ('".$userid."','".$rr."', '1')";
                    $result = mysqli_query($conn, $insert);
                }
            }else{
                $insert = "INSERT INTO `joinin` (`userid`, `acid`, `main`) VALUES ('".$userid."','".$r."', '1')";
                $result = mysqli_query($conn, $insert);
            }
        }
        
        if(!$result){
            return response::json(416,"创建活动失败");
        }
        $tribe = 1;
        $c = new TopClient;
        $c->appkey = '23666480';
        $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
        $req = new OpenimTribeCreateRequest;
        $user = new OpenImUser;
        $user->uid="abc";
        $user->taobao_account="false";
        $user->app_key="23666480";
        $req->setUser(json_encode($user));
        $req->setTribeName($title);
        $req->setNotice("none");
        $req->setTribeType("0");
        $members = new OpenImUser;
        $members->uid="abc";
        $members->taobao_account="false";
        $members->app_key="demo";
        $req->setMembers(json_encode($members));
        $resp = $c->execute($req);
        $resp = (array) $resp;
        $tribinfo = (array)$resp['tribe_info'];
        $id = $tribinfo['tribe_id'];//群id
        $tribe_id = array('tribeid'=>$id);
        $sql3 = "UPDATE `activity` SET `tribe_id` = '$id' WHERE `activity`.`acid` = $rr";
        mysqli_query($conn, $sql3);
        return response::json(417,"创建活动成功",$tribe_id);
        
    }
?>