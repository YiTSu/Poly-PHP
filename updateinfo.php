<?php
require_once './json.php';
require_once './db.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/request/OpenimUsersUpdateRequest.php';
require_once './aliSDK/top/domain/Userinfos.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:"44";
    $addr = isset($_GET['addr'])?$_GET['addr']:"";
    $sex = isset($_GET['sex'])?$_GET['sex']:"";
    $name = isset($_GET['name'])?$_GET['name']:"";
    $realname = isset($_GET['realname'])?$_GET['realname']:"";
    $hobby = isset($_GET['hobby'])?$_GET['hobby']:"";
    $phone = isset($_GET['phone'])?$_GET['phone']:"";
    $signature = isset($_GET['signature'])?$_GET['signature']:"";
    $imgname = isset($_GET['imgname'])?$_GET['imgname']:"";
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    if($imgname!=""){
        $sql = "UPDATE `userinfo` SET `img` = '".$imgname."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    if($addr!=""){
        $sql = "UPDATE `userinfo` SET `addr` = '".$addr."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    if($sex!=""){
        $sql = "UPDATE `userinfo` SET `sex` = '".$sex."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    if($name!=""){
        $sql = "UPDATE `userinfo` SET `name` = '".$name."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }else{
            
            return response::json(438,"更新资料成功");
        }
    }
    if($realname!=""){
        $sql = "UPDATE `userinfo` SET `realname` = '".$realname."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    if($hobby!=""){
        $sql = "UPDATE `userinfo` SET `hobby` = '".$hobby."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    if($phone!=""){
        $sql = "UPDATE `userinfo` SET `phone` = '".$phone."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    if($signature!=""){
        $sql = "UPDATE `userinfo` SET `signature` = '".$signature."' WHERE `userinfo`.`userid` = ".$userid;
        $result = mysqli_query($conn, $sql);
        if(!$result){
            return response::json(437,"更新资料失败");
        }
    }
    
    return response::json(438,"更新资料成功");
?>