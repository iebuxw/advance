<?php

namespace common\service;

use phpDocumentor\Reflection\DocBlock\Tags\See;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

class HcUploadFile
{
    public static $allow_format = ['png', 'jpg', 'jpeg', 'gif'];
    public static $max_size = 52428800;// 50M

    /***
     * @param $name
     * @return array|string 返回对应于指定的文件输入名称上传的文件的数组。
     */
    public static function uploadFiles($name)
    {
        $uploadedFile = UploadedFile::getInstanceByName($name);

        if ($uploadedFile === null || $uploadedFile->hasError) {
            return [false, '文件不存在'];
        }

        //创建时间
        $ym = date("Ym");
        //存储到本地的路径
        $save_path = \Yii::getAlias('@frontend') . '/web/uploads/' . $ym . '/';

        //file_exists() 函数检查文件或目录是否存在
        //mkdir() 函数创建目录

        if (!file_exists($save_path)) {
            mkdir($save_path);
        }

        //图片格式
        $file_ext = $uploadedFile->getExtension();

        //判断后缀名是否正确
        if(!in_array($file_ext, self::$allow_format)){
            return [false, "上传文件是不允许上传的后缀名"];
        }

        //判断是否满足这个函数的最大上传值
        if($uploadedFile->size > self::$max_size){
            return [false, "上传文件过大"];
        }

        //新文件名
        $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
        $new_full_name = '/uploads/' . $ym . '/' . $new_file_name;
        //图片信息
        $uploadedFile->saveAs($save_path . $new_file_name);

        return [true, $new_full_name];
    }
}