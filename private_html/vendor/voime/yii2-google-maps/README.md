Google Maps Yii2 wrapper
========================
Google Maps Yii2 wrapper

Forked from [https://github.com/tugmaks/yii2-google-maps] and
  * added Infowindow support.
  * removed units parameters.
  * added mapOptions parameters. (styles)
  * added marker options. (icon)
  * added mapInput widget

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist voime/yii2-google-maps "*"
```

or add

```
"voime/yii2-google-maps": "*"
```

to the require section of your `composer.json` file.


MUST READ
-----
[Google Maps JavaScript API v3](https://developers.google.com/maps/documentation/javascript/reference)

BASIC USAGE
-----
Once the extension is installed, simply use it in your code by  :

```php
use voime\GoogleMaps\Map;

echo Map::widget([
    'zoom' => 16,
    'center' => 'Red Square',
    'width' => '700px',
    'height' => '400px',
    'mapType' => Map::MAP_TYPE_SATELLITE,
]);
```

There are two ways to set API KEY:

Add to application parameters.
```php
config/params.php

return [
.....
'GOOGLE_API_KEY' => 'VIza7yBgBzYEbKx09V566DhM8Ylc3NjWsJ0ps-2' // use your own api key
.....
]
```
Or pass it direct to widget.

```php
use voime\GoogleMaps\Map;

echo Map::widget([
    'apiKey'=> 'VIza7yBgBzYEbKx09V566DhM8Ylc3NjWsJ0ps-2',
    'zoom' => 3,
    'center' => [20, 40.555],
    'width' => '700px',
    'height' => '400px',
    'mapType' => Map::MAP_TYPE_HYBRID,
]);
```

Parameters

| Name  | Description |
| ------------- | ------------- |
| mapOptions  | array, not required, map object options |
| zoom  | integer, not required, default 16 |
| center  | array or string, required. If array lat and lng will be used, if string search query will be used. For example: ```php 'center'=>[23.091,100.412] ``` or ```php 'center'=>'London, UK' ``` |
| width | string, not required, default 600px. div wrapper width |
| height | string, not required, default 600px. div wrapper height |
| mapType | string, not required, default ROADMAP. Available types: MAP_TYPE_ROADMAP, MAP_TYPE_HYBRID, MAP_TYPE_SATELLITE, MAP_TYPE_TERRAIN |
| markers | array, not required. Markers that will be added to map|

MARKERS
-----

One or more marker can be added to map. Just pass marker array to widget config

```php
use voime\GoogleMaps\Map;

echo Map::widget([
    'mapOptions' => ['styles' => file_get_contents(Yii::getAlias('@webroot/res/map-styles.json'))],
    'zoom' => 5,
    'center' => [45, 45],
    'markers' => [
        ['position' => 'Tartu', 'title' => 'marker title', 'content' => 'InfoWindow content', 'options' => ["icon" => "'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'"]],
        ['position' => [56,27]],
    ]
]);
````

MARKER OPTIONS
-----

The following options are allowed:

| Name  | Description |
| ------------- | ------------- |
| position  | string or array, required. If array lat and lng will be used, if string search query will be used. |
| title  | string, not required. Rollover text |
| content  | string, not required. Infowindow text |
| options  | array, not required. Marker options |

MARKERS FIT BOUNDS
-----

Sometimes you need to show all markers on map, but do not know initial map center and zoom. In this case use widget like this

```php
use voime\GoogleMaps\Map;

echo Map::widget([
    'width' => '50%',
    'height' => '600px',
    'mapType' => Map::MAP_TYPE_HYBRID,
    'markers' => [
        ['position' => 'Belgrad'],
        ['position' => 'Zagreb'],
        ['position' => 'Skopje'],
        ['position' => 'Podgorica'],
        ['position' => 'Sarajevo'],
    ],
    'markerFitBounds'=>true
]);
```

MAPINPUT
-----

MapInput widget example. This need the following inputs
  * address-input for address seach on map
  * lat-input for latitude
  * lng-input for longitude
  * country-input for country name [optional]


```php
use voime\GoogleMaps\MapInput;

<?= $form->field($model, 'address')->textInput(['id'=>'address-input']) ?>

<?php
echo MapInput::widget([
    'height' => '400px',
    'zoom' => Yii::$app->params['map_zoom_one'],
    'countryInput' => 'country-input',
    'mapOptions' => [
        'styles' => file_get_contents(Yii::getAlias('@webroot/res/map-styles.json')),
        'maxZoom' => '15',
    ],
    'markerOptions' => ['icon'=>"'" . Yii::getAlias('@web/res/img/marker.png') . "'"],
]);
?>
<?=$form->field($model, 'latitude')->hiddenInput(['id'=>'lat-input'])->label(false) ?>
<?=$form->field($model, 'longitude')->hiddenInput(['id'=>'lng-input'])->label(false) ?>
<?=$form->field($model, 'country')->hiddenInput(['id'=>'country-input'])->label(false) ?>
````
