<?php
require_once './json.php';
require_once './db.php';
require_once './aliSDK/top/request/OpenimUsersAddRequest.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/domain/Userinfos.php';
    $username = isset($_GET['username'])?$_GET['username']:"150029893411";
    $passwd = isset($_GET['passwd'])?$_GET['passwd']:"aa";
    if(!is_string($username)||!is_string($passwd)){
        return response::json(401,"数据不合法");
    }
    if($username==""||$passwd==""){
        return response::json(408,"用户名或密码不能为空");
    }
    $sql = "select userid from userinfo where username='".$username."'";
    
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    
    $result = mysqli_query($conn, $sql);//查找是否存在用户名
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
        $array[] = $r;
    }
    
    if($array==null){//如果用户名不存在则加入
        $sql = "INSERT INTO `userinfo` (`userid`, `addr`, `sex`, `name`, `realname`, `username`, `passwd`, `hobby`, `phone`, `signature`, 
            `img`,`longitude`,`lat`) VALUES (NULL, '', '', '', '', '".$username."', '".$passwd."', '', '', '', '','0','0')";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(404,"注册失败");
        }else{
            $c = new TopClient;
            $c->appkey = '23666480';
            $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
            $req = new OpenimUsersAddRequest;
            $userinfos = new Userinfos;
            $userinfos->nick=$username;
            $userinfos->userid=$username;
            $userinfos->password=$passwd;
            $req->setUserinfos(json_encode($userinfos));
            $resp = $c->execute($req);
            return response::json(400,"注册成功");
        }
    }else{
        return response::json(403,"用户名已存在");
    }
?>
