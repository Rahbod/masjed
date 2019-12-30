<?php

use yii\helpers\Html;


/**
 * @param $vars
 */
function dd($vars)
{
    $args = func_get_args();
    echo Html::beginTag('pre', ['class' => 'xdebug-var-dump', 'dir' => 'ltr']);
    foreach ($args as $arg) {
        var_dump($arg);
        echo "\n";
    }
    echo Html::endTag('pre');
    exit();
}

/**
 * @param $url
 * @return string
 */
function encodeUrl($url)
{
    return str_replace(array(' ', '/', '\\'), '-', $url);
}