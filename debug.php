<?php 
require_once './json.php';
require_once './db.php';
//$_FILES：文件上传变量
    $data = $_FILES;
    $imgname = $_FILES['myfile']['name'];
    $tmp = $_FILES['myfile']['tmp_name'];
    $filepath = './photo/';
    if(move_uploaded_file($tmp,$filepath.$imgname.".png")){
        return response::json(441,"成功");
    }else{
        return response::json(442,"失败");
    }
?>