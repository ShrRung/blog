<?php
$APP_CALLBACK_ROOT = "http://m.yoyoxing.com/yoyoxing/Admin/admin/test";

$Qiniu_AccessKey	= 'VdujwxmrvKW0nSpE8Br6UXxTokssI-9QBNdrcJRq';
$Qiniu_SecretKey	= '04jCKwccr9hC5Aw7RtOy5QWD22-sf-gcU3p8LlV-';
$Qiniu_Public_Bucket = "source";
$Qiniu_Private_Bucket = "<Private Bucket>";

if (empty($Qiniu_AccessKey)) {
    exit("<p class='alert alert-danger'>Error: Please set the access key</p>");
}
if (empty($Qiniu_SecretKey)) {
    exit("<p class='alert alert-danger'>Error: Please set the secret key</p>");
}
if (empty($Qiniu_Public_Bucket)) {
    exit("<p class='alert alert-danger'>Error: Please set a name for the public bucket</p>");
}
if (empty($Qiniu_Private_Bucket)) {
    exit("<p class='alert alert-danger'>Error: Please set a name for the private bucket</p>");
}
?>