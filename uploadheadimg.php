<?php 
require_once './json.php';
require_once './db.php';
require_once './aliSDK/top/request/OpenimUsersAddRequest.php';
require_once './aliSDK/top/request/OpenimUsersUpdateRequest.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/domain/Userinfos.php';
//$_FILES：文件上传变量
    $userid = isset($_GET['userid'])?$_GET['userid']:44;
    $username = isset($_GET['username'])?$_GET['user']:"15002989348";
    $passwd = isset($_GET['passwd'])?$_GET['passwd']:"-3110-365773-7089-85-6686-3287-1415-12062";
    $data = $_FILES;
    $imgname = $_FILES['myfile']['name'];
    $tmp = $_FILES['myfile']['tmp_name'];
    $filepath = 'headimg/';
    if(move_uploaded_file($tmp,$filepath.$imgname.".png")){
        $c = new TopClient;
        $c->appkey = '23666480';
            $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
        $req = new OpenimUsersUpdateRequest;
        $userinfos = new Userinfos;
        $userinfos->icon_url="http://120.25.120.123/Poly/downloadheadimg.php?userid=$userid";
        $userinfos->userid=$username;
        $userinfos->password=$passwd;
        $req->setUserinfos(json_encode($userinfos));
        $resp = $c->execute($req);
        return response::json(441,"成功");
    }else{
        return response::json(442,"失败");
    }
?>