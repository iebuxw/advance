<?php

namespace backend\source;

class ErrorCode
{
    public static $msg = [
        // 1x 用户错误
        'LOGIN_OUT' => ['code' => 100000, 'msg' => '用户未登录'],

        // 2x 成功
        'SUCCESS' => ['code' => 200, 'msg' => '成功'],

        // 4x 参数错误
        'ERROR_PARAM' => ['code' => 400000, 'msg' => '缺少必要的参数'],

        // 5x 服务器错误
        'SYS_ERROR' => ['code' => 500000, 'msg' => '系统错误'],
        'DB_ERROR' => ['code' => 500001, 'msg' => '数据库错误:{aa}'],
        'ERROR_UNKNOWN' => ['code' => 500002, 'msg' => '未知错误'],
    ];

    /**
     * @param $err_code
     * @param $msgFree
     * @param $retParams
     * @return array
     */
    public static function getMsg($err_code, $msgFree, $retParams)
    {
        $code = isset(self::$msg[$err_code]['code']) ? self::$msg[$err_code]['code'] : -1;
        $msg = empty(self::$msg[$err_code]['msg']) ? "未配置错误码：{$err_code}" : self::$msg[$err_code]['msg'];

        if (!empty($msg) && !empty($retParams) && is_array($retParams)) {
            foreach ($retParams as $key => $retParam) {
                $msg = str_replace('{' . $key . '}', $retParam, $msg);
            }
        }

        $msg = !empty($msgFree)? $msgFree : $msg;

        return [$code, $msg];
    }
}
