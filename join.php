<?php
require_once './json.php';
require_once './db.php';
require_once './aliSDK/top/TopClient.php';
require_once './aliSDK/top/request/OpenimTribeJoinRequest.php';
require_once './aliSDK/top/request/OpenimTribeSetmembernickRequest.php';
require_once './aliSDK/top/domain/OpenImUser.php';
require_once './aliSDK/top/domain/User.php';
    $userid = isset($_GET['userid'])?$_GET['userid']:43;
    $acid = isset($_GET['acid'])?$_GET['acid']:385;
    $sql = "select * from joinin where userid=".$userid." and acid=".$acid;
    try {
        $conn = DB::getinstance()->connect();
    } catch (Exception $e) {
        return response::json(402,"数据库连接失败");
    }
    $r = mysqli_query($conn, $sql);
    $array = array();
    while($re = mysqli_fetch_assoc($r)){
        $array = $re;
    }
    if($array==NULL){
        $sql = "INSERT INTO `joinin` (`userid`, `acid`, `main`) VALUES (".$userid.",".$acid.", 0)";
        $query = "select people,realpeople from activity where acid=".$acid;
        
        try {
            $conn = DB::getinstance()->connect();
        } catch (Exception $e) {
            return response::json(402,"数据库连接失败");
        }
        $r = mysqli_query($conn, $query);
        $array = array();
        while($re = mysqli_fetch_assoc($r)){
            $array = $re;
        }
        $r = 0;
        foreach ($array as $a){
            if($r == 0){
                $b = $a;
                $r = $r+1;
            }else{
                $c = $a;
            }
        }
        if($b<=$c){
            return response::json(420,"人数已满");
        }else{
            $c = $c+1;
            $result = mysqli_query($conn, $sql);
            $insert = "UPDATE `activity` SET `realpeople` = ".$c." WHERE `activity`.`acid` =".$acid;
            $result1 = mysqli_query($conn, $insert);
            if((!$result)||(!$result1)){
                return response::json(421,"参加活动失败");
            }else{
                //找uid
                $sql = "SELECT username FROM userinfo WHERE userid = $userid";
                $result = mysqli_query($conn, $sql);
                $array = array();
                while($r = mysqli_fetch_assoc($result)){
                    $array[] = $r;
                }
                foreach ($array as $a){
                    foreach ($a as $aa);
                }

                //找群id
                $sql = "SELECT tribe_id FROM activity WHERE acid = $acid";
                $result = mysqli_query($conn, $sql);
                $array = array();
                while($r = mysqli_fetch_assoc($result)){
                    $array[] = $r;
                }
                foreach ($array as $b){
                    foreach ($b as $tribeid);
                }

                $c = new TopClient;
                $c->appkey = '23666480';
                $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
                $req = new OpenimTribeJoinRequest;
                $user = new OpenImUser;
                $user->uid=$aa;
                $user->taobao_account="false";
                $user->app_key="23666480";
                $req->setUser(json_encode($user));
                $req->setTribeId("$tribeid");
                $resp = $c->execute($req);
                
                $c = new TopClient;
                $c->appkey = '23666480';
                $c->secretKey = '97d79da8874aecc1a5a05a099a0e1904';
                $req = new OpenimTribeSetmembernickRequest;
                $user = new User;
                $user->app_key="23666480";
                $user->taobao_account="false";
                $user->uid=$aa;
                $req->setUser(json_encode($user));
                $req->setTribeId("$tribeid");
                $member = new User;
                $member->app_key="23666480";
                $member->taobao_account="false";
                $member->uid=$aa;
                
                $sql = "SELECT name FROM userinfo WHERE userid = $userid";
                $result = mysqli_query($conn, $sql);
                $array = array();
                while($r = mysqli_fetch_assoc($result)){
                    $array[] = $r;
                }
                if(!$array){
                    $req->setNick("$aa");
                }else{
                    foreach ($array as $a){
                        foreach ($a as $nick);
                    }
                    $req->setMember(json_encode($member));
                    $req->setNick("$nick");
                }
                $resp = $c->execute($req);
                return response::json(422,"参加活动成功");
            }
        }
    }else{
        return response::json(433,"你已经加入该活动");
    }
    
?>