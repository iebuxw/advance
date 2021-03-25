<?php


namespace common\service;


use common\models\Book;
use common\models\User;

class Utils
{
    // 用户id => name
    public static function getUserNameMap()
    {
        return User::find()->select('name')->orderBy('id')->indexBy('id')->column();
    }

    // 用户id => name
    public static function getBookNameMap()
    {
        return Book::find()->select('name')->orderBy('id')->indexBy('id')->column();
    }
}