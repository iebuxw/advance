<?php

class BizResult
{
    static public function isFalse($result, $errno, $freemsg = '', $msg_param = null)
    {
        if($result === false)
        {
            list($code, $msg) = \backend\source\ErrorCode::getMsg($errno, $freemsg, $msg_param);
            throw new BizException($msg, $code);
        }
        return $result;
    }
}

class BizException extends Exception
{
    public function __construct($errmsg, $errno)
    {
        parent::__construct($errmsg, $errno);
    }
}