<?php
require_once './json.php';
require_once './db.php';
    $username = isset($_GET['username'])?$_GET['username']:"1500298934111";
    $passwd = isset($_GET['passwd'])?$_GET['passwd']:"aa";
    $longitude = isset($_GET['longitude'])?$_GET['longitude']:"50.11";
    $lat = isset($_GET['lat'])?$_GET['lat']:"50";
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
        $array = array();
        while($r = mysqli_fetch_assoc($result)){
            $array[] = $r;
        }
        foreach ($array as $a){
            foreach ($a as $userid);
        }
        if($array==null){
            return response::json(406,"用户名或密码错误");
        }else{
            $sql = "UPDATE `userinfo` SET `longitude` = '$longitude', `lat` = '$lat' WHERE `userinfo`.`userid` = $userid";
            $result = mysqli_query($conn, $sql);
            return response::json(407,"登陆成功",$array);
        }
    }
    
?>