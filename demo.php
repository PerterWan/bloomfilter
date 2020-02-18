<?php
require './vendor/autoload.php';

use Bloomfilter\BloomFilter;

$bloomFilter = new BloomFilter("MD5", ["1", "2", "3"], ["adsfjka;df", "23234", "sdfsdf"]);

$bloomFilter->getPlat(\Bloomfilter\config\Scenes::SCENES_REDIS, [
    'host' => '127.0.0.1', 'port' => 6379, 'password' => '', 'timeout' => 0, 'database' => 0, 'redisKey' => 'aaa'
])->setBloomFilter();

$res = $bloomFilter->getPlat(\Bloomfilter\config\Scenes::SCENES_REDIS, [
    'host' => '127.0.0.1', 'port' => 6379, 'password' => '', 'timeout' => 0, 'redisKey' => 'aaa', 'database' => 0
])->isExistsBloomFilter();

var_dump($res);