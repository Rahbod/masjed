<?php
require_once 'my_helper.php';

use yii\helpers\Html;

/**
 * @return \yii\console\Application|\yii\web\Application
 */
function app()
{
    return Yii::$app;
}

/**
 * @param $category
 * @param $key
 * @param array $params
 * @param null $language
 * @return string
 */
function trans($category, $key, $params = [], $language = null)
{
    return Yii::t($category, $key, $params, $language);
}

/**
 * @return \yii\console\Request|\yii\web\Request
 */
function request()
{
    return Yii::$app->request;
}

/**
 * @return \yii\console\Response|\yii\web\Response
 */
function response()
{
    return Yii::$app->response;
}

/**
 * @return array|string|\yii\base\Theme
 */
function theme()
{
    return Yii::$app->view->theme;
}

/**
 * @param $alias
 * @param bool $throwException
 * @return bool|string
 */
function alias($alias, $throwException = true)
{
    return Yii::getAlias($alias, $throwException);
}