yii2-tnt extension
===================
[![Total Downloads](https://poser.pugx.org/apaticmusic/yii2-tnt/downloads)](https://packagist.org/packages/apaticmusic/yii2-tnt)
[![License](https://poser.pugx.org/apaticmusic/yii2-tnt/license)](https://packagist.org/packages/apaticmusic/yii2-tnt)
                   
Tierion blockchain datastore component for YII2 Framework.

More info about Tierion: http://tierion.com

Requirements
------------
- Yii2
- PHP 5.4+
- Curl and php-curl installed


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```bash
composer require --prefer-dist apaticmusic/yii2-tnt "*"```


Usage
------------

```php
use apaticmusic\yii2\tnt;
...
$tierion = new Tierion($tierionApiKey, $tierionUsername, false);

$datastores = $tierion->getDatastores(); //Get all datastores
echo print_r($tierion->createRecord($datastores[0]['id'], ['thisisatestid'=>'This is a test data record']), true) . PHP_EOL; //Create data record in the first datastore

```
