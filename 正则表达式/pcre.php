<?php

class Pcre
{
    //校验手机号
    public function check_mobile($mobile = '')
    {
        // 非数字直接false
        if (!is_numeric($mobile)) {
            return false;
        }
        $pattern = '/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,3,7,8]{1}\d{8}$|^18[\d]{9}$|^19[9]{1}\d{8}$/';
        $res = preg_match($pattern, $mobile) ? true : false;
        return $res;
    }
    //校验邮箱
    public function check_email($email = '')
    {
        $pattern = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
        $res = preg_match($pattern, $email) ? true : false;
        return $res;
    }
}

$preg = new Pcre;
echo $preg->check_email('wang_chunfei@123.com');