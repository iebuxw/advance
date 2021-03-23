<?php

defined('NOW_TIME') or define('NOW_TIME', time());
defined('DATE_TIME') or define('DATE_TIME', date(CommonConst::TIME_FORMAT));
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../'));// advance
defined('PAGE_SIZE') or define('PAGE_SIZE', 10);