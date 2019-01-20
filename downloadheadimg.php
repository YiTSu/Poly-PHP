<?php
require_once './json.php';
require_once './db.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:44;
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $sql = "select img from userinfo where userid=".$userid;
    $result = mysqli_query($conn, $sql);
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
            $array[] = $r;
    }
    foreach ($array as $s){
        if(is_array($s)){
            foreach ($s as $ss);
            $filename = $ss.".png";
        }else{
            $filename = $s.".png";
        }
    }
    $src = "./headimg/".$filename;
    $info = getimagesize($src);
    $type = image_type_to_extension($info[2],false);
    $fun = "imagecreatefrom{$type}";
    $image = $fun($src);
    $image_thumb = imagecreatetruecolor(50, 50);
    imagecopyresampled($image_thumb, $image, 0, 0, 0, 0, 50, 50, $info[0], $info[1]);
    imagedestroy($image);
    header("Content-type:".$info['mime']);
    $funs = "image{$type}";
    $funs($image_thumb);
    imagedestroy($image_thumb);
?>