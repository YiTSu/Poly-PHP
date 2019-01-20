<?php
require_once './json.php';
require_once './db.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/request/OpenimTribeQuitRequest.php';
require_once './aliSDK/top/domain/OpenImUser.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:54;
    $acid = isset($_GET['acid'])?$_GET['acid']:386;
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $sql = "select main from joinin where userid=$userid and acid=$acid";
    $result = mysqli_query($conn, $sql);
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
        $array[] = $r;
    }
    foreach ($array as $a){
        foreach ($a as $a);
    }
    if($a==0){
        $query = "select realpeople from activity where acid=".$acid;
        $r = mysqli_query($conn, $query);
        $array = array();
        while($re = mysqli_fetch_assoc($r)){
            $array = $re;
        }
        foreach ($array as $a){
        }
        $a = $a-1;
        $insert = "UPDATE `activity` SET `realpeople` = $a WHERE acid =$acid";
        $result1 = mysqli_query($conn, $insert);
        
        $sql = "delete from joinin where userid=$userid and acid=$acid";
        $result = mysqli_query($conn, $sql);
        if((!$result)||(!$result1)){
            return response::json(423,"退出活动失败");
        }else{   
            //找uid
            $sql = "SELECT username FROM userinfo WHERE userid = $userid";
            $result = mysqli_query($conn, $sql);
            $array = array();
            while($r = mysqli_fetch_assoc($result)){
                $array[] = $r;
            }
            foreach ($array as $a){
                foreach ($a as $aa);
            }
            
            //找群id
            $sql = "SELECT tribe_id FROM activity WHERE acid = $acid";
            $result = mysqli_query($conn, $sql);
            $array = array();
            while($r = mysqli_fetch_assoc($result)){
                $array[] = $r;
            }
            foreach ($array as $b){
                foreach ($b as $tribeid);
            }
            
            $c = new TopClient;
            $c->appkey = '23666480';
            $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
            $req = new OpenimTribeQuitRequest;
            $user = new OpenImUser;
            $user->uid=$aa;
            $user->app_key="23666480";
            $req->setUser(json_encode($user));
            $req->setTribeId("$tribeid");
            $resp = $c->execute($req);
            return response::json(424,"退出活动成功");
        }
    }else{
        return response::json(443,"发起活动者不能退出此次活动");
    }
?>