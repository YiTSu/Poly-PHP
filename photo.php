<?php
require_once './json.php';
require_once './db.php';
    $acid = isset($_GET['acid'])?$_GET['acid']:385;
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $sql = "select filename from activity where acid=".$acid;
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
            echo "s:".$s;
        }
    }
    $filename1 = '1480591458665.png';
    $src = "./photo/".$filename;
    $info = getimagesize($src);
    $type = image_type_to_extension($info[2],false);
    $fun = "imagecreatefrom{$type}";
    $image = $fun($src);
    $image_thumb = imagecreatetruecolor(300, 300);
    imagecopyresampled($image_thumb, $image, 0, 0, 0, 0, 300, 300, $info[0], $info[1]);
    imagedestroy($image);
    header("Content-type:".$info['mime']);
    $funs = "image{$type}";
    $funs($image_thumb);
    imagedestroy($image_thumb);
?>