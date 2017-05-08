<?php
/**
 * Created by PhpStorm.
 * User: zth
 * Date: 15/4/9
 * Time: 下午5:24
 */
class PictureHandle
{
    function upload_to_qiniu($path)
    {
        require_once("./Public/qiniu/qiniu_config.php");
        require_once("./Public/qiniu/io.php");
        require_once("./Public/qiniu/rs.php");
        require_once("./Public/qiniu/print_result.php");
        $Qiniu_AccessKey = 'DuqjJwtgQ1lOuya_ON6CtpODRJmDgKmriOiGewCX';
        $Qiniu_SecretKey = 'gQxIYAWtyPrT_ELUARUQf7dMSSTkc4H1eltKyamD';
        $Qiniu_Public_Bucket = "social";
        $putPolicy = new \Qiniu_RS_PutPolicy($Qiniu_Public_Bucket);
        $auth = new \Qiniu_Mac($Qiniu_AccessKey, $Qiniu_SecretKey);
        $upToken = $putPolicy->Token($auth);
        $localFile = '.' . $path;
        $key = substr($localFile, 2);
        $putExtra = new \Qiniu_PutExtra();
        $putExtra->CheckCrc = TRUE;
        $putExtra->Crc32 = crc32(file_get_contents($localFile));
        list($ret, $err) = Qiniu_PutFile($upToken, $key, $localFile, $putExtra);
        if ($err) {
            return false;
        } else {
            return true;
        }
    }

    function get_uptoken($bucket)
    {
        require_once("./Public/qiniu/qiniu_config.php");
        require_once("./Public/qiniu/io.php");
        require_once("./Public/qiniu/rs.php");
        require_once("./Public/qiniu/print_result.php");
        $Qiniu_AccessKey = 'DuqjJwtgQ1lOuya_ON6CtpODRJmDgKmriOiGewCX';
        $Qiniu_SecretKey = 'gQxIYAWtyPrT_ELUARUQf7dMSSTkc4H1eltKyamD';
//        $Qiniu_Public_Bucket = "social";
        $Qiniu_Public_Bucket = $bucket;
        $putPolicy = new \Qiniu_RS_PutPolicy($Qiniu_Public_Bucket);
        $auth = new \Qiniu_Mac($Qiniu_AccessKey, $Qiniu_SecretKey);
        $upToken = $putPolicy->Token($auth);
        return $upToken;
    }
}