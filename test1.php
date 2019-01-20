<?php
require_once './json.php';
require_once './db.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/request/OpenimUsersDeleteRequest.php';
require_once './aliSDK/top/request/OpenimTribeQuitRequest.php';
require_once './aliSDK/top/domain/Userinfos.php';
require_once './aliSDK/top/domain/OpenImUser.php';
return response::json(424,"数据库连接失败");

?>