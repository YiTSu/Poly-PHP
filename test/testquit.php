<?php
require_once 'D:/wamp/wamp64/www/Poly/json.php';
require_once 'D:/wamp/wamp64/www/Poly/db.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/TopClient.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/request/OpenimUsersDeleteRequest.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/request/OpenimTribeQuitRequest.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/domain/Userinfos.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/domain/OpenImUser.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:0;
    $acid = isset($_GET['acid'])?$_GET['acid']:216;
    $sql = "delete from joinin where userid=".$userid." and acid=".$acid;
    $query = "select realpeople from activity where acid=".$acid;
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $r = mysqli_query($conn, $query);
    $array = array();
    while($re = mysqli_fetch_assoc($r)){
        $array = $re;
    }
    foreach ($array as $a){
        
    }
    $a = $a-1;
    $insert = "UPDATE `activity` SET `realpeople` = ".$a." WHERE `activity`.`acid` =".$acid;
    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $insert);
    if((!$result)||(!$result1)){
        return response::json(423,"退出活动失败");
    }else{   
        $sql = "SELECT tribe_id FROM `activity` WHERE `acid`=$acid";
        $r = mysqli_query($conn, $sql);
        $array = array();
        while($re = mysqli_fetch_assoc($r)){
            $array = $re;
        }
        foreach ($array as $a){
        }
        $c = new TopClient;
        $c->appkey = '23666480';
        $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
        $req = new OpenimTribeQuitRequest;
        $user = new OpenImUser;
        $user->uid="$userid";
        $user->taobao_account="false";
        $user->app_key="23666480";
        $req->setUser(json_encode($user));
        $req->setTribeId("$a");
        $resp = $c->execute($req);
        return response::json(424,"退出活动成功");
    }
?>