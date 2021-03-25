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
    $str = strip_tags($content);
    $tmp_len = mb_strlen($str);
    $str = mb_substr($str, 0, $len, 'utf-8');

    return $str . ($tmp_len > $len  ? '...' : '');
}

// 删除图片
function delFile($file)
{
    $path = Yii::getAlias('@frontend') . '/web';
    @unlink($path . $file);
}