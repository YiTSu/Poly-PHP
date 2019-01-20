<?php
require_once './db.php';
require_once './json.php';
require_once './aliSDK/top/request/OpenimUsersAddRequest.php';
require_once './aliSDK/top/request/OpenimUsersUpdateRequest.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/domain/Userinfos.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:55;
    $username = isset($_GET['username'])?$_GET['username']:"1500298934111";
    $passwd = isset($_GET['passwd'])?$_GET['passwd']:"hehehe";
    if($passwd==""){
            return response::json(447,"密码不能为空");
    }
    $sql = "update userinfo set passwd='$passwd' where userid=$userid";
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $result = mysqli_query($conn, $sql);
    if(!$result){
        return response::json(448,"密码更新失败");
    }else{
        $c = new TopClient;
        $c->appkey = '23666480';
        $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
        $req = new OpenimUsersUpdateRequest;
        $userinfos = new Userinfos;
        $userinfos->userid=$username;
        $userinfos->password=$passwd;
        $req->setUserinfos(json_encode($userinfos));
        $resp = $c->execute($req);
        return response::json(449,"密码更新成功");
    }
?>