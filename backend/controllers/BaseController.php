<?php

namespace backend\controllers;

use backend\models\SimpleModel;
use Yii;
use yii\web\Controller;

/**
 * BaseController implements the CRUD actions for Post model.
 */
class BaseController extends Controller
{
    public $resp = [];

    // 获取参数
    public function getParam($key, $type = 'string', $default = '')
    {
        $value = isset($_REQUEST[$key]) ? htmlspecialchars(addslashes(trim($_REQUEST[$key])), ENT_QUOTES) : $default;

        switch ($type)
        {
            case 'string':
                return strval($value);
                break;
            case 'int':
                return intval($value);
                break;
            case 'float':
                return floatval($value);
                break;
            default:
                return $value;
                break;
        }
    }

    function renderJson($errCode = 'SYS_SUCCESS', $msgFree = '', $retParams = [])
    {
        $base_msg = \backend\source\ErrorCode::$msg;
        $code = isset($base_msg[$errCode]['code']) ? $base_msg[$errCode]['code'] : -1;
        $msg = empty($base_msg[$errCode]['msg']) ? "未配置错误码{$errCode}" : $base_msg[$errCode]['msg'];

        if (!empty($msg) && !empty($retParams) && is_array($retParams)) {
            foreach ($retParams as $key => $retParam) {
                $msg = str_replace('{' . $key . '}', $retParam, $msg);
            }
        }

        $msg = !empty($msgFree)? $msgFree : $msg;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $this->resp,
        ];
    }

    function renderExeJson($data)
    {
        if ($data instanceof \Exception) {
            isset($data->data) && $data->data && $show_data = $data->data;
            $data = array(
                'code'   => $data->getCode() ? $data->getCode() : '-1',
                'msg'   => $data->getMessage(),// 数据库的后续优化
            );
        } else {
            list($code, $msg) = \backend\source\ErrorCode::getMsg($data['code'] ?: 'SUCCESS', $data['freemsg'] ?: '', $data['params'] ?: []);
            $data = array(
                'code'   => $code,
                'msg'   => $msg,
                'data'   => $data ?: [],
            );
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $data;
    }

    // 验证1
    public static function verifyParam($array_param, $rules, $is_throw_exception = true, $errno = null)
    {
        $check = new SimpleModel();

        foreach ($rules as $rule) {
            $check->$rule[0] = $array_param[$rule[0]];
        }

        $check->setRules($rules);

        $rt = $check->validate();
        if ($is_throw_exception) {
            if (!$rt) {
                foreach ($check->getErrors() as $key => $error) {
                    foreach ($error as $key2 => $value) {
                        \BizResult::isFalse(false, 'ERROR_UNKNOWN', $value);
                    }
                }
            }
            $errno = $errno === null ? 'ERROR_UNKNOWN' : $errno;
            \BizResult::isFalse($rt, $errno);
        }

        return $rt;
    }

    // 验证2
    public function verifyParam2($array_param, $rules, $is_throw_exception = true, $errno = null)
    {
        // 添加验证规则
        $check = new SimpleModel();
        $check->setRules($rules);
        $check->load($array_param, '');
        $check->validate();

        $rt = $check->validate();
        if ($is_throw_exception) {
            if (!$rt) {
                foreach ($check->getErrors() as $key => $error) {
                    foreach ($error as $key2 => $value) {
                        \BizResult::isFalse(false, 'ERROR_UNKNOWN', $value);
                    }
                }
            }
            $errno = $errno === null ? 'ERROR_UNKNOWN' : $errno;
            \BizResult::isFalse($rt, $errno);
        }

        return $rt;
    }
}
