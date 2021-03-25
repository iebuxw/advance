<?php

function dd($v)
{
    if (empty($v)) {
        var_dump($v);
    } else {
        echo '<pre>';
        print_r($v);
    }

    exit();
}

function getShortContent($content, $len = 50)
{
    $str     = strip_tags($content);
    $tmp_len = mb_strlen($str);
    $str     = mb_substr($str, 0, $len, 'utf-8');

    return $str . ($tmp_len > $len ? '...' : '');
}

// 删除图片
function delFile($file)
{
    $path = Yii::getAlias('@frontend') . '/web';
    @unlink($path . $file);
}

/**
 * description: 交换数组中两个元素的位置，元素包括key和value，具体用法见下面的例子
 * $arr = array (11 => 'a', 22 => 'b', 33 => 'c', 44 => 'd' );
 * $res = array_exchange ( $arr, 11, 33 );
 * @param $arr
 * @param $arg1
 * @param $arg2
 * @return mixed
 */
function array_exchange($arr, $arg1, $arg2)
{
    $r      = range(0, count($arr) - 1);
    $res    = $res_bak = array_combine($r, array_keys($arr));
    $change = array($arg1, $arg2);
    list ($res[array_search($change [0], $res_bak)], $res[array_search($change [1], $res_bak)]) = array($change [1], $change [0]);
    foreach ($res as $v) {
        $array [$v] = $arr [$v];
    }
    return $array;
}

//转换ip格式ip=1.1.1.1或10.10.10.1/24或1.1.1.1-1.1.1.2转化为{“start":"10.10.12.12","end":"10.10.12.14"}
function IpsRangeTransfer($ips)
{
    if (empty($ips)) {
        return array('count' => 0, 'ip_vals' => array());
    }
    if (!is_array($ips)) {
        $ips = explode(',', $ips);
    }
    $count   = 0;
    $ip_vals = array();
    foreach ($ips as $ip) {
        $val = array();
        if (strpos($ip, "/") > 0) {
            list($ip_str, $mark_len) = explode("/", $ip);
            $ip           = ip2long($ip_str);
            $mark         = 0xFFFFFFFF << (32 - $mark_len) & 0xFFFFFFFF;
            $start        = $ip & $mark;
            $end          = $ip | (~$mark) & 0xFFFFFFFF;
            $val['start'] = long2ip($start);
            $val['end']   = long2ip($end);
            $count        += abs($end - $start) + 1;
        } elseif (strpos($ip, "-") > 0) {
            list($val['start'], $val['end']) = explode("-", $ip);
            $start_ip_s = explode('.', $val['start']);
            $ip_1       = '';
            foreach ($start_ip_s as $vv) {
                $ip_1 .= sprintf("%08d", decbin($vv));
            }
            $ip_start_count = bindec($ip_1);
            $end_ip_s       = explode('.', $val['end']);
            $ip_2           = '';
            foreach ($end_ip_s as $vv) {
                $ip_2 .= sprintf("%08d", decbin($vv));
            }
            $ip_end_count = bindec($ip_2);
            $count        += ($ip_end_count - $ip_start_count) + 1;

//                $count += abs(ip2long($val['end']) - ip2long($val['start'])) + 1;
        } else {
            $val['start'] = $ip;
            $val['end']   = $ip;
            $count++;
        }
        $ip_vals[] = $val;
    }

    return array('count' => $count, 'val_policy' => $ip_vals);
}

// array_get($a, 'a.b');
function array_get(array $array, $key, $default = null)
{
    if (is_null($key)) {
        return $array;
    }

    if (isset($array[$key])) {
        return $array[$key];
    }

    foreach (explode('.', $key) as $segment) {
        if (!is_array($array) || !array_key_exists($segment, $array)) {
            return $default;
        }

        $array = $array[$segment];
    }

    return $array;
}

// 获取字符串参数
function getParamStr(array $params)
{
    $tmp = [];
    foreach ($params as $key => $param) {
        $tmp[] = $key . '=' . $param;
    }

    return implode('&', $tmp);
}