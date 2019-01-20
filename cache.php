<?php
/*$this是目录，$key是文件名
 * */
class File{
    private $dir;
    
    const EXT='.php';/*后缀*/
    public function construct(){
        $this->dir=dirname(__FILE__).'/cache/';
    }
    public function cacheData($key,$value='',$cacheTime = 0){
        $filename = $this->dir.$key.self::EXT;
        if(is_null($value)){//*如果值是空的话删除缓存文件
            return unlink($filename);
        }
        if($value!=''){/*value写入缓存*/
           
            $dir1=dirname($filename);
            if(!is_dir($dir1)){
                mkdir($dir1,0777);
            }
            $cacheTime = sprintf("%011d",$cacheTime);//设置的缓存时间
            
            return file_put_contents($filename,$cacheTime.json_encode($value));
        }
        
        if(!is_file($filename)){
            return FALSE;
        }
        $contents = file_get_contents($filename);//获取缓存的内容
        $cacheTime = (int)substr($contents,0,11);//获取缓存时间
        $value =substr($contents,11);//获取缓存数据
        if($cacheTime!=0&&($cacheTime + filemtime($filename))<time()){
            unlink($filename);
            return FALSE;
        }
        return json_decode($value,TRUE);
            
        
    }
}
?>