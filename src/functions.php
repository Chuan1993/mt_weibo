<?php

/**
 * 把数据库查询二数组中的主键当下标
 * @param array $arr
 * @paream string $index 主键名
 * @return array
 * */
if (!function_exists('setPrimaryKeyToArrayKey')) {
    function setPrimaryKeyToArrayKey($arr, $index = "id")
    {
        $data = array();
        foreach ($arr as $v) {
            $data[$v[$index]] = $v;
        }
        return $data;
    }
}

/**
 * 简单加密算法   把md5扩充到64位
 * @param $password
 * @return string
 */
function setPassword($password)
{
    $tmp = md5($password);
    $pw_front = substr($tmp, 0, 16);
    $pw_behind = substr($tmp, -16);

    return md5($pw_front) . md5($pw_behind);
}

/**
 * 简单处理传输参数，防止被第三方恶意刷接口
 * 使用非对称加密比较合理  -- 时间关系
 * @param $params
 * @return string
 */
function setParams($params)
{
    $str_params = json_encode($params);
    return base64_encode($str_params);
}


/**
 * 获取IP方法，获取不到则返回255.255.255.255
 * @return string
 */
function getIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "255.255.255.255";
    }
    return $cip;
}
