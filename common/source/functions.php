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