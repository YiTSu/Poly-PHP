<?php
class response{
    public static function json($code,$msg='',$data=array()){
        if(!is_numeric($code)){
            return '';
        }

        $result = array(
            'code'=>$code,
            'msg' =>$msg,
            'data'=>$data);
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit();
    }
}
?>