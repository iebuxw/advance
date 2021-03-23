<?php

class CommonConst
{
    //是否启用
    const ACTIVE      = 1;
    const INACTIVE    = 0;
    const TIME_FORMAT = 'Y-m-d H:i:s';

    //数据库对应列名
    const ID          = 'id';
    const TYPE        = 'type';
    const PID         = 'pid';
    const STATUS      = 'status';
    const CONDITION   = 'condition';
    const VALUE       = 'value';
    const START       = 'start';
    const END         = 'end';
    const KEY         = 'key';
    const DATA        = 'data';
    const IP          = 'ip';
    const NAME        = 'name';
    const VERSION     = 'version';
    const ADD_TIME    = 'add_time';
    const UPDATE_TIME = 'update_time';
    const START_DAY   = 'start_day';
    const END_DAY     = 'end_day';
    const TITLE       = 'title';
    const CONTENT     = 'content';
    const AGE         = 'age';
    const USERNAME    = 'username';

    // 字段翻译，供验证使用
    public static $fieldName = [
        self::ID       => 'ID',
        self::CONTENT  => '内容',
        self::STATUS   => '状态',
        self::AGE      => '年龄',
        self::USERNAME => '用户名',
    ];
}