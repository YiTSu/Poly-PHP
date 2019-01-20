<?php
require_once 'D:/wamp/wamp64/www/Poly/json.php';
require_once 'D:/wamp/wamp64/www/Poly/db.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/TopClient.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/request/OpenimUsersDeleteRequest.php';
require_once 'D:/wamp/wamp64/www/Poly/aliSDK/top/domain/Userinfos.php';
    
    $username = isset($_GET['username'])?$_GET['username']:"1234";
    $passwd = isset($_GET['passwd'])?$_GET['passwd']:"1234";
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
    while($r = mysqli_fetch_array($result)){
        $array[] = $r;
    }
    
    if($array==null){//如果用户名不存在则失败
        return response::json(405,"用户名不存在");
    }else{
        $sqli = "select userid from userinfo where username='".$username."' and passwd ='".$passwd."'";
        $result = mysqli_query($conn, $sqli);//判断用户名密码是否一致
        $array1 = array();
        while($r = mysqli_fetch_assoc($result)){
            $array1[] = $r;
        }
        foreach ($array1 as $a){
            foreach ($a as $b){
                
            }
        }
        $pswd = md5($passwd);
        $resp = array('userinfos'=>$username,'password'=>$pswd,'userid'=>$b);
        
        $c = new TopClient;
        $c->appkey = '23666480';
        $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
        $req = new OpenimUsersDeleteRequest;
        $req->setUserids($b);
        $resp = $c->execute($req);
        var_dump($resp);
        
        
        
        if($array1==null){
            return response::json(406,"用户名或密码错误");
        }else{
            echo response::json(407,"登陆成功",$resp);
        }
    }
    
?>