<?php
function QiniuLab_PrintUploadResult($ret, $err)
{
    if ($err) {
        print("Err: " . $err->Err . "\r\n");
        print("Reqid: " . $err->Reqid . "\r\n");
        print("Details: " . $err->Details . "\r\n");
        print("Code: " . $err->Code . "\r\n");
    } else {
        foreach ($ret as $key => $val) {
            print($key . ": " . $val . "\r\n");
        }
    }
    print("\r\n");
}