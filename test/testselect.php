<?php
require_once 'D:/wamp/wamp64/www/Poly/json.php';
require_once 'D:/wamp/wamp64/www/Poly/db.php';
    if(!is_numeric($page)||!is_numeric($pageSize)){
        return response::json(401,'数据不合法');
    }
    try {//链接数据库
        $connect = DB::getinstance()->connect();
    }catch (Exception $e){
        return response::json(402,"数据库连接失败");
    }
    












?>