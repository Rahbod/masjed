<?php use app\components\Setting;
use yii\helpers\Url;

$val = Setting::get('socialNetworks.facebook');
echo $val && !empty($val) ? '<a href="' . $val . '" target="_blank"><i class="icon icon-facebook"></i></a>' : '';

$val = Setting::get('socialNetworks.instagram');
echo $val && !empty($val) ? '<a href="' . $val . '" target="_blank"><i class="icon icon-instagram"></i></a>' : '';

$val = Setting::get('socialNetworks.twitter');
echo $val && !empty($val) ? '<a href="' . $val . '" target="_blank"><i class="icon icon-twitter"></i></a>' : '';